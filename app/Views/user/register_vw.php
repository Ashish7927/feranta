<?php include('header.php'); ?>

<div class="main-content">
        <!-- login/register -->
        <section class="login-register">
            <div class="container <?php if (session()->has('tab')) {?>   sign-up-mode <?php } ?>">
                <div class="forms-container">
                    <div class="signin-signup">
                        <form novalidate class="sign-in-form needs-validation" autocomplete="off"  action="<?php echo base_url();?>Home/Login_auth" enctype="multipart/form-data" method="post">
                            <h3 class="fw_600 txt_blue mb-2">Welcome </h3>
                            <span class="d-block h6 mb-3">Login to manage your account.</span>
                            <div class="input-field bg_light_blue border_radius">
                                <i class="fas fa-user txt_blue"></i>
                                <input type="text" placeholder="Username" name="username" required/>
                            </div>
                            <div class="input-field bg_light_blue border_radius">
                                <i class="fas fa-lock txt_blue"></i>
                                <input type="password" placeholder="Password" name="password" />
                            </div>
                            <button class="mt-2 btn btn solid bg_blue txt_white border_radius ctm-btn" type="submit" >Login</button>
                            
                            
 <?php if (session()->has('msg')) {?>                           
                            
<div class="uk-alert-danger" uk-alert style="width:300px;">
    <a href class="uk-alert-close" uk-close></a>
    <?php echo session('msg'); ?>
</div>
<?php } ?>




                        </form>
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        <form  class="sign-up-form" action="<?php echo base_url();?>Home/userregistration" enctype="multipart/form-data" method="post" >
                            <h3 class="fw_600 txt_blue mb-2">Welcome </h3>
                            <span class="d-block h6 mb-3">Fill out the form to get started.</span>
                            <div class="input-field bg_light_blue border_radius" >
                                <i class="fas fa-user txt_blue"></i>
                                <input type="text" placeholder="Name" name="fname" value="<?= set_value('fname'); ?>" />
                                <?php if (isset($validation)) { ?><span class="uk-text-danger" style="width:300px;"><small><?= $error = $validation->getError('fname'); ?></small></span><?php } ?>
                            </div>
                            
                            <div class="input-field bg_light_blue border_radius">
                                <i class="fas fa-phone txt_blue"></i>
                                <input type="number" placeholder="cotact No" name="contact" value="<?= set_value('contact'); ?>" />
                                <?php if (isset($validation)) { ?><span class="uk-text-danger" style="width:300px;"><small><?= $error = $validation->getError('contact'); ?></small></span><?php } ?>
                            </div>
                            
                            <div class="input-field bg_light_blue border_radius">
                                <i class="fas fa-envelope txt_blue"></i>
                                <input type="email" placeholder="Email" name="email" value="<?= set_value('email'); ?>" />
                                <?php if (isset($validation)) { ?><span class="uk-text-danger" style="width:400px;"><small ><?= $error = $validation->getError('email'); ?></small></span><?php } ?>
                            </div>
                            
                            <div class="input-field bg_light_blue border_radius">
                                <i class="fas fa-user txt_blue"></i>
                                <input type="text" placeholder="Username" name="username" value="<?= set_value('username'); ?>" />
                                <?php if (isset($validation)) { ?><span class="uk-text-danger" style="width:400px;"><small><?= $error = $validation->getError('username'); ?></small></span><?php } ?>
                            </div>
                            
                            <div class="input-field bg_light_blue border_radius">
                                <i class="fas fa-lock txt_blue"></i>
                                <input type="password" placeholder="Password" name="password" value="<?= set_value('password'); ?>" />
                                <?php if (isset($validation)) { ?><span class="uk-text-danger" style="width:400px;" ><small><?= $error = $validation->getError('password'); ?></small></span><?php } ?>
                            </div>
                            <button class="mt-2 btn btn solid bg_blue txt_white border_radius ctm-btn" type="submit" >Register</button>
                           
                           
                        </form>
                    </div>
                </div>

                <div class="panels-container">
                    <div class="panel left-panel">
                        <div class="content">
                            <h3 class="fw_600 txt_white mb-2">New here ?</h3>
                            <p class="mb-0">
                                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis,<br> ex ratione. Aliquid!
                            </p>
                            <button class="btn transparent" id="sign-up-btn">
                    Sign up
                  </button>
                        </div>
                    </div>
                    <div class="panel right-panel">
                        <div class="content">
                            <h3 class="fw_600 txt_white mb-2">One of us ?</h3>
                            <p class="mb-0">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum<br> laboriosam ad deleniti.
                            </p>
                            <button class="btn transparent" id="sign-in-btn">
                    Sign in
                  </button>
                        </div>
                    </div>
                </div>
            </div>
    </section>
       
    </div>

<?php include('footer.php'); ?>