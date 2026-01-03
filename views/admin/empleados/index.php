<?php require_once 'helpers/auth.php'; checkAuth('admin'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Empleados - Admin</title>
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

    .btn-success {
      background-color: #1c9983;
      border: none;
    }

    .btn-success:hover {
      background-color: #12876e;
    }

    .btn-warning {
      background-color: #ffc107;
      border: none;
    }

    .btn-danger {
      background-color: #d85e9f;
      border: none;
    }

    .btn-danger:hover {
      background-color: #c94b8d;
    }

    .table th, .table td {
      vertical-align: middle;
    }

    @media(max-width: 768px) {
      .main-content {
        margin-left: 0;
        padding: 1rem;
      }
    }
  </style>
</head>
<body>

<?php include_once __DIR__ . '/../../layouts/sidebar_admin.php'; ?>

<div class="main-content">
  <h2><i class="bi bi-person-badge-fill"></i> Lista de Empleados</h2>

  <a href="index.php?controller=Empleado&action=crear" class="btn btn-success mb-3">
    <i class="bi bi-plus-circle"></i> Nuevo Empleado
  </a>

  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Teléfono</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($emp = $empleados->fetch_object()): ?>
          <tr>
            <td><?= $emp->id ?></td>
            <td><?= htmlspecialchars($emp->nombre) ?></td>
            <td><?= htmlspecialchars($emp->telefono) ?></td>
            <td class="text-center">
              <a href="index.php?controller=Empleado&action=editar&id=<?= $emp->id ?>" class="btn btn-sm btn-warning me-1">
                <i class="bi bi-pencil-square"></i>
              </a>
              <a href="index.php?controller=Empleado&action=eliminar&id=<?= $emp->id ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este empleado?')">
                <i class="bi bi-trash"></i>
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
