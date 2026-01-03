<?php
require_once 'models/Categoria.php';

class CategoriaController {

    public function index() {
    require_once 'models/Categoria.php';
    $categoria = new Categoria();

    $query = $_GET['query'] ?? '';
    $orderby = $_GET['orderby'] ?? 'id';
    $order = $_GET['order'] ?? 'asc';

    if (!empty($query)) {
        $categorias = $categoria->buscarYOrdenar($query, $orderby, $order);
    } else {
        $categorias = $categoria->getAllOrdenado($orderby, $order);
    }

    require_once 'views/categorias/index.php';
}


    public function crear() {
        require_once 'helpers/auth.php';
        checkAuth('admin');

        require_once 'views/layouts/header.php';
        require_once 'views/categorias/formulario.php';
        require_once 'views/layouts/footer.php';
    }

    public function editar() {
        require_once 'helpers/auth.php';
        checkAuth('admin');

        if (isset($_GET['id'])) {
            $c = new Categoria();
            $categoria = $c->getById($_GET['id']);

            require_once 'views/layouts/header.php';
            require_once 'views/categorias/formulario.php';
            require_once 'views/layouts/footer.php';
        }
    }

    public function guardar() {
        require_once 'helpers/auth.php';
        checkAuth('admin');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $c = new Categoria();
            $c->setNombre($_POST['nombre']);

            if (!empty($_POST['id'])) {
                $c->setId($_POST['id']);
                $c->update();
            } else {
                $c->save();
            }

            header("Location: index.php?controller=Categoria&action=index");
        }
    }

    public function eliminar() {
        require_once 'helpers/auth.php';
        checkAuth('admin');

        if (isset($_GET['id'])) {
            $c = new Categoria();
            $c->delete($_GET['id']);
            header("Location: index.php?controller=Categoria&action=index");
        }
    }
}
