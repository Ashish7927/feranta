<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>

          


                    <!-- Page content -->
                    <div id="page-content">
                        <!-- Dashboard Header -->
                        <!-- For an image header add the class 'content-header-media' and an image as in the following example -->
                        
                        <!-- END Dashboard Header -->

                        <!-- Mini Top Stats Row -->
                        <form action="<?php echo base_url();?>/admin/UpdateSetting" enctype="multipart/form-data" method="post">
        
        <div class="uk-card uk-card-body uk-card-default">
        
       
          		<div class="form-group">
                  <input type="hidden" class="form-control" id="agentid" name="settingid" value="<?= $setting_data->settingg_id;?>">
                  <label for="exampleInputEmail1">Website Title</label>
                  <input type="text" class="form-control" id="title" name="title" value="<?= $setting_data->title;?>" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Tag Line</label>
                  <input type="text" class="form-control" id="tag" name="tagline" value="<?= $setting_data->tagline;?>" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"> Logo</label>
                  <input type="file" class="form-control" id="img" name="img">
                </div>
                
                 <img src="<?php echo base_url();?>/uploads/<?= $setting_data->logo;?>" width="100" align="logo">
        				<div class="form-group">
                  <label for="">Description </label>
                  <textarea class="form-control" name="desc" id="editor1" rows="10" ><?= $setting_data->description;?></textarea>
                </div>
                <div class="form-group">
                 <label for="exampleInputEmail1">Facebook </label>
                  <input type="text" class="form-control" id="facebook" name="facebook" value="<?= $setting_data->facebook;?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Twitter </label>
                  <input type="text" class="form-control" id="tweeter" name="tweeter" value="<?= $setting_data->tweeter;?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Google Plus </label>
                  <input type="text" class="form-control" id="google" name="google" value="<?= $setting_data->google;?>">
                </div>
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Linkdin  </label>
                  <input type="text" class="form-control" id="linkdin" name="linkdin" value="<?= $setting_data->linkdin;?>">
                </div>
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Instagram  </label>
                  <input type="text" class="form-control" id="instagram" name="instagram" value="<?= $setting_data->instagram;?>">
                </div>
                
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit" id="submit" name="submit" value="editagent">Submit</button> 
          
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </form>
                        <!-- END Mini Top Stats Row -->

                        
                    </div>
                    <!-- END Page Content -->

                   
           
<?php include('footer.php') ?>