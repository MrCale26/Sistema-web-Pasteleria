<?php require_once 'helpers/auth.php'; checkAuth('admin'); ?>
<?php
function buildUrl($params) {
  $base = "index.php?controller=Pedido&action=indexAdmin";
  $final = $params;
  foreach ($_GET as $k => $v) {
    if (!isset($params[$k])) $final[$k] = $v;
  }
  return $base . '&' . http_build_query($final);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Pedidos - Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { font-family: 'Segoe UI', sans-serif; background: #fffefc; margin: 0; }
    .main-content {
  margin-left: 260px;
  padding: 2rem;
}

    h2 { color: #d85e9f; font-weight: bold; margin-bottom: 1.5rem; }
    .btn-primary { background-color: #1c9983; border: none; }
    .btn-primary:hover { background-color: #12876e; }
    .table th, .table td { vertical-align: middle; }
    .btn-volver {
      margin-bottom: 1rem; display: inline-block; color: #888;
      font-size: 0.95rem; text-decoration: none;
    }
    .btn-volver:hover { color: #555; text-decoration: underline; }
    .top-actions {
      display: flex; flex-wrap: wrap;
      justify-content: space-between; align-items: center;
      gap: 1rem; margin-bottom: 1.5rem;
    }
    .pagination { justify-content: center; margin-top: 2rem; }
    .pagination .page-link {
      color: #1c9983; border: 1px solid #cbe9e0;
    }
    .pagination .page-link:hover { background-color: #dff9f2; }
    .pagination .active .page-link {
      background-color: #1c9983; color: white; border-color: #1c9983;
    }
    @media (max-width: 768px) {
      .main-content { margin-left: 0; padding: 1rem; }
      .sidebar {
        position: static; width: 100%;
        border-right: none; border-bottom: 2px solid #cbe9e0;
        box-shadow: none;
      }
      .top-actions { flex-direction: column; align-items: stretch; }
    }
  </style>
</head>
<body>

<!-- SIDEBAR -->
<?php include __DIR__ . '/../../layouts/sidebar_admin.php';
 ?>

<!-- MAIN -->
<div class="main-content">
  <a href="javascript:history.back()" class="btn-volver"><i class="bi bi-arrow-left"></i> Volver</a>

  <h2><i class="bi bi-receipt-cutoff"></i> Pedidos Registrados</h2>

  <div class="top-actions">
    <div class="d-flex gap-2 flex-wrap align-items-center">
      <!-- Botones de orden -->
      <?php
        $orden = $_GET['order'] ?? 'asc';
        $queryActual = $_GET['query'] ?? '';
      ?>
      <form method="get" action="index.php">
        <input type="hidden" name="controller" value="Pedido">
        <input type="hidden" name="action" value="indexAdmin">
        <input type="hidden" name="orderby" value="id">
        <input type="hidden" name="order" value="<?= ($orden == 'asc' && ($_GET['orderby'] ?? '') == 'id') ? 'desc' : 'asc' ?>">
        <?php if ($queryActual): ?><input type="hidden" name="query" value="<?= $queryActual ?>"><?php endif; ?>
        <button class="btn btn-outline-secondary btn-sm" type="submit"><i class="bi bi-sort-numeric-down"></i> ID</button>
      </form>

      <form method="get" action="index.php">
        <input type="hidden" name="controller" value="Pedido">
        <input type="hidden" name="action" value="indexAdmin">
        <input type="hidden" name="orderby" value="cliente">
        <input type="hidden" name="order" value="<?= ($orden == 'asc' && ($_GET['orderby'] ?? '') == 'cliente') ? 'desc' : 'asc' ?>">
        <?php if ($queryActual): ?><input type="hidden" name="query" value="<?= $queryActual ?>"><?php endif; ?>
        <button class="btn btn-outline-secondary btn-sm" type="submit"><i class="bi bi-sort-alpha-down"></i> Cliente</button>
      </form>

      <form method="get" action="index.php">
        <input type="hidden" name="controller" value="Pedido">
        <input type="hidden" name="action" value="indexAdmin">
        <input type="hidden" name="orderby" value="fecha">
        <input type="hidden" name="order" value="<?= ($orden == 'asc' && ($_GET['orderby'] ?? '') == 'fecha') ? 'desc' : 'asc' ?>">
        <?php if ($queryActual): ?><input type="hidden" name="query" value="<?= $queryActual ?>"><?php endif; ?>
        <button class="btn btn-outline-secondary btn-sm" type="submit"><i class="bi bi-calendar-week"></i> Fecha</button>
      </form>

      <!-- Buscador -->
      <form class="d-flex" method="get" action="index.php">
        <input type="hidden" name="controller" value="Pedido">
        <input type="hidden" name="action" value="indexAdmin">
        <input class="form-control me-2" type="search" name="query" placeholder="Buscar cliente o fecha..." value="<?= htmlspecialchars($_GET['query'] ?? '') ?>">
        <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
      </form>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Cliente</th>
          <th>Fecha</th>
          <th>Total</th>
          <th>Estado</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
  <?php foreach ($pedidos as $p): ?>
    <tr>
      <td><?= $p['id'] ?></td>
      <td><?= $p['cliente'] ?></td>
      <td><?= $p['fecha'] ?></td>
      <td>S/ <?= number_format($p['total'], 2) ?></td>
      <td>
        <?php
          $estadoColor = match (strtolower($p['estado'])) {
            'pendiente' => 'warning',
            'enviado' => 'primary',
            'entregado' => 'success',
            'cancelado' => 'danger',
            default => 'secondary',
          };
        ?>
        <span class="badge bg-<?= $estadoColor ?>">
          <?= ucfirst($p['estado']) ?>
        </span>
      </td>
      <td class="text-center">
        <a href="index.php?controller=Pedido&action=detalle&id=<?= $p['id'] ?>" class="btn btn-sm btn-primary">
          <i class="bi bi-eye"></i> Ver
        </a>
      </td>
    </tr>
  <?php endforeach; ?>
</tbody>

    </table>
  </div>

  <!-- Paginación dinámica -->
  <nav>
    <ul class="pagination">
      <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
        <a class="page-link" href="<?= buildUrl(['page' => $page - 1]) ?>">Anterior</a>
      </li>
      <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
          <a class="page-link" href="<?= buildUrl(['page' => $i]) ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>
      <li class="page-item <?= $page >= $totalPaginas ? 'disabled' : '' ?>">
        <a class="page-link" href="<?= buildUrl(['page' => $page + 1]) ?>">Siguiente</a>
      </li>
    </ul>
  </nav>
</div>

</body>
</html>
