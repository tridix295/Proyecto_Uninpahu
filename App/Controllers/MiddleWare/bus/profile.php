<?php
namespace App\Controllers\MiddleWare\bus;

use Helpers\sessionClient;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

    class profile extends AbstractExtension{

        use sessionClient{
            sessionClient::__construct as session;
        }

        private $profile = 2;
        private $dataUser = array();

        public function __construct(Array $data = [])
        {
            $this->dataUser = $data;
        }

        public function init()
        {
            return include Path_App . '/Profile/user.php';

        }

        public function getFunctions()
        {
            return [new TwigFunction('profile',[$this,'setProfile'])];
        }

        public function setProfile(){
            $profiles = $this->init();
            $typeUser = $this->getElementSession('UsId');
            $typeUser = $typeUser !== false ? $typeUser : 2;            

            $input  = call_user_func([$this,$profiles[$typeUser]]);
            return $input . $this->Default();
        }

        private function Default() {
            return '
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle perfil" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">'.
                        $this->dataUser['UsNombre']
                    .'</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="/user">Mi cuenta</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/login/logout">Salir</a></li>
                    </ul>
                </li>';
        }
        
        private function Empresa(){
            return '<li class="nav-item active"><a class="nav-link" href="/">Inicio</a></li>
                      <li class="nav-item"><a class="nav-link" href="/jobs">Trabajos</a></li>
                      <li class="nav-item"><a class="nav-link" href="/company">Mis vacantes</a></li>';
        }
        private function Natural(){
            return '<li class="nav-item active"><a class="nav-link" href="/">Inicio</a></li>
            <li class="nav-item"><a class="nav-link" href="/jobs">Trabajos</a></li>
            <li class="nav-item"><a class="nav-link" href="/jobs">Mis postulaciones</a></li>';

        }
        private function Administrador(){
            return '<li class="nav-item active"><a class="nav-link" href="/">Inicio</a></li>';
        }
    }
?>