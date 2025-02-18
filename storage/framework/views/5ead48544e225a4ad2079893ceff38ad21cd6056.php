
<fieldset class="white-box">
    <legend>
        <h4>
            <span class="text-danger">*</span>
            4. การปฏิบัติของห้องปฏิบัติการที่สอดคล้องตามข้อกำหนดมาตรฐานเลขที่ มอก. 17025 – 2561 (ISO/IEC 17025 : 2017)
        </h4>
    </legend>
    <div><h4>(Laboratory’s implementations which are conformed with TIS 17025 - 2561 (2018) (ISO/IEC 17025 : 2017))</h4></div>
    
    <div class="row repeater-form-file">
        <div class="col-md-12 box_section4" data-repeater-list="repeater-section4" id="repeater_section4_wrapper">

            <?php
                $section4_required = 'required';
            ?>

            <?php if( isset( $certi_lab->id ) && count( App\Models\Certify\Applicant\CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id )->where('file_section', '4')->get() ) > 0 ): ?>

                <?php
                    $section4_required = '';
                    $file_sectionn4 = App\Models\Certify\Applicant\CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id )->where('file_section', '4')->get();
                ?>

                <?php $__currentLoopData = $file_sectionn4; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section4): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="form-group">
                        <div class="col-md-4 text-light"></div>
                        <div class="col-md-6">
                            
                            <a href="<?php echo HP::getFileStorage($attach_path.$section4->file); ?>" target="_blank" class="view-attach btn btn-sm"><?php echo HP::FileExtension($section4->file_client_name)  ?? ''; ?> <?php echo $section4->file_client_name  ?? ''; ?></a>
                            <a href="<?php echo e(url('certify/applicant/delete/file_app_certi_lab_attach_all').'/'.$section4->id.'/'.$certi_lab->token); ?>" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                <i class="fa fa-remove"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
            <?php endif; ?>

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
                            <input type="file" name="attachs_sec4" class="attachs_sec4 check_max_size_file" <?php echo $section4_required; ?>>
                        </span> 
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    <?php echo $errors->first('attachs_sec4', '<p class="help-block">:message</p>'); ?>

                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger delete-sec4" type="button" data-repeater-delete>
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
    
    
    <div class="clearfix"></div>
    <legend><h4><span class="text-danger">*</span> 5. ขอบข่ายที่ยื่นขอรับการรับรอง
        (<span class="text-warning">ห้องปฏิบัติการสอบเทียบ</span>) (Scope of Accreditation Sought (<span class="text-warning">For calibration laboratory</span>)) </h4></legend>
            <div class="clearfix"></div>
            <?php if($urlType == 'create'): ?>
                <table class="table table-bordered" id="myTable_labScope">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-center text-white "  width="10%">ลำดับ</th>
                            <th class="text-center text-white "  width="50%">สาขา</th>
                            
                            <th class="text-center text-white "  width="20%">เพิ่มขอบข่าย</th>
                        </tr>
                    </thead>
                    <tbody id="lab_address_with_scope_body">
                        <tr>
                            <td class="text-center" style="vertical-align:top">1</td>
                            <td style="vertical-align:top">
                                สำนักงานใหญ่
                            </td>
                            
                            <td class="text-center" id="main-branch-container">
                                
                            </td>
                        </tr>
                    </tbody>
                </table> 

                <div id="scope_table_wrapper">

                </div>

            <?php elseif($urlType == 'show' && ($labTestRequest->count() !== 0 ||  $labCalRequest->count() !== 0) ): ?>
         


                
    
                <div id="scope_table_wrapper">
    
                </div>
        
        <?php elseif($urlType == 'show' && $labTestRequest->count() === 0 &&  $labCalRequest->count() === 0): ?> 
            
            <?php if($certi_lab->lab_type == 3): ?>
                <?php if($certi_lab_attach_all61->count() > 0): ?>
                    <div class="row">
                        <?php $__currentLoopData = $certi_lab_attach_all61; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($data->file): ?>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-4 text-light"> </div>
                                        <div class="col-md-6 text-light">
                                            <a href="<?php echo e(url('certify/check/file_client/'.$data->file.'/'.( !is_null($data->file_client_name) ? $data->file_client_name : basename($data->file)  ))); ?>" target="_blank">
                                                <?php echo HP::FileExtension($data->file)  ?? ''; ?>

                                                <?php echo e(!empty($data->file_client_name) ? $data->file_client_name :  basename($data->file)); ?>

                                            </a>
                                        </div>
                                        <div class="col-md-2 text-left">
                                            <a href="<?php echo e(url('certify/applicant/delete/file_certiLab').'/'.basename($data->file).'/'.$data->token); ?>" class="btn btn-danger btn-xs"
                                                onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')" >
                                                <i class="fa fa-remove"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            <?php elseif($certi_lab->lab_type == 4): ?>   
                
                <?php if($certi_lab_attach_all62->count() > 0): ?>
                    <div class="row">
                        <?php $__currentLoopData = $certi_lab_attach_all62; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($data->file): ?>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-4 text-light"> </div>
                                        <div class="col-md-6 text-light">
                                            <a href="<?php echo e(url('certify/check/file_client/'.$data->file.'/'.( !is_null($data->file_client_name) ? $data->file_client_name : basename($data->file)  ))); ?>" target="_blank">
                                                    <?php echo HP::FileExtension($data->file)  ?? ''; ?>

                                                    <?php echo e(!empty($data->file_client_name) ? $data->file_client_name :  basename($data->file)); ?>

                                            </a>
                                        </div>
                                        <div class="col-md-2 text-left">
                                            <a href="<?php echo e(url('certify/applicant/delete/file_certiLab').'/'.basename($data->file).'/'.$data->token); ?>" class="btn btn-danger btn-xs"
                                                onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')" >
                                                <i class="fa fa-remove"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

        <?php elseif($urlType == 'edit'): ?>
            <table class="table table-bordered" id="myTable_labScope">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-center text-white "  width="10%">ลำดับ</th>
                        <th class="text-center text-white "  width="50%">สาขา</th>
                        
                        <th class="text-center text-white "  width="20%">เพิ่มขอบข่าย</th>
                    </tr>
                </thead>
                <tbody id="lab_address_with_scope_body">
                    <tr>
                        <td class="text-center" style="vertical-align:top">1</td>
                        <td style="vertical-align:top">
                            สำนักงานใหญ่
                        </td>
                        <td class="text-center" id="main-branch-container">

                            
                        </td>
                    </tr>
                </tbody>
            </table> 

            <div id="scope_table_wrapper">

            </div>

            

        <?php endif; ?>      
       
