<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>

          


                    <!-- Page content -->
                    <div id="page-content">
<?php foreach($catsingle_data as $categorym){ }?>    
                       
 


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

function build_menu($rows, $parent = 0,$sel=null) {
    $result = "<ul class='treme'>";
    foreach ($rows as $row) {
		
        if ($row['parent_id'] == $parent) {
			
			if ($row['cat_id'] == $sel) {
				  $result .= "<li> <input type='radio' name='p_cat' checked value='{$row['cat_id']}'/> {$row['cat_name']}";
				} else {
					$result .= "<li> <input type='radio' name='p_cat' value='{$row['cat_id']}'/> {$row['cat_name']}";
					}
			
            if (has_children($rows, $row['cat_id'])) {
                $result .= build_menu($rows, $row['cat_id'],$sel);
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
    padding: 0px 20px; margin:0;}

</style>
 

            
              
                        <div class="uk-child-width-expand uk-grid-small" uk-grid>
                          <div class="uk-width-3-4"> <div class="uk-card uk-card-body uk-card-default uk-card-small">
                          
                           
                     
                     
                          
                            <form action="<?php echo base_url();?>/admin/edit_category" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                            <label>Enter Category Name</label>
                                            <input type="hidden" class="form-control" name="cid"   required value="<?= $categorym->cat_id;?> ">
                                            <input type="text" class="form-control" name="catname"   required value="<?= $categorym->cat_name;?>  ">
                                            </div>
                            
                                              <label >Uploade Category Image</label>
                                              <input type="file" name="img" class="form-control"    >
                                            <p></p>
                                           <div class="form-group">
                                            
                                                <label>Select Parent Category </label>
                                                <div style='border:solid 1px #ccc; padding:10px; height:300px; overflow-y: scroll;'>
                                                 <li class="uk-padding-remove uk-margin-remove"><input type='radio'  name='p_cat' value='0' />No Parent</li>
                                                  <?php echo build_menu($category, 0, $categorym->parent_id);?>
                                                  
                                                  
                                            </div>
                                                </div>
                                              
                                            
                                            <button type="submit" class="btn btn-primary" >Submit</button>
                                    </form>
                           </div> </div>
                           <div class="uk-width-1-4">
                           <div class="uk-card uk-card-body uk-card-default">
                           	<img src="<?php echo base_url(); ?>/uploads/<?= $categorym->cat_img;?>"/>
                            </div>
                           </div>
                            
                            
                           
                        </div>

                        
                    </div>
                    <!-- END Page Content -->

                   
           
<?php include('footer.php') ?>