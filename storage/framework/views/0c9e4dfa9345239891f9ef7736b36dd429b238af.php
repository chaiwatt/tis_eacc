<!-- Modal เลข 19 -->
<?php $__env->startPush('css'); ?>
    <!-- ===== Parsley js ===== -->
    <link href="<?php echo e(asset('plugins/components/parsleyjs/parsley.css?20200630')); ?>" rel="stylesheet" />
    <?php $__env->stopPush(); ?>


    <div class="modal fade text-left" id="action19<?php echo e($id); ?>" tabindex="-1" role="dialog" aria-labelledby="addBrand">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">
                        แจ้งรายละเอียดการชำระเงินค่าใบรับรอง 
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </h4>
                </div>

                <?php echo Form::open(['url' => 'certify/applicant/update/status/cost/certificate/'.$certificate->id,   'method' => 'POST', 'class' => 'form-horizontal app_certificate_form','files' => true]); ?>

                <?php
                $formula = App\Models\Bcertify\Formula::Where([['applicant_type',3],['state',1]])->first();
                $amount  =  !empty($certificate->amount) ? $certificate->amount :  '0';
                $amount_fee  =  !empty($certificate->amount_fee) ?$certificate->amount_fee :  '0';
                $sum =   ((string)$amount +   (string)$amount_fee);
                // dd($certificate);
              ?>
                <div class="modal-body">
                    <div class="container-fluid">
                        <h3 class="text-center"><span ><?php echo e(HP::formatDateThai($certificate->notification_date) ?? '-'); ?></span></h3>
                        <p>&nbsp;</p>
                        <p>เรียน <span> <?php echo e($applicant->information->name); ?></span></p>
                        <p>เรื่อง <span>แจ้งรายละเอียดการชำระค่าใบรับรอง</span></p>
                        <p style="text-indent: 50px;">ตามที่  <?php echo e($applicant->information->name); ?> ได้แจ้งขอรับบริการการตรวจประเมินความสามารถ 
                            ตามมาตรฐาน มอก. <?php echo e(!is_null($formula)?$formula->title:'-'); ?>  ลงรับวันที่  <?php echo e(!empty($applicant->check->report_date) ?  HP::formatDateThai($applicant->check->report_date) : '-'); ?> </span>นั้น
                        </p>
                        <p style="text-indent: 50px;"> สำนักงานขอให้ท่านชำระค่าใบรับรอง จึงเรียนมาเพื่อโปรดดำเนินการ </p>
           
                        <br>
                        <?php if($certificate->conditional_type == 1): ?> <!--  เรียกเก็บค่าธรรมเนียม -->
                            <p>	ค่าธรรมเนียมคำขอการใบรับรอง สก. :
                                <span style="color:#26ddf5;"><?php echo e(number_format($certificate->amount_fixed,2).' บาท ' ??'0.00'); ?></span>
                            </p>
                            <p>ค่าธรรมเนียมใบรับรอง สก. :
                                <span style="color:#26ddf5;"><?php echo e(number_format($certificate->amount_fee,2).' บาท '  ??'0.00'); ?></span>
                            </p>
                            <p>ใบแจ้งหนี้ค่าธรรมเนียม :
                                <?php if(!is_null($certificate) && !is_null($certificate->attach)): ?>
                                <a href="<?php echo e(url('certify/check/file_client/'. $certificate->attach.'/'.( !empty($certificate->attach_client_name) ? $certificate->attach_client_name : basename($certificate->attach) ))); ?>" target="_blank">
                                    <?php echo HP::FileExtension($certificate->attach)  ?? ''; ?>

                                </a>
                                <?php endif; ?> 
                            </p>
                        <?php elseif($certificate->conditional_type == 2): ?> <!--  ยกเว้นค่าธรรมเนียม -->
                             <p>เอกสารยกเว้นค่าธรรมเนียม :
                                <a href="<?php echo e(url('funtions/get-view-file/'.base64_encode($certificate->attach).'/'.( !empty($certificate->attach_client_name) ? $certificate->attach_client_name : basename($certificate->attach) ))); ?>" target="_blank">
                                    <?php echo HP::FileExtension($certificate->attach)  ?? ''; ?>

                                </a>
                            </p>
                            <?php elseif($certificate->conditional_type == 3): ?> <!--  ชำระเงินนอกระบบ, ไม่เรียกชำระเงิน หรือ กรณีอื่น -->
                            <p>
                                	หมายเหตุ :  <?php echo e(!empty($certificate->remark) ? $certificate->remark: null); ?> 
                            </p>
                            <p>ไฟล์แนบ :
                                <a href="<?php echo e(url('certify/check/file_client/'. $certificate->attach.'/'.( !empty($certificate->attach_client_name) ? $certificate->attach_client_name : basename($certificate->attach) ))); ?>" target="_blank">
                                    <?php echo HP::FileExtension($certificate->attach)  ?? ''; ?>

                                </a>
                            </p>
                        <?php endif; ?>
       
 
                        <br>

                        <div class=" form-group <?php echo e($errors->has('activity_file19') ? 'has-error' : ''); ?>">
                            <label for="activity_file19" class="col-md-12" style="padding-top: 7px;margin-bottom: 13px"><span class="text-danger">*</span> หลักฐานค่าธรรมเนียม :</label>
                            <div class="col-md-10">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn btn-default btn-file">
                                    <span class="fileinput-new">เลือกไฟล์</span>
                                    <span class="fileinput-exists">เปลี่ยน</span>
                                        <input type="file" name="activity_file19"  required class="check_max_size_file">
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                </div>
                                <?php echo $errors->first('activity_file19', '<p class="help-block">:message</p>'); ?>

                            </div>
                        </div>
                    </div>


                    <?php if(!is_null($certificate->detail)): ?>
                         <br>
                        <p>หมายเหตุ :</p>
                        <p>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo e($certificate->detail ?? '-'); ?>

                        </p>
                    <?php endif; ?>


                </div>
                <input type="hidden" name="findCertiLab19" id="findCertiLab19" value="<?php echo e($token); ?>">

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-success" >แจ้งชำระเงิน</button>
                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>

    <!-- ===== PARSLEY JS Validation ===== -->
    <script src="<?php echo e(asset('plugins/components/parsleyjs/parsley.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/components/parsleyjs/language/th.js')); ?>"></script>

<script>
    $(document).ready(function () {
//แจ้งรายละเอียดการชำระเงินค่าใบรับรอง modal 23
$('.app_certificate_form').parsley().on('field:validated', function() {
              var ok = $('.parsley-error').length === 0;
              $('.bs-callout-info').toggleClass('hidden', !ok);
              $('.bs-callout-warning').toggleClass('hidden', ok);
              })
 .on('form:submit', function() {
                  // Text
                  $.LoadingOverlay("show", {
                      image       : "",
                      text        : "กำลังบันทึก กรุณารอสักครู่..."
                  });
              return true; // Don't submit form for this demo
  });
});
</script>
