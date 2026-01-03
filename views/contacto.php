<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Contáctanos - Pastelería Dieguito D & M</title>
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
    h1 {
      font-family: 'Pacifico', cursive;
      color: #d85e9f;
    }
    .breadcrumb {
      background-color: #f8f8f8;
      padding: 0.75rem 1.25rem;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .contact-section {
      background-color: #fff5fa;
      border-radius: 20px;
      padding: 3rem;
      box-shadow: 0 6px 20px rgba(0,0,0,0.06);
      max-width: 900px;
      margin: auto;
    }
    label {
      font-weight: 500;
    }
    .form-control:focus {
      border-color: #d85e9f;
      box-shadow: 0 0 0 0.2rem rgba(216, 94, 159, 0.25);
    }
    .btn-contact {
      background-color: #d85e9f;
      color: white;
      padding: 10px 30px;
      border-radius: 30px;
      transition: all 0.3s ease;
    }
    .btn-contact:hover {
      background-color: #c14686;
      transform: scale(1.05);
    }
    .social-icons i {
      font-size: 1.5rem;
      margin: 0 10px;
      color: #d85e9f;
      transition: transform 0.3s ease;
    }
    .social-icons i:hover {
      transform: scale(1.2);
    }
    footer {
      background-color: #fdeef4;
      color: #444;
      padding: 2rem 0;
      margin-top: 4rem;
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
      <li class="breadcrumb-item active" aria-current="page">Contáctanos</li>
    </ol>
  </nav>

  <!-- TÍTULO -->
  <h1 class="text-center mb-4 animate__animated animate__fadeInDown">Contáctanos</h1>
  <p class="text-center mb-4 text-muted animate__animated animate__fadeInUp">¿Tienes dudas, sugerencias o pedidos especiales? ¡Escríbenos y te responderemos lo más pronto posible!</p>

  <!-- FORMULARIO -->
  <div class="contact-section animate__animated animate__fadeIn">
    <form method="POST" action="#">
      <div class="row g-3">
        <div class="col-md-6">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="nombre" required>
        </div>
        <div class="col-md-6">
          <label for="correo" class="form-label">Correo Electrónico</label>
          <input type="email" class="form-control" id="correo" required>
        </div>
        <div class="col-12">
          <label for="asunto" class="form-label">Asunto</label>
          <input type="text" class="form-control" id="asunto" required>
        </div>
        <div class="col-12">
          <label for="mensaje" class="form-label">Mensaje</label>
          <textarea class="form-control" id="mensaje" rows="5" required></textarea>
        </div>
        <div class="col-12 text-center mt-3">
          <button type="submit" class="btn btn-contact"><i class="bi bi-send-fill"></i> Enviar Mensaje</button>
        </div>
      </div>
    </form>
  </div>

  <!-- REDES -->
  <div class="text-center mt-4">
    <p class="mb-2">También puedes encontrarnos en nuestras redes:</p>
    <div class="social-icons">
      <a href="#"><i class="bi bi-facebook"></i></a>
      <a href="#"><i class="bi bi-instagram"></i></a>
      <a href="#"><i class="bi bi-whatsapp"></i></a>
    </div>
  </div>

  <!-- BOTÓN VOLVER -->
  <div class="text-center mt-4">
    <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4"><i class="bi bi-arrow-left"></i> Volver al Inicio</a>
  </div>
</div>

<!-- FOOTER -->
<footer class="text-center mt-5">
  <div class="container">
    <p class="fw-bold">Pastelería Dieguito D & M</p>
    <p>Jr. Dulce 123 - Lima, Perú · contacto@dieguitodm.com</p>
    <p>&copy; <?= date('Y') ?> Todos los derechos reservados.</p>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
