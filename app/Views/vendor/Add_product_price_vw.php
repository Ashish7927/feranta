<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php
$category = json_decode(json_encode($category_data), true);
$procat = json_decode(json_encode($Product_Category), true);
$md = 0;
foreach ($procat as $dm) {
  $simple_array1[] = $dm['category_id'];
}
if (count($procat) == "0") {
  $simple_array1 = array("0");
}

?>

<?php
function has_children($rows, $cat_id)
{
  foreach ($rows as $row) {
    if ($row['parent_id'] == $cat_id) {
      return true;
    }
  }
  return false;
}

function build_menu($rows, $parent = 0, $sel = null)
{
  $result = "<ul class='treme'>";
  foreach ($rows as $row) {

    if ($row['parent_id'] == $parent) {

      if (in_array("$row[cat_id]", $sel)) {
        $result .= "<li> <input disabled type='checkbox' name='p_cat[]' checked value='{$row['cat_id']}'/> {$row['cat_name']}";
      } else {
        $result .= "<li> <input disabled type='checkbox' name='p_cat[]' value='{$row['cat_id']}'/> {$row['cat_name']}";
      }

      if (has_children($rows, $row['cat_id'])) {
        $result .= build_menu($rows, $row['cat_id'], $sel);
      }
      $result .= "</li>";
    }
  }
  $result .= "</ul>";
  return $result;
}

?>
<style>
  .treme {
    list-style: none;
    padding: 0px 20px;
  }

  a:hover {
    text-decoration: none;
  }

  .pcat {
    border: solid 1px #f1f1f1;
    height: 250px;
    overflow-y: scroll;
    padding: 20px
  }

  .pcat li {
    padding-left: 20px;
  }
</style>



