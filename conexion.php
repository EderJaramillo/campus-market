<?php
require 'vendor/autoload.php';

use Kreait\Firebase\Factory;

$factory = (new Factory)
    ->withServiceAccount('serviceAccountKey.json')
    ->withDatabaseUri('https://campus-market-ef7b1-default-rtdb.firebaseio.com/'); // Reemplaza con tu URL

$database = $factory->createDatabase();

// Escribe un dato de prueba
$database->getReference('prueba')->set([
    'mensaje' => '¡Funciona!',
    'fecha' => date('Y-m-d H:i:s')
]);

echo "🔥 Datos guardados en Firebase!";
?>