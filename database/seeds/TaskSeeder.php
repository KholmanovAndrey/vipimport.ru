<?php

use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->insert($this->getData());
    }

    private function getData()
    {
        $data[] = [
            'title' => 'Умножение',
            'description' => '2*6',
            'solution' => '12'
        ];
        $data[] = [
            'title' => 'Сложение',
            'description' => '2+6',
            'solution' => '12'
        ];
        return $data;
    }
}
