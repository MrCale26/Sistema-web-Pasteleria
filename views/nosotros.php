<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Nosotros - Pastelería Dieguito D & M</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap + Iconos + Fuentes -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet"/>

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fefeff;
    }
    h1, h2 {
      font-family: 'Pacifico', cursive;
      color: #d85e9f;
    }
    .breadcrumb {
      background-color: #f8f8f8;
      padding: 0.75rem 1.25rem;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .seccion-contenido {
      background-color: #fff5fa;
      border: 1px solid #f0dbe7;
      border-radius: 15px;
      padding: 2.5rem;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .quienes-somos {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: center;
      gap: 2rem;
    }
    .quienes-somos .text {
      flex: 1 1 400px;
    }
    .quienes-somos .text p {
      font-size: 1.1rem;
      line-height: 1.8;
      color: #444;
    }
    .quienes-somos .image {
      flex: 1 1 300px;
      text-align: center;
    }
    .quienes-somos img {
      border-radius: 1rem;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      max-width: 100%;
      transition: transform 0.3s;
    }
    .quienes-somos img:hover {
      transform: scale(1.03);
    }
    .timeline {
      position: relative;
      padding: 2rem 0;
    }
    .timeline::before {
      content: '';
      position: absolute;
      left: 50%;
      width: 4px;
      background-color: #e3e3e3;
      top: 0;
      bottom: 0;
      transform: translateX(-50%);
    }
    .timeline-event {
      position: relative;
      width: 50%;
      padding: 2rem;
      box-sizing: border-box;
    }
    .timeline-event.left {
      left: 0;
      text-align: right;
    }
    .timeline-event.right {
      left: 50%;
    }
    .timeline-event::before {
      content: '';
      position: absolute;
      top: 30px;
      width: 20px;
      height: 20px;
      background-color: #d85e9f;
      border-radius: 50%;
      border: 3px solid white;
      z-index: 10;
    }
    .timeline-event.left::before {
      right: -10px;
    }
    .timeline-event.right::before {
      left: -10px;
    }
    .timeline-content {
      background: #fff;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    .btn-volver {
      background-color: #d85e9f;
      color: white;
      border-radius: 30px;
      padding: 10px 25px;
      transition: all 0.3s ease;
    }
    .btn-volver:hover {
      background-color: #c14686;
      transform: scale(1.05);
    }
    .chef-firma {
      background: #fffdfd;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.07);
      display: inline-block;
    }
    @media (max-width: 768px) {
      .quienes-somos {
        flex-direction: column;
      }
      .timeline::before { left: 20px; }
      .timeline-event {
        width: 100%;
        padding-left: 40px;
        padding-right: 0;
      }
      .timeline-event.left,
      .timeline-event.right {
        left: 0;
        text-align: left;
      }
      .timeline-event::before {
        left: 0;
        top: 15px;
      }
    }
    footer {
      background-color: #fdeef4;
      color: #444;
      padding: 2rem 0;
      margin-top: 4rem;
    }
    .footer-icons i {
      font-size: 1.5rem;
      margin: 0 12px;
      color: #d85e9f;
      transition: transform 0.3s;
    }
    .footer-icons i:hover {
      transform: scale(1.3);
    }
  </style>
</head>
<body>

<!-- CONTENIDO -->
<div class="container mt-4">

  <!-- BREADCRUMB -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-dark"><i class="bi bi-house-door-fill"></i> Inicio</a></li>
      <li class="breadcrumb-item active" aria-current="page">Nosotros</li>
    </ol>
  </nav>

  <!-- SECCIÓN QUIÉNES SOMOS -->
  <div class="seccion-contenido animate__animated animate__fadeInUp">
    <h1 class="text-center mb-4">¿Quiénes Somos?</h1>
    <div class="quienes-somos">
      <div class="text">
        <p>En <strong>Dieguito D & M</strong> no solo horneamos dulces, creamos experiencias que perduran en el recuerdo. Cada torta, cada bocadito y cada pastel está preparado con cariño, combinando tradición, creatividad y pasión por la repostería.</p>
        <p>Desde nuestros inicios en una cocina familiar hasta convertirnos en un referente local, mantenemos intacto nuestro compromiso con la calidad, la innovación y el buen servicio. Somos una familia que comparte amor a través del sabor.</p>
        <p>Nos inspira la alegría de nuestros clientes, la celebración de momentos especiales y la oportunidad de endulzar vidas día a día.</p>
      </div>
      <div class="image">
        <img src="assets/img/equipo_pasteleria.jpg" alt="Nuestro equipo" class="img-fluid">
      </div>
    </div>
  </div>

<!-- HISTORIA -->
<h2 class="text-center my-5 animate__animated animate__fadeInDown">Nuestra Historia</h2>
<div class="timeline">

  <!-- 2012 -->
  <div class="timeline-event left animate__animated animate__fadeInLeft">
    <div class="timeline-content d-flex flex-column flex-md-row align-items-center">
      <div class="me-md-3 mb-3 mb-md-0 text-center">
        <img src="assets/img/historia/2012.jpg" alt="Historia 2012" class="img-fluid rounded shadow" style="max-width: 160px;">
      </div>
      <div>
        <h5>2012</h5>
        <p>Nace Dieguito D & M como un cálido emprendimiento familiar, dando sus primeros pasos desde casa con recetas tradicionales transmitidas de generación en generación, llenas de historia y sabor.</p>
      </div>
    </div>
  </div>

  <!-- 2014 -->
  <div class="timeline-event right animate__animated animate__fadeInRight">
    <div class="timeline-content d-flex flex-column flex-md-row align-items-center">
      <div class="me-md-3 mb-3 mb-md-0 text-center order-md-2">
        <img src="assets/img/historia/2014.jpg" alt="Historia 2014" class="img-fluid rounded shadow" style="max-width: 160px;">
      </div>
      <div class="order-md-1">
        <h5>2014</h5>
        <p>Participamos en ferias locales con nuestros dulces caseros, generando una comunidad de clientes fieles.</p>
      </div>
    </div>
  </div>

  <!-- 2016 -->
  <div class="timeline-event left animate__animated animate__fadeInLeft">
    <div class="timeline-content d-flex flex-column flex-md-row align-items-center">
      <div class="me-md-3 mb-3 mb-md-0 text-center">
        <img src="assets/img/historia/2016.jpg" alt="Historia 2016" class="img-fluid rounded shadow" style="max-width: 160px;">
      </div>
      <div>
        <h5>2016</h5>
        <p>Abrimos con ilusión nuestro primer local físico, marcando un gran paso en nuestra historia. Este espacio no solo nos permitió atender directamente a nuestros clientes, sino también ofrecer una experiencia más cercana, cálida y profesional, donde cada visita se convirtió en parte de nuestra familia pastelera.</p>
      </div>
    </div>
  </div>

  <!-- 2019 -->
  <div class="timeline-event right animate__animated animate__fadeInRight">
    <div class="timeline-content d-flex flex-column flex-md-row align-items-center">
      <div class="me-md-3 mb-3 mb-md-0 text-center order-md-2">
        <img src="assets/img/historia/2019.jpg" alt="Historia 2019" class="img-fluid rounded shadow" style="max-width: 160px;">
      </div>
      <div class="order-md-1">
        <h5>2019</h5>
        <p>Nos consolidamos como una pastelería reconocida a nivel local, gracias a la calidad constante de nuestros productos y al cariño de nuestros clientes, quienes depositaron su confianza en cada uno de nuestros dulces.</p>
      </div>
    </div>
  </div>

  <!-- 2025 -->
  <div class="timeline-event left animate__animated animate__fadeInLeft">
    <div class="timeline-content d-flex flex-column flex-md-row align-items-center">
      <div class="me-md-3 mb-3 mb-md-0 text-center">
        <img src="assets/img/historia/2023.jpg" alt="Historia 2023" class="img-fluid rounded shadow" style="max-width: 160px;">
      </div>
      <div>
        <h5>2025</h5>
        <p>Mejoramos nuestra infraestructura operativa y sentamos las bases para una transformación digital completa. Modernizamos nuestros canales, incorporamos pedidos online, promociones exclusivas y atención personalizada. Como siguiente paso, proyectamos el desarrollo de un sistema web integral que eleve aún más la experiencia de nuestros clientes.</p>
      </div>
    </div>
  </div>

</div>


  <!-- CHEF -->
  <div class="text-center mt-5 animate__animated animate__fadeInUp">
    <div class="chef-firma">
      <img src="assets/img/rosalyn.jpg" alt="Chef" class="rounded-circle shadow" width="120">
      <h5 class="mt-3 fw-bold">Rosalyn Picón</h5>
      <p class="text-muted">Chef Directora</p>
    </div>
  </div>

  <!-- BOTÓN VOLVER -->
  <div class="text-center mt-4">
    <a href="index.php" class="btn btn-volver"><i class="bi bi-arrow-left"></i> Volver al Inicio</a>
  </div>

</div>

<!-- FOOTER -->
<?php include 'views/layouts/footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
