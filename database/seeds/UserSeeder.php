<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert($this->getData());
    }

    private function getData()
    {
        $data[] = [
            'name' => 'SuperAdmin',
            'email' => 'superadmin@vipimport.ru',
            'password' => Hash::make('superAdmin'),
        ];
        $data[] = [
            'name' => 'Admin',
            'email' => 'admin@vipimport.ru',
            'password' => Hash::make('admin'),
        ];
        $data[] = [
            'name' => 'Client',
            'email' => 'client@vipimport.ru',
            'password' => Hash::make('client'),
        ];
        return $data;
    }
}
