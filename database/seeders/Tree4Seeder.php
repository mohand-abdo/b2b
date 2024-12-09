<?php

namespace Database\Seeders;

use App\Models\Tree4;
use Illuminate\Database\Seeder;

class Tree4Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tree4  = new Tree4();
        $tree4->tree4_code = 120300001;
        $tree4->tree4_name = 'بنك الخرطوم';
        $tree4->tree3_code = 1203;
        $tree4->save();

        $tree4  = new Tree4();
        $tree4->tree4_code = 120300002;
        $tree4->tree4_name = 'بنك فيصل';
        $tree4->tree3_code = 1203;
        $tree4->save();

        $tree4  = new Tree4();
        $tree4->tree4_code = 120200001;
        $tree4->tree4_name = 'الخزينة الكاش';
        $tree4->tree3_code = 1202;
        $tree4->save();
        ////////////////////////////////////////////////

        $tree4  = new Tree4();
        $tree4->tree4_code = 410100001;
        $tree4->tree4_name = 'العمولات';
        $tree4->tree3_code = 4101;
        $tree4->save();


        $tree4  = new Tree4();
        $tree4->tree4_code = 510100001;
        $tree4->tree4_name = 'منصرفات اليوم';
        $tree4->tree3_code = 5101;
        $tree4->save();

        $tree4  = new Tree4();
        $tree4->tree4_code = 420100001;
        $tree4->tree4_name = 'المبيعات';
        $tree4->tree3_code = 4201;
        $tree4->save();

        $tree4  = new Tree4();
        $tree4->tree4_code = 520100001;
        $tree4->tree4_name = 'المشتريات';
        $tree4->tree3_code = 5201;
        $tree4->save();

        $tree4  = new Tree4();
        $tree4->tree4_code = 410100002;
        $tree4->tree4_name = 'إيرادات النقل';
        $tree4->tree3_code = 4101;
        $tree4->save();
    }
}