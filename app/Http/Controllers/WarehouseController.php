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

    // Menyimpan data barang yang ditambahkan
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'product_name' => 'required',
            'quantity' => 'required|integer',
            'date_in' => 'required|date',
        ]);

        // Menyimpan data barang ke database
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

    // Simpan nama produk lama
    $oldProductName = $warehouse->product_name;

    // Update data di warehouse
    $warehouse->update([
        'product_name' => $request->product_name,
        'date_in' => $request->date_in,
    ]);

    IncomingGoods::where('product_name', $oldProductName)
        ->update(['product_name' => $request->product_name]);

    OutcomingGoods::where('product_name', $oldProductName)
        ->update(['product_name' => $request->product_name]);

    return redirect()->route('warehouse.index')->with('success', 'Warehouse product updated successfully.');
}



    public function destroy($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->delete();
        return redirect()->route('warehouse.index')->with('success', 'Item deleted successfully');
    }

    public function edit($id)
    {
        $product = Warehouse::findOrFail($id);
        $products = Warehouse::pluck('product_name', 'id');

        return view('warehouse.edit', compact('product', 'products'));
    }


}

