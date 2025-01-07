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

        // Ambil data quantity sebelum diupdate (untuk menghitung selisih)
        $oldQuantity = $outcomingGoods->quantity;

        // Update data outcoming goods
        $outcomingGoods->update([
            'product_name' => $request->product_name,
            'date_out' => $request->date_out,
            'quantity' => $request->quantity,
            'destination' => $request->destination,
        ]);

        // Ambil data warehouse untuk produk yang terpilih
        $warehouse = Warehouse::where('product_name', $outcomingGoods->product_name)->first();

        if ($warehouse) {
            // Hitung selisih quantity, kemudian update quantity di warehouse
            $quantityDifference = $request->quantity - $oldQuantity;

            // Tambahkan selisih quantity ke warehouse
            $warehouse->quantity -= $quantityDifference;

            // Pastikan quantity tidak negatif
            if ($warehouse->quantity < 0) {
                $warehouse->quantity = 0;
            }

            // Simpan perubahan pada warehouse
            $warehouse->save();
        }

        return redirect()->route('outcomingGoods.index')->with('success', 'Goods Outgoing updated successfully.');
    }

    public function destroy($id)
    {
        // Ambil data outcoming goods yang akan dihapus
        $goods = OutcomingGoods::findOrFail($id);

        // Ambil data warehouse untuk produk yang terpilih
        $warehouse = Warehouse::where('product_name', $goods->product_name)->first();

        if ($warehouse) {
            // Tambahkan quantity yang dikeluarkan kembali ke warehouse
            $warehouse->quantity += $goods->quantity;

            // Simpan perubahan pada warehouse
            $warehouse->save();
        }

        // Hapus data outcoming goods
        $goods->delete();

        return redirect()->route('outcomingGoods.index')->with('success', 'Item deleted successfully and warehouse quantity updated.');
    }    
}
