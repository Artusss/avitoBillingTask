<?php

namespace App\Http\Controllers;

class PaymentServiceController extends Controller
{
    public function payment()
    {
        $responseArray = array(
            "status" => 400
        );
        if(empty($_GET["nominal"]))
        {
            $responseArray["errorMessage"] = "Укажите номинал";
        }
        elseif(empty($_GET["slug"]))
        {
            $responseArray["errorMessage"] = "Укажите назначение платежа";
        }
        else
        {
            session_start();
            // generate id for payment
            $_SESSION['id']             = rand(100000, 999999);
            $responseArray["status"]    = 200;
            $responseArray["nominal"]   = $_GET["nominal"];
            $responseArray["slug"]      = $_GET["slug"];
            $responseArray["sessionId"] = $_SESSION['id'];
        }

        return response()
            ->json($responseArray)
            ->header("ContentType", "application/json");
    }

    public function index(){
        $responseArray = array(
            "status" => 400
        );
        session_start();
        if(isset($_SESSION["id"]))
        {
            $responseArray["status"]    = 200;
            $responseArray["sessionId"] = $_SESSION["id"];
            unset($_SESSION["id"]);
            return response()
                ->json($responseArray)
                ->header("ContentType", "application/json");
        }
        return response()
            ->json($responseArray)
            ->header("ContentType", "application/json");
    }
}
