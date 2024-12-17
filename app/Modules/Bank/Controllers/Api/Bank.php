<?php

namespace App\Modules\Bank\Controllers\Api;

use App\Controllers\BaseControllerApi;
use App\Modules\Bank\Models\BankModel;
use App\Modules\Cashflow\Models\CashflowModel;
use App\Modules\Toko\Models\TokoModel;
use App\Modules\Log\Models\LogModel;
use CodeIgniter\I18n\Time;

class Bank extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = BankModel::class;
    protected $cash;
    protected $toko;
    protected $log;

    public function __construct()
    {
        //memanggil Model
        $this->cash = new CashflowModel();
        $this->toko = new TokoModel();
        $this->log = new LogModel();
        helper('text');
    }

    public function index()
    {
        $input = $this->request->getVar();
        $start = $input['tgl_start'] ?? "";
        $end = $input['tgl_end'] ?? "";
        $where = $input['bank'] ?? "";
        if ($start == "" && $end == "") {
            $data = $this->model->getBank($where);
        } else {
            $data = $this->model->getBank($start, $end, $where);
        }
        if (!empty($data)) {
            $response = [
                "status" => true,
                "message" => lang('App.getSuccess'),
                "data" => $data
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => lang('App.noData'),
                'data' => []
            ];
            return $this->respond($response, 200);
        }
    }

    public function show($id = null)
    {
        return $this->respond(['status' => true, 'message' => lang('App.getSuccess'), 'data' => $this->model->showBank($id)], 200);
    }

    public function saldo()
    {
        $input = $this->request->getVar();
        $start = $input['tgl_start'] ?? "";
        $end = $input['tgl_end'] ?? "";
        $where = $input['bank'] ?? "";
        if ($where == "") {
            $data = $this->model->getSaldo($where);
        } else {
            $data = $this->model->getSaldo($start, $end, $where);
        }
        if (!empty($data)) {
            $response = [
                "status" => true,
                "message" => lang('App.getSuccess'),
                "data" => (int)$data
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => lang('App.noData'),
                'data' => []
            ];
            return $this->respond($response, 200);
        }
    }

    public function create()
    {
        $rules = [
            'jenis' => [
                'rules'  => 'required',
                'errors' => []
            ],
            'nominal' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        //Ambil kode bank
        $idToko = get_cookie('id_toko');
        $toko = $this->toko->find($idToko);
        $kdBank = $toko['kode_bank'];
        $idBankAkun = $toko['id_bank_akun'];
        $kdJualTahun = $toko['kode_jual_tahun'];
        /* $time = Time::now();
        if ($time->getHour() < 10) {
            $getHour = '0' . $time->getHour();
        } else {
            $getHour = $time->getHour();
        }
        if ($time->getMinute() < 10) {
            $getMinute = '0' . $time->getMinute();
        } else {
            $getMinute = $time->getMinute();
        }
        if ($time->getSecond() < 10) {
            $getSecond = '0' . $time->getSecond();
        } else {
            $getSecond = $time->getSecond();
        }
        $timestamp = $getHour . $getMinute . $getSecond; */

        if ($kdJualTahun == '1') {
            //Hitung transaksi tgl-bulan-tahun total tambah 1
            $query = $this->model->select('DATE(created_at) as date_val, COUNT(*) as total')->groupBy('DATE(created_at)');
            $hasil = $query->get()->getRowArray();
            if (empty($hasil)) {
                $last = 1;
            } else {
                $last = $hasil['total'] + 1;
            }
            $lastKode = sprintf('%02s', $last);

            $kodeBank = $kdBank . random_string('numeric', 3) . date('dmy') . '-' . $lastKode;
        } else {
            //Hitung transaksi bulan-tahun total tambah 1
            $query = $this->model->select('YEAR(created_at) as year_val, MONTH(created_at) as month_val, COUNT(*) as total')->groupBy('YEAR(created_at), MONTH(created_at)');
            $hasil = $query->get()->getRowArray();
            if (empty($hasil)) {
                $last = 1;
            } else {
                $last = $hasil['total'] + 1;
            }
            $lastKode = sprintf('%02s', $last);

            $kodeBank = $kdBank . random_string('numeric', 3) . date('my') . '-' . $lastKode;
        }

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $jenis = $json->jenis;
            $tanggal = $json->tanggal;
            $waktu = $json->waktu;
            $nominal = $json->nominal;
            $keterangan = $json->keterangan;
            $idBank = $json->id_bank;
            $idToko = $json->id_toko;
            if ($jenis == "Pemasukan") {
                $pemasukan = $nominal;
                $pengeluaran = 0;
            } else {
                $pengeluaran = $nominal;
                $pemasukan = 0;
            }
            $data = [
                'faktur' => $kodeBank,
                'jenis' => $jenis,
                'tanggal' => $tanggal,
                'waktu' => $waktu,
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
                'keterangan' => $keterangan,
                'id_toko' => $idToko,
                'id_login' => session()->get('id'),
                'id_bank_akun' => $idBankAkun,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null
            ];
        } else {
            $jenis = $this->request->getPost('jenis');
            $tanggal = $this->request->getPost('tanggal');
            $waktu = $this->request->getPost('waktu');
            $nominal = $this->request->getPost('nominal');
            $keterangan = $this->request->getPost('keterangan');
            $idBank = $this->request->getPost('id_bank');
            $idToko = $this->request->getPost('id_toko');
            if ($jenis == "Pemasukan") {
                $pemasukan = $nominal;
                $pengeluaran = 0;
            } else {
                $pengeluaran = $nominal;
                $pemasukan = 0;
            }
            $data = [
                'faktur' => $kodeBank,
                'jenis' => $jenis,
                'tanggal' => $tanggal,
                'waktu' => $waktu,
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
                'keterangan' => $keterangan,
                'id_toko' => $idToko,
                'id_login' => session()->get('id'),
                'id_bank_akun' => $idBankAkun,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null
            ];
        }

        if (!$this->validate($rules)) {
            $response = [
                'status' => false,
                'message' => lang('App.isRequired'),
                'data' => $this->validator->getErrors(),
            ];
            return $this->respond($response, 200);
        } else {
            $this->model->save($data);
            $lastId = $this->model->getInsertID();

            //Save Log
            $this->log->save(['keterangan' => session('nama') . ' (' . session('email') . ') ' . strtolower(lang('App.do')) . ' Save Bank: ' . $kodeBank . ' Keterangan: ' . $jenis . ' ' . $keterangan]);

            if ($idBank != '') :
                $this->model->update($idBank, ['keterangan' => 'Transfered']);
            endif;

            if ($jenis == "Mutasi ke Kas") {
                $bank = $this->model->find($idBank);
                $this->model->update($lastId, ['noref_nokartu' => $bank['faktur']]);

                $dataKas = [
                    'faktur' => $kodeBank,
                    'jenis' => 'Pemasukan',
                    'kategori' => 'Mutasi dari Bank',
                    'tanggal' => $tanggal,
                    'waktu' => $waktu,
                    'pemasukan' => $nominal,
                    'pengeluaran' => 0,
                    'keterangan' => $keterangan,
                    'id_toko' => $idToko,
                    'id_login' => session()->get('id'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => null
                ];
                //Save Kas
                $this->cash->save($dataKas);

                //Save Log
                $this->log->save(['keterangan' => session('nama') . ' (' . session('email') . ') ' . strtolower(lang('App.do')) . ' Save Cash: ' . $kodeBank . ' Keterangan: Pemasukan Mutasi dari Bank']);
            }

            $response = [
                'status' => true,
                'message' => lang('App.saveSuccess'),
                'data' => [],
            ];
            return $this->respond($response, 200);
        }
    }

    public function update($id = NULL)
    {
        $rules = [
            'keterangan' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'keterangan' => $json->keterangan,
            ];
        } else {
            $data = $this->request->getRawInput();
        }

        if (!$this->validate($rules)) {
            $response = [
                'status' => false,
                'message' => lang('App.isRequired'),
                'data' => $this->validator->getErrors(),
            ];
            return $this->respond($response, 200);
        } else {
            $this->model->update($id, $data);
            $response = [
                'status' => true,
                'message' => lang('App.updSuccess'),
                'data' => [],
            ];
            return $this->respond($response, 200);
        }
    }

    public function delete($id = null)
    {
        $delete = $this->model->find($id);
        $faktur = $delete['faktur'];
        $jenis = $delete['jenis'];
        $nominal = $delete['pengeluaran'];

        if ($delete) {
            if ($jenis == "Mutasi ke Kas") :
                $cashflow = $this->cash->where('faktur', $faktur)->findAll();
                foreach ($cashflow as $row) {
                    $idCashflow = $row['id_cashflow'];
                    //Delete Cashflow
                    $this->cash->delete($idCashflow);
                    //Save Log
                    $this->log->save(['keterangan' => session('nama') . ' (' . session('email') . ') ' . strtolower(lang('App.do')) . ' Delete Cash: ' . $faktur . ' Keterangan: Mutasi ke Bank']);
                }

                //Update bank where faktur
                $bank = $this->model->where('faktur', $delete['noref_nokartu'])->first();
                $this->model->update($bank['id_bank'], ['keterangan' => '']);
            endif;

            //Delete Bank
            $this->model->delete($id);
            //Save Log
            $this->log->save(['keterangan' => session('nama') . ' (' . session('email') . ') ' . strtolower(lang('App.do')) . ' Delete Bank: ' . $faktur]);

            $response = [
                'status' => true,
                'message' => lang('App.delSuccess'),
                'data' => [],
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => lang('App.delFailed'),
                'data' => [],
            ];
            return $this->respond($response, 200);
        }
    }
}
