<?php

namespace App\Modules\Dashboard\Models;

/*
PT ITSHOP BISNIS DIGITAL
Website: https://itshop.biz.id
Toko Online: ITSHOP Purwokerto (https://Tokopedia.com/itshoppwt, https://Shopee.co.id/itshoppwt, https://Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
04-2022
*/

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $table                = 'penjualan';

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    // hitung total data pada transaction
    public function getCountTrx()
    {
        return $this->db->table("penjualan")->countAll();
    }

    // hitung total data pada barang
    public function getcountBarang($outlet)
    {

        $query = $this->db->table('barang')
            ->where('id_toko', $outlet);
        return $query->countAllResults();
    }

    // hitung total data pada kontak
    public function getCountKontak()
    {
        return $this->db->table("kontak")->countAll();
    }

    // hitung total data pada user
    public function getCountUser()
    {
        return $this->db->table("login")->countAll();
    }

    // hitung total data pada toko
    public function getToko()
    {
        return $this->db->table("toko")->get()->getResultArray();
    }

    public function getBackups()
    {
        $query = $this->db->table('backups')
            ->where('DATE(created_at) =', date('Y-m-d'));
        return $query->get()->getResultArray();
    }

    public function chartTransaksi($outlet, $date)
    {
        $this->like('created_at', $date, 'after');
        $this->where('id_toko', $outlet);
        return count($this->get()->getResultArray());
    }

    public function chartHarian($outlet, $date)
    {
        $this->like('created_at', $date, 'after');
        $this->where('id_toko', $outlet);
        return count($this->get()->getResultArray());
    }

    public function chartPemasukan($outlet, $date)
    {
        $this->select('(sum(subtotal)+sum(pembulatan)-sum(diskon)) as total');
        $this->where('id_toko', $outlet);
        $this->like('created_at', $date, 'after');
        return $this->get()->getRow()->total;
    }

    public function sumQtyHariini($outlet)
    {
        $query = $this->db->table('penjualan_item')
            ->select('sum(qty) as total')
            ->join("penjualan", "penjualan.id_penjualan = penjualan_item.id_penjualan")
            ->where('penjualan.id_toko', $outlet)
            ->where('DATE(penjualan.created_at) =', date('Y-m-d'));
        return $query->get()->getRow()->total;
    }

    public function sumLabaHariini($outlet)
    {
        $this->select('sum(total_laba) as total');
        $this->where('id_toko', $outlet);
        $this->where('DATE(created_at) =', date('Y-m-d'));
        return $this->get()->getRow()->total;
    }

    public function sumLabaHarikemarin($outlet)
    {
        $this->select('sum(total_laba) as total');
        $this->where('id_toko', $outlet);
        $this->where('DATE(created_at) =', date('Y-m-d', strtotime('-1 days')));
        return $this->get()->getRow()->total;
    }

    public function countTrxHariini($outlet)
    {
        $this->where('id_toko', $outlet);
        $this->where('DATE(created_at) =', date('Y-m-d'));
        return count($this->get()->getResultArray());
    }

    public function countTrxHarikemarin($outlet)
    {
        $this->where('id_toko', $outlet);
        $this->where('DATE(created_at) =', date('Y-m-d', strtotime('-1 days')));
        return count($this->get()->getResultArray());
    }

    public function totalTrxHariini($outlet)
    {
        $this->select('(sum(subtotal)+sum(pembulatan)-sum(diskon)) as total');
        $this->where('id_toko', $outlet);
        $this->where('DATE(created_at) =', date('Y-m-d'));
        return $this->get()->getRow()->total;
    }

    public function totalTrxHarikemarin($outlet)
    {
        $this->select('(sum(subtotal)+sum(pembulatan)-sum(diskon)) as total');
        $this->where('id_toko', $outlet);
        $this->where('DATE(created_at) =', date('Y-m-d', strtotime('-1 days')));
        return $this->get()->getRow()->total;
    }

    public function kasMasukHariini($outlet)
    {
        $query = $this->db->table('cashflow')
            ->select('sum(pemasukan) as total')
            ->like('jenis', 'Pemasukan')
            ->where('id_toko', $outlet)
            ->where('DATE(created_at) =', date('Y-m-d'));
        return $query->get()->getRow()->total;
    }

    public function kasKeluarHariini($outlet)
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

    public function bankMasukHariini($outlet)
    {
        $query = $this->db->table('bank')
            ->select('sum(pemasukan) as total')
            ->like('jenis', 'Pemasukan')
            ->where('id_toko', $outlet)
            ->where('DATE(created_at) =', date('Y-m-d'));
        return $query->get()->getRow()->total;
    }

    public function bankKeluarHariini($outlet)
    {
        $query = $this->db->table('bank')
            ->select('sum(pengeluaran) as total')
            ->groupStart()
            ->like('jenis', 'Pengeluaran')
            ->orLike('jenis', 'Mutasi ke Kas', 'before')
            ->groupEnd()
            ->where('id_toko', $outlet)
            ->where('DATE(created_at) =', date('Y-m-d'));
        return $query->get()->getRow()->total;
    }

    public function jumlahHutang($outlet)
    {
        $query = $this->db->table('hutang')
            ->select('sum(jumlah_hutang) as total')
            ->where('id_toko', $outlet);
        return $query->get()->getRow()->total;
    }

    public function sisaHutang($outlet)
    {
        $query = $this->db->table('hutang')
            ->select('sum(sisa_hutang) as total')
            ->where('id_toko', $outlet);
        return $query->get()->getRow()->total;
    }

    public function jumlahPiutang($outlet)
    {
        $query = $this->db->table('piutang')
            ->select('sum(jumlah_piutang) as total')
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

    public function sisaPiutangHariini($outlet)
    {
        $query = $this->db->table('piutang')
            ->select('sum(sisa_piutang) as total')
            ->where('DATE(tanggal) =', date('Y-m-d'))
            ->where('id_toko', $outlet);
        return $query->get()->getRow()->total;
    }

    public function sisaPiutangHarikemarin($outlet)
    {
        $query = $this->db->table('piutang')
            ->select('sum(sisa_piutang) as total')
            ->where('DATE(tanggal) =', date('Y-m-d', strtotime('-1 days')))
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
}
