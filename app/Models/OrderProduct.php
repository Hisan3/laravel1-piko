<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    function rel_to_product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    function rel_to_inventory(){
        return $this->hasMany(Inventory::class, 'product_id','product_id');
    }
    function rel_to_Customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    protected $guarded  = ['id'];
}
