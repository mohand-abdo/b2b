<?php

namespace App\Helpers;

use App\Models\Setting;
use App\Models\Transport_Setting;


class Helper
{
    static function GeneralSiteSettings($var)
    {
        $Setting = Setting::find(1);
        return $Setting->$var;
    }

    ///function to Transport Setting 
    static function GeneralSiteTransportSettings($variable)
    {
        $Transport_Setting = Transport_Setting::find(1);
        return $Transport_Setting->$variable;
    }

}
