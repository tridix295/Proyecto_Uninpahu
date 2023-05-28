<?php
namespace App\Models\Company;

use Illuminate\Database\Eloquent\Model;

class CompanyModel extends Model{

    protected $table = "empresa";

    protected $fillable = ['EmUsId','EmNit','EmRazonSocial','EmSector','EmDescripcion','EmUbicacion','EmLogo'];

    const CREATED_AT = 'EmFecha';

    const UPDATED_AT = 'EmFechaActualizado';

    public function get(){
        return 'Hola';
    }

    protected function register($request){
        return CompanyModel::insert($request);
    }
}
?>