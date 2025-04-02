<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SolicitudModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class SolicitudController extends ResourceController
{
    protected $model;
    protected $format = 'json';

    public function __construct()
    {
        $this->model = new SolicitudModel();
    }

    public function create()
    {
        try {
            if ($this->request->getMethod() !== 'POST') {
                return $this->fail('Método no permitido', 405);
            }

            $data = $this->request->getJSON(true); // Recibir JSON

            var_dump($data);

            // Depuración: Ver datos recibidos
            if (empty($data)) {
                return $this->fail('No se recibieron datos', 400);
            }

            // Validación manual
            $validation = \Config\Services::validation();
            $validation->setRules($this->model->validationRules, $this->model->validationMessages);



            // Crear entidad y asignar datos
            $solicitud = new \App\Entities\Solicitud();
            $solicitud->fill($data);

            if (!$this->model->insert($solicitud->toRawArray())) {
                return $this->failValidationErrors($this->model->errors());
            }

            return $this->respondCreated([
                'status' => 201,
                'message' => 'Solicitud creada exitosamente',
                'data' => $solicitud
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error en SolicitudController::create: ' . $e->getMessage());
            return $this->failServerError('Ocurrió un error inesperado. Inténtelo más tarde.');
        }
    }



    public function index()
    {
        $limite = 10; // Registros por página
        $pagina = $this->request->getVar('page') ?? 1; // Página actual

        // Obtener datos paginados
        $solicitudes = $this->model->paginate($limite);
        $paginacion = $this->model->pager;

        // Convertir los campos numéricos a enteros y agregar los links
        foreach ($solicitudes as $solicitud) {
            // Añadir los links
            $solicitud->links = [
                [
                    'rel' => 'proveedor',
                    'href' => route_to('proveedores/(.*)', $solicitud->id_proveedor)
                ],
                [
                    'rel' => 'insumo',
                    'href' => route_to('insumos/(.*)', $solicitud->id_insumo)
                ]
            ];
        }

        return $this->respond([
            'data' => $solicitudes, // Los datos de las solicitudes
            'meta' => [
                'total' => $paginacion->getTotal(),
                'per_page' => $limite,
                'current_page' => $pagina,
                'total_pages' => $paginacion->getPageCount()
            ],
            'links' => [
                'first' => $paginacion->getPageURI(1),
                'last' => $paginacion->getPageURI($paginacion->getPageCount()),
                'prev' => ($pagina > 1) ? $paginacion->getPageURI($pagina - 1) : null,
                'next' => ($pagina < $paginacion->getPageCount()) ? $paginacion->getPageURI($pagina + 1) : null
            ]
        ]);
    }
}
