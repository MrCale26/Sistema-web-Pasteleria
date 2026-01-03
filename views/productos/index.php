<?php require_once 'helpers/auth.php'; checkAuth('admin'); ?>
<?php require_once 'config/config.php'; ?>
<?php require_once 'models/Producto.php'; ?>
<?php
$productoModel = new Producto();
$productos = $productoModel->listarTodos();
$categorias = $productoModel->obtenerCategorias();
$totalPaginas = ceil(count($productos) / 10);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Productos - Admin</title>
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
    .product-image {
      height: 60px;
      width: 60px;
      object-fit: cover;
      border-radius: 0.5rem;
    }
    .top-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
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
      .top-actions {
        flex-direction: column;
        align-items: stretch;
      }
    }
  </style>
</head>
<body>
<!-- Código actualizado para incluir flags destacados y promociones en vista admin -->
<!-- Tu contenido original continúa aquí... -->

<?php include __DIR__ . '/../layouts/sidebar_admin.php'; ?>


<div class="main-content">
  <a href="javascript:history.back()" class="btn btn-link mb-2 text-muted"><i class="bi bi-arrow-left"></i> Volver</a>
  <h2><i class="bi bi-box-seam"></i> Gestión de Productos</h2>
  <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>
  <div class="top-actions">
    <a href="<?= BASE_URL ?>index.php?controller=Producto&action=crear" class="btn btn-success">
      <i class="bi bi-plus-circle-fill"></i> Nuevo Producto
    </a>
    <div class="d-flex flex-wrap gap-2 align-items-center">
      <!-- Botones de orden -->
      <form method="get" action="<?= BASE_URL ?>index.php">
        <input type="hidden" name="controller" value="Producto">
        <input type="hidden" name="action" value="index">
        <input type="hidden" name="orderby" value="id">
        <input type="hidden" name="order" value="<?= ($_GET['orderby'] ?? '') === 'id' && ($_GET['order'] ?? '') === 'asc' ? 'desc' : 'asc' ?>">
        <button type="submit" class="btn btn-outline-secondary btn-sm"><i class="bi bi-sort-numeric-down"></i> ID</button>
      </form>
      <form method="get" action="<?= BASE_URL ?>index.php">
        <input type="hidden" name="controller" value="Producto">
        <input type="hidden" name="action" value="index">
        <input type="hidden" name="orderby" value="nombre">
        <input type="hidden" name="order" value="<?= ($_GET['orderby'] ?? '') === 'nombre' && ($_GET['order'] ?? '') === 'asc' ? 'desc' : 'asc' ?>">
        <button type="submit" class="btn btn-outline-secondary btn-sm"><i class="bi bi-sort-alpha-down"></i> Nombre</button>
      </form>
      <form method="get" action="<?= BASE_URL ?>index.php">
        <input type="hidden" name="controller" value="Producto">
        <input type="hidden" name="action" value="index">
        <input type="hidden" name="orderby" value="descripcion">
        <input type="hidden" name="order" value="<?= ($_GET['orderby'] ?? '') === 'descripcion' && ($_GET['order'] ?? '') === 'asc' ? 'desc' : 'asc' ?>">
        <button type="submit" class="btn btn-outline-secondary btn-sm"><i class="bi bi-text-paragraph"></i> Descripción</button>
      </form>
    </div>
    <form class="d-flex" method="get" action="<?= BASE_URL ?>index.php">
      <input type="hidden" name="controller" value="Producto">
      <input type="hidden" name="action" value="index">
      <input class="form-control me-2" type="search" name="query" placeholder="Buscar producto..." value="<?= $_GET['query'] ?? '' ?>">
      <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
    </form>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Precio (S/)</th>
          <th>Precio Original</th>
          <th>Descuento (%)</th>
          <th>Stock</th>
          <th>Categoría</th>
          <th>Imagen</th>
          <th>Destacado</th>
          <th>Promoción</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($productos as $p): ?>
