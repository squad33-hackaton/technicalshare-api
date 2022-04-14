<?php

namespace App\Core;

class Router {

    private $controller;
    private $httpMethod;
    private $controllerMethod;

    private $params = [];

    function __construct() {
        
        $url = $this->parseURL();

        if (file_exists("../App/Controllers/" . ucfirst($url["path"][0]) . ".php")) {
            $this->controller = $url["path"][0];

        } elseif (empty($url["path"][0])) {
            echo json_encode("TechnicalShare API");
            exit;

        } else {
            http_response_code(404);
            echo json_encode(["error" => "resource not found"]);
            exit;
        }

        require_once("../App/Controllers/" . ucfirst($this->controller) . ".php");

        $this->controller = new $this->controller;
        $this->httpMethod = $_SERVER["REQUEST_METHOD"];

        switch ($this->httpMethod) {
            case "GET":
                if (isset($url["path"][1])) {
                    $this->controllerMethod = "show";
                    $this->params = [$url["path"][1]];

                } elseif (isset($url["query"])) {
                    $this->controllerMethod = "filter";
                    $this->params = [$url["query"]];

                } else {
                    $this->controllerMethod = "index";

                }
                break;

            case "POST":
                $this->controllerMethod = "create";
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
        $url = sprintf('%s://%s%s',
                        isset($_SERVER['HTTPS']) ? 'https' : 'http',
                        $_SERVER['HTTP_HOST'],
                        $_SERVER['REQUEST_URI']
        );

        $urlArray = parse_url($url);
        $urlArray["path"] = ltrim($urlArray["path"], '/');
        $urlArray["path"] = rtrim($urlArray["path"], '/');
        $urlArray["path"] = explode("/", $urlArray["path"]);

        return $urlArray;
    }

}
