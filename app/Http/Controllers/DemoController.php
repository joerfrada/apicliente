<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class DemoController extends Controller
{
    //
    public function getEncrypt()
    {
        $value = Crypt::encryptString('hola');

        return response()->json([
            'tipo' => 0,
            'secret' => $value
        ]);
    }

    public function getDecrypt(Request $request)
    {
        $secret = $request->input("secret");

        try {
            $value = Crypt::decryptString($secret);
            return response()->json([
                'tipo' => 0,
                'mensaje' => $value
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'tipo' => -1,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
}
