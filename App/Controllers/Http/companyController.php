<?php
use App\Controllers\BaseController\BaseController;
use App\Controllers\MiddleWare\bus\auth;
class Company extends BaseController {
    private $auth;
        public function __construct()
        {
            parent::__construct('Home');
            $this->auth = new auth();
        }

        public function index(){
         $this->view->getView("index","Companies");
        }
    }
?>