<div id="page-content">
<?php foreach ($product_data as $product) {} ?>

                                            
    <div class="uk-grid-small uk-child-width-expand@m" uk-grid>
      <div>
        <div class="uk-card uk-card-small uk-card-body uk-card-default">
          <h4>Product Details</h4>
          <hr>
  <form action="<?php echo base_url(); ?>/Vendor/product_price" enctype="multipart/form-data" method="post">


          <div class="form-group">
          <input type="hidden" name="productid" value="<?= $product->product_id ?>" id="ProductInsertId">
          
            <label for="exampleInputEmail1">Product Name</label>
            <input type="text" readonly class="form-control" id="product_name" name="product_name" placeholder="Enter Product Name" onchange="InsertNewProduct();" value="<?= $product->product_name ?>" required="">
          </div>
			
            
            <?php foreach ($allpricedata as $pricevari){}?>
            <div class="uk-grid-small uk-child-width-expand" uk-grid>
            <div>
            <label>Regular Price</label>
            <input type="text" name="regularprice" class="form-control" value="<?php if(!empty($allpricedata)){ echo $pricevari->regular_price; }  ?>" />
            </div>
            
             <div>
            <label>Sales Price</label>
            <input type="text" name="salesprice" class="form-control" value="<?php if(!empty($allpricedata)){ echo $pricevari->sale_price; }  ?>" required />
            </div>
            
            <div>
            <label>Product Image</label>
            <input type="file" name="img" class="form-control" />
            
            </div>
            
            	<?php if(!empty($allpricedata)){ 
					if ($pricevari->image!=""){
				?>
                <div>
				<img src="<?php echo base_url(); ?>/uploads/<?=$pricevari->image?>"/>
                </div>
				<?php }}  ?>
            
            </div>
           
            
            <p></p>
            <button type="submit" class="btn btn-primary"> Submit</button>
     </form>      
        
        </div>
        
	
        	        <?php if($product->prodType == '1'){ ?>
                    <div class="uk-card uk-card-body uk-card-small uk-card-default uk-margin-top">
 			 <form action="<?php echo base_url(); ?>/Vendor/product_variationprice" enctype="multipart/form-data" method="post">
                    
            <h4> Variation  Details</h4>
            <hr>
            <input type="hidden" name="productid" value="<?= $product->product_id ?>" id="ProductInsertId">
            <div class="uk-grid-small uk-child-width-expand" uk-grid>
				<?php foreach($attribute as $attr){?>
                <div>
                    <label> <?=$attr->attribute_name; ?></label>
                    <select class="form-control" name="variation[]">
                        <option value="">Select Variation</option>
                        <?php foreach($variations as $vari){
                            if ($vari->attribute_id==$attr->attribute_id){
                            ?>
                            <option value="<?=$vari->variation_id; ?>"><?=$vari->variation_name; ?></option>
                        <?php }}?>
                    </select>
                </div>
                <?php }?>
                <div>
                <label>Regular Price</label>
                <input type="text" name="regularprice" class="form-control" />
                </div>
                
                 <div>
                <label>Sales Price</label>
                <input type="text" name="salesprice" class="form-control" required />
                </div>
                
                 <div>
                <label>Product Image</label>
                <input type="file" name="img" class="form-control" />
                
                </div>
                
                <div class="uk-width-auto"><p></p><button type="submit" class="btn btn-primary"> Add</button></div>
            </div>
            
            </form>
             <p></p>
            <?php if(session()->getFlashdata('msg')):?>
       <div class="alert alert-warning">
       <?= session()->getFlashdata('msg') ?>
       </div>
<?php endif;?>

           
            <table class="table" id="example-datatable">
            	<thead>
                <tr>
                	<th>Sl No</th>
                    <th>Variatio</th>
                    <th>Sales Price</th>
                    <th>Regular Price</th>
                    <th>image</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php 
				$i=1;
				foreach($allvariationpricedata as $vardata){?>
                <tr>
                	<td><?=$i++;?></td>
                    <td><?=$vardata->variation_value;?></td>
                    <td><?=$vardata->regular_price;?></td>
                    <td><?=$vardata->sale_price;?></td>
                    <td><img src="<?php echo base_url(); ?>/uploads/<?=$pricevari->image?>" width="50"/></td>
                    <td>
                     <a class="btn btn-sm btn-danger"  href="javascript:void(0);" onClick="deleteRecord('<?= $vardata->price_varition_id; ?>');"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
            </div>
            <?php }?>
        

		<div class="uk-card uk-card-body uk-card-small uk-card-default uk-margin-top">
              <h4>Product Type</h4>
 				<hr>
                <label for="onlinePayment" style="font-weight:400">
                    <input type="radio" name="productType"  <?php if($product->prodType == '0'){ echo 'checked';}?>  value="0" required onclick="SelectProductType(0)"/> Simple Product
                </label>&nbsp; &nbsp;&nbsp;
               
                  <label for="cod" style="font-weight:400">
                       <input type="radio"  name="productType" <?php if($product->prodType == '1'){ echo 'checked';}?> value="1"  required onclick="SelectProductType(1)"> Variation Product</label>
       
             
            
             <div class="form-group uk-margin-top uk-margin-small">
            <label for="exampleInputEmail1">Product Short Description</label>
            <textarea readonly id="editor1" class="form-control" name="description"><?= $product->description ?></textarea>
          </div>
            </div>
            
        <div class="uk-grid-small uk-child-width-expand uk-grid-match" uk-grid>
            
	    <div>    <div class="uk-card uk-card-body uk-card-default uk-card-small uk-margin-top">
          <div class="form-group">
            <h4>Select Brand</h4>
            <div class="uk-height-small" style="border:solid 1px #ccc; min-height:300px; overflow-y:scroll">
              <ul class="treme">
                <li><input type="radio" <?php if ($product->brands_id==0) { echo "checked";  } ?> name="brand" value="0" name="brand"> No Brand</li>
                <?php foreach ($allBrands as $banner) { ?>
                  <li><input type="radio" disabled  value="<?= $banner->brands_id; ?>" <?php if ($banner->brands_id == "$product->brands_id") { echo "checked";  } ?> name="brand"> <?= $banner->brands_name; ?></li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div></div>
        <div>    
       <div class="uk-card uk-card-body uk-card-default uk-card-small uk-margin-top"> 
          <div class="form-group">
            <h4>Select Category</h4>

            <div class="uk-height-small" style="border:solid 1px #ccc; min-height:300px; overflow-y:scroll">
              <?php echo build_menu($category, 0, $simple_array1); ?>
            </div>
          </div>
        </div>
        </div>
        <div>    <div class="uk-card uk-card-body uk-card-default uk-card-small uk-margin-top">
          <div class="form-group">

            <h4>Primary Image</h4>
           
              <?php if ($product->primary_image == '') { ?>
                <img src="<?php echo base_url(); ?>/uploads/default.png" width="100%">
              <?php } else { ?>
                <img src="<?php echo base_url(); ?>/uploads/<?= $product->primary_image ?>" width="100%">
              <?php } ?>
            
          </div>
        </div></div>
        <div class="uk-width-1-1">    
        <div class="uk-card uk-card-body uk-card-default uk-card-small uk-margin-top">
            <h4> Gallery Images</h4>
            <div class="uk-child-width-1-3@m uk-grid-small uk-grid-match" uk-grid>

              <?php foreach ($allGallery as $gallery) { ?>
                <div class="uk-position-relative">
                  <img src="<?php echo base_url(); ?>/uploads/<?= $gallery->image ?>" width="100%">
                  
                </div>
              <?php } ?>
            </div>
        </div></div>
       </div>
            
      </div>

      <div class="uk-width-1-4@m">
       

        
      </div>
    </div>






</div>
</div>







<script>

  

  function deleteRecord(variation_id) {
  if (confirm("Are you sure you want to delete this variation?")) {
    $.ajax({
      type: "POST",
      url: "<?= base_url('Vendor/delete_variationprice'); ?>",
      data: {
        variation_id: variation_id
      },
      success: function (data) {
        location.reload();
      }
    });
  }
}
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<?php if ($product->sales_price <= 100) {
  $saleprice = $product->sales_price - 10;
} elseif ($product->sales_price > "100" and $product->sales_price <= 200) {
  $saleprice = $product->sales_price - 20;
} elseif ($product->sales_price > "200") {
  $saleprice = $product->sales_price - 30;
} else {
  $saleprice = 0;
} ?>

<script>
  $(function() {
    $("input[name='saleperprice']").on('input', function(e) {
      $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });

    $("input[name='regperprice']").on('input', function(e) {
      $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });

    $("input[name='stock']").on('input', function(e) {
      $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });

    $("input[name='Varprice[]']").on('input', function(e) {
      $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });

    $("input[name='Varstock[]']").on('input', function(e) {
      $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });

  });
</script>
<script>
  function FormCtrl($) {
    var self = this;
    var MIN_VALUE = <?= $saleprice ?>;

    self.minValueAccepted = MIN_VALUE;
    self.min = $('#ValA');
    self.field = $('#ValB');

    self.formFeedback = function(message, success) {
      var type = success ? 'info' : 'danger';

      console.log(message, success)

      return $('#formFeedback').html('<p class="text-' + type + '">' + message + '</p>');
    };
    self.updateField = function(event) {
      var value = Number(self.field.val());
      var isValid = false;
      var message = 'Regular Price should greater than Sales Price';


      if (value > self.minValueAccepted) {
        isValid = true;
        message = '';
      }

      return self.formFeedback(message, isValid);
    };

    self.updateMinValue = function(event) {
      self.minValueAccepted = Number(self.min.val());
    };

    this.min.change(self.updateMinValue);
    this.field.change(self.updateField);

    this.min.val(MIN_VALUE);
  }

  jQuery(document).ready(FormCtrl);
</script>


<script>
  $(document).ready(function() {
    $('#city_id').on('change', function() {
      var cityId = $(this).val();
      $.ajax({
        url: '<?php echo base_url(); ?>/Admin/Get_School',
        type: 'POST',
        data: {
          city_id: cityId
        },
        success: function(response) {
          $('#getschool').html(response);
        },
        error: function(xhr, status, error) {
          // Handle error response here
        }
      });
    });
  });
</script>


<?php include('footer.php') ?>