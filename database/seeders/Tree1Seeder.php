<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tree1;
class Tree1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tree1  = new Tree1();
        $tree1->tree1_code = 1;
        $tree1->tree1_name = 'الاصول';
        $tree1->save();
        //
        $tree1  = new Tree1();
        $tree1->tree1_code = 2;
        $tree1->tree1_name = 'الخصوم';
        $tree1->save();
        //
        $tree1  = new Tree1();
        $tree1->tree1_code = 3;
        $tree1->tree1_name = 'حقوق الملكية';
        $tree1->save();
        //
        $tree1  = new Tree1();
        $tree1->tree1_code = 4;
        $tree1->tree1_name = 'إيرادات';
        $tree1->save();
        //
        $tree1  = new Tree1();
        $tree1->tree1_code = 5;
        $tree1->tree1_name = 'منصرفات';
        $tree1->save();
        //

    }
}
