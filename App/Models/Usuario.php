<?php

use App\Core\Model;

class Usuario {

    public $id;
    public $nome;
    public $email;
    public $senha;
    public $habilidade;
    public $linkedin;
    public $teams;
    public $whatsapp;
    public $isMentor;

    public function listAll() {
        $sqlQuery = "SELECT * FROM usuario";

        $statement = Model::getConnection()->prepare($sqlQuery);
        $statement->execute();

        if ($statement->rowCount() > 0) {
            $result = $statement->fetchAll(PDO::FETCH_OBJ);
            return $result;

        } else {
            return [];
        }
    }

    public function findById($id) {
        $sqlQuery = "SELECT * FROM usuario WHERE id = ? LIMIT 0,1";

        $statement = Model::getConnection()->prepare($sqlQuery);
        $statement->bindParam(1, $id);

        if ($statement->execute()) {
            $usuario = $statement->fetch(PDO::FETCH_OBJ);

            if (!$usuario) {
                return false;
            }

            $this->id = $usuario->id;
            $this->nome = $usuario->nome;
            $this->email = $usuario->email;
            $this->senha = $usuario->senha;
            $this->habilidade = $usuario->habilidade;
            $this->linkedin = $usuario->linkedin;
            $this->teams = $usuario->teams;
            $this->whatsapp = $usuario->whatsapp;
            $this->isMentor = $usuario->isMentor;

            return $this;
        
        } else {
            return null;
        }
    }    
}