<?php

use App\Controllers\BaseController\BaseController;
use Helpers\helper;
use App\Controllers\MiddleWare\bus\auth;
use App\Models\User\UserModel;
use Helpers\sessionClient;

class User extends BaseController{
    use sessionClient;

    private $auth;
    public function __construct()
    {
        parent::__construct();
        $this->auth = new auth();
    }
    public function index(){
        $UsId = $this->getElementSession('UsId');

        $data = UserModel::where('UsId',$UsId)->first();
//var_dump($data->toArray());die();
        $this->view->getView("index","User",$data->toArray());
    }

}

?>