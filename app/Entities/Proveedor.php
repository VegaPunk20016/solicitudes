<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Proveedor extends Entity implements \JsonSerializable
{
    protected $datamap = [
        'NombreProveedor' => 'nombre', // Mapear 'nombre' a 'NombreProveedor'
        'RFC' => 'rfc',              // Mapear 'rfc' a 'RFC'
        'Telefono' => 'telefono',
    ];

    protected $dates   = []; // Campos de fecha
    protected $casts   = []; // Conversión de tipos (opcional)

    protected $validationRules = [
        'nombre'   => 'required|min_length[3]|max_length[255]|alpha_space', // Solo letras y espacios
        'rfc'      => 'required|exact_length[13]|alpha_numeric', // RFC debe tener 13 caracteres alfanuméricos
        'telefono' => 'required|integer|min_length[10]|max_length[15]', // Número entero con longitud entre 10 y 15
    ];
    
    // Mensajes de validación personalizados
    protected $validationMessages = [
        'nombre' => [
            'required' => 'El nombre es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre no puede exceder los 255 caracteres.',
            'alpha_space' => 'El nombre solo puede contener letras y espacios.'
        ],
        'rfc' => [
            'required' => 'El RFC es obligatorio.',
            'exact_length' => 'El RFC debe tener exactamente 13 caracteres.',
            'alpha_numeric' => 'El RFC solo puede contener letras y números.'
        ],
        'telefono' => [
            'required' => 'El teléfono es obligatorio.',
            'integer' => 'El teléfono debe ser un número entero.',
            'min_length' => 'El teléfono debe tener al menos 10 dígitos.',
            'max_length' => 'El teléfono no puede tener más de 15 dígitos.'
        ]
    ];
    
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
