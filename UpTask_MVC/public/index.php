<?php 
/* Lugar donde definiremos las rutas */


require_once __DIR__ . '/../includes/app.php';

use Controllers\LoginController;
use Controllers\DashboardController;
use Controllers\TareaController;
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
$router->get('/confirmar',[LoginController::class,'confirmar']);

/* ##############################---DASHBOARD---########################### */
//('titulo de pagina', Clase que se queda)
/* Aqui recordar qeu tenemos que importar el use de los namespacer de los controladores necesario */
$router->get('/dashboard',[DashboardController::class,'index']);

//Crear Proyecto 

$router->get('/crear-proyecto',[DashboardController::class,'crear_proyecto']);
$router->post('/crear-proyecto',[DashboardController::class,'crear_proyecto']);

$router->get('/proyecto',[DashboardController::class,'proyecto']);

//Perfil

$router->get('/perfil',[DashboardController::class,'perfil']);

//DashBoard Rutas 


// API para las tareas
/* Mostrar los proyectos mediante esa api */
$router->get('/api/tareas',[TareaController::class,'index']);
$router->post('/api/tarea',[TareaController::class,'crear']);
$router->post('/api/tarea/actualizar',[TareaController::class,'actualizar']);
$router->post('/api/tarea/eliminar',[TareaController::class,'eliminar']);
// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
