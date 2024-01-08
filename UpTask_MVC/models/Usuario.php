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
    public $password2;

    public function __construct($args=[])
    {
        $this->id=$args['id'] ?? null;
        $this->nombre=$args['nombre'] ?? '';
        $this->email=$args['email'] ?? '';
        $this->password=$args['password'] ?? '';
        /* aqui se esta creando la variable password2 , para darle todo eso */
        $this->password2=$args['password2'] ?? '';
        $this->token=$args['token'] ?? '';
        $this->confirmado=$args['confirmado'] ?? '';
    }

    //Validación para cuentas neuvas
    public function validarNuevaCuenta(){
        /* this nombre, si se pone, si no se pone sale falso , pero como se niega es verdadero por eso pasa la validación */
        if(!$this->nombre){
            self::$alertas['error'][]="El nombre del Usuario es Obligatorio";
        }
        if(!$this->email){
            self::$alertas['error'][]="El Email del Usuario es Obligatorio";
        }
        if(!$this->password){
            self::$alertas['error'][]="El Password del Usuario no puede ir vacio";
        }
        if(strlen($this->password)<6){
            self::$alertas['error'][]="El Password debe de contener almenos 6 caracteres";
        }
        if($this->password !== $this->password2){
            self::$alertas['error'][]="Los password tienes que ser iguales";
        }
        return self::$alertas;
    }
    //Hashea el Password 
    public function hashPassword(){
        $this->password=password_hash($this->password,PASSWORD_BCRYPT);
    }
    public function crearToken(){
        $this->token=uniqid();
    }


}


?>