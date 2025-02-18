


<fieldset class="white-box">
    <legend><h4>ข้อมูลขอรับบริการ</h4></legend>

    <div class="row">

        <?php
            $province = App\Models\Basic\Province::orderbyRaw('CONVERT(PROVINCE_NAME USING tis620)');
            // $CertificationBranch = App\Models\Bcertify\CertificationBranch::select(DB::raw("CONCAT(title,' (',initial,')') AS titles"),'id')
            //                                                                 ->where('formula_id',@$certi_cb->type_standard)
            //                                                                 ->where('state',1)
            //                                                                 ->orderbyRaw('CONVERT(titles USING tis620)')
            //                                                                 ->pluck('titles','id');
            $CertificationBranch = App\Models\Bcertify\CertificationBranch::select(
                                        DB::raw("CONCAT(title, ' (', initial, ')') AS titles"),
                                        'id',
                                        'model_name' // เพิ่ม model_name เข้ามา
                                    )
                                    ->where('formula_id', @$certi_cb->type_standard)
                                    ->where('state', 1)
                                    ->orderByRaw('CONVERT(titles USING tis620)')
                                    ->get()
                                    ->pluck(null, 'id'); // ดึงค่าทั้งหมดโดยไม่แปลงเป็น key-value คู่เดียว



            if( !isset($certi_cb->id) ){
                $app_check = App\Models\Certify\ApplicantCB\CertiCb::where( function($Query) use($tis_data){
                                                                    if(!is_null($tis_data->agent_id)){  // ตัวแทน
                                                                        $Query->where('agent_id',  $tis_data->agent_id ) ;
                                                                    }else{
                                                                        if($tis_data->branch_type == 1){  // สำนักงานใหญ่
                                                                            $Query->where('tax_id',  $tis_data->tax_number ) ;
                                                                        }else{   // ผู้บันทึก
                                                                            $Query->where('created_by',   auth()->user()->getKey()) ;
                                                                        }
                                                                    }
                                                                })
                                                                ->get();

                $certificate_no = DB::table('app_certi_cb_export AS export')
                                    ->leftJoin('app_certi_cb AS cb', 'cb.id', '=', 'export.app_certi_cb_id')
                                    ->select('export.id')
                                    ->where('cb.tax_id',$tis_data->tax_number)
                                    ->where('export.status',3)
                                    ->get();
            }

            // dd(count($certificate_no)==0);

            // $Formula_Arr = App\Models\Bcertify\Formula::where('applicant_type',1)->where('state',1)->orderbyRaw('CONVERT(title USING tis620)')->pluck('title','id');

        ?>

        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"/>

        

        <?php if(count($formulas) == 1): ?>
            <div class="form-group <?php echo e($errors->has('type_standard') ? 'has-error' : ''); ?>">
                <label for="type_standard" class="col-md-3 control-label label-height">
                    <span class="text-danger">*</span> ข้อกำหนดที่ใช้ในการรับรอง:
                    <br/><span class="font_size">(According to TIS)</span>
                </label>
                <div class="col-md-6">
                    <select name="type_standard" id="type_standard" class="form-control" required>
                        <?php $__currentLoopData = $Formula_Arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>" 
                                <?php echo e((!empty($certi_cb->type_standard) && $certi_cb->type_standard == $key) || $formulas[0]->id == $key ? 'selected' : ''); ?>>
                                <?php echo e($value); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php if($errors->has('type_standard')): ?>
                        <p class="help-block"><?php echo e($errors->first('type_standard')); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="form-group <?php echo e($errors->has('type_standard') ? 'has-error' : ''); ?>">
                <label for="type_standard" class="col-md-3 control-label label-height">
                    <span class="text-danger">*</span> ข้อกำหนดที่ใช้ในการรับรอง:
                    <br/><span class="font_size">(According to TIS)</span>
                </label>
                <div class="col-md-8">
                    <select name="type_standard" id="type_standard" class="form-control" required>
                        <option value="">- เลือกข้อกำหนดที่ใช้ในการรับรอง -</option>
                        <?php $__currentLoopData = $Formula_Arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>" 
                                <?php echo e(!empty($certi_cb->type_standard) && $certi_cb->type_standard == $key ? 'selected' : ''); ?>>
                                <?php echo e($value); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php if($errors->has('type_standard')): ?>
                        <p class="help-block"><?php echo e($errors->first('type_standard')); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>




        

        <div class="form-group <?php echo e($errors->has('petitioner') ? 'has-error' : ''); ?>">
            <label for="petitioner" class="col-md-3 control-label label-height">
                <span class="text-danger">*</span> สาขาการรับรอง:
                <br/><span class="font_size">(ฺBranch)</span>
            </label>
            <div class="col-md-8">
                <select name="petitioner" id="petitioner" class="form-control" required>
                    <option value="">- เลือกสาขาเข้าขอรับการรับรอง -</option>
                    <?php $__currentLoopData = $CertificationBranch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>" data-model = "<?php echo e($value->model_name); ?>"
                            <?php echo e(!empty($certi_cb->petitioner) && $certi_cb->petitioner == $key ? 'selected' : ''); ?>>
                            <?php echo e($value->titles); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php if($errors->has('petitioner')): ?>
                    <p class="help-block"><?php echo e($errors->first('petitioner')); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group <?php echo e($errors->has('trust_mark') ? 'has-error' : ''); ?>">
            <label for="trust_mark" class="col-md-3 control-label label-height">
                <span class="text-danger">*</span> มาตรฐานที่ใช้รับรอง:
                <br/><span class="font_size">(Standard to TIS)</span>
            </label>
            <div class="col-md-8">
                <select name="trust_mark" id="trust_mark" class="form-control" required>
                    <option value="">- เลือกมาตรฐานที่ใช้รับรอง -</option>
                        <?php if(!empty($certi_cb->petitioner_id)): ?>
                            <?php $__currentLoopData = $cbTrustmarks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cbTrustmark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>" 

                                <?php if($cbTrustmark->bcertify_certification_branche_id == $certi_cb->petitioner_id ): ?>
                                    selected
                                <?php endif; ?>>
                                <?php echo e($cbTrustmark->tis_no); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

      

                </select>
                <?php if($errors->has('trust_mark')): ?>
                    <p class="help-block"><?php echo e($errors->first('trust_mark')); ?></p>
                <?php endif; ?>
            </div>
        </div>
        


        

        <?php if( isset($certi_cb->id) && !empty($certi_cb->standard_change) ): ?>
            <?php $selectedStandard = $certi_cb->standard_change; ?>
        <?php else: ?>
            <?php $selectedStandard = null; ?>
        <?php endif; ?>

        <div class="form-group <?php echo e($errors->has('standard_change') ? 'has-error' : ''); ?>">
            <label for="standard_change" class="col-md-3 control-label label-height">
                วัตถุประสงค์ในการยื่นคำขอ:
                <br/><span class="font_size">(Apply to NSC for)</span>
            </label>

            <label class="col-md-2 label-height">
                <input type="radio" name="standard_change" value="1" id="standard_change1" class="check" data-radio="iradio_square-green" 
                    <?php echo e($selectedStandard == 1 ? 'checked' : ''); ?>>
                &nbsp;ยื่นขอครั้งแรก <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span class="font_size">(initial assessment)</span>
            </label>
            <?php if($certifieds->count() > 0): ?>
                <label class="col-md-2 label-height">
                    <input type="radio" name="standard_change" value="2" id="standard_change2" class="check" data-radio="iradio_square-green" 
                        <?php echo e($selectedStandard == 2 ? 'checked' : ''); ?>>
                    &nbsp;ต่ออายุใบรับรอง <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font_size">(renewal)</span>
                </label>

                <label class="col-md-2 label-height">
                    <input type="radio" name="standard_change" value="3" id="standard_change3" class="check" data-radio="iradio_square-green" 
                        <?php echo e($selectedStandard == 3 ? 'checked' : ''); ?>>
                    &nbsp;ขยายขอบข่าย <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font_size">(extending accreditation)</span>
                </label>

                <label class="col-md-3 label-height">
                    <input type="radio" name="standard_change" value="4" id="standard_change4" class="check" data-radio="iradio_square-green" 
                        <?php echo e($selectedStandard == 4 ? 'checked' : ''); ?>>
                    &nbsp;การเปลี่ยนแปลงมาตรฐาน <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font_size">(standard change)</span>
                </label>
            <?php endif; ?>


            <?php if($errors->has('standard_change')): ?>
                <p class="help-block"><?php echo e($errors->first('standard_change')); ?></p>
            <?php endif; ?>
        </div>


        

        <div id="box_ref_application_no">
            <div class="form-group">
                <label for="ref_application_no" class="col-md-3 control-label label-height">
                    อ้างอิงเลขที่คำขอ: <br/>
                    <span class="font_size">(Application No.)</span>
                </label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="ref_application_no" name="ref_application_no">
                    <p class="help-block" id="error_ref_application_no"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="certificate_exports_id" class="col-md-3 control-label label-height">
                    ใบรับรองเลขที่: <br/>
                    <span class="font_size">(Certificate No)</span>
                </label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="certificate_exports_id" name="certificate_exports_id">
                    <p class="help-block" id="error_certificate_exports_id"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="accereditation_no" class="col-md-3 control-label label-height">
                    <span class="text-danger">*</span> หมายเลขการรับรองที่: <br/>
                    <span class="font_size">(Accreditation No. Calibration)</span>
                </label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="accereditation_no" name="accereditation_no">
                    <p class="help-block" id="error_accereditation_no"></p>
                </div>
            </div>
        </div>
        

        

        <div class="form-group <?php echo e($errors->has('branch_type') ? 'has-error' : ''); ?>">
            <?php echo HTML::decode(Form::label('branch_type', '<span class="text-danger">*</span> ประเภทสาขา'.':'.'<br/><span class=" font_size">(Branch Type)</span>', ['class' => 'col-md-3 control-label  label-height'])); ?>

            <div class="col-md-4" >
                <div class="iradio_square-blue <?php echo (@$certi_cb->branch_type == 1)?'checked':''; ?>"></div>
                <label for="branch_type1">&nbsp;สำนักงานใหญ่&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <div class="iradio_square-blue <?php echo (@$certi_cb->branch_type != 1)?'checked':''; ?>"></div>
                <label for="branch_type2">&nbsp;สาขา</label>
                <input type="hidden" name="branch_type" value="<?php echo (@$certi_cb->branch_type == 1)?1:2; ?>" />
            </div>
        </div>



        


        <div class="form-group <?php echo e($errors->has('name_standard') ? 'has-error' : ''); ?>">
            <?php echo HTML::decode(Form::label('name_standard', '<span class="text-danger">*</span> หน่วยรับรอง'.':'.'<br/><span class=" font_size">(Name of Certification body)</span>', ['class' => 'col-md-3 control-label  label-height'])); ?>

            <div class="col-md-6">
                <?php echo Form::text('name_standard',  !empty($certi_cb->name_standard)?$certi_cb->name_standard:null, ['class' => 'form-control', 'required' => true]); ?>

                <?php echo $errors->first('name_standard', '<p class="help-block">:message</p>'); ?>

            </div>
        </div>

        <div class="form-group <?php echo e($errors->has('name_en_standard') ? 'has-error' : ''); ?>">
            <?php echo HTML::decode(Form::label('name_en_standard', '<span class="text-danger">*</span> หน่วยรับรอง (EN)'.':'.'<br/><span class=" font_size">(Name of Certification body)</span>', ['class' => 'col-md-3 control-label  label-height'])); ?>

            <div class="col-md-6">
                <?php echo Form::text('name_en_standard', !empty($certi_cb->name_en_standard)?$certi_cb->name_en_standard:null, ['class' => 'form-control input_address_eng', 'required' => true]); ?>

                <?php echo $errors->first('name_en_standard', '<p class="help-block">:message</p>'); ?>

            </div>
        </div>

        <div class="form-group <?php echo e($errors->has('name_short_standard') ? 'has-error' : ''); ?>">
            <?php echo HTML::decode(Form::label('name_short_standard', 'ชื่อย่อหน่วยรับรอง'.':'.'<br/><span class=" font_size">(Short Name of Certification body)</span>', ['class' => 'col-md-3 control-label  label-height'])); ?>

            <div class="col-md-6">
                <?php echo Form::text('name_short_standard', !empty($certi_cb->name_short_standard)?$certi_cb->name_short_standard:null, ['class' => 'form-control']); ?>

                <?php echo $errors->first('name_short_standard', '<p class="help-block">:message</p>'); ?>

            </div>
        </div>

    </div>

    <hr>

    <div class="row">
        <div class="form-group <?php echo e($errors->has('use_address_office') ? 'has-error' : ''); ?>">
            <?php echo HTML::decode(Form::label('use_address_office', 'ที่ตั้งหน่วยงาน'.':'.'<br/><span class=" font_size">(Address laboratory)</span>', ['class' => 'col-md-3 control-label  label-height'])); ?>

            <div class="col-md-8">
                <div class="col-md-4">
                    <?php echo Form::radio('use_address_office', '1',null, ['class' => 'form-control check', 'data-radio' => 'iradio_square-blue', 'id'=>'use_address_office-1']); ?>

                    <?php echo Form::label('use_address_office-1', 'ที่อยู่เดียวกับที่อยู่สำนักงานใหญ่', ['class' => 'control-label font-medium-1 text-capitalize']); ?>

                </div>
                <div class="col-md-4">
                    <?php echo Form::radio('use_address_office', '2',null, ['class' => 'form-control check', 'data-radio' => 'iradio_square-blue', 'id'=>'use_address_office-2']); ?>

                    <?php echo Form::label('use_address_office-2', 'ที่อยู่เดียวกับที่อยู่ติดต่อได้', ['class' => 'control-label font-medium-1 text-capitalize']); ?>

                </div>
                <div class="col-md-4">
                    <?php echo Form::radio('use_address_office', '3',null, ['class' => 'form-control check', 'data-radio' => 'iradio_square-blue', 'id'=>'use_address_office-3']); ?>

                    <?php echo Form::label('use_address_office-3', 'ระบุที่ตั้งใหม่', ['class' => 'control-label font-medium-1 text-capitalize']); ?>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group <?php echo e($errors->has('address') ? 'has-error' : ''); ?>">
                <?php echo HTML::decode(Form::label('address', '<span class="text-danger">*</span> เลขที่'.':'.'<br/><span class=" font_size">(Address)</span>', ['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                    <?php echo Form::text('address', null, ['class' => 'form-control input_address', 'required' => 'required','id'=>'address']); ?>

                    <?php echo $errors->first('address', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group <?php echo e($errors->has('allay') ? 'has-error' : ''); ?>">
                <?php echo HTML::decode(Form::label('allay', 'หมู่ที่'.':'.'<br/><span class=" font_size">(Mool)</span>', ['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                    <?php echo Form::text('allay', null, ['class' => 'form-control input_address','id'=>'allay']); ?>

                    <?php echo $errors->first('allay', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group <?php echo e($errors->has('village_no') ? 'has-error' : ''); ?>">
                <?php echo HTML::decode(Form::label('village_no', 'ตรอก/ซอย'.':'.'<br/><span class=" font_size">(Trok/Sol)</span>', ['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                    <?php echo Form::text('village_no', null, ['class' => 'form-control input_address','id'=>'village_no']); ?>

                    <?php echo $errors->first('village_no', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group <?php echo e($errors->has('road') ? 'has-error' : ''); ?>">
                <?php echo HTML::decode(Form::label('road', 'ถนน'.':'.'<br/><span class=" font_size">(Street/Road)</span>',['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                    <?php echo Form::text('road', null, ['class' => 'form-control input_address','id'=>'road']); ?>

                    <?php echo $errors->first('road', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group ">
                <?php echo Form::label('authorized_address_seach', 'ค้นหาที่อยู่'.' :', ['class' => 'col-md-5 control-label']); ?>

                <div class="col-md-7">
                    <?php echo Form::text('authorized_address_seach', null,  ['class' => 'form-control authorized_address_seach', 'autocomplete' => 'off', 'data-provide' => 'typeahead', 'placeholder' => 'ค้นหาที่อยู่' ]); ?>

                    <?php echo $errors->first('authorized_address_seach', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group <?php echo e($errors->has('province') ? 'has-error' : ''); ?>">
                <?php echo HTML::decode(Form::label('province_id', 'จังหวัด'.':'.'<br/><span class=" font_size">(Province)</span>',['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                    <?php echo Form::select('province_id',$province->pluck('PROVINCE_NAME','PROVINCE_ID'), null, ['class' => 'form-control input_address', 'id'=>'province_id', 'placeholder' =>'- เลือกจังหวัด -']); ?>

                   <?php echo $errors->first('province_id', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group <?php echo e($errors->has('amphur_id') ? 'has-error' : ''); ?>">
                <?php echo HTML::decode(Form::label('amphur_id', 'เขต/อำเภอ'.':'.'<br/><span class=" font_size">(Arnphoe/Khet)</span>',['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                    <?php echo Form::text('amphur_id', null, ['class' => 'form-control input_address','id'=>'amphur_id']); ?>

                    <?php echo $errors->first('amphur_id', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group <?php echo e($errors->has('district_id ') ? 'has-error' : ''); ?>">
                <?php echo HTML::decode(Form::label('district_id ', 'แขวง/ตำบล'.':'.'<br/><span class=" font_size">(Zip code)</span>',['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                   <?php echo Form::text('district_id', null, ['class' => 'form-control input_address','id'=>'district_id']); ?>

                   <?php echo $errors->first('district_id', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group <?php echo e($errors->has('postcode') ? 'has-error' : ''); ?>">
                <?php echo HTML::decode(Form::label('postcode', '<span class="text-danger">*</span> รหัสไปรษณีย์'.':'.'<br/><span class=" font_size">(Tambon/Khwaeng)</span>',['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                    <?php echo Form::text('postcode', null, ['class' => 'form-control input_address', 'required' => 'required','id'=>'postcode']); ?>

                    <?php echo $errors->first('postcode', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?php echo HTML::decode(Form::label('', '',['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                    <a class="btn btn-default pull-left" id="show_map" onclick="return false">
                        ค้นหาจากแผนที่
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group <?php echo e($errors->has('cb_latitude') ? 'has-error' : ''); ?>">
                <?php echo HTML::decode(Form::label('cb_latitude', 'พิกัดที่ตั้ง (ละติจูด)'.':'.'<br/><span class=" font_size">(latitude)</span>',['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                    <input type="text" name="cb_latitude" id="cb_latitude" class="form-control input_address" value="<?php echo !empty($certi_cb->cb_latitude)?$certi_cb->cb_latitude: null; ?>">
                    <?php echo $errors->first('cb_latitude', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group <?php echo e($errors->has('cb_longitude') ? 'has-error' : ''); ?>">
                <?php echo HTML::decode(Form::label('cb_longitude', 'พิกัดที่ตั้ง (ลองจิจูด)'.':'.'<br/><span class=" font_size">(longitude)</span>',['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                    <input type="text" name="cb_longitude" id="cb_longitude" class="form-control input_address" value="<?php echo !empty($certi_cb->cb_longitude)?$certi_cb->cb_longitude: null; ?>">
                    <?php echo $errors->first('cb_longitude', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?php echo HTML::decode(Form::label('', 'ที่ตั้งหน่วยงาน (EN)',['class' => 'col-md-6 control-label label-height'])); ?>

                <div class="col-md-6"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group <?php echo e($errors->has('cb_address_no_eng') ? 'has-error' : ''); ?>">
                <?php echo HTML::decode(Form::label('cb_address_no_eng', '<span class="text-danger">*</span> เลขที่'.':'.'<br/><span class=" font_size">(Address)</span>', ['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                    <?php echo Form::text('cb_address_no_eng', !empty($certi_cb->cb_address_no_eng)?$certi_cb->cb_address_no_eng: null , ['class' => 'form-control input_address_eng', 'required' => 'required']); ?>

                    <?php echo $errors->first('cb_address_no_eng', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group <?php echo e($errors->has('cb_moo_eng') ? 'has-error' : ''); ?>">
                <?php echo HTML::decode(Form::label('cb_moo_eng', 'หมู่ที่'.':'.'<br/><span class=" font_size">(Moo)</span>', ['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                    <?php echo Form::text('cb_moo_eng', !empty($certi_cb->cb_moo_eng)?$certi_cb->cb_moo_eng: null , ['class' => 'form-control input_address_eng']); ?>

                    <?php echo $errors->first('cb_moo_eng', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group <?php echo e($errors->has('cb_soi_eng') ? 'has-error' : ''); ?>">
                <?php echo HTML::decode(Form::label('cb_soi_eng', 'ตรอก/ซอย'.':'.'<br/><span class=" font_size">(Trok/Sol)</span>', ['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                    <?php echo Form::text('cb_soi_eng', !empty($certi_cb->cb_soi_eng)?$certi_cb->cb_soi_eng: null , ['class' => 'form-control input_address_eng']); ?>

                    <?php echo $errors->first('cb_soi_eng', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group <?php echo e($errors->has('cb_street_eng') ? 'has-error' : ''); ?>">
                <?php echo HTML::decode(Form::label('cb_street_eng', 'ถนน'.':'.'<br/><span class=" font_size">(Street/Road)</span>',['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                    <?php echo Form::text('cb_street_eng', !empty($certi_cb->cb_street_eng)?$certi_cb->cb_street_eng: null , ['class' => 'form-control input_address_eng']); ?>

                    <?php echo $errors->first('cb_street_eng', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group <?php echo e($errors->has('address_city') ? 'has-error' : ''); ?>">
                <?php echo HTML::decode(Form::label('cb_province_eng', 'จังหวัด'.':'.'<br/><span class=" font_size">(Province)</span>',['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                    <?php echo Form::select('cb_province_eng', $province->where('PROVINCE_NAME_EN', '!=', null)->pluck('PROVINCE_NAME_EN', 'PROVINCE_ID' ), !empty($certi_cb->cb_province_eng)?$certi_cb->cb_province_eng: null , ['class' => 'form-control', 'id'=>'cb_province_eng', 'required' => true,'placeholder' =>'- PROVINCE -']); ?>

                    <?php echo $errors->first('cb_province_eng', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group <?php echo e($errors->has('cb_amphur_eng') ? 'has-error' : ''); ?>">
                <?php echo HTML::decode(Form::label('cb_amphur_eng', 'เขต/อำเภอ'.':'.'<br/><span class=" font_size">(Arnphoe/Khet)</span>',['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                    <input type="text" name="cb_amphur_eng" id="cb_amphur_eng" class="form-control input_address_eng" value="<?php echo !empty($certi_cb->cb_amphur_eng)?$certi_cb->cb_amphur_eng: null; ?>">
                    <?php echo $errors->first('cb_amphur_eng', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group <?php echo e($errors->has('cb_district_eng') ? 'has-error' : ''); ?>">
                <?php echo HTML::decode(Form::label('cb_district_eng', 'แขวง/ตำบล'.':'.'<br/><span class=" font_size">(Tambon/Khwaeng)</span>',['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                    <input type="text" name="cb_district_eng" id="cb_district_eng" class="form-control input_address_eng" value="<?php echo !empty($certi_cb->cb_district_eng)?$certi_cb->cb_district_eng: null; ?>">
                    <?php echo $errors->first('cb_district_eng', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group <?php echo e($errors->has('cb_postcode_eng') ? 'has-error' : ''); ?>">
                <?php echo HTML::decode(Form::label('cb_postcode_eng', '<span class="text-danger">*</span> รหัสไปรษณีย์'.':'.'<br/><span class=" font_size">(Zip code)</span>',['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                    <input type="text" name="cb_postcode_eng" id="cb_postcode_eng" class="form-control input_address_eng" required value="<?php echo !empty($certi_cb->cb_postcode_eng)?$certi_cb->cb_postcode_eng: null; ?>">
                    <?php echo $errors->first('cb_postcode_eng', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?php echo HTML::decode(Form::label('', 'ข้อมูลสำหรับการติดต่อ (Contact information)',['class' => 'col-md-6 control-label label-height'])); ?>

                <div class="col-md-6"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group <?php echo e($errors->has('contactor_name') ? 'has-error' : ''); ?>">
                <?php echo HTML::decode(Form::label('contact', '<span class="text-danger">*</span> ชื่อบุคคลที่ติดต่อ'.':'.'<br/><span class=" font_size">(Contact Person)</span>',['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                    <?php echo Form::text('contactor_name', !empty($certi_cb->contactor_name)?$certi_cb->contactor_name: null  , ['class' => 'form-control' ,'id'=>'contactor_name','readonly'=>true]); ?>

                    <?php echo $errors->first('contactor_name', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
                <?php echo HTML::decode(Form::label('address_tel', '<span class="text-danger">*</span> Email'.':'.'<br/><span class=" font_size text-danger">*หากต้องการเปลี่ยน e-mail กรุณาติดต่อเจ้าหน้าที่</span>',['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                    <?php echo Form::text('email', !empty($certi_cb->email)?$certi_cb->email: null, ['class' => 'form-control','required'=>"required","placeholder"=>"Email@gmail.com",'id'=>"address_email",'readonly'=>true]); ?>

                    <?php echo $errors->first('email', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group <?php echo e($errors->has('contact_tel') ? 'has-error' : ''); ?>">
                <?php echo HTML::decode(Form::label('contact_mobile', 'โทรศัพท์ผู้ติดต่อ'.':'.'<br/><span class=" font_size">(Telephone)</span>',['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                    <?php echo Form::text('contact_tel', !empty($certi_cb->contact_tel)?$certi_cb->contact_tel: null  , ['class' => 'form-control' ,'id'=>'contact_tel','readonly'=>true]); ?>

                    <?php echo $errors->first('contact_tel', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group <?php echo e($errors->has('telephone') ? 'has-error' : ''); ?>">
                <?php echo HTML::decode(Form::label('telephone', '<span class="text-danger">*</span> โทรศัพท์มือถือ'.':'.'<br/><span class=" font_size">(Mobile)</span>',['class' => 'col-md-5 control-label label-height'])); ?>

                <div class="col-md-7">
                    <?php echo Form::text('telephone', !empty($certi_cb->telephone)?$certi_cb->telephone: null , ['class' => 'form-control','id'=>"telephone",'readonly'=>true]); ?>

                    <?php echo $errors->first('telephone', '<p class="help-block">:message</p>'); ?>

                </div>
            </div>
        </div>
    </div>

</fieldset>

<?php $__env->startPush('js'); ?>
    <script>
        const app_cb_id = '<?php echo e(@$certi_cb->id); ?>';


        $(document).ready(function () {

            //เมื่อกรอกภาษาอังกฤษ
            $('.input_address_eng').keyup(function(event) {
                filterEngAndNumberOnlyCustomForPage(this);//เอาเฉพาะภาษาอังกฤษ ฟังก์ชั่นในไฟล์ function.js
            });

            $('.input_address_eng').change(function(event) {
                filterEngAndNumberOnlyCustomForPage(this);//เอาเฉพาะภาษาอังกฤษ ฟังก์ชั่นในไฟล์ function.js
            });

            $('#show_map').click(function(){
                $('#modal-default').modal('show');
            });


            $('#button-modal-default').click(function(){

                if( $('#lat1').val() != ""){
                    $('#cb_latitude').val( $('#lat1').val());
                }else{
                    $('#cb_latitude').val('');
                }

                if( $('#lng1').val() != ""){
                    $('#cb_longitude').val( $('#lng1').val());
                }else{
                    $('#cb_longitude').val('');
                }

                $('#modal-default').modal('hide');
            });

            $('#type_standard').change(function(){

                $('#trust_mark').html('<option value="">- เลือกมาตรฐานที่ใช้รับรอง -</option>').select2();
                
                $('#petitioner').html('<option value="">- เลือกสาขาเข้าขอรับการรับรอง  -</option>').select2();
                if($(this).val()!=""){
                    let type = $('#type_standard').find('option[value="'+$(this).val()+'"]').text();
                    // console.log('type',type);
                    // let row = type.replace("มอก.", "");
                    // $('.span_tis').html(row);

                    $.ajax({
                    url: "<?php echo url('/certify/applicant-cb/formulas2'); ?>"  + "/" + $(this).val()
                    }).done(function( object ) {
                        let row = object.data;
                        console.log(row);
                        if(row != '-'){
                            $.each(row,function (index,value) {
                                $('#petitioner').append('<option value='+value.id+' data-model_name='+value.model_name+'  >'+value.title+'</option>');
                            });
                        }
                    });

                }else{
                    $('.span_tis').html('');
                }
            });

            // $('#petitioner').change(function(){
                
            //     $('#petitioner').html('<option value="">- เลือกสาขาเข้าขอรับการรับรอง  -</option>').select2();
            //     if($(this).val()!=""){
            //         let type = $('#petitioner').find('option[value="'+$(this).val()+'"]').text();
            //         console.log('value',$(this).val());
            //         // let row = type.replace("มอก.", "");
            //         // $('.span_tis').html(row);

            //         $.ajax({
            //         url: "<?php echo url('/applicant-cb/formulas-get-trust-mark'); ?>"  + "/" + $(this).val()
            //         }).done(function( object ) {
            //             let data = object.cbTrustMarks;
            //             console.log(data);
            //             if(row != '-'){
            //                 // $.each(row,function (index,value) {
            //                 //     $('#petitioner').append('<option value='+value.id+'  >'+value.titles+'</option>');
            //                 // });
            //             }
            //         });

            //     }else{
            //         $('.span_tis').html('');
            //     }
            // });




            //  $('#type_standard').change();
            $('#petitioner').change(function(){
                if($(this).val()!=""){
                    let row = $('#petitioner').find('option[value="'+$(this).val()+'"]').text();
                    selectedModel = $(this).find(':selected').data('model_name'); // ค้นหา option ที่ถูกเลือก
                    console.log(selectedModel);
                    // $('#selectedModel').val(selectedModel);
                    $('#span_certification').html(row);

                    $.ajax({
                    url: "<?php echo url('/certify/applicant-cb/formulas-get-trust-mark'); ?>"  + "/" + $(this).val()
                    }).done(function( response ) {
                        let data = response.cbTrustMarks; // ตรวจสอบว่าตัวแปรนี้มีค่าถูกต้อง

                        if (Array.isArray(data)) { // ตรวจสอบว่าเป็น Array
                            let select = $('#trust_mark');
                            select.empty(); // ล้าง option เดิม
                            select.append('<option value="">- เลือกมาตรฐานที่ใช้รับรอง -</option>');

                            $.each(data, function(index, item) {
                                select.append(`<option value="${item.id}">${item.tis_no}</option>`);
                            });
                            select.val('').trigger("change");

                        }
                     
                    });
                }else{
                    $('#span_certification').html('');
                }
            });


            $('.check-readonly').prop('disabled', true);//checkbox ความคิดเห็น
            $('.check-readonly').parent().removeClass('disabled');
            $('.check-readonly').parent().css({"background-color": "rgb(238, 238, 238);","border-radius":"50%"});

            $('#use_address_office-1').on('ifChecked', function(event){
                use_address_offices();
            });

            $('#use_address_office-2').on('ifChecked', function(event){
                use_address_offices();
            });

            $('#use_address_office-3').on('ifChecked', function(event){
                use_address_offices();
            });

            $("#authorized_address_seach").select2({
                dropdownAutoWidth: true,
                width: '100%',
                ajax: {
                    url: "<?php echo e(url('/funtions/search-addreess')); ?>",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            searchTerm: params // search term
                        };
                    },
                    results: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true,
                },
                placeholder: 'คำค้นหา',
                minimumInputLength: 1,
            });

            $("#authorized_address_seach").on('change', function () {
                $.ajax({
                    url: "<?php echo url('/funtions/get-addreess/'); ?>" + "/" + $(this).val()
                }).done(function( jsondata ) {
                    if(jsondata != ''){

                        $('#province_id').val(jsondata.pro_id).select2();
                        $('#amphur_id').val(jsondata.dis_title);
                        $('#district_id').val(jsondata.sub_title);
                        $('#postcode').val(jsondata.zip_code);


                        $('#cb_province_eng').val(jsondata.pro_id).select2();
                        $('#cb_amphur_eng').val(jsondata.dis_title_en);
                        $('#cb_district_eng').val(jsondata.sub_title_en);
                        $('#cb_postcode_eng').val(jsondata.zip_code);

                    }
                });
            });

            // change   สาขาที่ขอรับการรับรอง
            $("input[name=standard_change]").on("ifChanged",function(){
                box_ref_application_no();
                get_app_no_and_certificate_exports_no();
            });

            // change   สาขาที่ขอรับการรับรอง
            $("#type_standard").change(function(){
                box_ref_application_no();
                get_app_no_and_certificate_exports_no();
            });
            box_ref_application_no();


        });

        function use_address_offices(){

            $('.input_address').val('');
            $('#province_id').val('').select2();

            if( $('#use_address_office-1').is(':checked',true) ){

                var address =  '<?php echo isset($tis_data) && !empty($tis_data->address_no) ?$tis_data->address_no:''; ?>';
                var moo =  '<?php echo isset($tis_data) && !empty($tis_data->moo) ?$tis_data->moo:''; ?>';
                var soi =  '<?php echo isset($tis_data) && !empty($tis_data->soi) ?$tis_data->soi:''; ?>';
                var road =  '<?php echo isset($tis_data) && !empty($tis_data->street) ?$tis_data->street:''; ?>';
                var building =  '<?php echo isset($tis_data) && !empty($tis_data->building) ?$tis_data->building:''; ?>';

                var subdistrict_txt =  '<?php echo isset($tis_data) && !empty($tis_data->subdistrict) ?$tis_data->subdistrict:''; ?>';
                var district_txt = '<?php echo isset($tis_data) && !empty($tis_data->district) ?$tis_data->district:''; ?>';
                var province_txt = '<?php echo isset($tis_data) && !empty($tis_data->province_id) ?$tis_data->province_id:''; ?>';
                var postcode_txt = '<?php echo isset($tis_data) && !empty($tis_data->zipcode) ?$tis_data->zipcode:''; ?>';

                var longitude =  '<?php echo isset($tis_data) && !empty($tis_data->longitude) ?$tis_data->longitude:''; ?>';
                var latitude =  '<?php echo isset($tis_data) && !empty($tis_data->latitude) ?$tis_data->latitude:''; ?>';

                $('#address').val(address);
                $('#allay').val(moo);
                $('#village_no').val(soi);
                $('#road').val(road);

                $('#province_id').val(province_txt).select2();
                $('#amphur_id').val(district_txt);
                $('#district_id').val(subdistrict_txt);
                $('#postcode').val(postcode_txt);

                $('#cb_latitude').val(latitude);
                $('#cb_longitude').val(longitude);

            }else if( $('#use_address_office-2').is(':checked',true) ){

                var address =  '<?php echo isset($tis_data) && !empty($tis_data->contact_address_no) ?$tis_data->contact_address_no:''; ?>';
                var moo =  '<?php echo isset($tis_data) && !empty($tis_data->contact_moo) ?$tis_data->contact_moo:''; ?>';
                var soi =  '<?php echo isset($tis_data) && !empty($tis_data->contact_soi) ?$tis_data->contact_soi:''; ?>';
                var road =  '<?php echo isset($tis_data) && !empty($tis_data->contact_street) ?$tis_data->contact_street:''; ?>';
                var building =  '<?php echo isset($tis_data) && !empty($tis_data->contact_building) ?$tis_data->contact_building:''; ?>';

                var subdistrict_txt =  '<?php echo isset($tis_data) && !empty($tis_data->contact_subdistrict) ?$tis_data->contact_subdistrict:''; ?>';
                var district_txt = '<?php echo isset($tis_data) && !empty($tis_data->contact_district) ?$tis_data->contact_district:''; ?>';
                var province_txt = '<?php echo isset($tis_data) && !empty($tis_data->contact_province_id) ?$tis_data->contact_province_id:''; ?>';
                var postcode_txt = '<?php echo isset($tis_data) && !empty($tis_data->contact_zipcode) ?$tis_data->contact_zipcode:''; ?>';

                $('#address').val(address);
                $('#allay').val(moo);
                $('#village_no').val(soi);
                $('#road').val(road);

                $('#province_id').val(province_txt).select2();
                $('#amphur_id').val(district_txt);
                $('#district_id').val(subdistrict_txt);
                $('#postcode').val(postcode_txt);
            }

        }

        function box_ref_application_no(){
            let standard_change = $('input[name="standard_change"]:checked').val();
            if(standard_change >= 2){
                $('#box_ref_application_no').show();
                $('#box_ref_application_no').find('input').prop('disabled', false);
                $('#accereditation_no').prop('required', true);
            }else{
                $('#box_ref_application_no').hide();
                $('#box_ref_application_no').find('input').prop('disabled', true);
                $('#accereditation_no').prop('required', false);
            }
        }

        function get_app_no_and_certificate_exports_no(){
            // alert('ok');
            let std_id = $('#type_standard').val();
            let standard_change = $('input[name="standard_change"]:checked').val();
            $('#ref_application_no').val(null);
            $('#certificate_exports_id').val(null);
            if(app_cb_id == '' && !!std_id && standard_change >= 2){
                $.get("<?php echo e(url('/certify/applicant-cb/get_app_no_and_certificate_exports_no')); ?>", {
                    std_id: std_id
                }).done(function( data ) {
                    if(data.status){
                        $('#ref_application_no').val(data.app_no);
                        $('#certificate_exports_id').val(data.certificate_exports_no);
                    }
                });
            }
        }


    </script>
<?php $__env->stopPush(); ?>
