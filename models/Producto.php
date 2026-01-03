<?php
require_once 'config/database.php';

class Producto {
    private $db;
    private $id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $precio_original; // ✅ nuevo atributo
    private $stock;
    private $categoria_id;
    private $imagen;
    private $promocion;
    private $destacado;
    private $descuento;

    public function __construct() {
        $this->db = Database::connect();
    }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setNombre($nombre) { $this->nombre = $this->db->real_escape_string($nombre); }
    public function setDescripcion($descripcion) { $this->descripcion = $this->db->real_escape_string($descripcion); }
    public function setPrecio($precio) { $this->precio = floatval($precio); }
    public function setPrecioOriginal($precioOriginal) { $this->precio_original = floatval($precioOriginal); } // ✅ nuevo setter
    public function setStock($stock) { $this->stock = intval($stock); }
    public function setCategoriaId($categoria_id) {
        $this->categoria_id = !empty($categoria_id) ? intval($categoria_id) : null;
    }
    public function setImagen($imagen) { $this->imagen = $imagen; }
    public function setPromocion($promocion) { $this->promocion = intval($promocion); }
    public function setDestacado($destacado) { $this->destacado = intval($destacado); }
    public function setDescuento($descuento) { $this->descuento = floatval($descuento); }

    // Getters
    public function getPromocion() { return $this->promocion; }
    public function getDestacado() { return $this->destacado; }
    public function getDescuento() { return $this->descuento; }

    // Guardar nuevo producto
    public function save() {
        $cat = $this->categoria_id ?? "NULL";
        $img = $this->imagen ? "'{$this->imagen}'" : "NULL";

        $sql = "INSERT INTO productos 
                (nombre, descripcion, precio, precio_original, imagen, stock, categoria_id, promocion, destacado, descuento)
                VALUES (
                    '{$this->nombre}', 
                    '{$this->descripcion}', 
                    {$this->precio}, 
                    {$this->precio_original}, 
                    $img, 
                    {$this->stock}, 
                    $cat, 
                    {$this->promocion}, 
                    {$this->destacado}, 
                    {$this->descuento}
                )";
        return $this->db->query($sql);
    }

    // Actualizar producto existente
    public function update() {
        $cat = $this->categoria_id ?? "NULL";
        $setImagen = $this->imagen ? ", imagen = '{$this->imagen}'" : "";

        $sql = "UPDATE productos SET 
                nombre = '{$this->nombre}', 
                descripcion = '{$this->descripcion}', 
                precio = {$this->precio}, 
                precio_original = {$this->precio_original}, 
                stock = {$this->stock}, 
                categoria_id = $cat,
                promocion = {$this->promocion},
                destacado = {$this->destacado},
                descuento = {$this->descuento}
                $setImagen
                WHERE id = {$this->id}";
        return $this->db->query($sql);
    }

    // Eliminar producto
    public function delete($id) {
        $sqlCheck = "SELECT COUNT(*) as total FROM detalle_pedido WHERE producto_id = $id";
        $result = $this->db->query($sqlCheck)->fetch_assoc();
        if ($result && $result['total'] > 0) return false;

        $imagen = $this->getImagenById($id);
        if ($imagen && file_exists('uploads/' . $imagen)) {
            unlink('uploads/' . $imagen);
        }

        $sqlDelete = "DELETE FROM productos WHERE id = $id";
        return $this->db->query($sqlDelete);
    }

    public function getImagenById($id) {
        $sql = "SELECT imagen FROM productos WHERE id = $id";
        $result = $this->db->query($sql);
        $row = $result->fetch_object();
        return $row ? $row->imagen : null;
    }

