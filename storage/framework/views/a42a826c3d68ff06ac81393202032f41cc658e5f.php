<?php $__env->startPush('css'); ?>
<link href="<?php echo e(asset('plugins/components/icheck/skins/all.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
 <div class="container-fluid">
     <div class="row">
        <div class="col-md-12">
           <div class="white-box">
           <h3 class="box-title pull-left"> ยื่นคำขอรับใบรับรองระบบงาน 
            <?php if($certi_lab->certi_auditors_many->count() > $certi_lab->fullyApprovedAuditorNoCancels->count()): ?>
            <span class="text-danger">(รอดำเนินการ <?php echo e($certi_lab->certi_auditors_many->count() - $certi_lab->fullyApprovedAuditorNoCancels->count()); ?> คณะ)</span> 
            <?php endif; ?>
            
        
        </h3>

                <a class="btn btn-danger text-white pull-right" href="<?php echo e(url('certify/applicant')); ?>">
                        <i class="icon-arrow-left-circle"></i> กลับ
                </a>

                <div class="clearfix"></div>
                <hr>
 
    


 
 <?php echo Form::open(['url' => 'certify/applicant/update/status/auditor/'.$certi_lab->token,
                'class' => 'form-horizontal',
                'method' => 'POST',
                'id'=>'form_auditor', 
                'files' => true]); ?>

 <div class="row form-group">
     <div class="col-md-12">
         <div class="white-box" style="border: 2px solid #e5ebec;">
         <legend><h3>ขอความเห็นแต่งตั้งคณะผู้ตรวจประเมิน</h3></legend>
         <div class="container-fluid">
     
 

 <?php
    // สร้างตัวแปรเก็บรายการที่ status == 1
    $approvedAuditors = $certi_lab->fullyApprovedAuditorNoCancels->filter(function ($item) {
        return $item->status != 1;
    })->values()->all(); // filter เฉพาะรายการที่ status == 1 และ reset keys
?>

 <?php $__currentLoopData = $certi_lab->fullyApprovedAuditorNoCancels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
       

<div class="row">
     <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend><h3><?php echo e($item->auditor ?? null); ?></h3></legend>

            <?php if($item->status == null): ?>   
                <input type="hidden" name="auditors_id[]" id="auditors_id" value="<?php echo e($item->id ?? null); ?>">                 
                <div class="row">
                    <div class="col-md-5 text-right">
                        <p >เห็นชอบกับการแต่งตั้งคณะผู้ตรวจประเมินที่เสนอมา :</p>
                    </div>
                    <div class="col-md-7">
                        <label><?php echo Form::radio('status['.$item->id.']', '1', true, ['class'=>'check status', 'data-radio'=>'iradio_square-green']); ?> &nbsp;เห็นชอบดำเนินการแต่งตั้งคณะผู้ตรวจประเมินต่อไป &nbsp;</label>
                        <br>
                        <label><?php echo Form::radio('status['.$item->id.']', '2', false, ['class'=>'check status', 'data-radio'=>'iradio_square-red']); ?> &nbsp;ไม่เห็นชอบ เพราะ  &nbsp;</label>
                    </div>
                </div>
                <div  style="display: none" class="notAccept hide"  id="notAccept">
                    <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-7">
                            <label for="remark">หมายเหตุ :</label>
                            <textarea name="remark[<?php echo e($item->id); ?>]" id="remark" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row m-t-20">
                        <div class="col-md-5"></div>
                        <div class="col-md-7">
                            <?php echo Form::label('another_modal_attach_files', 'ไฟล์แนบ (ถ้ามี):', ['class' => 'm-t-5']); ?>

                            <button type="button" class="btn btn-sm btn-success m-l-10  form-group attach-add" data-attach="<?php echo e($item->id); ?>">
                                <i class="icon-plus"></i>&nbsp;เพิ่ม
                            </button>
                                                
                            <div id="attach-box<?php echo e($item->id); ?>">
                                <div class="form-group other_attach_item">
                                    <div class="col-md-5">
                                        <?php echo Form::text('file_desc['.$item->id.'][]', null, ['class' => 'form-control ', 'placeholder' => 'ชื่อไฟล์']); ?>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="fileinput fileinput-new input-group " data-provides="fileinput">
                                            <div class="form-control" data-trigger="fileinput">
                                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                <span class="fileinput-filename"></span>
                                            </div>
                                            <span class="input-group-addon btn btn-default btn-file">
                                            <span class="fileinput-new">เลือกไฟล์</span>
                                            <span class="fileinput-exists">เปลี่ยน</span>
                                                <input type="file" name="another_modal_attach_files[<?php echo e($item->id); ?>][]" class="  check_max_size_file">
                                            </span>
                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-left " style="margin-top: 3px">
                                        <div class="button_remove"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            <?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel block4">
            <div class="panel  <?php echo e($item->status == 1 ? 'panel-info' : 'panel-danger'); ?>">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            
                            <a data-toggle="collapse" data-parent="#accordion<?php echo e($key +1); ?>" href="#collapse<?php echo e($key +1); ?>"> <dd>รายละเอียด <?php echo e($item->auditor ?? null); ?>  </dd>  </a>
                        </h4>
                    </div>
                  
