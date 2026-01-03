<?php require_once 'helpers/auth.php'; checkAuth('admin'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Categorías - Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
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

    .btn-success {
      background-color: #1c9983;
      border: none;
    }

    .btn-success:hover {
      background-color: #12876e;
    }

    .btn-warning { background-color: #ffc107; border: none; }
    .btn-danger { background-color: #d85e9f; border: none; }
    .btn-danger:hover { background-color: #c94b8d; }

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

    .top-actions {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }

    .pagination {
      justify-content: center;
      margin-top: 2rem;
    }

    .pagination .page-link {
      color: #1c9983;
      border: 1px solid #cbe9e0;
    }

    .pagination .page-link:hover {
      background-color: #dff9f2;
    }

    .pagination .active .page-link {
      background-color: #1c9983;
      color: white;
      border-color: #1c9983;
    }

    @media (max-width: 768px) {
      .main-content { margin-left: 0; padding: 1rem; }
      .sidebar {
        position: static;
        width: 100%;
        border-right: none;
        border-bottom: 2px solid #cbe9e0;
        box-shadow: none;
      }
      .top-actions {
        flex-direction: column;
        align-items: stretch;
      }
    }
  </style>
</head>
<body>

<!-- SIDEBAR -->
<?php include __DIR__ . '/../layouts/sidebar_admin.php'; ?>

<!-- MAIN CONTENT -->
<div class="main-content">
  <a href="javascript:history.back()" class="btn-volver"><i class="bi bi-arrow-left"></i> Volver</a>

  <h2><i class="bi bi-folder2-open"></i> Categorías de Productos</h2>

  <div class="top-actions">
    <a href="index.php?controller=Categoria&action=crear" class="btn btn-success">
      <i class="bi bi-plus-circle-fill"></i> Nueva Categoría
    </a>

    <div class="d-flex gap-2 align-items-center flex-wrap">
      <!-- Ordenar por ID -->
      <form method="get" action="index.php">
        <input type="hidden" name="controller" value="Categoria">
        <input type="hidden" name="action" value="index">
        <input type="hidden" name="orderby" value="id">
        <input type="hidden" name="order" value="<?= ($_GET['orderby'] ?? '') === 'id' && ($_GET['order'] ?? '') === 'asc' ? 'desc' : 'asc' ?>">
        <button class="btn btn-outline-secondary btn-sm" type="submit"><i class="bi bi-sort-numeric-down"></i> ID</button>
      </form>

      <!-- Ordenar por nombre -->
      <form method="get" action="index.php">
        <input type="hidden" name="controller" value="Categoria">
        <input type="hidden" name="action" value="index">
        <input type="hidden" name="orderby" value="nombre">
        <input type="hidden" name="order" value="<?= ($_GET['orderby'] ?? '') === 'nombre' && ($_GET['order'] ?? '') === 'asc' ? 'desc' : 'asc' ?>">
        <button class="btn btn-outline-secondary btn-sm" type="submit"><i class="bi bi-sort-alpha-down"></i> Nombre</button>
      </form>

      <!-- Buscador -->
      <form method="get" action="index.php" class="d-flex">
        <input type="hidden" name="controller" value="Categoria">
        <input type="hidden" name="action" value="index">
        <input class="form-control form-control-sm me-2" type="search" name="query" placeholder="Buscar categoría..." value="<?= $_GET['query'] ?? '' ?>">
        <button class="btn btn-outline-success btn-sm" type="submit"><i class="bi bi-search"></i></button>
      </form>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($cat = $categorias->fetch_object()): ?>
          <tr>
            <td><?= $cat->id ?></td>
            <td><?= $cat->nombre ?></td>
            <td class="text-center">
              <a href="index.php?controller=Categoria&action=editar&id=<?= $cat->id ?>" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
              <a href="index.php?controller=Categoria&action=eliminar&id=<?= $cat->id ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta categoría?')"><i class="bi bi-trash3"></i></a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- Paginación visual (estática por ahora) -->
  <nav>
    <ul class="pagination">
      <li class="page-item disabled"><span class="page-link">Anterior</span></li>
      <li class="page-item active"><span class="page-link">1</span></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">Siguiente</a></li>
    </ul>
  </nav>
</div>

</body>
</html>
