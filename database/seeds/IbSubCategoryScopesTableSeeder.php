<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IbSubCategoryScopesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ib_sub_category_scopes')->insert([
            [
                'ib_main_category_scope_id' => 1,
                'name' => 'การตรวจโรงงานเพื่อการรับรองคุณภาพผลิตภัณฑ์'  
            ],
            [
                'ib_main_category_scope_id' => 2,
                'name' => 'เครื่องแต่งกาย: เสื้อผ้าสำเร็จรูป'  
            ],
            [
                'ib_main_category_scope_id' => 3,
                'name' => 'เครื่องแต่งกาย : เสื้อผ้าสําเร็จรูป2'  
            ],
            [
                'ib_main_category_scope_id' => 4,
                'name' => 'ผลิตภัณฑ์อาหาร: การตรวจผลิตภัณฑ์อาหาร'  
            ],
            [
                'ib_main_category_scope_id' => 5,
                'name' => 'ยานยนต์: รถยนต์'  
            ],
            [
                'ib_main_category_scope_id' => 6,
                'name' => 'เครื่องจักรกล: ถังก๊าซปิโตรเลียมเหลว'  
            ],
            [
                'ib_main_category_scope_id' => 7,
                'name' => 'ข้าวหอมมะลิไทย,ข้าวหอมไทย'  
            ],
            [
                'ib_main_category_scope_id' => 7,
                'name' => 'ข้าวขาว,ข้าวกล้อง,ข้าวเหนียวขาว,ข้าวนึ่ง'  
            ],
            [
                'ib_main_category_scope_id' => 7,
                'name' => 'น้ำตาลทรายขาว,น้ำตาลทรายดิบ'  
            ],
            [
                'ib_main_category_scope_id' => 7,
                'name' => 'ข้าวสาลี,กากถั่วเหลือง'  
            ],
            [
                'ib_main_category_scope_id' => 7,
                'name' => 'เมล็ดธัญพืช'  
            ],
            [
                'ib_main_category_scope_id' => 7,
                'name' => 'ข้าว'  
            ],
            [
                'ib_main_category_scope_id' => 7,
                'name' => 'น้ำตาลทรายขาวบริสุทธิ์,น้ำตาลทรายดิบ'  
            ],
            [
                'ib_main_category_scope_id' => 7,
                'name' => 'ข้าว,ผลิตภัณฑ์อาหารสัตว์,ผลิตภัณฑ์เชื้อเพลิงชีวมวล'  
            ],
            [
                'ib_main_category_scope_id' => 8,
                'name' => 'สินค้าเกษตร :  ผลิตภัณฑ์มันสําปะหลัง'  
            ]
          

        ]);
    }
}
