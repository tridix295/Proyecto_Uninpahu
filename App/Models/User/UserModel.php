<?php
namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Psr\Container\ContainerInterface;

class UserModel extends Model{


    private $container;

    protected $table = 'usuarios';

    protected $primaryKey = 'UsId';
    
    protected $fillable = ['TuTipoUsuario','UsNombre','UsPrimeraVez','UsApellido1','UsApellido2','UsEmail','UsPassword','UsTelefeno','UsEdad','UsFecha'];

    const CREATED_AT = 'UsCreacion';

    const UPDATED_AT = 'UsUltimaActualizacion';

    public function __construct()
    {

    }

    protected function insert(){
        $validator = $this->container->get(validation::class);
        var_dump($validator);
    }

}

?>