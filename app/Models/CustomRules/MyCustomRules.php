<?php 
namespace App\Models\CustomRules;

use App\Models\UsuarioModel;

class MyCustomRules{
    public function is_valid_empleado(int $id):bool{

        $model = new UsuarioModel();
        $empleado = $model->find(($id));
        return $empleado == null ? false : true;
    }
}