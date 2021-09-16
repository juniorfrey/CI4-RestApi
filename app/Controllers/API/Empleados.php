<?php

namespace App\Controllers\API;


use App\Models\EmpleadosModel;
use CodeIgniter\RESTful\ResourceController;


class Empleados extends ResourceController
{
    
    public function __construct(){
        $this->model = $this->setModel(new EmpleadosModel());
    }

	public function index()
	{
		/*$userModel = new UserModel($db);
		$user = $userModel->find('1');
		var_dump($user);
		return view('welcome_message');*/
        $empleados = $this->model->findAll();
        return $this->respond($empleados);
	}

    public function Empleados()
	{
        $empleados = $this->model->findAll();
        return $this->setResponseFormat('json')->respond($empleados);
	}

    // Crear unn nuevo empleado - POST
    public function create(){
        try {
           $empleados = $this->request->getJSON(); // recibo la data enviada desde el cliente
           if($this->model->insert( $empleados)): // ejecuto la función insert para guardar el json almacenado en la variable "$empleado"
                $empleados->Id = $this->model->insertID();
                return $this->setResponseFormat('json')->respondCreated($empleados); // enviamos respuesta de que se inserto al cliente
           else:
                return $this->failValidationErrors($this->model->validation->listErrors()); // se muestran los errores 
           endif;
        } catch (\Exception $th) {
            return $this->failServerError('Error en el servidor');
        }
    }

    // Consultar la información por id - GET
    public function edit($id = null){
        try {
            if($id == null)
                return $this->failValidationErrors('No se ha pasado un id valido');

            $empleado = $this->model->find($id);
            if($empleado == null)
                return $this->failNotFound('No se encontro en el sistema un cliente con identificación: '.$id);

            return $this->respond($empleado) ;


        } catch (\Exception $th) {
            return $this->failServerError('Ha ocurrido un un error en el servidor');
        }
    }

    // Actualizar la información - PUT
    public function update($id = null){
        try {
            if($id == null)
                return $this->failValidationErrors('No se ha pasado un id valido');

            $empleadoVer = $this->model->find($id);
            if($empleadoVer == null)
                return $this->failNotFound('No se encontro en el sistema un cliente con identificación: '.$id);
           
            $empleado =  $this->request->getJSON();
            if($this->model->update($id, $empleado)): // ejecuto la función update para actualizar la información en la base de datos
                $empleado->Id = $id;
                return $this->respondUpdated($empleado); // enviamos respuesta de que se inserto al cliente
           else:
                return $this->failValidationErrors($this->model->validation->listErrors()); // se muestran los errores 
            endif;

        } catch (\Exception $th) {
            return $this->failServerError('Ha ocurrido un un error en el servidor');
        }
    }

    // Eliminar un empleado de la base de datos - DELETE
    public function delete($id = null){
        try {
            if($id == null)
                return $this->failValidationErrors('No se ha pasado un id valido');

            $empleadoVer = $this->model->find($id);
            if($empleadoVer == null)
                return $this->failNotFound('No se encontro en el sistema un cliente con identificación: '.$id);
           
           
            if($this->model->delete($id)): // ejecuto la función delete para eliminar la información en la base de datos
                return $this->respondDeleted($empleadoVer); // enviamos respuesta de que se elimino al cliente
           else:
                return $this->failServerError('No se pudo eliminar registro de la base de datos');
            endif;

        } catch (\Exception $th) {
            return $this->failServerError('Ha ocurrido un un error en el servidor');
        }
    }

    /*
     public function conectar(){
		//$dbconect = $this->request->getPost('db');
		//$conexio = new Conexion();
		//$db = $conexio->conectar($dbconect);
		$dbconect = $this->request->getPost('db');
		$db = \Config\Database::connect();
		$db->setDatabase($dbconect);
		$db->reconnect();

		
		$clientes= $this->model->findAll();
		return $this->respond($clientes);
		/*
		$db = $this->conexio->conectar($dbconect);
		$this->model=$this->setModel(new clientemodel($db));
		$clientes= $this->model->findAll();
		return $this->respond($clientes);
	
     */
}