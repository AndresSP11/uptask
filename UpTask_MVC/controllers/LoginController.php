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

        $alertas=[];

        $usuario=new Usuario();

        if($_SERVER['REQUEST_METHOD']==='POST'){

            $usuario->sincronizar($_POST);
            /* Esto si en caso el metodo es POST se va procesar los datos o variables correspondientes */
            /* Esta utilizando la parte de arg, para procederlo  */
            $alertas=$usuario->validarLogin();

            if(empty($alertas)){
                //Verificamos que el usuario Existe 
                /* Si existe el Usuario se van a tomar los datos del crear para extraer la información corresondiente */
                $existeUsuario=Usuario::where('email',$usuario->email);
                
                if(!$existeUsuario){
                    Usuario::setAlerta('error','No existe este Usuario porfavor introduce uno valido');
                    
                }else{
                    if($existeUsuario->confirmado=="0"){
                        Usuario::setAlerta('error','El usuario no se encuentra confirmado aún');
                    }else{
                        //El Usuario Existe;
                        if(password_verify($_POST['password'], $existeUsuario->password)){
                            session_start();
                            /* Orientando todos los valores para la Sesion */
                            $_SESSION['id']=$existeUsuario->id;
                            $_SESSION['nombre']=$existeUsuario->nombre;
                            $_SESSION['email']=$existeUsuario->email;
                            $_SESSION['login']=true;
                            header('Location: /dashboard');
                            debuguear($_SESSION);
                        }else{
                            Usuario::setAlerta('error','La contraseña ingresada es incorrecto');
                        }

                    }
                }
                /* debuguear($existeUsuario); */
            }

            $alertas=Usuario::getAlertas();

        }
    /* Aqui se genera las variables de $router */
    $router->render('auth/login',[
        'titulo'=>'Iniciar Sesión',
        'alertas'=>$alertas,
        'usuario'=>$usuario
    ]);
    

    }


    public static function logout(Router $router){
        /* Metodo get suficiente para cerrar sesión */
        session_start();
        $_SESSION=[];
        header('Location:/');
    }


    /* AQUI VAMOS A CREAR LA CUENTA ANTES DE PROCEDER A USAR LOGIN */
    public static function crear(Router $router){
        /* EN ESTE CASO SI ES NECESARIO EL USUARIO:: TAL , PORQUE AQUI SE ESTA HABLANDO DE FORMA GENERAL, MIENTRAS QUE EN USUARIO NO ES NECESARIO PORQ UE SE EXITENDE DE AHI PERO ES NECESARIO
        EL SELF:: TAL (SEA FUNCION O NO) POR QUE DE UNA FORMA U OTRA LO IDENTIFICA */
        $alertas=[];
        /* AQUI SE CREA UNA NUEVA INSTANCIA, DONDE SE PUEDE HACER REFERENCIA A LAS FUNCIONES , IMAGENES ETC */
        /* AQUI SE ESTA IMPORTANDO EL USUARIO  */
        $usuario=new Usuario();

        if($_SERVER['REQUEST_METHOD']==='POST'){
            /* Sincronizar darle valor */
            /* ESTO PARA QUE SE QUEDE, RECORDAR COLOCAR EN EL VALUE CADA INPUT PARA QUE NO SE PIERDA , osea sincronizar es PARA DARLE EL POST */
            $usuario->sincronizar($_POST);
            /* Aqui pasaran las validaciones correpondientes - Función qyue se encuentra en el modelo de Usuario*/
            /* Validar */

            $alertas=$usuario->validarNuevaCuenta();

            
            /* Si noexiste alertas, se va tomar el existe Usuario */

            /* En esta función se verificará que las alertas no existan */

            /* Despudes de avlidar y confirmar que ls contraseñas sean iguales, la funciòn de colocar en password lo hace luego */
            if(empty($alertas)){
                /* Usando el metodo de la clase, con el valor del objeto brindado */
                $existeUsuario=Usuario::where('email',$usuario->email);
                if($existeUsuario){
                    /* Si no existe este metodo, lo que realizamos es crear un alerta con el tipo de error */
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
        $alertas=[];
        
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $usuario=new Usuario($_POST);
            
            $alertas=$usuario->validarEmail();

            if(empty($alertas)){
                
                /* Lo que nos arroja es un Objeto, facil de identificar */
                $existeUsuario=Usuario::where('email',$usuario->email);
                
              /*   debuguear($existeUsuario); */
                if($existeUsuario && $existeUsuario->confirmado==="1"){
                    
                    //Encontro el email del usuario
                    

                    //Generar un nuevo token
                    //Marca como error pero si funciona esta es la clase Usuario recordar que esta heredando del activeRecord como tambien al parte del Usuario
                    $existeUsuario->crearToken();   
                    /* unset($existeUsuario->password2); */
                    
                    //Actualizar el Usuario
                    $existeUsuario->guardar();
                    //Enviar el email
                    $email=new Email($existeUsuario->nombre,$existeUsuario->email,$existeUsuario->token);

                    //Enviar Olvidar Password
                    $email->enviarOlvidarPassword();
                
                    //Imprimir la alerta
                    /* debuguear($existeUsuario); */
                    Usuario::setAlerta('exito','Revisar tu Email porfavor');
                    $alertas=Usuario::getAlertas();
                }else{
                    Usuario::setAlerta('error','Usuario no existe o no ha sido confirmado aún');        
                }
                
            }
            $alertas=Usuario::getAlertas();
        }
    $router->render('auth/olvide',[
        'titulo'=>'Olvide',
        'alertas'=>$alertas
    ]);
    }

    //reestablecer

    public static function reestablecer(Router $router){
        $alertas=[];
        //Validamos el token
        $token=s($_GET['token']);

        $mostrar=true;

        if(!$token) header('Location:/');

        //Identificar el usuario con este token

        $usuario=Usuario::where('token',$token);
        /* CREA UN OBJETO AQUI EN ESTE CASO LO CREA SIN PROBLEMA */
        /* debuguear($usuario);
 */

        /* Verificación del usuario */
        if(empty($usuario)){
            Usuario::setAlerta('error','Token no valido');
            $mostrar=false;
        }

        if($_SERVER['REQUEST_METHOD']==='POST'){

            /* TENIA DUDA EL MOTIVO EN EL CUAL EL PASSWORD NO SE EJECUTO LA PARTE DEL NUEVO OBJETO, EN ESTE CASO SINCRONIZAR ES QUE LOS VALORES QUE SE ENCUENTREN
            YA QUE TENGAN VALOR, PERO EN EL CASO DE LOS NOMBRES NUEVOS SE LOS VA REEMPLAZAR NUEVAMENTE  */
            $usuario->sincronizar($_POST);
            
            $alertas=$usuario->validarPassword();

            if(empty($alertas)){
            
                //Hash Password

            $usuario->hashPassword();

                //Eliminar el Token

                $usuario->token="";
                /* debuguear($usuaro); */
                $usuario->guardar();

                $resultado=$usuario->guardar();

                if($resultado){
                    Usuario::setAlerta('exito','Se ha cambiado la contraseña correctamente');
                }

            
            
            }
        }

        $alertas=Usuario::getAlertas();

        $router->render('auth/reestablecer',[
            'titulo'=>'Reestablecer Password',
            'alertas'=>$alertas,
            'mostrar'=>$mostrar
        ]);

    }



    public static function mensaje(Router $router){
        $router->render('auth/mensaje',[
            'titulo'=>'Mensaje'
        ]);
    }


    public static function confirmar(Router $router){
        $alertas=[];
        /* Agregamos el metodo s, esto evitar los caraecteres especiales del metodo GET */
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