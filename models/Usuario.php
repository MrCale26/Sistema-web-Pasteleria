<?php
require_once 'config/database.php';

class Usuario {
    private $db;
    private $id;
    private $nombre;
    private $email;
    private $password;
    private $rol;

    public function __construct() {
        $this->db = Database::connect();
    }

    // ---------- SETTERS ----------
    public function setId($id) { $this->id = intval($id); }

    public function setNombre($nombre) { $this->nombre = $this->db->real_escape_string($nombre); }

    public function setEmail($email) { $this->email = $this->db->real_escape_string($email); }

    public function setPassword($password) { $this->password = $password; }

    public function setRol($rol) { $this->rol = $rol; }

    // ---------- OBTENER USUARIO POR EMAIL ----------
    public function getByEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object();
    }

    // ---------- OBTENER TODOS LOS USUARIOS ----------
    public function getAll() {
        $sql = "SELECT * FROM usuarios";
        return $this->db->query($sql);
    }

    // ---------- OBTENER USUARIO POR ID ----------
    public function getById($id) {
        $sql = "SELECT * FROM usuarios WHERE id = $id";
        return $this->db->query($sql)->fetch_object();
    }

    // ---------- GUARDAR NUEVO USUARIO ----------
    public function save() {
        $sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssss", $this->nombre, $this->email, $this->password, $this->rol);
        return $stmt->execute();
    }

    // ---------- ACTUALIZAR USUARIO EXISTENTE ----------
    public function update() {
        $sql = "UPDATE usuarios SET 
                    nombre = '{$this->nombre}', 
                    email = '{$this->email}', 
                    rol = '{$this->rol}' 
                WHERE id = {$this->id}";
        return $this->db->query($sql);
    }

    // ---------- BUSCAR USUARIO POR NOMBRE O EMAIL ----------
    public function buscar($filtro = null) {
        if ($filtro) {
            $filtro = $this->db->real_escape_string($filtro);
            $sql = "SELECT * FROM usuarios 
                    WHERE nombre LIKE '%$filtro%' 
                       OR email LIKE '%$filtro%'";
        } else {
            $sql = "SELECT * FROM usuarios";
        }
        return $this->db->query($sql);
    }

    // ---------- ELIMINAR USUARIO POR ID ----------
    public function eliminar() {
    // Eliminar cliente relacionado
    $this->db->query("DELETE FROM clientes WHERE usuario_id = {$this->id}");

    // Luego eliminar el usuario
    $sql = "DELETE FROM usuarios WHERE id = {$this->id}";
    return $this->db->query($sql);
}

}
