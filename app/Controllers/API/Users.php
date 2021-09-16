<?php

namespace App\Controllers\API;

use App\Models\EmpleadosModel;
use App\Models\LoginModel;
use App\Models\UsuarioModel;
use CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController{

    public function __construct(){
        $this->model = $this->setModel(new UsuarioModel());
        helper('HashPassword');
    }

    public function getUsuarios()
	{
        $usuarios = $this->model->findAll();
        return $this->setResponseFormat('json')->respond($usuarios);
	}

    public function create(){
        try {
           $usuario = $this->request->getJSON();
           if($this->model->insert($usuario)):
            $usuario->Id = $this->model->insertID();
                return $this->setResponseFormat('json')->respond($usuario);
           else:
                return $this->failValidationErrors($this->model->validation->listErrors());
           endif; 
            

        } catch (\Throwable $th) {
           return $this->failServerError('Error en el servidor -> '.$th);
        }
    }

    // Controlador -> Ejemplo de join
    public function getUsuariosEmpleados($id = null){
        try {
            $modelEmpleado = new EmpleadosModel();
            if($id == null)
                return $this->failValidationErrors('No se ha pasado un id valido');

            $valEmp = $modelEmpleado->find($id);
            if($valEmp == null)
                return $this->failNotFound('No se encontro en el sistema un cliente con identificación: '.$id);

            $getUsuarios = $this->model->ListEmpleadoUsuario($id);
            
            return $this->respond($getUsuarios);

        } catch (\Exception $th) {
            return $this->failServerError('Ha ocurrido un un error en el servidor  '. $th);
        }
    }

    public function crearUsuario(){

        try {
            $modelo = new LoginModel();
            $user = $this->request->getPost('usuario');
            $pass = $this->request->getPost('password');
            if(hashPassword($pass)):
                $password = hashPassword($pass);
            endif;

            $data = [
                'usuario' => $user
            ];
    
            if($modelo->insert(
                [
                    'usuario'   => $user,
                    'password'  =>  $password
                ]  
            ));
            return $this->respond($data);
        } catch (\Throwable $th) {
            return $this->failServerError('Ha ocurrido un un error en el servidor  '. $th);
        }


       
    }
   
}