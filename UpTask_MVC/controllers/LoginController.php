<?php
/* En este caso, se verá las variables */

namespace Controllers;

use Classes\Email;
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
        /* AQUI SE CREA UNA NUEVA INSTANCIA, DONDE SE PUEDE HACER REFERENCIA A LAS FUNCIONES , IMAGENES ETC */
        /* AQUI SE ESTA IMPORTANDO EL USUARIO  */
        $usuario=new Usuario();

        if($_SERVER['REQUEST_METHOD']==='POST'){
            /* ESTO PARA QUE SE QUEDE, RECORDAR COLOCAR EN EL VALUE CADA INPUT PARA QUE NO SE PIERDA , osea sincronizar es PARA DARLE EL POST */
            $usuario->sincronizar($_POST);
            /* Aqui pasaran las validaciones correpondientes - Función qyue se encuentra en el modelo de Usuario*/
            /* Validar */
            $alertas=$usuario->validarNuevaCuenta();

            
            /* Si noexiste alertas, se va tomar el existe Usuario */
            /* En esta función se verificará que las alertas no existan */
            /* Despudes de avlidar y confirmar que ls contraseñas sean iguales, la funciòn de colocar en password lo hace luego */
            if(empty($alertas)){
                $existeUsuario=Usuario::where('email',$usuario->email);
                if($existeUsuario){
                Usuario::setAlerta('error', 'El usuario ya existe registrado');
                /* En ActiveRecord esta para mostrar las Alertas correspondienets */
                $alertas=Usuario::getAlertas();
                }else{
                    //Hashear PASSWORD
                    $usuario->hashPassword();
                    // Eliminar password, o eliminar mejor dicho un elemento de un objeto
                    unset($usuario->password2);

                    //Generar el Token
                    $usuario->crearToken();

                    $usuario->confirmado=0;

                    //Ahora vamos a almacenar la parte del Usuario creado
                    $resultado= $usuario->guardar();

                    //Instanciando Email

                    $email=new Email($usuario->email,$usuario->nombre,$usuario->token);

                    $email->enviarConfirmacion();

                    if($resultado){
                        header('Location:/mensaje');
                    }
                }
                /* debuguear($usuario); */
            }
            
        }
        /* AQUI SE VAN A MANDAR LAS FUNCIONES DE CREAR  */
        /* EN ESTE CASO TAMBIEN SE ESTAN MANDANDO EN EL LOGIN CONTROLLER LAS VARIABLES CORESPONDIENTES A LOS VIEWS */
        /* Estas variables del render ses van a utilziar para el uso del Render, en VIEWS */
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

        $token=s($_GET['token']);
        if(!$token) header('Location:/');
        //Encontrar al usuario con este token

        $usuario=Usuario::where('token',$token);
        /* debuguear($usuario); */

        if(empty($usuario)){
            //No se encontró un usuario con ese token
            Usuario::setAlerta('error','Token no valido');

        }else{
            //Confirmar la cuenta
            $usuario->confirmado=1;
            $usuario->token=null;
            unset($usuario->password2);
            
            $usuario->guardar();

            Usuario::setAlerta('exito','Cuenta Comprobada Correctamente');
        }
        $alertas=Usuario::getAlertas();

        $router->render('auth/confirmar',[
            'titulo'=>'Confirma tu cuenta UpTask',
            'alertas'=>$alertas
        ]);
    }
}

?>