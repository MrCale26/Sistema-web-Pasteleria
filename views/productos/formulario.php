<?php require_once 'helpers/auth.php'; checkAuth('admin'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= isset($producto) ? 'Editar Producto' : 'Registrar Producto' ?> - Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { font-family: 'Segoe UI', sans-serif; background-color: #fffefc; }

    .main-content {
  margin-left: 260px;
  padding: 2rem;
}

    h2 { color: #d85e9f; font-weight: bold; margin-bottom: 1rem; }
    .form-section {
      background-color: white; border-radius: 1rem; padding: 2rem;
      box-shadow: 0 8px 25px rgba(0,0,0,0.07);
    }
    .btn-volver { color: #888; text-decoration: none; display: inline-block; margin-bottom: 1rem; }
    .btn-volver:hover { color: #555; text-decoration: underline; }
    .btn-primary { background-color: #1c9983; border: none; }
    .btn-primary:hover { background-color: #12876e; }
    .btn-danger { background-color: #d85e9f; border: none; }
    .btn-danger:hover { background-color: #c94b8d; }
    label { font-weight: 500; }
    @media (max-width: 768px) {
      .main-content { margin-left: 0; padding: 1rem; }
      .sidebar { position: static; width: 100%; border-bottom: 1px solid #cbe9e0; box-shadow: none; }
    }
  </style>
</head>
<body>

<?php include __DIR__ . '/../layouts/sidebar_admin.php'; ?>



<div class="main-content">
  <a href="javascript:history.back()" class="btn-volver"><i class="bi bi-arrow-left"></i> Volver</a>

  <div class="form-section">
    <h2><i class="bi bi-pencil-square"></i> <?= isset($producto) ? 'Editar Producto' : 'Registrar Producto' ?></h2>

    <form action="index.php?controller=Producto&action=guardar" method="post" enctype="multipart/form-data">
      <?php if (isset($producto)): ?>
        <input type="hidden" name="id" value="<?= $producto->id ?>">
      <?php endif; ?>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>Nombre</label>
          <input type="text" name="nombre" class="form-control" required value="<?= $producto->nombre ?? '' ?>">
        </div>
        <div class="col-md-6">
          <label>Precio Original</label>
          <input type="number" step="0.01" name="precio" class="form-control" required value="<?= $producto->precio_original ?? '' ?>">
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>Stock</label>
          <input type="number" name="stock" class="form-control" required value="<?= $producto->stock ?? '' ?>">
        </div>
        <div class="col-md-6">
          <label>Categoría</label>
          <select name="categoria_id" class="form-select" required>
            <option value="">-- Selecciona --</option>
            <?php while ($cat = $categorias->fetch_object()): ?>
              <option value="<?= $cat->id ?>" <?= isset($producto) && $producto->categoria_id == $cat->id ? 'selected' : '' ?>>
                <?= $cat->nombre ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>
      </div>

      <div class="mb-3">
        <label>Descripción</label>
        <textarea name="descripcion" class="form-control" required><?= $producto->descripcion ?? '' ?></textarea>
      </div>

      <div class="mb-3">
        <label>Imagen</label>
        <input type="file" name="imagen" class="form-control">
        <?php if (isset($producto) && $producto->imagen): ?>
          <p class="mt-2">Imagen actual:</p>
          <img src="uploads/<?= $producto->imagen ?>" alt="Imagen actual" width="100" class="rounded">
        <?php endif; ?>
      </div>

      <div class="row mb-3">
        <div class="col-md-6 form-check form-switch">
          <input type="checkbox" class="form-check-input" id="destacado" name="destacado" value="1"
            <?= isset($producto) && $producto->destacado ? 'checked' : '' ?>>
          <label class="form-check-label" for="destacado">¿Producto destacado?</label>
        </div>

        <div class="col-md-6 form-check form-switch">
          <input type="checkbox" class="form-check-input" id="promocion" name="promocion" value="1"
            <?= isset($producto) && $producto->promocion ? 'checked' : '' ?>>
          <label class="form-check-label" for="promocion">¿Producto en promoción?</label>
        </div>
      </div>

      <div class="row mb-3" id="grupoDescuento" style="<?= isset($producto) && $producto->promocion ? '' : 'display: none;' ?>">
        <div class="col-md-6">
          <label>Descuento (%)</label>
          <input type="number" name="descuento" min="0" max="100" step="0.01" class="form-control"
            value="<?= $producto->descuento ?? 0 ?>">
        </div>
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
      </div>
    </form>
  </div>
</div>

<script>
  const chkPromocion = document.getElementById('promocion');
  const grupoDescuento = document.getElementById('grupoDescuento');

  chkPromocion.addEventListener('change', function () {
    grupoDescuento.style.display = this.checked ? 'flex' : 'none';
  });
</script>

</body>
</html>
