<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\IncomingGoods;
use App\Models\OutcomingGoods;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::all();
        return view('warehouse.index', compact('warehouses'));
    }

    public function add()
    {
        return view('warehouse.add');  
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'quantity' => 'required|integer',
            'date_in' => 'required|date',
        ]);

        // Cek apakah produk sudah ada
        $existingProduct = Warehouse::where('product_name', $request->product_name)->first();
        if ($existingProduct) {
            return redirect()->back()->with('error', 'Product already exists in the warehouse.');
        }

        Warehouse::create([
            'product_name' => $request->product_name,
            'quantity' => $request->quantity,
            'date_in' => $request->date_in,
        ]);

        return redirect()->route('warehouse.index')->with('success', 'Product added to warehouse!');
    }

    public function update(Request $request, $id)
    {
        $warehouse = Warehouse::findOrFail($id);

        // Cek apakah nama produk baru sudah ada di warehouse, kecuali produk saat ini
            $existingProduct = Warehouse::where('product_name', $request->product_name)
            ->where('id', '!=', $id)
            ->first();

        if ($existingProduct) {
        return redirect()->back()->with('error', 'Product with this name already exists in the warehouse.');
        }

        // Simpan nama produk lama
        $oldProductName = $warehouse->product_name;

        // Cek apakah produk sudah digunakan di IncomingGoods atau OutcomingGoods
        $isUsedInIncoming = IncomingGoods::where('product_name', $oldProductName)->exists();
        $isUsedInOutgoing = OutcomingGoods::where('product_name', $oldProductName)->exists();

        if ($isUsedInIncoming || $isUsedInOutgoing) {
            return redirect()->back()->with('error', 'Product is used in Incoming/Outgoing goods and cannot be updated.');
        }

        // Update data di warehouse
        $warehouse->update([
            'product_name' => $request->product_name,
            'quantity' => $request->quantity,
            'date_in' => $request->date_in,
        ]);

        return redirect()->route('warehouse.index')->with('success', 'Warehouse product updated successfully.');
    }

    public function destroy($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        
        IncomingGoods::where('product_name', $warehouse->product_name)->delete();
        OutcomingGoods::where('product_name', $warehouse->product_name)->delete();

        $warehouse->delete();

        return redirect()->route('warehouse.index')->with('success', 'Item deleted successfully, and related goods entries removed.');
    }


    public function edit($id)
    {
        $product = Warehouse::findOrFail($id);
        
        // Cek apakah produk sudah digunakan di IncomingGoods atau OutcomingGoods
        $isUsedInIncoming = IncomingGoods::where('product_name', $product->product_name)->exists();
        $isUsedInOutgoing = OutcomingGoods::where('product_name', $product->product_name)->exists();

        // Jika produk sudah digunakan, flag untuk mencegah perubahan quantity
        $isUsed = $isUsedInIncoming || $isUsedInOutgoing;

        return view('warehouse.edit', compact('product', 'isUsed'));
    }


}

