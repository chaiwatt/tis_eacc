

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
   <div id="style"> 
    <p> 
        <b>เรียน  ผู้อำนวยการสำนักงานคณะกรรมการการมาตรฐานแห่งชาติ</b> 
    </p>
    <p>   
        <b>เรื่อง  แจ้งแนวทางแก้ไข</b>   
    </p> 
    <p class="indent50">   
     ข้าพเจ้า  <?php echo e(!empty($certi_lab->name) ?  $certi_lab->name  :  ''); ?> 
     คำขอเลขที่   <?php echo e(!empty($certi_lab->app_no) ?   $certi_lab->app_no  :  ''); ?> 
     ได้ดำเนินการส่งแนวทางการแก้ไข/หลักฐานการแก้ไขข้อบกพร่องเรียบร้อยแล้ว ดังแนบ
    </p>

      <?php if(count($assessment->items) > 0): ?> 
      <p class="indent50"> 
          โดยมีรายละเอียดดังนี้
      </p>
      <table  id="customers" width="100%">
          <thead>
                  <tr>
                      <th width="5%" >#</th>
                      <th width="45%">ผลการประเมินที่พบ</th>
                      <th width="50%">แนวทางการแก้ไข</th>
                  </tr>
          </thead>
          <tbody>
              <?php $__currentLoopData = $assessment->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                      <td class="center"><?php echo e($key + 1); ?></td>
                      <td><?php echo e(!empty($item->remark)?$item->remark:null); ?></td>
                      <td> 
                         <?php if($item->status == 1): ?> 
                              <?php if(!is_null($item->attachs) && isset($item->attachs)): ?>
                              <a href="<?php echo e(url('certify/check/file_client/'.$item->attachs.'/'.( !empty($item->attachs_client_name) ? $item->attachs_client_name : 'null' ))); ?>" target="_blank">
                                        <?php echo basename($item->attachs)  ?? ''; ?>

                                    </a>
                              <?php endif; ?>
                         <?php else: ?> 
                               <?php echo e(!empty($item->details)?$item->details:null); ?>

                         <?php endif; ?>
                      </td>
                  </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
      </table>
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

