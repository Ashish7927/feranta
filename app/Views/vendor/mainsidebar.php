  <!-- Main Sidebar -->
  <div id="sidebar">
      <!-- Wrapper for scrolling functionality -->

      <div id="sidebar-scroll">
          <!-- Sidebar Content -->
          <div class="sidebar-content">
              <!-- Brand -->
              <a href="<?php echo base_url(); ?>Vendor/Dashboard" class="sidebar-brand">
                  <i class="gi gi-flash"></i><span class="sidebar-nav-mini-hide"><?= $setting_data->title; ?></span>
              </a>
              <!-- END Brand -->

              <!-- User Info -->
              <div class="sidebar-section sidebar-user clearfix sidebar-nav-mini-hide">
                  <div class="sidebar-user-avatar">
                      <a href="<?php echo base_url(); ?>Vendor/Dashboard">

                          <img src="<?php echo base_url(); ?>/uploads/<?= $user->profile_image; ?>" alt="avatar">
                      </a>
                  </div>
                  <div class="sidebar-user-name"><?= $user->user_name; ?></div>
                  <div class="sidebar-user-links">
                      <a href="<?php echo base_url(); ?>/Vendor/Profile" data-toggle="tooltip" data-placement="bottom" title="Profile"><i class="gi gi-user"></i></a>
                     
                      <a href="<?php echo base_url(); ?>/Vendor/logout" data-toggle="tooltip" data-placement="bottom" title="Logout"><i class="gi gi-exit"></i></a>
                  </div>
              </div>
              <!-- END User Info -->
              <?php include("theme_color.php"); ?>
              <!-- Sidebar Navigation -->
              <ul class="sidebar-nav">
                  <li><a href="<?php echo base_url(); ?>/Vendor/Dashboard"><i class="gi gi-stopwatch sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Dashboard</span></a></li>
                  <li><a href="<?php echo base_url(); ?>/Vendor/Dashboard"><i class="gi gi-stopwatch sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">My Order</span></a></li>
                  <li><a href="<?php echo base_url(); ?>/Vendor/Product"><i class="gi gi-stopwatch sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">All Product</span></a></li>
                  <li><a href="<?php echo base_url(); ?>/Vendor/PendingProduct"><i class="gi gi-stopwatch sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Product For Approval</span></a></li>
                
              </ul>
              <!-- END Sidebar Navigation -->


          </div>
          <!-- END Sidebar Content -->
      </div>
      <!-- END Wrapper for scrolling functionality -->
  </div>
  <!-- END Main Sidebar -->



  <!-- Main Container -->
  <div id="main-container">
      <!-- Header -->

      <header class="navbar navbar-default">




          <!-- Right Header Navigation -->
          <ul class="nav navbar-nav-custom pull-right">


              <!-- User Dropdown -->
              <li class="dropdown">
                  <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                      <img src="<?php echo base_url(); ?>/uploads/<?= $user->profile_image; ?>" alt="avatar"> <i class="fa fa-angle-down"></i> <?= $user->full_name; ?>
                  </a>
                  <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                      <li class="dropdown-header text-center">Account</li>

                      <li>
                          <a href="<?php echo base_url(); ?>/Vendor/Profile">
                              <i class="fa fa-user fa-fw pull-right"></i>
                              Profile
                          </a>
                          <!-- Opens the user settings modal that can be found at the bottom of each page (page_footer.html in PHP version) -->
                          
                      </li>
                      <li class="divider"></li>
                      <li>
                          <!--<a href="page_ready_lock_screen.html"><i class="fa fa-lock fa-fw pull-right"></i> Lock Account</a>-->
                          <a href="<?php echo base_url(); ?>/Vendor/logout"><i class="fa fa-ban fa-fw pull-right"></i> Logout</a>
                      </li>

                  </ul>
              </li>
              <!-- END User Dropdown -->
          </ul>
          <!-- END Right Header Navigation -->
      </header>
      <!-- END Header -->