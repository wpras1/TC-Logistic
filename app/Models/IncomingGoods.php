<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingGoods extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'date_in',
        'quantity',
        'origin',
    ];

    protected static function booted()
    {
        static::updated(function ($incomingGoods) {
            $warehouse = Warehouse::where('product_name', $incomingGoods->product_name)->first();

            if ($warehouse) {
                $warehouse->quantity = $incomingGoods->quantity;
                $warehouse->save();
            }
        });
    }
}
