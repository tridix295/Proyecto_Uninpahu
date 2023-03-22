<?php
namespace App\Controllers\BaseController;

class BaseController {
    protected $model;
    protected $view;
 
    public function __construct() {
        $modelName = get_class($this);
        $modelClass = "\\App\\Models\\{$modelName}\\{$modelName}Model";
        $this->model = new $modelClass();
        $this->view = new views();
    }
  //  public function getView();
 }
 
?>