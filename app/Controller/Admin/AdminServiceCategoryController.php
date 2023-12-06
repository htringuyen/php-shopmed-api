<?php

namespace App\Controller\Admin;

use App\Model\ServiceCategory;
use Exception;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;

class AdminServiceCategoryController {

    public function update(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth) {
        $categoryId = $request->pathVariable("id");

        $category = ServiceCategory::where("id", $categoryId)->first();

        if (!isset($category)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "Service category not found..."]);
            return $response;
        }

        $fields = ["name"];
        foreach ($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $category->$field = $value;
            }
        }

        try {
            $category->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($category->toSerializationArray());
            return $response;
        } catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }

    public function getAllOrSearch(HttpRequest $request, HttpResponse $response) {
        $searchName = $request->requestParam("name");

        $searchFields = ["id", "name"];

        $query = ServiceCategory::query();
        foreach ($searchFields as $field) {
            $searchValue = $request->requestParam($field);
            if (isset($searchValue)) {
                $query->where($field, "%{$searchValue}%", "like");
            }
        }

        $categories = $query->all();

        $data = array_map(fn ($category) => $category->toSerializationArray(), $categories);

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }


    public function create(HttpRequest $request, HttpResponse $response) {
        $category = new ServiceCategory();

        $fields = ["name"];
        foreach ($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $category->$field = $value;
            }
        }

        try {
            $category->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($category->toSerializationArray());
            return $response;
        } catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }


    public function delete(HttpRequest $request, HttpResponse $response) {
        $categoryId = $request->pathVariable("id");

        $category = ServiceCategory::where("id", $categoryId)->first();

        if (!isset($category)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "Service category not found..."]);
            return $response;
        }

        try {
            $category->delete();
            $response->setType(HttpResponse::JSON);
            $response->setContent(["message" => "Service category " . $category->id . " deleted successfully"]);
            return $response;
        } catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }
}
