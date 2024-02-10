<?php 

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;

class TareaController{
    public static function index(){
       
    }
    public static function crear(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            /* Creando un array del codigo */
            /* $juan="Juanito Alimaña";
            $array=[
                'nombre' => $juan,
                'apellidos' => 'Khalifa'
            ]; 
             */
            session_start();
            /* Verificamos el Proyecto con Where para juntar esto */
            $proyecto= Proyecto::where('url',$_POST['proyectoId']);
            /* debuguear($proyecto); */
            /* El objetivo de esto es crear las tareas correspondientes en base al ID del proyecto, teniendo en cuenta también que el Usuario sea la persona 
            quien la creó... */
            /* Comparación de propietario al momento de crear la tarea o actividad */
            if(!$proyecto || $proyecto->propietarioId!==$_SESSION['id']){
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un Error al agregar la tarea'
                ];
                echo json_encode($respuesta);
                return;
            }

            $tarea=new Tarea($_POST);
            $tarea->nombre=$_POST['nombre'];
            $tarea->proyectoId=$proyecto->id;
            $resultado=$tarea->guardar();
            /* $resultado=$tarea->guardar(); */
            if($resultado){
                $respuesta = [
                    'tipo' => 'exito',
                    'mensaje' => 'Agregado correctamente'
                ];
                echo json_encode($respuesta);
            }
           
        

        /* echo json_encode("Bienvenido al mundo del servidor y creación"); */
        /* echo "<br>"; */
        /* echo "<br>"; */
       /*  echo json_encode("Imprimiendo arreglo".$array); */
        }
    }
    public static function actualizar(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            
        }
    }
    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            
        }
    }
}


?>