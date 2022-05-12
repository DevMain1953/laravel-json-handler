<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use App\Services\Checker\Luhn;
use App\Services\Converter\Date;
use Illuminate\Support\Facades\Log;

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
        $card_data = json_decode($request->getContent(), true);

        // Converts date for validator
        $card_data['expire'] = Date::convert($card_data['expire']);

        $validator = Validator::make($card_data, [
            'pan' => 'required|numeric|digits:16',
            'cvc' => 'required|numeric|digits:3',
            'cardholder' => 'required|string',
            'expire' => 'required|date_format:d-m-Y'
        ]);

        if ($validator->fails()) {
            Log::info('Validator errors.');
            return response()->json($validator->errors());
        }

        if (Luhn::check($card_data['pan']) == 0) {
            Log::info('Card number is invalid.');
            return response()->json(['message' => '400 Bad Request - Card number is invalid']);
        }

        return response()->json(['pan' => $card_data['pan'], 'token' => Date::getTokenExpire()]);
    }
}
