<?php

namespace App\Controller\Resource;

use Slimmvc\Filesystem\LocalFilesystemDriver;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;

class ReadImageController {

    public function handle(HttpRequest $request, HttpResponse $response, LocalFilesystemDriver $fileDriver) {
        $category = $request->pathVariable("category");
        $imageId = $request->pathVariable("imageId");

        $SEPARATOR = DIRECTORY_SEPARATOR;
        $dir = $SEPARATOR."images".$SEPARATOR.$category;

        $imageName = $imageId;
        //$imageName = $fileDriver->findAFileWith($imageId, $dir);

        /*if (is_null($imageName)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent("image {$imageId} not found in {$dir}");
            return $response;
        }*/

        $imagePath = $dir.$SEPARATOR.$imageName;

        $stream = $fileDriver->readStream($imagePath);

        $response->setType(HttpResponse::IMAGE);
        $response->addHeader(HttpResponse::HEADER_CONTENT_TYPE, $fileDriver->mimeType($imagePath));
        $response->addHeader(HttpResponse::HEADER_CONTENT_LENGTH, $fileDriver->sizeOf($imagePath));
        $response->setContent($stream);

        return $response;
    }

}