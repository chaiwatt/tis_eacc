<style>
        .symbol-btn {
        width: 60px; /* ปรับความกว้างตามที่ต้องการ */
        margin: 5px; /* ช่องว่างระหว่างปุ่ม */
    }
/* เส้นขอบรอบตาราง */
.custom-bordered-table {
    border-collapse: separate;
    border: 0.5px solid #dee2e6; /* เส้นขอบรอบตาราง */
    border-spacing: 0; /* ไม่มีช่องว่างระหว่างเซลล์ */
}

/* เส้นขอบเฉพาะด้านซ้ายและขวาสำหรับ td และ th */
.custom-bordered-table td,
.custom-bordered-table th {
    border-left: 0.5px solid #dee2e6 !important; /* ขอบซ้าย */
    border-right: 0.5px solid #dee2e6 !important; /* ขอบขวา */
    border-top: none !important; /* ไม่มีขอบบน */
    border-bottom: none !important; /* ไม่มีขอบล่าง */
}

/* ยกเลิกเส้นขอบที่อาจซ้อนมาจาก Bootstrap */
.custom-bordered-table th,
.custom-bordered-table td {
    border-top: 0 !important;
    border-bottom: 0 !important;
}

/* เส้นขอบด้านล่างสุดของตาราง */
.custom-bordered-table tr:last-child td {
    border-bottom: none !important; /* ยกเลิกขอบล่างของแถวสุดท้าย */
}

    /* ปิดเอฟเฟกต์ hover */
    .table-no-hover tbody tr:hover {
        background-color: transparent !important;
    }

    .editable-div {
    width: 200px;
    min-height: 100px;
    white-space: pre-wrap;
    font-family: Arial, sans-serif;
    overflow-wrap: break-word;
    border: 1px solid #ccc;
    padding: 4px;
    outline: none;
}

.editable-div:focus {
    border-color: #666;
}

[id^="result"] {
    margin-top: 10px;
}

.select2-results__option {
    white-space: normal; /* อนุญาตให้ข้อความขึ้นบรรทัดใหม่ */
    line-height: 1.5; /* ปรับระยะห่างระหว่างบรรทัด */
}

.select2-results__option span {
    display: block; /* ทำให้แต่ละ span ขึ้นบรรทัดใหม่ */
}

</style>

<div class="modal fade" id="modal-add-ib-scope">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title">
                    <span id="scope-modal-title">เพิ่มขอบข่ายหน่วยตรวจ (IB)</span>  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </h4>
                <h5>
                  <span class="text-danger">*โปรดทราบ!! ถ้าไม่พบขอบข่ายที่ต้องการ โปรดติดต่อเจ้าหน้าที่เพื่อเพิ่มเติมขอบข่าย ==></span> <span><a href="{{url('certify/scope-request/lab-scope-request')}}" target="_blank">ขอเพิ่มขอบข่าย</a></span>
                </h5>
            </div>
            <div class="modal-body">
                <fieldset class="white-box">
                    <div class="row" id="select_wrapper">
                        <div class="col-md-4 form-group">
                            <label for="">สาขา</label>
                            <select class="form-control" name="" id="main_category_ib">
                            </select>
                        </div>
                        <div class="col-md-4 form-group" id="sub_category_ib_wrapper" style="display: none;">
                            <label for="">สาขาการย่อย</label>
                            <select class="form-control" name="" id="sub_category_ib">
                            </select>
                        </div>
                        <div class="col-md-4 form-group" id="scope_topic_ib_wrapper" style="display: none;">
                            <label for="">ขอบข่ายย่อย1</label>
                            <select class="form-control" name="" id="scope_topic_ib">
                            </select>
                        </div>
                        <div class="col-md-4 form-group" id="scope_detail_ib_wrapper" style="display: none;">
                            <label for="">ขอบข่ายย่อย2</label>
                            <select class="form-control" name="" id="scope_detail_ib">
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group"> 
                            <label for="">ข้อกำหนดที่ใช้</label>
                            <textarea name="standard" id="standard" rows="5" class="form-control"></textarea>
                         </div>
                    </div>
                </fieldset>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success pull-right ml-2" id="button_add_ib_scope">
                    <span aria-hidden="true">เพิ่ม</span>
                </button>
            </div>
        </div>
    </div>
