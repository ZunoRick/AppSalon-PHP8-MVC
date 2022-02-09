<?php 

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController{
    public static function index(Router $router){
        if (!isset($_SESSION)) {
            session_start();
        }
        isAdmin();
        $alertas = [];
        $servicios = Servicio::all();

        if (isset($_GET['err_no'])) {
            switch ($_GET['err_no']) {
                case '100':
                    Servicio::setAlerta('exito', 'Servicio Actualizado Correctamente');
                    break;

                case '101':
                    Servicio::setAlerta('error', 'Servicio no válido');
                    break;

                case '102':
                    Servicio::setAlerta('exito', 'Servicio Eliminado Correctamente');
                    break;

                case '103':
                    Servicio::setAlerta('exito', 'Servicio Creado Correctamente');
                    break;

                default:
                    header('Location: /servicios');
                    break;
            }
            $alertas = Servicio::getAlertas();
        }
        
        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios,
            'alertas' => $alertas
        ]);
    }

    public static function crear(Router $router){
        if (!isset($_SESSION)) {
            session_start();
        }
        isAdmin();
        $alertas = [];
        $servicio = new Servicio;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios?err_no=103');
            }
        }

        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router){
        debuguear($_GET['id']);
        if (!isset($_SESSION)) {
            session_start();
        }
        isAdmin();

        // $idServicio = is_numeric($idServicio);
        if (!is_numeric($_GET['id']))  {
            header('Location: /servicios?err_no=101');
        }
        $servicio = Servicio::find($_GET['id']);
        $alertas = [];
        
        debuguear($servicio);
        // debuguear($servicio);
        if (!$servicio) {
            header('Location: /servicios?err_no=101');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios?err_no=100');
            }
        }

        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar(Router $router){
        if (!isset($_SESSION)) {
            session_start();
        }
        isAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $servicio = Servicio::find($id);
            $servicio->eliminar();
            header('Location: /servicios?err_no=102');
        }
    }
}