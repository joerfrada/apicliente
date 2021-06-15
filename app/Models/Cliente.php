<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Cliente extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "app_clientes";

    protected $fillable = [
        'nombres', 'apellidos', 'ciudad', 'salario'
    ];

    public function getClientes(Request $request = null)
    {
        if ($request == null)
        {
            return DB::select("call pr_clientes()");
        }
        else {
            $filtro_ini = $request->input('filtro');
            $filtro_fin = $filtro_ini + 200;
            $filtro_texto = $request->input('filtro_texto');
            return DB::select("call pr_get_app_clientes(?,?,?)", array($filtro_ini, $filtro_fin, $filtro_texto));
        }
    }
}
