<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>

          


                    <!-- Page content -->
                    <div id="page-content">
                        <!-- Dashboard Header -->
                        <!-- For an image header add the class 'content-header-media' and an image as in the following example -->
                        
                        <!-- END Dashboard Header -->

                        <!-- Mini Top Stats Row -->
                       
                        
                            <section class="content container-fluid">

            
            <!-- /.box-header -->
            
            <div class="uk-grid-small" uk-grid>
                
                <div class="uk-width-1-3@m">
                    
                    
          <div class="uk-card uk-card-body uk-card-default uk-card-small">
           <form  action="<?=base_url();?>/admin/AddCuopon" method="post" enctype="multipart/form-data" >  
              <div class="modal-header">
                <h4 class="modal-title">Add Coupon </h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                <label>Coupon Name</label>
                <input type="text" class="form-control" name="coname" id="" placeholder="Enter Coupon Name" required value="" />
                </div>
                <div class="form-group">
                <label>Coupon Code</label>
                <input type="text" class="form-control" name="cocode" id="" placeholder="Enter Coupon Code" required value=""/>
                <?php if(isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('cocode'); ?></span><?php } ?>
                </div>
                
                <!--<div class="form-group">
                    <label>Select City</label>
                    <select class="uk-select" name="city">
                        <?php
                        foreach ($AllCity as $city_data) { ?>
                            <option value="<?= $city_data->city_id ?>"><?= $city_data->city_name ?></option>
                        <?php } ?>
                    </select>
                </div>-->
                
                 <div class="form-group">
                <label>Discount Type</label>
                <select class="form-control" name="cotype" required="">
                  <option value="">--Coupon Type--</option>
                  <option value="1">Flat</option>
                  <option value="2">%</option>

                </select>  
                
                </div>
                <div class="form-group">
                <label>Discount Value</label>
                <input type="text" class="form-control" name="disvalue" id="" placeholder="Enter Discount Value" required  value=""/>              
                </div>

                  <div class="form-group">
                <label>Valid Up To</label>
                <input type="date" class="form-control" name="validate" id=""  required  value=""/>              
                </div>

                   <div class="form-group">
                <label>No. Of Uses</label>
                <input type="number" class="form-control" name="noofuse" id="" placeholder="Enter No. Of Uses" required min="0" value=""/>              
                </div>
                
                
                <div class="form-group">
                <label>No. Of Use Per User</label>
                <input type="number" class="form-control" name="noofuseperuser" id="" placeholder="Enter No. Of Use per user" required min="0" value=""/>              
                </div>
                
                
                
                 <div class="form-group">
                <label>Applay Of Cart Price</label>
                <input type="text" class="form-control" name="priceapplay" id="" placeholder="EnterApplay Of Cart Price" required  value=""/>              
                </div>
                
                <div class="form-group">
                <label >Uploade Image</label>
                <input type="file"  name="img" id="exampleFormControlFile1" class="form-control" >             
                </div>
                
                
              </div>
              <div class="modal-footer">
              <button type="submit" class="btn btn-primary pull-left " value="addCoupon" name="submit">Add Coupon</button>
                
              </div>
           </form>
          </div>
          
         
                    
                </div>
                
                
                <div class="uk-width-expand@m">
                     <div class="uk-card uk-card-body uk-card-default uk-card-small">
            <div class="table-responsive">
              <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
                <thead>
                <tr>
                  <th>Slno.</th>
                  <th>Coupon Name</th>
                  <th>Coupon Image</th>
                  <th>Coupon Code</th>
                  <th>Discount Type</th>
                  <th>Discount Value</th>
                  <th>Valid Upto</th>
                  <th>No. Of Uses</th>
                  <th>Applay Of Cart Price</th>
                  
                  <th>Edit</th>
                 
                  <th >Delete</th>
                  
                </tr>
                </thead>
                <tbody>
                <?php $i=1; foreach($allCupons as $cuopon){?>
                <tr>
                  <td><?=$i++;?></td>
                  <td><?=$cuopon->name?></td>
                  <td><img src="<?=base_url();?>/uploads/<?=$cuopon->img?>" width="50" /></td>
                    <td><?=$cuopon->code?></td>
                      <td><?php if($cuopon->discount_type == 1){echo 'Flat';}else{ echo '%';}?></td>
                      <td><?=$cuopon->discount_value?></td>
                       <td><?=$cuopon->valid_uo_to?></td>
                         <td><?=$cuopon->used_up_to?></td>
                          <td><?=$cuopon->price_cart?></td>
                        
                         <td> 
                         <a class="btn btn-social-icon btn-primary" data-toggle="modal" data-target="#modal-default-edit<?=$cuopon->coupon_code_id?>" ><i class="fa fa-edit"></i></a>
                         
                         
                         
                         </td>
                        
                      <td>
                          <a href="javascript:void(0);" onClick="deleteRecord('<?= $cuopon->coupon_code_id ; ?>');" class="btn btn-social-icon btn-danger"  ><i class="fa fa-trash"></i></a>
                         
                         
                  </td>
                </tr>
				<?php }?>
                   
                </tbody>
                
              </table>
            </div>  
 
 
 

            </div>
                </div>
            </div>
            
            <!-- /.box-body -->
         

    </section>
                        </div>
                        <!-- END Mini Top Stats Row -->

                        
                    </div>
                    <!-- END Page Content -->
                    
                    
                    
   <?php $i=1; foreach($allCupons as $cuopon){?>                  
   <div class="modal fade" id="modal-default-edit<?=$cuopon->coupon_code_id?>">
              
            <form  action="<?=base_url();?>/admin/EditCuopon" method="post" enctype="multipart/form-data" >  
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Coupon </h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" name="cuoponID" value="<?=$cuopon->coupon_code_id?>" >
                <div class="form-group">
                <label>Coupon Name</label>
                <input type="text" class="form-control" name="coname" id="" placeholder="Enter Coupon Name" required value="<?=$cuopon->name?>" />
                </div>
                <div class="form-group">
                <label>Coupon Code</label>
                <input type="text" class="form-control" name="cocode" id="" placeholder="Enter Coupon Code" required value="<?=$cuopon->code?>"/>
                
                </div>
                
                
                
                
                
                 <div class="form-group">
                <label>Discount Type</label>
                <select class="form-control" name="cotype" required="">
                  <option value="">--Coupon Type--</option>
                  <option value="1" <?php if($cuopon->discount_type == '1'){ echo 'selected';}?>>Flat</option>
                  <option value="2" <?php if($cuopon->discount_type == '2'){ echo 'selected';}?>>%</option>

                </select>  
                
                </div>
                <div class="form-group">
                <label>Discount Value</label>
                <input type="text" class="form-control" name="disvalue" id="" placeholder="Enter Discount Value" required  value="<?=$cuopon->discount_value?>"/>              
                </div>

                  <div class="form-group">
                <label>Valid Up To</label>
                <input type="date" class="form-control" name="validate" id=""  required  value="<?=$cuopon->valid_uo_to?>"/>              
                </div>

                   <div class="form-group">
                <label>No. Of Uses</label>
                <input type="number" class="form-control" name="noofuse" id="" placeholder="Enter No. Of Uses" required min="0" value="<?=$cuopon->used_up_to?>"/>              
                </div>
                
                 <div class="form-group">
                <label>No. Of Use Per User</label>
                <input type="number" class="form-control" name="noofuseperuser" id="" value="<?=$cuopon->no_of_use_user?>" required min="0" value=""/>              
                </div>
                
                
                 <div class="form-group">
                <label>Applay Of Cart Price</label>
                <input type="text" class="form-control" name="priceapplay" id="" placeholder="EnterApplay Of Cart Price" required  value="<?=$cuopon->price_cart?>"/>              
                </div>
                
                <div class="form-group">
                <label >Uploade Image</label>
                <input type="file"  name="img" id="exampleFormControlFile1" class="form-control" >
                </div>
    
              </div>
              <div class="modal-footer">
              <button type="submit" class="btn btn-primary pull-left " value="addCoupon" name="submit">Add Coupon</button>
                <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          
          </form>
          <!-- /.modal-dialog -->
        </div>                 
   <?php }?>                 
                    
                    
                    

                           <form name="frm_deleteBanner" id="frm_deleteBanner" action="<?php echo base_url();?>/admin/deleteCupon" method="post">
 <input type="hidden" name="operation" id="operation" value="">
 <input type="hidden" name="user_id" id="user_id" value="">
 </form>
<script type="text/javascript">
function deleteRecord(id){
	$("#operation").val('delete');
	$("#user_id").val(id);
	var conf=confirm("Are you sure want to delete this Coupon code");
	if(conf){
	   $("#frm_deleteBanner").submit();
	}
}
</script>   



           
<?php include('footer.php') ?>