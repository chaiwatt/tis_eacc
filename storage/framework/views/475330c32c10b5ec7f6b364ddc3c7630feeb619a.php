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
       .customers td, .customers th {
            border: 1px solid #ddd;
            padding: 8px;
            }

        .customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: center;
        background-color: #66ccff;
        color: #000000;
        }   
        
        .center {
            text-align: center;
         }
         .right {
            text-align: right;
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
        <b>เรียน <?php echo e($transferer->name); ?></b>
    </p>
    <p> 
        <b>เรื่อง มีการสร้างคำขอเพื่อขอโอนใบรับรองของท่าน</b>    
    </p>

    <p class="indent50"> 
        ระบบได้ตรวจพบว่ามีการสร้างคำขอเพื่อขอโอนใบรับรองห้องปฏิบัติการ<?php echo e($certiLab->lab_name); ?> ใบรับลองเลขที่ <?php echo e($certificateExport->certificate_no); ?> คำขอสร้างโดย <?php echo e($transferee->name); ?> บันทึกข้อมูลโดย <?php echo e($transferee->contact_name); ?> โทรศัพท์ <?php echo e($transferee->tel); ?> เบอร์มือถือ <?php echo e($transferee->contact_phone_number); ?>

        
    </p>
    <p class="indent50"> 
        โปรดละเว้นอีเมลนี้หากท่านไม่ต้องการดำเนินการใด ๆ แต่หากท่านไม่มีส่วนเกี่ยวข้อง โปรดแจ้งสำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรมเพื่อดำเนินการต่อไป
    </p>
      
          --------------------------
      </p>
          <img src="<?php echo asset('plugins/images/anchor_sm200.jpg'); ?>"  height="200px" width="200px"/>
     <p>
          <?php echo auth()->user()->UserContact; ?>

     </p>
    </div> 
</body> 
</html>

