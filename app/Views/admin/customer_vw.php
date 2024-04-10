<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>


<!-- Page content -->
<div id="page-content">
    <!-- Blank Header -->
    <div class="content-header">
        <div class="header-section">
            <h1>
                Customer
                <a class="btn btn-sm btn-primary uk-align-right" href="#modal-center" uk-toggle>Customer</a>
            </h1>

        </div>
    </div>

    <!-- END Blank Header -->
<div class="uk-grid-small uk-child-width-expand" uk-grid>
    <div class="uk-width-1-3">
        <div class="block">
        <form action="<?php echo base_url(); ?>/Admin/Insertcustomer" enctype="multipart/form-data" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="example-nf-email">CustomerName</label>
                                <input class="form-control" type="text" name="customername" id="customername" value="<?= set_value('customername') ?>">
                                <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('customername'); ?></span><?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="example-nf-email">Customer Email</label>
                                <input class="form-control" type="email" name="customeremail" id="customeremail" value="<?= set_value('customeremail') ?>">
                               
                            </div>
                              <div class="form-group">
                                <label for="example-nf-email">Customer Contactno</label>
                                <input class="form-control" type="text" name="customercontno" id="customercontno" value="<?= set_value('customercontno') ?>">
                                <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('customercontno'); ?></span><?php } ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
        </div>
    </div>
    <div>
    <div class="block">
     
     <!-- END Example Title -->

     <!-- Example Content -->

     <!-- END Example Content -->

     <div class="block full">
         <div class="block-title">
             <h2><strong>Customer</strong></h2>
         </div>
         <div class="table-responsive">
             <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
                 <thead>
                     <tr>
                         <th class="text-center">ID</th>

                         <th class="text-center">Customer Name</th>
                         <th class="text-center">Customer Email</th>
                         <th class="text-center">Customer Contactno</th>
                         <th class="text-center">Status</th>
                         <th class="text-center">Action</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                     $i = 1;
                     foreach ($customer as $customerr) { ?>
                         <tr>
                             <td class="text-center"><?= $i++; ?></td>
                             <td class="text-center"><?= $customerr->full_name; ?></td>
                             <td class="text-center"><?= $customerr->email; ?></td>
                              <td class="text-center"><?= $customerr->contact_no; ?></td>
                             <td class="text-center">
                                 <?php if ($customerr->status == 0) { ?>
                                     <a href="javascript:void(0);" onClick="statusupdate('<?= $customerr->id; ?>','1');"><button type="button" class="btn btn-danger ">Deactivate</button></a>
                                 <?php } else { ?>
                                     <a href="javascript:void(0);" onClick="statusupdate('<?= $customerr->id; ?>','0');"> <button type="button" class="btn btn-success"> Active </button></a>
                                 <?php } ?>
                             </td>
                             <td class="text-center">
                                 <div class="btn-group">
                                     <a href="#modal-center<?= $customerr->id; ?>" uk-toggle title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                     <a href="javascript:void(0);" onClick="deleteRecord('<?= $customerr->id; ?>');" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                 </div>
                             </td>
                         </tr>
                     <?php } ?>



                 </tbody>
             </table>

             <?php foreach ($customer as $customerr)  { ?>
                 <div id="modal-center<?= $customerr->id; ?>" class="uk-flex-top" uk-modal>

                     <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

                         <button class="uk-modal-close-default" type="button" uk-close></button>

                         <form action="<?php echo base_url(); ?>/Admin/Editcustomer" enctype="multipart/form-data" method="post">
                             <div class="modal-body">
                                 <?php if (session()->getFlashdata('uid') == $customerr->id) : ?>
                                     <div class="alert alert-warning">
                                         <?= session()->getFlashdata('msg') ?>
                                     </div>
                                 <?php endif; ?>
                                 <input type="hidden" name="customerid" value="<?= $customerr->id; ?>">
                                 <div class="row uk-text-left">

                                    <div class="form-group">
                                         <label for="example-nf-email">CustomerName</label>
                                         <input class="form-control" type="text" name="customername" id="customername" value="<?= $customerr->full_name; ?>">
                                         <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('customername'); ?></span><?php } ?>
                                     </div>
                                     <div class="form-group">
                                         <label for="example-nf-email">Customer Email</label>
                                         <input class="form-control" type="text" name="customeremail" id="customeremail" value="<?= $customerr->email; ?>">
                                         <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('customeremail'); ?></span><?php } ?>
                                     </div>
                                       <div class="form-group">
                                         <label for="example-nf-email">Customer Contactno</label>
                                         <input class="form-control" type="text" name="customercontno" id="customercontno" value="<?= $customerr->contact_no; ?>">
                                         <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('customercontno'); ?></span><?php } ?>
                                     </div>


                                     <div class="modal-footer">
                                         <button type="submit" class="btn btn-primary">Submit</button>
                                     </div>
                                 </div>
                             </div>
                         </form>

                     </div>
                 </div>
             <?php } ?>
         </div>
     </div>


 </div>
    </div>

</div>
    <!-- Example Block -->
    
    <!-- END Example Block -->
</div>
<!-- END Page Content -->




<form name="status_update" id="status_update" action="<?php echo base_url(); ?>/Admin/statuscustomer" method="post">
    <input type="hidden" name="customer_id" id="customer_id" value="">
    <input type="hidden" name="customer_status" id="customer_status" value="">
</form>

<script type="text/javascript">
    function statusupdate(id, status) {
        // alert(id);
        $("#customer_id").val(id);
        $("#customer_status").val(status);
        var conf = confirm("Are you sure want to change the status");
        if (conf) {
            $("#status_update").submit();
        }
    }
</script>
<form name="frm_deleteBanner" id="frm_deleteBanner" action="<?php echo base_url(); ?>/Admin/deletecustomer" method="post">
    <input type="hidden" name="user_id" id="user_id" value="">
</form>

<script type="text/javascript">
    function deleteRecord(id) {
        $("#operation").val('delete');
        $("#user_id").val(id);
        var conf = confirm("Are you sure want to delete this customer");
        if (conf) {
            $("#frm_deleteBanner").submit();
        }
    }
</script>



<?php if (isset($validation)) { ?>
<script>
    // Wait for the page to fully load
    document.addEventListener("DOMContentLoaded", function () {
        // Find your modal element by its ID
        var modal = document.getElementById("modal-center");

        // Open the modal
        UIkit.modal(modal).show();
    });
</script>

<?php } ?>
<?php include("footer.php") ?>