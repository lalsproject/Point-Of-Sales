<?php

namespace App\Modules\Keranjang\Models;

use CodeIgniter\Model;

class KeranjangPendingModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'keranjang_pending';
    protected $primaryKey           = 'id_pending';
    protected $useAutoIncrement     = false;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = false;
    protected $allowedFields        = [];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = '';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = [];
    protected $afterInsert          = [];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    // Get Keranjang Jual Pending
    public function getPending($outlet)
    {
        $this->where('id_toko', $outlet);
        $this->orderBy("{$this->table}.created_at", "DESC");
        $query = $this->findAll();
        return $query;
    }
}
