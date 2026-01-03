<?php
require_once 'models/Usuario.php';

class UsuarioController {

    public function login() {
        require_once 'views/usuarios/login.php';
    }

    public function autenticar() {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();

    // Inicializar intentos si no existe
    if (!isset($_SESSION['intentos_login'])) {
        $_SESSION['intentos_login'] = 0;
    }

    // Verificar si hay bloqueo por tiempo
    if (isset($_SESSION['bloqueado_hasta'])) {
        $ahora = time();
        if ($ahora < $_SESSION['bloqueado_hasta']) {
            $minutos_restantes = ceil(($_SESSION['bloqueado_hasta'] - $ahora) / 60);
            $_SESSION['login_mensaje'] = "Has sido bloqueado. Vuelve a intentar en $minutos_restantes minuto(s).";
            $_SESSION['login_tipo'] = "alert-danger";
            header("Location: index.php?controller=Usuario&action=login");
            exit;
        } else {
            // Se venció el tiempo de bloqueo
            unset($_SESSION['bloqueado_hasta']);
            $_SESSION['intentos_login'] = 0;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $usuario = new Usuario();
        $datos = $usuario->getByEmail($email);

        if ($datos && password_verify($password, $datos->password)) {
            // Acceso correcto
            $_SESSION['intentos_login'] = 0;
            unset($_SESSION['bloqueado_hasta']);

            $_SESSION['usuario'] = [
                'id' => $datos->id,
                'nombre' => $datos->nombre,
                'rol' => $datos->rol
            ];

            if ($datos->rol == 'admin') {
                header('Location: index.php?controller=Usuario&action=dashboard');
            } else {
                header('Location: index.php?controller=Usuario&action=panelCliente');
            }
            exit;
        } else {
            // Falló intento
            $_SESSION['intentos_login']++;
            $restantes = 2 - $_SESSION['intentos_login'];

            if ($_SESSION['intentos_login'] >= 2) {
                $_SESSION['bloqueado_hasta'] = time() + (5 * 60); // 5 minutos
                $_SESSION['login_mensaje'] = "Has excedido los intentos permitidos. Intenta nuevamente en 5 minutos.";
                $_SESSION['login_tipo'] = "alert-danger";
            } else {
                $_SESSION['login_mensaje'] = "Credenciales incorrectas. Intentos restantes: $restantes";
                $_SESSION['login_tipo'] = "alert-warning";
            }

            header("Location: index.php?controller=Usuario&action=login");
            exit;
        }
    }
}




    public function registro() {
        require_once 'views/usuarios/registro.php';
    }

    public function guardarRegistro() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = trim($_POST['nombre']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $telefono = trim($_POST['telefono']);
            $direccion = trim($_POST['direccion']);

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $usuario = new Usuario();
            $existe = $usuario->getByEmail($email);

            if ($existe) {
                echo "<p style='color:red;'> Este correo ya está registrado. <a href='index.php?controller=Usuario&action=login'>Inicia sesión</a></p>";
                require_once 'views/usuarios/registro.php';
                return;
            }

            $usuario->setNombre($nombre);
            $usuario->setEmail($email);
            $usuario->setPassword($passwordHash);
            $usuario->setRol('cliente');

            $guardado = $usuario->save();

            if ($guardado) {
                if (session_status() !== PHP_SESSION_ACTIVE) session_start();
                $nuevoUsuario = $usuario->getByEmail($email);

                require_once 'config/database.php';
                $db = Database::connect();
                $stmt = $db->prepare("INSERT INTO clientes (usuario_id, telefono, direccion) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $nuevoUsuario->id, $telefono, $direccion);
                $stmt->execute();

                $_SESSION['usuario'] = [
                    'id' => $nuevoUsuario->id,
                    'nombre' => $nuevoUsuario->nombre,
                    'rol' => $nuevoUsuario->rol
                ];

                $_SESSION['mensaje'] = "¡Cuenta creada exitosamente!";
                header('Location: index.php?controller=Usuario&action=panelCliente');
                exit;
            } else {
                echo "<p style='color:red;'> Error al guardar el usuario.</p>";
                require_once 'views/usuarios/registro.php';
            }
        }
    }

    public function logout() {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();

    $_SESSION = [];
    session_unset();
    session_destroy();

    // Elimina la cookie de sesión también si existe
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    header("Location: index.php");
    exit();
}


    public function dashboard() {
        require_once 'helpers/auth.php';
        checkAuth('admin');
        require_once 'views/admin/dashboard.php';
    }

    // 🔄 ACTUALIZADA
    public function panelCliente() {
    require_once 'helpers/auth.php';
    checkAuth('cliente');

    require_once 'models/Producto.php';
    require_once 'models/Categoria.php';

    $producto = new Producto();

    // ✅ Obtener productos destacados (con fallback)
    if (method_exists($producto, 'getDestacados')) {
        $destacados = $producto->getDestacados();
    } else {
        $destacados = $producto->getAll();
    }

    // ✅ Obtener productos en promoción
    if (method_exists($producto, 'getPromociones')) {
        $promociones = $producto->getPromociones();
    } else {
        $promociones = [];
    }

    // ✅ Obtener categorías
    $categoria = new Categoria();
    $categorias = $categoria->getAll();

    // ✅ Pasar variables a la vista
    require_once 'views/cliente/panel.php';
}


    public function misPedidos() {
        require_once 'helpers/auth.php';
        checkAuth('cliente');
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        require_once 'config/database.php';

        $db = Database::connect();
        $usuarioId = $_SESSION['usuario']['id'];

        $stmtCliente = $db->prepare("SELECT id FROM clientes WHERE usuario_id = ?");
        $stmtCliente->bind_param("i", $usuarioId);
        $stmtCliente->execute();
        $resCliente = $stmtCliente->get_result();

        if ($resCliente->num_rows === 0) {
            echo "<p>No estás registrado como cliente.</p>";
            return;
        }

        $clienteId = $resCliente->fetch_assoc()['id'];

        $sql = "SELECT * FROM pedidos WHERE cliente_id = ? ORDER BY fecha DESC";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $clienteId);
        $stmt->execute();
        $pedidos = $stmt->get_result();

        require_once 'views/cliente/mis_pedidos.php';
    }

