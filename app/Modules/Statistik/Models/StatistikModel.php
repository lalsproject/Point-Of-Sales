<?php

namespace App\Modules\Statistik\Models;

/*
PT ITSHOP BISNIS DIGITAL
Website: https://itshop.biz.id
Toko Online: ITSHOP Purwokerto (https://Tokopedia.com/itshoppwt, https://Shopee.co.id/itshoppwt, https://Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
04-2022
*/

use CodeIgniter\Model;

class StatistikModel extends Model
{
    protected $table                = 'penjualan';

    // hitung total data pada transaction
    public function getCountTrx()
    {
        return $this->db->table("penjualan")->countAll();
    }

    // hitung total data pada barang
    public function getcountBarang()
    {
        return $this->db->table("barang")->countAll();
    }

    // hitung total data pada Kontak
    public function getCountKontak()
    {
        return $this->db->table("kontak")->countAll();
    }

    // hitung total data pada user
    public function getCountUser()
    {
        return $this->db->table("login")->countAll();
    }

    public function chartTransaksi($outlet,$date)
    {
        $this->where('id_toko', $outlet);
        $this->like('created_at', $date, 'after');
        return count($this->get()->getResultArray());
    }

    public function chartHarian($outlet, $date)
    {
        $this->where('id_toko', $outlet);
        $this->like('created_at', $date, 'after');
        return count($this->get()->getResultArray());
    }

    public function chartPemasukan($outlet, $date)
    {
        $this->select('(sum(subtotal)+sum(pembulatan)-sum(diskon)) as total');
        $this->where('id_toko', $outlet);
        $this->like('created_at', $date, 'after');
        return $this->get()->getRow()->total;
    }

    public function chartSisaPiutang($outlet, $date)
    {
        $query = $this->db->table('piutang')
            ->select('sum(sisa_piutang) as total')
            ->like('DATE(tanggal)', $date, 'after')
            ->where('id_toko', $outlet);
        return $query->get()->getRow()->total;
    }

    public function countTrxHariini($outlet, $tgl)
    {
        $this->where('DATE(created_at) =', $tgl);
        $this->where('id_toko', $outlet);
        return count($this->get()->getResultArray());
    }

    public function countTrxHarikemarin($outlet, $tgl)
    {
        $this->where('DATE(created_at) =', date('Y-m-d', strtotime($tgl . '-1 days')));
        $this->where('id_toko', $outlet);
        return count($this->get()->getResultArray());
    }

    public function totalTrxHariini($outlet, $tgl)
    {
        $this->select('(sum(subtotal)+sum(pembulatan)-sum(diskon)) as total');
        $this->where('DATE(created_at) =', $tgl);
        $this->where('id_toko', $outlet);
        return $this->get()->getRow()->total;
    }

    public function totalTrxHarikemarin($outlet, $tgl)
    {
        $this->select('(sum(subtotal)+sum(pembulatan)-sum(diskon)) as total');
        $this->where('DATE(created_at) =', date('Y-m-d', strtotime($tgl . '-1 days')));
        $this->where('id_toko', $outlet);
        return $this->get()->getRow()->total;
    }

    public function sisaHutang($outlet)
    {
        $query = $this->db->table('hutang')
            ->select('sum(sisa_hutang) as total')
            ->where('id_toko', $outlet);
        return $query->get()->getRow()->total;
    }

    public function sisaPiutang($outlet)
    {
        $query = $this->db->table('piutang')
            ->select('sum(sisa_piutang) as total')
            ->where('id_toko', $outlet);
        return $query->get()->getRow()->total;
    }

    public function sisaPiutangHariini($outlet, $tgl)
    {
        $query = $this->db->table('piutang')
            ->select('sum(sisa_piutang) as total')
            ->where('DATE(tanggal) =', $tgl)
            ->where('id_toko', $outlet);
        return $query->get()->getRow()->total;
    }

    public function sisaPiutangHarikemarin($outlet, $tgl)
    {
        $query = $this->db->table('piutang')
            ->select('sum(sisa_piutang) as total')
            ->where('DATE(tanggal) =', date('Y-m-d', strtotime($tgl . '-1 days')))
            ->where('id_toko', $outlet);
        return $query->get()->getRow()->total;
    }

    public function hutangAkanTempo($outlet)
    {
        $query = $this->db->table('hutang')
            ->where('DATE(jatuh_tempo) >', date('Y-m-d'))
            ->where('status_hutang', 0)
            ->where('id_toko', $outlet);
        return $query->countAllResults();
    }

    public function hutangTempoHariini($outlet)
    {
        $query = $this->db->table('hutang')
            ->where('DATE(jatuh_tempo) =', date('Y-m-d'))
            ->where('status_hutang', 0)
            ->where('id_toko', $outlet);
        return $query->countAllResults();
    }

