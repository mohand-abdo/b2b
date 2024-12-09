<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tree2;

class Tree2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tree2  = new Tree2();
        $tree2->tree2_code = 11;
        $tree2->tree2_name = 'اصول ثابتة';
        $tree2->tree1_code = 1;
        $tree2->save();

        $tree2  = new Tree2();
        $tree2->tree2_code = 12;
        $tree2->tree2_name = 'اصول متداولة';
        $tree2->tree1_code = 1;
        $tree2->save();


        $tree2  = new Tree2();
        $tree2->tree2_code = 21;
        $tree2->tree2_name = 'مرتبات الموظفين';
        $tree2->tree1_code = 2;
        $tree2->save();

        $tree2  = new Tree2();
        $tree2->tree2_code = 22;
        $tree2->tree2_name = 'دائنون حكوميون';
        $tree2->tree1_code = 2;
        $tree2->save();

        $tree2  = new Tree2();
        $tree2->tree2_code = 41;
        $tree2->tree2_name = 'ايرادات اخرى ';
        $tree2->tree1_code = 4;
        $tree2->save();

        $tree2  = new Tree2();
        $tree2->tree2_code = 51;
        $tree2->tree2_name = 'منصرفات اخرى';
        $tree2->tree1_code = 5;
        $tree2->save();

        $tree2  = new Tree2();
        $tree2->tree2_code = 42;
        $tree2->tree2_name = 'المبيعات';
        $tree2->tree1_code = 4;
        $tree2->save();


        $tree2  = new Tree2();
        $tree2->tree2_code = 52;
        $tree2->tree2_name = 'المشتريات';
        $tree2->tree1_code = 5;
        $tree2->save();


        $tree2  = new Tree2();
        $tree2->tree2_code = 23;
        $tree2->tree2_name = 'الموردين';
        $tree2->tree1_code = 2;
        $tree2->save();
    }
}
