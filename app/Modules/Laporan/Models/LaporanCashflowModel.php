<?php

namespace App\Modules\Laporan\Models;

use CodeIgniter\Model;

class LaporanCashflowModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'cashflow';
    protected $primaryKey           = 'id_cashflow';
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

    public function getLaporanByCashflow($outlet, $start, $end)
    {
        $this->select("{$this->table}.*, l.nama, t.nama_toko");
        $this->join("login l", "l.id_login = {$this->table}.id_login");
        $this->join("toko t", "t.id_toko = {$this->table}.id_toko");
        if ($outlet != '') :
            $array1 = explode(",", $outlet);
            $this->whereIn("{$this->table}.id_toko", $array1);
        endif;
        $this->where("DATE({$this->table}.created_at) BETWEEN '$start' AND '$end'", null, false);
        $this->orderBy("{$this->table}.created_at", "ASC");
        $query = $this->findAll();
        return $query;
    }

    public function sumPenjualan($outlet, $start, $end)
    {
        $this->select('sum(pemasukan) as total');
        $this->groupStart();
        $this->like('jenis', 'Pemasukan');
        $this->like('kategori', 'Penjualan');
        $this->groupEnd();
        if ($outlet != '') :
            $array1 = explode(",", $outlet);
            $this->whereIn("{$this->table}.id_toko", $array1);
        endif;
        $this->where("DATE(created_at) BETWEEN '$start' AND '$end'", null, false);
        return $this->get()->getRow()->total;
    }

    public function sumPemasukanLain($outlet, $start, $end)
    {
        $this->select('sum(pemasukan) as total');
        $this->groupStart();
        $this->like('jenis', 'Pemasukan');
        $this->notLike('kategori', 'Penjualan');
        $this->groupEnd();
        if ($outlet != '') :
            $array1 = explode(",", $outlet);
            $this->whereIn("{$this->table}.id_toko", $array1);
        endif;
        $this->where("DATE(created_at) BETWEEN '$start' AND '$end'", null, false);
        return $this->get()->getRow()->total;
    }

    public function sumHPP($outlet, $start, $end)
    {
        $this->select('sum(p.hpp) as total');
        $this->join("penjualan p", "p.faktur = {$this->table}.faktur");
        $this->groupStart();
        $this->like('jenis', 'Pemasukan');
        $this->like('kategori', 'Penjualan');
        $this->groupEnd();
        if ($outlet != '') :
            $array1 = explode(",", $outlet);
            $this->whereIn("{$this->table}.id_toko", $array1);
        endif;
        $this->where("DATE({$this->table}.created_at) BETWEEN '$start' AND '$end'", null, false);
        return $this->get()->getRow()->total;
    }

    public function sumPengeluaran($outlet, $start, $end)
    {
        $this->select('sum(pengeluaran) as total');
        $this->like('jenis', 'Pengeluaran');
        if ($outlet != '') :
            $array1 = explode(",", $outlet);
            $this->whereIn("{$this->table}.id_toko", $array1);
        endif;
        $this->where("DATE(created_at) BETWEEN '$start' AND '$end'", null, false);
        return $this->get()->getRow()->total;
    }

    public function sumMutasiBank($outlet, $start, $end)
    {
        $this->select('sum(pengeluaran) as total');
        $this->like('jenis', 'Mutasi ke Bank');
        if ($outlet != '') :
            $array1 = explode(",", $outlet);
            $this->whereIn("{$this->table}.id_toko", $array1);
        endif;
        $this->where("DATE(created_at) BETWEEN '$start' AND '$end'", null, false);
        return $this->get()->getRow()->total;
    }
}
