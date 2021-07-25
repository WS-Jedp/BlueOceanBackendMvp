<?php

namespace App\Http;

class Request {
    protected $controller = "";
    protected $method = "";
    protected $parameter = "";

    public function __construct()
    {
        $segments = explode("/", $_SERVER["REQUEST_URI"]);

        $this->controller = empty($segments[1]) ? 'Projects' : $segments[1];
        $this->method = empty($segments[2]) ? 'Index' : $segments[2];
        $this->parameter = empty($segments[3]) ? null : $segments[3];
        
        $this->Send();
    }

    protected function GetController()
    {
        $controller = ucfirst($this->controller);
        return "App\Http\Controllers\\{$controller}Controller";
    }

    protected function GetMethod()
    {
        return ucfirst($this->method);
    }

    public function Send()
    {
        $controller = $this->GetController();
        $method = $this->GetMethod();
        $param = $this->parameter;

        $response = call_user_func([
            new $controller,
            $method
        ], $param);

        return $response->Send();
    }
}