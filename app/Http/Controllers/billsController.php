<?php

namespace App\Http\Controllers;

use App\Models\bill;
use Illuminate\Http\Request;

class billsController extends Controller
{
    public function show(Request $request)
    {
        $bills = bill::all();
        return response()->json([
            'message' => 'all bills here',
            'status' => 200,
            'data' => $bills,
        ]);
    }
}
