<?php

namespace Helpers;

use Helpers\helper;

trait sessionClient
{


    //Tiempo de vida de la sesion
    private $expire = 5;
    private $instance;

    /**
     * Configuracion inicial para trabajar con sessiones.
     * @return sessionClient
     */
    public function __construct()
    {
        //Comprobamos si la sesion ya está activa
        if (session_id() === '') {
            //Definimos el tiempo de vida para las sesiones y cookies
            ini_set('session.gc.maxlifetime', $this->expire);
            session_set_cookie_params($this->expire);

            //Iniciamos la sesión
            session_start();
            session_regenerate_id(true);
        }
        return $this;
    }

    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Funcion para obtener un elemento especifico de la sesion del usuario
     * @param string $element Elemento a bucar dentro de la session.
     * @return string|bool
     */
    protected function getElementSession($element)
    {
        session_status() === PHP_SESSION_ACTIVE ? '' : session_start();
        return !empty($_SESSION[$element]) ? $_SESSION[$element] : false;
    }

    /**
     * A partir de un parametro array los almacena en una sesion.
     * @param mixed $session valores a almacenar en la sesion => ['UsId' => 1, 'UsTipo' => 1]
     * @return void
     */
    protected function setSession(Array $session): void{
        foreach($session as $index => $value){
            if(!isset($_SESSION[$index])){
                $_SESSION[$index] = $value;
            }
        }
    }
    
    /**
     * Funcion para generar un token CSRF
     * @return string
     */
    private function generateCsrfToken()
    {
        return helper::getCsrf();
    }
    /**
     * Funcion para generar un token y ser almacenada en una sesion de manera persistente.
     * @return $this
     */
    protected function createToken()
    {
        $_SESSION['csrf_token'] = $this->generateCsrfToken();
        $_SESSION['enlapsed_time'] = time();
        return $this;
    }

    /**
     * Funcion para destruir una o varios elementos dentro de la session.
     * @param mixed $elements Elementos/indices a eliminar de la sesion.
     */
    protected function destroySession(array $elements = [])
    {
        foreach ($elements as $index) {
            if (isset($_SESSION[$index])) {
                unset($_SESSION[$index]);
            }
        }
    }

    /**
     * Valida si un token es valido o no y destruye al sesion al finalizar.
     * @param string $token Token a validar segun los datos almacenados en la sesion del usuario.
     * @return bool
     */
    protected function validateToken(string $token):bool
    {

        $status = hash_equals($this->getElementSession('csrf_token'), $token);
        $this->destroySession(['csrf_token']);

        return $status;
    }

    /**
     * Funcion para regenerar una sesion cuando esta ya ah expirado.
     * @return void
     */
    protected function regenerateSession()
    {
        if ($this->getElementSession('enlapsed_time') and (time() - $this->getElementSession('enlapsed_time')) > $this->expire) {
            session_regenerate_id(true);
            $_SESSION['enlapsed_time'] = time();
        }
    }
}
