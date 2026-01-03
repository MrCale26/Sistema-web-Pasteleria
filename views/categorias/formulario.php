<?php require_once 'helpers/auth.php'; checkAuth('admin'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= isset($categoria) ? 'Editar Categoría' : 'Nueva Categoría' ?> - Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap + Iconos -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #fffefc;
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

    .form-control {
      max-width: 500px;
    }

    .btn-primary {
      background-color: #1c9983;
      border: none;
    }

    .btn-primary:hover {
      background-color: #12876e;
    }

    .btn-volver {
      margin-bottom: 1rem;
      color: #888;
      text-decoration: none;
      display: inline-block;
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
      .sidebar {
        position: static;
        width: 100%;
        border-right: none;
        border-bottom: 2px solid #cbe9e0;
        box-shadow: none;
      }
    }
  </style>
</head>
<body>

<!-- SIDEBAR -->
<?php include __DIR__ . '/../layouts/sidebar_admin.php'; ?>

<!-- MAIN -->
<div class="main-content">
  <a href="index.php?controller=Categoria&action=index" class="btn-volver"><i class="bi bi-arrow-left"></i> Volver</a>

  <h2><?= isset($categoria) ? '<i class="bi bi-pencil-square"></i> Editar Categoría' : '<i class="bi bi-plus-circle-fill"></i> Nueva Categoría' ?></h2>

  <form action="index.php?controller=Categoria&action=guardar" method="post">
    <?php if (isset($categoria)): ?>
      <input type="hidden" name="id" value="<?= $categoria->id ?>">
    <?php endif; ?>

    <div class="mb-3">
      <label class="form-label">Nombre de la categoría:</label>
      <input type="text" name="nombre" class="form-control" required value="<?= $categoria->nombre ?? '' ?>">
    </div>

    <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill"></i> Guardar</button>
  </form>
</div>

</body>
</html>
