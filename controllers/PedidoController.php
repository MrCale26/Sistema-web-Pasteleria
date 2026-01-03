<?php
require_once 'models/Pedido.php';
require_once 'models/Usuario.php';

class PedidoController {

    public function indexAdmin() {
    require_once 'helpers/auth.php';
    checkAuth('admin');

    $pedido = new Pedido();

    // Parámetros GET
    $query = $_GET['query'] ?? null;
    $orderby = $_GET['orderby'] ?? 'id';
    $order = $_GET['order'] ?? 'asc';
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $limit = 5;
    $offset = ($page - 1) * $limit;

    // Validación segura
    $camposPermitidos = ['id', 'fecha', 'cliente'];
    $ordenValido = in_array($orderby, $camposPermitidos) ? $orderby : 'id';
    $direccionValida = strtolower($order) === 'desc' ? 'DESC' : 'ASC';

    // Obtener datos
    if (!empty($query)) {
        $pedidos = $pedido->buscarYOrdenarPaginado($query, $ordenValido, $direccionValida, $limit, $offset);
        $total = $pedido->contarBusqueda($query);
    } else {
        $pedidos = $pedido->obtenerTodosOrdenadoPaginado($ordenValido, $direccionValida, $limit, $offset);
        $total = $pedido->contarTodos();
    }

    $totalPaginas = ceil($total / $limit);

    require_once 'views/layouts/header.php';
    require_once 'views/admin/pedidos/index.php';
    
}


    // Ver detalle de un pedido
    public function detalle() {
        require_once 'helpers/auth.php';
        checkAuth('admin');

        if (isset($_GET['id'])) {
            $pedido_id = $_GET['id'];
            $pedido = new Pedido();
            $detalle = $pedido->getDetalle($pedido_id);

            require_once 'views/layouts/header.php';
            require_once 'views/admin/pedidos/detalle.php';
            
        }
    }
    public function cambiarEstado() {
    require_once 'helpers/auth.php';
    checkAuth('admin');

    if (isset($_POST['pedido_id']) && isset($_POST['estado'])) {
        $pedido = new Pedido();
        $pedido->cambiarEstado($_POST['pedido_id'], $_POST['estado']);

        header("Location: index.php?controller=Pedido&action=detalle&id=" . $_POST['pedido_id']);
    }
}
    
    public function asignarEntrega() {
    require_once 'helpers/auth.php';
    checkAuth('admin');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $pedido_id = $_POST['pedido_id'];
        $empleado_id = $_POST['empleado_id'];
        $fecha_entrega = $_POST['fecha_entrega'];

        require_once 'models/Entrega.php';
        $entrega = new Entrega();

        $existe = $entrega->getByPedidoId($pedido_id);

        if ($existe) {
            echo "<p style='color:red;'>Este pedido ya tiene entrega asignada.</p>";
        } else {
            $entrega->asignar($pedido_id, $empleado_id, $fecha_entrega);
        }

        header("Location: index.php?controller=Pedido&action=detalle&id=$pedido_id");
    }
}
    public function actualizarEntrega() {
    require_once 'helpers/auth.php';
    checkAuth('admin');

    if (isset($_POST['entrega_id'], $_POST['estado'])) {
        require_once 'models/Entrega.php';
        $entrega = new Entrega();
        $entrega->actualizarEstado($_POST['entrega_id'], $_POST['estado']);

        $pedido_id = $_POST['pedido_id'];
        header("Location: index.php?controller=Pedido&action=detalle&id=$pedido_id");
    }
}
    public function resumenEntregas() {
    require_once 'helpers/auth.php';
    checkAuth('admin');

    $db = Database::connect();
    $sql = "SELECT e.id AS entrega_id, e.pedido_id, em.nombre AS empleado, e.fecha_entrega, e.estado AS estado_entrega,
                   p.estado AS estado_pedido
            FROM entregas e
            INNER JOIN empleados em ON e.empleado_id = em.id
            INNER JOIN pedidos p ON e.pedido_id = p.id
            ORDER BY e.fecha_entrega DESC";

    $entregas = $db->query($sql);

    require_once 'views/layouts/header.php';
    require_once 'views/admin/pedidos/resumen_entregas.php';
    
}

    

}
