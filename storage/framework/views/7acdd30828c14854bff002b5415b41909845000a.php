
<input type="text" id="lab_addresses_input" name="lab_addresses" />
<input type="text" id="lab_main_address_input" name="lab_main_address" />
<div >
    <div class="clearfix"></div>
    <hr>
    <legend><h4>สำนักงานสาขา (กรณีต้องการขอรับบริการมากกว่า 1 สำนักงาน)</h4>     </legend>  
    <div class="form-group">
        <?php echo HTML::decode(Form::label('', '',['class' => 'col-md-5 control-label label-height'])); ?>

        <div class="col-md-12">
            <span class="pull-left text-warning" ><i>สำนักงานสาขาสามารถกำหนดประเภทสถานปฏิบัติการของห้องปฏิบัติการ / ขอบข่ายที่ยื่นขอรับการรับรองอิสระเหมือนหรือแตกต่างสำนักงานใหญ่ได้</i></span>
            <a class="btn btn-info pull-right" id="show_add_address" onclick="return false">
                <i class="icon-plus"></i> เพิ่มสาขา
            </a>
        </div>
    </div>      
            <div class="clearfix"></div>
    <?php if($urlType == 'create'): ?>
        <table class="table table-bordered" id="myTable_labAddress">
            <thead class="bg-primary">
                <tr>
                    <th class="text-center text-white "  width="10%">ลำดับ</th>
                    <th class="text-center text-white "  width="70%">ที่อยู่สาขา</th>
                    <th class="text-center text-white"  width="10%">ลบรายการ</th>
                </tr>
            </thead>
            <tbody id="lab_address_body">

            </tbody>
        </table>
        <?php elseif($urlType == 'show'): ?>

        <table class="table table-bordered">
            <thead class="bg-primary">
                <tr>
                    <th class="text-center text-white "  width="10%">ลำดับ</th>
                    <th class="text-center text-white "  width="70%">ที่อยู่สาขา</th>
                    <th class="text-center text-white"  width="10%">จัดการ</th>
                </tr>
            </thead>
            <tbody id="lab_address_body">
                <?php $__currentLoopData = $branchLabAdresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $branchLabAdresse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-center"><?php echo e($key+1); ?></td>
                        <td>เลขที่ <?php echo e($branchLabAdresse->addr_no); ?> หมู่ที่ <?php echo e($branchLabAdresse->addr_moo); ?> 
                            แขวง/อำเภอ<?php echo e($branchLabAdresse->district->DISTRICT_NAME); ?> เขต/อำเภอ<?php echo e($branchLabAdresse->amphur->AMPHUR_NAME); ?> 
                            จังหวัด<?php echo e($branchLabAdresse->province->PROVINCE_NAME); ?> รหัสไปรษณีย์ <?php echo e($branchLabAdresse->postal); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <?php elseif($urlType == 'edit'): ?>


        <table class="table table-bordered">
            <thead class="bg-primary">
                <tr>
                    <th class="text-center text-white "  width="10%">ลำดับ</th>
                    <th class="text-center text-white "  width="70%">ที่อยู่สาขา</th>
                    <th class="text-center text-white"  width="10%">ลบรายการ</th>
                </tr>
            </thead>
            <tbody id="lab_address_body">
            </tbody>
        </table>

    <?php endif; ?>
            
     
        </div>

