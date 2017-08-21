<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = \App\Models\Settings::find(1);
        if (!isset($settings)) {
            \App\Models\Settings::insert([
                'min_sum' => 1,
                'new_message_text' => '',
                'remind_message_text' => '',
            ]);
        }
    }
}
