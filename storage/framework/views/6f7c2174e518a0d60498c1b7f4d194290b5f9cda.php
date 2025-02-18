<!-- Modal เลข 3 -->
<div class="modal fade text-left" id="TakeAction<?php echo e($id); ?>" tabindex="-1" role="dialog" aria-labelledby="addBrand">
          <div class="modal-dialog  modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title" id="exampleModalLabel1"> อยู่ระหว่างดำเนินการ
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      </h4>
                  </div>
      <div class="modal-body"> 
          
       <?php 
              $auditors_btn =  '';
          if($certi->CertiAuditorsStatus == "statusInfo"){
              $auditors_btn = 'btn-info';
          }elseif($certi->CertiAuditorsStatus == "statusSuccess"){
              $auditors_btn =  'btn-success';
          }else{
              $auditors_btn = 'btn-danger';
          }
      ?>

<?php if($certi->fullyApprovedAuditorNoCancels->count() > 0): ?> 
<a class="btn  btn-sm  form-group <?php echo e($auditors_btn); ?>" 
href="<?php echo e(url('certify/tracking-labs/tracking-auditor/'.base64_encode($certi->id))); ?>" style="width:300px;">
 เห็นชอบการแต่งตั้งคณะผู้ตรวจประเมิน
</a>
<?php else: ?>
    
    <span class="text-warning">อยู่ระหว่างดำเนินการ...</span>
<?php endif; ?>

            

           <br>
           <?php if(count($certi->tracking_payin_one_many) > 0 ): ?>
           <?php 
                 $payin1_btn =  '';
             if($certi->CertiPayInOneStatus == "state3"){
                 $payin1_btn = 'btn-info';
             }elseif($certi->CertiPayInOneStatus == "state1"){
                 $payin1_btn =  'btn-danger';
             }elseif($certi->CertiPayInOneStatus == "state2"){
                 $payin1_btn = 'btn-success';
             }
         ?>
           <div class="btn-group  form-group">
             <div class="btn-group">
                   <button type="button" class="btn <?php echo e($payin1_btn); ?> dropdown-toggle" data-toggle="dropdown" style="width:300px;">
                            แจ้งรายละเอียดค่าตรวจประเมิน <span class="caret"></span>
                    </button>
                    <div class="dropdown-menu" role="menu" >
                         <?php $__currentLoopData = $certi->tracking_payin_one_many; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1 => $one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <?php 
                                         $payin1_btn =  '';
                                     if(is_null($one->state)){
                                         $payin1_btn = 'btn-warning';  
                                     }elseif($one->status == 1){ // ผ่าน
                                         $payin1_btn = 'btn-info';  
                                     }elseif($one->state == 1){  //จนท. ส่งให้ ผปก.
                                         $payin1_btn = 'btn-danger';  
                                     }elseif($one->state == 2){   //ผปก. ส่งให้ จนท.
                                         $payin1_btn = 'btn-success';  
                                     }
                                 ?>
                                 <?php if($one->status  != 3): ?> 
                                     <a  class="btn <?php echo e($payin1_btn); ?> " href="<?php echo e(url("certify/tracking-labs/tracking-pay_in1/".base64_encode($one->id))); ?>"  style="width:750px;text-align: left">
                                         <?php echo e($one->auditors_to->auditor ?? '-'); ?>   
                                     </a> 
                                     <br>
                                 <?php endif; ?>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
               </div>
            </div>
            <?php endif; ?>
             <br>

             <?php if(count($certi->tracking_save_assessment_many) > 0 ): ?>
             <?php 
                 $assessment_btn =  '';
              if($certi->CertiSaveAssessmentStatus == "statusInfo" || $certi->CertiSaveAssessmentStatus == "statuPrimary"){
                $assessment_btn = 'btn-info';
              }elseif($certi->CertiSaveAssessmentStatus == "statusSuccess"){
                 $assessment_btn = 'btn-success';
             }elseif($certi->CertiSaveAssessmentStatus == "statusDanger"){
                $assessment_btn =  'btn-danger';
             
             }else{
                 $assessment_btn =  'btn-warning';
             }
            ?>
                    <div class="btn-group  form-group">
                      <div class="btn-group">
                            <button type="button" class="btn <?php echo e($assessment_btn); ?> btn-succesdropdown-toggle" data-toggle="dropdown" style="width:300px;">
                                ผลการตรวจประเมิน <span class="caret"></span>
                             </button>
                             <div class="dropdown-menu" role="menu" >
                               <?php $__currentLoopData = $certi->tracking_save_assessment_many; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2 => $assessment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                     <?php 
                                        $bug_report  = ['1'=>'แก้ไขข้อบกพร่อง/ข้อสังเกต','2'=>'การตรวจสอบประเมิน']; 
                                            $assessment_btn =  '';
                                            $assessment_url =  '';
                                        if ($assessment->degree == 7 || $assessment->degree == 4) { // ผ่านการการประเมิน
                                            $assessment_btn =  'btn-info';
                                        }elseif (in_array($assessment->degree,[8])) {  //ฉบับร่าง
                                            $assessment_btn =  '#ffff80';
                                        }elseif (in_array($assessment->degree,[1,3,4,6])) {  //จนท. ส่งให้ ผปก.
                                            $assessment_btn =  'btn-danger';
                                        }else {    //ผปก. ส่งให้ จนท.
                                            $assessment_btn =  'btn-success';
                                        }
                                       
                                        if ($assessment->bug_report == 1) { 
                                            $assessment_url = 'certify/tracking-labs/assessment/'.base64_encode($assessment->id);
                                        }else{
                                            $assessment_url = 'certify/tracking-labs/evaluation/'.base64_encode($assessment->id);
                                        }
                                      ?>
                                    <a  class="btn <?php echo e($assessment_btn); ?> " href="<?php echo e(url("$assessment_url")); ?>"  style="background-color:<?php echo e($assessment_btn); ?>;width:750px;text-align: left">
                                       <?php echo e($assessment->auditors_to->auditor ?? '-'); ?>  
                                       <?php echo e(array_key_exists($assessment->bug_report,$bug_report) ?  '( '.$bug_report[$assessment->bug_report].' )' :''); ?>

                                    </a> 
                                   <br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  
                             </div>
                        </div>
                     </div>
                     <?php endif; ?>
             

      </div>
 
              </div>
          </div>
      </div>
      
      