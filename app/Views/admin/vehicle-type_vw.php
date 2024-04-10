<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>
<!-- Page content -->
<div id="page-content">



    <div class="uk-grid-small" uk-grid>
        <div class="uk-width-1-3@m">
            <div class="uk-card  uk-card-default uk-card-small">
                <div class="modal-header">
                    <h4 class="modal-title">Add Vehicle Type</h4>
                </div>


                <form action="<?php echo base_url(); ?>/vehicle-type/add" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Enter Vehicle Type</label>
                            <input type="text" name="statename" class="form-control" required>
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

            <h3>Vehicle Type</h3>
            <div class="table-responsive">
                <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Vehicle Type</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                            <th style="display:none"></th>
                            <th style="display:none"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($Allstate as $state) {

                        ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td><?= $state->type_name; ?></td>
                                <td class="text-center">
                                    <?php if ($state->status == 1) { ?>
                                        <a href="javascript:void(0);" onClick="statusupdate('<?= $state->id; ?>','0');"><button type="button" class="btn btn-danger ">Deactivate</button></a>
                                    <?php } else { ?>
                                        <a href="javascript:void(0);" onClick="statusupdate('<?= $state->id; ?>','1');"> <button type="button" class="btn btn-success"> Active </button></a>
                                    <?php } ?>
                                </td>

                                <td class="text-center">
                                    <div class="btn-group">

                                        <a href="#modal-center<?= $state->id; ?>" uk-toggle title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0);" onClick="deleteRecord('<?= $state->id; ?>');" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                    </div>
                                </td>
                                <th style="display:none"></th>
                                <th style="display:none"></th>
                            </tr>
                        <?php } ?>


                    </tbody>
                </table>



                <?php foreach ($Allstate as $state) { ?>

                    <div id="modal-center<?= $state->id; ?>" class="uk-flex-top" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

                            <button class="uk-modal-close-default" type="button" uk-close></button>
                            <?php if (session()->getFlashdata('uid') == $state->id) : ?>
                                <div class="alert alert-warning">
                                    <?= session()->getFlashdata('msg') ?>
                                </div>
                            <?php endif; ?>


                            <form action="<?php echo base_url(); ?>vehicle-type/edit/<?= $state->id; ?>" method="post">
                                <div class="modal-body uk-text-left">
                                    <div class="form-group">
                                        <label>Edit Vehicle Type</label>
                                        <input type="text" name="statename" value="<?= $state->type_name; ?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>

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




</div>
<!-- END Page Content -->
<form name="frm_deleteBanner" id="frm_deleteBanner" action="<?php echo base_url(); ?>/vehicle-type/delete" method="post">
    <input type="hidden" name="id" id="user_id" value="">
</form>

<script type="text/javascript">
    function deleteRecord(id) {
        $("#operation").val('delete');
        $("#user_id").val(id);
        var conf = confirm("Are you sure want to delete this State");
        if (conf) {
            $("#frm_deleteBanner").submit();
        }
    }
</script>
<form name="status_update" id="status_update" action="<?php echo base_url(); ?>/vehicle-type/status" method="post">
    <input type="hidden" name="state_id" id="state_id" value="">
    <input type="hidden" name="state_status" id="state_status" value="">
</form>

<script type="text/javascript">
    function statusupdate(id, status) {
        // alert(id);
        $("#state_id").val(id);
        $("#state_status").val(status);
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