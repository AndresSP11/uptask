<?php

namespace Controllers;

use Model\Proyecto;
use MVC\Router;


class DashboardController{

    public static function index(Router $router){
        
        session_start();    

        isAuth();

        $id=$_SESSION['id'];

        $proyectos=Proyecto::belongsTo('propietarioId',$id);

        //En este caso redirecciona a la carpeta dashboard/index, osea el archivo que  va ejecutar 
        //En este caso el nombre de la ruta es dashboard, pero la dirección que toma es 'dashboard/index, osea
        //que a pesar que se llame index.php o la ruta dashboard, esta apuntando a index, lo cual se ejecuta index.php
        $router->render('dashboard/index',[
            'titulo'=>'Proyectos',
            'proyectos' => $proyectos
        ]);
    }

    public static function crear_proyecto(Router $router){
        
        //Validar el Usuario para empezar a ver si existe o no el Usuario

        session_start();

        isAuth();

        //Función validar

        $alertas=[];
        
        if($_SERVER['REQUEST_METHOD']==='POST'){

            /* Aqui para darle los valores $_POST */
            $proyecto=new Proyecto($_POST);       
            
            //Validar el proceso
            /* Funcioens de validar Proyecto */
            $alertas=$proyecto->validarProyecto();

            if(empty($alertas)){
                //Generar una URL ùnica
                $hash=md5(uniqid());
                $proyecto->url=$hash;
            
                //Almacenar el creador del proyecto
                $proyecto->propietarioId=$_SESSION['id'];


                $proyecto->guardar();

                header("Location: /proyecto?id=$proyecto->url");
                
                // Almacenar el creador del proyecto



                //Guardar

              
            }
           /*  
            debuguear($proyecto); */
        }
        //En este caso redirecciona a la carpeta dashboard/index, osea el archivo que  va ejecutar 
        //En este caso el nombre de la ruta es dashboard, pero la dirección que toma es 'dashboard/index, osea
        //que a pesar que se llame index.php o la ruta dashboard, esta apuntando a index, lo cual se ejecuta index.php
        $router->render('dashboard/crear-proyecto',[
            'titulo'=>'Crear Proyecto',
            'alertas'=>$alertas
        ]);
    }
    
    public static function proyecto(Router $router){
        
        session_start();

        isAuth();

        $token=s($_GET['id']); 


        if(!$token){
            header("Location: /dashboard");
        }
        //Aqui muestra el objeto del proyecto y sus propiedades
        $proyecto=Proyecto::where('url',$token);


        if($proyecto->propietarioId!==$_SESSION['id']){
            header("Location: /dashboard");
        }
        
        //En este caso redirecciona a la carpeta dashboard/index, osea el archivo que  va ejecutar 
        //En este caso el nombre de la ruta es dashboard, pero la dirección que toma es 'dashboard/index, osea
        //que a pesar que se llame index.php o la ruta dashboard, esta apuntando a index, lo cual se ejecuta index.php
        $router->render('dashboard/proyecto',[
            'titulo'=>$proyecto->proyecto
        ]);
    }


    public static function perfil(Router $router){
        
        session_start();

        isAuth();

        $token=$_GET['id'];
        //En este caso redirecciona a la carpeta dashboard/index, osea el archivo que  va ejecutar 
        //En este caso el nombre de la ruta es dashboard, pero la dirección que toma es 'dashboard/index, osea
        //que a pesar que se llame index.php o la ruta dashboard, esta apuntando a index, lo cual se ejecuta index.php
        $router->render('dashboard/perfil',[

            'alertas'=>$alertas,
            'titulo'=>'Perfil'

        ]);
    }



}


?>