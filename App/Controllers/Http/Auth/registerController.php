<?php
namespace App\Controllers\Http\Auth;
use App\Controllers\BaseController\views;
use App\Models\User\UserModel;

    class register{
        private static $view;

        public function __construct()
        {
            self::$view = new Views();
        }

        public function index(){
            self::$view->getView("register","Login");
        }
    }
?>