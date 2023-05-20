<?php

namespace App\Controllers\Http\Auth;

use App\Controllers\MiddleWare\bus\request;
use App\Controllers\BaseController\views;
use App\Controllers\MiddleWare\bus\auth;


class login
{

    use request{
        request::__construct as private request;
    }

    private $auth;

    public function __construct()
    {
        $this->auth = new auth();
    }


    public function index()
    {
        $objView = new views();
        $objView->getView('Login', 'login');
    }

    /**
     * 
     */
    public function succes()
    {
       
    }

    /**
     * Evento auth
     */
    public function Auth()
    {
       $this->Authenticate();
    }

    /**
     * Evento insert
    */
    public function insert(){
        $this->store();
    }

    public function store(){

    }

    /**
     * Administra el evento de login, valida si un usuario se logueo y lo redirecciona al home o login segun
     * sea el caso.
     */
    private function Authenticate(){

        //Obtenemos los datos mediante POST.
        $request = $this->request()->Post();

        if($request){
            //Validamos la informacion y lo redireccionamos a la vista correspondiente.
            $this->auth->validate($request)->redirected();
        }
    }
}
