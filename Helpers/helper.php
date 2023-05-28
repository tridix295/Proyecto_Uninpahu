<?php
/**
 * Funciones auxiliares que pueden ser utilizadas a lo largo del proyecto
 * @author Sebastian Diaz
 * @version 1.0
 */
namespace Helpers;

class helper extends Messages
{
    private static $message;

    /**
     *  Inicializamos la propiedad message con nuestro objeto Messages
     *  @return void
     */
    private static function initializeMessages()
    {
        //Instancias el objeto donde se encuentran nuestro diccionario de estados.
        self::$message = new Messages('es');
    }

    /**
     *   Funcion para definir el metodo y controlador que estaremos llamando en funcion
     *   de la solicitud http que nos llegue.
     *   @param string $url Peticion http
     *   @return array Array asociativo con el controlador,metodo y parametros en caso de ser necesario.
     */
    public static function sliceRoute(string $url)
    {
        // Convertir todo a minúsculas para evitar problemas de mayúsculas y minúsculas
        $url = strtolower($url);

        // Dividir la URL en sus componentes
        $url_parts = explode('/', $url);

        // Extraer los componentes relevantes
        $controller = isset($url_parts[0]) ? $url_parts[0] : $url;
        $method = isset($url_parts[1]) ? $url_parts[1] : 'index';
        $params = isset($url_parts[2]) ? implode(',', array_slice($url_parts, 2)) : null;

        // Construir la matriz de salida
        $output = [
            'controller' => $controller,
            'method' => $method,
            'params' => $params,
        ];

        return $output;
    }

    /**
     * Muestra una salida de depuración legible y organizada con lista desplegable.
     * @param mixed $data El dato que se va a depurar.
     * @return void
     */
    public static function debug($data)
    {
        // Imprime un contenedor preformateado con estilos CSS
        echo '<pre style="background-color: #F7F7F7; color: #333; font-size: 14px; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">';
        // Llama a la función recursiva para imprimir el contenido del dato
        self::recursiveDebug($data);
        // Cierra el contenedor preformateado
        echo '</pre>';
    }

    /**
     * Función recursiva que imprime los datos en una lista desplegable.
     * @param mixed $data El dato que se va a imprimir
     * @return void
     */
    private static function recursiveDebug($data)
    {
        // Verifica si el dato es un array
        if (is_array($data)) {
            // Si es un array, imprime una lista desplegable con el tipo "Array"
            echo '<details style="margin-left: 10px; margin-bottom: 5px;"><summary style="cursor: pointer; font-weight: bold; padding: 5px; border-radius: 5px; background-color: #D1D1D1;">Array</summary><ul style="list-style-type: none; margin: 0; padding-left: 15px;">';
            // Recorre el array y llama a la función recursiva para imprimir cada elemento
            foreach ($data as $key => $value) {
                echo '<li style="margin-bottom: 5px;"><span style="color: #666;">' . htmlspecialchars($key) . '</span> => ';
                self::recursiveDebug($value);
                echo '</li>';
            }
            // Cierra la lista
            echo '</ul>';
            // Cierra la lista desplegable
            echo '</details>';
        } else {
            // Si no es un array, imprime el valor como texto plano
            echo '<span style="color: #EE6E73;">' . htmlspecialchars(var_export($data, true)) . '</span>';
        }
    }

    /**
     *  Funcion para validar si un recurso (carpeta o archivo existe)
     *  @param string $type Tipo de recurso al cual se esta invocando.
     *  @param string $path Ruta del recurso
     *  @return boolean
     */
    public static function validationRss($type, $path)
    {
        $status = is_file($path);
        $time = date('Y-m-d');
        if (!$status) {
            self::initializeMessages();
            //Codigo de status en caso de fallar.
            $codeStatus = 'WR-RSS-00';

            //Obtenemos el mensaje segun el codigo de status
            $message = self::$message->getMessage($codeStatus);
            $message = "\n Tipo: $type \n\n Mensaje: $message $path \n\n Path: $path";
            self::logRegister(Path_App . "/Logs/LlamandoRecursos_$time.log", $message);
        }
        return $status;
    }

    /**
     * Funcion para registros los distintos logs que pueda generar el sistema.
     * @param string $pathlog ruta fisica donde se va a alamacenar el log.
     * @param mixed $content contenido del log
     * @return void
     */
    public static function LogRegister($pathlog, $content)
    {
        $time = date('Y-m-d H:i:s');
        $data = PHP_EOL . '***** Inicio Log:' . $time . ' *****' . PHP_EOL . $content . PHP_EOL . '**** Fin Log ****' . PHP_EOL;

        $handle = fopen($pathlog, 'a+');
        fwrite($handle, $data);
        fclose($handle);
    }
    
    /**
     * Valida la estructura de una url, y busca alguna coincidencia con el parametro buscado.
     * @param mixed|string $search Parametro a buscar.
     * @param int $precise 
     *  0 -> Indica si dentro de la url debe aparecer todos los elementos buscados.
     *  1 -> Indica que en caso de no encontrar alguna concidencia no finaliza la ejecucion.
     * @return mixed|bool
     */
    public static function uri($search,int $precise = 0) {
        $uri = array();
        $url = $_SERVER['REQUEST_URI'];

        //Busca los elemtos dentro de la url.
        if(is_array($search)){
            foreach($search as $key){
                $find = strpos($url,$key);
                
                //Si dentro de alguno de los elementos no coincide finaliza la ejecucion y devuelve el estado.
                if($precise === 0 && !$find){
                    return $find;
                }else{
                    $uri[$key] = $find; 
                }
            }
        }elseif(is_string($search)){
            $find = strpos($url,$search);
            
            //Si dentro de alguno de los elementos no coincide finaliza la ejecucion y devuelve el estado.
            if($precise === 0 && !$find){
                return $find;
            }else{
                $uri[$search] = $find; 
            }
        }

        return $uri;
    }

    public static function makeRoute($controller,$options = []){
        $path = array();
        if(array_key_exists($controller,$options)){
            $repo = str_replace('\\','/',$options[$controller]);
            $path["class"] = $options[$controller] . "\\$controller";
            $path["path"] = Path_App . '/' . $repo . '/' . $controller . 'Controller.php';
        }else{
            $path["class"] = $controller;
            $path["path"] = Path_App . '/App/Controllers/Http/'. $controller . 'Controller.php';
        }
        return $path;
    }

    public static function getCsrf()
    {
        return bin2hex(random_bytes(32));
    }

}

?>
