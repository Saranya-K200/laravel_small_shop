<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $filament = [
        'customer_id',
        'order_number',
        'order_date',
        'total_amount',
        'order_status',
        'payment_method'
    ];



}
