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

    protected $dates =['order_date'];
    
    public function customer()
    { 
     return $this->belongsTo (user::class);
    }
    public function orderItems()
    {
     return$this->hasmany(OrderItem::class);
    }
    public function product()
    {
     return $this->BelongsTomany(product::class,'order_items');
    }
     
        
    }
    


