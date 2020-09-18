<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert($this->getData());
    }

    private function getData()
    {
        $data[] = [
            'title' => 'Новый'
        ];
        $data[] = [
            'title' => 'В работе'
        ];
        $data[] = [
            'title' => 'Заказан'
        ];
        $data[] = [
            'title' => 'Выкуплен'
        ];
        $data[] = [
            'title' => 'На складе'
        ];
        return $data;
    }
}
