<?php

namespace App\Controller\Common\Auth;

use App\Model\AuthInfo;
use App\Model\User;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;

class AuthController {
    /*const HARD_DURATION = 86400;
    const SOFT_DURATION = 7200;*/

    const REFRESH_TOKEN_COOKIE_PATH = "/api/v1/common/auth";
    const REFRESH_TOKEN_COOKIE_NAME = "__jwtc_refresh_token";

    public function login(HttpRequest $request, HttpResponse $response): HttpResponse {

        $HARD_DURATION = intval($_ENV['REFRESH_TOKEN_EXPIRATION']);
        $SOFT_DURATION = intval($_ENV['ACCESS_TOKEN_EXPIRATION']);

        $authHeaderValue = $request->getBasicAuthorizationHeaderValue();
        $credentials = explode(":", base64_decode($authHeaderValue));
        $username = $credentials[0];
        $password = $credentials[1];

        $authInfo = AuthInfo::where("username", $username)->first();
        $authUser = $this->authenticate($username, $password, $authInfo);

        if (! isset($authUser)) {
            $response->setStatus(401);
            $response->setType(HttpResponse::JSON);
            $response->setContent([
                "authorized" => "false"
            ]);
            return $response;
        }

        $refreshToken = TokenAuthentication::createTokenFor(
            $authUser->id, TokenAuthentication::REFRESH_TOKEN,
            $authInfo->authority, $HARD_DURATION);

        $accessToken = TokenAuthentication::createTokenFor(
            $authUser->id, TokenAuthentication::ACCESS_TOKEN,
            $authInfo->authority, $SOFT_DURATION);

        $response->setType(HttpResponse::JSON);

        // set refresh token as cookie with httpOnly
        $response->setCookie(self::REFRESH_TOKEN_COOKIE_NAME, $refreshToken, [
            "expires" => time() + $HARD_DURATION,
            "path" => self::REFRESH_TOKEN_COOKIE_PATH,
            "secure" => false,
            "httponly" => true,
            "samesite" => "strict"
        ]);

        $response->setContent([
            "authorized" => "true",
            "userId" => $authUser->id,
            "authority" => $authInfo->authority,
            "accessToken" => $accessToken,
            "hardDuration" => $HARD_DURATION,
            "softDuration" => $SOFT_DURATION
        ]);

        return $response;
    }


    public function logout(HttpRequest $request, HttpResponse $response) {
        $response->setCookie(self::REFRESH_TOKEN_COOKIE_NAME, "", [
            "expires" => time() - 3600,
            "path" => self::REFRESH_TOKEN_COOKIE_PATH,
            "secure" => false,
            "httponly" => true,
            "samesite" => "strict"
        ]);
        $response->setStatus(200);
        $response->setType(HttpResponse::JSON);
        $response->setContent([
            "message" => "logout successfully"
        ]);
        return $response;
    }


    public function getSessionDuration(HttpRequest $request, HttpResponse $response,
                                       TokenAuthentication $auth): HttpResponse {
        $refreshToken = $request->getCookie(self::REFRESH_TOKEN_COOKIE_NAME);

        if (! isset($refreshToken) || ! $auth->authenticate($refreshToken, TokenAuthentication::REFRESH_TOKEN)) {
            $response->setStatus(200);
            $response->setType(HttpResponse::JSON);
            $response->setContent([
                "validDuration" => 0
            ]);
            return $response;
        }

        $duration = $auth->getCreatedTime() + $auth->getValidDuration() - time();

        $response->setStatus(200);
        $response->setType(HttpResponse::JSON);
        $response->setContent([
            "validDuration" => $duration
        ]);
        return $response;
    }


    public function refreshAccessToken(HttpRequest $request, HttpResponse $response,
                                       TokenAuthentication $auth): HttpResponse {
        $HARD_DURATION = intval($_ENV['REFRESH_TOKEN_EXPIRATION']);
        $SOFT_DURATION = intval($_ENV['ACCESS_TOKEN_EXPIRATION']);

        $refreshToken = $request->getCookie(self::REFRESH_TOKEN_COOKIE_NAME);

        $authorized = $auth->authenticate($refreshToken, TokenAuthentication::REFRESH_TOKEN);

        if (! $authorized) {
            $response->setStatus(401);
            $response->setType(HttpResponse::JSON);
            $response->setContent([
                "authorized" => "false",
                "message" => "Invalid refresh token"
            ]);
            return $response;
        }

        $accessToken = TokenAuthentication::createTokenFor(
            $auth->getUserId(), TokenAuthentication::ACCESS_TOKEN,
            $auth->getAuthority(), $SOFT_DURATION);

        $response->setType(HttpResponse::JSON);
        $response->setStatus(200);

        $response->setContent([
            "authorized" => "true",
            "accessToken" => $accessToken,
        ]);


        return $response;
    }

    private function authenticate(string $username, string $password, ?AuthInfo $authInfo): ?User {
        //$hashedPassword = hash("sha256", $password);

        $hashedPassword = $password; // for testing

        if (isset($authInfo) && $hashedPassword === $authInfo->passwordHash) {
            return $authInfo->user;
        }
        return null;
    }

}