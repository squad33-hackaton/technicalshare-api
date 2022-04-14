<?php

use App\Core\Controller;

class Users extends Controller {

    public function index() {
        $userModel = $this->model("User");
        $users = $userModel->listAll();

        echo json_encode($users, JSON_UNESCAPED_UNICODE);
    }

    public function show($id) {
        $userModel = $this->model("User");
        $user = $userModel->getById($id);
        
        echo json_encode($user, JSON_UNESCAPED_UNICODE);
    }

    public function create() {
        $newUser = $this->getRequestBody();

        $userModel = $this->model("User");
        $userModel = User::fromJson($newUser);
        $userModel = $userModel->insert();

        if ($userModel) {
            http_response_code(201);
            echo json_encode($userModel);

        } else {
            http_response_code(500);
            echo json_encode(["error" => "insert error message"]);
        }

    }

    public function filter($query) {
        $userModel = $this->model("User");

        $queryArray = explode("=", $query);
        $field = $queryArray[0];
        $value = $queryArray[1];
        
        switch ($field) {
            case "email":
            case "id":
                $users = $userModel->findBy($field, $value);
                break;

            default: 
                http_response_code(500);
                echo json_encode(["error" => "invalid field"]);
                exit;
                break;
        }

        echo json_encode($users, JSON_UNESCAPED_UNICODE);

    }
}