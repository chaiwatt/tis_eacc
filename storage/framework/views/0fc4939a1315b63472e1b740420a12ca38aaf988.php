<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">คำขอรับบริการหน่วยรับรอง (CB) </h3>
                    <?php if( HP::CheckPermission('view-'.str_slug('applicantcbs'))): ?>
                        <a class="btn btn-success pull-right" href="<?php echo e(url("certify/applicant-cb")); ?>" >
                            <i class="icon-arrow-left-circle"></i> กลับ
                        </a>
                    <?php endif; ?>
                    <div class="clearfix"></div>
                    <hr>
                    <?php if($errors->any()): ?>
                        <ul class="alert alert-danger">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php endif; ?>

                    <?php echo Form::open(['url' => '/certify/applicant-cb', 'class' => 'form-horizontal', 'files' => true,'id'=>'app_certi_form']); ?>


                        <?php echo $__env->make('certify.applicant_cb.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        
                        
                        

                        <div class="row form-group">
                            <div class="col-md-12 text-center">
                                <div id="status_btn"></div>
                                <button type="button"class="btn btn-default m-l-5" onclick="submit_form('1');return false" id="send_data" disabled>ส่งข้อมูล</button>
                                <button type="button" class="btn btn-warning text-white m-l-5 " onclick="submit_form_draft('0');return false">ฉบับร่าง</button>
                                <a href="<?php echo e(url("certify/applicant-cb")); ?>"  class="btn btn-danger text-white m-l-5" id="cancel_edit_calibrate">ยกเลิก</a>
                            </div>
                        </div>
                    <?php echo Form::close(); ?>


                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
    <script>



        $(document).ready(function () {
           
            if($('input[name="branch_type"]').val() == 1){
                $('#use_address_office-1').iCheck('check');
            }else{
                $('#use_address_office-2').iCheck('check');
            }

        });
        
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>