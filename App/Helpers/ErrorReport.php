<?php

namespace App\Helpers;
use App\Http\Response;

class ErrorReport {


    public static function BadRequest()
    {
        $err = [
            "status" => 501,
            "message" => "Bad request"
        ];
        return new Response("json", $err, 501);
    }


    public static function Error($msg)
    {
        $err = [
            "status" => 500,
            "message" => $msg,
        ];
        return new Response("json", $err, 500);
    } 

}