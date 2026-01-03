<?php
require_once 'Conexion.php'; // Ajusta según tu estructura

class GraficoModel {
    private $db;

    public function __construct() {
        $this->db = Conexion::getConexion();
    }

    public function productosMasVendidos($limite = 5) {
        $stmt = $this->db->prepare("
            SELECT p.nombre, SUM(dp.cantidad) AS total
            FROM detalle_pedido dp
            JOIN productos p ON dp.producto_id = p.id
            GROUP BY p.id
            ORDER BY total DESC
            LIMIT ?
        ");
        $stmt->bind_param("i", $limite);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function ventasUltimos7Dias() {
        $sql = "
            SELECT DATE(fecha) AS dia, SUM(total) AS total
            FROM (
                SELECT fecha, total FROM pedidos
                UNION ALL
                SELECT fecha, total FROM ventas_directas
            ) AS todas
            WHERE fecha >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
            GROUP BY dia
            ORDER BY dia
        ";
        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function pedidosPorEstado() {
        $sql = "SELECT estado, COUNT(*) AS cantidad FROM pedidos GROUP BY estado";
        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function ingresosPorQuincena() {
        $sql = "
            SELECT CONCAT(YEAR(fecha), '-Q', IF(DAY(fecha) <= 15, '1', '2')) AS quincena,
                   SUM(total) AS total
            FROM (
                SELECT fecha, total FROM pedidos
                UNION ALL
                SELECT fecha, total FROM ventas_directas
            ) AS ingresos
            WHERE fecha >= DATE_SUB(CURDATE(), INTERVAL 60 DAY)
            GROUP BY quincena
            ORDER BY quincena
        ";
        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }
}
