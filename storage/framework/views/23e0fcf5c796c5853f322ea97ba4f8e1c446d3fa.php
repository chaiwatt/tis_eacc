<?php $__env->startPush('css'); ?>
<link href="<?php echo e(asset('plugins/components/icheck/skins/all.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('plugins/components/bootstrap-datepicker-thai/css/datepicker.css')); ?>" rel="stylesheet" type="text/css" />
<style>
    textarea.form-control {
        border-radius: 0 !important;
        border-top: none !important;
        border-bottom: none !important;
        resize: none;
        overflow: hidden; /* ซ่อน scrollbar */
    }
    .no-hover-animate tbody tr:hover {
        background-color: inherit !important; /* ปิดการเปลี่ยนสี background */
        transition: none !important; /* ปิดเอฟเฟกต์การเปลี่ยนแปลง */
    }
    
    /* กำหนดขนาดความกว้างของ SweetAlert2 */
    .custom-swal-popup {
        width: 500px !important;  /* ปรับความกว้างตามต้องการ */
    }
    textarea.non-editable {
        pointer-events: none; /* ทำให้ไม่สามารถคลิกหรือแก้ไขได้ */
        opacity: 0.6; /* กำหนดความทึบของ textarea */
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
 <div class="container-fluid">
     <div class="row">
        <div class="col-md-12">
           <div class="white-box">
           <h3 class="box-title pull-left">ยื่นคำขอรับใบรับรองระบบงาน</h3>

                <a class="btn btn-danger text-white pull-right" href="<?php echo e(app('url')->previous()); ?>">
                        <i class="icon-arrow-left-circle"></i> กลับ
                </a>

                <div class="clearfix"></div>
                <hr>     

<?php if(count($assessment->CertificateHistorys) > 0): ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel block4">
            <div class="panel-group" id="accordion">
                <div class="panel panel-info">

 <div class="panel-heading">
    <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse"> <dd> ข้อบกพร่อง/ข้อสังเกต</dd>  </a>
    </h4>
</div>
 
<div id="collapse" class="panel-collapse collapse ">
    <br>
 <div class="container-fluid">
    
 
    
<?php $__currentLoopData = $assessment->CertificateHistorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1 => $item1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
 
            <?php if(!is_null($item1->details_table)): ?>
            <?php 
                $details_table = json_decode($item1->details_table);
            ?> 
            <?php if(!is_null($details_table)): ?>
            <table class="table color-bordered-table primary-bordered-table table-bordered no-hover-animate">
                <thead>
                    <tr>
                        <th class="text-center" width="2%">ลำดับ</th>
                        <th class="text-center" width="20%">ผลการประเมินที่พบ</th>
                        <th class="text-center" width="7%">ประเภท</th>
                        <th class="text-center" width="35%">แนวทางการแก้ไข</th>
        
                        <?php if($key1 > 0): ?> 
                        <th  class="text-center" width="20%">สาเหตุ</th>
                        <th class="text-center" width="10%" >หลักฐาน</th>
                        
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="table-body">
                    
                    <?php $__currentLoopData = $details_table; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2 => $item2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                     $type =   ['1'=>'ข้อบกพร่อง','2'=>'ข้อสังเกต'];
                    ?>
                    <tr>
                        <td class="text-center" style="padding: 0px"><?php echo e($key2+1); ?></td>
                        <td style="padding: 0px">
                             <?php echo e($item2->remark ?? null); ?>

                        </td>
                        <td class="text-center" style="padding: 0px">
                            <?php echo e(array_key_exists($item2->type,$type) ? $type[$item2->type] : '-'); ?>  
                        </td>
                        <td style="padding: 0px">
                            
                            <?php echo e(@$item2->details ?? null); ?>

                            <br>
                            <?php if($item2->status == 1): ?> 
                              <label for="app_name">ผลแนวทาง : <span> <i class="fa fa-check-square" style="font-size:20px;color:rgb(0, 255, 42)"></i></span> ผ่าน </label> 
                            <?php elseif(!is_null($item2->comment)): ?> 
                            <label for="app_name"><span>ผลแนวทาง : <i class="fa  fa-close" style="font-size:20px;color:rgb(255, 0, 0)"></i> <?php echo e('ไม่ผ่าน:'.$item2->comment ?? null); ?></span> </label>
                            <?php endif; ?>
                        </td>
        
                        <?php if($key1 > 0): ?> 
                        <td style="padding: 0px">
                            <?php echo e(@$item2->cause ?? null); ?>

                        </td>
                          <td style="padding: 0px">
                                <?php if($item2->status == 1): ?> 
                                            <?php if($item2->file_status == 1): ?>
                                            <span> <i class="fa fa-check-square" style="font-size:20px;color:rgb(0, 255, 42)"></i> ผ่าน</span>  
                                             <?php elseif(!is_null($item2->attachs) && isset($item2->attachs) ): ?>
                                            <span> <i class="fa  fa-close" style="font-size:20px;color:rgb(255, 0, 0)"></i> ไม่ผ่าน </span> 
                                            <?php endif; ?>
                                        <label for="app_name">
                                            <span>
                                                <?php if(!is_null($item2->attachs) && isset($item2->attachs) ): ?>
                                                    <a href="<?php echo e(url('certify/check/file_client/'.$item2->attachs.'/'.( !empty($item2->attachs_client_name) ? $item2->attachs_client_name :  basename($item2->attachs) ))); ?>" target="_blank">
                                                        <?php echo HP::FileExtension($item2->attachs)  ?? ''; ?>

                                                    </a>
                                                 <?php endif; ?>
                                            </span> 
                                        </label> 
                                <?php endif; ?>
                                
                         </td>
                        <?php endif; ?>
                      
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                </tbody>
            </table>
            <?php endif; ?>
            <?php endif; ?>
        
            
            <?php if(!is_null($item1->file)): ?> 
            <div class="row">
            <div class="col-md-3 text-right">
                <p class="text-nowrap">รายงานการตรวจประเมิน :</p>
            </div>
            <div class="col-md-9">
                <p>
                    <a href="<?php echo e(url('certify/check/file_client/'.$item1->file.'/'.( !empty($item1->file_client_name) ? $item1->file_client_name : basename($item1->file) ))); ?>" 
                        title=" <?php echo e(!empty($item1->file_client_name) ? $item1->file_client_name : basename($item1->file)); ?>"   target="_blank">
                        <?php echo HP::FileExtension($item1->file)  ?? ''; ?>

                    </a>
                </p>
            </div>
            </div>
            <?php endif; ?>
        
            <?php if(!is_null($item1->attachs)): ?> 
            <div class="row">
            <div class="col-md-3 text-right">
                <p class="text-nowrap">ไฟล์แนบ :</p>
            </div>
            <div class="col-md-9">
                    <?php 
                        $attachs = json_decode($item1->attachs);
                    ?>  
                    
                    <?php if(!is_null($attachs)): ?> 
                    <?php $__currentLoopData = $attachs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <p>
                            <a href="<?php echo e(url('certify/check/file_client/'.$item2->attachs.'/'.( !empty($item2->attachs_client_name) ? $item2->attachs_client_name : basename($item2->attachs) ))); ?>" 
                                title=" <?php echo e(!empty($item2->attachs_client_name) ? $item2->attachs_client_name :  basename($item2->attachs)); ?>"  target="_blank">
                                <?php echo HP::FileExtension($item2->attachs)  ?? ''; ?>

                            </a>
                         </p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
            </div>
            </div>
            <?php endif; ?>
        
            <?php if(!is_null($item1->date)): ?> 
            <div class="row">
            <div class="col-md-3 text-right">
                <p class="text-nowrap">วันที่บันทึก :</p>
            </div>
            <div class="col-md-9">
                <?php echo e(@HP::DateThai($item1->date) ?? '-'); ?>

            </div>
            </div>
            <?php endif; ?>
        
 

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
    
<?php endif; ?>

<input type="text" id="notice_id" value="<?php echo e($assessment->id); ?>">

 <?php echo Form::open(['url' => 'certify/applicant/assessment/update/'.$assessment->id,
                'class' => 'form-horizontal',
                'id'=>'form_auditor', 
                'method' => 'post',
                'files' => true]); ?>

<div id="box-readonly">
<?php if($assessment->degree == 1): ?>
 <div class="row form-group">
    <div class="col-md-12">
       <div class="white-box" style="border: 2px solid #e5ebec;">
  <legend><h3>   แก้ไขข้อบกพร่อง/ข้อสังเกต <?php if($assessment->accept_fault == null): ?>
    <span class="text-warning">(โปรดยอมรับข้อบกพร่อง)</span>
<?php elseif($assessment->submit_type != 'confirm'): ?>
<span class="text-warning">(กำลังดำเนินการ)</span>
<?php endif; ?></h3></legend>

<div class="container-fluid">
        <table class="table color-bordered-table primary-bordered-table table-bordered no-hover-animate">
        <thead>
            <tr>
                <th class="text-center" width="2%">ลำดับ</th>
                <th class="text-center" width="40%">ผลการประเมินที่พบ</th>
                <th class="text-center" width="58%">แนวทางการแก้ไข</th>  
            </tr>
        </thead>
        <tbody id="table-body">
            <?php $__currentLoopData = $assessment->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="text-center" style="padding: 0px"><?php echo e($key+1); ?></td>
                <td style="padding: 0px">
                    <?php echo Form::hidden('detail[id][]',!empty($item->id)?$item->id:null, ['class' => 'form-control ']); ?>

                    <?php echo e($item->remark ?? null); ?>

               </td>
                <td style="padding: 0px">
                    <textarea name="detail[details][]"  class="form-control auto-expand <?php echo e($assessment->accept_fault == null || $assessment->submit_type != 'confirm' ? 'non-editable' : ''); ?>"  rows="5"  required> <?php echo e(!empty($item->details) ? $item->details : ''); ?></textarea>


                </td>
                
            </tr>
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
        </tbody>
    </table>
</div>

        </div>
    </div>
</div>
<?php elseif($assessment->degree == 3): ?>
<div class="row">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
      <legend><h4>บันทึกการแก้ไขข้อบกพร่อง / ข้อสังเกต</h4></legend>
            <?php if(count($assessment->items) > 0): ?>

                    <table class="table color-bordered-table primary-bordered-table no-hover-animate">
                        <thead>
                            <tr>
                                <th class="text-center" width="2%">ลำดับ</th>
                                <th class="text-center" width="30%">ผลการประเมินที่พบ</th>
                                <th class="text-center" width="20%">ผลการประเมิน</th>
                                <th class="text-center" width="46%" >แนวทางการแก้ไข/หลักฐาน</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            <?php $__currentLoopData = $assessment->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $type =   ['1'=>'ข้อบกพร่อง','2'=>'ข้อสังเกต'];
                            ?>
                            <tr>
                                <td class="text-center" style="padding: 0px">
                                    <?php echo e($key+1); ?>

                                </td>
                                

                                <td style="padding: 0px">
                                    <input type="hidden" name="detail[id][]" value="<?php echo e(!empty($item->id) ? $item->id : null); ?>" class="form-control">
                                    <textarea name="notice[]" class="form-control non-editable" style="border: none !important" ><?php echo e($item->remark ?? null); ?></textarea>
                                </td>
                                
                                

                                <td style="padding: 0px">  
                                    
                                      <?php echo e($item->details ?? null); ?>    <br>
                                      <?php if($item->status == 1): ?> 
                                            <label for="app_name">ผลแนวทาง : <span> <i class="fa fa-check-square" style="font-size:20px;color:rgb(0, 255, 42)"></i> </span> </label> 
                                       <?php else: ?> 
                                            <label for="app_name">ผลแนวทาง : <span>  <i class="fa  fa-close" style="font-size:20px;color:rgb(255, 0, 0)"></i> <?php echo e($item->comment ?? null); ?></span> </label>
                                       <?php endif; ?>
                           
                                </td>
                                <td style="padding: 0px">
                                         <?php if($item->status == 1): ?> 
                                                 <?php if(!is_null($item->file_comment)): ?> 
                                                 <label for="app_name">หลักฐาน :  <i class="fa  fa-close" style="font-size:20px;color:rgb(255, 0, 0)"></i>   <?php echo $item->file_comment ?? null; ?> </label> 
                                                 <?php endif; ?>
                                                <?php if($item->file_status != 1): ?>												
									
												 <?php
													$required = ($item->type==2)?"":"required";
												?>
                                                     <div class="fileinput fileinput-new input-group " data-provides="fileinput">
                                                        <div class="form-control" data-trigger="fileinput">
                                                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                            <span class="fileinput-filename"></span>
                                                        </div>
                                                        <span class="input-group-addon btn btn-default btn-file">
                                                            <span class="fileinput-new">เลือกไฟล์</span>
                                                            <span class="fileinput-exists">เปลี่ยน</span>
                                                            <input type="file" name="attachs[<?php echo e($key); ?>]"  <?php echo e($required); ?> class="check_max_size_file" accept=".pdf">
                                                        </span>
                                                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                                    </div>
                                                <?php else: ?> 
                                                   <label for="app_name">หลักฐาน : 
                                                     <span>
                                                        <?php if(!is_null($item->attachs) && isset($item->attachs) ): ?>
                                                        <i class="fa fa-check-square" style="font-size:20px;color:rgb(0, 255, 42)"></i> 
                                                          <a href="<?php echo e(url('certify/check/file_cb_client/'.$item->attachs.'/'.( !empty($item->attach_client_name) ? $item->attach_client_name :   basename($item->attachs) ))); ?>" 
                                                               title="<?php echo e(!empty($item->attach_client_name) ? $item->attach_client_name :  basename($item->attachs)); ?>" target="_blank">
                                                              <?php echo HP::FileExtension($item->attachs)  ?? ''; ?>

                                                            </a>
                                                        <?php endif; ?>
                                                     </span> 
                                                  </label> 
                                                <?php endif; ?>
                                        <?php else: ?> 
                                             
                                             <textarea name="detail[details][<?php echo e($key); ?>]" class="form-control auto-expand" rows="5" required></textarea>

                                        <?php endif; ?>
                                </td>
                             </tr>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
     
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>
</div>

<?php if(in_array($assessment->degree,[1,3,4,6])): ?>
<div class="row">
    <div class="form-group">
        <div class="col-md-offset-5 col-md-6">
                
                <?php if($assessment->accept_fault == '1' && $assessment->submit_type == 'confirm'): ?>
                    <button class="btn btn-primary" type="submit"  onclick="submit_form();return false">
                        <i class="fa fa-paper-plane"></i> บันทึก
                    </button>
                    <a class="btn btn-default" href="<?php echo e(app('url')->previous()); ?>">
                        <i class="fa fa-rotate-left"></i> ยกเลิก
                    </a>
                <?php elseif($assessment->accept_fault == null): ?>    
                    <button type="button" class="btn btn-warning" id="accept_fault">
                        <i class="fa fa-paper-plane"></i> ยอมรับข้อบกพร่อง
                    </button>
                    <a class="btn btn-default" href="<?php echo e(app('url')->previous()); ?>">
                        <i class="fa fa-rotate-left"></i> ยกเลิก
                    </a>
                <?php endif; ?>
                
              
        </div>
    </div>
</div> 
<?php else: ?> 
<a  href="<?php echo e(app('url')->previous()); ?>">
    <div class="alert alert-dark text-center" role="alert">
        <i class="fa fa-rotate-left"></i> ยกเลิก
    </div>
</a>

<?php endif; ?>
<?php echo Form::close(); ?>   


            </div>  
        </div>  
    </div>
 </div>   
 <?php $__env->stopSection(); ?>
 
<?php $__env->startPush('js'); ?>
<script src="<?php echo e(asset('plugins/components/icheck/icheck.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/components/icheck/icheck.init.js')); ?>"></script>
<!-- input calendar thai -->
<script src="<?php echo e(asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker.js')); ?>"></script>
<!-- thai extension -->
<script src="<?php echo e(asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/components/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js')); ?>"></script>
<script src="<?php echo e(asset('js/jasny-bootstrap.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/components/sweet-alert2/sweetalert2.all.min.js')); ?>"></script>

<script type="text/javascript">
jQuery(document).ready(function() {

    $('.auto-expand').each(function () {
                autoExpand(this);
                syncRowHeight(this);
            });

        // ฟังก์ชันปรับขนาด textarea
        function autoExpand(textarea) {
            textarea.style.height = 'auto'; // รีเซ็ตความสูง
            textarea.style.height = textarea.scrollHeight + 'px'; // กำหนดความสูงตามเนื้อหา
        }

        // ฟังก์ชันปรับขนาด textarea ทุกตัวในแถวเดียวกัน
        function syncRowHeight(textarea) {
            let $row = $(textarea).closest('tr'); // หา tr ที่ textarea อยู่
            let maxHeight = 0;

            // วนลูปหา maxHeight ใน textarea ทุกตัวในแถว
            $row.find('.auto-expand').each(function () {
                this.style.height = 'auto'; // รีเซ็ตความสูงก่อนคำนวณ
                let currentHeight = this.scrollHeight;
                if (currentHeight > maxHeight) {
                    maxHeight = currentHeight;
                }
            });

            // กำหนดความสูงให้ textarea ทุกตัวในแถวเท่ากัน
            $row.find('.auto-expand').each(function () {
                this.style.height = maxHeight + 'px';
            });
        }

        // ดักจับ event input
        $(document).on('input', '.auto-expand', function () {
            autoExpand(this); // ปรับ textarea ที่มีการเปลี่ยนแปลง
            syncRowHeight(this); // ปรับ textarea ทั้งแถว
        });


    $('.check-readonly').prop('disabled', true); 
    $('.check-readonly').parent().removeClass('disabled');
    $('.check-readonly').parent().css({"background-color": "rgb(238, 238, 238);","border-radius":"50%"});

//เพิ่มไฟล์แนบ
$(".attach-add").unbind();
    $('.attach-add').click(function(event) {
        var box = $(this).next();
        console.log(box);
        
        box.find('.other_attach_item:first').clone().appendTo('#attach-box');

        box.find('.other_attach_item:last').find('input').val('');
        box.find('.other_attach_item:last').find('a.fileinput-exists').click();
        box.find('.other_attach_item:last').find('a.view-attach').remove();

        ShowHideRemoveBtn94(box);
    });
   //ลบไฟล์แนบ
   $('body').on('click', '.attach-remove', function(event) {
        var box = $(this).parent().parent().parent().parent();
        $(this).parent().parent().remove();
        ShowHideRemoveBtn94(box);
     
    });
    $('.attach-add').each(function(index,eve){
        var box = $(eve).next();
        ShowHideRemoveBtn94(box);
    });


    $("input[name=status]").on("ifChanged",function(){
         status_checkStatus();
    });
   status_checkStatus();

   });

   function ShowHideRemoveBtn94(box) { //ซ่อน-แสดงปุ่มลบ
    if (box.find('.other_attach_item').length > 1) {
        box.find('.attach-remove').show();
    } else {
        box.find('.attach-remove').hide();
    }
   }
   
   function status_checkStatus(){
         var row = $("input[name=status]:checked").val();
         $('#notAccept').hide();  
    if(row == "2"){
        $('#notAccept').fadeIn();
      }else{
        $('#notAccept').hide();
      }
  }
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


   $(document).on('click', '#accept_fault', function(e) {
            e.preventDefault();

            // รับค่าจากฟอร์ม
            const _token = $('input[name="_token"]').val();

            var notice_id = $('#notice_id').val();
  

            // สร้าง overlay
            showOverlay();

            // เรียก AJAX
            $.ajax({
                url: "<?php echo e(route('certify.confirm_notice')); ?>",
                method: "POST",
                data: {
                    _token: _token,
                    notice_id:notice_id,
                },
                success: function(result) {
                    console.log(result);
                    location.reload(); // รีโหลดหน้าเว็บหลังจากสำเร็จ
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    alert("เกิดข้อผิดพลาด กรุณาลองใหม่");
                },
                complete: function() {
                    // ลบ overlay เมื่อคำขอเสร็จสิ้น
                    hideOverlay();
                }
            });
        });


    function showOverlay() {
        // ตรวจสอบว่ามี overlay อยู่หรือยัง
        if ($('#loading-overlay').length === 0) {
            $('body').append(`
                <div id="loading-overlay" style="
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(255, 255, 255, 0.4);
                    z-index: 1050;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: black;
                    font-size: 65px;
                    font-family: 'Kanit', sans-serif;
                ">
                    กำลังบันทึก กรุณารอสักครู่...
                </div>
            `);
        }
    }


    // ฟังก์ชันสำหรับลบ overlay
    function hideOverlay() {
        $('#loading-overlay').remove();
    }


   jQuery(document).ready(function() {
    $('#form_auditor').parsley().on('field:validated', function() {
                        var ok = $('.parsley-error').length === 0;
                        $('.bs-callout-info').toggleClass('hidden', !ok);
                        $('.bs-callout-warning').toggleClass('hidden', ok);
         }) 
         .on('form:submit', function() {
                            // Text
                            $.LoadingOverlay("show", {
                            image       : "",
                            text  : "กำลังบันทึก กรุณารอสักครู่..."
                            });
                        return true; // Don't submit form for this demo
          });
     });
</script>       
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>