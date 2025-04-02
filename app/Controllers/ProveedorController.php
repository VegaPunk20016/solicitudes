<?php

namespace App\Controllers;

use App\Models\ProveedorModel;
use CodeIgniter\RESTful\ResourceController;

class ProveedorController extends ResourceController
{
    protected $model;
    protected $format = 'json';

    public function __construct()
    {
        $this->model = new ProveedorModel();
    }


    public function index()
    {
        try {

            $proovedor = $this->model->findAll();
            return $this->respond(['data' => $proovedor]);
        } catch (\Exception $e) {
            log_message('error', 'Error en ProveedorController::index' . $e->getMessage());

            return $this->failServerError('ocurrio un error, intentalo mas tarde');
        }
    }

    public function show($id = null)
    {
        try {

            $proveedor = $this->model->find($id);
            if (!$proveedor) {
                return $this->fail('Insumo no encontrado', 404);
            }
            return $this->respond(['data' => $proveedor]);
        } catch (\Exception $e) {
            log_message('error', 'Error en ProveedorController::show' . $e->getMessage());

            return $this->failServerError('ocurrio un error, intentalo mas tarde');
        }
    }

    public function showNombre($nombre = null)
    {
        try {
            // Validar que el nombre no esté vacío
            if (empty($nombre)) {
                return $this->fail('El nombre es requerido', 400);
            }

            // Buscar el insumo por nombre
            $proveedor = $this->model->where('nombre', $nombre)->first();

            // Si no se encuentra el empleado, devolver un error 404
            if (!$proveedor) {
                return $this->fail('insumo no encontrado', 404);
            }

            // Responder con los datos del empleado
            return $this->respond([
                'status' => 200,
                'message' => 'Proveedor encontrado',
                'data' => $proveedor
            ]);

        } catch (\Exception $e) {
            // Registrar el error en los logs
            log_message('error', 'Error en ProveedorController::showNombre: ' . $e->getMessage());

            // Devolver un error 500
            return $this->failServerError('Ocurrió un error, inténtalo más tarde');
        }
    }
}
