<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>

          


                    <!-- Page content -->
                    <div id="page-content">
                        
  


<?php
$category = json_decode(json_encode($category_data),true);
function has_children($rows, $cat_id) {
    foreach ($rows as $row) {
        if ($row['parent_id'] == $cat_id) {
            return true;
        }
    }
    return false;
}

function build_menu($rows, $parent = 0) {
    $result = "<ul class='treme'>";
    foreach ($rows as $row) {
        if ($row['parent_id'] == $parent) {
            $result .= "<li> <input type='radio' name='p_cat' value='{$row['cat_id']}' /> {$row['cat_name']}";
            if (has_children($rows, $row['cat_id'])) {
                $result .= build_menu($rows, $row['cat_id']);
            }
            $result .= "</li>";
        }
    }
    $result .= "</ul>";
    return $result;
}


?>
<style>
  .treme{list-style: none;
    padding: 0px 20px; margin-top:0;}

</style>
 

            
              
                        <div class="uk-child-width-expand uk-grid-small" uk-grid>
                          <div class="uk-width-1-3"> <div class="uk-card uk-card-body uk-card-default uk-card-small">
                          
                            <form action="<?php echo base_url();?>/admin/addcategory" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                            <label>Enter Category Name</label>
                                            <input type="text" class="form-control" name="catname" value="<?php echo set_value('catname'); ?>" required >
                                            <?php if(isset($validation)) { ?>
                                                <span class="text-danger"><?= $error = $validation->getError('catname'); ?></span>
                                            <?php } ?>
                                            </div>
                            
                                              <label >Uploade Category Image</label>
                                              <input type="file" name="img" class="form-control" required >
                                             
                                            <p></p>
                                           <div class="form-group">
                                            
                                                <label>Select Parent Category </label>
                                                <div style='border:solid 1px #ccc; padding:10px; height:250px; overflow:scroll'>
                                                 <li class="uk-padding-remove uk-margin-remove"><input type='radio'  name='p_cat' value='0' />No Parent</li>
                                                  <?php echo build_menu($category, 0);?>
                                            </div>
                                                </div>
                                              
                                            
                                            <button type="submit" class="btn btn-primary" >Submit</button>
                                    </form>
                           </div> </div>
                            
                            
                           <div>  <div class="uk-card uk-card-body uk-card-default uk-card-small">
                             
                          <div class="uk-alert-danger"> <?php if(isset($message)){ echo $message; } ?></div>
                             
                                <div class="table-responsive">
                                <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Sl No</th>
                                            <th class="text-center">Image</th>
                                            <th>Category Name</th>
                                            <th>Parent Category</th>
                                             <th></th>
                                            <th>Status</th>
                                            <th class="text-center">Actions</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                     <?php
                              
                              $i=1;
                              foreach( $category_data as $category){
                                  $prntcatname='';
                                  if($category->parent_id != '' && $category->parent_id != 0){
                                $p_cat=db_connect()->table('category')->getWhere(array('cat_id' => $category->parent_id))->getResult();
                                
                                
                                foreach($p_cat as $pcat_name){}
                              $prntcatname=$pcat_name->cat_name;
                                  }
                              ?>
                                        <tr>
                                            <td class="text-center"><?= $i++;;?></td>
                                            <td class="text-center"><img src="<?=base_url();?>/uploads/<?=$category->cat_img?>" width="50" alt="avatar" class="img-circle"></td>
                                            <td><?= $category->cat_name;?> </td>
                                            <td><?= $prntcatname?></td>
                                            <td class="text-center">
                                           
                                            
                                            <td>
												<?php if($category->status == '1'){?>
                                                <a class="btn btn-success" href="<?=base_url();?>/admin/catstatusBlock/<?=$category->cat_id?>">Active</a>
                                                <?php }else{?>
                                                <a class="btn btn-danger"  href="<?=base_url();?>/admin/catstatusActive/<?=$category->cat_id?>" >Deactive</a> 
                                                <?php }?>
                                            </td>
                                            
                                            
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="<?php echo base_url();?>/admin/EditCategory/<?= $category->cat_id ; ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                                    <a href="" data-toggle="modal" data-target="#myModal3<?= $category->cat_id ; ?>"  class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                                    <div id="myModal3<?= $category->cat_id ; ?>" class="modal fade" role="dialog">
                          <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                          <h4 class="modal-title">Delete Category</h4>
                                          </div>
                                          
                                          <div class="modal-body">
                                          Are you sure delete <?= $category->cat_name;?>
                                          <form action="<?php echo base_url();?>/admin/deletecategory" method="post">
                                          <input type="hidden" name="cat_id" value="<?= $category->cat_id;?>" />
                                          <input type="hidden" name="cat_img" value="<?= $category->cat_img;?>" />
                                          <p></p>
                                          <button class="btn btn-danger">Yes</button>
                                          </form>
                                          </div>
                                        </div>
                          </div>
    			</div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php }?>
                                       
                                       
                                    </tbody>
                                </table>
                                 
                                
                                </div>
                          
                        </div> </div>
                        </div>

                        
                    </div>
                    <!-- END Page Content -->

                   
           
<?php include('footer.php') ?>