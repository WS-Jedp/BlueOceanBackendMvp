<?php

namespace App\Helpers;

class RequestHelpers 
{
    public static function ValidateRequiredData($required)
    {
        for ($i=0; $i < count($required); $i++) { 
            $in_array = array_key_exists($required[$i], $_POST);
            if(!$in_array)
            {
                return "You must need send the $required[$i] value!";
            }
        }

        return null;
    } 


    public static function GetAcceptedColumns($data, $columns)
    {
        $accepted = [];
        foreach ($data as $key => $value) {
            if(in_array($key, $columns)) {
                $accepted[$key] = $value;
            }
        }

        return $accepted;
    }
}