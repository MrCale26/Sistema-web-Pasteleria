<?php require_once 'helpers/auth.php'; checkAuth('admin'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resumen de Entregas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { font-family: 'Segoe UI', sans-serif; background: #fffefc; margin: 0; }

    .main-content { margin-left: 240px; padding: 2rem; }
    h2 { color: #d85e9f; font-weight: bold; margin-bottom: 1.5rem; }
    .table th { background-color: #e5f9f3; color: #1c9983; }
    .btn-outline-primary { color: #1c9983; border-color: #1c9983; }
    .btn-outline-primary:hover { background-color: #1c9983; color: white; }
    .btn-secondary { background-color: #999; border: none; }
    .btn-secondary:hover { background-color: #777; }
    .badge { font-size: 0.85rem; }
    .section {
      background: #fdfdfd;
      border: 1px solid #eee;
      padding: 1.5rem;
      border-radius: 1rem;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    @media (max-width: 768px) {
      .main-content { margin-left: 0; padding: 1rem; }
      .sidebar {
        position: static; width: 100%;
        border-right: none; border-bottom: 2px solid #cbe9e0;
        box-shadow: none;
      }
    }
  </style>
</head>
<body>

<!-- SIDEBAR -->
<?php include __DIR__ . '/../../layouts/sidebar_admin.php';
 ?>

<!-- MAIN CONTENT -->
<div class="main-content">

  <a href="index.php?controller=Pedido&action=indexAdmin" class="btn btn-link text-muted mb-3">
    <i class="bi bi-arrow-left"></i> Volver a pedidos
  </a>

  <h2><i class="bi bi-truck-front-fill"></i> Resumen de Entregas por Empleado</h2>

  <div class="section">
    <?php if ($entregas->num_rows > 0): ?>
      <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
          <thead>
            <tr>
              <th># Pedido</th>
              <th>Empleado</th>
              <th>Fecha de Entrega</th>
              <th>Estado Entrega</th>
              <th>Estado Pedido</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($e = $entregas->fetch_object()): ?>
              <tr>
                <td><?= $e->pedido_id ?></td>
                <td><?= $e->empleado ?></td>
                <td><?= $e->fecha_entrega ?></td>
                <td>
                  <span class="badge bg-info"><?= ucfirst($e->estado_entrega) ?></span>
                </td>
                <td>
                  <span class="badge bg-secondary"><?= ucfirst($e->estado_pedido) ?></span>
                </td>
                <td class="text-center">
                  <a href="index.php?controller=Pedido&action=detalle&id=<?= $e->pedido_id ?>" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-eye"></i> Ver pedido
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <p class="text-muted">No hay entregas registradas aún.</p>
    <?php endif; ?>
  </div>

</div>
</body>
</html>
