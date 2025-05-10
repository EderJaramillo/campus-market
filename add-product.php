<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require 'vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Storage;

// Verificar autenticación
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Conexión a Firebase
$factory = (new Factory)
    ->withServiceAccount(__DIR__.'/serviceAccountKey.json')
    ->withDatabaseUri('https://campus-market-ef7b1-default-rtdb.firebaseio.com/');

$auth = $factory->createAuth();
$user = $auth->getUser($_SESSION['user']['uid']);
$database = $factory->createDatabase();
$storage = $factory->createStorage();

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // 1. Subir imagen a Firebase Storage
        $imageFile = $_FILES['productImage'];
        $storageClient = $storage->getBucket();
        $imagePath = 'products/'.uniqid().'.'.pathinfo($imageFile['name'], PATHINFO_EXTENSION);
        $storageClient->upload(
            file_get_contents($imageFile['tmp_name']),
            ['name' => $imagePath]
        );
        $imageUrl = $storageClient->object($imagePath)->signedUrl(new \DateTime('+10 years'));

        // 2. Guardar datos en Realtime Database
        $newProductRef = $database->getReference('products')->push();
        $newProductRef->set([
            'name' => $_POST['productName'],
            'description' => $_POST['productDescription'],
            'price' => floatval($_POST['productPrice']),
            'category' => $_POST['productCategory'],
            'categoryColor' => $this->getCategoryColor($_POST['productCategory']),
            'image' => $imageUrl,
            'sellerId' => $user->uid,
            'sellerName' => $user->displayName ?? explode('@', $user->email)[0],
            'timestamp' => time(),
            'status' => 'available'
        ]);

        header('Location: dashboard.php?success=product_added');
        exit();

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Función auxiliar para colores de categoría
function getCategoryColor($category) {
    $colors = [
        'Libros' => 'info',
        'Electrónica' => 'warning',
        'Ropa' => 'danger',
        'Muebles' => 'secondary',
        'Transporte' => 'success',
        'Servicios' => 'primary'
    ];
    return $colors[$category] ?? 'primary';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar Producto - Campus Market</title>
    <link href="assets/bootstrap-5.3.4-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .gradient-custom {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .image-preview {
            max-height: 300px;
            object-fit: contain;
        }
    </style>
</head>
<body class="gradient-custom">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg