<?php

namespace App\Libraries;
/*
PT ITSHOP BISNIS DIGITAL
Website: https://itshop.biz.id
Toko Online: ITSHOP Purwokerto (https://Tokopedia.com/itshoppwt, https://Shopee.co.id/itshoppwt, https://Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
02-2024
*/

class Language
{
	var $htmlLang = "";
	var $siteLang = "";
	public function __construct()
	{
		$config = config("App");
		if (session()->get('lang') || env('app.defaultLocale') == 'id' ?? $config->defaultLocale) {
			$this->htmlLang = 'id';
			$this->siteLang = 'id-ID';
		} else {
			$this->htmlLang = 'en';
			$this->siteLang = 'en-US';
		}
	}
}
