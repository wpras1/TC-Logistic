<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = ['product_name', 'quantity'];

    public function incomingGoods()
    {
        return $this->hasOne(IncomingGoods::class, 'product_name', 'product_name');
    }

}

