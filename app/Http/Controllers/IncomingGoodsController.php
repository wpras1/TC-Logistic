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
        $products = Warehouse::pluck('product_name', 'id');  
        return view('incomingGoods.add', compact('products'));
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
                'date_in' => $validatedData['date_in'],
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
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'date_in' => 'required|date',
            'origin' => 'required|string|max:255',
        ]);

        $incomingGoods = IncomingGoods::findOrFail($id);

        $warehouse = Warehouse::where('product_name', $validatedData['product_name'])->first();

        if ($warehouse) {
            $warehouse->quantity -= $incomingGoods->quantity;

            $incomingGoods->update($validatedData);

            $warehouse->quantity += $validatedData['quantity'];
            $warehouse->save();
        }

        return redirect()->route('incomingGoods.index')->with('success', 'Incoming goods updated and warehouse quantity adjusted.');
    }

    public function destroy($id)
    {
        $goods = IncomingGoods::findOrFail($id);

        $warehouse = Warehouse::where('product_name', $goods->product_name)->first();

        if ($warehouse) {
            $warehouse->quantity -= $goods->quantity;

            if ($warehouse->quantity < 0) {
                $warehouse->quantity = 0;
            }

            $warehouse->save();
        }

        $goods->delete();

        return redirect()->route('incomingGoods.index')->with('success', 'Item deleted successfully and warehouse quantity reset.');
    }

}