</fieldset>




<fieldset class="white-box">
    <legend>
        <h4>
            <span class="text-danger">*</span> 
            6. รายชื่อคุณวุฒิประสบการณ์และขอบข่ายความรับผิดชอบของเจ้าหน้าที่ (List of relevant personnel providing name, qualification, experience and responsibility)
        </h4>
    </legend>

    <div class="row repeater-form-file">
        <div class="col-md-12 box_section5" data-repeater-list="repeater-section5" id="repeater_section5_wrapper">
            <?php
                $section5_required = 'required';
            ?>
            <?php if( isset( $certi_lab->id ) && count( App\Models\Certify\Applicant\CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id )->where('file_section', '5')->get() ) > 0 ): ?>

                <?php
                    $section5_required = '';

                    $file_sectionn5 = App\Models\Certify\Applicant\CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id )->where('file_section', '5')->get();
                ?>

                <?php $__currentLoopData = $file_sectionn5; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section5): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="form-group">
                        <div class="col-md-4 text-light"></div>
                        <div class="col-md-6">
                            
                            <a href="<?php echo HP::getFileStorage($attach_path.$section5->file); ?>" target="_blank" class="view-attach btn btn-sm"><?php echo HP::FileExtension($section5->file)  ?? ''; ?> <?php echo $section5->file_client_name  ?? ''; ?></a>
                            
                            <a href="<?php echo e(url('certify/applicant/delete/file_app_certi_lab_attach_all').'/'.$section5->id.'/'.$certi_lab->token); ?>" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                <i class="fa fa-remove"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

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
                            <input type="file" name="attachs_sec5" class="attachs_sec5 check_max_size_file" <?php echo $section5_required; ?>>
                        </span> 
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    <?php echo $errors->first('attachs_sec5', '<p class="help-block">:message</p>'); ?>

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
            <span class="text-danger">*</span> 
            7. เครื่องมือ (Equipment)
        </h4>
    </legend>

    <div id="viewForm93" style="display: none">
       TEST viewForm93
        <div class="row repeater-form-file">
            <div class="col-md-12 box_section72" data-repeater-list="repeater-section72" id="repeater_section72_wrapper">
                <?php
                    $section72_required = '';
                ?>
                <?php if( isset( $certi_lab->id ) && count( App\Models\Certify\Applicant\CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id )->where('file_section', '72')->get() ) > 0 ): ?>
    
                    <?php
                        $section72_required = '';
    
                        $file_sectionn72 = App\Models\Certify\Applicant\CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id )->where('file_section', '72')->get();
                    ?>
    
                    <?php $__currentLoopData = $file_sectionn72; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section72): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-group">
                            <div class="col-md-4 text-light"></div>
                            <div class="col-md-6">
                                
                                <a href="<?php echo HP::getFileStorage($attach_path.$section72->file); ?>" target="_blank" class="view-attach btn btn-sm"><?php echo HP::FileExtension($section72->file)  ?? ''; ?> <?php echo $section72->file_client_name  ?? ''; ?></a>
                                <a href="<?php echo e(url('certify/applicant/delete/file_app_certi_lab_attach_all').'/'.$section72->id.'/'.$certi_lab->token); ?>" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                    <i class="fa fa-remove"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
    
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
                                <input type="file" name="attachs_sec72" class="attachs_sec72 check_max_size_file" <?php echo $section72_required; ?>>
                            </span> 
                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                        </div>
                        <?php echo $errors->first('attachs_sec72', '<p class="help-block">:message</p>'); ?>

                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-danger delete-sec72" type="button" data-repeater-delete>
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
    

        <input type="hidden" name="calibrateAddSize" id="calibrateAddSize" value="1">
    </div>

    <div id="viewForm92" style="display: none">
        CAL viewForm92
        <div class="row repeater-form-file">
            <div class="col-md-12 box_section71" data-repeater-list="repeater-section71" id="repeater_section71_wrapper">
                <?php
                    $section71_required = '';
                ?>
                <?php if( isset( $certi_lab->id ) && count( App\Models\Certify\Applicant\CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id )->where('file_section', '71')->get() ) > 0 ): ?>
    
                    <?php
                        $section71_required = '';
    
                        $file_sectionn71 = App\Models\Certify\Applicant\CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id )->where('file_section', '71')->get();
                    ?>
    
                    <?php $__currentLoopData = $file_sectionn71; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section71): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-group">
                            <div class="col-md-4 text-light"></div>
                            <div class="col-md-6">
                                
                                <a href="<?php echo HP::getFileStorage($attach_path.$section71->file); ?>" target="_blank" class="view-attach btn btn-sm"><?php echo HP::FileExtension($section71->file)  ?? ''; ?> <?php echo $section71->file_client_name  ?? ''; ?></a>
                                <a href="<?php echo e(url('certify/applicant/delete/file_app_certi_lab_attach_all').'/'.$section71->id.'/'.$certi_lab->token); ?>" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                    <i class="fa fa-remove"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
    
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
                                <input type="file" name="attachs_sec71" class="attachs_sec71 check_max_size_file" <?php echo $section71_required; ?>>
                            </span> 
                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                        </div>
                        <?php echo $errors->first('attachs_sec71', '<p class="help-block">:message</p>'); ?>

                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-danger delete-sec71" type="button" data-repeater-delete>
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
    


    </div>

