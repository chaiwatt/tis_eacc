
<style>
    tr {
        padding: 0;
    }
    td {
        padding: 0;
    }
    .table-one {
        margin-left: 3px;    
    }
    .table-two {
        margin-left: 5px
    }
    .table-three {
        margin-left: 5px
    }
    .table-four {
        margin-left: 5px
    }
</style>

<table width="100%"  cellspacing="0" cellpadding="5" >
    <tbody>
        <?php
            $categoryCounts = [];
        ?>
        
        <?php $__currentLoopData = $scopes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td style="vertical-align: top;width:15%;padding-bottom: 90px;padding-left:5px;font-size:22px">
                    <span <?php if($key != 0): ?>
                            style="visibility: hidden"
                    <?php endif; ?> >สาขา<?php echo e($item->category_th); ?> <br><span style="font-size: 16px">(<?php echo e($item->category); ?> field)</span> </span>
                </td>
                <td style="vertical-align: top;width:25%">
                    <table class="table-one" cellspacing="0" width="100%" >
                        <tr>
                            <td >
                                <span style="margin-top:5px"><?php echo e($item->instrument); ?> </span><span style="font-size:1px;visibility: hidden">*<?php echo e($key); ?>*</span>
                                <?php if($item->instrument !== ""): ?>
                                    <span><br><?php echo e($item->instrument_two); ?> </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table class="table-two" cellspacing="0"  width="100%" >
                                    <?php if(!empty($item->description)): ?>
                                        <tr><td><span><?php echo e($item->description); ?></span></td></tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td style="<?php if($item->description !== ''): ?> margin-left:15px <?php endif; ?>">
                                            <table class="table-three" cellspacing="0"  width="100%">
                                                <?php $__currentLoopData = $item->measurements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $measurement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td style="<?php if($i > 0): ?> padding-top: 15px; <?php endif; ?>">
                                                            <span><?php echo e($measurement->name); ?></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="table-four" cellspacing="0" width="100%" style="padding-right:3px">
                                                                <?php $__currentLoopData = $measurement->ranges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $range): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php if(!empty($range->description)): ?>
                                                                        <tr>
                                                                            <td style="<?php if($i > 0): ?> padding-top: 15px; <?php endif; ?>">
                                                                                <span><?php echo $range->description; ?></span>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                    <tr>
                                                                  
                                                                        <?php if(preg_match('/\.(png|jpg|jpeg|gif)$/i', $range->uncertainty)): ?>
                                                                            <td  style="padding-left: 0px">
                                                                                <img src="<?php echo e($range->uncertainty); ?>" alt="Image" style="max-width:160px;visibility: hidden" />                                                                                  
                                                                            </td>
                                                                        <?php else: ?>
                                                                            <td  style="padding-left: 7px">
                                                                                <span><?php echo $range->range; ?></span>
                                                                            </td>
                                                                        <?php endif; ?>
                                                                    </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>

        
               <td style="vertical-align: top;width:25%">
                    <table class="table-one" cellspacing="0" width="100%" >
                        <tr>
                            <td >
                                <span style="visibility: hidden;margin-top:5px"><?php echo e($item->instrument); ?></span><span style="font-size:1px;visibility: hidden">*<?php echo e($key); ?>*</span>
                                <?php if($item->instrument !== ""): ?>
                                    <span style="visibility: hidden;"><br><?php echo e($item->instrument_two); ?> </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table class="table-two" cellspacing="0"  width="100%">
                                    <?php if(!empty($item->description)): ?>
                                        <tr><td><span style="visibility: hidden;"><?php echo e($item->description); ?></span></td></tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td style="<?php if($item->description !== ''): ?> margin-left:15px <?php endif; ?>">
                                            <table class="table-three" cellspacing="0"  width="100%">
                                                <?php $__currentLoopData = $item->measurements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j => $measurement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td style="<?php if($j > 0): ?> padding-top: 15px; <?php endif; ?>">
                                                            <span style="visibility: hidden;"><?php echo e($measurement->name); ?></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="table-four" cellspacing="0" width="100%" style="text-align: center;padding-right:3px">
                                                                <?php $__currentLoopData = $measurement->ranges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $range): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php if(!empty($range->description)): ?>
                                                                        <tr>
                                                                            <td style="<?php if($i > 0): ?> padding-top: 15px; <?php endif; ?>">
                                                                                <span style="visibility: hidden;"><?php echo $range->description; ?></span>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                    <tr>
                                                                        <?php if(preg_match('/\.(png|jpg|jpeg|gif)$/i', $range->uncertainty)): ?>
                                                                            <td  style="padding-left: 0px">
                                                                                <img src="<?php echo e($range->uncertainty); ?>" alt="Image" style="max-width:160px" />                                                                                  
                                                                            </td>
                                                                        <?php else: ?>
                                                                            <td  style="padding-left: -35px">
                                                                                <span><?php echo $range->uncertainty; ?></span>
                                                                            </td>
                                                                        <?php endif; ?>
                                                                    </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td> 
                <td style="vertical-align: top;width:25%">
                    <table class="table-one" cellspacing="0" width="100%" >
                        <tr>
                            <td>
                                <span style="visibility: hidden;margin-top:5px"><?php echo e($item->instrument); ?></span><span style="font-size:1px;visibility: hidden">*<?php echo e($key); ?>*</span>
                                <?php if($item->instrument !== ""): ?>
                                    <span style="visibility: hidden;"><br><?php echo e($item->instrument_two); ?> </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table class="table-two" cellspacing="0"  width="100%">
                                    <?php if(!empty($item->description)): ?>
                                        <tr><td><span style="visibility: hidden;"><?php echo e($item->description); ?></span></td></tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td style="<?php if($item->description !== ''): ?> margin-left:15px <?php endif; ?>">
                                            <table class="table-three" cellspacing="0"  width="100%">
                                                <?php $__currentLoopData = $item->measurements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $measurement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                       
                                                        <?php if($k == 0): ?>
                                                                <td style="<?php if($k > 0): ?> padding-top: 15px; <?php endif; ?>">
                                                                    <span ><?php echo $item->standard; ?></span>
                                                                </td>
                                                            <?php else: ?>
                                                            <td style="<?php if($k > 0): ?> padding-top: 15px; <?php endif; ?>">
                                                                <span ><?php echo $item->standard; ?></span>
                                                            </td>
                                                        <?php endif; ?>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="table-four" cellspacing="0" width="100%" style="text-align: center;padding-right:3px">
                                                                <?php $__currentLoopData = $measurement->ranges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $range): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php if(!empty($range->description)): ?>
                                                                        <tr>
                                                                            <td style="<?php if($i > 0): ?> padding-top: 15px; <?php endif; ?>">
                                                                                <span style="visibility: hidden;"><?php echo $range->description; ?></span>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                    <tr>
                                                                        <?php if(preg_match('/\.(png|jpg|jpeg|gif)$/i', $range->uncertainty)): ?>
                                                                            <td  style="padding-left: 0px">
                                                                                <img src="<?php echo e($range->uncertainty); ?>" alt="Image" style="max-width:160px;visibility: hidden" />                                                                                  
                                                                            </td>
                                                                        <?php else: ?>
                                                                            <td  style="padding-left: 7px">
                                                                                <span style="visibility: hidden;"><?php echo $range->range; ?></span>
                                                                            </td>
                                                                        <?php endif; ?>
                                                                    </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td> 
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    </tbody>
</table>




