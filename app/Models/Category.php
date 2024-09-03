<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    function rel_to_product(){
        return $this->hasMany(Product::class, 'category_id');
    }

    protected $fillable =['category_name', 'category_image'];
}
