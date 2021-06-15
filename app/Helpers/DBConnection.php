<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DBConnection
{
    public function setConnection($username, $password)
    {
        Config::set('database.connections.mysql.database', 'mibase');
        Config::set('database.connections.mysql.username', $username);
        Config::set('database.connections.mysql.password', $password);

        DB::purge('mysql');
        DB::reconnect('mysql');
    }
}