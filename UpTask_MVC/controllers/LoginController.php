<?php
/* En este caso, se verá las variables */

namespace Controllers;

use MVC\Router;

class LoginController{
    public static function login(Router $router){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            
        }
    $router->render('auth/login',[
        'titulo'=>'Iniciar Sesión'
    ]);
    }
    

    public static function logout(){
        /* Metodo get suficiente para cerrar sesión */
        echo "Desde logout"; 
    }



    public static function crear(Router $router){
        
        if($_SERVER['REQUEST_METHOD']==='POST'){

        }
    $router->render('auth/crear',[
        'titulo'=>'Crear'
    ]);
    }


    public static function olvide(){
        echo "Desde olvide"; 
        if($_SERVER['REQUEST_METHOD']==='POST'){

        }
    }
    public static function reestablecer(){
        echo "Desde reestablecer"; 
        if($_SERVER['REQUEST_METHOD']==='POST'){

        }
    }
    public static function mensaje(){
        echo "Desde mensaje"; 
    }
    public static function confirmar(){
        echo "Desde confirmar"; 
        
    }
}

?>