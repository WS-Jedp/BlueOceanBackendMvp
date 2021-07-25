<?php

namespace App\Models;
use App\Databases\MySQL;
use App\Models\IndustriesModel;

class VariablesModel 
{
    private $table = "variables";
    private $inner_table = "industries";
    public $columns = ["id", "title", "description", "value", "industry_id"];
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
        $variable = $this->db->FindOne($this->table, $id, $selected_columns);
        return $variable[0];
    }

    public function FindAll($columns = [])
    {
        $selected_columns = empty($columns) ? $this->columns : $columns;
        $variables = $this->db->FindAll($this->table, $selected_columns);
        return $variables;
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

    public function GetIndustry($id)
    {
        $industry = new IndustriesModel();
        $variable = $this->FindOne($id);
        $variable["industry"] = $industry->FindOne($variable["industry_id"]);
        return $variable;

    }
}