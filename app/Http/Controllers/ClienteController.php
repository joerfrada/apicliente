<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Helpers\DBConnection;
use Exception;

use App\Models\Cliente;

class ClienteController extends Controller
{
    //
    public function getClientes(Request $request)
    {
        try
        {
            $model = new Cliente();
            $clientes = $model->getClientes($request);

            return response()->json([
                "tipo" => 0,
                "result" => $clientes
            ]);
        }
        catch (Exception $e)
        {
            if ($e instanceof QueryException)
            {
                return response()->json([
                    "tipo" => -1,
                    "mensaje" => $e->getMessage()
                ]);
            }
        }
    }
}
