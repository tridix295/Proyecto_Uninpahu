<?php
use App\Controllers\BaseController\BaseController;
use App\Controllers\MiddleWare\bus\auth;
use App\Controllers\MiddleWare\bus\request;
use Helpers\sessionClient;
use App\Models\User\UserModel;

class Company extends BaseController {
    use request{
        request::__construct as request;
    }

    use sessionClient;
    private $auth;
        public function __construct()
        {
            parent::__construct('Home');
            $this->auth = new auth();
        }

        public function index(){
            $UsId = $this->getElementSession('UsId');

            $data = UserModel::where('UsId',$UsId)->first();

            $this->view->getView("index","Companies",$data->toArray());
         
        }

        public function insert(){
            $this->store();
        }

        private function store(){
            $http = $this->request()->POST();
            $UsId = $this->getElementSession('UsId');
            if($http && $UsId){
                unset($http['csrf_token']);
                $http['EmUsId'] = $UsId;
                $status = $this->model->insert($http);

                if($status){
                    $this->auth->redirected();
                }
            }
           // var_dump($status,$http,$UsId);die();    
        }
    }
?>