<?php

namespace App\Modules\Cashflow\Controllers;
/*
PT ITSHOP BISNIS DIGITAL
Website: https://itshop.biz.id
Toko Online: ITSHOP Purwokerto (https://Tokopedia.com/itshoppwt, https://Shopee.co.id/itshoppwt, https://Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
02-2024
*/

use App\Controllers\BaseController;
use App\Modules\Cashflow\Models\CashflowModel;
use CodeIgniter\I18n\Time;

class Cashflow extends BaseController
{
    protected $cashflow;

    public function __construct()
    {
        //memanggil function di model
        $this->cashflow = new CashflowModel();
    }

    public function index()
    {
        // User Agent Class
		$agent = $this->request->getUserAgent();
		if ($agent->isMobile()) {
			$view = 'cashflow_mobile';
		} else {
			$view = 'cashflow';
		}

        $cari = $this->request->getVar('search');
        return view('App\Modules\Cashflow\Views/' . $view, [
            'title' => lang('App.cashflow'),
            'search' => $cari,
            'startDate' => date('Y-m-d', strtotime('-3 month', strtotime(Time::now()))),
            'endDate' => date('Y-m-d', strtotime(Time::now())),
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
