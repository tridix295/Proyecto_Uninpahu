<?php

use App\Controllers\BaseController\BaseController;
use Helpers\helper;

class User extends BaseController{
    public function __construct()
    {
        parent::__construct();
    }
    public function index(){
        $this->view->getView("index","User");
    }
}

?>