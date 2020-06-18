<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Payment;

class PaymentServiceController extends Controller
{
    public function register()
    {
        $responseArray = array(
            "status" => 400,
            "success" => false
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
            $payment = new Payment;

            $_SESSION["id"]                 = session_id();
            $payment->sessionId             = $_SESSION["id"];
            $redirectUrl                    = $_SERVER["SERVER_NAME"] . "/payments/card/form?sessionId={$_SESSION["id"]}";

            $responseArray["status"]        = 200;
            $responseArray["success"]       = true;

            $responseArray["nominal"]       = $_GET["nominal"];
            $payment->nominal               = $_GET["nominal"];
            $_SESSION["payment"]["nominal"] = $_GET["nominal"];
            
            $responseArray["slug"]          = $_GET["slug"];
            $payment->slug                  = $_GET["slug"];
            $_SESSION["payment"]["slug"]    = $_GET["slug"];

            if(!empty($_GET["callbackUrl"]))
            {
                $callbackUrl = $_GET["callbackUrl"];
                $responseArray["callbackUrl"]       = $callbackUrl;
                $_SESSION["payment"]["callbackUrl"] = $callbackUrl;
            }
            $responseArray["redirectUrl"]   = $redirectUrl;
            
            $payment->save();
        }

        return response()
            ->json($responseArray)
            ->header("ContentType", "application/json");
    }

    public function index(){
        return view("index");
    }

    public function payments()
    {
        $responseArray = array(
            "status"  => 200,
            "success" => true
        );
        if(!empty($_GET["dateFrom"]) && !empty($_GET["dateTo"]))
        {
            $dateFrom = $_GET["dateFrom"];
            $dateTo   = $_GET["dateTo"];
            $payments = Payment::whereBetween("created_at", array($dateFrom, $dateTo))
                ->get();
        }
        elseif(empty($_GET["dateFrom"]) && empty($_GET["dateTo"]))
        {
            $payments = Payment::all();
        }
        else
        {
            if(empty($_GET["dateFrom"]))
            {
                $dateTo   = $_GET["dateTo"];
                $payments = Payment::where("created_at", "<=", $dateTo)
                    ->get();
            }
            else
            {
                $dateFrom = $_GET["dateFrom"];
                $payments = Payment::where("created_at", ">=", $dateFrom)
                    ->get();
            }
        }

        $responseArray["payments"] = $payments->toArray();
        return response()
            ->json($responseArray)
            ->header("ContentType", "application/json");
    }

    public function paymentsCardForm()
    {
        session_start();
        if(empty($_GET["sessionId"]))
        {
            return view("status", array(
                "message" => "Не удалось обнаружить параметр 'sessionId'"
            ));
        }
        if(!isset($_SESSION["id"]))
        {
            return view("status", array(
                "message" => "Платежной сессии не существует"
            ));
        }
        $requestSessionId = $_GET["sessionId"];
        $currentSessionId = $_SESSION["id"];
        if(strcmp($requestSessionId, $currentSessionId) === 0)
        {
            return view("payments/card/form", array(
                "nominal"     => $_SESSION["payment"]["nominal"],
                "slug"        => $_SESSION["payment"]["slug"],
                "callbackUrl" => !empty($_SESSION["payment"]["callbackUrl"]) ? $_SESSION["payment"]["callbackUrl"] : "",
                "sessionId"   => $requestSessionId
            ));
        }
        return view("status", array(
            "message" => "Данный 'sessionId' не совпадает с текущим"
        ));
    }

    public function paymentsCardFormPay(Request $request)
    {
        session_start();
        $validator = Validator::make($request->all(), [
            'card' => 'required|max:16'
        ]);
        $isLunaCard = $this->isLunaCard($request->card);
        if ($validator->fails() || !$isLunaCard) {
            return view("status", array(
                "message" => "Некорректная карта, оплата недействительна"
            ));
        }
        session_destroy();
        return view("status", array(
            "message" => "Поздравляем, оплата прошла успешно"
        ));
    }

    private function isLunaCard($value)
    {
        $number = strrev(preg_replace('/[^\d]+/', '', $value));
        $sum = 0;
        for ($i = 0, $j = strlen($number); $i < $j; $i++) {
            if (($i % 2) == 0) {
                $val = $number[$i];
            } else {
                $val = $number[$i] * 2;
                if ($val > 9)  {
                    $val -= 9;
                }
            }
            $sum += $val;
        }
        return (($sum % 10) === 0);
    }
}
