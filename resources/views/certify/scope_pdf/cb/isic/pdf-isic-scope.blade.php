<style>
    .isic-table {
        width: 690px;
        border-collapse: collapse;
        font-family: "TH Sarabun New", sans-serif;
        font-size: 16px;
    }
    .isic-table th, .isic-table td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }
    .isic-table th {
        background-color: #f2f2f2;
        font-weight: bold;
        text-align: center;
        font-size: 20px;
    }

    .isic-code {
        width: 20%;
        text-align: center;
        font-weight: bold;
    }
    .description {
        width: 80%;
    }
    .sub-text {
        font-size: 14px;
        font-style: italic;
    }
</style>

    <table class="isic-table" style="margin-top: 20px">
        <tr>
            <th class="isic-code">รหัส ISIC<br><span style="font-size: 16px; font-weight: normal;">(ISIC Codes)</span></th>
            <th class="description">กิจกรรม<br><span style="font-size: 16px; font-weight: normal;">(Description)</span></th>
        </tr>
   
        @foreach ($cbScopeIsicTransactions as $key => $cbScopeIsicTransaction)
            <tr>
                @php
                    // $subCategoryCodesFiltered ="";
                    // $categoryCodes = "";
                    // // กรองรายการที่ is_checked = 0
                    // $filteredCategoryTransactions = $cbScopeIsicTransaction->cbScopeIsicCategoryTransactions->where('is_checked', 0);
                    
                    // // สร้าง $categoryCodes สำหรับ category_code ที่เติม 0 ทางซ้ายให้เป็น 3 หลัก
                    // $categoryCodes = $filteredCategoryTransactions->map(function($categoryTransaction) {
                    //     return str_pad($categoryTransaction->cbScopeIsicCategory->category_code, 3, '0', STR_PAD_LEFT);
                    // })->implode(', ');

                    // // กรองรายการที่ is_checked = 1
                    // $filteredCategoryTransactions = $cbScopeIsicTransaction->cbScopeIsicCategoryTransactions->where('is_checked', 1);

                    // // สร้าง $subCategoryCodesFiltered โดยไม่ทับซ้อนตัวแปร
                    // $subCategoryCodesFiltered = $filteredCategoryTransactions->flatMap(function($categoryTransaction) {
                    //     // กรอง subCategoryTransactions ที่ is_checked = 0
                    //     return $categoryTransaction->cbScopeIsicSubCategoryTransactions->filter(function($subCategoryTransaction) {
                    //         return $subCategoryTransaction->is_checked == 0;
                    //     })->map(function($subCategoryTransaction) {
                    //         // เติม 0 ให้เป็น 4 หลัก
                    //         return str_pad($subCategoryTransaction->cbScopeIsicSubCategory->sub_category_code, 4, '0', STR_PAD_LEFT);
                    //     });
                    // })->implode(', ');

                    $categoryCodes = "";
                    $subCategoryCodesFiltered = "";

                    // กรองรายการที่ is_checked = 0
                    $filteredCategoryTransactions = $cbScopeIsicTransaction->cbScopeIsicCategoryTransactions->where('is_checked', 0);

                    // สร้าง $categoryCodes สำหรับ category_code ที่เติม 0 ทางซ้ายให้เป็น 3 หลัก
                    $categoryCodes = $filteredCategoryTransactions->map(function($categoryTransaction) {
                        return str_pad($categoryTransaction->cbScopeIsicCategory->category_code, 3, '0', STR_PAD_LEFT);
                    })->implode(', ');

                    // กรองรายการที่ is_checked = 1
                    $filteredCategoryTransactions = $cbScopeIsicTransaction->cbScopeIsicCategoryTransactions->where('is_checked', 1);

                    // สร้าง $subCategoryCodesFiltered โดยไม่ทับซ้อนตัวแปร
                    $subCategoryCodesFiltered = $filteredCategoryTransactions->flatMap(function($categoryTransaction) {
                        // กรอง subCategoryTransactions ที่ is_checked = 0
                        return $categoryTransaction->cbScopeIsicSubCategoryTransactions->filter(function($subCategoryTransaction) {
                            return $subCategoryTransaction->is_checked == 0;
                        })->map(function($subCategoryTransaction) {
                            // เติม 0 ให้เป็น 4 หลัก
                            return str_pad($subCategoryTransaction->cbScopeIsicSubCategory->sub_category_code, 4, '0', STR_PAD_LEFT);
                        });
                    })->implode(', ');

                    // รวม $categoryCodes และ $subCategoryCodesFiltered ใส่คอมมา
                    $combinedCodes = $categoryCodes . ($categoryCodes && $subCategoryCodesFiltered ? ', ' : '') . $subCategoryCodesFiltered;

                @endphp

                <td class="isic-code" style="text-align: center;font-size:22px; font-weight: normal;">{{$cbScopeIsicTransaction->isic->isic_code}} 

                    @if ($combinedCodes != "" )
                    <br> (ยกเว้น {{$combinedCodes}} )
                    @endif

                     <span style="font-size: 0.01px">*{{$key}}*</span>
                </td>
                <td class="description" style="font-size:22px">
                    {{$cbScopeIsicTransaction->isic->description_th}}<br>
                    <span class="sub-text">({{$cbScopeIsicTransaction->isic->description_en}})</span>
                </td>
            </tr>
        @endforeach
    </table>

    {{-- <table style="margin-top: 30px">
        <tr>
            <td style="width: 62%"></td>
            <td>
                <div >
                    <span style="font-size:22px">ตั้งแต่ วันที่ ๑๓ กันยายน พ.ศ. ๒๕๖๖</span><br>
                    <span style="font-size:18px">(Valid from) 13 September B.E. 2566 (2023)</span><br>
                    <span style="font-size:22px">ถึงวันที่ วันที่ ๑๑ มิถุนายน พ.ศ. ๒๕๗๑</span><br>
                    <span style="font-size:18px">(Valid from) ๑๑ June B.E. 2571 (2028)</span><br>
                    <span style="font-size:22px">ออกให้ ณ วันที่ ๑๓ กันยายน พ.ศ. ๒๕๖๖</span><br>
                    <span style="font-size:18px">(Valid from) 13 September B.E. 2566 (2023)</span>
                </div>
            </td>
        </tr>
    </table> --}}
    
</div>
