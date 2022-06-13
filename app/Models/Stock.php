<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'product_id',
        'stock_total'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

}
