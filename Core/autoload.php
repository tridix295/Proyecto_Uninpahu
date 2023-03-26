<?php
/**
*   Este sctript tiene como finalidad cargar de manera dinamica las clases que sean heradadas del controlador padre en funcion del namespace de la clase padre.
*   Ejem.
*   /Core/...
*       {Controller_Home} extends baseController...
*   /Helpers/...
*       {class_helper} extends Messages...
*   @author Sebastian Diaz
*   @version 1.0
*   @param string $class_name clase hija a instanciar.
*   @return void  
**/

function getClass($class_name) {
    $filename = "";
    //Arreglamos la ruta de class_name
    $class_name = str_replace("\\","/",$class_name);
    // Determinamos la ruta del archivo de la clase hija según su namespace
    if (strpos($class_name, 'Core') === 0) {
        $filename = Path_App . '/' . $class_name . '.php';
    } elseif (strpos($class_name, 'Helpers') === 0) {
        $filename = Path_App . '/' . $class_name . '.php';
    }

    // Cargamos el archivo de la clase hija si existe
    if(file_exists($filename)){
        require_once $filename;
    }

}
// Registramos la función getClass() como autoload
spl_autoload_register('getClass');
?>