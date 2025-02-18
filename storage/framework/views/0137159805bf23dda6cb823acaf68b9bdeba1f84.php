

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <style>
       #style{
            /* width: 60%; */
            padding: 5px;
            border: 5px solid gray;
            margin: 0;
            
       }    
       #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
            }

        #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #66ccff;
        color: #000000;
        }   
        .indent50 {
        text-indent: 50px;
        } 
        .indent100 {
        text-indent: 100px;
        } 
   </style>
</head>
<body>
   <div id="style">
   <p style="font-size:30px;"> 

        <p><b>เรียน ผู้อำนวยการสำนักงานคณะกรรมการการมาตรฐานแห่งชาติ</b></p>  
        <p><b>เรื่อง การแต่งตั้งคณะผู้ตรวจประเมิน</b></p>  
         <?php if($authorities != '-'): ?>
           <?php $__currentLoopData = $authorities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key4 => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
       
           <p  class="indent50">   
                ตามที่สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรมได้แจ้งรายละเอียดการแต่งตั้งคณะผู้ตรวจประเมิน ของ  <?php echo e(!empty($certi_Lab->BelongsInformation->name) ?  $certi_Lab->BelongsInformation->name  :  ''); ?> 
                คำขอเลขที่  <?php echo e(!empty($certi_Lab->app_no) ?   $certi_Lab->app_no  :  ''); ?>  
                เมื่อวันที่ <?php echo e(!empty($item->updated_at) ?  HP::formatDateThaiFull($item->updated_at) :  HP::formatDateThaiFull($item->created_at)); ?> 
                โดย   <?php echo e(!empty($certi_Lab->name) ?  $certi_Lab->name :  ''); ?>   มีความเห็นดังนี้ 
           </p>

                <?php if($item->status != null): ?>
                    <?php if($item->status == 1): ?>
                        <p  class="indent50">   
                            <b>เห็นชอบกับการแต่งตั้งคณะผู้ตรวจประเมินที่เสนอมา : </b> เห็นชอบดำเนินการแต่งตั้งคณะผู้ตรวจประเมินต่อไป
                        </p>
                    <?php elseif($item->status == 2): ?>
                        <p  class="indent50">  
                            <b>เห็นชอบกับการแต่งตั้งคณะผู้ตรวจประเมินที่เสนอมา : </b> ไม่เห็นชอบ
                        </p>
                    <?php endif; ?>
                <?php else: ?> 
                    <p  class="indent50">  
                        <b>เห็นชอบกับการแต่งตั้งคณะผู้ตรวจประเมินที่เสนอมา : </b>
                    </p>
                <?php endif; ?>

               <?php if($item->remark != null): ?>
               <p  class="indent50">   
                    <b>หมายเหตุ :</b> <?php echo e($item->remark ?? '-'); ?> 
               </p>
               <?php endif; ?> 
               
               <?php if($item->attachs != null): ?>
               <?php 
                $attachs = json_decode($item->attachs);
                ?>
                <p>   
                    <b>หลักฐาน :</b>
                    <?php $__currentLoopData = $attachs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $files): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p class="indent50">     
                            <?php echo e(@$files->file_desc); ?>

                            <a href="<?php echo e(url('certify/check/file_client/'.$files->file.'/'.( !empty($files->attachs_client_name) ? $item1->attachs_client_name : 'null' ))); ?>" target="_blank">
                                <?php echo e(!empty($files->file_client_name) ? $files->file_client_name :  basename($files->file)); ?>

                            </a>
                        </p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </p>
              <?php endif; ?> 
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <?php endif; ?> 

        <p>
            จึงเรียนมาเพื่อโปรดพิจารณา 
            <a href="<?php echo e($url ?? '/'); ?>"class="btn btn-link" target="_blank">เข้าสู่ระบบ </a>
        </p>
        <p>
            ------------------------------------------
            <br>
            <?php echo auth()->user()->SetDataTraderAddress ?? null; ?>

        </p> 
    </div> 
</body>
</html>

