<?php

use App\Core\Controller;

class Users extends Controller {

    public function index() {
        $userModel = $this->model("User");
        $users = $userModel->listAll();

        echo json_encode($users, JSON_UNESCAPED_UNICODE);
    }

    public function find($id) {
        $userModel = $this->model("User");
        $user = $userModel->findById($id);
        
        echo json_encode($user, JSON_UNESCAPED_UNICODE);
    }

    public function create() {
        $newUser = $this->getRequestBody();

        $userModel = $this->model("User");
        $userModel->name = $newUser->name;
        $userModel->email = $newUser->email;
        $userModel->position = $newUser->position;
        $userModel->level = $newUser->level;
        $userModel->isMentor = $newUser->isMentor;
        $userModel->techs = $newUser->techs;
        $userModel->linkedin = $newUser->linkedin;
        $userModel->teams = $newUser->teams;
        $userModel->whatsapp = $newUser->whatsapp;

        $userModel = $userModel->insert();

        if ($userModel) {
            http_response_code(201);
            echo json_encode($userModel);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "insert error message"]);
        }
        
    }
}