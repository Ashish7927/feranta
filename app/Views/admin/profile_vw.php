<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>
<?php foreach($singleuser as $singledata){}?>
          


                    <!-- Page content -->
                    <div id="page-content">
                        <!-- Dashboard Header -->
                        <!-- For an image header add the class 'content-header-media' and an image as in the following example -->
                        
                        <!-- END Dashboard Header -->

                        <!-- Mini Top Stats Row -->
                        <div class="uk-card uk-card-body uk-card-default uk-card-small">
                        	
      <h3>
        Pofile
        <small>Pofile  </small>
      </h3>
  
 
                            <section class="content container-fluid">

      <div class="row">
      	<div class="col-xs-12">
        	<form action="<?php echo base_url();?>/admin/pro" method="post" enctype="multipart/form-data">
            <div class="form-group">
                  <label for="exampleInputEmail1"> Name</label>
                  <input type="text" class="form-control" name="fullname" id="fullname" value="<?= $singledata->full_name;?>">
                   <?php if(isset($validation)) { ?>
					<span class="text-danger"><?= $error = $validation->getError('fullname'); ?></span>
                    <?php } ?>

                </div>
             
             <div class="form-group">
                  <label for="exampleInputEmail1">Email </label>
                  <input type="email" class="form-control" id="email" name="email" value="<?= $singledata->email;?>">
                  <?php if(isset($validation)) { ?>
				 	<span class="text-danger"><?= $error = $validation->getError('email'); ?></span>
                 <?php } ?>
                </div>
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Contat No </label>
                  <input type="tel" class="form-control" id="contact" name="contact" value="<?= $singledata->contact_no;?>">
                  <?php if(isset($validation)) { ?>
					<span class="text-danger"><?= $error = $validation->getError('contact'); ?></span>
                  <?php } ?>
                </div>
                
                 <div class="form-group">
                  <label for="exampleInputPassword1">User Name</label>
                  <input type="text" class="form-control" id="username" name="username" value="<?= $singledata->user_name;?>">
                   <?php if(isset($validation)) { ?>
					<span class="text-danger"><?= $error = $validation->getError('username'); ?></span>
                   <?php } ?>
                </div>
                
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="text" class="form-control" name="password" id="password" value="<?= base64_decode(base64_decode($singledata->password));?>">
                  <?php if(isset($validation)) { ?>
					<span class="text-danger"><?= $error = $validation->getError('password'); ?></span>
                   <?php } ?>
                </div>
                
                <div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <input type="file" class="form-control" id="img" name="img">
                
                <?php if($singledata->profile_image<>''){?>
        <img src="<?php echo base_url();?>/uploads/<?= $singledata->profile_image;?>"  width="100" height="100" >
        <?php }else{?>
         <img src="images/default.png"  >
        <?php }?>
                
                </div>
                
                
                
            <button class="btn btn-primary" type="submit">submit</button>
            </form>
   
       
     
        </div>
      </div>

    </section>
                        </div>
                        <!-- END Mini Top Stats Row -->

                        
                    </div>
                    <!-- END Page Content -->

                   
           
<?php include('footer.php') ?>