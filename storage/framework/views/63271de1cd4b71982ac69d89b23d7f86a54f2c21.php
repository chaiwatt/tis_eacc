
<style>
    tr {
        padding: 0;
    }
    td {
        padding: 0;
    }
    .table-one {
        margin-left: 3px;    
    }
    .table-two {
        margin-left: 5px
    }
    .table-three {
        margin-left: 5px
    }
    .table-four {
        margin-left: 5px
    }
</style>
    <?php
        if (!function_exists('formatRangeWithSpecialChars')) {
            function formatRangeWithSpecialChars($range) {
                $result = '';
                $chars = mb_str_split($range, 1, 'UTF-8'); // แยก string เป็นตัวอักษร UTF-8

                foreach ($chars as $char) {
                    // รายการอักขระพิเศษทางวิทยาศาสตร์/คณิตศาสตร์ (เพิ่มได้ตามต้องการ)
                    $scientificChars = ['Ω', 'π', 'Σ', 'β', 'α', 'γ', 'µ', '±', '∞', 'θ', 'δ','ξ', 'φ', 'χ', 'ψ', 'ω', 'ε','Δ','√', '∮', '∫', '∂', '∇', '∑', '∏', '∆','λ', 'ω', 'σ','ρ','℃','℉','Ξ'];
                    
                    // ตรวจสอบว่าตัวอักษรนี้เป็นอักขระพิเศษทางวิทยาศาสตร์หรือไม่
                    if (in_array($char, $scientificChars)) {
                        // ห่ออักขระพิเศษด้วย <span>
                        $result .= '<span style="font-family: DejaVuSans; font-size: 14px;">' . htmlspecialchars($char, ENT_QUOTES, 'UTF-8') . '</span>';
                    } else {
                        // ตัวอักษรปกติ ไม่ต้องห่อ
                        $result .= htmlspecialchars($char, ENT_QUOTES, 'UTF-8');
                    }
                }

                return $result;
            }
        }
    ?>

