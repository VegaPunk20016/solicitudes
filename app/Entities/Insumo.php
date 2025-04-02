<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Insumo extends Entity implements \JsonSerializable
{
    protected $datamap = ['nombre' => 'Nombre']; // Mapeo de campos (opcional)
    protected $dates   = []; // Campos de fecha
    protected $casts   = []; // Conversión de tipos (opcional)    

    public function jsonSerialize()
    {
        $data = parent::jsonSerialize();  // Obtiene los datos base de la entidad
        
        // Eliminar el campo 'id' si existe en los datos
        //*unset($data['id']);  // Elimina el campo 'id' de la salida
        
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
