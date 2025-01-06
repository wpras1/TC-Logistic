<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomingGoods;
use App\Models\Warehouse;

class IncomingGoodsController extends Controller
{
    public function index()
    {
        $incomingGoods = IncomingGoods::all();
        return view('incomingGoods.index', compact('incomingGoods'));
    }

    public function add()
    {
        return view('incomingGoods.add');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'date_in' => 'required|date',
            'origin' => 'required|string|max:255',
        ]);

        IncomingGoods::create($validatedData);

        $warehouse = Warehouse::where('product_name', $validatedData['product_name'])->first();
        if ($warehouse) {
            $warehouse->quantity += $validatedData['quantity'];
            $warehouse->save();
        } else {
            Warehouse::create([
                'product_name' => $validatedData['product_name'],
                'quantity' => $validatedData['quantity'],
            ]);
        }

        return redirect()->route('incomingGoods.index')->with('success', 'Goods added and warehouse updated successfully.');
    }

    public function edit($id)
    {
        $incomingGoods = IncomingGoods::find($id); 
        $products = Warehouse::pluck('product_name', 'id');  
        return view('incomingGoods.edit', compact('incomingGoods', 'products'));
    }

    public function update(Request $request, $id)
    {
        $incomingGoods = IncomingGoods::find($id);

        $oldQuantity = $incomingGoods->quantity;
        $productName = $incomingGoods->product_name;

        $incomingGoods->update([
            'product_name' => $request->product_name,
            'date_in' => $request->date_in,
            'quantity' => $request->quantity,
            'origin' => $request->origin,
        ]);

        $warehouse = Warehouse::where('product_name', $productName)->first();
        if ($warehouse) {
            $warehouse->quantity += ($request->quantity - $oldQuantity); 
            $warehouse->save();
        }

        return redirect()->route('incomingGoods.index')->with('success', 'Goods Incoming updated successfully.');
    }

    public function destroy($id)
    {
        $goods = IncomingGoods::findOrFail($id);
        $goods->delete();
        return redirect()->route('incomingGoods.index')->with('success', 'Item deleted successfully');
    }

}