<table width="100%"  cellspacing="0" cellpadding="5" >
    <tbody>
        <?php
            $previousCategoryTh = null;
        ?>
        
        <?php $__currentLoopData = $scopes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                
                <td style="vertical-align: top; width:15%; padding-bottom: 90px; padding-left:5px; font-size:22px">
                    <span <?php if($key != 0 && $item->category_th === $previousCategoryTh): ?>
                            style="visibility: hidden"
                          <?php endif; ?>>
                        สาขา<?php echo $item->category_th; ?> <br>
                        <span style="font-size: 16px">(<?php echo $item->category; ?> field)</span>
                    </span>
                </td>
                <td style="vertical-align: top;width:25%">
                    <table class="table-one" cellspacing="0" width="100%" style="padding-right: 1px"  >
                        <tr>
                            <td style="padding-left: 0px" >
                                <span style="margin-top:5px"><?php echo $item->instrument; ?></span><span style="font-size:1px;visibility: hidden">*<?php echo e($key); ?>*</span>
                                <?php if($item->instrument !== ""): ?>
                                    <span><br><?php echo $item->instrument_two; ?> </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table class="table-two" cellspacing="0"  width="100%" >

                                    <?php if(!empty($item->description)): ?>
                                        <tr><td><span><?php echo $item->description; ?></span></td></tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td style="<?php if($item->description !== ''): ?> margin-left:15px <?php endif; ?>">
                                            <table class="table-three" cellspacing="0"  width="100%">
                                                <?php $__currentLoopData = $item->measurement_edit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $measurement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td style="<?php if($i > 0): ?> padding-top: 15px; <?php endif; ?>">
                                                            <span><?php echo $measurement['name']; ?></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="table-four" cellspacing="0" width="100%" style="margin-left:0px;padding-right:3px">
                                                                <?php $__currentLoopData = $measurement['ranges']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $description_i => $range): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if(!empty($description_i)): ?>
                                                                    <tr>
                                                                        <td style="<?php if($loop->index > 0): ?> padding-top: 15px; <?php endif; ?>">
                                                                            <span><?php echo $description_i; ?></span> <!-- แสดงชื่อคีย์ เช่น "Nominal", "Ultraviolet at 257 nm" -->
                                                                        </td>
                                                                    </tr>
                                                                <?php endif; ?>

                                                                <tr>
                                                                    <td style="padding-left: 7px">
                                                                        <?php $__currentLoopData = $range['ranges']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $range): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <span><?php echo formatRangeWithSpecialChars($range); ?></span><br>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </td>
                                                                </tr>

                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>

        
               <td style="vertical-align: top;width:25%">
                    <table class="table-one" cellspacing="0" width="100%"  style="padding-right: 1px">
                        <tr>
                            <td style="padding-left: 0px">
                                <span style="visibility: hidden;margin-top:5px"><?php echo $item->instrument; ?></span><span style="font-size:1px;visibility: hidden">*<?php echo e($key); ?>*</span>
                                <?php if($item->instrument !== ""): ?>
                                    <span style="visibility: hidden;"><br><?php echo $item->instrument_two; ?> </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table class="table-two" cellspacing="0"  width="100%">
                                    <?php if(!empty($item->description)): ?>
                                        <tr><td><span style="visibility: hidden;"><?php echo $item->description; ?></span></td></tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td style="<?php if($item->description !== ''): ?> margin-left:15px <?php endif; ?>">
                                            <table class="table-three" cellspacing="0"  width="100%">
                                                <?php $__currentLoopData = $item->measurement_edit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j => $measurement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td style="<?php if($j > 0): ?> padding-top: 15px; <?php endif; ?>">
                                                            <span style="visibility: hidden;"><?php echo $measurement['name']; ?></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="table-four" cellspacing="0" width="100%" style="margin-left:0px;text-align: center;padding-right:3px">
                                                                <?php $__currentLoopData = $measurement['ranges']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $description_j => $range): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if(!empty($description_j)): ?>
                                                                    <tr>
                                                                        <td style="<?php if($loop->index > 0): ?> padding-top: 15px; <?php endif; ?>">
                                                                            <span style="visibility: hidden;"><?php echo $description_j; ?></span> <!-- แสดงชื่อคีย์ เช่น "Nominal", "Ultraviolet at 257 nm" -->
                                                                        </td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                                <tr>
                                                                    <td style="padding-left: 7px">
                                                                        <?php $__currentLoopData = $range['uncertainties']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uncertain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                             <?php if(preg_match('/\.(png|jpg|jpeg|gif)$/i', $uncertain)): ?>
                                                                                <span  style="padding-left: 0px">
                                                                                    <span> <img src="<?php echo e(public_path('uploads/files/applicants/check_files/' . basename($uncertain))); ?>" style="width: 160px" alt=""> </span><br>
                                                                                </span>
                                                                            <?php else: ?>
                                                                                <span><?php echo $uncertain; ?></span><br> 
                                                                            <?php endif; ?>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </td>
                                                                </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td> 
                <td style="vertical-align: top;width:25%">
                    <table class="table-one" cellspacing="0" width="100%"  style="padding-right: 1px">
                        <tr>
                            <td style="padding-left: 0px">
                                <span style="visibility: hidden;margin-top:5px"><?php echo $item->instrument; ?></span><span style="font-size:1px;visibility: hidden">*<?php echo e($key); ?>*</span>
                                <?php if($item->instrument !== ""): ?>
                                    <span style="visibility: hidden;"><br><?php echo $item->instrument_two; ?> </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table class="table-two" cellspacing="0"  width="100%">
                                    <?php if(!empty($item->description)): ?>
                                        <tr><td><span style="visibility: hidden;"><?php echo $item->description; ?></span></td></tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td style="<?php if($item->description !== ''): ?> margin-left:15px <?php endif; ?>">
                                            <table class="table-three" cellspacing="0"  width="100%">
                                                <?php $__currentLoopData = $item->measurement_edit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $measurement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                       
                                                        <?php if($k == 0): ?>
                                                                <td style="<?php if($k > 0): ?> padding-top: 15px; <?php endif; ?>">
                                                                    <span ><?php echo $item->standard; ?></span>
                                                                </td>
                                                            <?php else: ?>
                                                            <td style="<?php if($k > 0): ?> padding-top: 15px; <?php endif; ?>">
                                                                <span ><?php echo $item->standard; ?></span>
                                                            </td>
                                                        <?php endif; ?>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="table-four" cellspacing="0" width="100%" style="margin-left:0px;text-align: center;padding-right:3px">
                                                                <?php $__currentLoopData = $measurement['ranges']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $description_k => $range): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if(!empty($description_k)): ?>
                                                                    <tr>
                                                                        <td style="<?php if($loop->index > 0): ?> padding-top: 15px; <?php endif; ?>">
                                                                            <span style="visibility: hidden;"><?php echo $description_k; ?></span> <!-- แสดงชื่อคีย์ เช่น "Nominal", "Ultraviolet at 257 nm" -->
                                                                        </td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                                <tr>
                                                                    <td style="padding-left: 7px">
                                                                        <?php $__currentLoopData = $range['ranges']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $range): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <span  style="visibility: hidden;"><?php echo $range; ?></span><br>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </td>
                                                                </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td> 
            </tr>
            <?php
                $previousCategoryTh = $item->category_th; // อัพเดทค่า category_th สำหรับแถวถัดไป
            ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    </tbody>
</table>




