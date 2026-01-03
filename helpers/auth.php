<?php
function checkAuth($role = null) {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start(); // 🔒 Necesario para acceder a $_SESSION
    }

    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?controller=Usuario&action=login");
        exit();
    }

    if ($role && $_SESSION['usuario']['rol'] !== $role) {
        echo "<p>No tienes permisos para acceder a esta sección.</p>";
        exit();
    }
}
