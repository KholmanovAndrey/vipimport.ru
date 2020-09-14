<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacts')->insert($this->getData());
    }

    private function getData()
    {
        $data[] = [
            'title' => 'Офис в США',
            'address' => 'VIP IMPORT LLC <br/>11520 N Port Washington Rd. Suite 1 <br/>D Mequon, WI 53092 USA',
            'phone' => '+1 702 602 0004',
            'email' => 'inf@vipimport.ru',
            'description' => ''
        ];
        $data[] = [
            'title' => 'Представительство в России',
            'address' => 'ООО "ВИП ИМПОРТ" <br/>Алтайский Край, г.Барнаул, <br/>ул.Попова, д.248/5, 656922 РФ',
            'phone' => '+7 995 089 9904',
            'email' => 'inf@vipimport.ru',
            'description' => ''
        ];
        return $data;
    }
}
