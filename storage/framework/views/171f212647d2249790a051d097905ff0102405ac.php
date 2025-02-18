


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <style>
       #style{
            width: 60%;
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
    <p> 
        <b>เรียน ผู้อำนวยการสำนักงานคณะกรรมการการมาตรฐานแห่งชาติ</b> 
    </p>
    <p>   
        <b>เรื่อง  การประมาณการค่าใช้จ่าย </b>   
    </p> 
    <p class="indent50">   
        ตามที่สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรมได้แจ้งรายละเอียดการประมาณการค่าใช้จ่ายในการตรวจประเมิน 
        ของ     <?php echo e(!empty($certiLab->BelongsInformation->name) ?  $certiLab->BelongsInformation->name  :  ''); ?> 
        คำขอเลขที่ <?php echo e(!empty($certiLab->app_no) ?   $certiLab->app_no  :  ''); ?> 
        เมื่อวันที่ <?php echo e(!empty($certi_cost->created_at) ?  HP::formatDateThaiFull($certi_cost->created_at) :  ''); ?> 
         <?php echo e(!empty($certiLab->BelongsInformation->name) ?   $certiLab->BelongsInformation->name   :  ''); ?> 
        มีความเห็นดังนี้
    </p> 

    <p><b>เห็นชอบกับค่าใช่จ่ายที่เสนอมา :</b>  <?php echo e($check_status ?? null); ?> </p>  
    <?php if(!empty($certi_cost->remark)): ?>
     <p><b>หมายเหตุ :</b>  <?php echo e($certi_cost->remark  ?? null); ?> </p>  
    <?php endif; ?>

    
     <?php if($attachs != '-'): ?>
     <p><b>หลักฐาน :</b>   </p>  
            <?php $__currentLoopData = $attachs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $files): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <p class="indent50"> 
                <?php if(isset($files->file)): ?>
                <?php echo e(@$files->file_desc); ?>

                 <a href="<?php echo e(url('certify/check/files/'.$files->file)); ?>"  target="_blank"> 
                    <a href="<?php echo e(url('certify/check/file_client/'.$files->file.'/'.( !empty($files->file_client_name) ? $files->file_client_name : 'null' ))); ?>" target="_blank">
                    <?php echo e(!empty($files->file_client_name) ? $files->file_client_name :   @basename($files->file)); ?>

                </a>
                <?php endif; ?>
            </p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php endif; ?>


      <p><b>เห็นชอบกับ scope  :</b>  <?php echo e($status_scope ?? null); ?> </p>  
      <?php if(!empty($certi_cost->remark_scope)): ?>
       <p><b>หมายเหตุ :</b>  <?php echo e($certi_cost->remark_scope  ?? null); ?> </p>  
      <?php endif; ?>
      <?php if($attachs_scope != '-'): ?> 
      <p><b>หลักฐาน :</b>   </p>  
             <?php $__currentLoopData = $attachs_scope; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             <p class="indent50"> 
                 <?php if(isset($item->attach_files)): ?>
                 <?php echo e(@$item->file_desc_text); ?>

                 <a href="<?php echo e(url('certify/check/file_client/'.$item->attach_files.'/'.( !empty($item->file_client_name) ? $item->file_client_name : 'null' ))); ?>" target="_blank">
                    <?php echo e(!empty($item->file_client_name) ? $item->file_client_name :   @basename($item->attach_files)); ?>

                 </a>
                 <?php endif; ?>
             </p>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
       <?php endif; ?>
       <p>
        จึงเรียนมาเพื่อโปรดดำเนินการต่อไป 
        
        </p>
        <p>
            ------------------------------------------
            <br>
            <?php echo auth()->user()->SetDataTraderAddress ?? null; ?>

        </p> 
    </div> 
</body>
</html>
 