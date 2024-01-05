<?php 

/* AQUI SE HACE LLAMADO DEL COMPOSER */

require 'funciones.php';
require 'database.php';
require __DIR__ . '/../vendor/autoload.php';

// Conectarnos a la base de datos
use Model\ActiveRecord;
/* Sacando la base de datos de forma directa, sin ningún problema */
ActiveRecord::setDB($db);