<?php
namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Psr\Container\ContainerInterface;

class UserModel extends Model{

    private $container;

    protected $table = 'usuarios';

    public function __construct()
    {

    }

    protected function insert(){
        $validator = $this->container->get(validation::class);
        var_dump($validator);
    }

}

?>