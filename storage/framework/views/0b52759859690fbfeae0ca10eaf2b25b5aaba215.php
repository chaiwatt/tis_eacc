
<?php $__env->startPush('css'); ?>
<link href="<?php echo e(asset('plugins/components/icheck/skins/all.css')); ?>" rel="stylesheet" type="text/css" />
     <!-- ===== Parsley js ===== -->
    <link href="<?php echo e(asset('plugins/components/parsleyjs/parsley.css?20200630')); ?>" rel="stylesheet" />
<?php $__env->stopPush(); ?>

<?php echo Form::open(['url' => 'certify/tracking-labs/inspection/update/'.$inspection->id,    'method' => 'POST', 'class' => 'form-horizontal  ','id'=>'form-inspection', 'files' => true]); ?>


<div class="modal fade text-left" id="inspection<?php echo e($id); ?>" tabindex="-1" role="dialog" aria-labelledby="addBrand">
          <div class="modal-dialog  modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title" id="exampleModalLabel1"> ยืนยัน Scope
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      </h4>
                  </div>
 <div class="modal-body"> 

<div class="row">
    <div class="col-md-12">

<div class="form-group <?php echo e($errors->has('Scope') ? 'has-error' : ''); ?>">
        <?php echo HTML::decode(Form::label('Scope', 'Scope'.' :', ['class' => 'col-md-4 control-label text-right'])); ?>

        <div class="col-md-8">
            <?php if(!is_null($inspection->FileAttachScopeTo)): ?>
                        <p>
                                <a href="<?php echo e(url('funtions/get-view/'.$inspection->FileAttachScopeTo->url.'/'.( !empty($inspection->FileAttachScopeTo->filename) ? $inspection->FileAttachScopeTo->filename :  basename($inspection->FileAttachScopeTo->url)  ))); ?>" 
                                    title="<?php echo e(!empty($inspection->FileAttachScopeTo->filename) ? $inspection->FileAttachScopeTo->filename : basename($inspection->FileAttachScopeTo->url)); ?>" target="_blank">
                                    <?php echo HP::FileExtension($inspection->FileAttachScopeTo->url)  ?? ''; ?>

                                </a> 
                        </p>
            <?php endif; ?>
        </div>
</div>       
<div class="form-group <?php echo e($errors->has('Report') ? 'has-error' : ''); ?>">
    <?php echo HTML::decode(Form::label('Report', 'สรุปรายงานการตรวจทุกครั้ง'.' :', ['class' => 'col-md-4 control-label text-right'])); ?>

    <div class="col-md-8">
        <?php if(!is_null($inspection->FileAttachReportTo)): ?>
                    <p>
                            <a href="<?php echo e(url('funtions/get-view/'.$inspection->FileAttachReportTo->url.'/'.( !empty($inspection->FileAttachReportTo->filename) ? $inspection->FileAttachReportTo->filename :  basename($inspection->FileAttachReportTo->url)  ))); ?>" 
                                title="<?php echo e(!empty($inspection->FileAttachReportTo->filename) ? $inspection->FileAttachReportTo->filename : basename($inspection->FileAttachReportTo->url)); ?>" target="_blank">
                                <?php echo HP::FileExtension($inspection->FileAttachReportTo->url)  ?? ''; ?>

                            </a> 
                    </p>
        <?php endif; ?>
    </div>
</div> 
<div class=" col-md-12">   <hr/> </div>
 

