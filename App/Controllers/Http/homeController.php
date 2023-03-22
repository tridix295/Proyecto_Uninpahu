<?php
use App\Controllers\BaseController\BaseController;
use App\Model;
class Home extends BaseController {
        public function __construct()
        {
            parent::__construct('Home');
        }

        public function index(){
          echo  $this->model->get();
        }
    }
?>