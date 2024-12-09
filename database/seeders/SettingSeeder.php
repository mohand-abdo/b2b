<?php

namespace Database\Seeders;

use App\Models\setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = new setting();
        $setting->id = 1;
        $setting->name = 'براند للاعمال المتقدمة المحددة';
        $setting->location = 'الخرطوم - بحري';
        $setting->phone = '249116266500';
        $setting->email = 'Brand-sd@gmail.com';
        $setting->logo = '17307014763895.png';
        $setting->save();
    }
}
