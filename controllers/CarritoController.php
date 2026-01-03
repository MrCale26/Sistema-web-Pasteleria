<?php
class CarritoController {
    public function agregar() {
        if (!isset($_GET['id'])) {
            header('Location: index.php?controller=Producto&action=catalogo');
            return;
        }

        $id = intval($_GET['id']);

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad']++;
        } else {
            $productoModel = new Producto();
            $producto = $productoModel->getById($id);

            if (!$producto) {
                header('Location: index.php?controller=Producto&action=catalogo');
                return;
            }

            $_SESSION['carrito'][$id] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1,
                'imagen' => $producto->imagen
            ];
        }

        header('Location: index.php?controller=Producto&action=catalogo');
    }

    public function ver() {
        if (!isset($_SESSION)) session_start();
        require_once 'views/carrito/ver.php';
    }

    public function vaciar() {
        if (!isset($_SESSION)) session_start();
        unset($_SESSION['carrito']);
        header('Location: index.php?controller=Carrito&action=ver');
        exit;
    }

    public function modificar() {
        if (!isset($_SESSION)) session_start();

        if (isset($_POST['id'], $_POST['accion'])) {
            $id = $_POST['id'];
            $accion = $_POST['accion'];

            if (isset($_SESSION['carrito'][$id])) {
                if ($accion === 'sumar') {
                    $_SESSION['carrito'][$id]['cantidad']++;
                } elseif ($accion === 'restar') {
                    $_SESSION['carrito'][$id]['cantidad']--;
                    if ($_SESSION['carrito'][$id]['cantidad'] <= 0) {
                        unset($_SESSION['carrito'][$id]);
                    }
                }
            }
        }

        header('Location: index.php?controller=Carrito&action=ver');
        exit;
    }

    public function confirmar() {
        if (!isset($_SESSION)) session_start();

        if (!isset($_SESSION['usuario']) || empty($_SESSION['carrito'])) {
            echo "<p style='color:red;'>Debes estar logueado y tener productos en el carrito.</p>";
            return;
        }

        require_once 'config/database.php';
        $db = Database::connect();

        $usuarioId = $_SESSION['usuario']['id'];
        $carrito = $_SESSION['carrito'];

        $sqlCliente = $db->prepare("SELECT id FROM clientes WHERE usuario_id = ?");
        $sqlCliente->bind_param("i", $usuarioId);
        $sqlCliente->execute();
        $resCliente = $sqlCliente->get_result();

        if ($resCliente->num_rows === 0) {
            echo "<p style='color:red;'>No se encontró el cliente asociado a este usuario.</p>";
            return;
        }

        $clienteId = $resCliente->fetch_assoc()['id'];

        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        $stmtPedido = $db->prepare("INSERT INTO pedidos (cliente_id, total) VALUES (?, ?)");
        $stmtPedido->bind_param("id", $clienteId, $total);
        $stmtPedido->execute();

        $pedidoId = $stmtPedido->insert_id;

        $stmtDetalle = $db->prepare("INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");

        foreach ($carrito as $productoId => $item) {
            $cantidad = $item['cantidad'];
            $precio = $item['precio'];
            $subtotal = $precio * $cantidad;
            $stmtDetalle->bind_param("iiidd", $pedidoId, $productoId, $cantidad, $precio, $subtotal);
            $stmtDetalle->execute();
        }

        unset($_SESSION['carrito']);

        echo "<p style='color:green;'>Pedido confirmado exitosamente. Gracias por tu compra.</p>";
        echo "<a href='index.php?controller=Usuario&action=panelCliente' class='btn btn-primary mt-3'>Volver al panel</a>";
    }

    public function pagar() {
        require_once 'helpers/auth.php';
        checkAuth('cliente');

        if (!isset($_SESSION)) session_start();
        require_once 'config/database.php';
        $db = Database::connect();

        if (empty($_SESSION['carrito'])) {
            echo "<p style='color:red;'>Tu carrito está vacío.</p>";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $metodo = $_POST['metodo'];
            $usuarioId = $_SESSION['usuario']['id'];

            $stmtCliente = $db->prepare("SELECT id FROM clientes WHERE usuario_id = ?");
            $stmtCliente->bind_param("i", $usuarioId);
            $stmtCliente->execute();
            $resCliente = $stmtCliente->get_result();

            if ($resCliente->num_rows === 0) {
                echo "<p style='color:red;'>No se encontró el cliente asociado a este usuario.</p>";
                return;
            }

            $clienteId = $resCliente->fetch_assoc()['id'];

            $total = 0;
            foreach ($_SESSION['carrito'] as $item) {
                $total += $item['precio'] * $item['cantidad'];
            }

            $stmtPedido = $db->prepare("INSERT INTO pedidos (cliente_id, total) VALUES (?, ?)");
            $stmtPedido->bind_param("id", $clienteId, $total);
            $stmtPedido->execute();
            $pedidoId = $stmtPedido->insert_id;

            $stmtDetalle = $db->prepare("INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");

            foreach ($_SESSION['carrito'] as $prodId => $item) {
                $subtotal = $item['precio'] * $item['cantidad'];
                $stmtDetalle->bind_param("iiidd", $pedidoId, $prodId, $item['cantidad'], $item['precio'], $subtotal);
                $stmtDetalle->execute();
            }

            $stmtPago = $db->prepare("INSERT INTO pagos (pedido_id, metodo, monto, estado) VALUES (?, ?, ?, 'completado')");
            $stmtPago->bind_param("isd", $pedidoId, $metodo, $total);
            $stmtPago->execute();

            unset($_SESSION['carrito']);

            echo "<div class='alert alert-success text-center w-50 mx-auto'>
                    Pedido registrado y pagado correctamente con <strong>$metodo</strong>.<br>
                    <a href='index.php?controller=Usuario&action=misPedidos' class='btn btn-outline-success mt-2'>Ver mis pedidos</a>
                  </div>";
            return;
        }

        require_once 'views/cliente/pagar.php';
    }

    public function agregarAjax() {
        $id = $_POST['id'] ?? 0;
        $productoModel = new Producto();
        $producto = $productoModel->getById($id);

        if (!$producto) exit;

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad']++;
        } else {
            $_SESSION['carrito'][$id] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1,
                'imagen' => $producto->imagen
            ];
        }

        require 'views/partials/cart_preview.php';
exit;
    }

    public function modificarAjax() {
        $id = $_POST['id'] ?? 0;
        $accion = $_POST['accion'] ?? '';

        if (isset($_SESSION['carrito'][$id])) {
            if ($accion === 'sumar') {
                $_SESSION['carrito'][$id]['cantidad']++;
            } elseif ($accion === 'restar') {
                $_SESSION['carrito'][$id]['cantidad']--;
                if ($_SESSION['carrito'][$id]['cantidad'] <= 0) {
                    unset($_SESSION['carrito'][$id]);
                }
            }
        }

        require 'views/partials/cart_preview.php';
exit;
    }

    public function eliminar() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            unset($_SESSION['carrito'][$id]);
        }
        header('Location: index.php?controller=Carrito&action=ver');
    }
    public function eliminarAjax() {
    if (!isset($_SESSION)) session_start();

    $id = $_POST['id'] ?? 0;
    if (isset($_SESSION['carrito'][$id])) {
        unset($_SESSION['carrito'][$id]);
    }

    require 'views/partials/cart_preview.php';
exit;
}

}