    public function getAll() {
        $sql = "SELECT * FROM productos ORDER BY id DESC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getAllWithCategoria() {
        $sql = "SELECT p.*, c.nombre AS categoria
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                ORDER BY p.id DESC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getAllLimit($limite = 6) {
        $sql = "SELECT * FROM productos ORDER BY id DESC LIMIT $limite";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getById($id) {
        $sql = "SELECT * FROM productos WHERE id = $id";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_object() : null;
    }

    public function getByCategoria($categoria_id) {
        $categoria_id = intval($categoria_id);
        $sql = "SELECT * FROM productos WHERE categoria_id = $categoria_id ORDER BY id DESC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function buscar($query) {
        $query = $this->db->real_escape_string($query);
        $sql = "SELECT * FROM productos 
                WHERE nombre LIKE '%$query%' 
                OR descripcion LIKE '%$query%' 
                ORDER BY id DESC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function buscarPorCategoriaYNombre($categoria_id, $query) {
        $categoria_id = intval($categoria_id);
        $query = $this->db->real_escape_string($query);
        $sql = "SELECT * FROM productos 
                WHERE categoria_id = $categoria_id 
                AND (nombre LIKE '%$query%' OR descripcion LIKE '%$query%')
                ORDER BY id DESC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function buscarPorNombreODescripcion($texto) {
        $texto = $this->db->real_escape_string($texto);
        $sql = "SELECT p.*, c.nombre AS categoria 
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                WHERE p.nombre LIKE '%$texto%' OR p.descripcion LIKE '%$texto%'
                ORDER BY p.id DESC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getAllOrdenado($orden = 'id', $dir = 'asc') {
        $orden = in_array($orden, ['id', 'nombre', 'descripcion']) ? $orden : 'id';
        $dir = $dir === 'desc' ? 'desc' : 'asc';

        $sql = "SELECT p.*, c.nombre AS categoria 
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                ORDER BY p.$orden $dir";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function buscarYOrdenar($query, $orden = 'id', $dir = 'asc') {
        $query = $this->db->real_escape_string($query);
        $orden = in_array($orden, ['id', 'nombre', 'descripcion']) ? $orden : 'id';
        $dir = $dir === 'desc' ? 'desc' : 'asc';

        $sql = "SELECT p.*, c.nombre AS categoria 
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                WHERE p.nombre LIKE '%$query%' OR p.descripcion LIKE '%$query%'
                ORDER BY p.$orden $dir";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function contarProductos($query = null) {
        if ($query) {
            $query = $this->db->real_escape_string($query);
            $sql = "SELECT COUNT(*) as total FROM productos WHERE nombre LIKE '%$query%' OR descripcion LIKE '%$query%'";
        } else {
            $sql = "SELECT COUNT(*) as total FROM productos";
        }
        $res = $this->db->query($sql)->fetch_assoc();
        return $res['total'] ?? 0;
    }

    public function getAllOrdenadoPaginado($orden, $dir, $limit, $offset) {
        $orden = in_array($orden, ['id', 'nombre', 'descripcion']) ? $orden : 'id';
        $dir = $dir === 'desc' ? 'desc' : 'asc';

        $sql = "SELECT p.*, c.nombre AS categoria 
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                ORDER BY p.$orden $dir
                LIMIT $limit OFFSET $offset";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function buscarYOrdenarPaginado($query, $orden, $dir, $limit, $offset) {
        $query = $this->db->real_escape_string($query);
        $orden = in_array($orden, ['id', 'nombre', 'descripcion']) ? $orden : 'id';
        $dir = $dir === 'desc' ? 'desc' : 'asc';

        $sql = "SELECT p.*, c.nombre AS categoria 
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                WHERE p.nombre LIKE '%$query%' OR p.descripcion LIKE '%$query%'
                ORDER BY p.$orden $dir
                LIMIT $limit OFFSET $offset";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function listarTodos() {
        return $this->getAllWithCategoria();
    }

    public function obtenerCategorias() {
        $sql = "SELECT * FROM categorias ORDER BY nombre ASC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getPromociones() {
        $sql = "SELECT * FROM productos WHERE promocion = 1 ORDER BY id DESC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getDestacados() {
    $sql = "SELECT * FROM productos WHERE destacado = 1 ORDER BY id DESC LIMIT 6";
    $result = $this->db->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}



}