</div>

<fieldset class="white-box">
    <legend><h4><span class="text-danger">*</span> 2. คู่มือคุณภาพและขั้นตอนการดำเนินงานของหน่วยงานตรวจสอบที่สอดคล้องตามข้อกำหนดมาตรฐานเลขที่ มอก.17020 (Inspection body implementations which are conformed with TIS 17020)</h4></legend>

    <div class="row repeater-form-file">
        <div class="col-md-12 box_section1" data-repeater-list="repeater-section1" >

            @php
                $section1_required = 'required';
            @endphp

            @if ( isset( $certi_ib->id ) && count( App\Models\Certify\ApplicantIB\CertiIBAttachAll::where('app_certi_ib_id', $certi_ib->id )->where('file_section', '1')->get() ) > 0 )

                @php
                    $section1_required = '';
                    $file_sectionn1 = App\Models\Certify\ApplicantIB\CertiIBAttachAll::where('app_certi_ib_id', $certi_ib->id )->where('file_section', '1')->get();
                @endphp

                @foreach ( $file_sectionn1 as $section1 )
                    <div class="form-group">
                        <div class="col-md-4 text-light"></div>
                        <div class="col-md-6">
                            <a href="{!! HP::getFileStorage($attach_path.$section1->file) !!}" target="_blank" class="view-attach btn btn-info btn-sm"> {!! HP::FileExtension($section1->file_client_name)  ?? '' !!}</a>
                            <a href="{{url('certify/applicant-ib/delete/file_app_certi_ib_attach_all').'/'.$section1->id.'/'.$certi_ib->token}}" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                <i class="fa fa-remove"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
                
            @endif

            <div class="form-group box_remove_file" data-repeater-item>
                <div class="col-md-4 text-light"></div>
                <div class="col-md-6">
                    <div class="fileinput fileinput-new input-group " data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput">
                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                            <span class="fileinput-filename"></span>
                        </div>
                        <span class="input-group-addon btn btn-default btn-file">
                            <span class="fileinput-new">เลือกไฟล์</span>
                            <span class="fileinput-exists">เปลี่ยน</span>
                            <input type="file" name="attachs_sec1" class="attachs_sec1 check_max_size_file" {!!  $section1_required !!}>
                        </span> 
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    {!! $errors->first('attachs_sec1', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger delete-sec1" type="button" data-repeater-delete>
                        <i class="fa fa-close"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success" data-repeater-create><i class="icon-plus"></i>เพิ่ม</button>
                </div>
            </div> 
        </div>
    </div>

</fieldset>

<fieldset class="white-box">
    <legend><h4>3. รายชื่อคุณวุฒิประสบการณ์และขอบข่ายความรับผิดชอบของเจ้าหน้าที่ (List of relevant personnel providing name, qualification, experience and responsibility)</h4></legend>
    <div class="row repeater-form-file">
        <div class="col-md-12 box_section2" data-repeater-list="repeater-section2" >

            @if ( isset( $certi_ib->id ) && count( App\Models\Certify\ApplicantIB\CertiIBAttachAll::where('app_certi_ib_id', $certi_ib->id )->where('file_section', '2')->get() ) > 0 )

                @php
                    $file_sectionn2 = App\Models\Certify\ApplicantIB\CertiIBAttachAll::where('app_certi_ib_id', $certi_ib->id )->where('file_section', '2')->get();
                @endphp
        
                @foreach ( $file_sectionn2 as $section2 )
                    <div class="form-group">
                        <div class="col-md-4 text-light"></div>
                        <div class="col-md-6">
                            <a href="{!! HP::getFileStorage($attach_path.$section2->file) !!}" target="_blank" class="view-attach btn btn-info btn-sm"> {!! HP::FileExtension($section2->file_client_name)  ?? '' !!}</a>
                            <a href="{{url('certify/applicant-ib/delete/file_app_certi_ib_attach_all').'/'.$section2->id.'/'.$certi_ib->token}}" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                <i class="fa fa-remove"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
                
            @endif

            <div class="form-group box_remove_file" data-repeater-item>
                <div class="col-md-4 text-light"></div>
                <div class="col-md-6">
                    <div class="fileinput fileinput-new input-group " data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput">
                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                            <span class="fileinput-filename"></span>
                        </div>
                        <span class="input-group-addon btn btn-default btn-file">
                            <span class="fileinput-new">เลือกไฟล์</span>
                            <span class="fileinput-exists">เปลี่ยน</span>
                            <input type="file" name="attachs_sec2" class="attachs_sec2 check_max_size_file">
                        </span> 
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    {!! $errors->first('attachs_sec2', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger delete-sec2" type="button" data-repeater-delete>
                        <i class="fa fa-close"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success" data-repeater-create><i class="icon-plus"></i>เพิ่ม</button>
                </div>
            </div> 
        </div>
        <div class="col-md-12">
            <table class="table">
                <tr>
                    <th>หมวดหมู่ / สาขาการตรวจ </th>
                    <th>ขั้นตอนและช่วงการตรวจ </th>
                    <th>ข้อกำหนดที่ใช้ </th>
                </tr>
                <tbody id="ib_scope_wrapper"></tbody>
                
            </table>
        </div>
    </div>

    @if ($methodType != 'show')
        <div class="row repeater-form-file">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-md-10"></div>
                    <div class="col-md-2">
                        <button type="button" id="btn_add_ib_scope" class="btn btn-success">
                            <i class="icon-plus"></i>เพิ่มขอบข่าย
                        </button>
                    </div>
                </div> 
            </div>
        </div>
    @endif
</fieldset>

<fieldset class="white-box">
    <legend>
        <h4>
            <span class="text-danger">*</span> 4. ขอบข่ายที่ยื่นขอรับการรับรอง (Scope of Accreditation Sought)
            <span class="text-danger">ไฟล์แนบ Word</span><span class="text-danger" style="font-size: 13px;"> (doc,docx)</span>
        </h4>
    </legend>
    <div class="row repeater-form-file">
        <div class="col-md-12 box_section3" data-repeater-list="repeater-section3" >

            @php
                $section3_required = 'required';
            @endphp

            @if ( isset( $certi_ib->id ) && count( App\Models\Certify\ApplicantIB\CertiIBAttachAll::where('app_certi_ib_id', $certi_ib->id )->where('file_section', '3')->get() ) > 0 )

                @php
                    $section3_required = '';
                    $file_sectionn3 = App\Models\Certify\ApplicantIB\CertiIBAttachAll::where('app_certi_ib_id', $certi_ib->id )->where('file_section', '3')->get();
                @endphp
        
                @foreach ( $file_sectionn3 as $section3 )
                    <div class="form-group">
                        <div class="col-md-4 text-light"></div>
                        <div class="col-md-6">
                            <a href="{!! HP::getFileStorage($attach_path.$section3->file) !!}" target="_blank" class="view-attach btn btn-info btn-sm"> {!! HP::FileExtension($section3->file_client_name)  ?? '' !!}</a>
                            <a href="{{url('certify/applicant-ib/delete/file_app_certi_ib_attach_all').'/'.$section3->id.'/'.$certi_ib->token}}" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                <i class="fa fa-remove"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
                
            @endif

            <div class="form-group box_remove_file" data-repeater-item>
                <div class="col-md-4 text-light"></div>
                <div class="col-md-6">
                    <div class="fileinput fileinput-new input-group " data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput">
                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                            <span class="fileinput-filename"></span>
                        </div>
                        <span class="input-group-addon btn btn-default btn-file">
                            <span class="fileinput-new">เลือกไฟล์</span>
                            <span class="fileinput-exists">เปลี่ยน</span>
                            <input type="file" name="attachs_sec3" class="attachs_sec3 check_max_size_file" {!! $section3_required !!}>
                        </span> 
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    {!! $errors->first('attachs_sec3', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger delete-sec3" type="button" data-repeater-delete>
                        <i class="fa fa-close"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success" data-repeater-create><i class="icon-plus"></i>เพิ่ม</button>
                </div>
            </div> 
        </div>
    </div>

</fieldset>

<fieldset class="white-box">
    <legend>
        <h4>
            <span class="text-danger">*</span> 5. เครื่องมือ (Equipment)   
        </h4>
    </legend>

    <div class="row repeater-form-file">
        <div class="col-md-12 box_section4" >
            <div class="form-group">
                <div class="col-md-4  text-light">
                    {!! Form::label('attachs_sec4', 'กรุณาแนบไฟล์เครื่องมือ', ['class' => 'col-md-12 label_attach text-light  control-label ']) !!}
                </div>
                <div class="col-md-6" data-repeater-list="repeater-section4" >
                    @php
                        $section4_required = 'required';
                    @endphp
                    @if ( isset( $certi_ib->id ) && count( App\Models\Certify\ApplicantIB\CertiIBAttachAll::where('app_certi_ib_id', $certi_ib->id )->where('file_section', '4')->get() ) > 0 )

                        @php
                            $section4_required = '';
            
                            $file_sectionn4 = App\Models\Certify\ApplicantIB\CertiIBAttachAll::where('app_certi_ib_id', $certi_ib->id )->where('file_section', '4')->get();
                        @endphp
            
                        @foreach ( $file_sectionn4 as $section4 )
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <a href="{!! HP::getFileStorage($attach_path.$section4->file) !!}" target="_blank" class="btn btn-info btn-sm"> {!! HP::FileExtension($section4->file_client_name)  ?? '' !!}</a>
                                    <a href="{{url('certify/applicant-ib/delete/file_app_certi_ib_attach_all').'/'.$section4->id.'/'.$certi_ib->token}}" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                        <i class="fa fa-remove"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <div class="row box_remove_file" data-repeater-item>
                        <div class="col-md-10">
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput">
                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                    <span class="fileinput-filename"></span>
                                </div>
                                <span class="input-group-addon btn btn-default btn-file">
                                    <span class="fileinput-new">เลือกไฟล์</span> 
                                    <span class="fileinput-exists">เปลี่ยน</span>
                                    <input type="file" name="attachs_sec4" class="attachs_sec4 check_max_size_file" {!! $section4_required !!}>
                                </span>
                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-danger  delete-sec4" type="button" data-repeater-delete>
                                <i class="fa fa-close"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-9"></div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-success" data-repeater-create><i class="icon-plus"></i>เพิ่ม</button>
                </div>
            </div> 
        </div>
    </div>

</fieldset>

<fieldset class="white-box">
    <legend>
        <h4>
            6. วัสดุอ้างอิง/มาตรฐานอ้างอิง (Reference material / Reference TIS)  
        </h4>
    </legend>

    <div class="row repeater-form-file">
        <div class="col-md-12 box_section5" data-repeater-list="repeater-section5" >

            @if ( isset( $certi_ib->id ) && count( App\Models\Certify\ApplicantIB\CertiIBAttachAll::where('app_certi_ib_id', $certi_ib->id )->where('file_section', '5')->get() ) > 0 )

                @php
                    $file_sectionn5 = App\Models\Certify\ApplicantIB\CertiIBAttachAll::where('app_certi_ib_id', $certi_ib->id )->where('file_section', '5')->get();
                @endphp
        
                @foreach ( $file_sectionn5 as $section5 )
                    <div class="form-group">
                        <div class="col-md-4 text-light"></div>
                        <div class="col-md-6">
                            <a href="{!! HP::getFileStorage($attach_path.$section5->file) !!}" target="_blank" class="view-attach btn btn-info btn-sm"> {!! HP::FileExtension($section5->file_client_name)  ?? '' !!}</a>
                            <a href="{{url('certify/applicant-ib/delete/file_app_certi_ib_attach_all').'/'.$section5->id.'/'.$certi_ib->token}}" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                <i class="fa fa-remove"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
                
            @endif

            <div class="form-group box_remove_file" data-repeater-item>
                <div class="col-md-4 text-light"></div>
                <div class="col-md-6">
                    <div class="fileinput fileinput-new input-group " data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput">
                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                            <span class="fileinput-filename"></span>
                        </div>
                        <span class="input-group-addon btn btn-default btn-file">
                            <span class="fileinput-new">เลือกไฟล์</span>
                            <span class="fileinput-exists">เปลี่ยน</span>
                            <input type="file" name="attachs_sec5" class="attachs_sec5 check_max_size_file">
                        </span> 
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    {!! $errors->first('attachs_sec5', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger delete-sec5" type="button" data-repeater-delete>
                        <i class="fa fa-close"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success" data-repeater-create><i class="icon-plus"></i>เพิ่ม</button>
                </div>
            </div> 
        </div>
    </div>

</fieldset>

<fieldset class="white-box">
    <legend>
        <h4>    
            7. การเข้าร่วมการทดสอบความชำนาญ / การเปรียบเทียบผลระหว่างห้องปฏิบัติการ (Participation in Proficiency testing program / Interlaboratory comparison)   
        </h4>
    </legend>

    <div class="row repeater-form-file">
        <div class="col-md-12 box_section6" data-repeater-list="repeater-sectio6" >
            @if ( isset( $certi_ib->id ) && count( App\Models\Certify\ApplicantIB\CertiIBAttachAll::where('app_certi_ib_id', $certi_ib->id )->where('file_section', '6')->get() ) > 0 )

                @php
                    $file_sectionn6 = App\Models\Certify\ApplicantIB\CertiIBAttachAll::where('app_certi_ib_id', $certi_ib->id )->where('file_section', '6')->get();
                @endphp
        
                @foreach ( $file_sectionn6 as $section6 )
                    <div class="form-group">
                        <div class="col-md-4 text-light"></div>
                        <div class="col-md-6">
                            <a href="{!! HP::getFileStorage($attach_path.$section6->file) !!}" target="_blank" class="view-attach btn btn-info btn-sm"> {!! HP::FileExtension($section6->file_client_name)  ?? '' !!}</a>
                            <a href="{{url('certify/applicant-ib/delete/file_app_certi_ib_attach_all').'/'.$section6->id.'/'.$certi_ib->token}}" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                <i class="fa fa-remove"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
                
            @endif

            <div class="form-group box_remove_file" data-repeater-item>
                <div class="col-md-4 text-light"></div>
                <div class="col-md-6">
                    <div class="fileinput fileinput-new input-group " data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput">
                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                            <span class="fileinput-filename"></span>
                        </div>
                        <span class="input-group-addon btn btn-default btn-file">
                            <span class="fileinput-new">เลือกไฟล์</span>
                            <span class="fileinput-exists">เปลี่ยน</span>
                            <input type="file" name="attachs_sec6" class="attachs_sec6 check_max_size_file">
                        </span> 
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    {!! $errors->first('attachs_sec6', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger delete-sec6" type="button" data-repeater-delete>
                        <i class="fa fa-close"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success" data-repeater-create><i class="icon-plus"></i>เพิ่ม</button>
                </div>
            </div> 
        </div>
    </div>

</fieldset>

<fieldset class="white-box">
    <legend>
        <h4>    
            8. เอกสารอ้างอิง ชื่อย่อ
        </h4>
    </legend>

    <div class="row repeater-form-file">
        <div class="col-md-12 box_section8" data-repeater-list="repeater-section8" >
            @if ( isset( $certi_ib->id ) && count( App\Models\Certify\ApplicantIB\CertiIBAttachAll::where('app_certi_ib_id', $certi_ib->id )->where('file_section', '8')->get() ) > 0 )

                @php
                    $file_sectionn8 = App\Models\Certify\ApplicantIB\CertiIBAttachAll::where('app_certi_ib_id', $certi_ib->id )->where('file_section', '8')->get();
                @endphp
        
                @foreach ( $file_sectionn8 as $section8 )
                    <div class="form-group">
                        <div class="col-md-4 text-light"></div>
                        <div class="col-md-6">
                            <a href="{!! HP::getFileStorage($attach_path.$section8->file) !!}" target="_blank" class="view-attach btn btn-info btn-sm"> {!! HP::FileExtension($section8->file_client_name)  ?? '' !!}</a>
                            <a href="{{url('certify/applicant-ib/delete/file_app_certi_ib_attach_all').'/'.$section8->id.'/'.$certi_ib->token}}" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                <i class="fa fa-remove"></i>
                            </a>
                        </div>
                    </div>
                @endforeach

            @else
                <div class="form-group box_remove_file" data-repeater-item>
                    <div class="col-md-4 text-light"></div>
                    <div class="col-md-6">
                        <div class="fileinput fileinput-new input-group " data-provides="fileinput">
                            <div class="form-control" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                <span class="fileinput-filename"></span>
                            </div>
                            <span class="input-group-addon btn btn-default btn-file">
                                <span class="fileinput-new">เลือกไฟล์</span>
                                <span class="fileinput-exists">เปลี่ยน</span>
                                <input type="file" name="attachs_sec8" class="attachs_sec8 check_max_size_file">
                            </span> 
                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                        </div>
                        {!! $errors->first('attachs_sec6', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                
            @endif
        </div>
    </div>


</fieldset>

<fieldset class="white-box">
    <legend>
        <h4>    
            เอกสารอื่นๆ (Others)  
        </h4>
    </legend>

    <div class="row repeater-form-file">
        <div class="col-md-12 box_section_other" data-repeater-list="repeater-section7" >

            @if ( isset( $certi_ib->id ) && count( App\Models\Certify\ApplicantIB\CertiIBAttachAll::where('app_certi_ib_id', $certi_ib->id )->where('file_section', '7')->get() ) > 0 )

                @php
                    $file_sectionn7 = App\Models\Certify\ApplicantIB\CertiIBAttachAll::where('app_certi_ib_id', $certi_ib->id )->where('file_section', '7')->get();
                @endphp
        
                @foreach ( $file_sectionn7 as $section7 )
                    <div class="form-group">
                        <div class="col-md-4 text-light"><input type="text" class='form-control' value="{!! !empty( $section7->file_desc )?$section7->file_desc:null !!}" disabled></div>
                        <div class="col-md-6">
                            <a href="{!! HP::getFileStorage($attach_path.$section7->file) !!}" target="_blank" class="view-attach btn btn-info btn-sm"> {!! HP::FileExtension($section7->file_client_name)  ?? '' !!}</a>
                            <a href="{{url('certify/applicant-ib/delete/file_app_certi_ib_attach_all').'/'.$section7->id.'/'.$certi_ib->token}}" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                <i class="fa fa-remove"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
                
            @endif

            <div class="form-group box_remove_file" data-repeater-item>
                <div class="col-md-4 text-light">
                    {!! Form::text('attachs_txt', null, ['class' => 'form-control', 'placeholder' => 'กรุณากรอกชื่อไฟล์']) !!}
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
                            <input type="file" name="attachs_sec7" class="attachs_sec7 check_max_size_file">
                        </span> 
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    {!! $errors->first('attachs_sec7', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger delete-sec7" type="button" data-repeater-delete>
                        <i class="fa fa-close"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success" data-repeater-create><i class="icon-plus"></i>เพิ่ม</button>
                </div>
            </div> 
        </div>
    </div>

</fieldset>
@push('js')
<script>

let transactions = [];

// เมื่อหน้าโหลด ให้เริ่มต้น array ว่าง
$(document).ready(function() {
    transactions = []; // สร้าง array ว่างสำหรับเก็บ transactions
});
    
// เมื่อคลิกปุ่มเพิ่ม scope
$('#btn_add_ib_scope').on('click', function() {
    const _token = $('input[name="_token"]').val();
    $.ajax({
        url: "{{ route('certi_ib.get-ib-main-category') }}",
        method: "POST",
        contentType: 'application/json',
        headers: {
            'X-CSRF-TOKEN': _token
        },
        success: function(response) {
            ibMainCategoryScopes = response.ibMainCategoryScopes;
            $('#main_category_ib').empty();
            $('#main_category_ib').select2('destroy').empty();
            $('#main_category_ib').append('<option value="not_select" disabled selected>- สาขาทดสอบ -</option>');
            $.each(ibMainCategoryScopes, function (index, value) {
                $('#main_category_ib').append('<option value="' + value.id + '">' + value.name + '</option>');
            });
            $('#main_category_ib').select2();
        }
    });
    $('#modal-add-ib-scope').modal('show');
});

// เมื่อเลือก main_category_ib
$(document).on('change', '#main_category_ib', function() {
    const _token = $('input[name="_token"]').val();
    const ibMainCategoryScopeId = $(this).val();

    if (ibMainCategoryScopeId !== 'not_select') {
        $.ajax({
            url: "{{ route('certi_ib.get-ib-sub-category') }}",
            method: "POST",
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': _token
            },
            data: JSON.stringify({ ib_main_category_scope_id: ibMainCategoryScopeId }),
            success: function(response) {
                const ibSubCategoryScopes = response.ibSubCategoryScopes;
                $('#sub_category_ib').empty();
                $('#sub_category_ib').select2('destroy').empty();
                $('#sub_category_ib').append('<option value="not_select" disabled selected>- เลือกสาขาการย่อย -</option>');
                $.each(ibSubCategoryScopes, function(index, value) {
                    $('#sub_category_ib').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                $('#sub_category_ib').select2();
                $('#sub_category_ib_wrapper').show(); // แสดง wrapper
            },
            error: function(xhr) {
                console.log('Error:', xhr);
            }
        });
    } else {
        $('#sub_category_ib_wrapper').hide(); // ซ่อน sub_category
        $('#scope_topic_ib_wrapper').hide();  // ซ่อน scope_topic
        $('#scope_detail_ib_wrapper').hide(); // ซ่อน scope_detail
    }
});



// เมื่อเลือก sub_category_ib
$(document).on('change', '#sub_category_ib', function() {
    const _token = $('input[name="_token"]').val();
    const ibSubCategoryScopeId = $(this).val();

    if (ibSubCategoryScopeId !== 'not_select') {
        $.ajax({
            url: "{{ route('certi_ib.get-ib-scope-topic') }}",
            method: "POST",
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': _token
            },
            data: JSON.stringify({ ib_sub_category_scope_id: ibSubCategoryScopeId }),
            success: function(response) {
                const ibScopeTopics = response.ibScopeTopics;
                $('#scope_topic_ib').empty();
                $('#scope_topic_ib').select2('destroy').empty();
                $('#scope_topic_ib').append('<option value="not_select" disabled selected>- เลือกขอบข่ายย่อย1 -</option>');
                $.each(ibScopeTopics, function(index, value) {
                    $('#scope_topic_ib').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                $('#scope_topic_ib').select2();
                $('#scope_topic_ib_wrapper').show(); // แสดง wrapper
            },
            error: function(xhr) {
                console.log('Error:', xhr);
            }
        });
    } else {
        $('#scope_topic_ib_wrapper').hide();  // ซ่อน scope_topic
        $('#scope_detail_ib_wrapper').hide(); // ซ่อน scope_detail
    }
});

// เมื่อเลือก scope_topic_ib
$(document).on('change', '#scope_topic_ib', function() {
    const _token = $('input[name="_token"]').val();
    const ibScopeTopicId = $(this).val();

    if (ibScopeTopicId !== 'not_select') {
        $.ajax({
            url: "{{ route('certi_ib.get-ib-scope-detail') }}",
            method: "POST",
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': _token
            },
            data: JSON.stringify({ ib_scope_topic_id: ibScopeTopicId }),
            success: function(response) {
                const ibScopeDetails = response.ibScopeDetails;
                $('#scope_detail_ib').empty();
                $('#scope_detail_ib').select2('destroy').empty();
                $('#scope_detail_ib').append('<option value="not_select" disabled selected>- เลือกขอบข่ายย่อย2 -</option>');
                $.each(ibScopeDetails, function(index, value) {
                    $('#scope_detail_ib').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                $('#scope_detail_ib').select2();
                $('#scope_detail_ib_wrapper').show(); // แสดง wrapper
            },
            error: function(xhr) {
                console.log('Error:', xhr);
            }
        });
    } else {
        $('#scope_detail_ib_wrapper').hide(); // ซ่อน scope_detail
    }
});


// เมื่อคลิกปุ่มเพิ่มใน modal footer
$('#button_add_ib_scope').on('click', function() {
    const mainCategoryId = $('#main_category_ib').val();
    const mainCategoryText = $('#main_category_ib option:selected').text();
    const subCategoryId = $('#sub_category_ib').val();
    const subCategoryText = $('#sub_category_ib option:selected').text();
    const scopeTopicId = $('#scope_topic_ib').val();
    const scopeTopicText = $('#scope_topic_ib option:selected').text();
    const scopeDetailId = $('#scope_detail_ib').val();
    const scopeDetailText = $('#scope_detail_ib option:selected').text();
    const standard = $('#standard').val();

    // ตรวจสอบว่าเลือกครบทุก dropdown และ textarea ไม่ว่าง
    if (mainCategoryId !== 'not_select' && subCategoryId !== 'not_select' && 
        scopeTopicId !== 'not_select' && scopeDetailId !== 'not_select' && standard.trim() !== '') {
        
        // สร้าง JSON object สำหรับ transaction รวมทั้ง ID และ text
        const transaction = {
            ib_main_category_scope_id: mainCategoryId,
            ib_main_category_scope_text: mainCategoryText,
            ib_sub_category_scope_id: subCategoryId,
            ib_sub_category_scope_text: subCategoryText,
            ib_scope_topic_id: scopeTopicId,
            ib_scope_topic_text: scopeTopicText,
            ib_scope_detail_id: scopeDetailId,
            ib_scope_detail_text: scopeDetailText,
            standard: standard
        };

        // เพิ่ม transaction ลงใน array
        transactions.push(transaction);


// เรียงลำดับ transactions ตาม main category
transactions.sort((a, b) => a.ib_main_category_scope_id - b.ib_main_category_scope_id);

// เคลียร์ข้อมูลเก่าใน <tbody>
$("#ib_scope_wrapper").empty();

// จัดกลุ่มข้อมูลตาม main category
let groupedData = {};

// จัดกลุ่ม transactions
transactions.forEach(transaction => {
    let key = transaction.ib_main_category_scope_text;
    if (!groupedData[key]) {
        groupedData[key] = [];
    }
    groupedData[key].push(transaction);
});

console.log(groupedData)

// Render ข้อมูลลงในตาราง
$.each(groupedData, function(mainCategoryText, items) {
    let mainCategoryRowSpan = items.length; // จำนวนแถวที่ต้องรวม

    let firstRow = true;
    $.each(items, function(index, transaction) {
        let row = "<tr>";

        // แสดงหมวดหมู่หลักและรายการย่อยรวมกันเพียงครั้งเดียว
        if (firstRow) {
            row += `
                <td rowspan="${mainCategoryRowSpan}">
                    <b>${transaction.ib_main_category_scope_text}</b><br>
                    - ${transaction.ib_sub_category_scope_text}
                </td>
            `;
            firstRow = false;
        }

        // แสดงขั้นตอนการตรวจสอบเป็นรายการ
        row += `
            <td>
                <ul>
                    <li>${transaction.ib_scope_topic_text}</li>
                    <li>${transaction.ib_scope_detail_text}</li>
                </ul>
            </td>
        `;

        // แสดงข้อกำหนดที่ใช้เป็นรายการ
        row += `
            <td>
                <ul>
                    <li>${transaction.standard}</li>
                </ul>
            </td>
        `;

        row += "</tr>";

        // เพิ่มแถวลงใน tbody
        $("#ib_scope_wrapper").append(row);
    });
});



        // รีเซ็ต dropdown และ textarea กลับไปที่ค่าเริ่มต้น
        $('#main_category_ib').val('not_select').trigger('change');
        $('#sub_category_ib').val('not_select').trigger('change');
        $('#scope_topic_ib').val('not_select').trigger('change');
        $('#scope_detail_ib').val('not_select').trigger('change');
        $('#standard').val('');

        // ซ่อน wrapper ของ dropdown ถัดไป
        $('#sub_category_ib_wrapper').hide();
        $('#scope_topic_ib_wrapper').hide();
        $('#scope_detail_ib_wrapper').hide();

        // ปิด modal (ถ้าต้องการ)
        $('#modal-add-ib-scope').modal('hide');
    } else {
        alert('กรุณาเลือกข้อมูลให้ครบทุกช่องและกรอกข้อกำหนดที่ใช้');
    }
});
</script>
@endpush
