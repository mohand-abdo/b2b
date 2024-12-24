<?php

namespace Database\Seeders;

use App\Models\Setting;
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
        $setting = new Setting();
        $setting->id = 1;
        $setting->name = 'b2b';
        $setting->location = 'الخرطوم - بحري';
        $setting->phone = '249116266500';
        $setting->no_khartoum = '202020';
        $setting->no_faisal = '1101010';
        $setting->email = 'info@b2btravelsudan';
        $setting->logo = '17307014763895.png';
        $setting->save();
    }
}
