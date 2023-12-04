<?php

namespace App\Controller\Admin;

use App\Model\User;
use Slimmvc\Http\HttpResponse;

class AdminUserController
{
    function getAllUsers(HttpResponse $response)
    {
        $users = User::all();
        $data = [];
        foreach ($users as $user) {
            array_push($data, $user->toSerializationArray());
        }

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }

    function getUserById(HttpResponse $response, $userId)
    {
        $user = User::find($userId);

        if (!$user) {
            $response->setType(HttpResponse::JSON);
            $response->setContent(['error' => 'User not found']);
            return $response;
        }

        $responseData = $user->toSerializationArray();

        $response->setType(HttpResponse::JSON);
        $response->setContent($responseData);
        return $response;
    }

    function createUser(HttpResponse $response, $userData)
    {
        // Tạo một đối tượng User mới từ dữ liệu đầu vào
        $newUser = new User();
        foreach ($userData as $key => $value) {
            // Kiểm tra xem thuộc tính có tồn tại trong đối tượng hay không
            if (property_exists($newUser, $key)) {
                // Nếu tồn tại, gán giá trị từ mảng vào thuộc tính
                $newUser->$key = $value;
            }
        }

        // Lưu người dùng mới vào cơ sở dữ liệu
        $newUser->save();

        // Trả về thông tin của người dùng vừa được tạo
        $responseData = $newUser->toSerializationArray();

        $response->setType(HttpResponse::JSON);
        $response->setContent($responseData);
        return $response;
    }

    function editUser(HttpResponse $response, $userId, $userData)
    {
        // Tìm người dùng cần chỉnh sửa theo ID
        $user = User::find($userId);

        if (!$user) {
            // Trả về lỗi nếu không tìm thấy người dùng
            $response->setType(HttpResponse::JSON);
            $response->setContent(['error' => 'User not found']);
            return $response;
        }

        // Cập nhật thông tin người dùng từ dữ liệu đầu vào
        foreach ($userData as $key => $value) {
            // Kiểm tra xem thuộc tính có tồn tại trong đối tượng hay không
            if (property_exists($user, $key)) {
                // Nếu tồn tại, gán giá trị từ mảng vào thuộc tính
                $user->$key = $value;
            }
        }
        $user->save();

        // Trả về thông tin của người dùng sau khi chỉnh sửa
        $responseData = $user->toSerializationArray();

        $response->setType(HttpResponse::JSON);
        $response->setContent($responseData);
        return $response;
    }

    function deleteUser(HttpResponse $response, $userId)
    {
        // Tìm người dùng cần xóa theo ID
        $user = User::find($userId);

        if (!$user) {
            // Trả về lỗi nếu không tìm thấy người dùng
            $response->setType(HttpResponse::JSON);
            $response->setContent(['error' => 'User not found']);
            return $response;
        }

        // Xóa người dùng khỏi cơ sở dữ liệu
        $user->delete();

        // Trả về thông báo xóa thành công
        $response->setType(HttpResponse::JSON);
        $response->setContent(['message' => 'User deleted successfully']);
        return $response;
    }
}
