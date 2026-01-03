<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inicia Sesión - Pastelería Dieguito D & M</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap + Iconos + Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

  <!-- Estilos visuales -->
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

    .login-container {
      background-color: #fff;
      border-radius: 1rem;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
      padding: 2.5rem 3rem;
      width: 100%;
      max-width: 450px;
      margin: 5rem auto;
      animation: fadeIn 1.2s ease;
    }

    .login-container h2 {
      text-align: center;
      color: #d85e9f;
      font-family: 'Pacifico', cursive;
      font-size: 2rem;
      margin-bottom: 2rem;
    }

    .btn-login {
      background-color: #d85e9f;
      color: #fff;
      font-weight: 600;
    }

    .btn-login:hover {
      background-color: #c94c8f;
    }

    .alerta-mensaje {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 1050;
      padding: 1rem 2rem;
      border-radius: 12px;
      background: #fff;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      animation: slideDown 0.5s ease;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .alerta-mensaje i {
      font-size: 1.2rem;
      color: #d85e9f;
    }

    .close-btn {
      background: none;
      border: none;
      margin-left: auto;
      font-size: 1.2rem;
      cursor: pointer;
      color: #888;
    }
    /* Estilo suave y moderno */
#formLogin input::placeholder {
  color: #ccc;
}

#formLogin .btn:hover {
  background-color: #c94c8f;
}

#loginMensaje {
  font-weight: 500;
  color: #d85e9f;
  animation: fadeIn 1s ease;
}

/* Curva en panel izquierdo más suave */
.login-container .col-md-5 {
  background: linear-gradient(145deg, #d5f2ea, #e6e2f3);
  clip-path: ellipse(120% 100% at 0% 50%);
}

.login-container .col-md-5 h2,
.login-container .col-md-5 p {
  color: #333;
}
.bienvenida-panel {
  background: linear-gradient(180deg, rgba(255, 200, 225, 0.7), rgba(248, 222, 238, 0.7));
  clip-path: ellipse(120% 100% at 0% 50%);
  color: #fff;
}

.bienvenida-titulo {
  font-family: 'Pacifico', cursive;
  color: #d85e9f;
  font-size: 2rem;
}

.bienvenida-texto {
  font-size: 0.95rem;
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



    

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideDown {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

<!-- ALERTA -->
<?php if (isset($_SESSION['login_mensaje'])): ?>
  <div id="alerta-top" class="alerta-mensaje">
    <i class="bi <?= $_SESSION['login_tipo'] == 'alert-success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' ?>"></i>
    <span><?= $_SESSION['login_mensaje'] ?></span>
    <button class="close-btn" onclick="document.getElementById('alerta-top').remove()">&times;</button>
  </div>
  <?php unset($_SESSION['login_mensaje'], $_SESSION['login_tipo']); ?>
<?php endif; ?>

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

<!-- LOGIN -->
<!-- LOGIN MODERNO ESTILO OVALADO SUAVE Y COMPLETO -->
<div class="container d-flex justify-content-center align-items-center flex-grow-1 my-5">
  <div class="row shadow rounded-4 overflow-hidden w-100" style="max-width: 920px; min-height: 520px; animation: fadeIn 1s ease;">
    
    <!-- Panel izquierdo: Bienvenida -->
    <div class="col-md-5 d-flex flex-column justify-content-center align-items-center text-white p-4 bienvenida-panel">
      <div class="text-center px-2">
        <h2 class="fw-bold bienvenida-titulo">¡Bienvenido!</h2>
        <p class="bienvenida-texto">Ingresa con tus datos personales para utilizar todas las funciones del sitio</p>
        <div class="social-icons mt-3">
          <a href="#"><i class="bi bi-facebook"></i></a>
          <a href="#"><i class="bi bi-instagram"></i></a>
          <a href="#"><i class="bi bi-whatsapp"></i></a>
        </div>
      </div>
    </div>

    <!-- Panel derecho: formulario -->
    <div class="col-md-7 bg-white p-5">
      <h3 class="text-center mb-4" style="color: #d85e9f; font-family: 'Pacifico', cursive;">
        <i class="bi bi-person-circle me-2"></i>Inicia sesión
      </h3>
      <form action="index.php?controller=Usuario&action=autenticar" method="post">
        <div class="mb-3">
          <label for="email" class="form-label">Correo electrónico</label>
          <input type="email" name="email" class="form-control" placeholder="ejemplo@correo.com" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <div class="input-group">
            <input type="password" name="password" id="password" class="form-control" placeholder="********" required>
            <button type="button" class="btn btn-outline-secondary" id="togglePassword" tabindex="-1">
              <i class="bi bi-eye-fill" id="eyeIcon"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="btn w-100 mt-3" style="background-color: #d85e9f; color: white; font-weight: 600;">Ingresar</button>
      </form>

      <div class="extra-links text-center mt-4">
        ¿No tienes cuenta? <a href="index.php?controller=Usuario&action=registro">Regístrate aquí</a>
      </div>
    </div>
    
  </div>
</div>

<?php include 'views/layouts/footer.php'; ?>


<script>
  // Mostrar el mensaje flotante solo por unos segundos
  const alertaTop = document.getElementById('alerta-top');
  if (alertaTop) {
    setTimeout(() => {
      alertaTop.style.opacity = '0';
      alertaTop.style.transition = 'opacity 0.8s ease';
      setTimeout(() => alertaTop.remove(), 900);
    }, 5000); // Desaparece después de 5 segundos
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const togglePassword = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('password');
  const eyeIcon = document.getElementById('eyeIcon');

  togglePassword.addEventListener('click', () => {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    eyeIcon.classList.toggle('bi-eye-fill');
    eyeIcon.classList.toggle('bi-eye-slash-fill');
  });

  // 🟢 Alerta flotante autodestructiva
  const alertaTop = document.getElementById('alerta-top');
  if (alertaTop) {
    setTimeout(() => {
      alertaTop.style.opacity = '0';
      alertaTop.style.transition = 'opacity 0.8s ease';
      setTimeout(() => alertaTop.remove(), 900);
    }, 5000);
  }
</script>

<script>
  // Mostrar el mensaje flotante solo por unos segundos
  const alertaTop = document.getElementById('alerta-top');
if (alertaTop) {
  setTimeout(() => {
    alertaTop.style.opacity = '0';
    alertaTop.style.transition = 'opacity 0.8s ease';
    setTimeout(() => alertaTop.remove(), 900);
  }, 5000);
}
</script>


</body>
</html>
