<?php
/**
 * Script principal para el procesamiento y cargue de los controladores en funcion de la
 * peticion http
 * @author Sebastian Diaz
 * @version 1.0
 */
require_once Path_App . '/Core/autoload.php';


use Helpers\helper;

// Obtenemos lo que sea que nos llegue por la url, sino llega nada nuestro
// controlador por defecto sera home.
$url = $_GET["url"] ?? "home";
$url = helper::sliceRoute($url);

// Definimos el nombre del controlador
// Cada controlador debe tener la siguiente nomenclatura:
// {nombreController}
$controllerFile = helper::makeRoute($url['controller'],$specialRepos);
if(!helper::validationRss('Controller',$controllerFile["path"])){
    die("Controlador no encontrado " . $controllerFile["class"]);
};


require_once $controllerFile["path"];
if(!class_exists($controllerFile["class"])){
    die("El controlador ". $controllerFile["class"] ." no esta definido");
}
// Instanciamos el controlador segun el nombre que nos llegue desde la url, tener en cuenta que el
// nombre de la clase debe ser igual al nombre del archivo
$controller = new $controllerFile["class"]();
$methodName = $url['method'];
if(!method_exists($controller, $methodName)){
    die("La accion $methodName no esta definida en el controlador ". $controllerFile["class"]);
}
$params = $url['params'];
//Inicio de operacion con el controlador.
$controller->{$methodName}($params);
?>