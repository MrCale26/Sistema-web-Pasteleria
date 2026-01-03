<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inicio - Pastelería Dieguito D & M</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap + Iconos + Google Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #fffefc;
      overflow-x: hidden;
    }
    .navbar {
      background-color: #fce6ef;
      box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    }
    .navbar-brand {
      display: flex;
      align-items: center;
    }
    .navbar-brand img {
      height: 45px;
      margin-right: 10px;
    }
    .navbar-brand span {
      font-family: 'Pacifico', cursive;
      font-size: 1.7rem;
      color: #d85e9f;
    }
    .navbar-nav .nav-link {
      color: #333;
      font-weight: 500;
    }
    .navbar-nav .nav-link:hover {
      color: #d85e9f;
    }
    .btn-login-icon {
      color: #d85e9f;
      font-weight: 500;
      display: flex;
      align-items: center;
      text-decoration: none;
    }
    .btn-login-icon i {
      font-size: 1.4rem;
      margin-right: 6px;
    }
    .btn-login-icon:hover {
      text-decoration: underline;
    }
    .hero-video video {
      width: 100%;
      height: auto;
      display: block;
      object-fit: cover;
    }
    .hero {
      background: linear-gradient(135deg, #fbe8f2, #fbd4e5);
      padding: 4rem 2rem;
      text-align: center;
      animation: fadeIn 1.8s ease;
    }
    .hero h1 {
      font-size: 2.8rem;
      color: #d85e9f;
      font-weight: bold;
    }
    .hero p {
      font-size: 1.2rem;
      color: #444;
    }
    .search-bar {
      background-color: #fffafc;
      padding: 1.5rem;
      margin-top: -40px;
      margin-bottom: 2rem;
      box-shadow: 0 5px 20px rgba(0,0,0,0.06);
      border-radius: 1rem;
      z-index: 10;
      position: relative;
    }
    .seccion-productos h2,
    #nosotros h2,
    #contacto h3 {
      color: #d85e9f;
      font-weight: 700;
    }
    .card img {
      width: 100%;
      height: auto;
      max-height: 300px;
      object-fit: contain;
      background-color: #fff;
      border-radius: 1rem 1rem 0 0;
    }
    .contacto {
      background-color: #fffafc;
      padding: 2rem;
      border-radius: 1rem;
      margin-top: 4rem;
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
    }
    .promo-carousel {
      margin: 1.5rem auto 2rem;
      max-width: 1100px;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    .promo-carousel img {
      object-fit: cover;
      height: 300px;
    }
    .second-header {
      background-color: #fff1f7;
      box-shadow: 0 1px 4px rgba(0,0,0,0.05);
      position: sticky;
      top: 56px;
      z-index: 999;
    }
    .second-header ul {
      display: flex;
      justify-content: center;
      gap: 2rem;
      list-style: none;
      margin: 0;
      padding: 0.6rem 0;
    }
    .second-header a {
      text-decoration: none;
      font-weight: 500;
      color: #c94c8f;
      transition: color 0.3s;
    }
    .second-header a:hover {
      color: #a83872;
    }
    .second-header i {
      margin-right: 6px;
    }

        .precio-original {
      text-decoration: line-through;
      color: #999;
      font-size: 0.9rem;
      margin-left: 0.5rem;
    }
    .precio-promocion {
      color: #c70039;
      font-weight: bold;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <img src="assets/img/logo.png" alt="Logo">
      <span>Dieguito D & M</span>
    </a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
      <a href="index.php?controller=Usuario&action=login" class="btn-login-icon me-3">
        <i class="bi bi-person-circle"></i>
        <?= isset($_SESSION['usuario']) ? htmlspecialchars($_SESSION['usuario']['nombre']) : 'Hola, inicia sesión' ?>
      </a>
    </div>
  </div>
</nav>

<!-- SEGUNDO HEADER -->
<div class="second-header">
  <ul>
    <li><a href="index.php"><i class="bi bi-house-door"></i>Inicio</a></li>
    <li><a href="index.php?controller=Producto&action=catalogo"><i class="bi bi-box-seam"></i>Catálogo</a></li>
    <li><a href="index.php?controller=Home&action=nosotros"><i class="bi bi-people"></i>Nosotros</a></li>
    <li><a href="index.php?controller=Home&action=contacto"><i class="bi bi-envelope"></i>Contáctanos</a></li>
  </ul>
</div>

<!-- CARRUSEL -->
<div id="carouselPromo" class="carousel slide promo-carousel" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="assets/img/promos/promo1.png" class="d-block w-100" alt="Promoción 1">
    </div>
    <div class="carousel-item">
      <img src="assets/img/promos/promo2.png" class="d-block w-100" alt="Promoción 2">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselPromo" data-bs-slide="prev">
    <span class="carousel-control-prev-icon bg-dark rounded-circle"></span>
    <span class="visually-hidden">Anterior</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselPromo" data-bs-slide="next">
    <span class="carousel-control-next-icon bg-dark rounded-circle"></span>
    <span class="visually-hidden">Siguiente</span>
  </button>
</div>

<!-- BÚSQUEDA -->
<section class="container search-bar">
  <form method="GET" action="index.php" class="row justify-content-center g-2">
    <input type="hidden" name="controller" value="Producto">
    <input type="hidden" name="action" value="catalogo">
    <div class="col-md-4">
      <select name="categoria_id" class="form-select">
        <option value="">Todas las categorías</option>
        <?php foreach ($categorias as $cat): ?>
          <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-4">
      <input type="text" name="query" class="form-control" placeholder="Buscar producto...">
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-success w-100"><i class="bi bi-search"></i> Buscar</button>
    </div>
  </form>
</section>

<!-- PRODUCTOS -->
<!-- PRODUCTOS DESTACADOS (SOLO VISTA) -->
<section class="container my-5">
  <h2 class="text-center text-uppercase mb-4 text-secondary animate__animated animate__fadeInDown" style="font-family:'Pacifico', cursive;"> Productos Destacados</h2>
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
    <?php foreach ($destacados as $producto): ?>
      <div class="col animate__animated animate__zoomIn">
        <div class="card h-100 shadow-sm border-0 rounded-4 bg-white">
          <img src="uploads/<?= htmlspecialchars($producto['imagen']) ?>" class="card-img-top p-3 rounded-top-4" style="height: 220px; object-fit: contain;">
          <div class="card-body text-center">
            <h5 class="card-title fw-bold" style="font-family:'Pacifico', cursive;"><?= htmlspecialchars($producto['nombre']) ?></h5>
            <p class="card-text small text-muted"><?= htmlspecialchars($producto['descripcion']) ?></p>
            <p class="mb-2 fs-5 text-success fw-bold">S/ <?= number_format($producto['precio'], 2) ?></p>
            <a href="index.php?controller=Usuario&action=login" class="btn btn-outline-secondary btn-sm px-3 rounded-pill shadow-sm">
              <i class="bi bi-box-arrow-in-right"></i> Inicia sesión
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>


<!-- PROMOCIONES ESPECIALES -->
<section class="container my-5">
  <h2 class="text-center text-uppercase mb-4 text-secondary animate__animated animate__fadeInDown" style="font-family:'Pacifico', cursive;">Promociones Especiales</h2>
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
    <?php foreach ($promociones as $producto): ?>
      <div class="col animate__animated animate__zoomIn">
        <div class="card h-100 shadow-sm border-0 rounded-4 bg-white card-producto">
          <img src="uploads/<?= htmlspecialchars($producto['imagen']) ?>" class="card-img-top p-3 rounded-top-4" style="height: 220px; object-fit: contain;">
          <div class="card-body text-center">
            <h5 class="card-title fw-bold" style="font-family:'Pacifico', cursive;"><?= htmlspecialchars($producto['nombre']) ?></h5>
            <p class="card-text small text-muted"><?= htmlspecialchars($producto['descripcion']) ?></p>
            <p class="mb-2">
              <span class="fs-5 precio-promocion">S/ <?= number_format($producto['precio'], 2) ?></span>
              <?php if (!empty($producto['precio_original']) && $producto['precio_original'] > $producto['precio']): ?>
                <span class="precio-original">S/ <?= number_format($producto['precio_original'], 2) ?></span>
              <?php endif; ?>
            </p>
            <a href="index.php?controller=Usuario&action=login" class="btn btn-outline-secondary btn-sm px-3 rounded-pill shadow-sm">
              <i class="bi bi-box-arrow-in-right"></i> Inicia sesión
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>


<!-- VIDEO -->
<section class="hero-video my-4 py-3 text-center" style="background-color: #fffdf9;">
  <div style="display: flex; justify-content: center;">
    <video autoplay muted loop playsinline style="max-height: 400px; width: auto;">
      <source src="videos/banner_animado.mp4" type="video/mp4">
      Tu navegador no soporta video HTML5.
    </video>
  </div>
</section>


<?php include 'views/layouts/footer.php'; ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