</fieldset>

 <fieldset class="white-box">
    <legend>
        <h4>
            8. วัสดุอ้างอิง/วัสดุอ้างอิงรับรอง (Reference material / certified reference material) 
        </h4>
    </legend>

    <div class="row repeater-form-file">
        <div class="col-md-12 box_section8" data-repeater-list="repeater-section8" id="repeater_section8_wrapper">

            <?php if( isset( $certi_lab->id ) && count( App\Models\Certify\Applicant\CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id )->where('file_section', '8')->get() ) > 0 ): ?>

                <?php
                    $file_sectionn8 = App\Models\Certify\Applicant\CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id )->where('file_section', '8')->get();
                ?>

                <?php $__currentLoopData = $file_sectionn8; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section8): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="form-group">
                        <div class="col-md-4 text-light"></div>
                        <div class="col-md-6">
                            
                            <a href="<?php echo HP::getFileStorage($attach_path.$section8->file); ?>" target="_blank" class="view-attach btn btn-sm"><?php echo HP::FileExtension($section8->file)  ?? ''; ?> <?php echo $section8->file_client_name  ?? ''; ?></a>
                            <a href="<?php echo e(url('certify/applicant/delete/file_app_certi_lab_attach_all').'/'.$section8->id.'/'.$certi_lab->token); ?>" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                <i class="fa fa-remove"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

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
                    <?php echo $errors->first('attachs_sec8', '<p class="help-block">:message</p>'); ?>

                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger delete-sec8" type="button" data-repeater-delete>
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
            <span class="text-danger">*</span> 
            9. การเข้าร่วมการทดสอบความชำนาญ / การเปรียบเทียบผลระหว่างห้องปฏิบัติการ (Participation in Proficiency testing program / Interlaboratory comparison)  
        </h4>
    </legend>

    <div class="row repeater-form-file">
        <div class="col-md-12 box_section9" data-repeater-list="repeater-section9" id="repeater_section9_wrapper">

            <?php
                $section9_required = 'required';
            ?>

            <?php if( isset( $certi_lab->id ) && count( App\Models\Certify\Applicant\CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id )->where('file_section', '9')->get() ) > 0 ): ?>

                <?php
                    $section9_required = '';
                    $file_sectionn9 = App\Models\Certify\Applicant\CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id )->where('file_section', '9')->get();
                ?>

                <?php $__currentLoopData = $file_sectionn9; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section9): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="form-group">
                        <div class="col-md-4 text-light"></div>
                        <div class="col-md-6">
                            
                            <a href="<?php echo HP::getFileStorage($attach_path.$section9->file); ?>" target="_blank" class="view-attach btn btn-sm"><?php echo HP::FileExtension($section9->file)  ?? ''; ?> <?php echo $section9->file_client_name  ?? ''; ?></a>
                            <a href="<?php echo e(url('certify/applicant/delete/file_app_certi_lab_attach_all').'/'.$section9->id.'/'.$certi_lab->token); ?>" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                <i class="fa fa-remove"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
            <?php endif; ?>

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
                            <input type="file" name="attachs_sec9" class="attachs_sec9 check_max_size_file" <?php echo $section9_required; ?>>
                        </span> 
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    <?php echo $errors->first('attachs_sec9', '<p class="help-block">:message</p>'); ?>

                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger delete-sec9" type="button" data-repeater-delete>
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
            10. เอกสารอ้างอิง ชื่อย่อ
        </h4>
    </legend>

    <div class="row repeater-form-file">
        <div class="col-md-12 box_section10" data-repeater-list="repeater-section10" id="repeater_section10_wrapper">
            <?php if( isset( $certi_lab->id ) && count( App\Models\Certify\Applicant\CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id )->where('file_section', '10')->get() ) > 0 ): ?>

                <?php
                    $file_sectionn10 = App\Models\Certify\Applicant\CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id )->where('file_section', '10')->get();
                ?>

                <?php $__currentLoopData = $file_sectionn10; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section10): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="form-group">
                        <div class="col-md-4 text-light"></div>
                        <div class="col-md-6">
                            
                            <a href="<?php echo HP::getFileStorage($attach_path.$section10->file); ?>" target="_blank" class="view-attach btn btn-sm"><?php echo HP::FileExtension($section10->file)  ?? ''; ?>> <?php echo $section10->file_client_name  ?? ''; ?></a>
                            <a href="<?php echo e(url('certify/applicant/delete/file_app_certi_lab_attach_all').'/'.$section10->id.'/'.$certi_lab->token); ?>" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                <i class="fa fa-remove"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
             <?php endif; ?>
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
                            <input type="file" name="attachs_sec10" class="attachs_sec10 check_max_size_file" >
                        </span> 
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    <?php echo $errors->first('attachs_sec10', '<p class="help-block">:message</p>'); ?>

                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger delete-sec10" type="button" data-repeater-delete>
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
         11.   เอกสารอื่นๆ (Others)  
        </h4>
    </legend>

    <div class="row repeater-form-file">
        <div class="col-md-12 box_section_other" data-repeater-list="repeater-section-other" id="repeater_section_other_wrapper">

            <?php if( isset( $certi_lab->id ) && count( App\Models\Certify\Applicant\CertiLabAttachMore::where('app_certi_lab_id', $certi_lab->id )->get() ) > 0 ): ?>

                <?php
                    $file_more = App\Models\Certify\Applicant\CertiLabAttachMore::where('app_certi_lab_id', $certi_lab->id )->get();
                ?>
                <?php $__currentLoopData = $file_more; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $more): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="form-group">
                        <div class="col-md-4 text-light">
                            <input type="text" class='form-control' value="<?php echo !empty( $more->file_desc )?$more->file_desc:null; ?>" disabled>
                        </div>
                        <div class="col-md-6">
                            
                            <a href="<?php echo HP::getFileStorage($attach_path.$more->file); ?>" target="_blank" class="view-attach btn btn-sm"><?php echo HP::FileExtension($more->file)  ?? ''; ?> <?php echo $more->file_client_name  ?? ''; ?></a>
                            <a href="<?php echo e(url('certify/applicant/delete/file_app_certi_lab_attach_more').'/'.$more->id.'/'.$certi_lab->token); ?>" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                <i class="fa fa-remove"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            <div class="form-group box_remove_file" data-repeater-item>
                <div class="col-md-4 text-light">
                    <?php echo Form::text('another_attach_files_desc', null, ['class' => 'form-control', 'placeholder' => 'กรุณากรอกชื่อไฟล์']); ?>

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
                            <input type="file" name="another_attach_files" class="another_attach_files check_max_size_file" >
                        </span> 
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    <?php echo $errors->first('another_attach_files', '<p class="help-block">:message</p>'); ?>

                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger delete-more" type="button" data-repeater-delete>
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


