<?php

namespace App\Http;

class Response {

    protected $type = "";
    protected $data = "";
    protected $status_code = 200;

    public function __construct($type, $data, $status_code = 200)
    {
        $this->type = $type;
        $this->data = $data;
        $this->status_code = $status_code;
    }

    public function GetResponse()
    {
        http_response_code($this->status_code);
        switch ($this->type) {
            case 'json':
                header('Content-Type: application/json');
                return json_encode($this->data);
                break;

            case 'view':                
                $content = file_get_contents(__DIR__ . "../../views/$this->data.php");
                require_once '../../views/template.php';
                break;
            
            default:
                header("Content-Type: 'application/json'");
                $data = [
                    "message" => "Error in the data type"
                ];
                return json_encode($data);
                break;
        }
    }

    public function Send()
    {
        echo $this->GetResponse();
    }

}