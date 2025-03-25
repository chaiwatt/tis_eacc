<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IbScopeTopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ib_scope_topics')->insert([
            [
                'ib_sub_category_scope_id' => 1,
                'name' => 'การตรวจกระบวนการผลิต ระบบการควบคุมคุณภาพและการตรวจประเมินผลิตภัณฑ์ สำหรับผลิตภัณฑ์'  
            ],
            [
                'ib_sub_category_scope_id' => 2,
                'name' => 'การตรวจสายการผลิตและการตรวจก่อนการส่งมอบในรายการต่อไปนี้'  
            ],
            [
                'ib_sub_category_scope_id' => 3,
                'name' => 'การตรวจสายการผลิต (In-line process inspection) และการตรวจก่อนการส่งมอบ (Pre-shipment inspection) ในรายการต่อไปนี้'  
            ],
            [
                'ib_sub_category_scope_id' => 4,
                'name' => 'การตรวจระหว่างการผลิตและการตรวจก่อนการส่งมอบ '  
            ],
            [
                'ib_sub_category_scope_id' => 5,
                'name' => 'การตรวจสภาพทั่วไปก่อนการส่งมอบในรายการต่อไปนี้'  
            ],
            [
                'ib_sub_category_scope_id' => 6,
                'name' => 'การตรวจกระบวนการผลิตและการควบคุมคุณภาพ ในรายการต่อไปนี้'
            ],
            [
                'ib_sub_category_scope_id' => 7,
                'name' => 'การตรวจในขั้นตรวจปล่อยในรายการต่อไปนี้'  
            ],
            [
                'ib_sub_category_scope_id' => 8,
                'name' => 'การตรวจในขั้นก่อนตรวจปล่อย,การตรวจในขั้นตรวจปล่อยในรายการต่อไปนี้'  
            ],
            [
                'ib_sub_category_scope_id' => 9,
                'name' => 'การตรวจลักษณะทั่วไป,ปริมาณทั้งนี้ไม่รวมผลวิเคราะห์ในห้องปฏิบัติการ'  
            ],
            [
                'ib_sub_category_scope_id' => 10,
                'name' => 'การตรวจสอบสภาพทั่วไป,การสุ่มตัวอย่าง,การสังเกตการณ์การชั่งน้ำหนัก'  
            ],
            [
                'ib_sub_category_scope_id' => 11,
                'name' => 'การสังเกตการณ์การชั่งน้ําหนัก,การเก็บตัวอย่างสินค้าชนิดเทกอง'  
            ],
            [
                'ib_sub_category_scope_id' => 12,
                'name' => 'การสังเกตการณ์การชั่งน้ำหนัก,การเก็บตัวอย่างสินค้าชนิดเทกอง'  
            ],
            [
                'ib_sub_category_scope_id' => 13,
                'name' => 'การตรวจลักษณะทั่วไป,การตรวจปริมาณ,การตรวจน้ำหนัก,การสุ่มเก็บตัวอย่าง,ทั้งนี้ไม่รวมถึงผลวิเคราะห์ในห้องปฏิบัติการ'  
            ],
            [
                'ib_sub_category_scope_id' => 14,
                'name' => 'การตรวจลักษณะทั่วไป,การสังเกตการณ์การชั่งน้ำหนัก,การเก็บตัวอย่างสินค้า,ทั้งนี้ไม่รวมการรมยาและการตรวจความสะอาด'  
            ],
            [
                'ib_sub_category_scope_id' => 15,
                'name' => 'การตรวจในขั้นก่อนตรวจปล่อยและขั้นตรวจปล่อย ในรายการต่อไปนี้'  
            ],
          

        ]);
    }
}