<tr>
  <td><?= $p['id'] ?></td>
  <td><?= htmlspecialchars($p['nombre']) ?></td>
  <td><?= htmlspecialchars($p['descripcion']) ?></td>
  <!-- Precio actual (resalta si tiene descuento) -->
<td>
  <?php if ($p['promocion'] && $p['descuento'] > 0): ?>
    <span class="text-danger fw-bold">S/ <?= number_format($p['precio'], 2) ?></span>
  <?php else: ?>
    S/ <?= number_format($p['precio'], 2) ?>
  <?php endif; ?>
</td>

<!-- Precio original -->
<td>
  <?php if (!empty($p['precio_original'])): ?>
    <span class="<?= $p['promocion'] ? 'text-muted text-decoration-line-through' : '' ?>">
      S/ <?= number_format($p['precio_original'], 2) ?>
    </span>
  <?php else: ?>
    <span class="text-muted">-</span>
  <?php endif; ?>
</td>

<!-- Porcentaje de descuento -->
<td>
  <?php if ($p['promocion'] && $p['descuento'] > 0): ?>
    <span class="badge bg-danger"><?= number_format($p['descuento'], 0) ?>%</span>
  <?php else: ?>
    <span class="text-muted">0%</span>
  <?php endif; ?>
</td>

  <td><?= $p['stock'] ?></td>
  <td><?= $p['categoria'] ?? 'Sin categoría' ?></td>
  <td class="text-center">
    <?php if (!empty($p['imagen'])): ?>
      <img src="<?= BASE_URL ?>uploads/<?= urlencode($p['imagen']) ?>" class="product-image" alt="imagen">
    <?php else: ?>
      <span class="text-muted">Sin imagen</span>
    <?php endif; ?>
  </td>

  <!-- ✅ Destacado -->
  <td class="text-center">
    <?= $p['destacado'] ? '<i class="bi bi-star-fill text-warning"></i>' : '<span class="text-muted">No</span>' ?>
  </td>

  <!-- ✅ Promoción -->
  <td class="text-center">
    <?= $p['promocion'] ? '<i class="bi bi-tags-fill text-danger"></i>' : '<span class="text-muted">No</span>' ?>
  </td>

  <td class="text-center">
    <a href="<?= BASE_URL ?>index.php?controller=Producto&action=editar&id=<?= $p['id'] ?>" class="btn btn-sm btn-warning me-1">
      <i class="bi bi-pencil-square"></i>
    </a>
    <a href="<?= BASE_URL ?>index.php?controller=Producto&action=eliminar&id=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este producto?')">
      <i class="bi bi-trash3"></i>
    </a>
  </td>
</tr>
<?php endforeach; ?>

      </tbody>
    </table>
  </div>
  <nav>
    <ul class="pagination">
      <?php
        $currentPage = $_GET['page'] ?? 1;
        $currentPage = max(1, intval($currentPage));
        $query = $_GET['query'] ?? '';
        $orderby = $_GET['orderby'] ?? 'id';
        $order = $_GET['order'] ?? 'asc';
        $baseUrl = BASE_URL . "index.php?controller=Producto&action=index"
                   . "&query=" . urlencode($query)
                   . "&orderby=" . urlencode($orderby)
                   . "&order=" . urlencode($order);
      ?>
      <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
        <a class="page-link" href="<?= $baseUrl . '&page=' . ($currentPage - 1) ?>">Anterior</a>
      </li>
      <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
        <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
          <a class="page-link" href="<?= $baseUrl . '&page=' . $i ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>
      <li class="page-item <?= $currentPage >= $totalPaginas ? 'disabled' : '' ?>">
        <a class="page-link" href="<?= $baseUrl . '&page=' . ($currentPage + 1) ?>">Siguiente</a>
      </li>
    </ul>
  </nav>
</div>
</body>
</html>
