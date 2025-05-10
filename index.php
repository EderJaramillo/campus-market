<?php
// Iniciar sesión si viene del login
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Market - Mercado Universitario</title>
    <link href="assets/bootstrap-5.3.4-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary-color: #6a11cb;
            --secondary-color: #2575fc;
        }
        .hero-gradient {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: 700;
        }
    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-store me-2"></i>Campus Market
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#inicio">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Beneficios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#como-funciona">¿Cómo funciona?</a>
                    </li>
                    <li class="nav-item">
                        <?php if(isset($_SESSION['user'])): ?>
                            <a href="dashboard.php" class="btn btn-outline-light ms-2">
                                <i class="fas fa-user-circle me-1"></i> Mi Cuenta
                            </a>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-outline-light ms-2">
                                <i class="fas fa-sign-in-alt me-1"></i> Iniciar Sesión
                            </a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-gradient text-white py-5" id="inicio">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">El mercado digital de tu universidad</h1>
                    <p class="lead mb-4">Compra, vende e intercambia productos y servicios con la comunidad estudiantil de forma segura y sencilla.</p>
                    <div class="d-flex gap-3">
                        <?php if(isset($_SESSION['user'])): ?>
                            <a href="dashboard.php" class="btn btn-light btn-lg px-4">
                                Ir al Dashboard <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        <?php else: ?>
                            <a href="register.php" class="btn btn-light btn-lg px-4">
                                Regístrate Gratis
                            </a>
                            <a href="#como-funciona" class="btn btn-outline-light btn-lg px-4">
                                <i class="fas fa-play-circle me-2"></i> Ver Demo
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="https://illustrations.popsy.co/amber/digital-nomad.svg" alt="Estudiantes intercambiando productos" class="img-fluid">
                </div>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section class="py-5" id="features">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Beneficios exclusivos</h2>
                <p class="text-muted lead">Diseñado por estudiantes para estudiantes</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 card-hover">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3">
                                <i class="fas fa-hand-holding-usd"></i>
                            </div>
                            <h4>Gana dinero extra</h4>
                            <p class="text-muted">Vende lo que ya no uses y genera ingresos desde tu celular.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 card-hover">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h4>Comunidad verificada</h4>
                            <p class="text-muted">Todos los usuarios son estudiantes con credenciales válidas.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 card-hover">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <h4>Transacciones rápidas</h4>
                            <p class="text-muted">Encuentra compradores o vendedores en tu mismo campus.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How it Works -->
    <section class="bg-light py-5" id="como-funciona">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold">¿Cómo funciona?</h2>
                <p class="text-muted lead">En solo 3 pasos</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="d-flex">
                        <div class="me-4">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <span class="fs-4">1</span>
                            </div>
                        </div>
                        <div>
                            <h4>Regístrate</h4>
                            <p>Crea tu cuenta con tu correo universitario y verifica tu identidad.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="d-flex">
                        <div class="me-4">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <span class="fs-4">2</span>
                            </div>
                        </div>
                        <div>
                            <h4>Publica tus productos</h4>
                            <p>Sube fotos, describe lo que ofreces y fija tu precio.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="d-flex">
                        <div class="me-4">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <span class="fs-4">3</span>
                            </div>
                        </div>
                        <div>
                            <h4>Concreta la venta</h4>
                            <p>Acuerda el punto de encuentro en tu campus y realiza el intercambio.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5 bg-dark text-white">
        <div class="container py-5 text-center">
            <h2 class="fw-bold mb-4">¿Listo para unirte a la comunidad?</h2>
            <p class="lead mb-4">Más de 5,000 estudiantes ya están usando Campus Market en su universidad.</p>
            <a href="<?= isset($_SESSION['user']) ? 'dashboard.php' : 'register.php' ?>" class="btn btn-primary btn-lg px-5">
                <?= isset($_SESSION['user']) ? 'Ir a mi cuenta' : 'Comenzar ahora' ?>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 bg-black text-white-50">
        <div class="container text-center">
            <p class="mb-0">
                &copy; <?= date('Y') ?> Campus Market. Todos los derechos reservados.
            </p>
            <div class="mt-3">
                <a href="#" class="text-white-50 me-3"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-white-50 me-3"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-white-50 me-3"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-white-50"><i class="fab fa-tiktok"></i></a>
            </div>
        </div>
    </footer>

    <script src="assets/bootstrap-5.3.4-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>