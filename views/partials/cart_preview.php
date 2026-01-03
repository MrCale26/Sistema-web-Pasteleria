<?php if (!empty($_SESSION['carrito'])): ?>
  <p class="mb-2 fw-bold text-center">🛍 Tu Carrito</p>
  <div id="cartItems" style="max-height: 250px; overflow-y: auto;">
    <?php foreach ($_SESSION['carrito'] as $id => $item): ?>
      <div class="d-flex align-items-center mb-2 border-bottom pb-2 bg-light rounded px-2 py-1 shadow-sm">
        <img src="uploads/<?= rawurlencode($item['imagen'] ?? 'noimg.jpg') ?>" alt="" width="45" height="45" class="rounded me-2" style="object-fit: cover; background: #fff4f8;">
        <div class="flex-grow-1">
          <div class="fw-semibold small text-dark"><?= htmlspecialchars($item['nombre']) ?></div>
          <div class="d-flex align-items-center">
            <button class="btn btn-sm btn-outline-danger py-0 px-2 btn-restar" data-id="<?= $id ?>">−</button>
            <span class="mx-2"><?= $item['cantidad'] ?></span>
            <button class="btn btn-sm btn-outline-primary py-0 px-2 btn-sumar" data-id="<?= $id ?>">+</button>
          </div>
        </div>
        <div class="text-end small fw-semibold text-success ms-2">
          S/ <?= number_format($item['precio'] * $item['cantidad'], 2) ?>
        </div>
        <!-- Botón eliminar con ícono -->
        <button class="btn btn-sm btn-outline-dark ms-2 btn-eliminar-item" data-id="<?= $id ?>" title="Eliminar">
          <i class="bi bi-trash-fill"></i>
        </button>
      </div>
    <?php endforeach; ?>
  </div>

  <hr>
  <div class="text-end fw-bold mb-2 text-dark">
    Total:
    <span id="cartTotal" class="text-danger">
      S/ <?= number_format(array_reduce($_SESSION['carrito'], fn($c, $i) => $c + $i['precio'] * $i['cantidad'], 0), 2) ?>
    </span>
  </div>
  <a href="index.php?controller=Carrito&action=ver" class="btn w-100 shadow-sm" style="background-color:#d85e9f; color: white;">
    <i class="bi bi-eye"></i> Ver carrito completo
  </a>
<?php else: ?>
  <div class="text-muted small text-center">Tu carrito está vacío.</div>
<?php endif; ?>
