<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionTableSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(Tree1Seeder::class);
        $this->call(Tree2Seeder::class);
        $this->call(Tree3Seeder::class);
        $this->call(Tree4Seeder::class);
    }
}
