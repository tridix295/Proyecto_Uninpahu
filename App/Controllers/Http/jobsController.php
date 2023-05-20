<?php

use App\Controllers\BaseController\BaseController;

class Jobs extends BaseController{
    public function __construct()
    {
        parent::__construct();
    }
    public function index(){
        $this->view->getView("search","Jobs");
    }
}

?>