<?php

namespace  App\Modules\Laporan\Controllers;
/*
PT ITSHOP BISNIS DIGITAL
Website: https://itshop.biz.id
Toko Online: ITSHOP Purwokerto (https://Tokopedia.com/itshoppwt, https://Shopee.co.id/itshoppwt, https://Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
06-2022
*/

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Libraries\Settings;
use App\Modules\Laporan\Models\LaporanBankModel;
use App\Modules\Laporan\Models\LaporanBarangModel;
use App\Modules\Laporan\Models\LaporanPenjualanModel;
use App\Modules\Laporan\Models\LaporanKategoriModel;
use App\Modules\Laporan\Models\LaporanCashflowModel;
use App\Modules\Laporan\Models\LaporanStokopnameModel;
use App\Modules\Toko\Models\TokoModel;
use TCPDF;
use Spipu\Html2Pdf\Html2Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CodeIgniter\I18n\Time;

class Laporan extends BaseController
{
    protected $permission;
	protected $setting;
    protected $barang;
    protected $penjualan;
    protected $kategori;
    protected $cash;
    protected $stokopname;
    protected $toko;
    protected $bank;

	public function __construct()
	{
		//memanggil Model
        $this->permission = new Permission();
		$this->setting = new Settings();
        $this->barang = new LaporanBarangModel();
        $this->penjualan = new LaporanPenjualanModel();
        $this->kategori = new LaporanKategoriModel();
        $this->cash = new LaporanCashflowModel();
        $this->stokopname = new LaporanStokopnameModel();
        $this->toko = new TokoModel();
        $this->bank = new LaporanBankModel();
        helper('tglindo');
	}

