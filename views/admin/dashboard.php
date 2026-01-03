<?php
require_once __DIR__ . '/../../helpers/auth.php';
checkAuth('admin');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel Admin - Pastelería Dieguito D & M</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://unpkg.com/phosphor-icons@1.4.2/src/css/phosphor.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Estilos -->
  <style>
    body {
      background-color: #f5f7fb;
      font-family: 'Poppins', sans-serif;
      margin: 0;
      overflow-x: hidden;
    }

    .sidebar {
      width: 250px;
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

    .content {
      margin-left: 260px;
      padding: 2rem;
    }

    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #fff;
      padding: 1rem 2rem;
      border-radius: 16px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.05);
      margin-bottom: 2rem;
      flex-wrap: wrap;
    }

    .top-actions {
      display: flex;
      align-items: center;
      gap: 1.5rem;
    }

    .search-box input {
      border: none;
      border-radius: 20px;
      padding: 0.5rem 1rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      outline: none;
    }

    .icon-btn {
      position: relative;
      font-size: 1.4rem;
      cursor: pointer;
      color: #6c5ce7;
    }

    .icon-btn .badge {
      position: absolute;
      top: -5px;
      right: -5px;
      background: red;
      color: white;
      border-radius: 50%;
      font-size: 0.6rem;
      padding: 2px 5px;
    }

    .user-dropdown {
      position: relative;
    }

    .dropdown-menu {
      position: absolute;
      top: 120%;
      right: 0;
      background: white;
      border-radius: 8px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.1);
      padding: 0.5rem 1rem;
      display: none;
      animation: fadeIn 0.3s ease;
      z-index: 10;
    }

    .dropdown-menu a {
      text-decoration: none;
      color: #e3342f;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
    }

    .card-box {
      background: #fff;
      border-radius: 1rem;
      padding: 1.5rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .card-box i {
      font-size: 2rem;
      color: #6c5ce7;
      margin-bottom: 0.5rem;
    }

    .card-box h5 {
      font-size: 1.2rem;
      margin-bottom: 0.3rem;
    }

    .card-box a {
      text-decoration: none;
      color: #6c5ce7;
      font-weight: 500;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media(max-width: 768px) {
      .sidebar {
        display: none;
      }

      .content {
        margin-left: 0;
      }

      .top-bar {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
      }
    }
    canvas {
  max-height: 280px;
}



  </style>
</head>
<body>

<!-- Sidebar -->
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

<!-- Contenido -->
<div class="content">
  <div class="top-bar">
    <div>
      <h4>Bienvenido, <?= $_SESSION['usuario']['nombre'] ?></h4>
      <p class="text-muted mb-0">Panel de administración general</p>
    </div>
    <div class="top-actions">
      <div class="search-box">
        <input type="text" placeholder="Buscar...">
      </div>
      <div class="icon-btn">
        <i class="bi bi-bell-fill"></i>
        <span class="badge">3</span>
      </div>
      <div class="user-dropdown">
        <i class="bi bi-person-circle icon-btn" id="userToggle"></i>
        <div class="dropdown-menu" id="dropdownMenu">
          <a href="index.php?controller=Usuario&action=logout">
            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Tarjetas -->
  <div class="cards">
    <div class="card-box">
      <i class="bi bi-box-seam"></i>
      <h5>Productos</h5>
      <a href="index.php?controller=Producto&action=index">Gestionar</a>
    </div>
    <div class="card-box">
      <i class="bi bi-folder2-open"></i>
      <h5>Categorías</h5>
      <a href="index.php?controller=Categoria&action=index">Gestionar</a>
    </div>
    <div class="card-box">
      <i class="bi bi-receipt-cutoff"></i>
      <h5>Pedidos</h5>
      <a href="index.php?controller=Pedido&action=indexAdmin">Gestionar</a>
    </div>
    <div class="card-box">
      <i class="bi bi-person-badge"></i>
      <h5>Empleados</h5>
      <a href="index.php?controller=Empleado&action=index">Gestionar</a>
    </div>
    <div class="card-box">
      <i class="bi bi-people-fill"></i>
      <h5>Usuarios</h5>
      <a href="index.php?controller=Usuario&action=indexAdmin">Gestionar</a>
    </div>
    <div class="card-box">
      <i class="bi bi-truck"></i>
      <h5>Entregas</h5>
      <a href="index.php?controller=Pedido&action=resumenEntregas">Ver resumen</a>
    </div>
    <div class="card-box">
      <i class="bi bi-cash-stack"></i>
      <h5>Pagos</h5>
      <a href="index.php?controller=Usuario&action=resumenPagos">Ver resumen</a>
    </div>
  </div>
</div>

<!-- Gráficos -->
  <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 mt-4">
    <div class="col-md-6 mb-4">
      <div class="card-box" style="height: 100%;">
        <h5 class="mb-3">Productos más vendidos</h5>
        <canvas id="productosVendidosChart"></canvas>
      </div>
    </div>
    <div class="col-md-6 mb-4">
      <div class="card-box" style="height: 100%;">
        <h5 class="mb-3">Ventas semanales</h5>
        <canvas id="ventasSemanalesChart"></canvas>
      </div>
    </div>
    <div class="col-md-6 mb-4">
      <div class="card-box" style="height: 100%;">
        <h5 class="mb-3">Pedidos por estado</h5>
        <canvas id="pedidosEstadoChart"></canvas>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-4 mb-4">
    <div class="card-box" style="height: 100%;">
      <h5 class="mb-3">Ingresos quincenales</h5>
      <canvas id="ingresosQuincenalesChart" style="max-height: 280px;"></canvas>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Gráfico de barras - Productos más vendidos
  const productosVendidosChart = new Chart(document.getElementById('productosVendidosChart'), {
    type: 'bar',
    data: {
      labels: ['Torta chocolate', 'Cupcakes', 'Cheesecake', 'Brownies', 'Panetón'],
      datasets: [{
        label: 'Unidades vendidas',
        data: [120, 90, 75, 60, 40],
        backgroundColor: '#6c5ce7'
      }]
    },
    options: {
      indexAxis: 'y',
      responsive: true,
      plugins: { legend: { display: false } }
    }
  });

  // Gráfico de líneas - Ventas semanales
  const ventasSemanalesChart = new Chart(document.getElementById('ventasSemanalesChart'), {
    type: 'line',
    data: {
      labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
      datasets: [{
        label: 'Ventas (S/.)',
        data: [120, 180, 150, 200, 250, 300, 220],
        borderColor: '#00b894',
        backgroundColor: 'rgba(0, 184, 148, 0.1)',
        fill: true,
        tension: 0.3
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { position: 'top' } }
    }
  });

  // Gráfico de dona - Pedidos por estado
  const pedidosEstadoChart = new Chart(document.getElementById('pedidosEstadoChart'), {
    type: 'doughnut',
    data: {
      labels: ['Pendientes', 'En camino', 'Entregados', 'Cancelados'],
      datasets: [{
        data: [12, 8, 30, 3],
        backgroundColor: ['#ffeaa7', '#74b9ff', '#55efc4', '#ff7675']
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'bottom' }
      }
    }
  });
  // Gráfico de barras - Ingresos quincenales
const ingresosQuincenalesChart = new Chart(document.getElementById('ingresosQuincenalesChart'), {
  type: 'bar',
  data: {
    labels: ['1ra Quincena Julio', '2da Quincena Julio', '1ra Quincena Agosto'],
    datasets: [{
      label: 'Ingresos (S/.)',
      data: [1800, 2450, 1980],
      backgroundColor: '#fd79a8'
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { position: 'top' }
    },
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});

</script>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('userToggle').addEventListener('click', () => {
    const menu = document.getElementById('dropdownMenu');
    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
  });

  // Cierra dropdown si haces clic fuera
  document.addEventListener('click', (e) => {
    const toggle = document.getElementById('userToggle');
    const menu = document.getElementById('dropdownMenu');
    if (!toggle.contains(e.target) && !menu.contains(e.target)) {
      menu.style.display = 'none';
    }
  });
</script>
</body>
</html>
