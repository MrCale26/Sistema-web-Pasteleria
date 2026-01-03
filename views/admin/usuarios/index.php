<?php require_once 'helpers/auth.php'; checkAuth('admin'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Usuarios</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { font-family: 'Segoe UI', sans-serif; background: #fffefc; margin: 0; }
    .main-content { margin-left: 240px; padding: 2rem; }
    h2 { color: #d85e9f; font-weight: bold; margin-bottom: 1.5rem; }
    .btn-primary { background-color: #1c9983; border: none; }
    .btn-primary:hover { background-color: #12876e; }
    .btn-outline-primary { border-color: #1c9983; color: #1c9983; }
    .btn-outline-primary:hover { background-color: #1c9983; color: white; }
    .btn-warning { background-color: #ffc107; border: none; }
    .btn-warning:hover { background-color: #e0a800; }
    .btn-danger { background-color: #dc3545; border: none; }
    .btn-danger:hover { background-color: #c82333; }
    .table th { background-color: #e5f9f3; color: #1c9983; }
    .table td { vertical-align: middle; }
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
  <a href="javascript:history.back()" class="btn btn-link mb-3 text-muted"><i class="bi bi-arrow-left"></i> Volver</a>

  <h2><i class="bi bi-people-fill"></i> Gestión de Usuarios</h2>

  <!-- Buscador -->
  <form class="mb-4" method="get" action="index.php">
    <input type="hidden" name="controller" value="Usuario">
    <input type="hidden" name="action" value="indexAdmin">
    <div class="input-group w-50">
      <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre o email..." value="<?= isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : '' ?>">
      <button class="btn btn-outline-primary" type="submit">
        <i class="bi bi-search"></i> Buscar
      </button>
    </div>
  </form>

  <!-- Tabla de usuarios -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Email</th>
          <th>Rol</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($u = $usuarios->fetch_object()): ?>
        <tr>
          <td><?= $u->id ?></td>
          <td><?= htmlspecialchars($u->nombre) ?></td>
          <td><?= htmlspecialchars($u->email) ?></td>
          <td><span class="badge bg-info text-dark"><?= ucfirst($u->rol) ?></span></td>
          <td class="text-center">
            <a href="index.php?controller=Usuario&action=editarUsuario&id=<?= $u->id ?>" class="btn btn-sm btn-warning me-1">
              <i class="bi bi-pencil-square"></i> Editar
            </a>
            <a href="index.php?controller=Usuario&action=eliminarUsuario&id=<?= $u->id ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
              <i class="bi bi-trash"></i> Eliminar
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
