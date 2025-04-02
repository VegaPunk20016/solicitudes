<?php

namespace App\Models;

use CodeIgniter\Model;

class InsumoModel extends Model
{
    protected $table            = 'Insumos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = '\App\Entities\Insumo';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nombre'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

}
