<?php

use App\Controllers\BaseController\BaseController;
use Helpers\sessionClient;
use App\Models\User\UserModel;

class Jobs extends BaseController{
    use sessionClient;

    public function __construct()
    {
        parent::__construct();
    }
    public function index(){
        $UsId = $this->getElementSession('UsId');

        $data = UserModel::where('UsId',$UsId)->first();
        $this->view->getView("search","Jobs",$data->toArray());
    }
}

?>