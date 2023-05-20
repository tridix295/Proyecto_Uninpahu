<?php
namespace App\Controllers\MiddleWare\bus;

use Helpers\sessionClient;
use Twig\TwigFunction;

/**
 * Clase para poder trabajar con tokens desde las vistas.
 */
class csrf_token extends \Twig\Extension\AbstractExtension{

        /**
         * Inicializamos el administrador de sesiones.
         */
        use sessionClient{
            sessionClient::__construct as session;
        }

        /**
         * Configuracion inicial para poder trabajar con csrf token desde el cliente.
         */
        public function __construct()
        {
            $this->session();
        }

        /**
         * Ejecutamos la implementacion de getFunctions la cual podra ser usada en las plantillas de twig,
         * para esto registramos inicialmente el nombre de nuestra funcion, y le pasamos la referencia de
         * la funcion en el contexto actual del objeto.
         * @return Twigfunction[]
         */
        public function getFunctions(){
            return [new TwigFunction('csrf_token',[$this,'getCsrfToken'])];
        }
        
        /**
         * Genera un token y lo almacena en un input cada vez que es llamado desde la vista.
         * @return string Cadena de texto el cual representa un input con un token csrf.
         */
        public function getCsrfToken(){

            //Obtenemos un token aleatorio.
            $token = $this->createToken()->getElementSession('csrf_token');

            //Almacenamos el token en la sesion para que sea persistente
            $_SESSION['csrf_token'] = $token;
            return "<input type='hidden' name='csrf_token' value ='$token'>";
        }
        
    }
?>