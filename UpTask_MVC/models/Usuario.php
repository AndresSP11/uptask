<?php

namespace Model;

class Usuario extends ActiveRecord{
    
    /* Nombre de la tabla de la base de datos */


    protected static $tabla = 'usuarios';
    /* Nombre de las columnas creadas en la base de datos */
    protected static $columnasDB=['id','nombre','email','password','token','confirmado'];
    /* Definiendo constructores y los valores de cada dato */

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $token;
    public $confirmado;

    public function __construct($args=[])
    {
        $this->id=$args['id'] ?? null;
        $this->nombre=$args['nombre'] ?? '';
        $this->email=$args['email'] ?? '';
        $this->password=$args['password'] ?? '';
        $this->token=$args['token'] ?? '';
        $this->confirmado=$args['confirmado'] ?? '';
    }

    //Validación para cuentas neuvas
    public function validarNuevaCuenta(){
        if(!$this->nombre){
            self::$alertas['error'][]="El nombre del Usuario es Obligatorio";
        }
        if(!$this->email){
            self::$alertas['error'][]="El Email del Usuario es Obligatorio";
        }
        return self::$alertas;
    }


}


?>