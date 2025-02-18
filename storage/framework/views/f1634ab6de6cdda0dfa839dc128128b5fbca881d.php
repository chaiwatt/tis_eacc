

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <style>
       #style{
            /* width: 50%; */
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
  <?php
    $data = ['1'=>'เห็นชอบกับ Scope','2'=>'ไม่เห็นชอบกับ Scope']
  ?>
 
   <div id="style"> 

    <p> 
        <b>เรียน ผู้อำนวยการสำนักงานคณะกรรมการการมาตรฐานแห่งชาติ</b> 
    </p>
    <p>   
        <b>เรื่อง ยืนยันขอบข่ายการรับรองห้องปฏิบัติการ</b>   
    </p> 
    <p class="indent50">   
    ตามที่  <?php echo e(!empty($certi_lab->BelongsInformation->name) ?   $certi_lab->BelongsInformation->name  :  ''); ?> 
    ได้ยื่นคำขอเลขที่   <?php echo e(!empty($certi_lab->app_no) ?   $certi_lab->app_no  :  ''); ?> 
    <?php echo e(($status_scope == 1 ) ? ' ขอยืนยันขอบข่ายตามที่แนบ' : 'แก้ไขขอบข่ายตามที่แนบ'); ?>

    </p>

    <p class="indent50"> 
    <b>เห็นชอบกับ scope : </b>   <?php echo e(($status_scope == 1 ) ? ' ยืนยัน scope' : 'แก้ไข scope'); ?>

    </p>

 
        <?php if(!is_null($remark)): ?> 
            <p class="indent50"> 
                โดยมีรายละเอียดดังนี้
            </p>
            <p > 
                หมายเหตุ : <?php echo e($remark ?? null); ?>

            </p>
        <?php endif; ?>
        <?php if(!is_null($evidence)): ?>
         <p > 
            ไฟล์แนบ : 
           <?php $__currentLoopData = $evidence; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
           <p class="indent100">
               <?php echo e(@$item->file_desc_text); ?>

                 <a href="<?php echo e(url('certify/check/file_client/'.$item->attachs.'/'.( !empty($item->attachs_client_name) ? $item->attachs_client_name : 'null' ))); ?>" target="_blank">
                     <?php echo !empty($item->attachs_client_name) ? $item->attachs_client_name : basename($item->attachs); ?>

                </a>
           </p>    
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
         </p>
        <?php endif; ?>
      <p>
          จึงเรียนมาเพื่อโปรดดำเนินการตรวจสอบรับคำขอ 
          
      </p>
      <p>
          ------------------------------------------
          <br>
          <?php echo auth()->user()->SetDataTraderAddress ?? null; ?>

      </p> 
    </div> 
</body>
</html> 

