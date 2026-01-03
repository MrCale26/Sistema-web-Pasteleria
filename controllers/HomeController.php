<?php
class HomeController {
    public function index() {
    if (isset($_SESSION['usuario'])) {
        if ($_SESSION['usuario']['rol'] === 'admin') {
            header('Location: index.php?controller=Producto&action=index');
            exit;
        } elseif ($_SESSION['usuario']['rol'] === 'cliente') {
            header('Location: index.php?controller=Usuario&action=panel');
            exit;
        }
    }

    require_once 'models/Producto.php';
    $producto = new Producto();

    $destacados = $producto->getDestacados();
    $promociones = $producto->getPromociones();

    require_once 'models/Categoria.php';
    $cat = new Categoria();
    $categorias = $cat->getAll();

    require_once 'views/home.php';
}


    public function nosotros() {
  require 'views/nosotros.php';
}

public function contacto() {
    require_once 'views/contacto.php';
}
}
