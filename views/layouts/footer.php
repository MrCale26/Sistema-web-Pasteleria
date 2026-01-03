<?php
require_once 'models/Categoria.php';
$categoria = new Categoria();
$categorias = $categoria->getAll();
?>

<!-- FOOTER REDISEÑADO PROFESIONAL -->
<footer class="footer-rosa mt-5 position-relative pt-5">
  <div class="footer-wave"></div>

  <div class="container py-5">
    <div class="row">

      <!-- LOGO Y REDES -->
      <div class="col-md-3 text-center text-md-start mb-4">
        <h1 class="display-3 fw-bold" style="font-family:'Pacifico', cursive; color:#d85e9f;">D</h1>
        <p class="text-muted small">Dieguito D & M · Pastelería</p>
        <div class="social-icons mt-3">
          <a href="https://facebook.com" target="_blank"><i class="bi bi-facebook"></i></a>
          <a href="https://instagram.com" target="_blank"><i class="bi bi-instagram"></i></a>
          <a href="https://wa.me/51999999999" target="_blank"><i class="bi bi-whatsapp"></i></a>
          <a href="https://tiktok.com" target="_blank"><i class="bi bi-tiktok"></i></a>
          <a href="mailto:contacto@dieguitodm.com"><i class="bi bi-envelope-fill"></i></a>
        </div>
      </div>

      <!-- CATEGORÍAS -->
      <div class="col-md-3 mb-4">
        <h6 class="fw-bold text-dark">Categorías</h6>
        <ul class="list-unstyled">
          <?php foreach($categorias as $cat): ?>
            <li><a href="index.php?controller=Producto&action=catalogo&id_categoria=<?= $cat['id'] ?>">
              <?= htmlspecialchars($cat['nombre']) ?>
            </a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- LINKS -->
      <div class="col-md-3 mb-4">
        <h6 class="fw-bold text-dark">Links de Interés</h6>
        <ul class="list-unstyled">
          <li><a href="#">Newsletters</a></li>
          <li><a href="#">Términos y Condiciones</a></li>
          <li><a href="#">Servicio al Cliente</a></li>
          <li><a href="#">Libro de Reclamaciones</a></li>
          <li><a href="#">Trabaja con Nosotros</a></li>
        </ul>
      </div>

      <!-- OPCIONES -->
      <div class="col-md-3 mb-4">
        <h6 class="fw-bold text-dark">Opciones del Sitio</h6>
        <ul class="list-unstyled">
          <li><a href="index.php">Inicio</a></li>
          <li><a href="index.php?controller=Usuario&action=registro">Registrarse</a></li>
          <li><a href="index.php?controller=Usuario&action=login">Iniciar Sesión</a></li>
          <li><a href="index.php?controller=Home&action=contacto">Contáctanos</a></li>
        </ul>
      </div>

    </div>

    <div class="text-center text-muted small mt-4">
      &copy; <?= date('Y') ?> Dieguito D & M · Todos los derechos reservados · <a href="#">Política de Privacidad</a>
    </div>
  </div>
</footer>

<!-- ESTILOS FOOTER -->
<style>
.footer-rosa {
  background: #fce4ef;
  color: #555;
}

.footer-rosa .social-icons a {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background: white;
  color: #d85e9f;
  font-size: 1.2rem;
  width: 36px;
  height: 36px;
  margin: 0 6px;
  border-radius: 50%;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  transition: all 0.3s ease;
}

.footer-rosa .social-icons a:hover {
  transform: scale(1.1);
  background-color: #fbd4e5;
}

.footer-rosa a {
  text-decoration: none;
  color: #555;
  font-size: 0.95rem;
}
.footer-rosa a:hover {
  color: #d85e9f;
}

/* OLA SUPERIOR ANIMADA */
.footer-wave {
  position: absolute;
  top: -90px;
  left: 0;
  width: 100%;
  height: 120px;
  background: url('assets/img/wave.svg') repeat-x;
  background-size: cover;
  animation: waveMove 10s linear infinite;
  z-index: 0;
}
@keyframes waveMove {
  0% { background-position-x: 0; }
  100% { background-position-x: 1000px; }
}
</style>
