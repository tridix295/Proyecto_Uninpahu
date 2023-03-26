<?php
use App\Controllers\BaseController\BaseController;

class Home extends BaseController {
        public function __construct()
        {
            parent::__construct('Home');
        }

        public function index(){
         $this->view->getView("index","Home");
        }
    }
?>