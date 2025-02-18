<?php $__env->startPush('css'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">ระบบตรวจติดตามใบรับรองระบบงาน (LAB)</h3>

                    <div class="pull-right">
 
                    </div>

                    <div class="clearfix"></div>
                    <hr>
                    <?php echo Form::model($filter, ['url' => 'certify/tracking-labs', 'method' => 'get', 'id' => 'myFilter']); ?>


                    <div class="row">
                      <div class="col-md-4 form-group">
                            <?php echo Form::label('filter_tb3_Tisno', 'สถานะ:', ['class' => 'col-md-2 control-label label-filter']); ?>

                            <div class="form-group col-md-10">
                                <?php echo Form::select('filter_status',
                                     App\Models\Certificate\TrackingStatus::pluck('title','id'), 
                                  null,
                                 ['class' => 'form-control',
                                 'id'=>'filter_status',
                                 'placeholder'=>'-เลือกสถานะ-']); ?>

                           </div>
                      </div>
                      <div class="col-md-6">
                             <?php echo Form::label('filter_tb3_Tisno', 'เลขที่คำขอ:', ['class' => 'col-md-3 control-label label-filter text-right']); ?>

                               <div class="form-group col-md-5">
                                <?php echo Form::text('filter_search', null, ['class' => 'form-control', 'placeholder'=>'','id'=>'filter_search']);; ?>

                              </div>
                              <div class="form-group col-md-4">
                                  <?php echo Form::label('perPage', 'Show', ['class' => 'col-md-4 control-label label-filter']); ?>

                                  <div class="col-md-8">
                                      <?php echo Form::select('perPage',
                                      ['10'=>'10', '20'=>'20', '50'=>'50', '100'=>'100','500'=>'500'],
                                        null,
                                       ['class' => 'form-control']); ?>

                                  </div>
                              </div>
                      </div><!-- /.col-lg-5 -->
                      <div class="col-md-2">
                        <div class="form-group  pull-left">
                            <button type="submit" class="btn btn-info waves-effect waves-light" style="margin-bottom: -1px;">ค้นหา</button>
                        </div>
                        <div class="form-group  pull-left m-l-15">
                            <button type="button" class="btn btn-warning waves-effect waves-light" id="filter_clear">
                                ล้าง
                            </button>
                        </div>
                    </div><!-- /.col-lg-1 -->
                  </div><!-- /.row -->

 

                    <input type="hidden" name="sort" value="<?php echo e(Request::get('sort')); ?>" />
                    <input type="hidden" name="direction" value="<?php echo e(Request::get('direction')); ?>" />

		 <?php echo Form::close(); ?>


                    <div class="clearfix"></div>

                        <table class="table table-borderless" id="myTable">
                            <thead>

                            <tr>
                                <th  class="text-center" width="2%">#</th>
                                <th  class="text-center" width="10%">เลขที่คำขอ</th>
                                <th  class="text-center" width="10%">ชื่อผู้ยื่น</th>
                                <th  class="text-center" width="10%">เลขที่มาตรฐาน</th>
                                <th  class="text-center" width="10%">สาขา</th>
                                <th  class="text-center"  width="10%">วันที่บันทึก</th>
                                <th  class="text-center"  width="10%">สถานะ</th>
                            </tr>
                            </thead>
                            <tbody>
                                  <?php $__currentLoopData = $query; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 
                                        <tr>
                                                  <td class="text-center"><?php echo e($loop->iteration + ( ((request()->query('page') ?? 1) - 1) * $query->perPage() )); ?></td>
                                                  <td><?php echo e($item->reference_refno ?? null); ?></td>
                                                  <td><?php echo e(!empty($item->certificate_export_to->CertiLabTo->name) ? $item->certificate_export_to->CertiLabTo->name : null); ?></td>
                                                  <td><?php echo e(!empty($item->certificate_export_to->CertiLabTo->lab_type) && $item->certificate_export_to->CertiLabTo->lab_type == 3 ? 'ทดสอบ' : 'สอบเทียบ'); ?></td>
                                                  <td>
                                                
                                                     <?php if(!empty($item->certificate_export_to->CertiLabTo->lab_type) && $item->certificate_export_to->CertiLabTo->lab_type == 3): ?>
                                                       <?php echo e(!empty($item->certificate_export_to->CertiLabTo->BranchTitle) ? $item->certificate_export_to->CertiLabTo->BranchTitle : null); ?>     
                                                    <?php elseif(!empty($item->certificate_export_to->CertiLabTo->lab_type) && $item->certificate_export_to->CertiLabTo->lab_type == 4): ?>
                                                        <?php echo e(!empty($item->certificate_export_to->CertiLabTo->ClibrateBranchTitle) ? $item->certificate_export_to->CertiLabTo->ClibrateBranchTitle : null); ?>     
                                                    <?php endif; ?>
                                                  </td>
                                                  <td>      <?php echo e(!empty($item->reference_date) ?  HP::DateThai($item->reference_date) : '-'); ?></td>
                                                  <td>
                                                      <?php
                                                        $status  =  !empty($item->tracking_status->title)? $item->tracking_status->title:'N/A';
                                                      ?>
                                                      <?php if($item->status_id == 3): ?>
                                                      <button style="border: none" data-toggle="modal"
                                                               data-target="#TakeAction<?php echo e($loop->iteration); ?>"   >
                                                               <i class="mdi mdi-magnify"></i>    <?php echo $status; ?>

                                                      </button>
                                                      <?php echo $__env->make('certify.tracking-labs.modal.modalstatus3',['id'=> $loop->iteration,
                                                                                                          'certi' => $item
                                                                                                      ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                      <?php elseif($item->status_id == 5  && !Is_null($item->tracking_inspection_to)): ?>  
                                                            <button style="border: none" data-toggle="modal"
                                                                  data-target="#inspection<?php echo e($loop->iteration); ?>"   >
                                                                  <i class="mdi mdi-magnify"></i>  <?php echo $status; ?>

                                                            </button>
               
                                                              <?php echo $__env->make('certify.tracking-labs.modal.modalstatus5',['id'=> $loop->iteration,
                                                                                                                      'certi' => $item,
                                                                                                                      'inspection'=> $item->tracking_inspection_to
                                                                                                                   ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>          
                                                      
                                                                                                       
                                                      <?php else: ?> 
                                                           <?php echo $status; ?> 
                                                      <?php endif; ?>
                                                      (ID:<?php echo e($item->status_id); ?>)
                                                  </td>
                                        </tr>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        <div class="pagination-wrapper">
                          <?php echo $query->appends(['search' => Request::get('search'),
                                                    'sort' => Request::get('sort'),
                                                    'direction' => Request::get('direction')
                                                  ])->render(); ?>

                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php $__env->startPush('js'); ?>
    <script src="<?php echo e(asset('plugins/components/toast-master/js/jquery.toast.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/components/sweet-alert2/sweetalert2.all.min.js')); ?>"></script>

    <script>

            $(document).ready(function () {
            $( "#filter_clear" ).click(function() {
                $('#filter_status').val('').select2();
                $('#filter_search').val('');

                $('#filter_state').val('').select2();
                $('#filter_start_date').val('');
                $('#filter_end_date').val('');
                $('#filter_branch').val('').select2();
                window.location.assign("<?php echo e(url('/certify/tracking-labs')); ?>");
            });

            if( checkNone($('#filter_state').val()) ||  checkNone($('#filter_start_date').val()) || checkNone($('#filter_end_date').val()) || checkNone($('#filter_branch').val())   ){
                // alert('มีค่า');
                $("#search_btn_all").click();
                $("#search_btn_all").removeClass('btn-primary').addClass('btn-success');
                $("#search_btn_all > span").removeClass('glyphicon-menu-up').addClass('glyphicon-menu-down');
            }

            $("#search_btn_all").click(function(){
                $("#search_btn_all").toggleClass('btn-primary btn-success', 'btn-success btn-primary');
                $("#search_btn_all > span").toggleClass('glyphicon-menu-up glyphicon-menu-down', 'glyphicon-menu-down glyphicon-menu-up');
            });
            function checkNone(value) {
            return value !== '' && value !== null && value !== undefined;
             }
         });


        $(document).ready(function () {

            <?php if(\Session::has('message')): ?>
                $.toast({
                    heading: 'Success!',
                    position: 'top-center',
                    text: '<?php echo e(session()->get('message')); ?>',
                    loaderBg: '#70b7d6',
                    icon: 'success',
                    hideAfter: 3000,
                    stack: 6
                });
            <?php endif; ?>

            <?php if(\Session::has('message_error')): ?>
                $.toast({
                    heading: 'Error!',
                    position: 'top-center',
                    text: '<?php echo e(session()->get('message_error')); ?>',
                    loaderBg: '#ff6849',
                    icon: 'error',
                    hideAfter: 3000,
                    stack: 6
                });
            <?php endif; ?>

            //เลือกทั้งหมด
            $('#checkall').change(function(event) {

              if($(this).prop('checked')){//เลือกทั้งหมด
                $('#myTable').find('input.cb').prop('checked', true);
              }else{
                $('#myTable').find('input.cb').prop('checked', false);
              }

            });

        });

        function Delete(){

          if($('#myTable').find('input.cb:checked').length > 0){//ถ้าเลือกแล้ว
            if(confirm_delete()){
              $('#myTable').find('input.cb:checked').appendTo("#myForm");
              $('#myForm').submit();
            }
          }else{//ยังไม่ได้เลือก
            alert("กรุณาเลือกข้อมูลที่ต้องการลบ");
          }

        }

        function confirm_delete() {
            return confirm("ยืนยันการลบข้อมูล?");
        }

        function UpdateState(state){

          if($('#myTable').find('input.cb:checked').length > 0){//ถ้าเลือกแล้ว
              $('#myTable').find('input.cb:checked').appendTo("#myFormState");
              $('#state').val(state);
              $('#myFormState').submit();
          }else{//ยังไม่ได้เลือก
            if(state=='1'){
              alert("กรุณาเลือกข้อมูลที่ต้องการเปิด");
            }else{
              alert("กรุณาเลือกข้อมูลที่ต้องการปิด");
            }
          }

        }

    </script>
    <script>
      function submit_form_pay1() {
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
                           $.LoadingOverlay("show", {
                               image       : "",
                               text        : "กำลังบันทึก กรุณารอสักครู่..."
                           });
                           $('.pay_in1_form').submit();
                       }
                   })
           }
   </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>