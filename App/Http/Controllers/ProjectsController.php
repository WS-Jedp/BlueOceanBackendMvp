<?php

namespace App\Http\Controllers;
use App\Http\Response;
use App\Helpers\RequestHelpers;
use App\Helpers\ErrorReport;
use App\Models\ProjectsModel;

class ProjectsController {
    private $model = null;

    public function __construct()
    {
        if(!$this->model) {
            $this->model = new ProjectsModel();
        }
    }

    public function Index()
    {

        if($_SERVER["REQUEST_METHOD"] === 'POST') {
            return ErrorReport::BadRequest();
        }

        $projects = $this->model->FindAll();
        $data = [
            "projects" => $projects
        ];
        return new Response("json", $data, 200);
    }

    public function Find($id)
    {

        if($_SERVER["REQUEST_METHOD"] === 'POST') {
            return ErrorReport::BadRequest();
        }

        $project = $this->model->GetIndustries($id);
        $data = [
            "project" => $project
        ];

        return new Response("json", $data, 200);
    }

    public function Create()
    {

        if($_SERVER["REQUEST_METHOD"] === 'GET') {
            return ErrorReport::BadRequest();
        }

        $is_errors = RequestHelpers::ValidateRequiredData(['title']);
        if($is_errors)
        {
            return ErrorReport::Error("ERROR: $is_errors");
        }

        $id = $this->model->Create($_POST);

        if(!$id) {
            return ErrorReport::Error("ERROR: We can't create the project");
        }

        $project = $this->model->FindOne($id);
        $data = [
            "status" => 201,
            "message" => "The project $id was created",
            "data" => [
                "project" => $project
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

        $project_updated = $this->model->FindOne($id);

        $data = [
            "status" => 201,
            "data" => [
                "project" => $project_updated
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
            return ErrorReport::Error("We can't delete the $id project");
        }

        $data = [
            "status" => 201,
            "message" => "The project $id was deleted"
        ];
        return new Response("json", $data, 201);
    }
}