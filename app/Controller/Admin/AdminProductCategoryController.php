<?php

namespace App\Controller\Admin;

use App\Model\ProductCategory;
use Exception;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;

class AdminProductCategoryController {

    public function update(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth) {
        $categoryId = $request->pathVariable("id");

        $category = ProductCategory::where("id", $categoryId)->first();

        if (! isset($category)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "Category not found..."]);
            return $response;
        }

        $name = $request->requestParam("name");
        if (isset($name)) {
            $category->name = $name;
        }

        try {
            $category->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($category->toSerializationArray());
            return $response;
        }
        catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }

    public function getAllOrSearch(HttpRequest $request, HttpResponse $response) {
        $searchName = $request->requestParam("name");

        $query = ProductCategory::query();
        if (isset($searchName)) {
            $query->where("name", "%{$searchName}%", "like");
        }

        $categories = $query->all();

        $data = array_map(fn($category) => $category->toSerializationArray(), $categories);

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }

    public function create(HttpRequest $request, HttpResponse $response) {
        $category = new ProductCategory();

        $name = $request->requestParam("name");
        if (isset($name)) {
            $category->name = $name;
        }

        try {
            $category->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($category->toSerializationArray());
            return $response;
        }
        catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }

    public function delete(HttpRequest $request, HttpResponse $response) {
        $categoryId = $request->pathVariable("id");

        $category = ProductCategory::where("id", $categoryId)->first();

        if (! isset($category)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "Category not found..."]);
            return $response;
        }

        try {
            $category->delete();
            $response->setType(HttpResponse::JSON);
            $response->setContent(["message" => "Category " . $category->id . " deleted successfully"]);
            return $response;
        }
        catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }
}
