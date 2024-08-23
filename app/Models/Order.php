<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
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
     return $this->belongsTo(User::class,'customer_id');
    }
    public function orderItems()
    {
     return$this->hasmany(OrderItem::class);
    }

    public function product()
    {

     return $this->BelongsTo(Product::class);

    }
     
        
    }
    


