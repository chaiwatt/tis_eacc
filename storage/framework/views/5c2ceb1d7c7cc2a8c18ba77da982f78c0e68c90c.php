<?php
        $theme_name = 'default';
        $fix_header = false;
        $fix_sidebar = false;
        $theme_layout = '';
		
        if(auth()->user()){

            $user = auth()->user();

            $params = (object)json_decode($user->params);

            if(!empty($params->theme_name)){
                if(is_file('css/colors/'.$params->theme_name.'.css')){
                    $theme_name = $params->theme_name;
                }
            }

            if(!empty($params->fix_header) && $params->fix_header=="true"){
                $fix_header = true;
            }

            if(!empty($params->fix_sidebar) && $params->fix_sidebar=="true"){
                $fix_sidebar = true;
            }

            if(!empty($params->theme_layout)){
                $theme_layout = $params->theme_layout;;
            }

            $experts = App\Expert::where('created_by', $user->id)->first();
            $data_session     =    HP::CheckSession();
        }

?>

<aside class="sidebar">
    <div class="scroll-sidebar">

        <?php if(auth()->check()): ?>

            <?php if($theme_layout != 'fix-header'): ?>
                <div class="user-profile">
                    <div class="dropdown user-pro-body ">
                        <div class="profile-image">

                            <?php if($user->picture == null): ?>
                                <img src="<?php echo e(asset('storage/uploads/users/no_avatar.png')); ?>" alt="user-img" class="img-circle">
                            <?php else: ?>
                                <img src="<?php echo e(HP::getFileStorage('sso_users/'.$user->picture)); ?>" alt="user-img" class="img-circle">
                            <?php endif; ?>

                        </div>
                        <p class="profile-text m-t-15 font-16">
                            <a href="javascript:void(0);">
                                <?php echo e($user->name); ?>

                            </a>
                        </p>
                    </div>
                    
                </div>
            <?php endif; ?>
            <nav class="sidebar-nav">
                <ul id="side-menu">
                    
                     <li>
                        <a class="waves-effect" href="javascript:void(0);" aria-expanded="false">
                          <i class="icon-badge fa-fw"></i> <span class="hide-menu"> ใบรับรองระบบงาน</span>
                        </a>
                        <ul aria-expanded="false" class="collapse extra">
                          <?php $__currentLoopData = $laravelMenuCertifys->menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(count(collect($section->items)) > 0): ?>
                                <?php $__currentLoopData = $section->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(HP::CheckPermission('view-'.str_slug($menu->title))): ?>
                                      <li>
                                          <a class="waves-effect" href="<?php echo e(url($menu->url)); ?>">
                                              <i class="<?php echo e($menu->icon); ?>" style="font-size:20px;"></i>
                                              <?php echo e($menu->display); ?>

                                          </a>
                                      </li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </ul>
                    </li>
                   <?php if($data_session->applicanttype_id == 2  && is_null($data_session->agent_id)): ?>
                     <li>
                        <a class="waves-effect" href="javascript:void(0);" aria-expanded="false">
                          <i class="icon-badge fa-fw"></i> <span class="hide-menu"> ทะเบียนผู้เชี่ยวชาญ</span>
                        </a>
                        <ul aria-expanded="false" class="collapse extra">
                          <?php $__currentLoopData = $laravelMenuExperts->menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(count(collect($section->items)) > 0): ?>
                                <?php $__currentLoopData = $section->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(HP::CheckPermission('view-'.str_slug($menu->title))): ?>
                                        <li>
                                            <a class="waves-effect" href="<?php echo e(url($menu->url)); ?>">
                                                <i class="<?php echo e($menu->icon); ?>" style="font-size:20px;"></i>
                                                <?php echo e($menu->display); ?>

                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                        </ul>
                      </li>
                    <?php endif; ?>
                    <li>
                        <a class="waves-effect" href="<?php echo e(url('tisi/standard-offers')); ?>">
                              <i class=" icon-layers fa-fw"></i><span class="hide-menu"> กำหนดมาตรฐาน </span>
                        </a>
                      </li>

                      <li>
                        <a class="waves-effect" href="javascript:void(0);" aria-expanded="false">
                          <i class="icon-plus fa-fw"></i> <span class="hide-menu"> เพิ่มเติมขอบข่าย </span>
                        </a>
                        <ul aria-expanded="false" class="collapse extra">
                          <?php $__currentLoopData = $laravelMenuScopeRequests->menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          
                            <?php if(count(collect($section->items)) > 0): ?>
                                <?php $__currentLoopData = $section->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    
                                            <li>
                                                <a class="waves-effect" href="<?php echo e(url($menu->url)); ?>">
                                                    <i class="<?php echo e($menu->icon); ?>" style="font-size:20px;"></i>
                                                    <?php echo e($menu->display); ?>

                                                </a>
                                            </li>
                                    
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                      </li>

                    <!-- <li>
                        <a class="waves-effect" href="javascript:void(0);" aria-expanded="true">
                          <i class="icon-badge fa fa-user"></i> <span class="hide-menu"> ทะเบียนผู้เชี่ยวชาญ</span>
                        </a>
                        <ul aria-expanded="true" class="collapse extra in">
                         
                                      <li>
                                          <a class="waves-effect" href="<?php echo e(url($menu->url)); ?>">
                                              <i class="mdi mdi-plus" style="font-size:20px;"></i>
                                                ขึ้นทะเบียน
                                          </a>
                                      </li>
                          
                        </ul>
                    </li> -->

                </ul>
            </nav>
        <?php endif; ?>
    </div>
</aside>
