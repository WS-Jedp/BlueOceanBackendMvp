<?php

namespace App\Models;
use App\Databases\MySQL;

class IndustriesModel 
{
    private $table = "industries";
    public $columns = ["id", "title", "description", "project_id"];
    private $parent_table = "projects";
    private $inner_table = "variables";
    private $db = null;

    public function __construct()
    {
        if(!$this->db)
        {
            $this->db = new MySQL();
        }
    }

    public function FindOne($id, $columns = [])
    {
        $selected_columns = empty($columns) ? $this->columns : $columns;
        $industry = $this->db->FindOne($this->table, $id, $selected_columns);
        return $industry[0];
    }

    public function FindAll($columns = [])
    {
        $selected_columns = empty($columns) ? $this->columns : $columns;
        $industries = $this->db->FindAll($this->table, $selected_columns);
        return $industries;
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

    public function GetProject($id)
    {
        $industry = $this->FindOne($id);
        $project = new ProjectsModel();
        $industry["project"] = $project->FindOne($industry["project_id"]);
        return $industry;
    }

    public function GetVariables($id) {
        $industry = $this->FindOne($id);
        $industry["variables"] = $this->db->InnerJoin($this->table, "id", $this->inner_table, "industry_id");
        return $industry;
    }
}