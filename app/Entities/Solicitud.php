<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Solicitud extends Entity implements \JsonSerializable
{
    protected $datamap = [
        'FechaSolicitud' => 'fecha_solicitud',  // Mapear 'fecha_solicitud' a 'FechaSolicitud'
        'TipoCantidad' => 'tipo_cantidad',      // Mapear 'tipo_cantidad' a 'TipoCantidad'
        'Cantidad' => 'cantidad',               // Mapear 'cantidad' a 'Cantidad'
        'ProveedorID' => 'id_proveedor',        // Mapear 'id_proveedor' a 'ProveedorID'
        'InsumoID' => 'id_insumo',             // Mapear 'id_insumo' a 'InsumoID'
    ]; 
    protected $dates   = []; // Campos de fecha
    protected $casts   = []; // Conversión de tipos (opcional)

    // Reglas de validación
    protected $validationRules = [
        'fecha_solicitud' => 'required|valid_date[Y-m-d]', // Fecha válida en formato YYYY-MM-DD
        'tipo_cantidad'  => 'required|alpha_space|min_length[3]|max_length[20]', // Solo letras y espacios
        'cantidad' => 'required|integer|greater_than[0]', // Debe ser un número entero positivo
        'id_proveedor' => 'required|integer|is_not_unique[proveedores.id]', // Debe existir en la tabla proveedores
        'id_insumo' => 'required|integer|is_not_unique[insumos.id]'
    ];

    // Mensajes de validación personalizados
    protected $validationMessages = [
        'fecha_solicitud' => [
            'required' => 'La fecha de solicitud es obligatoria.',
            'valid_date' => 'El formato de fecha debe ser YYYY-MM-DD.'
        ],
        'tipo_cantidad' => [
            'required' => 'El tipo de cantidad es obligatorio.',
            'alpha_space' => 'El tipo de cantidad solo puede contener letras y espacios.',
            'min_length' => 'El tipo de cantidad debe tener al menos 3 caracteres.',
            'max_length' => 'El tipo de cantidad no puede superar los 20 caracteres.'
        ],
        'cantidad' => [
            'required' => 'La cantidad es obligatoria.',
            'integer' => 'La cantidad debe ser un número entero.',
            'greater_than' => 'La cantidad debe ser mayor que 0.'
        ],
        'id_proveedor' => [
            'required' => 'El proveedor es obligatorio.',
            'integer' => 'El ID del proveedor debe ser un número entero.',
            'is_not_unique' => 'El proveedor seleccionado no existe en la base de datos.'
        ],
        'id_insumo' => [
            'required' => 'El insumo es obligatorio.',
            'integer' => 'El ID del insumo debe ser un número entero.',
            'is_not_unique' => 'El insumo seleccionado no existe en la base de datos.'
        ]
    ];

     // Método para personalizar la conversión a JSON (implementación de JsonSerializable)
     public function jsonSerialize()
     {
         $data = parent::jsonSerialize();  // Obtiene los datos base de la entidad
         
         // Aplica el mapeo
         $mappedData = [];
         foreach ($data as $key => $value) {
             if (array_key_exists($key, $this->datamap)) {
                 $mappedData[$this->datamap[$key]] = $value; // Mapea la clave
             } else {
                 $mappedData[$key] = $value; // Deja la clave como está si no hay mapeo
             }
         }
         
         return $mappedData;  // Devuelve los datos mapeados
     }
}
