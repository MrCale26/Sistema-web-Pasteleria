<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro - Pastelería Dieguito D & M</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap + Iconos + Fuente -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(145deg, #fbe8f2, #e0f6f0);
      min-height: 100vh;
      margin: 0;
      display: flex;
      flex-direction: column;
    }

    .navbar {
      background-color: #fce6ef;
      box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    }

    .navbar-brand img {
      height: 45px;
      margin-right: 10px;
    }

    .navbar-brand span {
      font-family: 'Pacifico', cursive;
      font-size: 1.7rem;
      color: #d85e9f;
    }

    .navbar-nav .nav-link {
      color: #333;
      font-weight: 500;
    }

    .navbar-nav .nav-link:hover {
      color: #d85e9f;
    }
        .second-header {
      background-color: #fff1f7;
      box-shadow: 0 1px 4px rgba(0,0,0,0.05);
      position: sticky;
      top: 56px;
      z-index: 999;
    }
    .second-header ul {
      display: flex;
      justify-content: center;
      gap: 2rem;
      list-style: none;
      margin: 0;
      padding: 0.6rem 0;
    }
    .second-header a {
      text-decoration: none;
      font-weight: 500;
      color: #c94c8f;
      transition: color 0.3s;
    }
    .second-header a:hover {
      color: #a83872;
    }
    .second-header i {
      margin-right: 6px;
    }

    .btn-login-icon {
      color: #d85e9f;
      font-weight: 500;
      display: flex;
      align-items: center;
      text-decoration: none;
    }

    .btn-login-icon i {
      font-size: 1.4rem;
      margin-right: 6px;
    }
    .btn-login-icon:hover {
      text-decoration: underline;
    }

    .second-header {
      background-color: #fff1f7;
      box-shadow: 0 1px 4px rgba(0,0,0,0.05);
      position: sticky;
      top: 56px;
      z-index: 999;
    }

    .second-header ul {
      display: flex;
      justify-content: center;
      gap: 2rem;
      list-style: none;
      margin: 0;
      padding: 0.6rem 0;
    }

    .second-header a {
      text-decoration: none;
      font-weight: 500;
      color: #c94c8f;
    }

    .second-header a:hover {
      color: #a83872;
    }

    .registro-container {
      margin: 5rem auto;
      max-width: 920px;
      width: 100%;
      display: flex;
      flex-wrap: wrap;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
      border-radius: 1rem;
      overflow: hidden;
      background-color: #fff;
    }

    .bienvenida-panel {
      background: linear-gradient(180deg, rgba(255, 200, 225, 0.7), rgba(248, 222, 238, 0.7));
      clip-path: ellipse(120% 100% at 0% 50%);
      color: #fff;
      padding: 2rem;
    }

    .bienvenida-panel h2 {
      font-family: 'Pacifico', cursive;
      color: #d85e9f;
    }

    .bienvenida-panel p {
      color: #6d3a5f;
    }

    .social-icons a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background-color: rgba(255,255,255,0.9);
      color: #d85e9f;
      font-size: 1.3rem;
      width: 40px;
      height: 40px;
      margin: 0 8px;
      border-radius: 50%;
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
      transition: transform 0.3s ease, background-color 0.3s;
    }

    .social-icons a:hover {
      background-color: #fbe5f0;
      transform: translateY(-2px);
    }

    .formulario-panel {
      padding: 2.5rem 3rem;
      flex: 1 1 500px;
    }

    .formulario-panel h3 {
      text-align: center;
      color: #d85e9f;
      font-family: 'Pacifico', cursive;
      margin-bottom: 2rem;
    }

    .form-control {
      border-radius: .5rem;
    }

    .btn-register {
      background-color: #d85e9f;
      border: none;
      font-weight: 600;
      color: white;
    }

    .btn-register:hover {
      background-color: #c34e91;
    }

    .extra-links {
      text-align: center;
      margin-top: 1.5rem;
    }

    .extra-links a {
      color: #d85e9f;
      font-weight: 500;
      text-decoration: none;
    }

    .extra-links a:hover {
      text-decoration: underline;
    }

  </style>
</head>
<body>

<!-- HEADER -->
<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <img src="assets/img/logo.png" alt="Logo">
      <span>Dieguito D & M</span>
    </a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
      <a href="index.php?controller=Usuario&action=login" class="btn-login-icon me-3">
        <i class="bi bi-person-circle"></i>
        <?= isset($_SESSION['usuario']) ? htmlspecialchars($_SESSION['usuario']['nombre']) : 'Hola, inicia sesión' ?>
      </a>
    </div>
  </div>
</nav>

<!-- SEGUNDO HEADER -->
<div class="second-header">
  <ul>
    <li><a href="index.php"><i class="bi bi-house-door"></i>Inicio</a></li>
    <li><a href="index.php#catalogo"><i class="bi bi-box-seam"></i>Catálogo</a></li>
    <li><a href="index.php?controller=Home&action=nosotros"><i class="bi bi-people"></i>Nosotros</a></li>
    <li><a href="index.php?controller=Home&action=contacto"><i class="bi bi-envelope"></i>Contáctanos</a></li>
  </ul>
</div>

<!-- FORMULARIO REGISTRO CON PANEL DE BIENVENIDA -->
<div class="registro-container">

  <!-- Panel izquierdo de bienvenida -->
  <div class="col-md-5 d-flex flex-column justify-content-center align-items-center bienvenida-panel">
    <div class="text-center px-2">
      <h2 class="fw-bold">¡Bienvenido!</h2>
      <p class="bienvenida-texto">Regístrate para acceder a los mejores productos de la pastelería</p>
      <div class="social-icons mt-3">
        <a href="#"><i class="bi bi-facebook"></i></a>
        <a href="#"><i class="bi bi-instagram"></i></a>
        <a href="#"><i class="bi bi-whatsapp"></i></a>
      </div>
    </div>
  </div>

  <!-- Formulario de registro -->
  <div class="formulario-panel">
    <h3><i class="bi bi-person-plus-fill me-2"></i>Crear cuenta</h3>

    <form action="index.php?controller=Usuario&action=guardarRegistro" method="post">
      <div class="mb-3">
        <label for="nombre" class="form-label"><i class="bi bi-person-fill me-1"></i>Nombre completo</label>
        <input type="text" name="nombre" id="nombre" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label"><i class="bi bi-envelope-fill me-1"></i>Correo electrónico</label>
        <input type="email" name="email" id="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label"><i class="bi bi-lock-fill me-1"></i>Contraseña</label>
        <input type="password" name="password" id="password" class="form-control" required minlength="6">
      </div>

      <div class="mb-3">
        <label for="telefono" class="form-label"><i class="bi bi-telephone-fill me-1"></i>Teléfono</label>
        <input type="text" name="telefono" id="telefono" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="direccion" class="form-label"><i class="bi bi-geo-alt-fill me-1"></i>Dirección</label>
        <textarea name="direccion" id="direccion" class="form-control" rows="2" required></textarea>
      </div>

      <button type="submit" class="btn btn-register w-100">Registrarse</button>
    </form>

    <div class="extra-links mt-3">
      ¿Ya tienes cuenta? <a href="index.php?controller=Usuario&action=login">Inicia sesión aquí</a>
    </div>
  </div>

</div>

<?php include 'views/layouts/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
