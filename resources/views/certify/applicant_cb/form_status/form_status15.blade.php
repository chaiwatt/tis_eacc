@extends('layouts.master')
@push('css')
<link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('plugins/components/bootstrap-datepicker-thai/css/datepicker.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
 <div class="container-fluid">
     <div class="row">
        <div class="col-md-12">
           <div class="white-box">
           <h3 class="box-title pull-left">ใบรับรองระบบงาน (CB)  </h3>

                <a class="btn btn-danger text-white pull-right" href="{{url('certify/applicant-cb')}}">
                        <i class="icon-arrow-left-circle"></i> กลับ
                </a>
                {{--  --}}
                <div class="clearfix"></div>
                <hr>  
  
                
  
@if(count($assessment->CertiCBHistorys) > 0)               
<div class="row">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
    <legend><h3>ข้อบกพร่อง/ข้อสังเกต</h3></legend>                

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
{{-- {{ (count($certi_cb->CertiCBSaveAssessments) == $key +1 )in ? 'in' : ' '  }} --}}
<div id="collapse" class="panel-collapse collapse ">
    <br>
 <div class="container-fluid">
@foreach($assessment->CertiCBHistorys as $key1 => $item)

<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
        {{-- <legend><h3> ครั้งที่ {{ $key1 +1}} </h3></legend> --}}
    @if(!is_null($item->details_two))
    @php 
        $details_two = json_decode($item->details_two);
    @endphp 
@if(!is_null($details_two))
    <table class="table color-bordered-table primary-bordered-table table-bordered">
        <thead>
            <tr>
                <th class="text-center" width="2%">ลำดับ</th>
                <th class="text-center" width="15%">รายงานที่</th>
                <th class="text-center" width="15%">ผลการประเมินที่พบ</th>
                <th class="text-center" width="15%">
                    {{ 
                        !empty($assessment->CertiCBCostTo->FormulaTo->title) ?   
                         $assessment->CertiCBCostTo->FormulaTo->title :''  
                    }}
                </th>
                <th class="text-center" width="10%">ประเภท</th>
                <th class="text-center" width="20%">แนวทางการแก้ไข</th>

                @if($key1 > 0) 
                <th class="text-center" width="25%" >หลักฐาน</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($details_two as $key2 => $item2)
            @php
             $type =   ['1'=>'ข้อบกพร่อง','2'=>'ข้อสังเกต'];
            @endphp
            <tr>
                <td class="text-center">{{ $key2+ 1 }}</td>
                <td>
                    {{ $item2->report ?? null }}
                </td>
                <td>
                     {{ $item2->remark ?? null }}
                </td>
                <td>
                    {{ $item2->no ?? null }}
                </td>
                <td>
                    {{  array_key_exists($item2->type,$type) ? $type[$item2->type] : '-' }}  
                </td>
              
                <td>
                    {{ @$item2->details ?? null }}
                    <br>
                    @if($item2->status == 1) 
                      <label for="app_name"> <span> <i class="fa fa-check-square" style="font-size:20px;color:rgb(0, 255, 42)"></i></span> ผ่าน </label> 
                    @elseif(!is_null($item2->comment)) 
                    <label for="app_name"><span>  <i class="fa  fa-close" style="font-size:20px;color:rgb(255, 0, 0)"></i> {{  'ไม่ผ่าน:'.$item2->comment ?? null   }}</span> </label> 
                   @endif
                </td>
                @if($key1 > 0) 
                  <td>
                         @if($item2->status == 1) 
                                     @if($item2->file_status == 1)
                                              <span> <i class="fa fa-check-square" style="font-size:20px;color:rgb(0, 255, 42)"></i> ผ่าน</span>  
                                     @elseif(isset($item2->file_comment))
                                            @if(!is_null($item2->file_comment))
                                              <span> <i class="fa  fa-close" style="font-size:20px;color:rgb(255, 0, 0)"></i> ไม่ผ่าน </span> 
                                              {!!   " : ".$item2->file_comment ?? null  !!}
                                            @endif
                                    @endif
                                <label for="app_name">
                                    <span>
                                        @if($item2->attachs!='' && HP::checkFileStorage($attach_path.$item2->attachs))
                                            <a href="{{url('certify/check/file_cb_client/'.$item2->attachs.'/'.( !empty($item2->attach_client_name) ? $item2->attach_client_name :   basename($item2->attachs) ))}}" 
                                                title="{{ !empty($item2->attach_client_name) ? $item2->attach_client_name :  basename($item2->attachs) }}" target="_blank">
                                                {!! HP::FileExtension($item2->attachs)  ?? '' !!}
                                            </a>
                                        @endif 
                                    </span> 
                                </label> 
                        @endif
                 </td>
                @endif
              
            </tr>
            @endforeach 
        </tbody>
       </table>
    @endif
 @endif


 @if(!is_null($item->details_three)) 
 <div class="row">
 <div class="col-md-3 text-right">
     <p class="text-nowrap">รายงานการตรวจประเมิน :</p>
 </div>
 <div class="col-md-9">
     <p>
        {{-- @if($item->details_three!=''  && HP::checkFileStorage($attach_path.$item->details_three) ) --}}
            <a href="{{url('certify/check/file_cb_client/'.$item->details_three.'/'.( !empty($item->file_client_name) ? $item->file_client_name :  basename($item->details_three) ))}}" 
               title="{{ !empty($item->file_client_name) ? $item->file_client_name :  basename($item->details_three) }}" target="_blank">
                {!! HP::FileExtension($item->details_three)  ?? '' !!}
            </a>
       {{-- @endif  --}}
     </p>
 </div>
 </div>
 @endif

 @if(!is_null($item->file)) 
 <div class="row">
 <div class="col-md-3 text-right">
     <p class="text-nowrap">ไฟล์แนบ :</p>
 </div>
 <div class="col-md-9">
         @php 
             $files = json_decode($item->file);
         @endphp  
         @foreach($files as  $key => $item2)
             {{-- <p> --}}
                {{-- @if($item2->file!=''  && HP::checkFileStorage($attach_path.$item2->file) ) --}}
                <a href="{{url('certify/check/file_cb_client/'.$item2->file.'/'.( !empty($item2->file_client_name) ? $item2->file_client_name :  basename($item2->file) ))}}" 
                    title="{{ !empty($item2->file_client_name) ? $item2->file_client_name :  basename($item2->file) }}" target="_blank">
                    {!! HP::FileExtension($item2->file)  ?? '' !!}
                </a>
               {{-- @endif  --}}
    
            {{-- </p> --}}
         @endforeach
 </div>
 </div>
 @endif


 @if(!is_null($item->created_at)) 
 <div class="row">
 <div class="col-md-3 text-right">
     <p class="text-nowrap">วันที่เจ้าหน้าที่บันทึก :</p>
 </div>
 <div class="col-md-9">
     {{ @HP::DateThai($item->created_at) ?? '-' }}
 </div>
 </div>
 @endif

 @if(!is_null($item->date)) 
 <div class="row">
 <div class="col-md-3 text-right">
     <p class="text-nowrap">วันที่ผู้ประกอบการบันทึก :</p>
 </div>
 <div class="col-md-9">
     {{ @HP::DateThai($item->date) ?? '-' }}
 </div>
 </div>
 @endif

        </div>
    </div>
 </div>   
 
 @endforeach  

    </div>
</div>
                </div>
            </div>
        </div>
    </div>
</div>

       </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
    <legend><h3>ผลการตรวจประเมิน</h3></legend>    
<div class="row">
    <div class="col-md-12">
        <div class="panel block4">
            <div class="panel-group" id="accordion">
            <div class="panel panel-info">
  
 <div class="panel-heading">
    <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#inspection"> <dd> ประวัติบันทึกผลการตรวจประเมิน</dd>  </a>
    </h4>
</div>

 <div id="inspection" class="panel-collapse collapse  in">
    <br> 


@if(count($assessment->LogCertiCBHistorys) > 0) 
@foreach($assessment->LogCertiCBHistorys as $key1 => $item1)

<div class="row form-group">
    <div class="col-md-12">
       <div class="white-box" style="border: 2px solid #e5ebec;">
  {{-- <legend><h3> ครั้งที่ {{ $key1 +1}} </h3></legend> --}}

<div class="container-fluid">

<div class="row ">
        <div class="col-md-6">
            <label class="col-md-6 text-right"> รายงานการตรวจประเมิน : </label>
            <div class="col-md-6">
                @if(!is_null($item1->details_three))
                   <p>
                        {{-- @if($item1->details_three!=''  && HP::checkFileStorage($attach_path.$item1->details_three) ) --}}
                           <a href="{{url('certify/check/file_cb_client/'.$item1->details_three.'/'.( !empty($item1->file_client_name) ? $item1->file_client_name :  basename($item1->details_three) ))}}" 
                                title="{{ !empty($item1->file_client_name) ? $item1->file_client_name :  basename($item1->details_three) }}" target="_blank">
                                {!! HP::FileExtension($item1->details_three)  ?? '' !!}
                            </a>
                        {{-- @endif  --}}
                 </p>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            @if(!is_null($item1->attachs_car))
            <label class="col-md-6 text-right"> รายงานปิด Car : </label>
            <div class="col-md-6">
                        <p>
                           {{-- @if($item1->attachs_car!=''  && HP::checkFileStorage($attach_path.$item1->attachs_car) ) --}}
                               <a href="{{url('certify/check/file_cb_client/'.$item1->attachs_car.'/'.( !empty($item1->attach_client_name) ? $item1->attach_client_name : basename($item1->attachs_car) ))}}" 
                                    title="{{ !empty($item1->attach_client_name) ? $item1->attach_client_name :  basename($item1->attachs_car) }}" target="_blank">
                                    {!! HP::FileExtension($item1->attachs_car)  ?? '' !!}
                               </a>
                           {{-- @endif  --}}
                        </p>
            </div>
            @endif
        </div>
</div>

<div class="row">
    @if(!is_null($item1->details_four))
    <div class="col-md-6">
        <label class="col-md-6 text-right">Scope : </label>
        <div class="col-md-6">
                 @php
                      $details_four = json_decode($item1->details_four);
                @endphp
                @if(!is_null($details_four))
                @foreach ($details_four as $item2)
                    {{-- <p> --}}
                        {{-- @if($item2->file!=''  && HP::checkFileStorage($attach_path.$item2->file) ) --}}
                        <a href="{{url('certify/check/file_cb_client/'.$item2->file.'/'.( !empty($item2->file_client_name) ? $item2->file_client_name :   basename($item2->file) ))}}" 
                            title="{{ !empty($item2->file_client_name) ? $item2->file_client_name :  basename($item2->file) }}" target="_blank">
                            {!! HP::FileExtension($item2->file)  ?? '' !!}
                        </a>
                       {{-- @endif  --}}
                   
                    {{-- </p> --}}
                @endforeach
                @endif
        </div>
    </div>
    @endif
    @if(!is_null($item1->attachs))
    <div class="col-md-6">
        <label class="col-md-7 text-right"> สรุปรายงานการตรวจทุกครั้ง : </label>
        <div class="col-md-5">
                 @php
                      $attachs = json_decode($item1->attachs);
                @endphp
                @if(!is_null($attachs))
                @foreach ($attachs as $item3)
                    {{-- <p> --}}
                        {{-- @if($item3->file!=''  && HP::checkFileStorage($attach_path.$item3->file) ) --}}
                        <a href="{{url('certify/check/file_cb_client/'.$item3->file.'/'.( !empty($item3->file_client_name) ? $item3->file_client_name :  basename($item3->file) ))}}" 
                            title="{{ !empty($item3->file_client_name) ? $item3->file_client_name :  basename($item3->file) }}" target="_blank">
                            {!! HP::FileExtension($item3->file)  ?? '' !!}
                        </a>
                       {{-- @endif  --}}
                    {{-- </p> --}}
                @endforeach
                @endif
        </div>
    </div>
    @endif
</div>
<div class="row">
    @if(!is_null($item1->file))
    <div class="col-md-6">
        <label class="col-md-6 text-right"> ไฟล์แนบ : </label>
        <div class="col-md-6">
                 @php
                      $files = json_decode($item1->file);
                @endphp
                @if(!is_null($files))
                @foreach ($files as $item4)
                    {{-- <p> --}}
                        {{-- @if($item4->file!=''  && HP::checkFileStorage($attach_path.$item4->file) ) --}}
                         <a href="{{url('certify/check/file_cb_client/'.$item4->file.'/'.( !empty($item4->file_client_name) ? $item4->file_client_name :  basename($item4->file) ))}}" 
                            title="{{ !empty($item4->file_client_name) ? $item4->file_client_name :  basename($item4->file) }}" target="_blank">
                            {!! HP::FileExtension($item4->file)  ?? '' !!}
                        </a>
                       {{-- @endif  --}}
                   
                    {{-- </p> --}}
                @endforeach
                @endif
        </div>
    </div>
    @endif
</div>

<hr>
@if(!is_null($item1->status))
<div class="form-group">
    <div class="col-md-12">
        <label class="col-md-3 text-right">  เห็นชอบกับ Scope : </label>
        <div class="col-md-7">
            <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-green" {{ ($item1->status == 1 ) ? 'checked' : ' '  }}>  &nbsp;ยืนยัน Scope &nbsp;</label>
            <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-red" {{ ($item1->status == 2 ) ? 'checked' : ' '  }}>  &nbsp; แก้ไข Scope &nbsp;</label>
        </div>
    </div>
</div>
@endif

@if(!is_null($item1->remark))
<div class="form-group">
    <div class="col-md-12">
        <label class="col-md-3 text-right"> หมายเหตุ : </label>
        <div class="col-md-7">
                {{ $item1->remark ?? null }}
        </div>
    </div>
</div>
@endif

<div class="form-group">
    <div class="col-md-12">
        @if(!is_null($item1->attachs_file))
        <label class="col-md-3 text-right"> ไฟล์แนบ : </label>
        <div class="col-md-7">
                @php
                      $attachs_file = json_decode($item1->attachs_file);
                @endphp
                @foreach ($attachs_file as $item13)
                    <p>
                       {{ @$item13->file_desc}}
                        {{-- @if($item13->file!=''  && HP::checkFileStorage($attach_path.$item13->file) ) --}}
                            <a href="{{url('certify/check/file_cb_client/'.$item13->file.'/'.( !empty($item13->file_client_name) ? $item13->file_client_name :  basename($item13->file) ))}}" 
                                title="{{ !empty($item13->file_client_name) ? $item13->file_client_name :  basename($item13->file) }}" target="_blank">
                                {!! HP::FileExtension($item13->file)  ?? '' !!}
                            </a>
                       {{-- @endif  --}}
                    </p>
                @endforeach
         
        </div>
         @endif
    </div>
</div>
@if(!is_null($item1->date)) 
<div class="row">
<label class="col-md-3 text-right">
    วันที่บันทึก :
</label>
<div class="col-md-9">
    {{ @HP::DateThai($item1->date) ?? '-' }}
</div>
</div>
@endif
 
</div>

        </div>
    </div>
</div>
 
@endforeach
@endif




</div>             
              </div>
           </div>
        </div>
    </div>
</div>


       </div>
    </div>
</div>

 {!! Form::open(['url' => 'certify/applicant-cb/inspection/update/'.$assessment->id,
                'class' => 'form-horizontal',
                'id'=>'form_auditor', 
                'files' => true])
 !!}
@if($assessment->degree == 4 || $assessment->degree == 6)
<div class="row">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
    <legend><h3>เหตุผล / หมายเหตุ ขอแก้ไข</h3></legend>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3 text-right">
                     <p class="text-nowrap">เห็นชอบกับ Scope  </p>
                </div>
                <div class="col-md-9">
                        <label>{!! Form::radio('status_scope', '1', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ยืนยัน Scope &nbsp;</label>
                        <label>{!! Form::radio('status_scope', '2', false, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} &nbsp;ขอแก้ไข Scope &nbsp;</label>
                </div>
            </div>
            <div  style="display: none" id="DivStatusScope">
                <div class="row">
                    <div class="col-md-3"></div>
                     <div class="col-md-7">
                        <label for="details">หมายเหตุ :</label>
                         <textarea name="details" id="details" cols="30" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                 <div class="row m-t-20">
                    <div class="col-md-3"></div>
                    <div class="col-md-7">
                           {!! Form::label('attach_files', 'ไฟล์แนบ (ถ้ามี):', ['class' => 'm-t-5']) !!}
                               <button type="button" class="btn btn-sm btn-success m-l-10 attach_add_scope" id="attach_add_scope">
                                     <i class="icon-plus"></i>&nbsp;เพิ่ม
                                 </button>
                                   
                                 <div id="modal_attach_box">
                                      <div class="form-group attach_item">
                                        <div class="col-md-5">
                                             {!! Form::text('file_desc_text[]', null, ['class' => 'form-control m-t-10', 'placeholder' => 'ชื่อไฟล์']) !!}
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
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>

        <div class="col-md-12">
            <div class="row">
                 <div class="col-md-3 text-right">
                         <p class="text-nowrap">วันที่บันทึก</p>
                  </div>
                    <div class="col-md-9" >
                        {{ HP::DateThai(date('Y-m-d')) }}
                   </div>
             </div>
         </div>

         </div>
        </div>
     </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        <div class="col-md-offset-5 col-md-6">
                <button class="btn btn-primary" type="submit"  onclick="submit_form();return false">
                <i class="fa fa-paper-plane"></i> บันทึก
                </button>
                    <a class="btn btn-default" href="{{url('/certify/applicant-cb')}}">
                        <i class="fa fa-rotate-left"></i> ยกเลิก
                    </a>
        </div>
    </div>
</div> 


@else 
<a  href="{{ url("$previousUrl") }}">
    <div class="alert alert-dark text-center" role="alert">
        <i class="fa fa-close"></i>
        <b>กลับ</b>
    </div>
</a>

@endif
{!! Form::close() !!}   


            </div>  
        </div>  
    </div>
 </div>   
 @endsection
 
@push('js')
<script src="{{ asset('plugins/components/icheck/icheck.min.js') }}"></script>
<script src="{{ asset('plugins/components/icheck/icheck.init.js') }}"></script>
<!-- input calendar thai -->
<script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
<!-- thai extension -->
<script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
<script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>
<script src="{{asset('js/jasny-bootstrap.js')}}"></script>
<script src="{{asset('plugins/components/sweet-alert2/sweetalert2.all.min.js')}}"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
        $('.check-readonly').prop('disabled', true);//checkbox ความคิดเห็น
        $('.check-readonly').parent().removeClass('disabled');
        $('.check-readonly').parent().css('margin-top', '8px');//checkbox ความคิดเห็น

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

    $("input[name=status_scope]").on("ifChanged",function(){
         status_status_scope();
    });
    status_status_scope();

});

function status_status_scope(){
         var row = $("input[name=status_scope]:checked").val();
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
                    $('#form_auditor').submit();
                }
            })
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
@endpush
