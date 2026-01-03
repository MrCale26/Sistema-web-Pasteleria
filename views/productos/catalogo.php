<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php $productos = $productos ?? []; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Catálogo - Dieguito D & M</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Estilos y fuentes -->
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
      font-family: 'Pacifico', cursive;
      color: #d85e9f;
      font-size: 1.7rem;
      display: flex;
      align-items: center;
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
    .second-header {
      background-color: #fff1f7;
      box-shadow: 0 1px 5px rgba(0,0,0,0.05);
      padding: 0.6rem 0;
      position: sticky;
      top: 60px;
      z-index: 998;
    }
    .second-header ul {
      display: flex;
      justify-content: center;
      gap: 30px;
      list-style: none;
      margin: 0;
      padding: 0;
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
    .cart-preview {
      position: absolute;
      top: 100%;
      right: 0;
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 0.5rem;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      width: 300px;
      z-index: 1000;
      display: none;
      max-height: 80vh;
      overflow-y: auto;
    }
    .cart-preview.active {
      display: block;
    }
    .card {
      border: none;
      border-radius: 1rem;
      transition: all 0.3s ease;
    }
    .card:hover {
      transform: translateY(-6px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
    }
    .card img {
      max-height: 220px;
      object-fit: contain;
      padding: 1rem;
      border-radius: 1rem 1rem 0 0;
      background-color: #fff;
    }
    .btn-login-icon {
      color: #d85e9f;
      font-weight: 500;
      text-decoration: none;
      display: flex;
      align-items: center;
    }
    .btn-login-icon i {
      font-size: 1.4rem;
      margin-right: 6px;
    }
    .btn-login-icon:hover {
      text-decoration: underline;
    }
    .nombre-usuario {
      margin-right: 10px;
      font-weight: 500;
      color: #d85e9f;
    }
    .icon-btn {
      border: none;
      background: none;
      font-size: 1.5rem;
      color: #a62c7c;
      margin-right: 10px;
    }
    .icon-btn:hover {
      color: #c94c8f;
    }
    #cartPreview .btn {
      font-size: 0.9rem;
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

    <!-- Iconos usuario, carrito, pedidos -->
    <ul class="navbar-nav ms-auto align-items-center">
      <!-- Pedidos -->
      <li class="nav-item">
        <?php if (isset($_SESSION['usuario'])): ?>
          <button class="icon-btn" onclick="window.location.href='index.php?controller=Usuario&action=misPedidos'">
            <i class="bi bi-truck"></i>
          </button>
        <?php else: ?>
          <a class="icon-btn" href="index.php?controller=Usuario&action=login"><i class="bi bi-truck"></i></a>
        <?php endif; ?>
      </li>

      <!-- Carrito -->
      <li class="nav-item position-relative">
        <?php if (isset($_SESSION['usuario'])): ?>
          <button class="icon-btn" onclick="document.getElementById('cartPreview').classList.toggle('active')">
            <i class="bi bi-cart"></i>
          </button>
        <?php else: ?>
          <a class="icon-btn" href="index.php?controller=Usuario&action=login"><i class="bi bi-cart"></i></a>
        <?php endif; ?>

        <!-- Vista previa del carrito -->
        <div id="cartPreview" class="cart-preview p-3">
          <p class="mb-2 fw-bold text-center">🛍 Tu Carrito</p>
          <?php if (!empty($_SESSION['carrito'])): ?>
            <div id="cartItems">
              <?php foreach ($_SESSION['carrito'] as $id => $item): ?>
                <div class="d-flex align-items-center mb-2 border-bottom pb-2 bg-light rounded px-2 py-1 shadow-sm">
                  <img src="uploads/<?= rawurlencode($item['imagen'] ?? 'noimg.jpg') ?>" width="45" height="45" class="rounded me-2">
                  <div class="flex-grow-1">
                    <div class="fw-semibold small"><?= htmlspecialchars($item['nombre']) ?></div>
                    <div class="d-flex align-items-center">
                      <button class="btn btn-sm btn-outline-danger py-0 px-2 btn-restar" data-id="<?= $id ?>">−</button>
                      <span class="mx-2"><?= $item['cantidad'] ?></span>
                      <button class="btn btn-sm btn-outline-primary py-0 px-2 btn-sumar" data-id="<?= $id ?>">+</button>
                    </div>
                  </div>
                  <div class="text-end small text-success fw-semibold ms-2">
                    S/ <?= number_format($item['precio'] * $item['cantidad'], 2) ?>
                  </div>
                  <button class="btn btn-sm btn-outline-danger ms-2 btn-eliminar-item" data-id="<?= $id ?>"><i class="bi bi-trash-fill"></i></button>
                </div>
              <?php endforeach; ?>
            </div>
            <hr>
            <div class="text-end fw-bold">
              Total: <span class="text-danger">
                S/ <?= number_format(array_reduce($_SESSION['carrito'], fn($c, $i) => $c + $i['precio'] * $i['cantidad'], 0), 2) ?>
              </span>
            </div>
            <a href="index.php?controller=Carrito&action=ver" class="btn w-100 mt-2" style="background:#d85e9f;color:white;">
              <i class="bi bi-eye"></i> Ver carrito completo
            </a>
          <?php else: ?>
            <div class="text-muted text-center small">Tu carrito está vacío.</div>
          <?php endif; ?>
        </div>
      </li>

      <!-- Usuario -->
      <li class="nav-item dropdown d-flex align-items-center">
        <?php if (isset($_SESSION['usuario'])): ?>
          <span class="nombre-usuario">Hola, <?= explode(' ', htmlspecialchars($_SESSION['usuario']['nombre']))[0] ?></span>
          <a class="nav-link dropdown-toggle" href="#" id="perfilDropdown" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle" style="font-size:1.5rem;color:#d85e9f;"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><h6 class="dropdown-header"><?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></h6></li>
            <li><a class="dropdown-item" href="#">Notificaciones</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="index.php?controller=Usuario&action=logout">Cerrar sesión</a></li>
          </ul>
        <?php else: ?>
          <a href="index.php?controller=Usuario&action=login" class="btn-login-icon me-3"><i class="bi bi-person-circle"></i> Inicia sesión</a>
        <?php endif; ?>
      </li>
    </ul>
  </div>
</nav>

<!-- SEGUNDO HEADER -->
<div class="second-header">
  <ul>
    <li><a href="index.php"><i class="bi bi-house-door"></i> Inicio</a></li>
    <li><a href="index.php?controller=Producto&action=catalogo"><i class="bi bi-box-seam"></i> Catálogo</a></li>
    <li><a href="index.php?controller=Usuario&action=nosotros"><i class="bi bi-people"></i> Nosotros</a></li>
    <li><a href="index.php?controller=Home&action=contacto"><i class="bi bi-envelope"></i> Contáctanos</a></li>
  </ul>
</div>

<!-- CONTENIDO -->
<div class="container my-5">
  <h2 class="text-center mb-4">Catálogo de Productos</h2>

  <!-- Filtros -->
  <form method="GET" action="index.php" class="row g-3 mb-4 justify-content-center">
    <input type="hidden" name="controller" value="Producto">
    <input type="hidden" name="action" value="catalogo">

    <div class="col-md-4">
      <select name="categoria_id" class="form-select shadow-sm">
        <option value="">Todas las categorías</option>
        <?php foreach ($categorias as $cat): ?>
          <option value="<?= $cat['id'] ?>" <?= (isset($_GET['categoria_id']) && $_GET['categoria_id'] == $cat['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-5">
      <input type="text" name="query" class="form-control shadow-sm" placeholder="Buscar por nombre o descripción..." value="<?= htmlspecialchars($_GET['query'] ?? '') ?>">
    </div>

    <div class="col-md-3">
      <button type="submit" class="btn btn-success w-100 shadow-sm"><i class="bi bi-search"></i> Buscar</button>
    </div>
  </form>

  <!-- Productos -->
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
    <?php if (!empty($productos)): ?>
      <?php foreach ($productos as $producto): ?>
        <div class="col">
          <div class="card h-100 shadow-lg animate__animated animate__fadeInUp">
            <img src="uploads/<?= rawurlencode($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
            <div class="card-body text-center">
              <h5 class="card-title fw-bold"><?= htmlspecialchars($producto['nombre']) ?></h5>
              <p class="card-text small text-muted"><?= htmlspecialchars($producto['descripcion']) ?></p>
              <p class="fw-bold text-success fs-5">S/ <?= number_format($producto['precio'], 2) ?></p>

              <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'cliente'): ?>
                <form class="form-agregar-carrito" data-id="<?= $producto['id'] ?>">
                  <button type="submit" class="btn btn-outline-success btn-sm rounded-pill shadow-sm">
                    <i class="bi bi-cart-plus"></i> Agregar al carrito
                  </button>
                </form>
              <?php else: ?>
                <a href="index.php?controller=Usuario&action=login" class="btn btn-outline-secondary btn-sm rounded-pill shadow-sm">
                  <i class="bi bi-box-arrow-in-right"></i> Inicia sesión para comprar
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="col-12 text-center">
        <div class="alert alert-warning shadow-sm">No se encontraron productos.</div>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include 'views/layouts/footer.php'; ?>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener('click', function(event) {
    const preview = document.getElementById('cartPreview');
    const isInsideCart = preview.contains(event.target);
    const isCartButton = event.target.closest('.icon-btn');
    if (!isInsideCart && !isCartButton) {
      preview.classList.remove('active');
    }
  });

  document.addEventListener('DOMContentLoaded', function () {
    const cartPreview = document.getElementById('cartPreview');

    function activarBotonesCarrito() {
      cartPreview.querySelectorAll('.btn-sumar, .btn-restar').forEach(btn => {
        btn.addEventListener('click', e => {
          e.preventDefault();
          const id = btn.dataset.id;
          const accion = btn.classList.contains('btn-sumar') ? 'sumar' : 'restar';
          fetch('index.php?controller=Carrito&action=modificarAjax', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}&accion=${accion}`
          })
          .then(res => res.text())
          .then(html => {
            cartPreview.innerHTML = html;
            activarBotonesCarrito();
            activarBotonesEliminar();
          });
        });
      });
    }

    function activarBotonesEliminar() {
      cartPreview.querySelectorAll('.btn-eliminar-item').forEach(btn => {
        btn.addEventListener('click', e => {
          e.preventDefault();
          const id = btn.dataset.id;
          fetch('index.php?controller=Carrito&action=eliminarAjax', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}`
          })
          .then(res => res.text())
          .then(html => {
            cartPreview.innerHTML = html;
            activarBotonesCarrito();
            activarBotonesEliminar();
          });
        });
      });
    }

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
          cartPreview.innerHTML = html;
          cartPreview.classList.add('active');
          activarBotonesCarrito();
          activarBotonesEliminar();
        });
      });
    });

    activarBotonesCarrito();
    activarBotonesEliminar();
  });
</script>
</body>
</html>
