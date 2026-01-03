<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mis Pedidos - Pastelería Dieguito D & M</title>
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
    .breadcrumb-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1rem;
    }
    .pedido-card {
      border-radius: 1rem;
      border: 1px solid #eee;
      box-shadow: 0 5px 15px rgba(0,0,0,0.04);
      animation: fadeIn 0.5s ease-in-out;
    }
    .pedido-card .card-header {
      background-color: #f9f9f9;
      font-weight: 500;
    }
    .pedido-card .card-body {
      background-color: #fff;
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
    .page-wrapper {
  flex: 1 0 auto;
}
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
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
        <button class="icon-btn" onclick="location.href='index.php?controller=Carrito&action=ver'">
          <i class="bi bi-cart"></i>
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

<!-- CONTENIDO DE PEDIDOS -->
<div class="page-wrapper">
  <div class="container my-5">
  <div class="breadcrumb-header">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php" style="color: #d85e9f; font-weight: 500;">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Mis Pedidos</li>
      </ol>
    </nav>
    <a href="javascript:history.back()" class="text-muted"><i class="bi bi-arrow-left"></i> Volver</a>
  </div>

  <h2 class="text-center mb-4" style="font-family:'Pacifico', cursive; color: #d85e9f;"><i class="bi bi-box-seam-fill"></i> Mis Pedidos</h2>

  <?php if ($pedidos->num_rows > 0): ?>
    <?php while ($pedido = $pedidos->fetch_object()): ?>
      <div class="card pedido-card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span><i class="bi bi-hash"></i> Pedido #<?= $pedido->id ?> — <?= $pedido->fecha ?></span>
          <span class="estado-pedido text-<?= $pedido->estado == 'pendiente' ? 'warning' : 'success' ?>">
            <i class="bi <?= $pedido->estado == 'pendiente' ? 'bi-clock-fill' : 'bi-check-circle-fill' ?>"></i>
            <?= ucfirst($pedido->estado) ?>
          </span>
        </div>
        <div class="card-body">
          <p><strong>Total:</strong> S/ <?= number_format($pedido->total, 2) ?></p>
          <?php
          $stmtPago = $db->prepare("SELECT metodo FROM pagos WHERE pedido_id = ? AND estado = 'completado' LIMIT 1");
          $stmtPago->bind_param("i", $pedido->id);
          $stmtPago->execute();
          $pagoResult = $stmtPago->get_result();
          $metodoPago = $pagoResult->fetch_assoc();
          ?>
          <?php if ($metodoPago): ?>
            <p><strong>Método de pago:</strong> <i class="bi bi-credit-card-2-front-fill"></i> <?= ucfirst($metodoPago['metodo']) ?></p>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-sm table-bordered mt-3">
              <thead class="table-light text-center">
                <tr>
                  <th>Producto</th>
                  <th>Precio unitario</th>
                  <th>Cantidad</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sqlDetalle = "SELECT dp.*, p.nombre FROM detalle_pedido dp INNER JOIN productos p ON dp.producto_id = p.id WHERE dp.pedido_id = ?";
                $stmtDetalle = $db->prepare($sqlDetalle);
                $stmtDetalle->bind_param("i", $pedido->id);
                $stmtDetalle->execute();
                $detalles = $stmtDetalle->get_result();
                ?>
                <?php while ($detalle = $detalles->fetch_object()): ?>
                  <tr class="text-center">
                    <td class="text-start"><?= htmlspecialchars($detalle->nombre) ?></td>
                    <td>S/ <?= number_format($detalle->precio_unitario, 2) ?></td>
                    <td><?= $detalle->cantidad ?></td>
                    <td>S/ <?= number_format($detalle->subtotal, 2) ?></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <div class="alert alert-info text-center">
      <i class="bi bi-info-circle-fill"></i> No has realizado ningún pedido aún.
    </div>
  <?php endif; ?>
</div>
</div> <!-- cierre de .page-wrapper -->
<!-- FOOTER -->
<?php include 'views/layouts/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
