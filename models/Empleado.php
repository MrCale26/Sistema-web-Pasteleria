<?php
require_once 'config/database.php';

class Empleado {
    private $db;
    private $id;
    private $nombre;
    private $telefono;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function setId($id) { $this->id = intval($id); }
    public function setNombre($nombre) {
        $this->nombre = $this->db->real_escape_string($nombre);
    }
    public function setTelefono($telefono) {
        $this->telefono = $this->db->real_escape_string($telefono);
    }

    public function getAll() {
        $sql = "SELECT * FROM empleados ORDER BY nombre ASC";
        return $this->db->query($sql);
    }

    public function getById($id) {
        $sql = "SELECT * FROM empleados WHERE id = $id";
        $result = $this->db->query($sql);
        return $result->fetch_object();
    }

    public function save() {
        $sql = "INSERT INTO empleados (nombre, telefono) VALUES ('{$this->nombre}', '{$this->telefono}')";
        return $this->db->query($sql);
    }

    public function update() {
        $sql = "UPDATE empleados SET nombre = '{$this->nombre}', telefono = '{$this->telefono}' WHERE id = {$this->id}";
        return $this->db->query($sql);
    }

    public function delete($id) {
        $sql = "DELETE FROM empleados WHERE id = $id";
        return $this->db->query($sql);
    }
}
