<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpleadosModel extends Model
{

    protected $db;

    protected $table      = 'Empleados';
    protected $primaryKey = 'Id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['nombre'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'nombre' => 'required|alpha_space|min_length[3]|max_length[50]',
        // 'correo' => 'permit_empty|valid_email'
    ];
    protected $validationMessages = [
        'nombre' => [
            'required' => 'Debe llenar el campo nombre'
        ]
    ];
    protected $skipValidation     = false;
}