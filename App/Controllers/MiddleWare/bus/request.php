<?php
namespace App\Controllers\MiddleWare\bus;

use Helpers\sessionClient;
/**
 * Clase auxiliar para poder trabajar con datos previamente enviados desde POST|GET.
 */
trait request {
    /**
     * Request data.
     */
    private $request = array();

    /**
     * Inicializar el administrador de sesiones.
    */
    use sessionClient{
        sessionClient::__construct as private token;
    }

    /**
     * Inicializamos los valores que podemos recibir mediante HTTP
     * @return request
    */
    public function __construct() {
        $this->request = array(
            'uri' => $_SERVER['REQUEST_URI'],
            'method' => $_SERVER['REQUEST_METHOD'],
            'headers' => getallheaders(),
            'params' => $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET,
            'client_ip' => $_SERVER['REMOTE_ADDR']

        );
        return $this;
    }

    /**
     * Devolvemos los datos de una solicitud POST
     * @return mixed
    */
    public function Post() {
        $token = $this->token()->validateToken($this->request['params']['csrf_token']);
        if($token){
            return $this->request['method'] === 'POST' ? $this->request['params'] : false;
        }
    }

    /**
     * Devolvemos los datos de una solicitud GET
     * @return mixed
    */
    public function Get() {
        return $this->request['method'] === 'GET' ? $this->request : false;
    }

    /**
     * Devuelve un elemento de la solicitud http entrante
     * @return string
     */
    protected function getParam($element) {
        return !empty($this->request['params'][$element]) ? $this->request['params'][$element] : false;
    }

    /**
     * Devuelve todos los elementos de la solicitud http.
     * @return mixed
     */
    protected function getAll() {
        return $this->request;
    }

    /**
     * Devuelve todos los elementos de la solicitud GET/POST.
     * @return mixed
     */
    protected function getQuery() {
        return !empty($this->request['params']) ? $this->request['params'] : false;
    }

}
?>