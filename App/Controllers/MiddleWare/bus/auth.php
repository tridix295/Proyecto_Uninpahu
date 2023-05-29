<?php
namespace App\Controllers\MiddleWare\bus;

use Helpers\hash;
use App\Models\User\UserModel;
use Helpers\user;
use Helpers\sessionClient;
use Illuminate\Database\QueryException;

/**
 * clase para administrar los procesos de autenticacion.
 */
class auth{
    /**
     * Inicializar el administrador de sesiones.
    */
    use sessionClient{
        sessionClient::__construct as private session;
    }

    public $logged = false;

    public function __construct()
    {
        $this->isLoged();
        return $this;
    }

    public function register(Array $request){
        $this->store($request);
        return $this;
    }

    public function logout(){
        $status = $this->destroySession($_SESSION);
        $this->redirected();
    }

    /**
     * Indica si el usuario se encuentra logueado.
     * @return bool
     */
    public function login():bool {
        return $this->logged;
    }

    private function store(array $request){
        //Obtenemos la clave del usuario en caso de que encuentre algun registro con el correo dado.
        $user = UserModel::where('UsEmail',$request['email'])->first();

        if(!$user){
            //var_dump($request);die();
            $pass = hash::generatePasswordHash($request['pass']);
            $age =user::age($request['nacimiento']);
  
            try { 
                $user = UserModel::create([
                'TuTipoUsuario' => 1,
                'UsNombre' => $request['username'], 
                'UsApellido1' => $request['primerapellido'],
                'UsApellido2' => $request['segundoapellido'],
                'UsEmail' => $request['email'],
                'UsPassword' => $pass,
                'UsTelefono' => null,
                'UsEdad', $age,
                'UsFechaNacimiento', $request['nacimiento']
            ]);

            //Genera una sesion despues de insertar la info.
            $this->guard($user->TuTipoUsuario,$user->id);
            }catch(QueryException $e){
                die($e -> getMessage());
            }
        }
    }

    /**
     * Valida si encuentra una session activa, de ser asi no lo deja ingresar al login o registro.
    */
    private function isLoged(){

        $this->logged = $this->getElementSession('UsId');
        if(!$this->logged && strpos($_SERVER['REQUEST_URI'],'login') === false && strpos($_SERVER['REQUEST_URI'],'register') === false){
    
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
        //die("$tipo | $Id");
        $this->setSession(["UsId" => $Id, 'UsTipo' => $tipo]);
        $this->logged = true;
    }

    /**
     * Redirecciona un usuario a una vista en especifico.
     * @param string Vista
    */
    public function redirected( string $view = 'login')
    {
    
       header("Location: /$view");
    }
}
?>