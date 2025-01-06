<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomingGoods;
use App\Models\OutcomingGoods;
use App\Models\Warehouse;

class HomeController extends Controller
{
    public function index()
    {
        $incomingGoods = IncomingGoods::all();  
        $outcomingGoods = OutcomingGoods::all(); 
        $warehouseStock = Warehouse::pluck('quantity', 'product_name'); 

        $mostStocked = Warehouse::orderBy('quantity', 'desc')->first();
        $leastStocked = Warehouse::orderBy('quantity', 'asc')->first();
        $totalProducts = Warehouse::count();
        $totalQuantity = Warehouse::sum('quantity');
        
        $products = [];

        foreach ($incomingGoods as $incoming) {
            $products[$incoming->product_name] = [
                'product_name' => $incoming->product_name,
                'incoming_from' => $incoming->origin,
                'outcoming_to' => null,
                'total_outcoming' => OutcomingGoods::where('product_name', $incoming->product_name)->sum('quantity'),
                'stock_in_warehouse' => $incoming->quantity,
            ];
        }

        foreach ($outcomingGoods as $outcoming) {
            if (isset($products[$outcoming->product_name])) {
                $products[$outcoming->product_name]['outcoming_to'] = $outcoming->destination;
            } else {
                $products[$outcoming->product_name] = [
                    'product_name' => $outcoming->product_name,
                    'incoming_from' => null,
                    'outcoming_to' => $outcoming->destination,
                    'total_outcoming' => $outcoming->quantity,
                    'stock_in_warehouse' => $warehouseStock[$outcoming->product_name] ?? 0,
                ];
            }
        }

        return view('home', [
            'products' => array_values($products),
            'mostStocked' => $mostStocked,
            'leastStocked' => $leastStocked,
            'totalProducts' => $totalProducts,
            'totalQuantity' => $totalQuantity,
            'warehouseStock' => $warehouseStock,
        ]);
    }
}


