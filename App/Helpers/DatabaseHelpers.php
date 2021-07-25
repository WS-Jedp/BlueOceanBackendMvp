<?php

namespace App\Helpers;

class DatabaseHelpers {

    public static function CreateConditions($array) {
        $conditions = "";
        $last_key = array_key_last($array);

        foreach ($array as $key => $value) {

            if($key === $last_key) {
                $conditions .= "$key = '$value'";
            } else {
                $conditions .= "$key = '$value',";
            }
        }

        return $conditions;
    }

    public static function CreateColumnsStatement($array) {
        $columns_statement = "";
        $length = count($array);
        for ($i=0; $i < $length; $i++) { 
            if($i === $length - 1) {
                $columns_statement .= "$array[$i]";
            } else {
                $columns_statement .= "$array[$i],";
            }
        }

        return $columns_statement;
    } 


    public static function CreateUpdateStatement($array)
    {
        $update_statement = "";
        $last_key = array_keys($array);
        
        foreach ($array as $key => $value) {
            if($last_key !== $key) {
                $update_statement .= "$key = '$value'";
            } else {
                $update_statement .= "$key = '$value',";
            }
        }

        return $update_statement;
    }


    public static function GetKeys($array) {
        $keys = "";
        $last_key = array_key_last($array);

        foreach ($array as $key => $value) {
            
            if($key === $last_key) {
                $keys .= "$key";
            } else {
                $keys .= "$key,";
            }
        }

        return $keys;
    }

    public static function GetValues($array) {
        $values = "";
        $last_key = array_key_last($array);

        foreach ($array as $key => $value) {
            
            if($key === $last_key) {
                $values .= "'$value'";
            } else {
                $values .= "'$value',";
            }
        }

        return $values;
    }


    /*
        [
            main_table => [
                id, name, something
            ] ---> main_table.id, main_table.name, ...
        ]
    */
    public static function GetInnerJoinColumns($table, $inner_table, $array)
    {
        $columns_statement = "";
        $main_columns = $array[$table];
        $inner_columns = $array[$inner_table];
        
        $main_length = count($main_columns);
        $inner_length = count($inner_columns);

        for($i = 0; $i < $main_length; $i++)
        {
            if($i === $main_length - 1) {
                $columns_statement .= "$table.$main_columns[$i]";
            } else {
                $columns_statement .= "$table.$main_columns[$i],";
            }
        }

        $columns_statement .= ",";

        for($i = 0; $i < $inner_length; $i++)
        {
            if($i === $inner_length - 1) {
                $columns_statement .= "$inner_table.$inner_columns[$i]";
            } else {
                $columns_statement .= "$inner_table.$inner_columns[$i],";
            }
        }

        return $columns_statement;
    }
}