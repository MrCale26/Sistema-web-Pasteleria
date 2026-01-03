<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel Cliente - Pastelería Dieguito D & M</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap + Iconos + Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fffefc;
      overflow-x: hidden;
    }
    .navbar {
      background-color: #fdeef4;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .navbar-brand {
      display: flex;
      align-items: center;
      font-family: 'Pacifico', cursive;
      color: #d85e9f;
      font-size: 1.7rem;
    }
    .navbar-brand img {
      height: 45px;
      margin-right: 10px;
    }
    .navbar-nav .nav-link {
      color: #444;
      font-weight: 500;
    }
    .navbar-nav .nav-link:hover {
      color: #d85e9f;
    }
    .dropdown-menu {
      min-width: 200px;
    }
    .form-control::placeholder {
      font-size: 0.95rem;
    }
    .floating-cart {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background-color: #d85e9f;
      color: white;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      z-index: 999;
      transition: transform 0.3s ease;
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
    .floating-cart:hover {
      transform: scale(1.1);
    }

    .second-header {
      position: sticky;
      top: 60px;
      z-index: 998;
      background-color: #fff1f7;
      padding: 0.6rem 0;
      box-shadow: 0 1px 5px rgba(0,0,0,0.05);
    }
    .second-header ul {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin: 0;
      padding: 0;
      list-style: none;
    }
    .second-header a {
      text-decoration: none;
      color: #c94c8f;
      font-weight: 500;
      transition: color 0.3s;
    }
    .second-header a:hover {
      color: #a62c7c;
    }
    .icon-btn {
      position: relative;
      margin-right: 10px;
      background: none;
      border: none;
      font-size: 1.5rem;
      color: #a62c7c;
      cursor: pointer;
    }
    .icon-btn:hover {
      color: #a62c7c;
    }
    .cart-preview {
      position: absolute;
      top: 40px;
      right: 0;
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 0.5rem;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      width: 300px;
      z-index: 1000;
      display: none;
    }
    .cart-preview.active {
      display: block;
    }
    .nombre-usuario {
      margin-right: 10px;
      font-weight: 500;
      color: #d85e9f;
    }
    .card-producto:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
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
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <img src="assets/img/logo.png" alt="Logo">
      Dieguito D & M
    </a>

    <!-- Buscador -->
    <form class="d-flex mx-auto w-50" method="GET" action="index.php">
      <input type="hidden" name="controller" value="Producto">
      <input type="hidden" name="action" value="catalogo">
      <div class="input-group w-100 shadow-sm">
        <input class="form-control border-end-0" type="search" name="query" placeholder="Buscar productos...">
        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
      </div>
    </form>
    <!-- Botones e íconos -->
<ul class="navbar-nav ms-auto align-items-center">

  <!-- Botón Mis Pedidos con ícono -->
  <li class="nav-item">
    <button class="icon-btn position-relative" onclick="window.location.href='index.php?controller=Usuario&action=misPedidos'">
      <i class="bi bi-truck"></i>
    </button>
  </li>

  <!-- Carrito flotante -->
  <li class="nav-item position-relative">
    <button class="icon-btn" onclick="document.getElementById('cartPreview').classList.toggle('active')">
      <i class="bi bi-cart"></i>
    </button>
    <div id="cartPreview" class="cart-preview p-3">
      <p class="mb-2 fw-bold text-center">🛍 Tu Carrito</p>

      <?php if (!empty($_SESSION['carrito'])): ?>
        <div id="cartItems" style="max-height: 250px; overflow-y: auto;">
          <?php foreach ($_SESSION['carrito'] as $id => $item): ?>
            <div class="d-flex align-items-center mb-2 border-bottom pb-2 bg-light rounded px-2 py-1 shadow-sm">
              <img src="uploads/<?= rawurlencode($item['imagen'] ?? 'noimg.jpg') ?>" alt="" width="45" height="45" class="rounded me-2" style="object-fit: cover; background: #fff4f8;">
              <div class="flex-grow-1">
                <div class="fw-semibold small text-dark"> <?= htmlspecialchars($item['nombre']) ?> </div>
                <div class="d-flex align-items-center">
                  <button class="btn btn-sm btn-outline-danger py-0 px-2 btn-restar" data-id="<?= $id ?>">−</button>
                  <span class="mx-2"> <?= $item['cantidad'] ?> </span>
                  <button class="btn btn-sm btn-outline-primary py-0 px-2 btn-sumar" data-id="<?= $id ?>">+</button>
                </div>
              </div>
              <div class="text-end small fw-semibold text-success ms-2">
                S/ <?= number_format($item['precio'] * $item['cantidad'], 2) ?>
              </div>
              <button class="btn btn-sm btn-outline-danger ms-2 btn-eliminar-item" data-id="<?= $id ?>" title="Eliminar del carrito">
                <i class="bi bi-trash-fill"></i>
              </button>
            </div>
          <?php endforeach; ?>
        </div>

        <hr>
        <div class="text-end fw-bold mb-2 text-dark">
          Total:
          <span id="cartTotal" class="text-danger">
            S/ <?= number_format(array_reduce($_SESSION['carrito'], fn($c, $i) => $c + $i['precio'] * $i['cantidad'], 0), 2) ?>
          </span>
        </div>
        <a href="index.php?controller=Carrito&action=ver" class="btn w-100 shadow-sm" style="background-color:#d85e9f; color: white;">
          <i class="bi bi-eye"></i> Ver carrito completo
        </a>
      <?php else: ?>
        <div class="text-muted small text-center">Tu carrito está vacío.</div>
      <?php endif; ?>
    </div>
  </li>

  <!-- Perfil de usuario -->
  <li class="nav-item dropdown d-flex align-items-center">
    <span class="nombre-usuario">Hola, <?= explode(' ', htmlspecialchars($_SESSION['usuario']['nombre']))[0] ?></span>
    <a class="nav-link dropdown-toggle" href="#" id="perfilDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 1.5rem; color: #d85e9f;">
      <i class="bi bi-person-circle"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="perfilDropdown">
      <li><h6 class="dropdown-header"><?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></h6></li>
      <li><a class="dropdown-item" href="#">Notificaciones</a></li>
      <li><a class="dropdown-item" href="#">Cambiar de cuenta</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item text-danger" href="index.php?controller=Usuario&action=logout">Cerrar sesión</a></li>
    </ul>
  </li>

</ul>

    
  </div>
</nav>

<!-- Script para ocultar la previsualización del carrito al hacer clic fuera -->
<script>
  document.addEventListener('click', function(event) {
  const preview = document.getElementById('cartPreview');
  const isCartBtn = event.target.closest('.icon-btn');
  const isInsideCart = event.target.closest('#cartPreview');

  if (!isCartBtn && !isInsideCart) {
    preview.classList.remove('active');
  }
});

</script>


<!-- SEGUNDO HEADER STICKY -->
<div class="second-header">
  <ul>
    <li><a class="icon-link" href="index.php"><i class="bi bi-house-door"></i> Inicio</a></li>
    <li><a class="icon-link" href="index.php?controller=Producto&action=catalogo"><i class="bi bi-box-seam"></i> Catálogo</a></li>
    <li><a class="icon-link" href="index.php?controller=Usuario&action=nosotros"><i class="bi bi-people"></i> Nosotros</a></li>
    <li class="nav-item">
  <a class="nav-link" href="index.php?controller=Home&action=contacto">Contáctanos</a>
</li>
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

<!-- PRODUCTOS DESTACADOS -->
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
            <a href="index.php?controller=Carrito&action=agregar&id=<?= $producto['id'] ?>" class="btn btn-outline-success btn-sm px-3 rounded-pill shadow-sm">
              <i class="bi bi-cart-plus"></i> Agregar
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>


<!-- PROMOCIONES -->

<!-- ACTUALIZAR LAS TARJETAS DE PROMOCIÓN -->
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
            <a href="index.php?controller=Carrito&action=agregar&id=<?= $producto['id'] ?>" class="btn btn-outline-danger btn-sm px-3 rounded-pill shadow-sm">
              <i class="bi bi-cart-plus"></i> Agregar
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>


<!-- BOTÓN FLOTANTE -->
<a href="index.php?controller=Carrito&action=ver" class="floating-cart">
  <i class="bi bi-cart3 fs-4"></i>
</a>

<!-- VIDEO COMPLETO SIN RECORTAR -->
<section class="hero-video my-4 py-3 text-center" style="background-color: #fffdf9;">
  <video autoplay muted loop playsinline style="max-height: 400px; width: auto;">
    <source src="videos/banner_animado.mp4" type="video/mp4">
    Tu navegador no soporta video HTML5.
  </video>
</section>

<!-- FOOTER -->
<?php include 'views/layouts/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>




<script>
  // Botones de + y −
  function activarBotonesCarrito() {
    document.querySelectorAll('.btn-sumar, .btn-restar').forEach(btn => {
      btn.addEventListener('click', e => {
        const id = btn.dataset.id;
        const accion = btn.classList.contains('btn-sumar') ? 'sumar' : 'restar';

        fetch('index.php?controller=Carrito&action=modificarAjax', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: `id=${id}&accion=${accion}`
        })
        .then(res => res.text())
        .then(html => {
          document.getElementById('cartPreview').innerHTML = html;
          activarBotonesCarrito();
          activarBotonesEliminar();
        });
      });
    });
  }

  // Botón eliminar 🗑
  function activarBotonesEliminar() {
    document.querySelectorAll('.btn-eliminar-item').forEach(btn => {
      btn.addEventListener('click', () => {
        const id = btn.dataset.id;

        fetch('index.php?controller=Carrito&action=eliminarAjax', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: `id=${id}`
        })
        .then(res => res.text())
        .then(html => {
          document.getElementById('cartPreview').innerHTML = html;
          activarBotonesCarrito();
          activarBotonesEliminar();
        });
      });
    });
  }

  // Agregar al carrito
  document.querySelectorAll('.form-agregar-carrito').forEach(form => {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      const id = form.dataset.id;

      fetch('index.php?controller=Carrito&action=agregarAjax', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}`
      })
      .then(res => res.text())
      .then(html => {
        document.getElementById('cartPreview').innerHTML = html;
        activarBotonesCarrito();
        activarBotonesEliminar();
      });
    });
  });

  // Iniciar todo
  activarBotonesCarrito();
  activarBotonesEliminar();

  <!-- Scripts Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</script>
</html>