<div class="form-group <?php echo e($errors->has('status') ? 'has-error' : ''); ?>">
    <?php echo HTML::decode(Form::label('status', 'เห็นชอบกับ Scope '.' :', ['class' => 'col-md-4 control-label text-right'])); ?>

        <div class="col-md-8">
                <label><?php echo Form::radio('status', '1', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']); ?> &nbsp;ยืนยัน Scope &nbsp;</label>
                <label><?php echo Form::radio('status', '2', false, ['class'=>'check check-readonly', 'data-radio'=>'iradio_square-red']); ?> &nbsp;ขอแก้ไข Scope &nbsp;</label>
        </div>
 </div>
 
 <div id="DivStatusScope">
    <div class="form-group <?php echo e($errors->has('status') ? 'has-error' : ''); ?>" >
        <?php echo HTML::decode(Form::label('status', 'หมายเหตุ'.' :', ['class' => 'col-md-4 control-label text-right'])); ?>

            <div class="col-md-8">
                <textarea name="details" id="details" cols="30" rows="3" class="form-control"></textarea>
            </div>
     </div>
  
    <div class="form-group <?php echo e($errors->has('status') ? 'has-error' : ''); ?>" >
         <?php echo HTML::decode(Form::label('status', 'ไฟล์แนบ (ถ้ามี)'.' :', ['class' => 'col-md-4 control-label text-right'])); ?>

           <div class="col-md-8">
            <button type="button" class="btn btn-sm btn-success m-l-10 attach_add_scope" id="attach_add_scope">
                <i class="icon-plus"></i>&nbsp;เพิ่ม
            </button>
            <div id="modal_attach_box">
                <div class="form-group attach_item">
                  <div class="col-md-5">
                       <?php echo Form::text('file_desc_text[]', null, ['class' => 'form-control m-t-10', 'placeholder' => 'ชื่อไฟล์']); ?>

                  </div>
                  <div class="col-md-6">
                       <div class="fileinput fileinput-new input-group m-t-10" data-provides="fileinput">
                              <div class="form-control" data-trigger="fileinput">
                                  <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                  <span class="fileinput-filename"></span>
                              </div>
                              <span class="input-group-addon btn btn-default btn-file">
                                  <span class="fileinput-new">เลือกไฟล์</span>
                                  <span class="fileinput-exists">เปลี่ยน</span>
                                   <input type="file" name="attach_files[]" class="  check_max_size_file">
                               </span>
                              <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                      </div>
                  </div>
                  <div class="col-md-1 text-left m-t-15" style="margin-top: 3px">
                      <button class="btn btn-danger btn-sm attach_remove_scope" type="button" >
                          <i class="icon-close"></i>
                      </button>
                  </div>
              </div>
           </div>
         </div>
   </div>
</div>
 
    </div> 
</div>

</div>

<?php if($certi->status_id == 5): ?>
<input type="hidden" name="previousUrl" id="previousUrl" value="<?php echo e(app('url')->previous()); ?>">
<div class="modal-footer">
    <button type="submit" class="btn btn-success" onclick="submit_form();return false">ยืนยัน</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
</div> 
<?php endif; ?>


        </div>
    </div>
</div>
<?php echo Form::close(); ?>

      
<?php $__env->startPush('js'); ?>
<script src="<?php echo e(asset('plugins/components/icheck/icheck.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/components/icheck/icheck.init.js')); ?>"></script>
     <!-- ===== PARSLEY JS Validation ===== -->
     <script src="<?php echo e(asset('plugins/components/parsleyjs/parsley.min.js')); ?>"></script>
     <script src="<?php echo e(asset('plugins/components/parsleyjs/language/th.js')); ?>"></script>
     <script src="<?php echo e(asset('js/jasny-bootstrap.js')); ?>"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
 
            $('.check-readonly').prop('disabled', true);//checkbox ความคิดเห็น
            $('.check-readonly').parent().removeClass('disabled');
            $('.check-readonly').parent().css({"background-color": "rgb(238, 238, 238);","border-radius":"50%", "cursor": "not-allowed"});
    
            $(".attach_add_scope").unbind();
        $('.attach_add_scope').click(function(event) {
            var box = $(this).next();
            box.find('.attach_item:first').clone().appendTo('#modal_attach_box');
            box.find('.attach_item:last').find('input').val('');
            box.find('.attach_item:last').find('a.fileinput-exists').click();
            box.find('.attach_item:last').find('a.view-attach').remove();
    
            ShowHideRemoveBtnScope(box);
    
        });
              //ลบไฟล์แนบ
        $('body').on('click', '.attach_remove_scope', function(event) {
            var box = $(this).parent().parent().parent().parent();
            $(this).parent().parent().remove();
            ShowHideRemoveBtnScope(box);
         
        });
        $('.attach_add_scope').each(function(index,eve){
            var box = $(eve).next();
            ShowHideRemoveBtnScope(box);
        });
    
        $("input[name=status]").on("ifChanged",function(){
             status_status_scope();
        });
        status_status_scope();
    
    });
    
    function status_status_scope(){
             var row = $("input[name=status]:checked").val();
             $('#DivStatusScope').hide();
        if(row == "2"){
            $('#DivStatusScope').fadeIn();
          }else{
            $('#DivStatusScope').hide();
          }
      }
      
    function ShowHideRemoveBtnScope(box) { //ซ่อน-แสดงปุ่มลบ
        if (box.find('.attach_item').length > 1) {
            box.find('.attach_remove_scope').show();
        } else {
            box.find('.attach_remove_scope').hide();
        }
    }
    function submit_form() {
        Swal.fire({
                title: 'ยืนยันการทำรายการ !',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'บันทึก',
                cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.value) {
                        $('#form-inspection').submit();
                    }
                })
        }
        jQuery(document).ready(function() {
        $('#form-inspection').parsley().on('field:validated', function() {
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
    