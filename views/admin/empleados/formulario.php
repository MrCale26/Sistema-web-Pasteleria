<?php require_once 'helpers/auth.php'; checkAuth('admin'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= isset($empleado) ? 'Editar Empleado' : 'Nuevo Empleado' ?> - Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fffefc;
      margin: 0;
      padding: 0;
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

    .form-container {
      background-color: #ffffff;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
    }

    label {
      font-weight: 500;
      color: #333;
    }

    .btn-primary {
      background-color: #1c9983;
      border: none;
    }

    .btn-primary:hover {
      background-color: #12876e;
    }

    .btn-volver {
      color: #888;
      text-decoration: none;
      display: inline-block;
      margin-bottom: 1rem;
    }

    .btn-volver:hover {
      color: #555;
      text-decoration: underline;
    }

    @media (max-width: 768px) {
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
  <a href="javascript:history.back()" class="btn-volver"><i class="bi bi-arrow-left"></i> Volver</a>

  <div class="form-container">
    <h2><i class="bi bi-person-badge"></i> <?= isset($empleado) ? 'Editar Empleado' : 'Nuevo Empleado' ?></h2>

    <form action="index.php?controller=Empleado&action=guardar" method="post">
      <?php if (isset($empleado)): ?>
        <input type="hidden" name="id" value="<?= $empleado->id ?>">
      <?php endif; ?>

      <div class="mb-3">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" class="form-control" required value="<?= $empleado->nombre ?? '' ?>">
      </div>

      <div class="mb-3">
        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" class="form-control" required value="<?= $empleado->telefono ?? '' ?>">
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-save"></i> Guardar
        </button>
      </div>
    </form>
  </div>
</div>

</body>
</html>
