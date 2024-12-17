<?php

namespace App\Modules\Member\Controllers;
/*
PT ITSHOP BISNIS DIGITAL
Website: https://itshop.biz.id
Toko Online: ITSHOP Purwokerto (https://Tokopedia.com/itshoppwt, https://Shopee.co.id/itshoppwt, https://Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
06-2022
*/

use App\Controllers\BaseController;

class Member extends BaseController
{
    public function __construct()
    {
        
    }

    public function index()
    {
        // User Agent Class
		$agent = $this->request->getUserAgent();
		if ($agent->isMobile()) {
			return view('App\Modules\Member\Views/member_mobile', [
                'title' => 'Member',
            ]);
		} else {
			return view('App\Modules\Member\Views/member', [
                'title' => 'Member',
            ]);
		}
    }

    
}
