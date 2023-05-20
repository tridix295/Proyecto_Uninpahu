<?php
namespace App\Controllers\MiddleWare\bus;
use Helpers\hash;
use App\Models\User\UserModel;
use Helpers\sessionClient;

class auth{
    /**
     * Inicializar el administrador de sesiones.
    */
    use sessionClient{
        sessionClient::__construct as private session;
    }

    private $status = false;

    public function __construct()
    {
        $this->isLoged();
        return $this;
    }

    /**
     * Valida si encuentra una session activa, de ser asi no lo deja ingresar al login o registro.
    */
    private function isLoged(){
        $this->status = $this->getElementSession('UsId');
        if($this->status && strpos($_SERVER['REQUEST_URI'],'login') !== false){
            $this->redirected();
        } 
    }

    /**
     * Valida si un usuario puede autenticarse o no de manera satisfactoria.
     * @param string $pass Contraseña digitada.
     * @return auth
    */
    public  function validate($pass){
        //Obtenemos la clave del usuario en caso de que encuentre algun registro con el correo dado.
        $user = UserModel::where('UsEmail',$pass['email'])->first();

        //Si existe un usuario y la clave de este coincide generamos una sesion.
        if($user && hash::verifyPasswordHash((string) $pass['password'],$user->UsPassword)){
                $this->guard($user->TuTipoUsuario,$user->TuTipoUsuario);
        }
        return $this;
    }

    /**
     * Almacena la sesion de un usuario especifico.
     * @param string $tipo tipo de usuario
     * @param string $Id Id del usuario
     * @return void
    */
    private function guard($tipo,$Id):void {
        $this->setSession(["UsId" => $Id, 'UsTipo' => $tipo]);
        $this->status = true;
    }

    /**
     * Redirecciona un usuario a una vista en especifico.
     * @param string Vista
    */
    public function redirected( string $view = 'login')
    {
        if($this->status){
            $view = 'home';
        }
       header("Location: /$view");
    }
}
?>