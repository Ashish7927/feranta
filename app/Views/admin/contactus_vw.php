<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>
<?php foreach($singleCsm as $singleData){}?>
                    <!-- Page content -->
                    <div id="page-content">
                        <div class="uk-grid-small uk-child-width-expand@m" uk-grid>
                        	
                            <div><div class="uk-card uk-card-body uk-card-default uk-card-small">
                        	<h3>Edit CMS</h3>
                            
                            
                                 <form action="<?php echo base_url();?>/admin/UpdateCsm" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" >
                                <!-- Basic Form Elements Block -->
                                <div class="block">
                                    
                                   
                                           <input type="hidden" name="cmsid" value="<?=$singleData->id?>"> 
                                        <div class="form-group">
                                            <label >Page Name</label>
                                            <div >
                                                <input type="text" id="example-text-input" name="pageName" class="form-control" value="<?=$singleData->page_name?>">
                                               
                                            </div>
                                        </div>
                                    
                                        <div class="form-group">
                                            <label >Description</label>
                                            <div >
                                                <textarea  id="editor1" name="pageDetails" class="form-control" placeholder="Description"><?=$singleData->details?></textarea>
                                               
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label >Address</label>
                                            <div >
                                                <textarea   name="address" class="form-control" placeholder="Address"><?=$singleData->address?></textarea>
                                               
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label >Emails</label>
                                            <div >
                                                <textarea   name="email" class="form-control" placeholder="Email"><?=$singleData->email?></textarea>
                                               
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label >Contact</label>
                                            <div >
                                                <textarea   name="contact" class="form-control" placeholder="Contact"><?=$singleData->phone?></textarea>
                                               
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label >Image</label>
                                            <div >
                                               <input type="file" id="example-file-input" name="img" class="form-control" placeholder=" Insert file">
                                            </div>
                                        </div>
                                        </div>
                                       
                                        <div class="form-group form-actions">
                                            <div>
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Submit</button>
                                                
                                            </div>
                                        </div>
                                    </form>
                            
                            
                            
                        </div></div>
                        <div class="uk-width-1-3@m">
                        <div class="uk-card uk-card-body uk-card-default uk-card-small">
                        <img src="<?php echo base_url(); ?>/uploads/<?=$singleData->image?>"/>
                        </div>
                        </div>
                        </div>
                        
                        </div>
                        
                    </div>
                    <!-- END Page Content -->

                   
           
<?php include('footer.php') ?>