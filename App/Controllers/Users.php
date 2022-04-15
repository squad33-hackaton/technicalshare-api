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
        
        if (!$user || !is_numeric($id)) {
            http_response_code(404);
            echo json_encode(["error" => "user not found"]);            

        } else {
            http_response_code(200);
            echo json_encode($user, JSON_UNESCAPED_UNICODE);

        }
    }

    public function create() {
        $newUser = $this->getRequestBody();

        $userModel = $this->model("User");
        $userModel = User::fromJson($newUser);

        $isEmailAvailable = !$userModel->findBy("email", $userModel->email);
        $isUserValid = User::isValid($userModel);

        if (!$isEmailAvailable) {
            http_response_code(400);
            echo json_encode(["error" => "email already in use"]);
            
        } elseif ($isUserValid) {

            $userModel = $userModel->insert();

            if ($userModel) {
                http_response_code(201);
                echo json_encode($userModel);

            } else {
                http_response_code(500);
                echo json_encode(["error" => "internal server error"]);
            }

        } else {
            http_response_code(400);
                echo json_encode(["error" => "invalid JSON"]);
        }

    }

    public function filter($query) {
        $userModel = $this->model("User");

        $queryArray = explode("=", $query);
        $field = $queryArray[0];
        $value = urldecode($queryArray[1]);
        
        switch ($field) {
            case "isMentor":
                $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case "id":
            case "name":
            case "email":
            case "position":
            case "level":
                $users = $userModel->findBy($field, $value);

                if (!$users && isset($value)) {
                    http_response_code(204);
    
                } else {
                    echo json_encode($users, JSON_UNESCAPED_UNICODE);
                }
                break;

            default: 
                $this->index();
                exit;
                break;
        }
    }
}