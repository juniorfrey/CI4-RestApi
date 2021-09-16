<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table      = 'Usuarios';
    protected $primaryKey = 'Id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['usuario','idEmpleado'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'usuario' => 'required|alpha_space|min_length[3]|max_length[50]',
        'idEmpleado' => 'required'
    ];
    protected $validationMessages = [
        'usuario' => [
            'required' => 'Debe llenar el campo nombre'
        ],
        'idEmpleado' => [
            'required' => 'Empleado no existe'
        ]
    ];
    protected $skipValidation     = false;

    // Join codeigniter 4
    public function ListEmpleadoUsuario($empleadoId = null){
        $builder = $this->db->table($this->table);
        $builder->select('Usuarios.Id as idUsuario, Usuarios.usuario as usuario, Empleados.nombre, Empleados.created_at');
        $builder->join('Empleados','Usuarios.idEmpleado = Empleados.id');
        $builder->where('Empleados.id',$empleadoId);
        

        $query = $builder->get();
        return $query->getResult();

    }

}