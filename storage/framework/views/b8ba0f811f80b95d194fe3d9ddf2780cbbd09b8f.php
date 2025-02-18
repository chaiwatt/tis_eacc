<?php $__env->startPush('css'); ?>

    <style>
        .table>tbody>tr>td ,label{
            line-height: 1.7;
            color: #5f5f5f;
        }
         .input_text_color {
            background-color:#ccffcc;
            /* color: white; */
         }

        .input_text_color[readonly]{
            background-color: #ccffcc;
        }
        .modal-xl {
            width: 80%; /* กำหนดความกว้างตามที่คุณต้องการ */
            max-width: none; /* ยกเลิกค่า max-width เริ่มต้น */
        }
        .modal-xxl {
            width: 90%; /* กำหนดความกว้างตามที่คุณต้องการ */
            max-width: none; /* ยกเลิกค่า max-width เริ่มต้น */
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">คำขอรับบริการห้องปฏิบัติการ (LAB)</h3>

                    <a class="btn btn-danger text-white pull-right" href="<?php echo e(url('certify/applicant')); ?>">
                        <i class="icon-arrow-left-circle"></i> กลับ
                    </a>
                    <div class="clearfix"></div>
                    <hr>
                    

                    <?php echo Form::open(['url' => 'certify/applicant/store', 'method' => 'post', 'class' => 'form-horizontal','id'=>'app_certi_form', 'files' => true]); ?>


                                       
                        <?php if($errors->any()): ?>
                            <ul class="alert alert-danger">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>



                        <?php echo $__env->make('certify.applicant.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        <center>
                            <div class="col-md-12 text-center">
                                <div id="status_btn"></div>
                                <button type="button"class="btn btn-default m-l-5" value="ส่งข้อมูล"  name="save" onclick="submit_form('1');return false" disabled>ส่งข้อมูล</button>
                                <button type="button" class="btn btn-warning text-white m-l-5" id="draft" name="draft" value="ฉบับร่าง" onclick="submit_form_draft('0');return false">ฉบับร่าง</button>
                                <a href="<?php echo e(url('certify/applicant')); ?>" class="btn btn-danger text-white m-l-5" id="cancel_edit_calibrate">ยกเลิก</a>
                            </div>
                        </center>
                        
                    <div class="clearfix"></div>

                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('plugins/components/toast-master/js/jquery.toast.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jasny-bootstrap.js')); ?>"></script>
    <script>
        $(document).ready(function () {
            <?php if(\Session::has('flash_message')): ?>
            $.toast({
                heading: 'Success!',
                position: 'top-center',
                text: '<?php echo e(session()->get('flash_message')); ?>',
                loaderBg: '#70b7d6',
                icon: 'success',
                hideAfter: 3000,
                stack: 6
            });
            <?php endif; ?>

        });


    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>