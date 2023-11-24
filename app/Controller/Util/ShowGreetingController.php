<?php

namespace App\Controller\Resource;

use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;

class ShowGreetingController {
    public function handle(HttpRequest $request, HttpResponse $response): HttpResponse {
        $content = [
            "group" => $request->pathVariable("group"),
            "name" => $request->pathVariable("name"),
            "info" => [
                "age" => $request->requestParam("age"),
                "country" => $request->requestParam("country")
            ]
        ];

        $response->setType(HttpResponse::JSON);

        $response->setContent($content);

        return $response;
    }

}