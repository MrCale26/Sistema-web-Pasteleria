<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Carrito - Pastelería Dieguito D & M</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Estilos y fuentes -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fffefc;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
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
    .second-header {
      background-color: #fff1f7;
      padding: 0.6rem 0;
      box-shadow: 0 1px 5px rgba(0,0,0,0.05);
    }
    .second-header ul {
      display: flex;
      justify-content: center;
      gap: 30px;
      list-style: none;
      padding-left: 0;
      margin: 0;
    }
    .second-header a {
      text-decoration: none;
      color: #c94c8f;
      font-weight: 500;
    }
    .second-header a:hover {
      color: #a62c7c;
    }
    .icon-btn {
      background: none;
      border: none;
      font-size: 1.5rem;
      color: #a62c7c;
      margin-right: 10px;
    }
    .nombre-usuario {
      margin-right: 10px;
      font-weight: 500;
      color: #d85e9f;
    }
    .carrito-title {
      color: #d85e9f;
      font-weight: bold;
      font-family: 'Pacifico', cursive;
      text-align: center;
      margin-top: 2rem;
      margin-bottom: 1.5rem;
    }
    .btn-primary {
      background-color: #1c9983;
      border: none;
    }
    .btn-danger {
      background-color: #d85e9f;
      border: none;
    }
    .footer {
      background-color: #fdeef4;
      color: #555;
      text-align: center;
      padding: 1rem 0;
      margin-top: auto;
      font-size: 0.9rem;
      border-top: 1px solid #eee;
    }
    @media (max-width: 576px) {
      .second-header ul {
        flex-direction: column;
        gap: 15px;
      }
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

    <form class="d-flex mx-auto w-50" method="GET" action="index.php">
      <input type="hidden" name="controller" value="Producto">
      <input type="hidden" name="action" value="catalogo">
      <div class="input-group w-100 shadow-sm">
        <input class="form-control border-end-0" type="search" name="query" placeholder="Buscar productos...">
        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
      </div>
    </form>

    <ul class="navbar-nav ms-auto align-items-center">
      <li class="nav-item">
        <button class="icon-btn" onclick="location.href='index.php?controller=Usuario&action=misPedidos'">
          <i class="bi bi-truck"></i>
        </button>
      </li>
      <li class="nav-item dropdown d-flex align-items-center">
        <span class="nombre-usuario me-1">Hola, <?= explode(' ', htmlspecialchars($_SESSION['usuario']['nombre']))[0] ?></span>
        <a class="nav-link dropdown-toggle" href="#" id="perfilDropdown" data-bs-toggle="dropdown">
          <i class="bi bi-person-circle" style="font-size: 1.5rem; color: #d85e9f;"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><h6 class="dropdown-header"><?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></h6></li>
          <li><a class="dropdown-item" href="#">Cambiar cuenta</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item text-danger" href="index.php?controller=Usuario&action=logout">Cerrar sesión</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>

<!-- SECOND HEADER -->
<div class="second-header">
  <ul>
    <li><a href="index.php"><i class="bi bi-house-door"></i> Inicio</a></li>
    <li><a href="index.php?controller=Producto&action=catalogo"><i class="bi bi-box-seam"></i> Catálogo</a></li>
    <li><a href="index.php?controller=Usuario&action=nosotros"><i class="bi bi-people"></i> Nosotros</a></li>
    <li><a href="index.php?controller=Home&action=contacto"><i class="bi bi-envelope"></i> Contáctanos</a></li>
  </ul>
</div>

<!-- CONTENIDO PRINCIPAL -->
<div class="container my-5 flex-grow-1">
  <h2 class="carrito-title"><i class="bi bi-cart4"></i> Carrito de Compras</h2>

  <?php if (!empty($_SESSION['carrito'])): ?>
    <div class="text-end mb-3">
      <a href="index.php?controller=Carrito&action=vaciar" class="btn btn-danger">
        <i class="bi bi-trash3-fill"></i> Vaciar carrito
      </a>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <thead class="table-light text-center">
          <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php $total = 0; ?>
          <?php foreach ($_SESSION['carrito'] as $id => $item): ?>
            <tr>
              <td><?= htmlspecialchars($item['nombre']) ?></td>
              <td class="text-center">S/ <?= number_format($item['precio'], 2) ?></td>
              <td class="text-center">
                <form action="index.php?controller=Carrito&action=modificar" method="post" class="d-flex justify-content-center align-items-center gap-2">
                  <input type="hidden" name="id" value="<?= $id ?>">
                  <button type="submit" name="accion" value="restar" class="btn btn-sm btn-outline-secondary"><i class="bi bi-dash"></i></button>
                  <span><?= $item['cantidad'] ?></span>
                  <button type="submit" name="accion" value="sumar" class="btn btn-sm btn-outline-secondary"><i class="bi bi-plus"></i></button>
                </form>
              </td>
              <td class="text-center">S/ <?= number_format($item['precio'] * $item['cantidad'], 2) ?></td>
            </tr>
            <?php $total += $item['precio'] * $item['cantidad']; ?>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>
            <th colspan="3" class="text-end">Total</th>
            <th class="text-center text-success">S/ <?= number_format($total, 2) ?></th>
          </tr>
        </tfoot>
      </table>
    </div>

    <div class="text-end">
      <a href="index.php?controller=Carrito&action=pagar" class="btn btn-primary mt-3">
        <i class="bi bi-credit-card"></i> Confirmar Pedido y Pagar
      </a>
    </div>
  <?php else: ?>
    <div class="text-center text-muted my-5">Tu carrito está vacío.</div>
  <?php endif; ?>
</div>

<!-- FOOTER -->
<?php include 'views/layouts/footer.php'; ?>

<!-- JS Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
