<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\IncomingGoods;
use App\Models\OutcomingGoods;

class DetailsController extends Controller
{
    public function index($productName)
    {
        $incomingGoods = IncomingGoods::where('product_name', $productName)->first();
        $outcomingGoods = OutcomingGoods::where('product_name', $productName)->get();
        $warehouseStock = Warehouse::where('product_name', $productName)->first();
    
        $product = [
            'product_name' => $incomingGoods->product_name,
            'incoming_from' => $incomingGoods->origin,
            'outcoming_to' => $outcomingGoods->isEmpty() ? null : $outcomingGoods->last()->destination,
            'total_outcoming' => $outcomingGoods->sum('quantity'),
            'stock_in_warehouse' => $warehouseStock ? $warehouseStock->quantity : 0,
        ];
    
        return view('details_goods', compact('product'));
    }
    
}
