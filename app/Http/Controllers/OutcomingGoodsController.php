<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OutcomingGoods;
use App\Models\Warehouse;
use Carbon\Carbon;

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

        if (!$warehouse) {
            return redirect()->back()->withErrors(['product_name' => 'Product not found in warehouse.'])->withInput();
        }

        if (Carbon::parse($validatedData['date_out'])->lt(Carbon::parse($warehouse->date_in))) {
            return redirect()->back()->withErrors([
                'date_out' => 'Date Out cannot be earlier than Date In (' . $warehouse->date_in . ').',
            ])->withInput();
        }

        if ($warehouse->quantity < $validatedData['quantity']) {
            return redirect()->back()->withErrors(['quantity' => 'Not enough stock in warehouse.'])->withInput();
        }

        $outgoingGoods = OutcomingGoods::create($validatedData);

        $warehouse->quantity -= $validatedData['quantity'];
        $warehouse->save();

        return redirect()->route('outcomingGoods.index')->with('success', 'Goods Outgoing added successfully.');
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

        // Validasi jika date_out lebih kecil dari date_in
        if (Carbon::parse($request->date_out)->lt(Carbon::parse($outcomingGoods->date_in))) {
            return redirect()->back()->withErrors(['date_out' => 'Date Out cannot be earlier than Date In.'])->withInput();
        }

        $oldQuantity = $outcomingGoods->quantity;

        $outcomingGoods->update([
            'product_name' => $request->product_name,
            'date_out' => $request->date_out,
            'quantity' => $request->quantity,
            'destination' => $request->destination,
        ]);

        $warehouse = Warehouse::where('product_name', $outcomingGoods->product_name)->first();

        if ($warehouse) {
            $quantityDifference = $request->quantity - $oldQuantity;
            $warehouse->quantity -= $quantityDifference;

            if ($warehouse->quantity < 0) {
                $warehouse->quantity = 0;
            }

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
