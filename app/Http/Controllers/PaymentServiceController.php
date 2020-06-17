<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
class PaymentServiceController extends Controller
{
    public function register()
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
            $sessionId                    = session_id();
            
            $redirectUrl                    = $_SERVER["SERVER_NAME"] . "/payments/card/form?sessionId={$sessionId}";

            $responseArray["status"]        = 200;

            $responseArray["nominal"]       = $_GET["nominal"];
            $_SESSION["payment"]["nominal"] = $_GET["nominal"];
            
            $responseArray["slug"]          = $_GET["slug"];
            $_SESSION["payment"]["slug"]    = $_GET["slug"];

            $responseArray["redirectUrl"]   = $redirectUrl;
        }

        return response()
            ->json($responseArray)
            ->header("ContentType", "application/json");
    }

    public function index(){
        $responseArray = array(
            "info" => "About this API!"
        );
        return response()
            ->json($responseArray)
            ->header("ContentType", "application/json");
    }

    public function paymentsCardForm()
    {
        session_start();
        if(empty($_GET["sessionId"]))
        {
            echo "Wwedi parametr";
            return;
        }
        $requestSessionId = $_GET["sessionId"];
        $currentSessionId = session_id();
        if(strcmp($requestSessionId, $currentSessionId) === 0)
        {
            return view("payments/card/form", array(
                "nominal" => $_SESSION["payment"]["nominal"],
                "slug"    => $_SESSION["payment"]["slug"]
            ));
        }
        echo "tut ne budet formi";
        return;
    }

    public function paymentsCardFormPay(Request $request)
    {
        return "OK";
    }
}