<div id="collapse<?php echo e($key +1); ?>" class="panel-collapse collapse">   
<br>
<?php $__currentLoopData = $item->CertificateHistorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1 => $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 
<div class="row form-group">
    <div class="col-md-12">
       <div class="white-box" style="border: 2px solid #e5ebec;">
           <legend><h3> ครั้งที่ <?php echo e($key1 +1); ?> </h3></legend>
           <div class="container-fluid">

            <?php if(isset($log->details_one)): ?>
                <div class="row">
                    <div class="col-md-4 text-right">
                        <p >ชื่อคณะผู้ตรวจประเมิน :</p>
                    </div>
                    <div class="col-md-8">
                    <span><?php echo e($log->details_one ?? '-'); ?></span>
                    </div>
                </div>
            <?php endif; ?>

    <div class="row">
        <div class="col-md-4 text-right">
        <p >วันที่ตรวจประเมิน</p>
        </div>
        <div class="col-md-8">
        <span><?php echo $log->DataBoardAuditorDateTitle ?? '-'; ?></span>
        </div>
    </div>

    <?php if(!is_null($log->attachs)): ?>
        <div class="row">
            <div class="col-md-4 text-right">
            <p >กำหนดการตรวจประเมิน</p>
            </div>
            <div class="col-md-8">
                <a href="<?php echo e(url('certify/check/file_client/'.$log->attachs.'/'.( !empty($log->attach_client_name) ? $log->attach_client_name : basename($log->attachs) ))); ?>" target="_blank">
                    <?php echo HP::FileExtension($log->attachs)  ?? ''; ?>

                </a>
            </div>
        </div>
    <?php endif; ?>
<div class="col-md-12">
    <label>โดยคณะผู้ตรวจประเมิน มีรายนามดังต่อไปนี้</label>
 </div>
<?php if(!is_null($log->details_table)): ?>
<div class="col-md-12">
<table class="table table-bordered">
    <thead class="bg-primary">
    <tr>
        <th class="text-center text-white" width="2%">ลำดับ</th>
        <th class="text-center text-white" width="30%">สถานะผู้ตรวจประเมิน</th>
        <th class="text-center text-white" width="40%">ชื่อผู้ตรวจประเมิน</th>
        <th class="text-center  text-white" width="26%">หน่วยงาน</th>
    </tr>
    </thead>
    <tbody>
         <?php
           $groups = json_decode($log->details_table);
         ?>
          <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2 => $item2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                 $status = App\Models\Bcertify\StatusAuditor::where('id',$item2->status)->first();
            ?>
          <tr>
              <td  class="text-center"><?php echo e($key2 +1); ?></td>
              <td> <?php echo e($status->title ?? '-'); ?></td>
              <td >
                <?php if(count($item2->temp_users) > 0): ?> 
                    <?php $__currentLoopData = $item2->temp_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key3 => $item3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p><?php echo e($item3 ?? '-'); ?></p>
                        
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
              </td>
              <td >
                <?php if(count($item2->temp_departments) > 0): ?> 
                    <?php $__currentLoopData = $item2->temp_departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key4 => $item4): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <p><?php echo e($item4 ?? '-'); ?></p>  
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
              </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
