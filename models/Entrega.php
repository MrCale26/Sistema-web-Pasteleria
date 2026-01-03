<?php
require_once 'config/database.php';

class Entrega {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function asignar($pedido_id, $empleado_id, $fecha_entrega) {
        $sql = "INSERT INTO entregas (pedido_id, empleado_id, fecha_entrega)
                VALUES ($pedido_id, $empleado_id, '$fecha_entrega')";
        return $this->db->query($sql);
    }

    public function actualizarEstado($entrega_id, $estado) {
        $sql = "UPDATE entregas SET estado = '$estado' WHERE id = $entrega_id";
        return $this->db->query($sql);
    }

    public function getByPedidoId($pedido_id) {
        $sql = "SELECT e.*, em.nombre AS empleado 
                FROM entregas e
                INNER JOIN empleados em ON em.id = e.empleado_id
                WHERE e.pedido_id = $pedido_id";
        $result = $this->db->query($sql);
        return $result->fetch_object();
    }
}
