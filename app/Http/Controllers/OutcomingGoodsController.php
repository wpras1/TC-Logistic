<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OutcomingGoods;
use App\Models\Warehouse;

class OutcomingGoodsController extends Controller
{
    public function index()
    {
        $outcomingGoods = OutcomingGoods::all();
        return view('outcomingGoods.index', compact('outcomingGoods'));
    }

    public function add()
    {
        $products = Warehouse::pluck('product_name', 'id'); 

        return view('outcomingGoods.add', compact('products'));
    }


    public function store(Request $request)
{
    $validatedData = $request->validate([
        'product_name' => 'required|string|max:255',
        'quantity' => 'required|integer|min:1',
        'destination' => 'required|string|max:255',
        'date_out' => 'required|date',
    ]);

    $warehouse = Warehouse::where('product_name', $validatedData['product_name'])->first();

    if ($warehouse && $warehouse->quantity < $validatedData['quantity']) {
        return redirect()->back()->withErrors(['quantity' => 'Not enough stock in warehouse.'])->withInput();
    }

    $outgoingGoods = OutcomingGoods::create($validatedData);

    if ($warehouse) {
        $warehouse->quantity -= $validatedData['quantity'];
        $warehouse->save();
    } else {
        return redirect()->back()->with('error', 'Product not found in warehouse.');
    }

    return redirect()->route('outcomingGoods.index')->with('success', 'Goods removed and warehouse updated successfully.');
}


    public function getProductStock(Request $request)
    {
        $productName = $request->product_name;
        $warehouse = Warehouse::where('product_name', $productName)->first();

        return response()->json([
            'stock' => $warehouse ? $warehouse->quantity : 0,
        ]);
    }

    public function edit($id)
    {
        $outcomingGoods = OutcomingGoods::find($id);  
        $products = Warehouse::pluck('product_name', 'id');  
        return view('outcomingGoods.edit', compact('outcomingGoods', 'products'));
    }

    public function update(Request $request, $id)
    {
        $outcomingGoods = OutcomingGoods::find($id);
        $outcomingGoods->update([
            'product_name' => $request->product_name,
            'date_out' => $request->date_out,
            'quantity' => $request->quantity,
            'destination' => $request->destination,
        ]);

        return redirect()->route('outcomingGoods.index')->with('success', 'Goods Outgoing updated successfully.');
    }



    public function destroy($id)
    {
        $goods = OutcomingGoods::findOrFail($id);
        $goods->delete();
        return redirect()->route('outcomingGoods.index')->with('success', 'Item deleted successfully');
    }
    
}
