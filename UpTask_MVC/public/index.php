<?php 
/* Lugar donde definiremos las rutas */


require_once __DIR__ . '/../includes/app.php';

use Controllers\LoginController;
use MVC\Router;
$router = new Router();

//Iniciar Sesión
$router->get('/',[LoginController::class,'login']);
$router->post('/',[LoginController::class,'login']);

//Cerrar Sesión

$router->get('/logout',[LoginController::class,'logout']);

//Crear Cuenta

$router->get('/crear',[LoginController::class,'crear']);
$router->post('/crear',[LoginController::class,'crear']);

//Olvide Password, donde se introducirá el correo.

$router->get('/olvide',[LoginController::class,'olvide']);
$router->post('/olvide',[LoginController::class,'olvide']);

//Introduciendo la nueva contraseña.

$router->get('/reestablecer',[LoginController::class,'reestablecer']);
$router->post('/reestablecer',[LoginController::class,'reestablecer']);

//Confirmación de Cuenta

$router->get('/mensaje',[LoginController::class,'mensaje']);
$router->post('/confirmar',[LoginController::class,'confirmar']);


//Formulario de Olvide mi password

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
