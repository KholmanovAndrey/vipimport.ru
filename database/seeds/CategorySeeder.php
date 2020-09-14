<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert($this->getData());
    }

    private function getData()
    {
        $data[] = [
            'title' => 'без категории',
            'name' => 'no-categories',
            'description' => ''
        ];
        $data[] = [
            'title' => 'Информация для клиентов',
            'name' => 'information-for-clients',
            'description' => ''
        ];
        $data[] = [
            'title' => 'Юридическая информация',
            'name' => 'legal-information',
            'description' => ''
        ];
        $data[] = [
            'title' => 'Наши услуги',
            'name' => 'services',
            'description' => ''
        ];
        return $data;
    }
}
