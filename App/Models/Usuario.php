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

    public function insert() {
        $sqlQuery = "INSERT INTO usuario (nome, email, senha, habilidade, linkedin, teams, whatsapp, is_mentor) 
                     VALUES (:nome, :email, :senha, :habilidade, :linkedin, :teams, :whatsapp, :is_mentor)";
        
        $statement = Model::getConnection()->prepare($sqlQuery);

        $this->nome=htmlspecialchars(strip_tags($this->nome));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->senha=htmlspecialchars(strip_tags($this->senha));
        $this->habilidade=htmlspecialchars(strip_tags($this->habilidade));
        $this->linkedin=htmlspecialchars(strip_tags($this->linkedin));
        $this->teams=htmlspecialchars(strip_tags($this->teams));
        $this->whatsapp=htmlspecialchars(strip_tags($this->whatsapp));
        $this->isMentor=htmlspecialchars(strip_tags($this->isMentor));

        $statement->bindParam(":nome", $this->nome);
        $statement->bindParam(":email", $this->email);
        $statement->bindParam(":senha", $this->senha);
        $statement->bindParam(":habilidade", $this->habilidade);
        $statement->bindParam(":linkedin", $this->linkedin);
        $statement->bindParam(":teams", $this->teams);
        $statement->bindParam(":whatsapp", $this->whatsapp);
        $statement->bindParam(":is_mentor", $this->isMentor);

        if ($statement->execute()) {
            $this->id = Model::getConnection()->lastInsertId();
            return $this;

        } else {
            print_r($statement->errorInfo());
            return null;
        }

    }
}