<?php

namespace App\Enums;

enum PaymentMethod: string

{
    case CASH = "CASH";
    case UPI = "UPI";
    case CARD = "CARD";


    public static function getvalues():array
    {
        return array_column(PaymentMethod::cases(),'value'); 
    }
    public static function getkeyvalue():array
    {
        return array_column(PaymentMethod::cases(),'value','key');
    }
}
