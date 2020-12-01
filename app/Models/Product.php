<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['manufacturer', 'product', 'set_number', 'description', 'price', 'assuarance', 'in_stock', 'category_id'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
