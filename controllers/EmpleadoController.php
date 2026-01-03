<?php
require_once 'models/Empleado.php';

class EmpleadoController {

    public function index() {
        require_once 'helpers/auth.php';
        checkAuth('admin');

        $empleado = new Empleado();
        $empleados = $empleado->getAll();

        require_once 'views/layouts/header.php';
        require_once 'views/admin/empleados/index.php';
        
    }

    public function crear() {
        require_once 'helpers/auth.php';
        checkAuth('admin');

        require_once 'views/layouts/header.php';
        require_once 'views/admin/empleados/formulario.php';
        
    }

    public function editar() {
        require_once 'helpers/auth.php';
        checkAuth('admin');

        if (isset($_GET['id'])) {
            $empleado = new Empleado();
            $empleado = $empleado->getById($_GET['id']);

            require_once 'views/layouts/header.php';
            require_once 'views/admin/empleados/formulario.php';
            
        }
    }

    public function guardar() {
        require_once 'helpers/auth.php';
        checkAuth('admin');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $e = new Empleado();
            $e->setNombre($_POST['nombre']);
            $e->setTelefono($_POST['telefono']);

            if (!empty($_POST['id'])) {
                $e->setId($_POST['id']);
                $e->update();
            } else {
                $e->save();
            }

            header("Location: index.php?controller=Empleado&action=index");
        }
    }

    public function eliminar() {
        require_once 'helpers/auth.php';
        checkAuth('admin');

        if (isset($_GET['id'])) {
            $e = new Empleado();
            $e->delete($_GET['id']);
            header("Location: index.php?controller=Empleado&action=index");
        }
    }
}
