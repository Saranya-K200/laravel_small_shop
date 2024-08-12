<?php

namespace App\Enums;

enum OrderStatus: string
{
    case APPOINTMENT = 'APPOINTMENT';
    case PLACE_AN_ORDER ='PLACE AN ORDER';
    case FINISHING ='FINISHING';
    case DELIVERY ='DELIVERY';

    public static function getValues():array{

        return array_column(OrderStatus::cases(),'value');

    }

    public static function getKeyValue():array{

        return array_column (OrderStatus::cases(),'value','key');
    }


    
}