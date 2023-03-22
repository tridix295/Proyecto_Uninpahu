<?php

use Helpers\flash;

// Obtenemos lo que sea que nos llegue por la url, sino llega nada nuestro
// controlador por defecto sera home.
$url = $_GET["url"] ?? "home";
$url = flash::sliceRoute($url);

// Definimos el nombre del controlador
// Cada controlador debe tener la siguiente nomenclatura:
// {nombreController}
$controllerName = $url['controller'];

$controllerFile = Path_App . '/App/Controllers/Http/' . $controllerName . 'Controller.php';
if(!flash::validationRss('Controller',$controllerFile)){
    die("Controlador no encontrado");
};


require_once $controllerFile;
if(!class_exists($controllerName)){
    die("El controlador $controllerName no esta definido");
}
// Instanciamos el controlador segun el nombre que nos llegue desde la url, tener en cuenta que el
// nombre de la clase debe ser igual al nombre del archivo
$controller = new $controllerName();
$methodName = $url['method'];
if(!method_exists($controller, $methodName)){
    die("La accion $methodName no esta definida en el controlador $controllerName");
}
$params = $url['params'];
//Inicio de operacion con el controlador.
$controller->{$methodName}($params);
?>