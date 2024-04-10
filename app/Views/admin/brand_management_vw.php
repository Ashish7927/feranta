<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>

          


                    <!-- Page content -->
                    <div id="page-content">
                        <!-- Dashboard Header -->
                        <!-- For an image header add the class 'content-header-media' and an image as in the following example -->
                        
                        <!-- END Dashboard Header -->

                        <!-- Mini Top Stats Row -->
                        
                        	<h3>Brand Management</h3>
                        	
                              
                
                                <div class="uk-grid-small" uk-grid>
                                	<div class="uk-width-1-3">
                                    <div class="uk-card uk-card-body uk-card-default uk-card-small">
                                    <form action="<?php echo base_url();?>/admin/AddBrand" method="post"  enctype="multipart/form-data">
     <div class="modal-body uk-text-left">

    
               
               <div class="form-group">
               <label>Enter Brand name</label>
               <input type="text" class="form-control" name="brandname" placeholder="Enter Brand name" value="<?php echo set_value('brandname'); ?>" >
               <?php if(isset($validation)) { ?>
					<span class="text-danger"><?= $error = $validation->getError('brandname'); ?></span>
                <?php } ?>
               </div>
               <div class="form-group">
                   <label>Upload Brand image</label>
                   <input type="file" class="form-control" name="img"  >
                    <?php if(isset($validation)) { ?>
					<span class="text-danger"><?= $error = $validation->getError('img'); ?></span>
               		 <?php } ?>
               </div>
               
               
             </div>
     <div class="modal-footer">
       <button type="submit" class="btn btn-primary" >Submit</button>
       
     </div>
     </form>
									</div>
									</div>
									<div class="uk-width-expand">
                                    <div class="uk-card uk-card-body uk-card-default uk-card-small">
                                    <div class="table-responsive">
                                <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">sl no</th>
                                            <th class="text-center">Image</th>
                                            <th>Brand Name</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1;  foreach($allBrands as $banner){
                                        ?>
                                        <tr>
                                            <td class="text-center"><?=$i++;?></td>
                                            <td class="text-center"><img src="<?=base_url();?>/uploads/<?=$banner->images?>" alt="avatar" class="img-circle" width="50px"></td>
                                            <td><?=$banner->brands_name?></td>
                                            
                                            <td><?php if($banner->status == '1'){?><a class="btn btn-success" href="<?=base_url();?>/admin/brandstatusBlock/<?=$banner->brands_id?>">Active</button><?php }else{?><a  href="<?=base_url();?>/admin/brandstatusActive/<?=$banner->brands_id?>" class="btn btn-danger">Deactive</a> <?php }?></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                     <a href="" data-toggle="modal" data-target="#myModal2<?= $banner->brands_id;?>" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                                    <a href="javascript:void(0);" onClick="deleteRecord('<?= $banner->brands_id ; ?>');" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                                </div>
                                                
                                                <!------------------------------------------------------------------>
                                                
                                                  <!-- Modal -->
<div id="myModal2<?= $banner->brands_id;?>" class="modal fade" role="dialog">
 <div class="modal-dialog">

   <!-- Modal content-->
   <div class="modal-content">
     <div class="modal-header">
     <h4 class="modal-title uk-text-left">Edit Brand</h4>
     
       
     </div>
     <form action="<?php echo base_url();?>/admin/EditBrand" method="post"  enctype="multipart/form-data">
     <div class="modal-body uk-text-left">
     			<input type="hidden" value="<?= $banner->brands_id;?>" name="brandId">
               <div class="uk-width-1-1">
               <label>Enter Brand Name</label><br>
               <input type="text" class="uk-input" name="brandname" value="<?=$banner->brands_name?>"  required>
               </div>

               
                     <div class="uk-width-1-1">
               <label>Upload Brand image</label>
               <input type="file" class="uk-input" name="img"  >
                
               </div>
               
               
             </div>
     <div class="modal-footer">
       <button type="submit" class="btn btn-primary" >Submit</button>
       
     </div>
     </form>
   </div>

 </div>
</div>
                                                
                                                <!------------------------------------------------------------------------>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div></div></div>
                                </div>
                                
                                

                                     
                        </div>
                        <!-- END Mini Top Stats Row -->
                        
                    </div>
                    <!-- END Page Content -->
<form name="frm_deleteBanner" id="frm_deleteBanner" action="<?php echo base_url();?>/admin/deleteBrand" method="post">
 <input type="hidden" name="operation" id="operation" value="">
 <input type="hidden" name="user_id" id="user_id" value="">
 </form>
<script type="text/javascript">
function deleteRecord(id){
	$("#operation").val('delete');
	$("#user_id").val(id);
	var conf=confirm("Are you sure want to delete this Product");
	if(conf){
	   $("#frm_deleteBanner").submit();
	}
}
</script>
                   
           
<?php include('footer.php') ?>