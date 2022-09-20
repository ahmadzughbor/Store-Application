<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\returns;
use App\Models\sale;
use Illuminate\Http\Request;

class salesController extends Controller
{
    public function sale(Request $request)
    {
        $request->validate([
            'price'=> 'required',
            'Quantity'=> 'required',
            'name'=> 'required',
        ]);
        $Psale = sale::create($request->all());
        // $prosale = product::all()->public('name')->toArray();
        $prosale = product::where('name',$request->name)->first();
        $prosale->update([
            'Quantity' => $prosale->Quantity - $request->Quantity,
        ]);
        return response()->json([
            'message' => 'product sale done ',
            'status' => 200,
            'data' => $Psale
        ]);
    }
    public function returns (Request $request)
    {
        $request->validate([
            'price'=> 'required',
            'Quantity'=> 'required',
            'name'=> 'required',
        ]);
        $productR = returns::create($request->all());
        $proreturn = product::where('name',$request->name)->first();
        $proreturn->update([
            'Quantity' => $proreturn->Quantity + $request->Quantity,
        ]);

        return response()->json([
            'message' => 'product return  done ',
            'status' => 200,
            'data' => $productR
        ]);
    }
    public function allSales(Request $request)
    {
        $allSales = sale::all();
        return response()->json([
            'message' => 'all sales',
            'status' => 200,
            'data' => $allSales
        ]);
    }
    public function allReturns(Request $request)
    {
        $allReturns = returns::all();
        return response()->json([
            'message' => 'all sales',
            'status' => 200,
            'data' => $allReturns
        ]);
    }
}
