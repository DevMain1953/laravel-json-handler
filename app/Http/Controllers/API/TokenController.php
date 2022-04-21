<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    /**
    * Handles input data from client and returns modified data with additional 'token' field
    * in json format.
    *
    * @param $request - request that contains input data
    */
    public function token(Request $request)
    {
        $req = json_decode($request->getContent(), true);
        $pan = $req['pan'] . " jumpBot";
        $cvc = $req['cvc'];
        $ch = $req['cardholder'];
        $exp = $req['expire'];

        return response()->json(['pan' => $pan, 'cvc' => $cvc, 'ch' => $ch, 'exp' => $exp, ]);
    }
}
