<?php
require_once 'config/config.php';
require_once 'autoload.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Obtener controlador y acción
$controller = isset($_GET['controller']) ? $_GET['controller'] . 'Controller' : null;
$action = $_GET['action'] ?? null;

// Si no se especifica controlador ni acción
if (!$controller && !$action) {
    if (isset($_SESSION['usuario'])) {
        // Redirigir según el rol
        if ($_SESSION['usuario']['rol'] === 'admin') {
            header("Location: index.php?controller=Usuario&action=dashboard");
            exit;
        } else {
            header("Location: index.php?controller=Usuario&action=panelCliente");
            exit;
        }
    } else {
        // Mostrar vista pública desde el HomeController
        $controller = 'HomeController';
        $action = 'index';
    }
}

$controllerClass = $controller;

// Verificar existencia del controlador
if (class_exists($controllerClass)) {
    $controlador = new $controllerClass();

    // Verificar existencia del método
    if ($action && method_exists($controlador, $action)) {
        $controlador->$action();
    } else {
        echo "<h2>Error </h2><p>La acción '<strong>$action</strong>' no existe en el controlador '<strong>$controllerClass</strong>'.</p>";
    }
} else {
    echo "<h2>Error </h2><p>El controlador '<strong>$controllerClass</strong>' no existe.</p>";
}
