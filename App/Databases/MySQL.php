<?php

namespace App\Databases;
use App\Helpers\DatabaseHelpers;
use \mysqli;

class MySQL {
    private $db_name = "blue_ocean";
    private $db_user = "ws-web";
    private $db_pass = "worldskills";
    private $db_host = "localhost";
    private $db_port = 3306;
    private $db = null;

    public function __construct()
    {
        if(!$this->db) {
            $this->Connect();
        }
    }

    public function Connect()
    {
        $this->db = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name, $this->db_port);
    }

    public function FindOne($table, $id, $columns = [])
    {
        $columns_statement = "*";
        if(count($columns) > 0) {
            $columns_statement = DatabaseHelpers::CreateColumnsStatement($columns);
        }
        $statement = "SELECT $columns_statement FROM $table WHERE id = $id";

        $result = $this->db->query($statement);

        $data = [];
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($data, $row);
            }
        }

        return $data;
    }

    public function FindAll($table, $columns = [])
    {
        $columns_statement = "*";
        if(count($columns) > 0) {
            $columns_statement = DatabaseHelpers::CreateColumnsStatement($columns);
        }
        $statement = "SELECT $columns_statement FROM $table";

        $result = $this->db->query($statement);

        $data = [];
        if($result->num_rows) {
            while($row = $result->fetch_assoc())
            {
                array_push($data, $row);
            }
        }

        return $data;
    }

    public function CreateOne($table, $data) 
    {
        $keys = DatabaseHelpers::GetKeys($data);
        $values = DatabaseHelpers::GetValues($data);
        $statement = "INSERT INTO $table ($keys) VALUES ($values)";

        $result = $this->db->query($statement);

        if($result) {
            return $this->db->insert_id;
        } else {
            return false;
        }
    }

    public function UpdateOne($table, $data, $id)
    {
        $update_statement = DatabaseHelpers::CreateUpdateStatement($data);
        $statement = "UPDATE $table SET $update_statement WHERE id = $id";

        $result = $this->db->query($statement);


        if($result) {
            return false;
        } else {
            return $this->db->error;
        }
    }
    
    public function DeleteOne($table, $id) 
    {
        $statement = "DELETE FROM $table WHERE id=$id";

        $result = $this->db->query($statement);

        if($result) {
            return true; 
        }

        return false;
    }


    public function InnerJoin($table, $primary_key, $inner_table, $foreign_id, $columns = [])
    {
        // $columns_statment = DatabaseHelpers::GetInnerJoinColumns($tabler, $inner_table, $columns);
        $statement = "SELECT $table.*, $inner_table.* FROM $table INNER JOIN $inner_table ON $table.$primary_key = $inner_table.$foreign_id";
        $result = $this->db->query($statement);
        $data = [];
        if($result->num_rows) {
            while($row = $result->fetch_assoc()) {
                array_push($data, $row);
            }
        }

        return $data;
    }
}