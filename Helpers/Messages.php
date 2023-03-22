<?php 
namespace Helpers;
    class Messages{
        private $Messages = array();

        /**
         *  Desde el constructor llamamos a la libreria donde se encuentran los mensajes de estados.
         *  @param string $lang Lenguaje de los mensajes
         */
        public function __construct(string $lang)
        {
            $dataMessage = require_once Path_App . "/Language/$lang/status.php";
            $this->Messages = $this->LoadMessages($dataMessage);
        }

        /**
         *  Funcion para obtener el mensaje para un codigo en especifico.
         *  @param string $code Codigo del mensaje.
         *  @return string Mensaje para el codigo segun corresponda.
         */
        public function getMessage(string $code){
            return isset($this->Messages[$code]) ? $this->Messages[$code] : "nothing";
        }

        /**
         *  Funcion para poblar los mensajes.
         *  @param array $data Diccionario de datos.
         *  @return array
         */
        private function LoadMessages(array $data){
            $messages = array();

            //Recorremos cada elemento del diccionario y lo almacenamos.
            foreach($data as $key => $value){
                $messages[$key] = $value;
            }
            return $messages;
        }
    }
?>