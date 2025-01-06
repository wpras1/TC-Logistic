<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::all();
        $warehouses = Warehouse::with('incomingGoods')->get();

        return view('warehouse.index', compact('warehouses'));
    }

    public function destroy($id)
    {
        $goods = Warehouse::findOrFail($id);
        $goods->delete();
        return redirect()->route('warehouse.index')->with('success', 'Item deleted successfully');
    }
}
