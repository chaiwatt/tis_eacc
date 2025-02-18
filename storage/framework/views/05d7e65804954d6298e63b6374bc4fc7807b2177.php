<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>" rel="stylesheet" type="text/css" />
    <style>
        .table>tbody>tr>td ,label{
            line-height: 1.7;
            color: #5f5f5f;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                   <h3 class="box-title pull-left">คำขอรับบริการห้องปฏิบัติการ (LAB)
                  
                    <?php if($labCalRequest->count() == 0 && $labTestRequest->count() ==0): ?>
                        <span class="text-warning">(คำขอระบบเก่า)</span>
                    <?php endif; ?>


                   </h3>
                    
                    
                    <a class="btn btn-danger text-white pull-right" href="<?php echo e(url('certify/applicant')); ?>">
                        <i class="icon-arrow-left-circle"></i> กลับ
                    </a>
                    
                    <div class="clearfix"></div>
                    <hr>
                    <?php if($errors->any()): ?>
                        <ul class="alert alert-danger">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php endif; ?>
                    <?php echo Form::model($certi_lab, [
                        'method' => 'post',
                        'url' => ['/certify/applicant/update', $certi_lab->token],
                        'class' => 'form-horizontal',
                        'files' => true,
                        'id'=>'app_certi_form',
                    ]); ?>

                    <div class="row" id="box-readonly">

                            

                            <?php echo $__env->make('certify.applicant.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                            <div id="status_btn"></div>

                            <div class="col-md-12">
                                <a  href="<?php echo e(url('certify/applicant')); ?>">
                                    <div class="alert alert-dark text-center" role="alert">
                                        <b>กลับ</b>
                                    </div>
                                </a>
                            </div>
                            <div class="clearfix"></div>
                    </div>
                    <?php echo Form::close(); ?>



                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>





    <script>
        jQuery(document).ready(function() {

            $('#box-readonly').find('input, select, textarea').prop('disabled', true);
            $('#box-readonly').find('button').remove();
            $('#box-readonly').find('.box_remove_file').remove();
            $('#show_add_address').remove();
            $('#show_map').remove();
            
      

            
           // จัดการข้อมูลในกล่องคำขอ false
            //   $('#box-readonly').find('button[type="submit"]').remove();
            //   $('#box-readonly').find('.icon-close').parent().remove();
            //   $('#box-readonly').find('.fa-copy').parent().remove();
            //   $('#box-readonly').find('.hide_attach').hide();
            //   $('#box-readonly').find('input').prop('disabled', true);
            //   $('#box-readonly').find('input').prop('disabled', true);
            //   $('#box-readonly').find('textarea').prop('disabled', true);
            //   $('#box-readonly').find('select').prop('disabled', true);
            //   $('#box-readonly').find('.bootstrap-tagsinput').prop('disabled', true);
            //   $('#box-readonly').find('span.tag').children('span[data-role="remove"]').remove();
            //   $('#box-readonly').find('button').prop('disabled', true);
            //   $('#box-readonly').find('button').remove();
            //   $('#box-readonly').find('button').remove();
            // $('body').on('click', '.attach-remove', function() {
            //     $(this).parent().parent().parent().find('input[type=hidden]').val('');
            //     $(this).parent().remove();
            // });
        });
    </script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>