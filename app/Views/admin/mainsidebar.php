  <!-- Main Sidebar -->
  <div id="sidebar">
      <!-- Wrapper for scrolling functionality -->

      <div id="sidebar-scroll">
          <!-- Sidebar Content -->
          <div class="sidebar-content">
              <!-- Brand -->
              <a href="<?php echo base_url(); ?>admin/dashboard" class="sidebar-brand">
                  <i class="gi gi-flash"></i><span class="sidebar-nav-mini-hide"><?= $setting_data->title; ?></span>
              </a>
              <!-- END Brand -->

              <!-- User Info -->
              <div class="sidebar-section sidebar-user clearfix sidebar-nav-mini-hide">
                  <div class="sidebar-user-avatar">
                      <a href="<?php echo base_url(); ?>admin/dashboard">

                          <img src="<?php echo base_url(); ?>/uploads/<?= $user->profile_image; ?>" alt="avatar">
                      </a>
                  </div>
                  <div class="sidebar-user-name"><?= $user->user_name; ?></div>
                  <div class="sidebar-user-links">
                      <a href="<?php echo base_url(); ?>admin/Profile" data-toggle="tooltip" data-placement="bottom" title="Profile"><i class="gi gi-user"></i></a>
                      <a href="<?php echo base_url(); ?>admin/Setting" class="enable-tooltip" data-placement="bottom" title="Settings"><i class="gi gi-cogwheel"></i></a>
                      <a href="<?php echo base_url(); ?>admin/logout" data-toggle="tooltip" data-placement="bottom" title="Logout"><i class="gi gi-exit"></i></a>
                  </div>
              </div>
              <!-- END User Info -->
              <?php include("theme_color.php"); ?>
              <!-- Sidebar Navigation -->
              <ul class="sidebar-nav">
                  <li><a href="<?php echo base_url(); ?>admin/dashboard"><i class="gi gi-stopwatch sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Dashboard</span></a></li>
                  <li> <a href="<?php echo base_url(); ?>admin/Vendor"><i class="hi hi-edit sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Owner & Driver Management</span></a></li>

                  <li> <a href="<?php echo base_url(); ?>vehicle"><i class="hi hi-edit sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Vehicle Management</span></a></li>

                  <li> <a href="<?php echo base_url(); ?>vehicle/driver-vehicle"><i class="hi hi-edit sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Driver-Vehicle</span></a></li>


                  <li> <a href="<?php echo base_url(); ?>service-rate"><i class="hi hi-edit sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Service Price</span></a></li>

                  <li> <a href="<?php echo base_url(); ?>service"><i class="hi hi-edit sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Driver scedule service </span></a></li>

                  <li> <a href="<?php echo base_url(); ?>service-booking"><i class="hi hi-edit sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Service Booking</span></a></li>

                  <li> <a href="<?php echo base_url(); ?>service-request"><i class="hi hi-edit sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Service Request</span></a></li>

                  <li> <a href="<?php echo base_url(); ?>franchises"><i class="hi hi-edit sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Franchises</span></a></li>
                  <li> <a href="<?php echo base_url(); ?>member-tracking"><i class="hi hi-edit sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Franchise Member</span></a></li>

                  <li> <a href="<?php echo base_url(); ?>delete-request"><i class="hi hi-edit sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Delete Request</span></a></li>

                  <li>
                      <a href="" class="sidebar-nav-menu">
                          <i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-sweater sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Manage Master</span></a>
                      <ul style="display: none;">
                          <li>
                              <a href="<?php echo base_url(); ?>admin/state">Manage State</a>
                          </li>
                          <li>
                              <a href="<?php echo base_url(); ?>admin/City"> Manage City </a>
                          </li>
                          <li>
                              <a href="<?php echo base_url(); ?>admin/Pincode"> Manage Pincode </a>
                          </li>

                          <li>
                              <a href="<?php echo base_url(); ?>vehicle-type">Vehicle Type</a>
                          </li>


                      </ul>
                  </li>
                  <li><a href="<?php echo base_url(); ?>admin/Cms_management"><i class="hi hi-edit sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">CMS Management</span></a></li>
                  <li><a href="<?php echo base_url(); ?>admin/Banner"><i class="gi gi-cargo sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Banner Management</span></a> </li>
                  <li><a href="<?php echo base_url(); ?>admin/Customer"><i class="gi gi-cargo sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Manage Customer</span></a> </li>
                  <li><a href="<?php echo base_url(); ?>admin/Subadmin"><i class="gi gi-keys sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Manage Subadmin</span></a></li>
                  <li><a href="<?php echo base_url(); ?>admin/Manage_coupon"><i class="gi gi-gift sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Manage Coupon</span></a></li>
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
                          <a href="<?php echo base_url(); ?>admin/Profile">
                              <i class="fa fa-user fa-fw pull-right"></i>
                              Profile
                          </a>
                          <!-- Opens the user settings modal that can be found at the bottom of each page (page_footer.html in PHP version) -->
                          <a href="<?php echo base_url(); ?>admin/Setting">
                              <i class="fa fa-cog fa-fw pull-right"></i>
                              Settings
                          </a>
                      </li>
                      <li class="divider"></li>
                      <li>
                          <!--<a href="page_ready_lock_screen.html"><i class="fa fa-lock fa-fw pull-right"></i> Lock Account</a>-->
                          <a href="<?php echo base_url(); ?>admin/logout"><i class="fa fa-ban fa-fw pull-right"></i> Logout</a>
                      </li>

                  </ul>
              </li>
              <!-- END User Dropdown -->
          </ul>
          <!-- END Right Header Navigation -->
      </header>
      <!-- END Header -->