<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articles')->insert($this->getData());
    }

    private function getData()
    {
        $data[] = [
            'user_id' => 1,
            'category_id' => 1,
            'title' => 'Контакты',
            'name' => 'contacts',
            'text' => 'МЫ ВСЕГДА ОТКРЫТЫ ДЛЯ ОБЩЕНИЯ. Если Вы не нашли ответа на Ваш вопрос либо желаете личное общение, Вы можете отправить нам сообщение, а так же найти нас в Социальных Сетях.
Мы с радостью ответим и поможем Вам в любом вопросе.',
            'image' => ''
        ];
        $data[] = [
            'user_id' => 1,
            'category_id' => 1,
            'title' => 'О нас',
            'name' => 'about',
            'text' => 'Мы занимаемся поставками товаров с 2006 года! За это время мы приобрели огромный опыт и связи, знакомства и сотрудничество с разными компаниями и просто людьми… Мы обеспечим для Вас лучший сервис по приобретению любого товара в США.',
            'image' => ''
        ];
        $data[] = [
            'user_id' => 1,
            'category_id' => 1,
            'title' => 'Политика конфиденциальности персональных данных',
            'name' => 'privacy-policy',
            'text' => '',
            'image' => ''
        ];
        $data[] = [
            'user_id' => 1,
            'category_id' => 2,
            'title' => 'Как заказать товар',
            'name' => 'how-to-order-a-product',
            'text' => '',
            'image' => ''
        ];
        $data[] = [
            'user_id' => 1,
            'category_id' => 2,
            'title' => 'Как заказать Автомобиль',
            'name' => 'how-to-order-a-car',
            'text' => '',
            'image' => ''
        ];
        return $data;
    }
}
