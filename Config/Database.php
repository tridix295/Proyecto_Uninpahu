<?php
use Illuminate\Database\Capsule\Manager as Capsule;

//Inicializamos las variables de configuracion en el archivo .env
$env = parse_ini_file("../.env");

$capsule = new Capsule;

$capsule->addConnection([
        'driver'    => $env['DBDRIVER'],
        'host'      => $env['DBSERVER'],
        'port'      => $env['DBPORT'],
        'database'  => $env['DBNAME'],
        'username'  => $env['DBUSER'],
        'password'  => $env['DBPASS'],
        'charset'   => $env['CHARSET'],
        'collation' => $env['COLLATION'],
        'prefix'    => ''
    ]);
    try {
        $capsule->bootEloquent();
    } catch (\Exception $e) {
        echo "Error al conectar con la base de datos: " . $e->getMessage();
        die();
    }
?>