	public function index()
	{
        // User Agent Class
		$agent = $this->request->getUserAgent();
		if ($agent->isMobile()) {
			$view = 'laporan_mobile';
		} else {
			$view = 'laporan';
		}

		return view('App\Modules\Laporan\Views/' . $view, [
			'title' => lang('App.report'),
            'permissions' => $this->permission->init(),
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

    public function cashflowPdf()
    {
        $input = $this->request->getVar();
        $outlet = $input['outlet'] ?? "";
        $start = $input['tgl_start'];
        $end = $input['tgl_end'];
        if ($outlet != '') {
            $expOutlet = explode(",", $outlet);
            $countOutlet = count($expOutlet);
            if ($countOutlet == 1) {
                $idOutlet = $expOutlet;
            } else {
                $idOutlet = 0;
            }
        } else {
            $expOutlet = explode(",", $outlet);
            $countOutlet = count($expOutlet);
            $idOutlet = 0;
        }

        $data = [
            'toko' => $this->toko->where('id_toko', $idOutlet)->first(),
            'logo' => $this->setting->info['img_logo_resize'],
            'tgl_start' => $start,
            'tgl_end' => $end,
            'data' => $this->cash->getLaporanByCashflow($outlet, $start, $end)
        ];

        $html = view('App\Modules\Laporan\Views/cash_pdf', $data);

        // create new PDF document
        $pdf = new Html2Pdf('L', 'A4');

        // Print text using writeHTMLCell()
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        //$file = FCPATH.'files/penjualan.pdf';
        //$pdf->Output($file, 'F');
        //$attachment = base_url('files/penjualan.pdf');
        $pdf->Output('cash.pdf','I');  // display on the browser
    }

    public function bankPdf()
    {
        $input = $this->request->getVar();
        $outlet = $input['outlet'] ?? "";
        $start = $input['tgl_start'];
        $end = $input['tgl_end'];
        if ($outlet != '') {
            $expOutlet = explode(",", $outlet);
            $countOutlet = count($expOutlet);
            if ($countOutlet == 1) {
                $idOutlet = $expOutlet;
            } else {
                $idOutlet = 0;
            }
        } else {
            $expOutlet = explode(",", $outlet);
            $countOutlet = count($expOutlet);
            $idOutlet = 0;
        }

        $data = [
            'toko' => $this->toko->where('id_toko', $idOutlet)->first(),
            'logo' => $this->setting->info['img_logo_resize'],
            'tgl_start' => $start,
            'tgl_end' => $end,
            'data' => $this->bank->getLaporanByBank($outlet, $start, $end)
        ];

        $html = view('App\Modules\Laporan\Views/bank_pdf', $data);

        // create new PDF document
        $pdf = new Html2Pdf('L', 'A4');

        // Print text using writeHTMLCell()
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        //$file = FCPATH.'files/penjualan.pdf';
        //$pdf->Output($file, 'F');
        //$attachment = base_url('files/penjualan.pdf');
        $pdf->Output('bank.pdf','I');  // display on the browser
    }

    public function penjualanPdf()
    {
        $input = $this->request->getVar();
        $outlet = $input['outlet'] ?? "";
        $start = $input['tgl_start'];
        $end = $input['tgl_end'];
        if ($outlet != '') {
            $expOutlet = explode(",", $outlet);
            $countOutlet = count($expOutlet);
            if ($countOutlet == 1) {
                $idOutlet = $expOutlet;
            } else {
                $idOutlet = 0;
            }
        } else {
            $expOutlet = explode(",", $outlet);
            $countOutlet = count($expOutlet);
            $idOutlet = 0;
        }

        $data = [
            'toko' => $this->toko->where('id_toko', $idOutlet)->first(),
            'logo' => $this->setting->info['img_logo_resize'],
            'tgl_start' => $start,
            'tgl_end' => $end,
            'data' => $this->penjualan->getLaporanByPenjualan($outlet, $start, $end)
        ];

        $html = view('App\Modules\Laporan\Views/penjualan_pdf', $data);

        // create new PDF document
        $pdf = new Html2Pdf('L', 'A4');

        // Print text using writeHTMLCell()
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        //$file = FCPATH.'files/penjualan.pdf';
        //$pdf->Output($file, 'F');
        //$attachment = base_url('files/penjualan.pdf');
        $pdf->Output('penjualan.pdf','I');  // display on the browser
    }

	public function barangPdf()
    {
        $input = $this->request->getVar();
        $outlet = $input['outlet'] ?? "";
        $start = $input['tgl_start'];
        $end = $input['tgl_end'];
        if ($outlet != '') {
            $expOutlet = explode(",", $outlet);
            $countOutlet = count($expOutlet);
            if ($countOutlet == 1) {
                $idOutlet = $expOutlet;
            } else {
                $idOutlet = 0;
            }
        } else {
            $expOutlet = explode(",", $outlet);
            $countOutlet = count($expOutlet);
            $idOutlet = 0;
        }

        $data = [
            'toko' => $this->toko->where('id_toko', $idOutlet)->first(),
            'logo' => $this->setting->info['img_logo_resize'],
            'tgl_start' => $start,
            'tgl_end' => $end,
            'data' => $this->barang->getLaporanByBarang($outlet, $start, $end)
        ];

        $html = view('App\Modules\Laporan\Views/barang_pdf', $data);

        // create new PDF document
        $pdf = new Html2Pdf('P', 'A4');

        // Print text using writeHTMLCell()
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        //$file = FCPATH.'files/barang.pdf';
        //$pdf->Output($file, 'F');
        //$attachment = base_url('files/barang.pdf');
        $pdf->Output('barang.pdf','I');  // display on the browser
    }

    public function stokbarangPdf()
    {
        $input = $this->request->getVar();
        $outlet = $input['outlet'] ?? "";
        $start = $input['tgl_start'];
        $end = $input['tgl_end'];
        if ($outlet != '') {
            $expOutlet = explode(",", $outlet);
            $countOutlet = count($expOutlet);
            if ($countOutlet == 1) {
                $idOutlet = $expOutlet;
            } else {
                $idOutlet = 0;
            }
        } else {
            $expOutlet = explode(",", $outlet);
            $countOutlet = count($expOutlet);
            $idOutlet = 0;
        }

        $data = [
            'toko' => $this->toko->where('id_toko', $idOutlet)->first(),
            'logo' => $this->setting->info['img_logo_resize'],
            'tgl_start' => $start,
            'tgl_end' => $end,
            'data' => $this->barang->getLaporanByStok($outlet, $start, $end)
        ];

        $html = view('App\Modules\Laporan\Views/stokbarang_pdf', $data);

        // create new PDF document
        $pdf = new Html2Pdf('P', 'A4');

        // Print text using writeHTMLCell()
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        //$file = FCPATH.'files/stokbarang.pdf';
        //$pdf->Output($file, 'F');
        //$attachment = base_url('files/stokbarang.pdf');
        $pdf->Output('stokbarang.pdf','I');  // display on the browser
    }

    public function kategoriPdf()
    {
        $input = $this->request->getVar();
        $outlet = $input['outlet'] ?? "";
        $start = $input['tgl_start'];
        $end = $input['tgl_end'];
        if ($outlet != '') {
            $expOutlet = explode(",", $outlet);
            $countOutlet = count($expOutlet);
            if ($countOutlet == 1) {
                $idOutlet = $expOutlet;
            } else {
                $idOutlet = 0;
            }
        } else {
            $expOutlet = explode(",", $outlet);
            $countOutlet = count($expOutlet);
            $idOutlet = 0;
        }
        
        $data = [
            'toko' => $this->toko->where('id_toko', $idOutlet)->first(),
            'logo' => $this->setting->info['img_logo_resize'],
            'tgl_start' => $start,
            'tgl_end' => $end,
            'data' => $this->kategori->getLaporanByKategori($start, $end)
        ];

        $html = view('App\Modules\Laporan\Views/kategori_pdf', $data);

        // create new PDF document
        $pdf = new Html2Pdf('P', 'A4');

        // Print text using writeHTMLCell()
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        //$file = FCPATH.'files/kategori.pdf';
        //$pdf->Output($file, 'F');
        //$attachment = base_url('files/kategori.pdf');
        $pdf->Output('kategori.pdf','I');  // display on the browser
    }

    public function labarugiPdf()
    {
        $input = $this->request->getVar();
        $outlet = $input['outlet'] ?? "";
        $start = $input['tgl_start'];
        $end = $input['tgl_end'];
        $totaloutlet = $input['totaloutlet'] ?? "";

        $data['sumPenjualan'] = $this->cash->sumPenjualan($outlet, $start, $end);
        $data['sumPenjualanBank'] = $this->bank->sumPenjualan($outlet, $start, $end);
        $data['sumPemasukanLain'] = $this->cash->sumPemasukanLain($outlet, $start, $end);
        $totalPendapatan = $data['sumPenjualan'] + $data['sumPenjualanBank'] + $data['sumPemasukanLain'];
        $data['sumHPP'] = $this->penjualan->sumHPP($outlet, $start, $end);
        $labaKotor = $totalPendapatan - $data['sumHPP'];
        $data['sumPengeluaran'] = $this->cash->sumPengeluaran($outlet, $start, $end);
        $data['sumPengeluaranBank'] = $this->bank->sumPengeluaran($outlet, $start, $end);
        $data['sumPengeluaranLain'] = $this->cash->sumMutasiBank($outlet, $start, $end);
        $totalPengeluaran = $data['sumPengeluaran'] + $data['sumPengeluaranBank'] +  $data['sumPengeluaranLain'];
        $labaBersih = $labaKotor - $totalPengeluaran;
        foreach ($data as $key => $value) {
            $arrayData = [
                'pemasukan_penjualan' => $data['sumPenjualan'],  
                'pemasukan_penjualan_bank' => $data['sumPenjualanBank'],  
                'pemasukan_lain' => $data['sumPemasukanLain'],
                'total_pendapatan' => $totalPendapatan,
                'beban_pokok_pendapatan' => $data['sumHPP'],
                'laba_kotor' => $labaKotor,
                'pengeluaran' => $data['sumPengeluaran'],
                'pengeluaran_bank' => $data['sumPengeluaranBank'],
                'pengeluaran_lain' => $data['sumPengeluaranLain'],
                'total_pengeluaran' => $totalPengeluaran,
                'laba_bersih' => $labaBersih,
            ];
        }

        if ($outlet != '') {
            $expOutlet = explode(",", $outlet);
            $countOutlet = count($expOutlet);
            if ($countOutlet == 1) {
                $idOutlet = $expOutlet;
            } else {
                $idOutlet = 0;
            }
        } else {
            $expOutlet = explode(",", $outlet);
            $countOutlet = $totaloutlet;
            $idOutlet = 0;
        }

        $data = [
            'toko' => $this->toko->where('id_toko', $idOutlet)->first(),
            'logo' => $this->setting->info['img_logo_resize'],
            'outlet' => $countOutlet,
            'tgl_start' => $start,
            'tgl_end' => $end,
            'data' => $arrayData
        ];

        $html = view('App\Modules\Laporan\Views/labarugi_pdf', $data);

        // create new PDF document
        $pdf = new Html2Pdf('P', 'A4');

        // Print text using writeHTMLCell()
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        //$file = FCPATH.'files/labarugi.pdf';
        //$pdf->Output($file, 'F');
        //$attachment = base_url('files/labarugi.pdf');
        $pdf->Output('labarugi.pdf','I');  // display on the browser
    }

    public function stokopnamePdf()
    {
        $input = $this->request->getVar();
        $outlet = $input['outlet'] ?? "";
        $start = $input['tgl_start'];
        $end = $input['tgl_end'];
        if ($outlet != '') {
            $expOutlet = explode(",", $outlet);
            $countOutlet = count($expOutlet);
            if ($countOutlet == 1) {
                $idOutlet = $expOutlet;
            } else {
                $idOutlet = 0;
            }
        } else {
            $expOutlet = explode(",", $outlet);
            $countOutlet = count($expOutlet);
            $idOutlet = 0;
        }

        $data = [
            'toko' => $this->toko->where('id_toko', $idOutlet)->first(),
            'logo' => $this->setting->info['img_logo_resize'],
            'tgl_start' => $start,
            'tgl_end' => $end,
            'data' => $this->stokopname->getStokOpname($outlet, $start, $end)
        ];

        $html = view('App\Modules\Laporan\Views/stokopname_pdf', $data);

        // create new PDF document
        $pdf = new Html2Pdf('P', 'A4');

        // Print text using writeHTMLCell()
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        //$file = FCPATH.'files/stokopname.pdf';
        //$pdf->Output($file, 'F');
        //$attachment = base_url('files/stokopname.pdf');
        $pdf->Output('stokopname.pdf','I');  // display on the browser
    }


}
