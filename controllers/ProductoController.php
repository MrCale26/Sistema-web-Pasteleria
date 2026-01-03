
<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'models/Producto.php';

class ProductoController {

    public function index() {
        require_once 'helpers/auth.php';
        checkAuth('admin');

        $producto = new Producto();

        $query = $_GET['query'] ?? '';
        $orderby = $_GET['orderby'] ?? 'id';
        $order = $_GET['order'] ?? 'asc';
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $ordenValido = in_array($orderby, ['id', 'nombre', 'descripcion']) ? $orderby : 'id';
        $direccionValida = ($order === 'desc') ? 'desc' : 'asc';

        $total = $producto->contarProductos($query);
        $totalPaginas = ceil($total / $limit);

        if (!empty($query)) {
            $productos = $producto->buscarYOrdenarPaginado($query, $ordenValido, $direccionValida, $limit, $offset);
        } else {
            $productos = $producto->getAllOrdenadoPaginado($ordenValido, $direccionValida, $limit, $offset);
        }

        require_once 'views/layouts/header.php';
        require_once 'views/productos/index.php';
        
    }

    public function catalogo() {
        require_once 'models/Categoria.php';

        $producto = new Producto();
        $cat = new Categoria();

        $query = $_GET['query'] ?? '';
        $categoriaId = !empty($_GET['categoria_id']) ? $_GET['categoria_id'] : null;

        $productos = $producto->buscar($query, $categoriaId);
        $categorias = $cat->getAll();

        require_once 'views/productos/catalogo.php';
    }

    public function crear() {
        require_once 'helpers/auth.php';
        checkAuth('admin');

        require_once 'models/Categoria.php';
        $cat = new Categoria();
        $categorias = $cat->getAll();

        require_once 'views/layouts/header.php';
        require_once 'views/productos/formulario.php';
        
    }

    public function editar() {
        require_once 'helpers/auth.php';
        checkAuth('admin');

        if (isset($_GET['id'])) {
            $producto = new Producto();
            $producto = $producto->getById($_GET['id']);

            require_once 'models/Categoria.php';
            $cat = new Categoria();
            $categorias = $cat->getAll();

            require_once 'views/layouts/header.php';
            require_once 'views/productos/formulario.php';
            
        }
    }

public function guardar() {
    require_once 'helpers/auth.php';
    checkAuth('admin');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $p = new Producto();
        $nombreImagen = '';

        // Subida de imagen
        if (!empty($_FILES['imagen']['name'])) {
            $archivo = $_FILES['imagen'];
            $permitidos = ['image/jpeg', 'image/png', 'image/gif'];
            $maxSize = 2 * 1024 * 1024;

            if (in_array($archivo['type'], $permitidos) && $archivo['size'] <= $maxSize) {
                $nombreOriginal = basename($archivo['name']);
                $nombreSanitizado = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $nombreOriginal);
                $nombreImagen = uniqid() . '_' . $nombreSanitizado;
                $rutaDestino = 'uploads/' . $nombreImagen;

                if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
                    $p->setImagen($nombreImagen);
                }
            }
        }

        // Si no se cargó imagen y estamos editando, usamos la existente
        if (empty($nombreImagen) && !empty($_POST['id'])) {
            $productoExistente = new Producto();
            $productoExistente = $productoExistente->getById($_POST['id']);
            if ($productoExistente && $productoExistente->imagen) {
                $p->setImagen($productoExistente->imagen);
            }
        }

        // Datos del formulario
        $precioOriginal = $_POST['precio'] ?? 0;
        $promocion = isset($_POST['promocion']) ? 1 : 0;
        $descuento = $_POST['descuento'] ?? 0;

        // Cálculo del precio actual
        if ($promocion && $descuento > 0) {
            $precioFinal = $precioOriginal - ($precioOriginal * $descuento / 100);
        } else {
            $precioFinal = $precioOriginal;
        }

        // Asignar valores al modelo
        $p->setNombre($_POST['nombre']);
        $p->setDescripcion($_POST['descripcion']);
        $p->setPrecio($precioFinal);
        $p->setPrecioOriginal($precioOriginal);
        $p->setStock($_POST['stock']);
        $p->setCategoriaId($_POST['categoria_id'] ?? null);
        $p->setPromocion($promocion);
        $p->setDescuento($descuento);
        $p->setDestacado(isset($_POST['destacado']) ? 1 : 0);

        if (!empty($_POST['id'])) {
            $p->setId($_POST['id']);
            $p->update();
        } else {
            $p->save();
        }

        header("Location: index.php?controller=Producto&action=index");
    }
}



    public function eliminar() {
        require_once 'helpers/auth.php';
        checkAuth('admin');

        if (isset($_GET['id'])) {
            $p = new Producto();
            $success = $p->delete($_GET['id']);

            if (!$success) {
                $_SESSION['error'] = "No se puede eliminar este producto porque ya ha sido utilizado en pedidos.";
            }
        }

        header("Location: index.php?controller=Producto&action=index");
    }
        public function nosotros() {
  require 'views/nosotros.php';
}
public function contacto() {
    require_once 'views/contacto.php';
}



}
