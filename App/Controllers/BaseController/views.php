<?php
/**
 * Clase principal para el cargue y procesamiento de las vistas
 * @author Sebastian Diaz
 * @version 1.0
 */
namespace App\Controllers\BaseController;

use App\Controllers\MiddleWare\bus\csrf_token;
use Helpers\helper;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

    class views{

        //Ruta fisica de la ubicacion donde se estaran almacenando todas las vistas del sistema.
        protected $pathView = Path_App . "/Views/";

        //Ruta fisica de la cache del sistema, el cual requiere twig para su correcto funcionamiento.
        protected $cache = Path_App . '/Cache/';

    
        /**
         *  Funcion par obtener la vista que se invoco desde el controlador, renderizarla bajo el motor de twig y mostrarla en pantalla.
         *  @param string $view Nombre de la vista a invocar
         *  @param string $repo Carpeta que contiene la vista a invocar.
         *  Ejem. ../Home etc...
         *  @param mixed $data Datos que se puden enviar a la vista.
         *  @return void
         */
        public function getView(string $view,string $repo, $data = []){
            
            //Instanciamos el motor de twig, y le enviamos la ruta la cual sera el contenedor donde se van almacenar todas las vistas.
            $loader =  new FilesystemLoader($this->pathView);

            //Concatenamos la carpeta a nuestra ruta Ejem. .../Views/Home.
            $this->pathView .= $repo;

            //Se valida que el recurso exista
            if(helper::validationRss("View",$this->pathView . "/$view.html.twig")){

                //Cargamos el motor y renderizamos la vista.
                $twig = new Environment($loader,[
                    'cache' => $this->cache,
                    'debug' => true,
                    'auto_reload' => true
                    ]);
                $twig->addExtension(new csrf_token());
               echo $twig->render("$repo/$view.html.twig",$data);
            
            }else{
                echo 'No encontrado: ' . $this->pathView . "/$view.twig";
            } 
        }
    }
?>