</div>
<?php endif; ?>

<?php if(!is_null($log->details_cost_confirm)): ?>
<?php
  $details_cost_confirm = json_decode($log->details_cost_confirm);
?>
<div class="col-md-12">
  <label>ประมาณค่าใช้จ่าย</label>
</div>
<div class="col-md-12">
<table class="table table-bordered">
  <thead class="bg-primary">
  <tr>
      <th class="text-center text-white" width="2%">ลำดับ</th>
      <th class="text-center text-white" width="38%">รายละเอียด</th>
      <th class="text-center text-white" width="20%">จำนวนเงิน (บาท)</th>
      <th class="text-center text-white" width="20%">จำนวนวัน (วัน)</th>
      <th class="text-center text-white" width="20%">รวม (บาท)</th>
  </tr>
  </thead>
  <tbody>
        <?php    
        $SumAmount = 0;
        ?>
      <?php $__currentLoopData = $details_cost_confirm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php     
          $amount_date = !empty($item3->amount_date) ? $item3->amount_date : 0 ;
          $amount = !empty($item3->amount) ? $item3->amount : 0 ;
          $sum =   $amount*$amount_date;
          $SumAmount  +=  $sum;
          $details = App\Models\Bcertify\StatusAuditor::where('id',$item3->desc)->first();
          ?>
          <tr>
              <td class="text-center"><?php echo e($key+1); ?></td>
              <td><?php echo e(!is_null($details) ? $details->title : null); ?></td>
              <td class="text-right"><?php echo e(number_format($amount, 2)); ?></td>
              <td class="text-right"><?php echo e($amount_date); ?></td>
              <td class="text-right"><?php echo e(number_format($sum, 2) ?? '-'); ?></td>
          </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
  <footer>
      <tr>
          <td colspan="4" class="text-right">รวม</td>
          <td class="text-right">
               <?php echo e(!empty($SumAmount) ?  number_format($SumAmount, 2) : '-'); ?> 
          </td>
      </tr>
  </footer>
</table>
</div>
<?php endif; ?>


<?php if(!is_null($log->status)): ?>
<div class="col-md-12">
    <div class="form-group <?php echo e($errors->has('no') ? 'has-error' : ''); ?>">
        <?php echo Form::label('no', 'กำหนดการตรวจประเมิน :', ['class' => 'col-md-4 control-label text-right']); ?>

        <div class="col-md-8">
            <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-green" <?php echo e(($log->status == 1 ) ? 'checked' : ' '); ?>>  &nbsp;เห็นชอบดำเนินการแต่งตั้งคณะผู้ตรวจประเมินต่อไป &nbsp;</label>
            <br>
            <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-red" <?php echo e(($log->status == 2 ) ? 'checked' : ' '); ?>>  &nbsp;ไม่เห็นชอบ เพราะ  &nbsp;</label>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if(!is_null($log->remark)): ?>
<div class="col-md-12">
    <div class="form-group <?php echo e($errors->has('no') ? 'has-error' : ''); ?>">
        <?php echo Form::label('no', 'หมายเหตุ :', ['class' => 'col-md-4 control-label text-right']); ?>

        <div class="col-md-8">
            <?php echo e(@$log->remark  ?? '-'); ?>

        </div>
    </div>
</div>
<?php endif; ?>
<?php if(!is_null($log->attachs_file)): ?>
<?php 
    $attachs_file = json_decode($log->attachs_file);
?> 
 <div class="col-md-12">
    <?php echo Form::label('no', 'หลักฐาน :', ['class' => 'col-md-4 control-label text-right']); ?>

<div class="col-md-8">
    <?php $__currentLoopData = $attachs_file; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $files): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <p> 
                <?php echo e(@$files->file_desc); ?>

                <a href="<?php echo e(url('certify/check/file_client/'.$files->file.'/'.( !empty($files->file_client_name) ? $log->file_client_name :  basename($files->file) ))); ?>" target="_blank">
                    <?php echo HP::FileExtension($files->file)  ?? ''; ?>

                </a>
            </p>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
</div>
<?php endif; ?>

