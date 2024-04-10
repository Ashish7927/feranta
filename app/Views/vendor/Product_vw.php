<?php include("header.php"); ?>
<?php include("mainsidebar.php"); ?>

<div id="page-content">
  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />


  <section class="content container-fluid">
    <div class="card shadow mb-4">
      <div class="uk-card uk-card-body uk-card-default uk-card-small">

        
        
              <form action="<?php echo base_url(); ?>/Vendor/Add_product_price" method="post" id="addform" enctype="multipart/form-data">
    <div class="modal-header">
        <h4 class="modal-title">Search Product</h4>
    </div>
    <div class="modal-body">
        <div class="uk-grid-small uk-child-width-expand" uk-grid>
            <div class="uk-width-auto"> 
                <select id="single" name="selectproduct" class="js-states form-control" style="max-width:400px;">
                    <option value="">Search Product</option>
                    <option value="0">Add New Product</option>
                    <?php foreach ($Allproduct_data as $prod) {?>
                        <option value="<?= $prod->product_id ?>"><?= $prod->product_name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <button type="button" class="btn btn-primary" onclick="showSelectedValue()">SUBMIT</button>
            </div>
        </div>
    </div>
</form>


<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal">&times;</button>

            <form id="addNewProductForm" action="<?php echo base_url(); ?>/Vendor/Add_product" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title">Add Product Name</h4>
                </div>
                <div class="modal-body">
                    <input type="text" name="pname" placeholder="" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">SUBMIT</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    function showSelectedValue() {
        // Get the value of the selected option
        var selectedValue = document.getElementById("single").value;

        // Check if the selected value is "0"
        if (selectedValue === "0") {
            // Open Bootstrap modal
            $('#myModal').modal('show');
        } else {
            // Submit the form
            document.querySelector("form").submit();
        }
    }
</script>





          
          


        <div class="table-responsive">
          <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
            <thead>
              <tr>
                <th>Sl.#</th>
                <th>Image</th>
                <th>Product Name</th>
                <th> Regular Price</th>
                <th > Sale Price</th>
                <th> Brand</th>

                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              
			<?php 
			$i=1;
			foreach ($product_data as $product){?>
             <tr>
             	<td><?=$i++;?></td>
                <td><img src="<?php echo base_url(); ?>/uploads/<?=$product->primary_image; ?>" width="50" /></td>
                <td><?=$product->product_name; ?></td>
                <td><?=$product->price; ?></td>
                <td><?=$product->sale_price; ?></td>
                <td><?=$product->brands_name; ?></td>
                <td>
                <?php if($product->vstatus ==0){?>
                  <a href="javascript:void(0);" onClick="statusupdate('<?= $product->product_price_id;?>','1');" ><button type="button" class="btn btn-danger ">Deactivate</button></a>
                  <?php }else{?>
                   <a href="javascript:void(0);" onClick="statusupdate('<?= $product->product_price_id;?>','0');"> <button type="button" class="btn btn-success"> Active </button></a>
                <?php }?>
                </td>
                <td>
                <a href="<?php echo base_url(); ?>/Vendor/Edit_ProductPrice/<?= $product->product_id; ?>"  title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                 <a href="javascript:void(0);" onClick="deleteRecord('<?= $product->product_price_id; ?>');" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                </td>
             </tr>
                
              <?php } ?>


            </tbody>


          </table>
        </div>

      </div>
    </div>

  </section>
  <!-- /.content -->
</div>

<form name="frm_deleteBanner" id="frm_deleteBanner" action="<?php echo base_url(); ?>/Vendor/deleteProduct" method="post">
  <input type="hidden" name="user_id" id="user_id" value="">
</form>
<script type="text/javascript">
  function deleteRecord(id) {
    $("#operation").val('delete');
    $("#user_id").val(id);
    var conf = confirm("Are you sure want to delete this Product");
    if (conf) {
      $("#frm_deleteBanner").submit();
    }
  }
</script>



<form name="status_update" id="status_update" action="<?php echo base_url(); ?>/Vendor/vendorprice" method="post">
   <input type="hidden" name="p_id" id="product_id" value="">
   <input type="hidden" name="status" id="status" value="">
</form>

<script type="text/javascript">
  function statusupdate(id,status) {
   // alert(id);
    $("#product_id").val(id);
	$("#status").val(status);
    var conf = confirm("Are you sure want to change the status");
    if (conf) {
      $("#status_update").submit();
    }
  }
</script>





 	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
      $("#single").select2({
          placeholder: "Select a programming language",
          allowClear: true
      });
      $("#multiple").select2({
          placeholder: "Select a programming language",
          allowClear: true
      });
    </script>

<?php include("footer.php"); ?>