<?php

namespace App\Http\Controllers;

use App\Models\bill;
use App\Models\product;
use Illuminate\Http\Request;

class productsController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'price'=>'required',
            'cost'=>'required',
            'Quantity'=>'required',
        ]);
        // $profit= $request->cost - $request->price ;
        $prods = product::all();
        $ar=$prods->pluck('name')->toArray();

        if(in_array($request->name , $ar))
        {
            $prod = product::where('name' ,$request->name)->first();
            $prod->update([
                'Quantity' => $request->Quantity + $prod->Quantity,
                ]);
        }else{
            $prod = product::create($request->all());
        }
        $productbills = bill::create([
            'name' => $request->name,
            'cost'=> $request->cost,
            'Quantity' =>$request->Quantity,
        ]);
        return response()->json([
            'message' =>'products added succsesfully',
            'status'=>'200',
            'data'=>[
                'product'=>  $prod ,
                'bills'  =>  $productbills
            ],
        ]);

    }

    public function allProduct (Request $request)
    {
        $products = product::all();
        return response()->json([
            'message' => 'all products is here',
            'status' => 200,
            'data' => $products
        ]);
    }
}
