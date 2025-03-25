<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IbMainCategoryScopesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ib_main_category_scopes')->insert([
            [
                'name' => 'การตรวจโรงงานเพื่อการรับรองคุณภาพผลิตภัณฑ์',
            ],
            [
                'name' => 'เครื่องแต่งกาย: เสื้อผ้าสำเร็จรูป',
            ],
            [
                'name' => 'เครื่องแต่งกาย: เสื้อผ้าสำเร็จรูป2',
            ],
            [
                'name' => 'ผลิตภัณฑ์อาหาร: การตรวจผลิตภัณฑ์อาหาร',
            ],
            [
                'name' => 'ยานยนต์: รถยนต์',
            ],
            [
                'name' => 'เครื่องจักรกล: ถังก๊าซปิโตรเลียมเหลว',
            ],
            [
                'name' => 'สินค้าเกษตร',
            ],
            [
                'name' => 'สินค้าเกษตร: ผลิตภัณฑ์มันสำปะหลัง',
            ]

        ]);
    }
}
