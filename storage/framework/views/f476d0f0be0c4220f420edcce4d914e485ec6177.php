

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
       .address{
            /* width: 50%; */
            padding: 5px;
            border: 1px solid gray;
            margin: 0;
            
       }    
        #table_th th{
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
        <b>เรียน  เลขาธิการสำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม</b> 
     </p>
     <p>   
         <b>เรื่อง ขอยื่นคำขอรับบริการห้องปฏิบัติการ</b>   
     </p> 
     <p class="indent50"> 
         ข้าพเจ้าบริษัท <?php echo e(!empty($certilab->BelongsInformation->name) ? $certilab->BelongsInformation->name  :  ''); ?> ได้ยื่นคำขอรับบริการยืนยันความสามารถห้องปฏิบัติการ
         ผ่านระบบการรับรองระบบงาน  คำขอเลขที่  <?php echo e(!empty($certilab->app_no) ?   $certilab->app_no  :  ''); ?> 
         เมื่อวันที่   <?php echo e(HP::formatDateThaiFull(date('Y-m-d'))); ?>    
         และได้แนบเอกสารประกอบคำขอดังกล่าวมาพร้อมนี้แล้ว
     </p> 
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

 