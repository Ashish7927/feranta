<?php include("header.php"); ?>
<?php include("mainsidebar.php"); ?>

<div id="page-content">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <section class="content container-fluid">
    <div class="card shadow mb-4">
      <div class="uk-card uk-card-body uk-card-default uk-card-small">
		
        <a data-toggle="modal" href="#myModal" class="btn btn-primary">Add Product</a>

        <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              

              <form action="<?php echo base_url(); ?>/Vendor/Add_product" method="post" enctype="multipart/form-data">
                    <div class="modal-header">

                      <h4 class="modal-title">Add Product Name</h4>
                    </div>
                    <div class="modal-body">
                      <input type="text" name="pname" placeholder="" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                      <button type="sybmit" class="btn btn-primary">SUBMIT</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </form>



            </div>

          </div>
        </div>

   

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












<?php include("footer.php"); ?>