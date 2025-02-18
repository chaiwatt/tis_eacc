<?php $__env->startPush('css'); ?>

<style>
  /*
    Max width before this PARTICULAR table gets nasty. This query will take effect for any screen smaller than 760px and also iPads specifically.
    */
    @media
      only screen
    and (max-width: 760px), (min-device-width: 768px)
    and (max-device-width: 1024px)  {

        /* Force table to not be like tables anymore */
        table, thead, tbody, th, td, tr {
            display: block;
        }

        /* Hide table headers (but not display: none;, for accessibility) */
        thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

    tr {
      margin: 0 0 1rem 0;
    }

    tr:nth-child(odd) {
      background: #eee;
    }

        td {
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 50%;
        }

        td:before {
            /* Now like a table header */
            /*position: absolute;*/
            /* Top/left values mimic padding */
            top: 0;
            left: 6px;
            width: 45%;
            padding-right: 10px;
            white-space: nowrap;
        }

        /*
        Label the data
    You could also use a data-* attribute and content for this. That way "bloats" the HTML, this way means you need to keep HTML and CSS in sync. Lea Verou has a clever way to handle with text-shadow.
        */
        /*td:nth-of-type(1):before { content: "Column Name"; }*/

    }
</style>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">ใบรับรองระบบงาน (CB)</h3>

                    <div class="pull-right">

                        <?php if( HP::CheckPermission('add-'.str_slug('applicantcbs'))): ?>
                            <a class="btn btn-success btn-sm waves-effect waves-light" href="<?php echo e(url('/certify/applicant-cb/create')); ?>">
                                <span class="btn-label"><i class="fa fa-plus"></i></span><b>ยื่นคำขอ</b>
                            </a>
                        <?php endif; ?>

                    </div>

                    <div class="clearfix"></div>
                    <hr>
                    <?php echo Form::model($filter, ['url' => 'certify/applicant-cb', 'method' => 'get', 'id' => 'myFilter']); ?>


                        <div class="row">
                            <div class="col-md-4 form-group">
                                <?php echo Form::label('filter_tb3_Tisno', 'สถานะ:', ['class' => 'col-md-2 control-label label-filter']); ?>

                                <div class="form-group col-md-10">
                                    <?php echo Form::select('filter_status', App\Models\Certify\ApplicantCB\CertiCBStatus::pluck('title','id'),null, ['class' => 'form-control','id'=>'filter_status','placeholder'=>'-เลือกสถานะ-']); ?>

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
                                        <?php echo Form::select('perPage', ['10'=>'10', '20'=>'20', '50'=>'50', '100'=>'100','500'=>'500'],null,['class' => 'form-control']); ?>

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

                        <div id="search-btn" class="panel-collapse collapse">
                            <div class="white-box" style="display: flex; flex-direction: column;">

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <?php echo Form::label('filter_state', 'ความสามารถห้องปฏิบัติการ:', ['class' => 'col-md-5 control-label label-filter']); ?>

                                        <div class="col-md-7">
                                            <?php echo Form::select('filter_state', ['3'=>'ทดสอบ', '4'=>'สอบเทียบ'], null,    ['class' => 'form-control',  'id'=>'filter_state','placeholder'=>"-เลือกความสามารถห้องปฏิบัติการ-"]); ?>

                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <?php echo Form::label('filter_start_date', 'วันที่มีคำสั่ง:', ['class' => 'col-md-3 control-label label-filter']); ?>

                                        <div class="col-md-8">
                                            <div class="input-daterange input-group" id="date-range">
                                                <?php echo Form::text('filter_start_date', null, ['class' => 'form-control','id'=>'filter_start_date']); ?>

                                                <span class="input-group-addon bg-info b-0 text-white"> ถึง </span>
                                                <?php echo Form::text('filter_end_date', null, ['class' => 'form-control','id'=>'filter_end_date']); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <?php echo Form::label('c', 'สาขา:', ['class' => 'col-md-5 control-label label-filter']); ?>

                                        <div class="col-md-7">
                                            <?php echo Form::select('filter_branch', [],   null, ['class' => 'form-control',  'id'=>'filter_branch','placeholder'=>"-เลือกสาขา-"]); ?>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

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
                                <th  class="text-center"  width="10%">วันที่รับคำขอ</th>
                                <th  class="text-center"  width="10%">สถานะ</th>
                                <th  class="text-center"  width="10%">เครื่องมือ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if( count($certiCbs ) == 0 ): ?>
                                <tr>
                                    <td class="text-center" colspan="8">
                                        ไม่พบข้อมูล
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php $__currentLoopData = $certiCbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-center"><?php echo e($loop->iteration + ( ((request()->query('page') ?? 1) - 1) * $certiCbs->perPage() )); ?></td>
                                    <td> <?php echo e(@$item->app_no); ?></td>
                                    <td><?php echo e($item->name ?? null); ?></td>
                                    <td><?php echo e(!empty($item->FormulaTo->title) ? $item->FormulaTo->title  : null); ?></td>
                                    <td><?php echo e($item->CertificationBranchName); ?></td>
                                    <td><?php echo e($item->AcceptDateShow); ?></td>
                                    <td>
                                        <?php
                                            $data_status =$item->TitleStatus->title ?? '-' ;
                                        ?>

                                        <?php if($item->status == 3): ?> <!-- ขอเอกสารเพิ่มเติม  -->
                                            <button style="border: none" data-toggle="modal"  data-target="#actionThree<?php echo e($loop->iteration); ?>"  > <i class="mdi mdi-magnify"></i>    <?php echo e($data_status); ?> </button>
                                            <?php echo $__env->make('certify.applicant_cb.modal.modalstatus3',array('id'    => $loop->iteration,
                                                                                                'details'     => $item->details ?? null,
                                                                                                'token'       =>  $item->token ,
                                                                                                'attach_path' => $attach_path ,
                                                                                                'file'        => $item->FileAttach6 ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                        <?php elseif($item->status == 4): ?>
                                            <button style="border: none" data-toggle="modal"  data-target="#actionFour<?php echo e($loop->iteration); ?>"  data-id="<?php echo e($item->token); ?>"  >
                                                <i class="mdi mdi-magnify"></i>      <?php echo e($data_status ?? '-'); ?>

                                            </button>
                                            <?php echo $__env->make('certify.applicant_cb.modal.modalstatus4', array('id' => $loop->iteration,'desc' => !empty($item->desc_delete) ? $item->desc_delete :  '-' , 'file'=>  $item->FileAttach5  ), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                        <?php elseif($item->status == 8): ?> <!-- ขอความเห็นประมาณการค่าใช้จ่าย  -->
                                            <a class="btn  btn-sm" style="background-color: rgb(235, 235, 235)" href="<?php echo e(url('certify/applicant-cb/cost/'.$item->token)); ?>">
                                                <i class="mdi mdi-magnify"></i>  <?php echo e($data_status); ?>

                                            </a>
                                        <?php elseif($item->status == 9): ?> <!-- ขอความเห็นผู้ตรวจประเมินเอกสาร  -->
                                      

                                        <?php if($item->cbDocReviewAuditor != null): ?>
                                                    
                                            <?php if($item->cbDocReviewAuditor->status == 0): ?>
                                                <button style="border: none" data-toggle="modal"  data-target="#TakeAction<?php echo e($loop->iteration); ?>" data-id="<?php echo e($item->token); ?>"  >
                                                    <i class="mdi mdi-magnify"></i>เห็นชอบการแต่งตั้งคณะผู้ตรวจประเมินเอกสาร
                                                </button>
                                                <?php echo $__env->make('certify.applicant_cb.modal.modalstatus9',['id'=> $loop->iteration,'token'=> $item->token,'auditors' => $item->CertiAuditorsMany,'certi' => $item ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                            <?php elseif($item->cbDocReviewAuditor->status == 2): ?>
                                                ไม่เห็นชอบการแต่งตั้งคณะผู้ตรวจประเมินเอกสาร
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if($item->doc_review_reject != null): ?>
                                                    
                                            <button style="border: none" data-toggle="modal"  data-target="#TakeAction<?php echo e($loop->iteration); ?>" data-id="<?php echo e($item->token); ?>"  >
                                                <i class="mdi mdi-magnify"></i>แก้ไขเอกสาร
                                            </button>
                                            <?php echo $__env->make('certify.applicant_cb.modal.modalstatus9_1',['id'=> $loop->iteration,'token'=> $item->token,'auditors' => $item->CertiAuditorsMany,'certi' => $item ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                        <?php endif; ?>

                                            


                                        <?php elseif($item->status == 10 || $item->status == 11): ?> <!-- อยู่ระหว่างดำเนินการ  -->
                                            <button style="border: none" data-toggle="modal"  data-target="#TakeAction<?php echo e($loop->iteration); ?>" data-id="<?php echo e($item->token); ?>"  >
                                                <i class="mdi mdi-magnify"></i>เห็นชอบการแต่งตั้งคณะผู้ตรวจประเมิน
                                            </button>

                                            <?php echo $__env->make('certify.applicant_cb.modal.modalstatus10',['id'=> $loop->iteration,'token'=> $item->token,'auditors' => $item->CertiAuditorsMany,'certi' => $item ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                        <?php elseif($item->status == 13): ?> <!-- รอยืนยันคำขอ  -->
                                            <button type="button"  style="border: none;"  data-toggle="modal" data-target="#ReportModal<?php echo e($item->id); ?>">
                                                <i class="mdi mdi-magnify"></i>  <?php echo e($data_status); ?>

                                            </button>
                                            <?php echo $__env->make('certify.applicant_cb.modal.modalstatus18',[ 'id' =>$item->id, 'report' => $item->CertiCBReportTo ?? null  ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                        <?php elseif($item->status == 15): ?> <!-- 	 	แจ้งรายละเอียดการชำระค่าใบรับรอง   -->
                                            <button type="button"  style="border: none;"  data-toggle="modal" data-target="#PayIn2Modal<?php echo e($item->id); ?>">
                                                <i class="mdi mdi-magnify"></i>  <?php echo e($data_status); ?>

                                            </button>
                                            <?php
                                                $PayIn2 = $item->CertiCBPayInTwoTo;
                                            ?>
                                            <?php echo $__env->make('certify.applicant_cb.modal.modalstatus20',[
                                                                                                    'id' =>$item->id,
                                                                                                    'PayIn2' => $PayIn2 ?? null,
                                                                                                    'app_no' => $item->app_no ?? '-',
                                                                                                    'name' => $item->name ?? '-',
                                                                                                    'files1' => $PayIn2->FileAttachPayInTwo1To->file ?? null,
                                                                                                    'file_client_name' => $PayIn2->FileAttachPayInTwo1To->file_client_name ?? null,
                                                                                                    'std_name' => $item->FormulaTo->title,
                                                                                                    'save_date' => $item->save_date
                                                                                                   ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                        <?php else: ?>
                                            <?php echo e($data_status ?? '-'); ?>

                                        <?php endif; ?>
                                        (ID:<?php echo e($item->status); ?>)
                                    </td>
                                    <td>
                                        
                                        <?php if( HP::CheckPermission('view-'.str_slug('applicantcbs'))): ?>
                                            <a href="<?php echo e(url('/certify/applicant-cb/' . $item->token)); ?>"  title="View ApplicantCB" class="btn btn-info btn-xs">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                        <?php endif; ?>

                                        <?php if($item->status != 4 &&  $item->status != 5  ): ?>
                                            <?php if( in_array($item->status ,[0,3]) ): ?>
                                                <?php if( HP::CheckPermission('edit-'.str_slug('applicantcbs'))): ?>
                                                    <a href="<?php echo e(url('/certify/applicant-cb/' . $item->token . '/edit')); ?>"  title="Edit ApplicantCB" class="btn btn-primary btn-xs">
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"> </i>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if( HP::CheckPermission('delete-'.str_slug('applicantcbs')) ): ?>

                                                <?php if( empty($item->app_certi_cb_export->certificate_newfile) || (!empty($item->app_certi_cb_export->certificate_newfile) && ( ( !empty($item->app_certi_cb_export) && !in_array($item->app_certi_cb_export->status, [4]) ) && !in_array($item->status, [20]) ))  ): ?>
                                                    <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modalDelete<?php echo e($loop->iteration); ?>"data-no="<?php echo e($item->app_no); ?>"data-id="<?php echo e($item->token); ?>" >
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                    </button>
                                                    <?php echo $__env->make('certify.applicant_cb.modal.modaldelete',['id'=>$loop->iteration, 'token'=>$item->token, 'app_no'=>$item->app_no], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                <?php endif; ?>
                                     
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if(count($item->DataCertiCbHistory) > 0): ?>
                                            <a class="btn btn-xs btn-warning"  href="<?php echo e(url('certify/applicant-cb/Log-CB/'.$item->token)); ?>">
                                                <i class="mdi mdi-magnify"></i>
                                            </a>
                                        <?php endif; ?>
                                     
                                        <?php if( !empty($item->app_certi_cb_export->certificate_newfile) && ( ( !empty($item->app_certi_cb_export) && in_array($item->app_certi_cb_export->status, [4]) ) || in_array($item->status, [20]) ) ): ?>
                                            <a href="<?php echo e(url('funtions/get-view').'/'.@$item->app_certi_cb_export->certificate_path.'/'.@$item->app_certi_cb_export->certificate_newfile.'/'.@$item->app_certi_cb_export->certificate_no.'_'.date('Ymd_hms').'.pdf'); ?>" target="_blank">
                                                <img src="<?php echo e(asset('images/icon-certification.jpg')); ?>" width="20px" style="margin-top: 4px;">
                                            </a>
                                        <?php elseif(!empty($item->app_certi_cb_export->attachs) && ( ( !empty($item->app_certi_cb_export) && in_array($item->app_certi_cb_export->status, [4]) ) || in_array($item->status, [20]) )): ?>
                                            <a href="<?php echo e(url('certify/check/file_cb_client/'.$item->app_certi_cb_export->attachs.'/'.( !empty($item->app_certi_cb_export->attach_client_name) ? $item->app_certi_cb_export->attach_client_name :  basename($item->app_certi_cb_export->attachs)  ))); ?>" target="_blank">
                                                <?php echo HP::FileExtension($item->app_certi_cb_export->attachs)  ?? ''; ?>

                                            </a>
                                        <?php endif; ?>

                                    </td>
                                </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        <div class="pagination-wrapper">
                          <?php echo $certiCbs->appends(['search' => Request::get('search'),
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
                window.location.assign("<?php echo e(url('/certify/applicant-cb')); ?>");
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

    $('input[name="agree"]').change(function() {
        if ($('#not_agree').is(':checked')) {
            $('#text-area-wrapper').show(); // แสดงทันที
        } else {
            $('#text-area-wrapper').hide(); // ซ่อนทันที
            $("#remark").val("");
        }
    });

    // agree_doc_review_tream

    


    $('#agree_doc_review_tream').click(function(){
   
        const _token = $('input[name="_token"]').val();
        let certiCbId = $('#certi_cb_id').val();
        
        // ดึงค่าของ radio ที่ถูกเลือก
        let agreeValue = $("input[name='agree']:checked").val();

        // ดึงค่าของ textarea
        let remarkText = $("#remark").val();


        $.ajax({
        url: "<?php echo e(route('applicant_cb.update_doc_review_team')); ?>",
        // url: "/certify/applicant/api/test_parameter",
        method: "POST",
        data: {
            certiCbId: certiCbId,
            agreeValue: agreeValue,
            remarkText: remarkText,
            _token: _token
        },
        success: function(result) {
            location.reload();

        }
    });
        
    });



   </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>