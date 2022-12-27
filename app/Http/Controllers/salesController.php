<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\returns;
use App\Models\sale;
use App\Models\storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class salesController extends Controller
{
    public function sale(Request $request)
    {
        if(!Auth::guard('api')->user()){
            return response()->json([
                'message' => 'you can not do this !'
            ]);
        }
        $request->validate([
            'price'=> 'required',
            'Quantity'=> 'required',
            // 'fullPrice'=> 'required',
            'product_id'=> 'required',
            'billnum'=> 'required',
        ]);
        $prosale = storage::where('product_id',$request->product_id)->first();
        if(!$prosale){
            return response()->json([
                'message' => 'cant do it',
                'status' => 401,
                'data' =>[],
            ]);
        }
        if($prosale->Quantity < $request->Quantity){
            return response()->json([
                'message' => 'There is not enough quantity',
                'status' => 200,
                'data' =>[],
            ]);
        }
        $user_name = Auth::guard('api')->user()->name;
        // $fullPrice = $request->price * $request->Quantity;
        $request->merge([
            'user_name' =>$user_name,
            // 'fullPrice' => $fullPrice,
        ]);
        $Psale = sale::create($request->all());
        $bill = sale::where('billnum',$request->billnum)->get();
        // // $prosale = product::all()->public('name')->toArray();
        // $prosale = product::where('name',$request->name)->first();
        $prosale->update([
            'user_name' => $user_name,
            'Quantity' => $prosale->Quantity - $request->Quantity,
        ]);
        return response()->json([
            'message' => ' done product sale  ',
            'status' => 200,
            'data' => [
                'bill'=>$bill,
                'product sale' =>$Psale
            ]
        ]);
    }



    public function returns (Request $request)
    {
        if(!Auth::guard('api')->user()){
            return response()->json([
                'message' => 'you can not do this !'
            ]);
        }
        $request->validate([
            'price'=> 'required',
            'Quantity'=> 'required',
            'product_id'=> 'required',
            'billnum'=> 'required',
        ]);
        // $fullPrice = $request->price * $request->Quantity;
        $user_name =Auth::guard('api')->user()->name;
        $request->merge([
            'user_name' =>$user_name,
            // 'fullPrice' => $fullPrice,
        ]);
        $proreturn = storage::where('product_id',$request->product_id)->first();
        if(!$proreturn){
            return response()->json([
                'message' => 'product not found'
            ]);
        }

        $productR = returns::create($request->all());
        $bill = returns::where('billnum',$request->billnum)->paginate();//الفاتورة

        $proreturn->update([
            'user_name' =>$user_name,
            'Quantity' => $proreturn->Quantity + $request->Quantity,
        ]);

        return response()->json([
            'message' => 'product return  done ',
            'status' => 200,
            'data' => [
                'bill'=>$bill,
                'product return' => $productR
            ]
        ]);
    }




    public function allSales(Request $request)
    {
        if(!Auth::guard('api')->user()){
            return response()->json([
                'message' => 'you can not do this !'
            ]);
        }
        $allSales = sale::paginate();
        // $total = sale::all();
        // $totalq = sale::all()->pluck('Quantity')->toArray();
        $salestotal = 0;
        foreach($allSales as $t){
            $salestotal+= $t->price * $t->Quantity;
        }
        return response()->json([
            'message' => 'all sales',
            'status' => 200,
            'data' => [
                'total sales price' =>$salestotal,
                ' all sales' => $allSales,
            ]
        ]);
    }




    public function allReturns(Request $request)
    {
        if(!Auth::guard('api')->user()){
            return response()->json([
                'message' => 'you can not do this !'
            ]);
        }
        $allReturns = returns::paginate();
        $total = returns::all()->pluck('price')->toArray();
        $returntotal = 0;
        foreach($allReturns as $t){
            $returntotal+= $t->price * $t->Quantity;
        }
        return response()->json([
            'message' => 'all returns',
            'status' => 200,
            'data' => [
                'total returns  price' =>$returntotal,
                ' all returns' => $allReturns,
            ]
        ]);
    }
}
