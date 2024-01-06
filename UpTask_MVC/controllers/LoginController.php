<?php
/* En este caso, se verá las variables */

namespace Controllers;

use Model\Usuario;
use MVC\Router;

class LoginController{
    /* ########################## */
    
    /* CONTROLANDO EL LOGIN EN BASE AL CONTROLLER */

    public static function login(Router $router){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            /* Esto si en caso el metodo es POST se va procesar los datos o variables correspondientes */


        }
    /* Aqui se genera las variables de $router */
    $router->render('auth/login',[
        'titulo'=>'Iniciar Sesión'
    ]);
    

    }
    public static function logout(){
        /* Metodo get suficiente para cerrar sesión */
        echo "Desde logout"; 
    }

    /* AQUI VAMOS A CREAR LA CUENTA ANTES DE PROCEDER A USAR LOGIN */
    public static function crear(Router $router){
        $alertas=[];
        /* AQUI SE ESTA IMPORTANDO EL USUARIO  */
        $usuario=new Usuario();

        if($_SERVER['REQUEST_METHOD']==='POST'){
            /* ESTO PARA QUE SE QUEDE, RECORDAR COLOCAR EN EL VALUE CADA INPUT PARA QUE NO SE PIERDA , osea sincronizar es PARA DARLE EL POST */
            $usuario->sincronizar($_POST);
            /* Aqui pasaran las validaciones correpondientes - Función qyue se encuentra en el modelo de Usuario*/
            $alertas=$usuario->validarNuevaCuenta();
        }
        /* AQUI SE VAN A MANDAR LAS FUNCIONES DE CREAR  */
        /* EN ESTE CASO TAMBIEN SE ESTAN MANDANDO EN EL LOGIN CONTROLLER LAS VARIABLES CORESPONDIENTES A LOS VIEWS */
    $router->render('auth/crear',[
        'titulo'=>'Crear',
        'usuario'=>$usuario,
        'alertas'=>$alertas
    ]);
    }

    /* No olvidar la definición de Router */
    public static function olvide(Router $router){
        echo "Desde olvide"; 
        if($_SERVER['REQUEST_METHOD']==='POST'){

        }
    $router->render('auth/olvide',[
        'titulo'=>'Olvide'
    ]);
    }
    public static function reestablecer(Router $router){
        if($_SERVER['REQUEST_METHOD']==='POST'){

        }
        $router->render('auth/reestablecer',[
            'titulo'=>'Reestablecer Password'
        ]);
    }
    public static function mensaje(Router $router){
        $router->render('auth/mensaje',[
            'titulo'=>'Mensaje'
        ]);
    }
    public static function confirmar(Router $router){
        $router->render('auth/confirmar',[
            'titulo'=>'Confirma tu cuenta UpTask'
        ]);
    }
}

?>