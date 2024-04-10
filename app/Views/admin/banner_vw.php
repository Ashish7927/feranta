<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>




<!-- Page content -->
<div id="page-content">
    <!-- Dashboard Header -->
    <!-- For an image header add the class 'content-header-media' and an image as in the following example -->

    <!-- END Dashboard Header -->

    <!-- Mini Top Stats Row -->

    <h3>Banner/Add Management</h3>



    <div class="uk-child-width-expand uk-grid-small" uk-grid>
        <div class="uk-width-1-3">
            <div class="uk-card uk-card-body uk-card-default uk-card-small">

                <form action="<?php echo base_url(); ?>/admin/addbanner" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Enter Banner/add Tittle</label>
                        <input type="text" class="form-control" name="title" required value="<?php echo set_value('title'); ?>">
                    </div>

                    <div class="form-group">
                        <label>Enter Banner/add Sub Tittle</label>
                        <input type="text" class="form-control" name="subtitle" value="<?php echo set_value('title'); ?>">
                    </div>


                    <div class="form-group">
                        <label>Order No</label>
                        <input type="number" class="form-control" name="orderby" required value="<?php echo set_value('orderby'); ?>">
                    </div>

                    <div class="form-group">
                        <label>Enter Banner/add Link</label>
                        <input type="url" class="form-control" name="url" value="<?php echo set_value('url'); ?>">
                    </div>

                    <div class="form-group">
                        <label>Enter Banner/ Add Description</label>
                        <textarea id="editor1" name="description" class="form-control" placeholder="Description"><?php echo set_value('description'); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Banner / Add Type</label>
                        <select class="form-control" name="ban_type" required>
                            <option value="banner">Banner</option>
                            <!--<option value="category">Category</option>-->
                            <option value="offer">Offer</option>
                            <!--<option value="add-2">Add-2</option>-->
                            <!--<option value="add-3">Add-3</option>-->
                            <!--<option value="add-4">Add-4</option>-->
                            <!--<option value="add-4">Add-5</option>-->
                        </select>
                    </div>


                    <div class="form-group">
                        <label>Uploade Banner/ Add Image</label>
                        <input type="file" name="img" class="form-control" required>
                    </div>
                    <p></p>



                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>


        <div>
            <div class="uk-card uk-card-body uk-card-default uk-card-small">

                <div class="uk-alert-danger"> <?php if (isset($message)) {
                                                    echo $message;
                                                } ?></div>

                <div class="table-responsive">
                    <table id="example1" class="table table-vcenter table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th>Sl.#</th>
                                <th>Image</th>
                                <th> Tittle</th>
                                <th> Description</th>
                                <th> Order No</th>
                                <th> Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $i = 1;
                            foreach ($banner_data as $banner) {

                            ?>

                                <tr>
                                    <td><?= $i++;; ?></td>
                                    <td><img src="<?= base_url(); ?>/uploads/<?= $banner->image ?>" width="50"></td>
                                    <td><?= $banner->banner_title; ?></td>
                                    <td><?= $banner->description; ?></td>
                                    <td><?= $banner->orderby; ?></td>
                                    <td><?= $banner->type; ?></td>



                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">




                                            <a class="btn btn-xs btn-danger  btn-warning" href="<?php echo base_url(); ?>/Admin/edit_banner/<?= $banner->banner_id; ?>"> <i class="fa fa-edit" aria-hidden="true"></i> Edit</a>
                                            <a href="javascript:void(0);" onClick="deleteRecord('<?= $banner->banner_id; ?>');" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i> Delete</a>


                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>


                        </tbody>


                    </table>
                </div>

            </div>
        </div>
    </div>




</div>
<!-- END Mini Top Stats Row -->

</div>
<!-- END Page Content -->
<form name="frm_deleteBanner" id="frm_deleteBanner" action="<?php echo base_url(); ?>/admin//Delete_Banner" method="post">
    <input type="hidden" name="operation" id="operation" value="">
    <input type="hidden" name="user_id" id="user_id" value="">
</form>
<script type="text/javascript">
    function deleteRecord(id) {
        $("#operation").val('delete');
        $("#user_id").val(id);
        var conf = confirm("Are you sure want to delete this Banner");
        if (conf) {
            $("#frm_deleteBanner").submit();
        }
    }
</script>


<?php include('footer.php') ?>