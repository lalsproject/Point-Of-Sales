<?php

namespace  App\Modules\Dashboard\Controllers;
/*
PT ITSHOP BISNIS DIGITAL
Website: https://itshop.biz.id
Toko Online: ITSHOP Purwokerto (https://Tokopedia.com/itshoppwt, https://Shopee.co.id/itshoppwt, https://Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
06-2022
*/

use App\Controllers\BaseController;
use App\Modules\Dashboard\Models\DashboardModel;
use App\Modules\Toko\Models\TokoModel;

class Dashboard extends BaseController
{
    protected $dashboard;
    protected $toko;

    public function __construct()
    {
        //memanggil Model
        $this->dashboard = new DashboardModel();
        $this->toko = new TokoModel();
    }

    public function index()
    {
        $outlet = $this->request->getVar('outlet')??get_cookie('id_toko');
        $data['title'] = 'Dashboard';
        $data['toko'] = $this->toko->findAll();
        $data['namaToko'] = $this->toko->find($outlet);
        $data['getToko'] = $outlet;
        $data['sumQtyHariini'] = $this->dashboard->sumQtyHariini($outlet);
        $data['countTrxHariini'] = $this->dashboard->countTrxHariini($outlet);
        $data['countTrxHarikemarin'] = $this->dashboard->countTrxHarikemarin($outlet);
        $data['totalTrxHariini'] = $this->dashboard->totalTrxHariini($outlet);
        $data['totalTrxHarikemarin'] = $this->dashboard->totalTrxHarikemarin($outlet);
        $data['sumLabaHariini'] = $this->dashboard->sumLabaHariini($outlet);
        $data['sumLabaHarikemarin'] = $this->dashboard->sumLabaHarikemarin($outlet);
        $data['jmlBarang'] = $this->dashboard->getcountBarang($outlet);
        $data['jmlKontak'] = $this->dashboard->getCountKontak();
        $data['jmlUser'] = $this->dashboard->getCountUser();
        $data['kasMasuk'] = $this->dashboard->kasMasukHariini($outlet);
        $data['kasKeluar'] = $this->dashboard->kasKeluarHariini($outlet);
        $data['bankMasuk'] = $this->dashboard->bankMasukHariini($outlet);
        $data['bankKeluar'] = $this->dashboard->bankKeluarHariini($outlet);
        $data['sisaHutang'] = $this->dashboard->sisaHutang($outlet);
        $data['sisaPiutang'] = $this->dashboard->sisaPiutang($outlet);
        $data['sisaPiutangHariini'] = $this->dashboard->sisaPiutangHariini($outlet);
        $data['sisaPiutangHarikemarin'] = $this->dashboard->sisaPiutangHarikemarin($outlet);
        $data['hutangAkanTempo'] = $this->dashboard->hutangAkanTempo($outlet);
        $data['hutangTempoHariini'] = $this->dashboard->hutangTempoHariini($outlet);
        $data['hutangLewatTempo'] = $this->dashboard->hutangLewatTempo($outlet);
        $data['piutangAkanTempo'] = $this->dashboard->piutangAkanTempo($outlet);
        $data['piutangTempoHariini'] = $this->dashboard->piutangTempoHariini($outlet);
        $data['piutangLewatTempo'] = $this->dashboard->piutangLewatTempo($outlet);
        $data['getBackups'] = $this->dashboard->getBackups();

        /* var_dump($this->dashboard->getLastQuery()->getQuery());
        die; */

        $data['outlet'] = $this->dashboard->getToko();
        $totalOutlet = count($data['outlet']);
        $data['totalOutlet'] = $totalOutlet;

        $bln = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $data['transaksi'] = [];
        foreach ($bln as $b) {
            $date = date('Y-') . $b;
            $data['transaksi'][] = $this->dashboard->chartTransaksi($outlet, $date);
        }

        $jam = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '00'];
        $data['jam'] = [];
        foreach ($jam as $j) {
            $date = date('Y-m-d') . ' ' . $j;
            $data['harian'][] = $this->dashboard->chartHarian($outlet, $date);
        }

        $tgl = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'];
        $data['tgl'] = [];
        foreach ($tgl as $t) {
            $date = date('Y-m-') . $t;
            $data['pemasukan'][] = $this->dashboard->chartPemasukan($outlet, $date);
        }

        // User Agent Class
        $agent = $this->request->getUserAgent();
        if ($agent->isMobile()) {
            return view('App\Modules\Dashboard\Views/index_mobile', $data);
        } else {
            return view('App\Modules\Dashboard\Views/index', $data);
        }
    }

    public function blocked()
    {
        return view('App\Modules\Dashboard\Views/blocked', [
            'title' => 'Access Denied'
        ]);
    }
}