    public function resumenPagos() {
        require_once 'helpers/auth.php';
        checkAuth('admin');
        require_once 'config/database.php';

        $db = Database::connect();
        $fechaInicio = $_GET['inicio'] ?? null;
        $fechaFin = $_GET['fin'] ?? null;

        $sql = "
            SELECT p.id AS pago_id, p.metodo, p.monto, p.estado, p.fecha_pago,
                   pe.id AS pedido_id, pe.total,
                   u.nombre AS cliente_nombre
            FROM pagos p
            INNER JOIN pedidos pe ON pe.id = p.pedido_id
            INNER JOIN clientes c ON pe.cliente_id = c.id
            INNER JOIN usuarios u ON c.usuario_id = u.id
        ";

        $condiciones = [];
        if ($fechaInicio && $fechaFin) {
            $condiciones[] = "p.fecha_pago BETWEEN '$fechaInicio 00:00:00' AND '$fechaFin 23:59:59'";
        }

        if (!empty($condiciones)) {
            $sql .= " WHERE " . implode(" AND ", $condiciones);
        }

        $sql .= " ORDER BY p.fecha_pago DESC";
        $pagos = $db->query($sql);

        require_once 'views/admin/pagos.php';
    }

    public function indexAdmin() {
        require_once 'helpers/auth.php';
        checkAuth('admin');

        $filtro = $_GET['buscar'] ?? null;

        $usuario = new Usuario();
        $usuarios = $usuario->buscar($filtro);

        require_once 'views/layouts/header.php';
        require_once 'views/admin/usuarios/index.php';
        
    }

    public function editarUsuario() {
        require_once 'helpers/auth.php';
        checkAuth('admin');

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $usuario = new Usuario();
            $usuario = $usuario->getById($id);

            require_once 'views/layouts/header.php';
            require_once 'views/admin/usuarios/editar.php';
            
        } else {
            echo "<p>Usuario no especificado.</p>";
        }
    }

    public function actualizarUsuario() {
        require_once 'helpers/auth.php';
        checkAuth('admin');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = new Usuario();
            $usuario->setId($_POST['id']);
            $usuario->setNombre($_POST['nombre']);
            $usuario->setEmail($_POST['email']);
            $usuario->setRol($_POST['rol']);
            $usuario->update();

            header("Location: index.php?controller=Usuario&action=indexAdmin");
        }
    }

    public function eliminarUsuario() {
        require_once 'helpers/auth.php';
        checkAuth('admin');

        if (isset($_GET['id'])) {
            $usuario = new Usuario();
            $usuario->setId($_GET['id']);
            $usuario->eliminar();
        }

        header("Location: index.php?controller=Usuario&action=indexAdmin");
    }
    public function nosotros() {
  require 'views/nosotros.php';
}
public function contacto() {
    require_once 'views/contacto.php';
}

}
