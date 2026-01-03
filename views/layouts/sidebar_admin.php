<!-- SIDEBAR ADMIN -->
<div class="sidebar">
  <h3>Dieguito D&M</h3>
  <a href="index.php?controller=Usuario&action=dashboard"><i class="bi bi-speedometer2"></i> Panel Principal</a>
  <a href="index.php?controller=Producto&action=index"><i class="bi bi-box-seam"></i> Productos</a>
  <a href="index.php?controller=Categoria&action=index"><i class="bi bi-folder2-open"></i> Categorías</a>
  <a href="index.php?controller=Pedido&action=indexAdmin"><i class="bi bi-receipt-cutoff"></i> Pedidos</a>
  <a href="index.php?controller=Empleado&action=index"><i class="bi bi-person-badge"></i> Empleados</a>
  <a href="index.php?controller=Usuario&action=indexAdmin"><i class="bi bi-people-fill"></i> Usuarios</a>
  <a href="index.php?controller=Pedido&action=resumenEntregas"><i class="bi bi-truck"></i> Entregas</a>
  <a href="index.php?controller=Usuario&action=resumenPagos"><i class="bi bi-cash-stack"></i> Pagos</a>
</div>

<style>
  .sidebar {
    width: 260px;
    background: linear-gradient(180deg, #ffffff, #f1f3f8);
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    padding: 2rem 1rem;
    box-shadow: 2px 0 12px rgba(0, 0, 0, 0.06);
    z-index: 1000;
  }

  .sidebar h3 {
    color: #553d67;
    font-weight: bold;
    text-align: center;
    margin-bottom: 2rem;
  }

  .sidebar a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0.75rem 1rem;
    color: #4b5563;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s;
    margin-bottom: 0.5rem;
    background-color: #fff;
    border: 1px solid #e0e0e0;
    border-left: 4px solid transparent;
  }

  .sidebar a:hover {
    background-color: #f5f5f5;
    color: #5a67d8;
    border-left: 4px solid #6c5ce7;
  }

  @media(max-width: 768px) {
    .sidebar {
      display: none;
    }
  }
</style>