<?php $__env->startPush('js'); ?>
    <script src="<?php echo e(asset('js/jasny-bootstrap.js')); ?>"></script>
    <script>


        $(document).ready(function () {

            //เพิ่มตำแหน่งงาน
            $('#test_tools_add').click(function() {
                $('.div_test_name_trader:first').clone().insertAfter(".div_test_name_trader:last");
                var last_new = $(".div_test_name_trader:last");
                $('.div_test_name_trader:last > label').text(''); 
                  $(last_new).find('input[type="text"]').val('');
                // resetOrder();
                ShowHideTestNameTrader();
            });

            //ลบตำแหน่ง
            $('body').on('click', '.test_tools_remove', function() {

                $(this).parent().parent().parent().parent().parent().remove();

                // reOrderLabTest();
                ShowHideTestNameTrader();
            });
            ShowHideTestNameTrader();

            //เพิ่มตำแหน่งงาน
            $('#test_program_add').click(function() {

                let newBox = $('#test_program_box').children(':first').clone(); //Clone Element
                newBox.find('input.mydatepicker').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'dd/mm/yyyy',
                    orientation: 'bottom'
                });
                newBox.find('input').val('');
                newBox.appendTo('#test_program_box');

                var last_new = $('#test_program_box').children(':last');
                //Change Button
                $(last_new).find('button').removeClass('btn-success');
                $(last_new).find('button').addClass('btn-danger test_program_remove');
                $(last_new).find('button').html('<i class="icon-close"></i> ลบ');
                reOrderTestProgram();

            });

            //ลบตำแหน่ง
            $('body').on('click', '.test_program_remove', function() {

                $(this).parent().parent().parent().parent().remove();

                reOrderTestProgram();

            });

            check_max_size_file();
            //เพิ่มไฟล์แนบ
            $('#another_attach-add').click(function(event) {
                $('.another_attach_files:first').clone().appendTo('#another_attach_files-box');
                $('.another_attach_files:last').find('input').val('');
                $('.another_attach_files:last').find('a.fileinput-exists').click();
                $('.another_attach_files:last').find('a.view-attach').remove();
                $('.another_attach_files:last').find('.label_attach').remove();
                $('.another_attach_files:last').find('button.another_attach-add').remove();
                $('.another_attach_files:last').find('.button_remove_files').html('<button class="btn btn-danger btn-sm another_attach_remove" type="button"> <i class="icon-close"></i>  </button>');
                // ShowHideRemoveBtn();
                check_max_size_file();
            });

            //ลบไฟล์แนบ
            $('body').on('click', '.another_attach_remove', function(event) {
                $(this).parent().parent().parent().remove();
                // ShowHideRemoveBtn();
            });
        });

        function ShowHideTestNameTrader() { //ซ่อน-แสดงปุ่มลบ
            var rows = $('div.div_test_name_trader').children(); //แถวทั้งหมด
            rows.each(function(index, el) {
                 if(index > 0){
                    $(el).find('.test_tools_remove').show();
                 }else{
                     $(el).find('.test_tools_remove').hide();
                 }
                $(el).find('label.label_last_new').first().html((index+1)+'.  รายการ (ชื่อและเครื่องหมายการค้า): ');
                // $(el).find('.test_tools_no').val((index+1));
            });
        }

        function reOrderTestProgram(){//รีเซตลำดับของตำแหน่ง
            let new_val = 0;
            $('.test_program_box').children().each(function(index, el) {
                $(el).find('input[name="test_program_no[]"]').val(index+1);
                new_val++;
            });
            return new_val;
        }

    $(document).on('click', '.btn-scope-group', function(e) {
        e.preventDefault();

        // console.log('sssssss');
        // var selectedValue = $('input[name="lab_ability"]:checked').val();
        const _token = $('input[name="_token"]').val();
        var certi_lab_id = $(this).data('certi_lab');
        var created_at = $(this).data('created_at');
        var group = $(this).data('group');

        

        // แยกวันที่และเวลาจาก created_at
        var dateTimeParts = created_at.split(' '); // แยกเป็น ['2024-09-12', '13:04:34']
        var dateParts = dateTimeParts[0].split('-'); // แยกเป็น ['2024', '09', '12']
        var timePart = dateTimeParts[1]; // ได้ '13:04:34'

        // แปลงเป็นปี พ.ศ. โดยบวก 543 กับปี ค.ศ.
        var year = parseInt(dateParts[0]) + 543;
        var month = dateParts[1];
        var day = dateParts[2];

        // สร้างรูปแบบ dd/mm/yyyy HH:mm:ss (พ.ศ.)
        var formattedDateTime = 'วันที่ ' + day + '/' + month + '/' + year + ' เวลา ' + timePart;
        $('#created_at').html(formattedDateTime);
        // 

        $.ajax({
            url:"<?php echo e(route('api.get_scope')); ?>",
            method:"POST",
            data:{
                _token:_token,
                certi_lab_id:certi_lab_id,
                group:group,
            },
            success:function (result){
                // console.log(result);
                const labCalScopeMainTransactions = result.labCalScopeTransactions.filter(item => item.branch_lab_adress_id === null);
                var lab_main_address_api = {
                    lab_type: 'main',
                    branch_lab_adress_id: undefined,
                    checkbox_main: '1',
                    address_number_add: "",
                    village_no_add: "",
                    address_city_add: "",
                    address_city_text_add: "",
                    address_district_add: "",
                    sub_district_add: "",
                    postcode_add: "",
                    lab_address_no_eng_add: "",
                    lab_province_text_eng_add: "",
                    lab_province_eng_add: "",
                    lab_amphur_eng_add: "",
                    lab_district_eng_add: "",
                    lab_moo_eng_add: "",
                    lab_soi_eng_add: "",
                    lab_street_eng_add: "",
                    lab_types: createLabTypesFromServer(labCalScopeMainTransactions,null,"main"), // เรียกใช้ฟังก์ชันเพื่อสร้าง lab_types
                    address_soi_add: "",
                    address_street_add: ""
                };

                console.log('lab_main_address_api');
                console.log(lab_main_address_api);



                const labCalScopeBranchTransactions  = result.labCalScopeTransactions.filter(item => item.branch_lab_adress_id !== null);
                const lab_addresses_array_api = [];
                
                result.branchLabAdresses.forEach(branchItem => {
                    // console.log(branchItem);
                    const lab_branch_address_server = {
                        lab_type: 'branch',
                        checkbox_main: '1',
                        branch_lab_adress_id: branchItem.id,
                        // thai
                        address_number_add_modal: branchItem.addr_no || "",
                        village_no_add_modal: branchItem.addr_moo || "",
                        soi_add_modal: branchItem.addr_soi || "",
                        road_add_modal: branchItem.addr_road || "",
                        
                        // จังหวัด
                        address_city_add_modal: branchItem.province.PROVINCE_ID || "",
                        address_city_text_add_modal: branchItem.province.PROVINCE_NAME || "",
                        // อำเภอ
                        address_district_add_modal: branchItem.amphur.AMPHUR_NAME || "",
                        address_district_add_modal_id: branchItem.amphur.AMPHUR_ID || "",
                        // ตำบล
                        sub_district_add_modal: branchItem.district.DISTRICT_NAME || "",
                        sub_district_add_modal_id: branchItem.district.DISTRICT_ID || "",
                        // รหัสไปรษณีย์
                        postcode_add_modal: branchItem.postal || "",

                        // eng
                        lab_address_no_eng_add_modal: branchItem.addr_no || "",
                        lab_moo_eng_add_modal: branchItem.addr_moo_en || "",
                        lab_soi_eng_add_modal: branchItem.addr_soi_en || "",
                        lab_street_eng_add_modal: branchItem.addr_road_en || "",

                        lab_province_eng_add_modal: branchItem.province.PROVINCE_ID || "",
                        // อำเภอ
                        lab_amphur_eng_add_modal: branchItem.amphur.AMPHUR_NAME_EN || "",
                        // ตำบล
                        lab_district_eng_add_modal: branchItem.district.DISTRICT_NAME_EN || "",
                        
                        lab_types: createLabTypesFromServer(labCalScopeBranchTransactions, branchItem.id, "branch"), // สำหรับสาขา
                    };

                    lab_addresses_array_api.push(lab_branch_address_server);
                            
                });

                console.log('lab_addresses_array_api');
                console.log(lab_addresses_array_api);

                $('#show_cal_scope_wrapper').empty();

                renderLabTypesMainTransactions(lab_main_address_api.lab_types,'#show_cal_scope_wrapper');
                renderLabTypesBranchTransactions(result.branchLabAdresses, lab_addresses_array_api,'#show_cal_scope_wrapper') 
                $('#modal-show-cal-scope').modal('show');

            }
        });
    });

    function createLabTypesFromServer(serverData,branch_index,type) 
    {
        var labTypes = {};

        if(type === 'main'){
            labTypes = {
                pl_2_1_main: 0, // index 0
                pl_2_2_main: 0, // index 1
                pl_2_3_main: 0, // index 2
                pl_2_4_main: 0, // index 3
                pl_2_5_main: 0  // index 4
            };
        }else if(type === 'branch'){

            labTypes = {
                pl_2_1_branch: 0, // index 0
                pl_2_2_branch: 0, // index 1
                pl_2_3_branch: 0, // index 2
                pl_2_4_branch: 0, // index 3
                pl_2_5_branch: 0  // index 4
            };
        }

        serverData.forEach(item => {
            const selectedValues = {
                cal_main_branch: item.calibration_branch ? item.calibration_branch.id : '',
                cal_main_branch_text: item.calibration_branch ? `${item.calibration_branch.title}` : '',

                cal_instrumentgroup: item.calibration_branch_instrument_group ? item.calibration_branch_instrument_group.id : '',
                cal_instrumentgroup_text: item.calibration_branch_instrument_group ? `${item.calibration_branch_instrument_group.name}` : '',

                cal_instrument: item.calibration_branch_instrument ? item.calibration_branch_instrument.id : '',
                cal_instrument_text: item.calibration_branch_instrument ? `${item.calibration_branch_instrument.name}` : '',

                cal_parameter_one: item.calibration_branch_param1 ? item.calibration_branch_param1.id : '',
                cal_parameter_one_text: item.calibration_branch_param1 ? `${item.calibration_branch_param1.name}` : '',
                cal_parameter_one_value: item.parameter_one_value || '',

                cal_parameter_two: item.calibration_branch_param2 ? item.calibration_branch_param2.id : '',
                cal_parameter_two_text: item.calibration_branch_param2 ? `${item.calibration_branch_param2.name}` : '',
                cal_parameter_two_value: item.parameter_two_value || '',

                cal_method: item.cal_method || ''
            };

            // ตรวจสอบว่า site_type มีใน labTypes หรือไม่
            if (item.site_type in labTypes) {
                // ถ้า labTypes ยังเป็น 0 (ยังไม่มีค่าใส่)
                if(type === 'main'){
                    if (labTypes[item.site_type] === 0) {
                        labTypes[item.site_type] = [selectedValues]; // เริ่มต้นด้วย array ที่มี 1 ค่า
                    } else {
                        labTypes[item.site_type].push(selectedValues); // เพิ่มค่าใน array
                    }
                }else{


                    if (parseInt(item.branch_lab_adress_id) === parseInt(branch_index)) {
                        if (labTypes[item.site_type] === 0) {
                            labTypes[item.site_type] = [selectedValues]; // เริ่มต้นด้วย array ที่มี 1 ค่า
                        } else {
                            labTypes[item.site_type].push(selectedValues); // เพิ่มค่าใน array
                        }
                    }
                } 
            }
        });

        return labTypes;
    }

    </script>   
<?php $__env->stopPush(); ?>