<?php

namespace App\Controller\Admin;

use App\Model\Service;
use Exception;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;

class AdminServiceController {

    public function update(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth) {
        $serviceId = $request->pathVariable("id");

        $service = Service::where("id", $serviceId)->first();

        if (!isset($service)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "Service not found..."]);
            return $response;
        }

        $fields = ["name", "description", "categoryId", "price"];
        foreach ($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $service->$field = $value;
            }
        }

        try {
            $service->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($service->toSerializationArray());
            return $response;
        } catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }

    public function getAllOrSearch(HttpRequest $request, HttpResponse $response) {
        $searchFields = ["id", "name", "description", "categoryId", "price"];

        $query = Service::query();
        foreach ($searchFields as $field) {
            $searchValue = $request->requestParam($field);
            if (isset($searchValue)) {
                $query->where($field, "%{$searchValue}%", "like");
            }
        }

        $services = $query->all();

        $data = array_map(fn($service) => $service->toSerializationArray(), $services);

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }

    public function create(HttpRequest $request, HttpResponse $response) {
        $service = new Service();

        $fields = ["name", "description", "categoryId", "price"];
        foreach ($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $service->$field = $value;
            }
        }

        try {
            $service->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($service->toSerializationArray());
            return $response;
        } catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }

    public function delete(HttpRequest $request, HttpResponse $response) {
        $serviceId = $request->pathVariable("id");

        $service = Service::where("id", $serviceId)->first();

        if (!isset($service)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "Service not found..."]);
            return $response;
        }

        try {
            $service->delete();
            $response->setType(HttpResponse::JSON);
            $response->setContent(["message" => "Service " . $service->id . " deleted successfully"]);
            return $response;
        } catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }
}
