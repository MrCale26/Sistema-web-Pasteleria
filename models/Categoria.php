<?php
require_once 'config/database.php';

class Categoria {
    private $db;
    private $id;
    private $nombre;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function setId($id) { $this->id = intval($id); }
    public function setNombre($nombre) {
        $this->nombre = $this->db->real_escape_string($nombre);
    }

    public function getAll() {
        $sql = "SELECT * FROM categorias ORDER BY nombre ASC";
        return $this->db->query($sql);
    }

    public function getById($id) {
        $sql = "SELECT * FROM categorias WHERE id = $id";
        $result = $this->db->query($sql);
        return $result->fetch_object();
    }

    public function save() {
        $sql = "INSERT INTO categorias (nombre) VALUES ('{$this->nombre}')";
        return $this->db->query($sql);
    }

    public function update() {
        $sql = "UPDATE categorias SET nombre = '{$this->nombre}' WHERE id = {$this->id}";
        return $this->db->query($sql);
    }

    public function delete($id) {
        $sql = "DELETE FROM categorias WHERE id = $id";
        return $this->db->query($sql);
    }
    public function getAllOrdenado($orderby = 'id', $order = 'asc') {
    $allowed = ['id', 'nombre'];
    $orderby = in_array($orderby, $allowed) ? $orderby : 'id';
    $order = strtolower($order) === 'desc' ? 'DESC' : 'ASC';

    $sql = "SELECT * FROM categorias ORDER BY $orderby $order";
    return $this->db->query($sql);
}

public function buscarYOrdenar($query, $orderby = 'id', $order = 'asc') {
    $allowed = ['id', 'nombre'];
    $orderby = in_array($orderby, $allowed) ? $orderby : 'id';
    $order = strtolower($order) === 'desc' ? 'DESC' : 'ASC';

    $sql = "SELECT * FROM categorias 
            WHERE nombre LIKE '%" . $this->db->real_escape_string($query) . "%' 
            ORDER BY $orderby $order";
    return $this->db->query($sql);
}

}
