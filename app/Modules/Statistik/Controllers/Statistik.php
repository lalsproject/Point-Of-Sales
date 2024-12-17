<?php

namespace  App\Modules\Statistik\Controllers;
/*
PT ITSHOP BISNIS DIGITAL
Website: https://itshop.biz.id
Toko Online: ITSHOP Purwokerto (https://Tokopedia.com/itshoppwt, https://Shopee.co.id/itshoppwt, https://Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
06-2022
*/

use App\Controllers\BaseController;
use App\Modules\Statistik\Models\StatistikModel;
use App\Modules\Toko\Models\TokoModel;

class Statistik extends BaseController
{
    protected $statistik;
    protected $toko;

    public function __construct()
    {
        //memanggil Model
        $this->statistik = new StatistikModel();
        $this->toko = new TokoModel();
        helper('tglindo');
    }

    public function index()
    {
        // User Agent Class
		$agent = $this->request->getUserAgent();
		if ($agent->isMobile()) {
			$view = 'statistik_mobile';
		} else {
			$view = 'statistik';
		}

        $outlet = $this->request->getVar('outlet')??get_cookie('id_toko');
        $cari = $this->request->getVar('cari')??date('Y-m-d');
        if (!empty($cari)) :
            $data['cari'] = $cari;
        endif;

        $data['title'] = lang('App.statistic');
        $data['toko'] = $this->toko->findAll();
        $data['namaToko'] = $this->toko->find($outlet);
        $data['sumQtyHariini'] = $this->statistik->sumQtyHariini($outlet, $cari);
        $data['sumLabaHariini'] = $this->statistik->sumLabaHariini($outlet, $cari);
        $data['sumLabaHarikemarin'] = $this->statistik->sumLabaHarikemarin($outlet, $cari);
        $data['countTrxHariini'] = $this->statistik->countTrxHariini($outlet, $cari);
        $data['countTrxHarikemarin'] = $this->statistik->countTrxHarikemarin($outlet, $cari);
        $data['totalTrxHariini'] = $this->statistik->totalTrxHariini($outlet, $cari);
        $data['totalTrxHarikemarin'] = $this->statistik->totalTrxHarikemarin($outlet, $cari);
        $data['sisaHutang'] = $this->statistik->sisaHutang($outlet);
        $data['sisaPiutang'] = $this->statistik->sisaPiutang($outlet);
        $data['sisaPiutangHariini'] = $this->statistik->sisaPiutangHariini($outlet, $cari);
        $data['sisaPiutangHarikemarin'] = $this->statistik->sisaPiutangHarikemarin($outlet, $cari);
        $data['hutangAkanTempo'] = $this->statistik->hutangAkanTempo($outlet);
        $data['hutangTempoHariini'] = $this->statistik->hutangTempoHariini($outlet);
        $data['hutangLewatTempo'] = $this->statistik->hutangLewatTempo($outlet);
        $data['piutangAkanTempo'] = $this->statistik->piutangAkanTempo($outlet);
        $data['piutangTempoHariini'] = $this->statistik->piutangTempoHariini($outlet);
        $data['piutangLewatTempo'] = $this->statistik->piutangLewatTempo($outlet);
        $data['kasKeluarHariini'] = $this->statistik->kasKeluarHariini($outlet, $cari);
        $data['kasKeluarHarikemarin'] = $this->statistik->kasKeluarHarikemarin($outlet, $cari);
        $data['bankKeluarHariini'] = $this->statistik->bankKeluarHariini($outlet, $cari);
        $data['bankKeluarHarikemarin'] = $this->statistik->bankKeluarHarikemarin($outlet, $cari);
        $data['barangTerlaris'] = $this->statistik->barangTerlaris($outlet);
        $data['jmlBarang'] = $this->statistik->getcountBarang();
        $data['jmlKontak'] = $this->statistik->getCountKontak();
        $data['jmlUser'] = $this->statistik->getCountUser();
        $data['getToko'] = $outlet;

        $bln = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $data['transaksi'] = [];
        foreach ($bln as $b) {
            $date = date('Y', strtotime($cari)) . '-' . $b;
            $data['transaksi'][] = $this->statistik->chartTransaksi($outlet, $date);
        }

        $jam = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '00'];
        $data['jam'] = [];
        foreach ($jam as $j) {
            $date = $cari . ' ' . $j;
            $data['harian'][] = $this->statistik->chartHarian($outlet, $date);
        }

        $tgl = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'];
        $data['tgl'] = [];
        foreach ($tgl as $t) {
            $date = date('Y-m', strtotime($cari)) . '-' . $t;
            $data['pemasukan'][] = ($this->statistik->chartPemasukan($outlet, $date) - $this->statistik->chartSisaPiutang($outlet, $date));
        }

        return view('App\Modules\Statistik\Views/' . $view, $data);
    }
}
