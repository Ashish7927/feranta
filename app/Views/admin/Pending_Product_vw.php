<?php include("header.php"); ?>
<?php include("mainsidebar.php"); ?>

<div id="page-content">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <section class="content container-fluid">
    <div class="card shadow mb-4">
      <div class="uk-card uk-card-body uk-card-default uk-card-small">

   

        <div class="table-responsive">
          <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
            <thead>
              <tr>
                <th>Sl.#</th>
                <th>Image</th>
                <th>Product Name</th>
                <th> Price</th>
                <!-- <th >  Brand</th>-->
                <th> Category</th>
                <th> </th>

                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php

              use App\Models\AdminModel;

              $db = db_connect();
              $this->AdminModel = new AdminModel($db);
              $i = 1;
              foreach ($product_data as $product) {


                $pro_id = $product->product_id;
                $category = $this->AdminModel->getselectedcategory($pro_id);


                $brands_id = $product->brands_id;
              ?>

                <tr>
                  <td><?= $i++;; ?></td>
                  <td>
                    <?php
                    if ($product->primary_image  != "") { ?>
                      <img src="<?php echo base_url(); ?>/uploads/<?= $product->primary_image; ?>" style="width:50px;" />
                    <?php } else { ?>
                      <img src="<?php echo base_url(); ?>/uploads/default.png" style="width:50px;" />
                    <?php } ?>
                  </td>
                  <td><?= $product->product_name; ?></td>
                  <td>Rs. <del><?= $product->regular_price; ?></del> <br>Rs. <?= $product->sales_price; ?></td>
                  <td>
                    <?php foreach ($category as $cate) { ?>
                      <?= $cate->cat_name; ?>,
                    <?php } ?>
                  </td>
                  <td> </td>
                  <td>
                   <?php 
				   
				   if ($product->approve == 1) { ?>
                  	  <a href="javascript:void(0);" onClick="productstatus('<?= $product->product_id; ?>','0');" class="btn btn-success btn-sm">Aprove</a>
				  <?php } else { ?>
                      <a href="javascript:void(0);" onClick="productstatus('<?= $product->product_id; ?>','1');" class="btn btn-danger btn-sm">Disapprove</a><?php } ?>
                  </td>
                  <td>



                    <a class="btn btn-sm btn-warning" href="<?php echo base_url(); ?>/admin/Edit_product/<?= $product->product_id; ?>"> <i class="fa fa-edit" aria-hidden="true"></i> </a>
                    <a href="javascript:void(0);" onClick="deleteRecord('<?= $product->product_id; ?>');"><button type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button></a>




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

<form name="statusform" id="statusform" action="<?php echo base_url(); ?>/Admin/approveproduct" method="post">
  <input type="hidden" name="product_id" id="product_id" value="">
  <input type="hidden" name="status" id="status" value="">
</form>
<script type="text/javascript">
  function productstatus(id,status) {
	  
    $("#product_id").val(id);
    $("#status").val(status);
    var conf = confirm("Are you sure want to change the status");
    if (conf) {
      $("#statusform").submit();
    }
  }
</script>

















<form name="frm_deleteBanner" id="frm_deleteBanner" action="<?php echo base_url(); ?>/Admin/deleteProduct" method="post">
  <input type="hidden" name="operation" id="operation" value="">
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


<?php include("footer.php"); ?>