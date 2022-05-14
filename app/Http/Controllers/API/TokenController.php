<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use App\Services\Checker\Luhn;
use App\Services\Converter\Date;
use App\Services\Encryptor\RSA;
use App\Services\Encryptor\BaseSixtyFour;

class TokenController extends Controller
{
    /**
    * Handles input data from client and returns modified data with additional 'token' field
    * in json format.
    *
    * @param $request - request that contains input data
    * @return mixed
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

        $maskedCardNumber = Str::mask($card_data['pan'], '*', -12, 8);

        $rsa = new RSA();
        $encryptedData = $rsa->encrypt(Date::getTokenExpire());
        $encodedData = BaseSixtyFour::encode($encryptedData);
        Log::info('Token = ' . $encodedData);
        return response()->json(['pan' => $maskedCardNumber, 'token' => $encodedData]);
    }
}
