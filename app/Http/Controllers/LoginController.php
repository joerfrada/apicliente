<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Exception;
use App\Helpers\DBConnection;

use App\Models\User;


class LoginController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        try
        {
            $db = new DBConnection();
            $db->setConnection($username, $password);

            $model = new User();
            $user = $model->getUser($username);

            return response()->json([
                    "tipo" => 0,
                    "result" => $user
            ]);
        }
        catch (Exception $e)
        {
            if ($e instanceof QueryException)
            {
                $code = $e->getCode();
                if ($code == 1045)
                {
                    return response()->json([
                        "tipo" => -1,
                        "mensaje" => "Usuario y/o Contraseña sean incorrectos"
                    ]);
                }
            }
        }
    }

    protected function changeEnv($data = array()){
        if (count($data) > 0)
        {
            // Read .env-file
            $env = file_get_contents(base_path() . '/.env');

            // Split string on every " " and write into array
            $env = preg_split('/\s+/', $env);;

            // Loop through given data
            foreach((array)$data as $key => $value)
            {
                // Loop through .env-data
                foreach($env as $env_key => $env_value)
                {
                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $env_value, 2);

                    // Check, if new key fits the actual .env-key
                    if($entry[0] == $key){
                        // If yes, overwrite it with the new one
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        // If not, keep the old one
                        $env[$env_key] = $env_value;
                    }
                }
            }

            // Turn the array back to an String
            $env = implode("\n", $env);

            // And overwrite the .env with the new data
            file_put_contents(base_path() . '/.env', $env);
            
            return true;
        }
        else
        {
            return false;
        }
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
