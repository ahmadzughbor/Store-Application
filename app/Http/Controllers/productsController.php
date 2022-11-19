<?php

namespace App\Http\Controllers;

use App\Models\bill;
use App\Models\product;
use App\Models\productImage;
use App\Models\returns;
use App\Models\sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class productsController extends Controller
{
    public function add(Request $request)
    {
        if(!Auth::guard('api')->user()){
            return response()->json([
                'message' => 'you can not do this !'
            ]);
        }
        $request->validate([
            'name'=>'required',
            'Purchasing_price'=>'required',
            'selling_price'=>'required',
            'Quantity'=>'required',
            'billnum'=>'required',
            'Quantity_price' =>'required',
        ]);
        $user_name=Auth::guard('api')->user()->name;// اسم المستخدم
        $request->merge([
            'user_name' => $user_name,
        ]);
        $prods = product::all();
        // $Quantity_price = $request->Quantity * $request->price;///السعر الكامل للمنتج المضاف
        $ar=$prods->pluck('name')->toArray();
        $imagepath = null;
        if(in_array($request->name , $ar))
        {
            $prod = product::where('name' ,$request->name)->first();
            $prod->update([
                'user_name' => $user_name,
                'Quantity' => $request->Quantity + $prod->Quantity,
                'selling_price'=>$request->selling_price
                ]);
                // $imagepath = $prod->images()->path;
        }else{
            $prod = product::create($request->all());
            if ($file = $request->file('file')) {
                $path = $file->store('public/files');
                $name = $file->getClientOriginalName();
                //store your file into directory and db
                $save = new productImage();
                $save->product_id = $prod->id;
                $save->name = $name;
                $save->path= $path;
                $save->save();
                // $imagepath = $prod->images()->path;
        }else{
            $path = storage_path('public/files/no_image');
            $name = 'no_image';
            $save = new productImage();
            $save->product_id = $prod->id;
            $save->name = $name;
            $save->path= $path;
            $save->save();
        }
    }
        bill::create([
            'user_name' => $user_name,
            'product_name' => $request->name,
            'Quantity_price'=> $request->Quantity_price,
            'billnum'=> $request->billnum,
            'Quantity' => $request->Quantity,
            // 'Quantity_price' => $Quantity_price,
        ]);
        $productbills = bill::where('billnum',$request->billnum)->get();
        return response()->json([
            'message' =>'products added succsesfully',
            'status'=>'200',
            'data'=>[
                'product'=>  $prod ,
                'product image' =>  $prod->images()->pluck('path')->toArray() ,
                'bill' => $productbills,
            ],
        ]);

    }


    public function allProduct (Request $request)
    {
        if(!Auth::guard('api')->user()){
            return response()->json([
                'message' => 'you can not do this !'
            ]);
        }
        $products = product::with('images')->paginate();
        $allQuantity = product::all()->pluck('Quantity')->toArray();
        $allSales = sale::all()->pluck('fullPrice')->toArray();
        $salesInf = sale::all();
        $returnsInf = returns::all();
        $salesnames = sale::all()->pluck('name');
        $allreturns = returns::all()->pluck('fullPrice')->toArray();
        //////////////////////////////////////////////////////
        $i = 0;
        $Full_purchase_price = 0;
        $full_sales_price = 0;
        $full_returns_price = 0;
        $full_profit =0;
        $withoutprofit =0;
        $contQuantity = 0;
        $returnsProfit = 0;
        /////////////////////////////////////////////////////
        foreach($allQuantity as $q){
            $contQuantity+= $q;
        }
        foreach($allSales as $q){
            $full_sales_price+= $q;
        }
        foreach($allreturns as $q){///////get price for all returns
            $full_returns_price+= $q;
        }
        foreach($salesInf as $q){///////get price for all sales
            $full_profit+= $q->price * $q->Quantity;
            $withoutprofit+= product::where('name',$q->name)->first()->Purchasing_price * $q->Quantity;
        }
        foreach($returnsInf as $q){///////get price for all returns
            $returnsProfit = (product::where('name',$q->name)->first()->selling_price  -  product::where('name',$q->name)->first()->Purchasing_price ) * $q->Quantity ;
        }



        /////////////////////////////////////////////////////
        return response()->json([
            'message' => 'all products is here',
            'status' => 200,
            'data' => [
                'all Quantity in Store' => $contQuantity,
                'full sales price' => $full_sales_price,
                'full returns price' => $full_returns_price,
                'full profit for sales'=>($full_profit - $withoutprofit)-$returnsProfit ,
                'Full purchase price for sales' =>$withoutprofit,
                'all products'=> $products,
                ]
        ]);
    }
}
