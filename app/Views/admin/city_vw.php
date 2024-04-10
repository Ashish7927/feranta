<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<!-- Page content -->
<div id="page-content">
    <!-- Dashboard Header -->
    <!-- For an image header add the class 'content-header-media' and an image as in the following example -->

    <div class="uk-grid-small" uk-grid>
        <div class="uk-width-1-3@m">
            <div class="uk-card  uk-card-default uk-card-small">
                <div class="modal-header">
                    <h4 class="modal-title">Add City</h4>
                </div>

                <div class="modal-body">
                    <form action="<?php echo base_url(); ?>/Admin/addcity" method="post">


                        <div>
                            <label>Select state</label>
                            <select class="form-control" name="state_id" required>
                                <option value=''>- Select -</option>
                                <?php foreach ($Allstate as $state) { ?>
                                    <option value="<?= $state->state_id; ?>"><?= $state->state_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Enter City</label>
                            <input type="text" name="cityname" value="<?php echo set_value('cityname'); ?>" class="form-control" />
                            <?php if (isset($validation)) { ?>
                                <span class="text-danger"><?= $error = $validation->getError('cityname'); ?></span>
                            <?php } ?>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>

                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="uk-width-expand@m">
            <div class="uk-card uk-card-body uk-card-default uk-card-small">

                <h3>City</h3>
                <div class="table-responsive">
                    <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">SL.No</th>
                                <th class="text-center">City Name</th>
                                <th class="text-center">State Name</th>
                                <th class="text-center">Status</th>


                                <th class="text-center">Actions</th>
                                <th style="display:none"></th>
                                <th style="display:none"></th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $i = 1;
                            foreach ($city as $cityy) { ?>
                                <tr>
                                    <td class="text-center"><?= $i++ ?></td>
                                    <td><?= $cityy->city_name; ?></td>
                                    <td>
                                        <?php foreach ($Allstate as $state) {
                                            if ($state->state_id == $cityy->state_id) {
                                        ?>
                                                <?= $state->state_name; ?>
                                        <?php }
                                        } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($cityy->status == 0) { ?>
                                            <a href="javascript:void(0);" onClick="statusupdate('<?= $cityy->city_id; ?>','1');"><button type="button" class="btn btn-danger ">Deactivate</button></a>
                                        <?php } else { ?>
                                            <a href="javascript:void(0);" onClick="statusupdate('<?= $cityy->city_id; ?>','0');"> <button type="button" class="btn btn-success"> Active </button></a>
                                        <?php } ?>
                                    </td>


                                    <td class="text-center">
                                        <div class="btn-group">

                                            <a href="#modal-center<?= $cityy->city_id; ?>" uk-toggle title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>

                                            <div id="modal-center<?= $cityy->city_id; ?>" class="uk-flex-top" uk-modal>
                                                <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

                                                    <button class="uk-modal-close-default" type="button" uk-close></button>
                                                    <?php if (session()->getFlashdata('uid') == $cityy->city_id) : ?>
                                                        <div class="alert alert-warning">
                                                            <?= session()->getFlashdata('msg') ?>
                                                        </div>
                                                    <?php endif; ?>


                                                    <form action="<?php echo base_url(); ?>/admin/editcity" method="post">
                                                        <div class="modal-body uk-text-left">
                                                            <input type="hidden" value="<?= $cityy->city_id; ?>" name="city_id">

                                                            <div class="form-group">
                                                                <label> Select State</label>
                                                                <select class="form-control" name="state_id">
                                                                    <option>- Select -</option>
                                                                    <?php foreach ($Allstate as $state) { ?>
                                                                        <option <?php if ($state->state_id == $cityy->state_id) {
                                                                                    echo "selected";
                                                                                } ?> value="<?= $state->state_id; ?>"><?= $state->state_name; ?></option>
                                                                    <?php } ?>
                                                                </select>

                                                            </div>
                                                            <div class="form-group">
                                                                <label>Enter City</label>
                                                                <input type="text" name="cityname" value="<?= $cityy->city_name; ?>" class="form-control" />
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Submit</button>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>




                                            <a href="javascript:void(0);" onClick="deleteRecord('<?= $cityy->city_id; ?>');" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                        </div>
                                    </td>
                                    <th style="display:none"></th>
                                    <th style="display:none"></th>
                                </tr>


                            <?php } ?>
                        </tbody>
                    </table>








                </div>
            </div>
        </div>
    </div>
</div>




</div>
<!-- END Page Content -->
<form name="frm_deleteBanner" id="frm_deleteBanner" action="<?php echo base_url(); ?>/Admin/deletecity" method="post">
    <input type="hidden" name="user_id" id="user_id" value="">
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
<form name="status_update" id="status_update" action="<?php echo base_url(); ?>/Admin/statuscity" method="post">
    <input type="hidden" name="city_id" id="city_id" value="">
    <input type="hidden" name="city_status" id="city_status" value="">
</form>

<script type="text/javascript">
    function statusupdate(id, status) {
        // alert(id);
        $("#city_id").val(id);
        $("#city_status").val(status);
        var conf = confirm("Are you sure want to change the status");
        if (conf) {
            $("#status_update").submit();
        }
    }
</script>
<script>
    UIkit.modal('#modal-center<?= session()->getFlashdata('uid') ?>').show();
</script>



<?php include('footer.php') ?>