<?php require_once 'helpers/auth.php'; checkAuth('admin'); ?>
<?php if (!isset($usuario)) { echo "<p style='color:red;'>No se encontró el usuario.</p>"; return; } ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Usuario</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { font-family: 'Segoe UI', sans-serif; background: #fffefc; margin: 0; }

    .main-content { margin-left: 240px; padding: 2rem; }
    h2 { color: #d85e9f; font-weight: bold; margin-bottom: 1.5rem; }
    .form-label { font-weight: 500; color: #333; }
    .form-control, select {
      border-radius: 0.5rem;
      border: 1px solid #ced4da;
      padding: 0.6rem;
    }
    .btn-primary { background-color: #1c9983; border: none; }
    .btn-primary:hover { background-color: #12876e; }
    .btn-secondary { background-color: #6c757d; border: none; }
    .btn-secondary:hover { background-color: #5a6268; }
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
  <a href="index.php?controller=Usuario&action=indexAdmin" class="btn btn-link text-muted mb-3"><i class="bi bi-arrow-left"></i> Volver</a>

  <h2><i class="bi bi-pencil-square"></i> Editar Usuario</h2>

  <form method="post" action="index.php?controller=Usuario&action=actualizarUsuario" class="w-100" style="max-width: 500px;">
    <input type="hidden" name="id" value="<?= $usuario->id ?>">

    <div class="mb-3">
      <label class="form-label">Nombre:</label>
      <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($usuario->nombre) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Email:</label>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($usuario->email) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Rol:</label>
      <select name="rol" class="form-select" required>
        <option value="admin" <?= $usuario->rol == 'admin' ? 'selected' : '' ?>>Administrador</option>
        <option value="cliente" <?= $usuario->rol == 'cliente' ? 'selected' : '' ?>>Cliente</option>
      </select>
    </div>

    <div class="mt-4">
      <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Guardar cambios</button>
      <a href="index.php?controller=Usuario&action=indexAdmin" class="btn btn-secondary ms-2"><i class="bi bi-x-circle"></i> Cancelar</a>
    </div>
  </form>
</div>

</body>
</html>
