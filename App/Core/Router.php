<?php

namespace App\Core;

class Router {

    private $controller;
    private $httpMethod;
    private $controllerMethod;

    private $params = [];

    function __construct() {
        
        $url = $this->parseURL();

        if (file_exists("../App/Controllers/" . ucfirst($url[1]) . ".php")) {
            $this->controller = $url[1];
            unset($url[1]);

        } elseif (empty($url[1])) {
            echo "TechnicalShare API";
            exit;

        } else {
            http_response_code(404);
            echo json_encode(["error" => "not found"]);
            exit;
        }

        require_once("../App/Controllers/" . ucfirst($this->controller) . ".php");

        $this->controller = new $this->controller;
        $this->httpMethod = $_SERVER["REQUEST_METHOD"];

        switch ($this->httpMethod) {
            case "GET":
                if (isset($url[2])) {
                    $this->controllerMethod = "find";
                    $this->params = [$url[2]];

                } else {
                    $this->controllerMethod = "index";

                }
                break;

            case "POST":
                break;

            case "PUT":
                break;

            case "DELETE":
                break;

            default: 
                echo "unknown method";
                exit;
                break;
        }

        call_user_func_array([$this->controller, $this->controllerMethod], $this->params);
       
    }

    private function parseURL(){
        return explode("/", $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
    }

}
