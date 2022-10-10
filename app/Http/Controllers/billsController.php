<?php

namespace App\Http\Controllers;

use App\Models\bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class billsController extends Controller
{
    public function show(Request $request)
    {
        if(!Auth::guard('api')->user()){
            return response()->json([
                'message' => 'you can not do this !'
            ]);
        }
        $bills = bill::all();
        return response()->json([
            'message' => 'all bills here',
            'status' => 200,
            'data' => $bills,
        ]);
    }
}
