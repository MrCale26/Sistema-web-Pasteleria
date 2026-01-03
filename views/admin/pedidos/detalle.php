<?php require_once 'helpers/auth.php'; checkAuth('admin'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalle del Pedido</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #fffefc;
      margin: 0;
    }

    .main-content { margin-left: 240px; padding: 2rem; }
    h2, h4 {
      color: #d85e9f;
      font-weight: bold;
    }
    .table th {
      background-color: #e5f9f3;
      color: #1c9983;
    }
    .btn-success { background-color: #1c9983; border: none; }
    .btn-success:hover { background-color: #12876e; }
    .btn-warning { background-color: #ffb347; border: none; color: #000; }
    .btn-warning:hover { background-color: #f5a623; }
    .btn-secondary { background-color: #999; border: none; }
    .btn-secondary:hover { background-color: #777; }
    .btn-outline-info {
      color: #1c9983;
      border-color: #1c9983;
    }
    .btn-outline-info:hover {
      background-color: #1c9983;
      color: white;
    }
    label {
      font-weight: 500;
      color: #444;
    }
    .form-select, .form-control {
      border-radius: 0.5rem;
      border: 1px solid #ccc;
    }
    .section {
      background: #fdfdfd;
      border: 1px solid #eee;
      padding: 1.5rem;
      margin-bottom: 2rem;
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

<!-- MAIN -->
<div class="main-content">

  <!-- ====================== DETALLE ====================== -->
  <div class="section">
    <h2><i class="bi bi-receipt-cutoff"></i> Detalle del Pedido</h2>
    <table class="table table-bordered mt-3">
      <thead>
        <tr>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Precio unitario</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($d = $detalle->fetch_object()): ?>
          <tr>
            <td><?= $d->nombre ?></td>
            <td><?= $d->cantidad ?></td>
            <td>S/ <?= number_format($d->precio_unitario, 2) ?></td>
            <td>S/ <?= number_format($d->subtotal, 2) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- ====================== ESTADO PEDIDO ====================== -->
  <div class="section">
    <h4><i class="bi bi-hourglass-split"></i> Estado del pedido</h4>
    <form method="post" action="index.php?controller=Pedido&action=cambiarEstado" class="mt-3">
      <input type="hidden" name="pedido_id" value="<?= $_GET['id'] ?>">
      <div class="mb-3">
        <label>Actualizar estado:</label>
        <select name="estado" class="form-select" required>
          <option value="">-- Selecciona nuevo estado --</option>
          <option value="pendiente">Pendiente</option>
          <option value="procesando">Procesando</option>
          <option value="enviado">Enviado</option>
          <option value="entregado">Entregado</option>
        </select>
      </div>
      <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Actualizar Estado</button>
    </form>
  </div>

  <!-- ====================== ENTREGA ====================== -->
  <div class="section">
    <h4><i class="bi bi-truck"></i> Entrega</h4>

    <?php
      require_once 'models/Entrega.php';
      $entrega = new Entrega();
      $entregada = $entrega->getByPedidoId($_GET['id']);
    ?>

    <?php if ($entregada): ?>
      <p><strong>Empleado asignado:</strong> <?= $entregada->empleado ?></p>
      <p><strong>Fecha programada:</strong> <?= $entregada->fecha_entrega ?></p>
      <p><strong>Estado actual:</strong> <?= ucfirst($entregada->estado) ?></p>

      <!-- Form para actualizar estado de entrega -->
      <form method="post" action="index.php?controller=Pedido&action=actualizarEntrega" class="mt-3">
        <input type="hidden" name="entrega_id" value="<?= $entregada->id ?>">
        <input type="hidden" name="pedido_id" value="<?= $_GET['id'] ?>">
        <div class="mb-3">
          <label>Actualizar estado de entrega:</label>
          <select name="estado" class="form-select" required>
            <option value="programado" <?= $entregada->estado == 'programado' ? 'selected' : '' ?>>Programado</option>
            <option value="en camino" <?= $entregada->estado == 'en camino' ? 'selected' : '' ?>>En camino</option>
            <option value="entregado" <?= $entregada->estado == 'entregado' ? 'selected' : '' ?>>Entregado</option>
          </select>
        </div>
        <button type="submit" class="btn btn-warning"><i class="bi bi-arrow-repeat"></i> Actualizar Entrega</button>
      </form>
    <?php else: ?>
      <!-- Form para asignar entrega -->
      <form method="post" action="index.php?controller=Pedido&action=asignarEntrega" class="mt-3">
        <input type="hidden" name="pedido_id" value="<?= $_GET['id'] ?>">
        <div class="mb-3">
          <label>Empleado asignado:</label>
          <select name="empleado_id" class="form-control" required>
            <option value="">-- Selecciona --</option>
            <?php
            require_once 'models/Empleado.php';
            $empleado = new Empleado();
            $lista = $empleado->getAll();
            while ($e = $lista->fetch_object()):
            ?>
              <option value="<?= $e->id ?>"><?= $e->nombre ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="mb-3">
          <label>Fecha y hora de entrega:</label>
          <input type="datetime-local" name="fecha_entrega" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success"><i class="bi bi-send-check"></i> Asignar Entrega</button>
      </form>
    <?php endif; ?>
  </div>

  <!-- ====================== VOLVER ====================== -->
  <div class="d-flex gap-3">
    <a href="index.php?controller=Pedido&action=indexAdmin" class="btn btn-secondary">
      <i class="bi bi-arrow-left"></i> Volver a pedidos
    </a>
    <a href="index.php?controller=Pedido&action=resumenEntregas" class="btn btn-outline-info">
      <i class="bi bi-clipboard-data"></i> Ver resumen de entregas
    </a>
  </div>

</div>
</body>
</html>
