<?php
require 'vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

// Procesar formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $factory = (new Factory)
        ->withServiceAccount(__DIR__.'/serviceAccountKey.json')
        ->withDatabaseUri('https://campus-market-ef7b1-default-rtdb.firebaseio.com/');

    try {
        $auth = $factory->createAuth();
        
        // 1. Autenticar usuario
        $signInResult = $auth->signInWithEmailAndPassword($_POST['email'], $_POST['password']);
        $user = $signInResult->data();
        
        // 2. Iniciar sesión PHP
        session_start();
        $_SESSION['user'] = [
            'uid' => $user['localId'],
            'email' => $user['email']
        ];
        
        // 3. Redirigir al dashboard
        header('Location: dashboard.php');
        exit();

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Campus Market</title>
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

                            <form method="POST" action="login.php">
                                <h2 class="fw-bold mb-4 text-uppercase">Login</h2>
                                <p class="text-white-50 mb-4">Ingresa tus credenciales</p>

                                <!-- Campo Email -->
                                <div class="form-outline form-white mb-4">
                                    <input type="email" name="email" id="email" class="form-control form-control-lg" required />
                                    <label class="form-label" for="email">Email</label>
                                </div>

                                <!-- Campo Contraseña -->
                                <div class="form-outline form-white mb-4">
                                    <input type="password" name="password" id="password" class="form-control form-control-lg" required minlength="6" />
                                    <label class="form-label" for="password">Password</label>
                                </div>

                                <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>

                                <div class="d-flex justify-content-center text-center mt-4 pt-1">
                                    <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                                    <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
                                    <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
                                </div>
                            </form>

                            <div class="mt-3">
                                <p class="mb-0">¿No tienes cuenta? <a href="register.php" class="text-white-50 fw-bold">Regístrate</a></p>
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