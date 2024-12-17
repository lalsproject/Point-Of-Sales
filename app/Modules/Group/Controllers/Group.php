<?php

namespace App\Modules\Group\Controllers;
/*
PT ITSHOP BISNIS DIGITAL
Website: https://itshop.biz.id
Toko Online: ITSHOP Purwokerto (https://Tokopedia.com/itshoppwt, https://Shopee.co.id/itshoppwt, https://Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
02-2024
*/

use App\Controllers\BaseController;
use App\Modules\Group\Models\GroupModel;
use CodeIgniter\I18n\Time;
use App\Libraries\Settings;

class Group extends BaseController
{
    protected $group;
    protected $setting;

    public function __construct()
    {
        //memanggil function di model
        $this->group = new GroupModel();
        $this->setting = new Settings();
    }

    public function index()
    {
        // User Agent Class
        $agent = $this->request->getUserAgent();
        if ($agent->isMobile()) {
            $view = 'group_mobile';
        } else {
            $view = 'group';
        }

        return view('App\Modules\Group\Views/' . $view, [
            'title' => 'Group',
            //'masterPermissions' => unserialize($this->setting->info['permissions']),
            //'permissions' => json_encode(unserialize($this->setting->info['permissions']))
        ]);
    }

    public function edit($id = null)
    {
        // User Agent Class
        $agent = $this->request->getUserAgent();
        if ($agent->isMobile()) {
            $view = 'group_edit_mobile';
        } else {
            $view = 'group_edit';
        }

        $group = $this->group->find($id);
        return view('App\Modules\Group\Views/' . $view, [
            'title' => 'Edit Group: ' . $group['nama_group'],
            'id' => $id,
            'group' => $group,
            'permissions' => unserialize($group['permission'])
        ]);
    }

    public function update($id)
    {
        $permission = serialize($this->request->getPost('permission'));

        $data = array(
            'nama_group' => $this->request->getPost('nama_group'),
            'permission' => $permission,
            'updated_at' => date('Y-m-d H:i:s')
        );

        $this->group->update($id, $data);
        $this->session->setFlashdata('success', 'Data Berhasil Di Update.');
        return redirect()->to('/group');
    }
}
