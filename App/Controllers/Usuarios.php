<?php

use App\Core\Controller;

class Usuarios extends Controller {

    public function index() {
        $usuarioModel = $this->model("Usuario");
        $usuarios = $usuarioModel->listAll();

        echo json_encode($usuarios, JSON_UNESCAPED_UNICODE);
    }

    public function find($id) {
        $usuarioModel = $this->model("Usuario");
        $usuario = $usuarioModel->findById($id);
        
        echo json_encode($usuario, JSON_UNESCAPED_UNICODE);
    }

    public function create() {
        $newUsuario = $this->getRequestBody();

        $usuarioModel = $this->model("Usuario");
        $usuarioModel->nome = $newUsuario->nome;
        $usuarioModel->email = $newUsuario->email;
        $usuarioModel->senha = $newUsuario->senha;
        $usuarioModel->habilidade = $newUsuario->habilidade;
        $usuarioModel->linkedin = $newUsuario->linkedin;
        $usuarioModel->teams = $newUsuario->teams;
        $usuarioModel->whatsapp = $newUsuario->whatsapp;
        $usuarioModel->isMentor = $newUsuario->isMentor;

        $usuarioModel = $usuarioModel->insert();

        if ($usuarioModel) {
            http_response_code(201);
            echo json_encode($usuarioModel);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "insert error message"]);
        }
        
    }
}