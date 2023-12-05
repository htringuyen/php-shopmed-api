<?php

namespace App\Controller\Dev\User;

use App\Model\User;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;

class AdminUserController {

    public function getAllOrSearch(HttpResponse $response, HttpRequest $request) {

        $searchFields = ["id", "fullName", "email", "address", "phone"];

        $query = User::query();

        foreach($searchFields as $field) {
            $searchValue = $request->requestParam($field);
            if (isset($searchValue)) {
                $query->where($field, "%{$searchValue}%", "like");
            }
        }

        $models = $query->all();

        $data = array_map(function ($model) {
            return $model->toSerializationArray();
        }, $models);

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }

}