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

}