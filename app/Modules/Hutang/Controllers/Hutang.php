<?php

namespace App\Modules\Hutang\Controllers;
/*
PT ITSHOP BISNIS DIGITAL
Website: https://itshop.biz.id
Toko Online: ITSHOP Purwokerto (https://Tokopedia.com/itshoppwt, https://Shopee.co.id/itshoppwt, https://Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
12-2022
*/

use App\Controllers\BaseController;
use App\Modules\Hutang\Models\HutangModel;
use CodeIgniter\I18n\Time;

class Hutang extends BaseController
{
    protected $hutang;

    public function __construct()
    {
        //memanggil function di model
        $this->hutang = new HutangModel();
    }

    public function index()
    {
        // User Agent Class
        $agent = $this->request->getUserAgent();
        if ($agent->isMobile()) {
            $view = 'hutang_mobile';
        } else {
            $view = 'hutang';
        }

        $cari = $this->request->getVar('faktur');
        return view('App\Modules\Hutang\Views/' . $view, [
            'title' => lang('App.debts'),
            'search' => $cari,
            'startDate' => date('Y-', strtotime(Time::now())) . '01-01',
            'endDate' => date('Y-', strtotime(Time::now())) . '12-31',
            'hariini' => date('Y-m-d', strtotime(Time::now())),
            'kemarin' => date('Y-m-d', strtotime('-1 day', strtotime(Time::now()))),
            'tujuhHari' => date('Y-m-d', strtotime('-1 week', strtotime(Time::now()))),
            'awalBulan' => date('Y-m-', strtotime(Time::now())) . '01',
            'akhirBulan' => date('Y-m-t', strtotime(Time::now())),
            'awalTahun' => date('Y-', strtotime(Time::now())) . '01-01',
            'akhirTahun' => date('Y-', strtotime(Time::now())) . '12-31',
            'awalTahunLalu' => date('Y-', strtotime('-1 year', strtotime(Time::now()))) . '01-01',
            'akhirTahunLalu' => date('Y-', strtotime('-1 year', strtotime(Time::now()))) . '12-31',
            'satuBulanAwal' => date('Y-m-d', strtotime('-1 month', strtotime(Time::now()))),
            'satuBulanAkhir' => date('Y-m-d', strtotime('-1 day', strtotime(Time::now()))),
            'tigaBulanAwal' => date('Y-m-d', strtotime('-3 month', strtotime(Time::now()))),
            'tigaBulanAkhir' => date('Y-m-d', strtotime(Time::now())),
        ]);
    }
}