<?php if(!is_null($log->date)): ?>
<div class="col-md-12">
    <div class="form-group <?php echo e($errors->has('no') ? 'has-error' : ''); ?>" target="_blank">
        <?php echo Form::label('no', 'วันที่บันทึก :', ['class' => 'col-md-4 control-label text-right']); ?>

        <div class="col-md-8">
            <?php echo e(HP::DateThai($log->date)  ?? '-'); ?>

        </div>
    </div>
</div>
<?php endif; ?>

            </div>
        </div>
    </div>
</div>             
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

                </div>
            </div>
        </div>
    </div>
</div>

        </div>
     </div>
</div>

 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
 <?php if(count($certi_lab->certi_auditors_null_many) > 0): ?>        
<div class="col-md-12">
    <div class="row">
        <div class="col-md-5 text-right">
            <p >วันที่บันทึก :</p>
        </div>
        <div class="col-md-7" >
            <?php echo e(HP::DateThai(date('Y-m-d'))); ?>

        </div>
    </div>
 </div> 
             
<input type="hidden" name="previousUrl" id="previousUrl" value="<?php echo e($previousUrl ?? null); ?>">

<?php if(count($approvedAuditors) != 0): ?>
<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <button class="btn btn-primary" type="submit"  onclick="submit_form();return false;">
            <i class="fa fa-paper-plane"></i>  บันทึก 
        </button>
        <a class="btn btn-default" href="<?php echo e(url("$previousUrl")); ?>">
             <i class="fa fa-rotate-left"></i> ยกเลิก
        </a>
    </div>
</div>
<?php endif; ?>

 
 <?php else: ?> 
 <a  href="<?php echo e(url("$previousUrl")); ?>">
 <div class="alert alert-dark text-center" role="alert">
    <i class="icon-arrow-left-circle"></i>
     <b>กลับ</b>
 </div>
 </a>
 <?php endif; ?>          

           </div>
        </div>
    </div>
 </div>
 <?php echo Form::close(); ?>


            </div>  
         </div>  
    </div>
</div>   
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
        <script src="<?php echo e(asset('plugins/components/icheck/icheck.min.js')); ?>"></script>
        <script src="<?php echo e(asset('plugins/components/icheck/icheck.init.js')); ?>"></script>

        <script src="<?php echo e(asset('js/jasny-bootstrap.js')); ?>"></script>
        <script src="<?php echo e(asset('plugins/components/sweet-alert2/sweetalert2.all.min.js')); ?>"></script>
 <script type="text/javascript">
                  function  submit_form(){
            Swal.fire({
                title: 'ยืนยันทำรายการ !',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'บันทึก',
                cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.value) {
                        $('#form_auditor').submit();
                    }
                })
           }
            $(document).ready(function() {
              //Validate
                 $('#form_auditor').parsley().on('field:validated', function() {
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
<script type="text/javascript">
        jQuery(document).ready(function() {
            $('.check-readonly').prop('disabled', true); 
            $('.check-readonly').parent().removeClass('disabled');
            $('.check-readonly').parent().css({"background-color": "rgb(238, 238, 238);","border-radius":"50%"});
        //เพิ่มไฟล์แนบ
 
            $('.attach-add').click(function(event) {
                var box = $(this).next();
                let attach = $(this).data('attach');
                box.find('.other_attach_item:first').clone().appendTo('#attach-box'+attach);
                box.find('.other_attach_item:last').find('input').val('');
                box.find('.other_attach_item:last').find('a.fileinput-exists').click();
                box.find('.other_attach_item:last').find('a.view-attach').remove();
                box.find('.other_attach_item:last').find('.button_remove').html('<button class="btn btn-danger btn-sm attach-remove" type="button"> <i class="icon-close"></i>  </button>');
                check_max_size_file();
            });
            
           //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove', function(event) {
                $(this).parent().parent().parent().remove();
            });
 
           $(".status").on("ifChanged",function(){
 
               if($(this).is(':checked') && $(this).val() == 2){
                let row = $(this).parent().parent().parent().parent().parent();
                    row.find('.notAccept').removeClass('hide').addClass('show');
               }else{
                let row = $(this).parent().parent().parent().parent().parent();
                    row.find('.notAccept').removeClass('show').addClass('hide');
               }
            
            });  
  });
</script>       
  <?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>