    public function hutangLewatTempo($outlet)
    {
        $query = $this->db->table('hutang')
            ->where('DATE(jatuh_tempo) <', date('Y-m-d'))
            ->where('status_hutang', 0)
            ->where('id_toko', $outlet);
        return $query->countAllResults();
    }

    public function piutangAkanTempo($outlet)
    {
        $query = $this->db->table('piutang')
            ->where('DATE(jatuh_tempo) >', date('Y-m-d'))
            ->where('status_piutang', '0')
            ->where('id_toko', $outlet);
        return $query->countAllResults();
    }

    public function piutangTempoHariini($outlet)
    {
        $query = $this->db->table('piutang')
            ->where('DATE(jatuh_tempo) =', date('Y-m-d'))
            ->where('status_piutang', '0')
            ->where('id_toko', $outlet);
        return $query->countAllResults();
    }

    public function piutangLewatTempo($outlet)
    {
        $query = $this->db->table('piutang')
            ->where('DATE(jatuh_tempo) <', date('Y-m-d'))
            ->where('status_piutang', '0')
            ->where('id_toko', $outlet);
        return $query->countAllResults();
    }

    public function sumQtyHariini($outlet, $tgl)
    {
        $query = $this->db->table('penjualan_item')
            ->select('sum(qty) as total')
            ->join("penjualan", "penjualan.id_penjualan = penjualan_item.id_penjualan")
            ->where('penjualan.id_toko', $outlet)
            ->where('DATE(penjualan.created_at) =', $tgl);
        return $query->get()->getRow()->total;
    }

    public function sumLabaHariini($outlet, $tgl)
    {
        $this->select('sum(total_laba) as total');
        $this->where('id_toko', $outlet);
        $this->where('DATE(created_at) =', $tgl);
        return $this->get()->getRow()->total;
    }

    public function sumLabaHarikemarin($outlet, $tgl)
    {
        $this->select('sum(total_laba) as total');
        $this->where('id_toko', $outlet);
        $this->where('DATE(created_at) =', date('Y-m-d', strtotime($tgl . '-1 days')));
        return $this->get()->getRow()->total;
    }

    public function kasKeluarHariini($outlet, $tgl)
    {
        $query = $this->db->table('cashflow')
            ->select('sum(pengeluaran) as total')
            ->groupStart()
            ->like('jenis', 'Pengeluaran')
            ->orLike('jenis', 'Mutasi ke Bank', 'before')
            ->groupEnd()
            ->where('id_toko', $outlet)
            ->where('DATE(created_at) =', date('Y-m-d'));
        return $query->get()->getRow()->total;
    }

    public function kasKeluarHarikemarin($outlet, $tgl)
    {
        $query = $this->db->table('cashflow')
            ->select('sum(pengeluaran) as total')
            ->groupStart()
            ->like('jenis', 'Pengeluaran')
            ->orLike('jenis', 'Mutasi ke Bank', 'before')
            ->groupEnd()
            ->where('id_toko', $outlet)
            ->where('DATE(tanggal) =', date('Y-m-d', strtotime($tgl . '-1 days')));
        return $query->get()->getRow()->total;
    }

    public function bankKeluarHariini($outlet, $tgl)
    {
        $query = $this->db->table('bank')
            ->select('sum(pengeluaran) as total')
            ->groupStart()
            ->like('jenis', 'Pengeluaran')
            ->orLike('jenis', 'Mutasi ke Kas', 'before')
            ->groupEnd()
            ->where('id_toko', $outlet)
            ->where('DATE(created_at) =', $tgl);
        return $query->get()->getRow()->total;
    }

    public function bankKeluarHarikemarin($outlet, $tgl)
    {
        $query = $this->db->table('bank')
            ->select('sum(pengeluaran) as total')
            ->groupStart()
            ->like('jenis', 'Pengeluaran')
            ->orLike('jenis', 'Mutasi ke Kas', 'before')
            ->groupEnd()
            ->where('id_toko', $outlet)
            ->where('DATE(tanggal) =', date('Y-m-d', strtotime($tgl . '-1 days')));
        return $query->get()->getRow()->total;
    }

    public function barangTerlaris($outlet)
    {
        $db      = \Config\Database::connect();
        $db->simpleQuery("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
        $builder = $db->table('penjualan_item n');
        $builder->select("b.nama_barang, b.satuan_barang, b.satuan_nilai, sum(n.qty) qty");
        $builder->join("barang b", "b.id_barang = n.id_barang");
        $builder->where('id_toko', $outlet);
        $builder->groupBy("n.id_barang");
        $builder->orderBy("n.qty", "DESC");
        $builder->limit("5");
        $query = $builder->get()->getResultArray();
        return $query;
        
    }

}
