<?php
/**
 * Controlador principal el cual se encarga de ser el intermediario entre el controlado-vista-modelo
 * @author Sebastian Diaz
 * @version 1.0
 */
namespace App\Controllers\BaseController;

class BaseController {
    protected $model;
    protected $view;
 
    /**
     * Inicializamos el modelo y vista corresponde al controlador.
     * @param void
     */
    public function __construct() {
        $modelName = get_class($this);
        $modelClass = "\\App\\Models\\{$modelName}\\{$modelName}Model";
       // die( $modelClass);
        $this->model = new $modelClass();
        $this->view = new views();
    }
 }
 
?>