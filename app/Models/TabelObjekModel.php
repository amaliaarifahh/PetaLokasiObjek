<?php

namespace App\Models;

use CodeIgniter\Model;

class TabelObjekModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tbl_objek';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true; //supaya di database tidak hilang
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama',
        'deskripsi',
        'longitude',
        'latitude',
        'foto',
    ];

    // Dates, menambahkan format datetime 
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
