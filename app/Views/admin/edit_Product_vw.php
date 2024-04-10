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
        $result .= "<li> <input type='checkbox' name='p_cat[]' checked value='{$row['cat_id']}'/> {$row['cat_name']}";
      } else {
        $result .= "<li> <input type='checkbox' name='p_cat[]' value='{$row['cat_id']}'/> {$row['cat_name']}";
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




  <?php foreach ($product_data as $product) {
  } ?>


  <form action="<?php echo base_url(); ?>/admin/update_product" enctype="multipart/form-data" method="post">

    <div class="uk-grid-small uk-child-width-expand@m" uk-grid>
      <div>
        <div class="uk-card uk-card-small uk-card-body uk-card-default">
          <h4>Product Details</h4>
          <hr>


          <div class="form-group">
            <label for="exampleInputEmail1">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter Product Name" onchange="InsertNewProduct();" value="<?= $product->product_name ?>" required="">
            <input type="hidden" name="productid" value="<?= $product->product_id ?>" id="ProductInsertId">
            <div style="color:red;" id="CheckProductEmpty"></div>
          </div>

          <?php
          if ($product->product_type == 2) { ?>

            <label>Select City</label>
            <select class="uk-select" name="city_id" id="city_id">
              <?php foreach ($allcity as $city) { ?>
                <option <?php if ($city->city_id === $product->pcity_id) {
                          echo "selected";
                        } ?> value="<?= $city->city_id ?>"><?= $city->city_name ?></option>
              <?php } ?>
            </select>


            <div id="getschool">
              <label>Select School</label>
              <select class="uk-input" required name="school_id" id="school_id">
                <?php foreach ($school as $school_obj) { ?>
                  <option <?php if ($school_obj->school_id === $product->pschool_id) {
                            echo "selected";
                          } ?> value="<?= $school_obj->school_id; ?>"><?= $school_obj->school_name; ?></option>
                <?php } ?>
              </select>



              <lable>Select Class </lable>
              <select class="uk-input" required name="class_id" id="school_id">
                <?php foreach ($class as $class_obj) { ?>
                  <option <?php if ($class_obj->class_id === $product->pclass_id) {
                            echo "selected";
                          } ?> value="<?= $class_obj->class_id; ?>"><?= $class_obj->class_name; ?></option>
                <?php } ?>
              </select>
            </div>

          <?php   } ?>
          <div class="form-group">
            <label for="exampleInputEmail1">Product Short Description</label>
            <textarea id="editor1" class="form-control" name="description"><?= $product->description ?></textarea>
          </div>

         

        </div>

		<div class="uk-card uk-card-body uk-card-small uk-card-default uk-margin-top">
              <h4>Product Type</h4>
 				<hr>
                <label for="onlinePayment" style="font-weight:400">
                    <input type="radio" name="productType"  <?php if($product->prodType == '0'){ echo 'checked';}?>  value="0" required onclick="SelectProductType(0)"/> Simple Product
                </label>&nbsp; &nbsp;&nbsp;
               
                  <label for="cod" style="font-weight:400">
                       <input type="radio"  name="productType" <?php if($product->prodType == '1'){ echo 'checked';}?> value="1"  required onclick="SelectProductType(1)"> Variation Product</label>
       
             
              
            <div id="ProductTypeID" <?php if($product->prodType == '0'){ echo 'style="display:none;"';}else{ echo 'style="display:block;"';}?> >
            
              <label>Add Attribute</label>
              
              <table class="table table-responsive table-striped table-bordered">
<thead>
	<tr>
    	<td>Attribute</td>
    	<td>Variation with | Separetor</td>
        <td style="width:150px;"></td>
    </tr>
</thead>
	<tbody id="AttributeContainer">
	    <tr >
    	<td><input type="text" class="form-control" name="attribute" placeholder="Enter Attribute like Colr , Size etc" id="attributeName"  />
    	 <div  style="color:red;" id="CheckAttributeEmpty"></div>
                </td>
    	<td><input type="text" class="form-control" name="variation" placeholder="Enter variation with | separator"  id="variationValue" />
    	 <div  style="color:red;" id="CheckVariationEmpty"></div></td>
    	
    	<td style="width:150px;"><button type="button" onclick="InsertAttribute()" class="btn btn-success" data-toggle="tooltip" data-original-title="Add Attribute">&nbsp; Add&nbsp;</button></td>
    </tr>
    
   
    
    
</tbody>

</table>


               
            <div id="VariationDtl">
            		<table class="uk-table uk-table-small uk-table-divider">
  <thead>
    <tr>
      <th>Attribute Name</th>
      <th>Variation Value</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($attribute as $attributes): ?>
  <tr>
  	<td><h4><?php echo $attributes->attribute_name; ?></h4></td>
    <?php foreach ($variations as $variation): 
	if($variation->attribute_id==$attributes->attribute_id){
	?>
      <tr>
        <td></td>
        <td><?php echo $variation->variation_name; ?></td>
        <td width="100">
         <a href="javascript:void(0);" onClick="deleteRecord('<?= $variation->variation_id; ?>');" class=" btn btn-danger">Delete</a>
        </td>
      </tr>
    <?php } endforeach; ?>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

            </div>
            </div>
           
            </div>
            
      </div>

      <div class="uk-width-1-4@m">
        <div class="uk-card uk-card-body uk-card-default uk-card-small">
          <div class="form-group">
            <h4>Select Category</h4>

            <div class="uk-height-small" style="border:solid 1px #ccc hidden300px;; overflow-y:scroll">
              <?php echo build_menu($category, 0, $simple_array1); ?>
            </div>
          </div>
        </div>
        <div class="uk-card uk-card-body uk-card-default uk-card-small uk-margin-top">
          <div class="form-group">
            <h4>Select Brand</h4>
            <div class="uk-height-small" style="border:solid 1px #ccc;">
              <ul class="treme">
                <li><input type="radio" <?php if ($product->brands_id==0) { echo "checked";  } ?> name="brand" value="0" name="brand"> No Brand</li>
                <?php foreach ($allBrands as $banner) { ?>
                  <li><input type="radio" value="<?= $banner->brands_id; ?>" <?php if ($banner->brands_id == "$product->brands_id") { echo "checked";  } ?> name="brand"> <?= $banner->brands_name; ?></li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="uk-card uk-card-body uk-card-default uk-card-small uk-margin-top">
          <div class="form-group">

            <h4>Upload Primary Image</h4>
            <input type="file" name="img" class="form-control">
            <p></p>
            <div class="uk-card uk-card-body uk-card-default">
              <?php if ($product->primary_image == '') { ?>
                <img src="<?php echo base_url(); ?>/uploads/default.png" width="100%">
              <?php } else { ?>
                <img src="<?php echo base_url(); ?>/uploads/<?= $product->primary_image ?>" width="100%">
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="uk-card uk-card-body uk-card-default uk-card-small uk-margin-top">
          <div class="uk-card uk-card-body uk-card-default uk-card-small uk-margin-top">
            <label>Upload Gallery Images</label>
            <input type="file" class="form-control" name="images[]" multiple>
            <p></p>
            <div class="uk-child-width-1-3@m uk-grid-small uk-grid-match" uk-grid>

              <?php foreach ($allGallery as $gallery) { ?>
                <div class="uk-position-relative">
                  <img src="<?php echo base_url(); ?>/uploads/<?= $gallery->image ?>" width="100%">
                  <a href="javascript:void(0);" onClick="deleteRecord('<?= $gallery->gallery_id; ?>');" class=" uk-button-small  uk-button-danger uk-width-1-1">Delete</a>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>

        <div class="uk-card uk-card-small uk-card-body uk-card-default">
          <button type="submit" name="submit" id="submit" value="addproduct" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>





  </form>
</div>
</div>



<form name="frm_deleteBanner" id="frm_deleteBanner" action="<?php echo base_url(); ?>/admin/deleteGallery" method="post">
  <input type="hidden" name="operation" id="operation" value="">
  <input type="hidden" name="user_id" id="user_id" value="">
  <input type="hidden" name="product_id" id="product_id" value="<?= $product->product_id; ?>">
</form>
<script type="text/javascript">
  function deleteRecord(id) {
    $("#operation").val('delete');
    $("#user_id").val(id);
    var conf = confirm("Are you sure want to delete this City");
    if (conf) {
      $("#frm_deleteBanner").submit();
    }
  }
</script>



<script>
  function SelectProductType(arg) {

    if (arg == '1') {
      $('#ProductTypeID').css('display', 'block');

    } else {
      $('#ProductTypeID').css('display', 'none');

    }

  }

  function GetSubCategory(val, arg) {
    var start = parseInt(arg) + 1;
    for (let i = start; i < 6; i++) {
      $("#categoryIndex" + i).remove();
    }
    var url = "<?php echo base_url(); ?>admin/GetAjax";
    $.post(url, {
      "choice": "getSubCat",
      "value": val,
      "index": arg
    }, function(res) {
      var result = res.trim();
      $('#selectCategoryId').append(result);

    });

  }

  function InsertNewProduct() {
    var product_name = document.getElementById("product_name").value;
    var ProductInsertId = document.getElementById("ProductInsertId").value;
    if (ProductInsertId == "") {
      var url = "<?php echo base_url(); ?>admin/GetAjax";
      $.post(url, {
        "choice": "InsertNewProduct",
        "product_name": product_name
      }, function(res) {
        var result = res.trim();
        $('#ProductInsertId').val(result);
      });
    }
    exit();

  }

  function InsertAttribute() {
  var attribute = document.getElementById("attributeName").value;
  var variation = document.getElementById("variationValue").value;
  var productID = document.getElementById("ProductInsertId").value;
  

  if (attribute == "") {
    $("#CheckAttributeEmpty").html("Attribute Name should not be empty!");
    return;
  }
  if (variation == "") {
    $("#CheckVariationEmpty").html("Variation values should not be empty!");
    return;
  }
  if (productID == "") {
    $("#CheckProductEmpty").html("Product Name should not be empty!");
    return;
  }

  var url = "<?php echo base_url(); ?>/Admin/InsertAttribute";
  $.post(url, {
    "choice": "AddAttribute",
    "attribute": attribute,
    "variation": variation,
    "productID": productID
  }, function(response) {
	 // alert(response);
    $("#VariationDtl").html(response);
	
  });
}

  function deleteRecord(variation_id) {
  if (confirm("Are you sure you want to delete this variation?")) {
    $.ajax({
      type: "POST",
      url: "<?= base_url('admin/delete_variation'); ?>",
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