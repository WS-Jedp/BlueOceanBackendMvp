<?php

namespace App\Http\Controllers;
use App\Http\Response;
use App\Helpers\RequestHelpers;
use App\Helpers\ErrorReport;
use App\Models\VariablesModel;

class VariablesController {
    private $model = null;

    public function __construct()
    {
        if(!$this->model) {
            $this->model = new VariablesModel();
        }
    }

    public function Index()
    {

        if($_SERVER["REQUEST_METHOD"] === 'POST') {
            return ErrorReport::BadRequest();
        }

        $variables = $this->model->FindAll();
        $data = [
            "variables" => $variables
        ];
        return new Response("json", $data, 200);
    }

    public function Find($id)
    {

        if($_SERVER["REQUEST_METHOD"] === 'POST') {
            return ErrorReport::BadRequest();
        }

        $variable = $this->model->GetIndustry($id);
        $data = [
            "variable" => $variable
        ];

        return new Response("json", $data, 200);
    }

    public function Create()
    {

        if($_SERVER["REQUEST_METHOD"] === 'GET') {
            return ErrorReport::BadRequest();
        }

        $is_errors = RequestHelpers::ValidateRequiredData(['title', 'industry_id']);
        if($is_errors)
        {
            return ErrorReport::Error("ERROR: $is_errors");
        }

        $id = $this->model->Create($_POST);

        if(!$id) {
            return ErrorReport::Error("ERROR: We can't create the variable");
        }

        $variable = $this->model->FindOne($id);
        $data = [
            "status" => 201,
            "message" => "The variable $id was created",
            "data" => [
                "variable" => $variable
            ]
        ];

        return new Response("json", $data, 201);
        
    }

    public function Update($id)
    {
        if($_SERVER["REQUEST_METHOD"] === 'GET') {
            return ErrorReport::BadRequest();
        }

        $data = RequestHelpers::GetAcceptedColumns($_POST, $this->model->columns);

        $is_error = $this->model->Update($data, $id);
        if($is_error) {
            return ErrorReport::Error("ERROR: $is_error");
        }

        $variable_updated = $this->model->FindOne($id);

        $data = [
            "status" => 201,
            "data" => [
                "variable" => $variable_updated
            ]
        ];

        return new Response("json", $data, 201);
    }

    public function Delete($id)
    {
        if($_SERVER["REQUEST_METHOD"] === 'POST') {
            return ErrorReport::BadRequest();
        }

        $is_deleted = $this->model->Delete($id);

        if(!$is_deleted) {
            return ErrorReport::Error("We can't delete the $id variable");
        }

        $data = [
            "status" => 201,
            "message" => "The variable $id was deleted"
        ];
        return new Response("json", $data, 201);
    }
}