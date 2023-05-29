<?php
use App\Controllers\BaseController\BaseController;
use App\Controllers\MiddleWare\bus\auth;
use Helpers\sessionClient;
use App\Models\User\UserModel;

class Home extends BaseController {
    private $auth;
    use sessionClient;
        public function __construct()
        {
            parent::__construct('Home');
            $this->auth = new auth();
        }

        public function index(){
            $UsId = $this->getElementSession('UsId');

            $data = userModel::where('UsId',$UsId)->first();
            //var_dump();die();
            $this->view->getView("index","Home",$data->toArray());
        }
    }
?>