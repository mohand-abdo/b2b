<?php

namespace App\Helpers;

use App\Models\Setting;

class Helper
{
    // دالة لإرجاع إعداد معين
    public static function GeneralSiteSettings($var)
    {
        $setting = Setting::find(1);

        if (!$setting) {
            // معالجة حالة عدم وجود الإعدادات
            throw new \Exception('Settings not found');
        }

        return $setting->$var;
    }

    // دالة لتحديد الحساب بناءً على tree3_code
    public static function no_account($item)
    {
        if ($item->tree4_code == '120300001') {
            return 'رقم الحساب ' . self::GeneralSiteSettings('no_khartoum');
        } elseif ($item->tree4_code == '120300002') {
            return 'رقم الحساب ' . self::GeneralSiteSettings('no_faisal');
        }

        // خيار افتراضي في حال عدم تحقق أي شرط
        return null;
    }

    public static function notifications()
    {
        return auth()->user()->notifications()->orderBy('created_at', 'desc')->get();
    }

    public static function countNotifications()
    {
        return auth()->user()->notifications->count();
    }

    public static function unReadCountNotifications()
    {
        return auth()->user()->notifications->where('read', false)->count();
    }
// use Illuminate\Support\Facades\Request;

// public function index(Request $request)
// {
//     $elementId = $request->get('id', null); // الحصول على ID العنصر من الرابط
//     $itemsPerPage = 10; // عدد العناصر في كل صفحة
//     $currentPage = 1; // افتراضي الصفحة الأولى

//     if ($elementId) {
//         // البحث عن ترتيب العنصر في قاعدة البيانات
//         $elementPosition = Element::where('id', $elementId)->orderBy('created_at', 'ASC')->pluck('id')->search($elementId) + 1;

//         // حساب الصفحة التي تحتوي العنصر
//         $currentPage = ceil($elementPosition / $itemsPerPage);
//     }

//     // جلب العناصر مع تحديد الصفحة
//     $elements = Element::paginate($itemsPerPage, ['*'], 'page', $currentPage);

//     return view('list.index', compact('elements', 'elementId', 'currentPage'));
// }

    // ///function to Transport Setting
    // static function GeneralSiteTransportSettings($variable)
    // {
    //     $Transport_Setting = Transport_Setting::find(1);
    //     return $Transport_Setting->$variable;
    // }
}
