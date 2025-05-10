<?php
// Incluimos el autoload de Composer al inicio para manejar sesiones/errores
require 'vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

// Procesamiento del formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $factory = (new Factory)
        ->withServiceAccount(__DIR__.'/serviceAccountKey.json')
        ->withDatabaseUri('https://campus-market-ef7b1-default-rtdb.firebaseio.com/');

    try {
        $auth = $factory->createAuth();
        $database = $factory->createDatabase();

        // 1. Crear usuario en Authentication
        $user = $auth->createUserWithEmailAndPassword($_POST['email'], $_POST['password']);

        // 2. Guardar datos adicionales en Realtime Database
        $database->getReference('users/'.$user->uid)->set([
            'nombre' => $_POST['name'],
            'email' => $_POST['email'],
            'rol' => 'estudiante',
            'fecha_registro' => date('Y-m-d H:i:s')
        ]);

        // Redirigir a login con éxito
        header('Location: login.php?registro=exitoso');
        exit();

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Campus Market</title>
    <link href="assets/bootstrap-5.3.4-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .gradient-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card {
            backdrop-filter: blur(10px);
            background: rgba(0, 0, 0, 0.5) !important;
        }
    </style>
</head>
<body class="gradient-custom">
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <!-- Mostrar errores -->
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger">
                                    <?= htmlspecialchars($error) ?>
                                </div>
                            <?php endif; ?>

                            <form method="POST" action="register.php">
                                <h2 class="fw-bold mb-4 text-uppercase">Registro</h2>
                                <p class="text-white-50 mb-4">Crea tu cuenta como estudiante</p>

                                <!-- Campo Nombre -->
                                <div class="form-outline form-white mb-4">
                                    <input type="text" name="name" id="name" class="form-control form-control-lg" required />
                                    <label class="form-label" for="name">Nombre Completo</label>
                                </div>

                                <!-- Campo Email -->
                                <div class="form-outline form-white mb-4">
                                    <input type="email" name="email" id="email" class="form-control form-control-lg" required />
                                    <label class="form-label" for="email">Email Universitario</label>
                                </div>

                                <!-- Campo Contraseña -->
                                <div class="form-outline form-white mb-4">
                                    <input type="password" name="password" id="password" class="form-control form-control-lg" required minlength="6" />
                                    <label class="form-label" for="password">Contraseña (mínimo 6 caracteres)</label>
                                </div>

                                <button class="btn btn-outline-light btn-lg px-5" type="submit">Registrarse</button>

                                <div class="d-flex justify-content-center text-center mt-4 pt-1">
                                    <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                                    <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
                                    <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
                                </div>
                            </form>

                            <div class="mt-3">
                                <p class="mb-0">¿Ya tienes cuenta? <a href="login.php" class="text-white-50 fw-bold">Inicia sesión</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="assets/bootstrap-5.3.4-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>