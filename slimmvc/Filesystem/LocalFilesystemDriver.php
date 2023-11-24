<?php
namespace Slimmvc\Filesystem;

use League\Flysystem\FileAttributes;
use League\Flysystem\Local\LocalFilesystemAdapter;

use League\Flysystem\Filesystem;

class LocalFilesystemDriver {
    private Filesystem $filesystem;

    public function __construct() {
        $adaptor = new LocalFilesystemAdapter(config("filesystem.local.path"));

        $this->filesystem = new Filesystem($adaptor);

    }

    public function sizeOf(string $path) {
        return $this->filesystem->fileSize($path);
    }

    public function list(string $path, bool $recursive = false): iterable
    {
        return $this->filesystem->listContents($path, $recursive);
    }

    public function findAFileWith(string $name, string $dirPath): ?string {
        $files = $this->filesystem->listContents($dirPath);

//        $this->filesystem->
//        foreach ($files as $file) {
//
//            if ($file instanceof FileAttributes && str_starts_with($file["basename"], $name)) {
//                return $file["basename"];
//            }
//
//
//        }

        return null;
    }

    public function exists(string $path): bool
    {
        return $this->filesystem->fileExists($path);
    }

    public function mimeType(string $path): string {
        return $this->filesystem->mimeType($path);
    }

    public function read(string $path): string
    {
        return $this->filesystem->read($path);
    }

    public function write(string $path, mixed $value): static
    {
        $this->filesystem->write($path, $value);
        return $this;
    }

    public function delete(string $path): static
    {
        $this->filesystem->delete($path);
        return $this;
    }

    public function readStream(string $path): mixed {
        return $this->filesystem->readStream($path);
    }

    public function writeStream(string $path, mixed $content) {
        $this->writeStream($path, $content);
    }

    public function readStreamAndFlush(string $path): void {
        $stream = $this->filesystem->readStream($path);

        fpassthru($stream);

        fclose($stream);
    }



}