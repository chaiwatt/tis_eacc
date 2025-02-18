

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
                     ตามที่สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรมได้แจ้งรายละเอียดการแต่งตั้งคณะผู้ตรวจประเมิน ของ  <?php echo e(!empty($certi->name) ?   $certi->name   :  ''); ?> 
                     คำขอเลขที่  <?php echo e(!empty($auditors->reference_refno) ?   $auditors->reference_refno  :  ''); ?>   
                     เมื่อวันที่ <?php echo e(!empty($item->updated_at) ?  HP::formatDateThaiFull($item->updated_at) :  HP::formatDateThaiFull($item->created_at)); ?> 
                     โดย   <?php echo e(!empty($certi->name) ?  $certi->name :  ''); ?>  
                     มีความเห็นดังนี้
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
                <p  class="indent50">  
                    <b>หลักฐาน :</b>
                    <?php $__currentLoopData = $attachs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $files): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p class="indent50">     
                            <?php echo e(@$files->caption); ?>

                            <?php if(!empty($files->url)): ?>
                                     <a href="<?php echo e(url('funtions/get-view/'.$files->url.'/'.( !empty($files->filename) ? $files->filename :  basename($files->url)  ))); ?>" target="_blank">
                                         <?php echo basename($files->url)  ?? ''; ?>

                                     </a>
                             <?php endif; ?>
                        </p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </p>
              <?php endif; ?> 

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <?php endif; ?> 
 

        <p>
            จึงเรียนมาเพื่อโปรดพิจารณา 
        </p>
        <p>
            ------------------------------------------
            <br>
            <?php echo HP::SetDataTraderAddress(); ?>

        </p> 
    </div> 
</body>
</html>

