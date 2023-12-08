<?php

namespace Slimmvc\Http;

use DateTimeImmutable;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;

class TokenAuthentication {
    const ACCESS_TOKEN = "ACCESS_TOKEN";
    const REFRESH_TOKEN = "REFRESH_TOKEN";
    const DEFAULT_VALID_DURATION = 86400;
    const ENCRYPTION_ALGORITHMS = "HS512";
    const ISSUER = "iss";
    const ISSUED_AT = "iat";
    const EXPIRED_AT = "exp";
    const USER_ID = "userId";
    const AUTHORITY = "authority";
    const TYPE = "type";


    private string $type;
    private mixed $userId;
    private mixed $authority;
    private int $createdTime;
    private int $validDuration;


    /*public function createTokenFor(mixed $userId, mixed $authority = null, $validDuration = null): string {
        $domainName = $_ENV['DOMAIN_NAME'];
        $secretKey = $_ENV['AUTH_SECRET_KEY'];

        $date = new DateTimeImmutable();

        $this->createdTime = $date->getTimestamp();
        $this->validDuration = is_null($validDuration) ? self::DEFAULT_VALID_DURATION : $validDuration;
        $this->userId = $userId;
        $this->authority = $authority;

        $tokenData = [
            self::ISSUER => $domainName,
            self::ISSUED_AT => $this->createdTime,
            self::EXPIRED_AT => $this->createdTime + $this->validDuration,
            self::USER_ID => $this->userId,
            self::AUTHORITY => $this->authority
        ];

        return JWT::encode($tokenData, $secretKey, self::ENCRYPTION_ALGORITHMS);
    }*/

    static function createTokenFor(mixed $userId, string $type, mixed $authority = null, $validDuration = null): string {
        $domainName = $_ENV['DOMAIN_NAME'];
        $secretKey = $_ENV['AUTH_SECRET_KEY'];

        $date = new DateTimeImmutable();

        $createdTime = $date->getTimestamp();
        $validDuration = is_null($validDuration) ? self::DEFAULT_VALID_DURATION : $validDuration;

        $tokenData = [
            self::ISSUER => $domainName,
            self::ISSUED_AT => $createdTime,
            self::EXPIRED_AT => $createdTime + $validDuration,
            self::USER_ID => $userId,
            self::AUTHORITY => $authority,
            self::TYPE => $type
        ];

        return JWT::encode($tokenData, $secretKey, self::ENCRYPTION_ALGORITHMS);
    }


    public function authenticate(?string $token, ?string $type): bool {
        if (! isset($token) || ! isset($type)) {
            return false;
        }

        $domainName = $_ENV['DOMAIN_NAME'];
        $secretKey = $_ENV['AUTH_SECRET_KEY'];

        //$decryptedData = JWT::decode($token, new Key($secretKey, self::ENCRYPTION_ALGORITHMS));
        $decryptedData = null;
        try {
            $decryptedData = JWT::decode($token, new Key($secretKey, self::ENCRYPTION_ALGORITHMS));
        }
        catch (SignatureInvalidException $e) {
            return false;
        }

        $now = new DateTimeImmutable();

        if (
            $decryptedData->iss !== $domainName ||
            $decryptedData->iat > $now->getTimestamp() ||
            $decryptedData->exp < $now->getTimestamp() ||
            $decryptedData->type !== $type
        ) {
            return false;
        }

        $this->createdTime = $decryptedData->iat;
        $this->validDuration = $decryptedData->exp - $decryptedData->iat;
        $this->userId = $decryptedData->userId;
        $this->authority = $decryptedData->authority;

        return true;
    }

    public function getUserId(): mixed
    {
        return $this->userId;
    }

    public function getAuthority(): mixed
    {
        return $this->authority;
    }

    public function getCreatedTime(): int
    {
        return $this->createdTime;
    }

    public function getValidDuration(): int
    {
        return $this->validDuration;
    }

    public function getExpiredTime(): int {
        return $this->createdTime + $this->validDuration;
    }

    public function getToken() {
        $domainName = $_ENV['DOMAIN_NAME'];
        $secretKey = $_ENV['AUTH_SECRET_KEY'];

        $tokenData = [
            self::ISSUER => $domainName,
            self::ISSUED_AT => $this->createdTime,
            self::EXPIRED_AT => $this->createdTime + $this->validDuration,
            self::USER_ID => $this->userId,
            self::AUTHORITY => $this->authority
        ];
        return JWT::encode($tokenData, $secretKey, self::ENCRYPTION_ALGORITHMS);
    }

    public function isEnoughAuthorityFor(mixed $routeAuthority): bool {
        if (is_int($routeAuthority) && is_int($this->authority)) {
            return $this->authority <= $routeAuthority;
        }

        return false;
    }
}




















