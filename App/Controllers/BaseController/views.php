<?php
namespace App\Controllers\BaseController;

use Helpers\flash;

    class views{
        protected $pathView = Path_App . "/Views/";
        public function getView(string $view,string $repo){
            $this->pathView .= $repo . "/$view.php";
            if(flash::validationRss("View",$this->pathView)){
                require $this->pathView;
            }   
        }
    }
?>