<?php

namespace App\Modules\Keranjang\Controllers\Api;
/*
PT ITSHOP BISNIS DIGITAL
Website: https://itshop.biz.id
Toko Online: ITSHOP Purwokerto (https://Tokopedia.com/itshoppwt, https://Shopee.co.id/itshoppwt, https://Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
02-2024
*/

use App\Controllers\BaseControllerApi;
use App\Modules\Keranjang\Models\KeranjangModel;
use App\Modules\Keranjang\Models\KeranjangPendingModel;
use App\Modules\Kontak\Models\KontakModel;
use CodeIgniter\I18n\Time;

class KeranjangPending extends BaseControllerApi
{
    protected $format       = 'json';
    protected $modelName    = KeranjangPendingModel::class;
    protected $keranjang;
    protected $kontak;

    public function __construct()
    {
        helper('text');
        $this->keranjang = new KeranjangModel();
        $this->kontak = new KontakModel();
    }

    // Keranjang Jual
    public function index()
    {
        $input = $this->request->getVar();
        $outlet = $input['id_toko'];

        $data = $this->model->getPending($outlet);

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
        $data = $this->model->find($id);
        $keranjang = $this->keranjang->getKeranjangPending($id);

        //Update Keranjang id_pending = null
        foreach ($keranjang as $row) {
            $this->keranjang->update($row['id_keranjang'], ['id_pending' => null]);
        }

        //Delete Keranjang pending
        $this->model->delete($id);

        $response = [
            "status" => true,
            "message" => lang('App.getSuccess'),
            "data" => $data,
            "keranjang" => $keranjang
        ];
        return $this->respond($response, 200);
    }

    public function create()
    {
        $rules = [
            'total' => [
                'rules'  => 'required',
                'errors' => []
            ],
        ];

        $idPending = random_string('alnum', 16);

        //Ambil request post data
        $input = $this->request->getVar('data');
        foreach ($input as $value) {
            $id_barang[] = $value[0];
            $harga_jual[] = $value[1];
            $stok[] = $value[2];
            $jumlah[] = $value[3];
            $satuan[] = $value[4];
            $harga_beli[] = $value[5];
            $diskon[] = $value[6];
            $diskon_persen[] = $value[7];
            $hpp[] = $value[8];
            $total_laba[] = $value[9];
            $harga_grosir[] = $value[10];
            $min_grosir[] = $value[11];
            $id_keranjang[] = $value[12];
        }
        $total_barang = count($id_barang);

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $kontak = $this->kontak->find($json->id_kontak);
            $data = [
                'id_pending' => $idPending,
                'nama_kontak' => $kontak['nama'],
                'jumlah_item' => $total_barang,
                'subtotal' => $json->subtotal,
                'total' => $json->total,
                'id_toko' => $json->id_toko,
                'id_login' => session()->get('id'),
                'id_kontak' => $json->id_kontak,
                'metode_bayar' => $json->metode_bayar,
                'catatan' => $json->catatan,
            ];
        } else {
            $kontak = $this->kontak->find($this->request->getPost('id_kontak'));
            $data = [
                'id_pending' => $idPending,
                'nama_kontak' => $kontak['nama'],
                'jumlah_item' => $total_barang,
                'subtotal' => $this->request->getPost('subtotal'),
                'total' => $this->request->getPost('total'),
                'id_toko' => $this->request->getPost('id_toko'),
                'id_login' => session()->get('id'),
                'id_kontak' => $this->request->getPost('id_kontak'),
                'metode_bayar' => $this->request->getPost('metode_bayar'),
                'catatan' => $this->request->getPost('catatan'),
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

            //Update
            $arrKeranjang = array();
            foreach ($input as $key => $value) {
                $id_barang = $value[0];
                $harga_jual = $value[1];
                $stok = $value[2];
                $qty = $value[3];
                $satuan = $value[4];
                $harga_beli = $value[5];
                $diskon = $value[6];
                $diskon_persen = $value[7];
                $hpp = $value[8];
                $total_laba = $value[9];
                $harga_grosir = $value[10];
                $min_grosir = $value[11];
                $id_keranjang = $value[12];
                $keranjang = array(
                    'id_keranjang' => $id_keranjang,
                    'id_pending' => $idPending,
                );
                array_push($arrKeranjang, $keranjang);
            }
            $dataKeranjang = $arrKeranjang;
            $this->keranjang->updateBatch($dataKeranjang, 'id_keranjang');

            $response = [
                'status' => true,
                'message' => lang('App.saveSuccess'),
                'data' => [],
            ];
            return $this->respond($response, 200);
        }
    }
}
