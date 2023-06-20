<?php

namespace App\Http\Controllers;

use App\Models\Trn;
use Illuminate\Http\Request;

class TrnController extends Controller
{
    public function autocomplete(Request $request)
    {
        $data = Trn::select("name as value", "id")
                    ->where('name', 'LIKE', '%'. $request->get('search'). '%')
                    ->get();
    
        return response()->json($data);
    }

    public function show(Trn $trn)
    {
        return response()->json($trn);
    }
}
