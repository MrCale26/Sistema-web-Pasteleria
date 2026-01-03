<?php
require_once '../../config/config.php';
require_once '../../config/database.php';

$db = Database::connect();

// ... resto del código exportar ...


// Filtrado por fechas (desde GET)
$inicio = isset($_GET['inicio']) ? $_GET['inicio'] : null;
$fin = isset($_GET['fin']) ? $_GET['fin'] : null;

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=pagos.xls");

echo "<table border='1'>";
echo "<tr>
        <th>ID Pago</th>
        <th>Cliente</th>
        <th>Pedido</th>
        <th>Método</th>
        <th>Monto</th>
        <th>Estado</th>
        <th>Fecha</th>
      </tr>";

$sql = "
    SELECT p.id AS pago_id, p.metodo, p.monto, p.estado, p.fecha_pago,
           pe.id AS pedido_id, u.nombre AS cliente_nombre
    FROM pagos p
    INNER JOIN pedidos pe ON pe.id = p.pedido_id
    INNER JOIN clientes c ON pe.cliente_id = c.id
    INNER JOIN usuarios u ON c.usuario_id = u.id
";

// Si hay fechas, agregamos condición
$condiciones = [];
if ($inicio && $fin) {
    $condiciones[] = "p.fecha_pago BETWEEN '$inicio 00:00:00' AND '$fin 23:59:59'";
}
if (!empty($condiciones)) {
    $sql .= " WHERE " . implode(" AND ", $condiciones);
}
$sql .= " ORDER BY p.fecha_pago DESC";

$pagos = $db->query($sql);

while ($p = $pagos->fetch_object()) {
    echo "<tr>
            <td>{$p->pago_id}</td>
            <td>{$p->cliente_nombre}</td>
            <td>{$p->pedido_id}</td>
            <td>{$p->metodo}</td>
            <td>S/ " . number_format($p->monto, 2) . "</td>
            <td>{$p->estado}</td>
            <td>{$p->fecha_pago}</td>
          </tr>";
}

echo "</table>";
