<?php
session_start();
require 'vendor/autoload.php';

use Kreait\Firebase\Factory;

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

// Obtener productos (ejemplo)
$products = $database->getReference('products')->orderByChild('timestamp')->limitToLast(8)->getValue();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Campus Market</title>
    <link href="assets/bootstrap-5.3.4-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary-color: #6a11cb;
            --secondary-color: #2575fc;
        }
        .navbar-brand img {
            height: 40px;
        }
        .hero-categories {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .product-card .badge {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .avatar {
            width: 40px;
            height: 40px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/img/logo.png" alt="Campus Market" class="d-inline-block align-top">
            </a>
            
            <!-- Search Bar -->
            <div class="d-flex mx-4 flex-grow-1">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Buscar productos...">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <!-- Nav Items -->
            <div class="d-flex align-items-center">
                <a href="#" class="text-dark mx-3">
                    <i class="fas fa-heart fa-lg"></i>
                </a>
                <a href="#" class="text-dark mx-3 position-relative">
                    <i class="fas fa-shopping-cart fa-lg"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        3
                    </span>
                </a>
                <div class="dropdown ms-3">
                    <a href="#" class="dropdown-toggle d-flex align-items-center text-decoration-none" id="userDropdown" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($user->displayName ?? $user->email) ?>&background=random" alt="Avatar" class="rounded-circle avatar me-2">
                        <span class="d-none d-sm-inline"><?= explode('@', $user->email)[0] ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i> Mi perfil</a></li>
                        <li><a class="dropdown-item" href="my-products.php"><i class="fas fa-boxes me-2"></i> Mis productos</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Cerrar sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Categories Bar -->
    <div class="hero-categories py-3 border-bottom">
        <div class="container">
            <div class="d-flex overflow-auto">
                <a href="#" class="text-nowrap mx-2 btn btn-sm btn-outline-primary">Todos</a>
                <a href="#" class="text-nowrap mx-2 btn btn-sm btn-outline-secondary">Libros</a>
                <a href="#" class="text-nowrap mx-2 btn btn-sm btn-outline-success">Electrónica</a>
                <a href="#" class="text-nowrap mx-2 btn btn-sm btn-outline-danger">Ropa</a>
                <a href="#" class="text-nowrap mx-2 btn btn-sm btn-outline-warning">Muebles</a>
                <a href="#" class="text-nowrap mx-2 btn btn-sm btn-outline-info">Transporte</a>
                <a href="#" class="text-nowrap mx-2 btn btn-sm btn-outline-dark">Servicios</a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container my-5">
        <!-- Featured Products -->
        <section class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 fw-bold">Productos destacados</h2>
                <a href="products.php" class="btn btn-sm btn-outline-primary">Ver todos</a>
            </div>
            
            <div class="row g-4">
                <?php if ($products): ?>
                    <?php foreach (array_reverse($products) as $id => $product): ?>
                        <div class="col-md-3">
                            <div class="card product-card h-100 border-0 shadow-sm transition-all">
                                <span class="badge bg-<?= $product['categoryColor'] ?? 'primary' ?>"><?= $product['category'] ?? 'General' ?></span>
                                <img src="<?= $product['image'] ?? 'https://via.placeholder.com/300x200?text=Producto' ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $product['name'] ?></h5>
                                    <p class="text-muted small"><?= substr($product['description'], 0, 60) ?>...</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold text-primary">$<?= number_format($product['price'], 2) ?></span>
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top-0">
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($product['sellerName'] ?? 'Vendedor') ?>&background=random" alt="Vendedor" class="rounded-circle avatar me-2">
                                        <small class="text-muted"><?= $product['sellerName'] ?? 'Vendedor' ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> No hay productos disponibles todavía.
                            <a href="add-product.php" class="alert-link">¡Sé el primero en publicar!</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- How it Works -->
        <section class="bg-light rounded-3 p-5 mb-5">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="fw-bold mb-4">¿Cómo vender en Campus Market?</h2>
                    <ol class="list-group list-group-numbered">
                        <li class="list-group-item bg-transparent border-0">Registra tu producto con fotos claras</li>
                        <li class="list-group-item bg-transparent border-0">Recibe ofertas de otros estudiantes</li>
                        <li class="list-group-item bg-transparent border-0">Acuerda un punto de encuentro en el campus</li>
                    </ol>
                    <a href="add-product.php" class="btn btn-primary mt-3 px-4">
                        <i class="fas fa-plus me-2"></i> Publicar producto
                    </a>
                </div>
                <div class="col-md-6 d-none d-md-block">
                    <img src="https://illustrations.popsy.co/amber/shopping-app.svg" alt="Vender en Campus Market" class="img-fluid">
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="fw-bold mb-3">Campus Market</h5>
                    <p>El marketplace exclusivo para la comunidad universitaria.</p>
                    <div class="social-icons">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="col-md-2 mb-4 mb-md-0">
                    <h6 class="fw-bold">Comprar</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50">Productos</a></li>
                        <li><a href="#" class="text-white-50">Categorías</a></li>
                        <li><a href="#" class="text-white-50">Ofertas</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4 mb-md-0">
                    <h6 class="fw-bold">Vender</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50">Publicar</a></li>
                        <li><a href="#" class="text-white-50">Mis productos</a></li>
                        <li><a href="#" class="text-white-50">Estadísticas</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold">Contacto</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2"></i> hola@campusmarket.edu</li>
                        <li><i class="fas fa-phone me-2"></i> +1 234 567 890</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 bg-secondary">
            <div class="text-center text-white-50 small">
                &copy; <?= date('Y') ?> Campus Market. Todos los derechos reservados.
            </div>
        </div>
    </footer>

    <script src="assets/bootstrap-5.3.4-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>