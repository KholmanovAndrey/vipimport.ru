<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert($this->getData());
    }

    private function getData()
    {
        $data[] = [
            'name' => 'superAdmin',
        ];
        $data[] = [
            'name' => 'admin',
        ];
        $data[] = [
            'name' => 'manager',
        ];
        $data[] = [
            'name' => 'client',
        ];
        return $data;
    }
}
