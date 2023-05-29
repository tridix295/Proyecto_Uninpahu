<?php
namespace App\Controllers\Http\Auth;
use App\Controllers\BaseController\views;
use App\Controllers\MiddleWare\bus\auth;
use App\Controllers\MiddleWare\bus\request;

    class register{

        use request{
            request::__construct as request;
        }

        private static $view;

        private $auth;
        public function __construct()
        {
            self::$view = new Views();
            $this->auth = new Auth;
            
        //Si el usuario ya inicio sesion se redirecciona al home.
        if($this->auth->login()){
           // $this->auth->redirected('home');
        }
        }

        public function index(){
            self::$view->getView("register","Login");
        }
    
        /**
        * Evento insert
        */
        public function insert(){
            $this->store();
        }

        private function store(){
            $request = $this->request()->Post();
            if($request){
                $this->auth->register($request);
                $this->auth->login();
                if(1 == 1){
                    /**
                     *  2 -> Usuario natural.
                     *  3 -> Usuario empresa 
                    */

                    $user = array_filter($this->request()->Mix(['natural', 'empresa']), function($value) {
                        return $value !== null && $value !== '';
                    });
                    $user = implode($user);
                    //var_dump($user === 3 ? 'empresa' : 'natural');die;        
                    self::$view->getView($user === 3 ? 'empresa' : 'natural', "Login");
                    
                }else{
                    $this->auth->redirected('register');
                }
            }
        }
    }
?>