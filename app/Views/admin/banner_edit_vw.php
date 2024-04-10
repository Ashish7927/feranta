<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>
<?php foreach($single_banner_data as $singleData){}?>
          


                    <!-- Page content -->
                    <div id="page-content">
                        <!-- Dashboard Header -->
                        <!-- For an image header add the class 'content-header-media' and an image as in the following example -->
                        
                        <!-- END Dashboard Header -->

                        <!-- Mini Top Stats Row -->
                        
                        	<h3>Brand/Add Management</h3>
                        	
                             
                
                                <div class="uk-child-width-expand uk-grid-small" uk-grid>
                          <div class="uk-width-3-5"> <div class="uk-card uk-card-body uk-card-default uk-card-small">
                          
                            <form action="<?php echo base_url();?>/admin/Update_Banner" method="post" enctype="multipart/form-data">
                            				
                                            <input type="hidden" class="form-control" name="EditId" required value="<?=$singleData->banner_id?>" >
                                            <div class="form-group">
                                            <label>Enter Banner/add Tittle</label>
                                            <input type="text" class="form-control" name="title" required value="<?=$singleData->banner_title?>" >
                                            </div>
                                            
                                            <div class="form-group">
                                            <label>Enter Banner/add Sub Tittle</label>
                                            <input type="text" class="form-control" name="subtitle"  value="<?=$singleData->banner_subtitle?>" >
                                            </div>
                                            
                                            <div class="form-group">
                                            <label>Order No</label>
                                            <input type="number" class="form-control" name="orderby" required value="<?=$singleData->orderby?>" >
                                            </div>
                                            
                                            <div class="form-group">
                                            <label>Enter Banner/add Link</label>
                                            <input type="url" class="form-control" name="url"  value="<?=$singleData->urrl?>" >
                                            </div>
                                            
                                            <div class="form-group">
                                            <label>Enter Banner/ Add Description</label>
                                             <textarea  id="editor1" name="description" class="form-control" placeholder="Description"> <?=$singleData->description?></textarea>
                                            </div>
                                            
                                            <div class="form-group">
                                            <label>Banner / Add Type</label>
                                             <select class="form-control" name="ban_type" required>
                                                <option value="">Select Banner</option>
                                             	<option value="banner" <?php if ($singleData->type=="banner"){echo "selected";}?>>Banner</option>
                                             	<option value="offer" <?php if ($singleData->type=="offer"){echo "selected";}?> >Offer</option>
                                             	
                                                
                                             </select>
                                            </div>
                                            
                                            
                             				 <div class="form-group">
                                              <label >Uploade Banner/ Add Image</label>
                                              <input type="file" name="img" class="form-control"  >
                                             </div>
                                            <p></p>
                                           
                                              
                                            
                                            <button type="submit" class="btn btn-primary" >Submit</button>
                                    </form>
                           </div> </div>
                           
                            
                            
                           <div>  <div class="uk-card uk-card-body uk-card-default uk-card-small">
                             
                          
                             <img src="<?php echo base_url(); ?>/uploads/<?=$singleData->image?>">
                                
                          
                        </div> </div>
                        </div>
                                
                                

                                     
                        </div>
                        <!-- END Mini Top Stats Row -->
                        
                    </div>
                    <!-- END Page Content -->
                    

                   
           
<?php include('footer.php') ?>