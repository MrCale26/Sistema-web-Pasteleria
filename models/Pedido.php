<?php
require_once 'config/database.php';

class Pedido {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // Obtener todos los pedidos con nombre del cliente
    public function getAllWithCliente() {
        $sql = "SELECT p.*, u.nombre AS cliente
                FROM pedidos p
                INNER JOIN clientes c ON p.cliente_id = c.id
                INNER JOIN usuarios u ON c.usuario_id = u.id
                ORDER BY p.fecha DESC";
        return $this->db->query($sql);
    }

    // Obtener los pedidos por cliente_id (para el panel del cliente)
    public function getByClienteId($cliente_id) {
        $sql = "SELECT * FROM pedidos WHERE cliente_id = $cliente_id ORDER BY fecha DESC";
        return $this->db->query($sql);
    }

    // Obtener detalles de productos en un pedido
    public function getDetalle($pedido_id) {
        $sql = "SELECT dp.*, p.nombre 
                FROM detalle_pedido dp
                INNER JOIN productos p ON p.id = dp.producto_id
                WHERE dp.pedido_id = $pedido_id";
        return $this->db->query($sql);
    }

    // Cambiar estado del pedido
    public function cambiarEstado($id, $nuevoEstado) {
        $sql = "UPDATE pedidos SET estado = '$nuevoEstado' WHERE id = $id";
        return $this->db->query($sql);
    }

    // Obtener un solo pedido (si lo necesitas más adelante)
    public function getById($id) {
        $sql = "SELECT * FROM pedidos WHERE id = $id";
        $result = $this->db->query($sql);
        return $result->fetch_object();
    }
    public function obtenerTodosOrdenado($orderby = 'id', $order = 'asc') {
    $orderby = in_array($orderby, ['id', 'fecha', 'cliente']) ? $orderby : 'id';
    $order = strtolower($order) === 'desc' ? 'DESC' : 'ASC';

    // Evitar ambigüedad si se ordena por 'cliente'
    $orderby = $orderby === 'cliente' ? 'u.nombre' : "p.$orderby";

    $sql = "
        SELECT p.*, u.nombre AS cliente
        FROM pedidos p
        INNER JOIN clientes c ON c.id = p.cliente_id
        INNER JOIN usuarios u ON u.id = c.usuario_id
        ORDER BY $orderby $order
    ";

    return $this->db->query($sql);
}

public function buscarYOrdenar($query, $orderby = 'id', $order = 'asc') {
    $query = $this->db->real_escape_string($query);
    $orderby = in_array($orderby, ['id', 'fecha', 'cliente']) ? $orderby : 'id';
    $order = strtolower($order) === 'desc' ? 'DESC' : 'ASC';

    // Evitar ambigüedad si se ordena por 'cliente'
    $orderby = $orderby === 'cliente' ? 'u.nombre' : "p.$orderby";

    $sql = "
        SELECT p.*, u.nombre AS cliente
        FROM pedidos p
        INNER JOIN clientes c ON c.id = p.cliente_id
        INNER JOIN usuarios u ON u.id = c.usuario_id
        WHERE u.nombre LIKE '%$query%' OR p.id LIKE '%$query%' OR p.fecha LIKE '%$query%'
        ORDER BY $orderby $order
    ";

    return $this->db->query($sql);
}
// ✅ Obtener todos los pedidos con orden y paginación
public function obtenerTodosOrdenadoPaginado($orderby = 'id', $order = 'asc', $limit = 10, $offset = 0) {
    $orderby = in_array($orderby, ['id', 'fecha', 'cliente']) ? $orderby : 'id';
    $order = strtolower($order) === 'desc' ? 'DESC' : 'ASC';
    $orderby = $orderby === 'cliente' ? 'u.nombre' : "p.$orderby";

    $sql = "
        SELECT p.*, u.nombre AS cliente
        FROM pedidos p
        INNER JOIN clientes c ON c.id = p.cliente_id
        INNER JOIN usuarios u ON u.id = c.usuario_id
        ORDER BY $orderby $order
        LIMIT ? OFFSET ?
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

// ✅ Contar todos los pedidos (para paginación)
public function contarTodos() {
    $sql = "SELECT COUNT(*) as total FROM pedidos";
    $result = $this->db->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'] ?? 0;
}

public function contarPorEstado() {
    $sql = "SELECT estado, COUNT(*) AS total FROM pedidos GROUP BY estado";
    $result = $this->db->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}





}
