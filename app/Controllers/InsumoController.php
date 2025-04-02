<?php

namespace App\Controllers;

use App\Models\InsumoModel;
use CodeIgniter\RESTful\ResourceController;

class InsumoController extends ResourceController
{
    protected $model;
    protected $format = 'json';

    public function __construct()
    {
        $this->model = new InsumoModel();
    }


    public function index()
    {
        try {

            $insumo = $this->model->findAll();
            return $this->respond(['data' => $insumo]);
        } catch (\Exception $e) {
            log_message('error', 'Error en InsumoController::index' . $e->getMessage());

            return $this->failServerError('ocurrio un error, intentalo mas tarde');
        }
    }

    public function show($id = null)
    {
        try {

            $insumo = $this->model->find($id);
            if (!$insumo) {
                return $this->fail('Insumo no encontrado', 404);
            }
            return $this->respond(['data' => $insumo]);
        } catch (\Exception $e) {
            log_message('error', 'Error en InsumoController::show' . $e->getMessage());

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
            $insumo = $this->model->where('nombre', $nombre)->first();

            // Si no se encuentra el empleado, devolver un error 404
            if (!$insumo) {
                return $this->fail('insumo no encontrado', 404);
            }

            // Responder con los datos del empleado
            return $this->respond([
                'status' => 200,
                'message' => 'Insumo encontrado',
                'data' => $insumo
            ]);

        } catch (\Exception $e) {
            // Registrar el error en los logs
            log_message('error', 'Error en InsumoController::showNombre: ' . $e->getMessage());

            // Devolver un error 500
            return $this->failServerError('Ocurrió un error, inténtalo más tarde');
        }
    }

}

