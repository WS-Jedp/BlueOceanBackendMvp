<?php

namespace App\Models;
use App\Databases\MySQL;

class ProjectsModel {
    private $table = 'projects';
    public $columns = ['id', 'title', 'description'];
    private $inner_table = "industries";
    private $db = null;

    public function __construct()
    {
        if(!$this->db) {
            $this->db = new MySQL();
        }
    }
    public function FindOne($id, $columns = [])
    {
        $selected_columns = empty($columns) ? $this->columns : $columns;
        $project = $this->db->FindOne($this->table, $id, $selected_columns);
        return $project[0];
    }

    public function FindAll($columns = [])
    {
        $selected_columns = empty($columns) ? $this->columns : $columns;
        $projects = $this->db->FindAll($this->table, $selected_columns);
        return $projects;
    }

    public function Create($data)
    {
        $id = $this->db->CreateOne($this->table, $data);
        return $id;
    }

    public function Update($data, $id)
    {
        $is_updated = $this->db->UpdateOne($this->table, $data, $id);
        return $is_updated;
    }

    public function Delete($id)
    {
        $is_deleted = $this->db->DeleteOne($this->table, $id);
        return $is_deleted;
    }

    public function GetIndustries($id)
    {
        $project = $this->FindOne($id);
        $project["industries"] = $this->db->InnerJoin($this->table, "id", $this->inner_table, "project_id");
        return $project;
    }
}