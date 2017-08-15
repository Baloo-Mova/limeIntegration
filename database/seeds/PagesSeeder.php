<?php

use Illuminate\Database\Seeder;
use App\Models\Pages;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Pages::find(1) == null){
            Pages::Insert([
                ['title'     => 'О нас', 'page_content' => null, 'name' => 'aboutUs'],
                ['title'     => 'FAQ', 'page_content' => null, 'name' => 'faq'],
                ['title'     => 'Конфиденциальность', 'page_content' => null, 'name' => 'confidentiality'],
                ['title'     => 'Пользовательское соглашение', 'page_content' => null, 'name' => 'terms'],
                ['title'     => 'Обратная связь', 'page_content' => null, 'name' => 'feedback']
            ]);
        }
    }
}
