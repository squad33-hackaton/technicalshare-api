<?php

use App\Core\Model;

class User implements JsonSerializable {

    public $id;
    public $name;
    public $email;
    public $position;
    public $level;
    public $isMentor;
    public $techs;
    public $linkedin;
    public $teams;
    public $whatsapp;

    public function listAll() {
        $sqlQuery = "SELECT * FROM user";

        $statement = Model::getConnection()->prepare($sqlQuery);
        $statement->execute();

        if ($statement->rowCount() > 0) {
            $users = array();
            while ($user = $statement->fetch(PDO::FETCH_OBJ)) {
                array_push($users, User::toJson($user));
            }
            return $users;
        } else {
            return [];
        }
    }

    public function findBy($field, $value) {

        if (!$this->isFieldValid($field)) {
            return false;
        }

        $sqlQuery = "SELECT * FROM user WHERE ${field} = \"${value}\"";

        $statement = Model::getConnection()->prepare($sqlQuery);
        $statement->execute();

        if ($statement->rowCount() > 0) {
            $users = array();
            while ($user = $statement->fetch(PDO::FETCH_OBJ)) {
                array_push($users, User::toJson($user));
            }
            return $users;
        } else {
            return [];

        }
    }

    public function isFieldValid($field) {
        $sqlQuery = "SHOW COLUMNS FROM `technicalsharedb`.`user` WHERE Field = \"${field}\"";
        
        $statement = Model::getConnection()->prepare($sqlQuery);
        $statement->execute();

        if ($statement->rowCount() > 0) {
            return true;
        }

        return false;
    }

    public function getById($id) {

        $sqlQuery = "SELECT * FROM user WHERE id = ? LIMIT 0,1";

        $statement = Model::getConnection()->prepare($sqlQuery);
        $statement->bindParam(1, $id);

        if ($statement->execute()) {
            $user = $statement->fetch(PDO::FETCH_OBJ);

            if (!$user) {
                return false;
            }

            $this->id = $user->id;

            $this->name = $user->name;
            $this->email = $user->email;
            $this->position = $user->position;
            $this->level = $user->level;
            $this->isMentor = $user->isMentor;
            $this->techs = $user->techs;
            $this->linkedin = $user->linkedin;
            $this->teams = $user->teams;
            $this->whatsapp = $user->whatsapp;

            return $this;
        
        } else {
            return null;
        }
    }

    public function insert() {
        $sqlQuery = "INSERT INTO user (name, email, position, level, isMentor, techs, linkedin, teams, whatsapp) 
                     VALUES (:name, :email, :position, :level, :isMentor, :techs, :linkedin, :teams, :whatsapp)";
        
        $statement = Model::getConnection()->prepare($sqlQuery);

        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->position=htmlspecialchars(strip_tags($this->position));
        $this->level=htmlspecialchars(strip_tags($this->level));
        $this->isMentor=htmlspecialchars(strip_tags($this->isMentor));
        $this->techs=htmlspecialchars(strip_tags($this->techs));
        $this->linkedin=htmlspecialchars(strip_tags($this->linkedin));
        $this->teams=htmlspecialchars(strip_tags($this->teams));
        $this->whatsapp=htmlspecialchars(strip_tags($this->whatsapp));
        
        $statement->bindParam(":name", $this->name);
        $statement->bindParam(":email", $this->email);
        $statement->bindParam(":position", $this->position);
        $statement->bindParam(":level", $this->level);
        $statement->bindParam(":isMentor", $this->isMentor);
        $statement->bindParam(":techs", $this->techs);
        $statement->bindParam(":linkedin", $this->linkedin);
        $statement->bindParam(":teams", $this->teams);
        $statement->bindParam(":whatsapp", $this->whatsapp);

        if ($statement->execute()) {
            $this->id = Model::getConnection()->lastInsertId();
            return $this;

        } else {
            print_r($statement->errorInfo());
            return null;
        }

    }

    public function jsonSerialize() {
        return User::toJson($this);
    }

    public static function toJson($obj) {
        return [
            'id' => $obj->id,
            'name' => $obj->name,
            'email' => $obj->email,
            'position' => $obj->position,
            'level' => $obj->level,
            'isMentor' => filter_var($obj->isMentor, FILTER_VALIDATE_BOOLEAN),
            'techs' => $obj->techs,
            'links' => [
                "linkedin" => $obj->linkedin,
                "teams" => $obj->teams,
                "whatsapp" => $obj->whatsapp
            ]
        ];
    }

    public static function fromJson($obj) {
        $user = new self();
        
        $user->name = $obj->name;
        $user->email = $obj->email;
        $user->position = $obj->position;
        $user->level = $obj->level;
        $user->isMentor = filter_var($obj->isMentor, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $user->techs = $obj->techs;
        $user->linkedin = $obj->links->linkedin;
        $user->teams = $obj->links->teams;
        $user->whatsapp = $obj->links->whatsapp;

        return $user;
    }

    public static function isValid($user) {
        {
            if (isset($user->name) &&
                isset($user->email) &&
                isset($user->position) &&
                isset($user->level) &&
                isset($user->isMentor) &&
                isset($user->techs)) {
    
                return true;
            }
            return false;
        }
    }
}