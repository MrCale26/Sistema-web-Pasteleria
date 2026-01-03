<?php require_once 'helpers/auth.php'; checkAuth('admin'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resumen de Pagos - Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fffefc;
      margin: 0;
    }
    .main-content {
      margin-left: 260px;
      padding: 2rem;
    }
    h2 {
      color: #d85e9f;
      font-weight: bold;
      margin-bottom: 1.5rem;
    }
    .btn-primary { background-color: #1c9983; border: none; }
    .btn-primary:hover { background-color: #12876e; }
    .btn-success { background-color: #4caf50; border: none; }
    .btn-success:hover { background-color: #43a047; }

    .badge-success { background-color: #1c9983; }
    .badge-warning { background-color: #ffc107; color: #000; }
    .badge-danger { background-color: #d85e9f; }

    .table th {
      background-color: #f8f9fa;
      color: #333;
    }

    .form-label {
      font-weight: 500;
      color: #444;
    }

    @media (max-width: 768px) {
      .main-content { margin-left: 0; padding: 1rem; }
    }
  </style>
</head>
<body>

<?php include __DIR__ . '/../layouts/sidebar_admin.php'; ?>

<div class="main-content">
  <a href="javascript:history.back()" class="btn btn-link text-muted mb-2"><i class="bi bi-arrow-left"></i> Volver</a>

  <h2><i class="bi bi-bar-chart-fill"></i> Resumen de Pagos (Administrador)</h2>

  <form method="GET" action="index.php" class="mb-4">
    <input type="hidden" name="controller" value="Usuario">
    <input type="hidden" name="action" value="resumenPagos">

    <div class="row g-2 align-items-end">
      <div class="col-md-4">
        <label for="inicio" class="form-label">Desde:</label>
        <input type="date" name="inicio" id="inicio" class="form-control" value="<?= $_GET['inicio'] ?? '' ?>">
      </div>
      <div class="col-md-4">
        <label for="fin" class="form-label">Hasta:</label>
        <input type="date" name="fin" id="fin" class="form-control" value="<?= $_GET['fin'] ?? '' ?>">
      </div>
      <div class="col-md-4">
        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Filtrar</button>
      </div>
    </div>
  </form>

  <a href="views/admin/exportar_pagos.php?inicio=<?= $_GET['inicio'] ?? '' ?>&fin=<?= $_GET['fin'] ?? '' ?>"
     class="btn btn-success mb-4" target="_blank"><i class="bi bi-file-earmark-excel-fill"></i> Exportar a Excel</a>

  <?php if ($pagos->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead>
          <tr>
            <th># Pago</th>
            <th>Cliente</th>
            <th># Pedido</th>
            <th>Método</th>
            <th>Monto</th>
            <th>Estado</th>
            <th>Fecha</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($pago = $pagos->fetch_object()): ?>
            <tr>
              <td>#<?= $pago->pago_id ?></td>
              <td><?= htmlspecialchars($pago->cliente_nombre) ?></td>
              <td>#<?= $pago->pedido_id ?></td>
              <td><i class="bi bi-wallet2"></i> <?= ucfirst($pago->metodo) ?></td>
              <td>S/ <?= number_format($pago->monto, 2) ?></td>
              <td>
                <?php
                  $estado = strtolower($pago->estado);
                  if ($estado === 'completado') {
                    echo '<span class="badge badge-success">Completado</span>';
                  } elseif ($estado === 'pendiente') {
                    echo '<span class="badge badge-warning">Pendiente</span>';
                  } else {
                    echo '<span class="badge badge-danger">' . ucfirst($estado) . '</span>';
                  }
                ?>
              </td>
              <td><i class="bi bi-calendar-check"></i> <?= date("d/m/Y H:i", strtotime($pago->fecha_pago)) ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info mt-4"><i class="bi bi-info-circle"></i> No se han registrado pagos en este periodo.</div>
  <?php endif; ?>
</div>

</body>
</html>
