<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>
<!-- Page content -->
<div id="page-content">

    <div class="uk-grid-small" uk-grid>
        <div class="uk-width-1-3@m">
            <div class="uk-card  uk-card-default uk-card-small">
                <div class="modal-header">
                    <h4 class="modal-title">Add new Service Rate</h4>
                </div>


                <form action="<?php echo base_url(); ?>/service-rate/add" method="post">
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Select State</label>
                            <select name="state_id" id="state_id" class="form-control" required>
                                <option value="">-- Select State --</option>
                                <?php foreach ($Allstate as $state) { ?>
                                    <option value="<?= $state->state_id; ?>"><?= $state->state_name ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Select Vehicle Type</label>
                            <select name="type_id" id="type_id" class="form-control" required>
                                <option value="">-- Select Vehicle Type --</option>
                                <?php foreach ($vehicleTypes as $types) { ?>
                                    <option value="<?= $types->id; ?>"><?= $types->type_name ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Max number for share booking</label>
                            <input type="number" min='00' value="" name="max_no_share" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Full Fare (per KM)</label>
                            <input type="number" min='00.00' value="" name="full_fare" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Fare Per share (per KM)</label>
                            <input type="number" min='00.00' value="" name="fare_per_share" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Remark</label>
                            <textarea name="remark" id="remark" rows="4" class="form-control"></textarea>
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

            <h3>Service Rate Details</h3>
            <div class="table-responsive">
                <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Sl No.</th>
                            <th>State</th>
                            <th>Vehicle Type</th>
                            <th>Full fare (per KM)</th>
                            <th>Share fare (per KM)</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($AllServiceRate as $serviceRate) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td><?= $serviceRate->state_name; ?></td>
                                <td><?= $serviceRate->type_name; ?></td>
                                <td><?= $serviceRate->full_fare; ?></td>
                                <td><?= $serviceRate->fare_per_share; ?></td>

                                <td class="text-center">
                                    <?php if ($serviceRate->status == 1) { ?>
                                        <a href="javascript:void(0);" onClick="statusupdate('<?= $serviceRate->id; ?>','0');"><button type="button" class="btn btn-danger ">Deactivate</button></a>
                                    <?php } else { ?>
                                        <a href="javascript:void(0);" onClick="statusupdate('<?= $serviceRate->id; ?>','1');"> <button type="button" class="btn btn-success"> Active </button></a>
                                    <?php } ?>
                                </td>

                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="#modal-center<?= $serviceRate->id; ?>" uk-toggle title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0);" onClick="deleteRecord('<?= $serviceRate->id; ?>');" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>


                    </tbody>
                </table>


                <?php foreach ($AllServiceRate as $serviceRate) { ?>

                    <div id="modal-center<?= $serviceRate->id; ?>" class="uk-flex-top" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

                            <button class="uk-modal-close-default" type="button" uk-close></button>
                            <?php if (session()->getFlashdata('uid') == $serviceRate->id) : ?>
                                <div class="alert alert-warning">
                                    <?= session()->getFlashdata('msg') ?>
                                </div>
                            <?php endif; ?>


                            <form action="<?php echo base_url(); ?>service-rate/edit/<?= $serviceRate->id; ?>" method="post">
                                <div class="modal-body uk-text-left">
                                    <div class="form-group">
                                        <label>Select State</label>
                                        <select name="state_id" id="state_id" class="form-control" required>
                                            <option value="">-- Select State --</option>
                                            <?php foreach ($Allstate as $state) { ?>
                                                <option value="<?= $state->state_id; ?>" <?php if($serviceRate->state_id == $state->state_id){ echo 'selected';}?> ><?= $state->state_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Select Vehicle Type</label>
                                        <select name="type_id" id="type_id" class="form-control" required>
                                            <option value="">-- Select Vehicle Type --</option>
                                            <?php foreach ($vehicleTypes as $types) { ?>
                                                <option value="<?= $types->id; ?>" <?php if($serviceRate->type_id == $types->id){ echo 'selected';}?> ><?= $types->type_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Max number for share booking</label>
                                        <input type="number" min='00' value="<?= $serviceRate->max_no_share ?>" name="max_no_share" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Full Fare (per KM)</label>
                                        <input type="number" min='00.00' value="<?= $serviceRate->full_fare ?>" name="full_fare" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Fare Per share (per KM)</label>
                                        <input type="number" min='00.00' value="<?= $serviceRate->fare_per_share ?>" name="fare_per_share" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Remark</label>
                                        <textarea name="remark" id="remark" rows="4" class="form-control"><?= $serviceRate->remark ?></textarea>
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
<form name="frm_deleteBanner" id="frm_deleteBanner" action="<?php echo base_url(); ?>/service-rate/delete" method="post">
    <input type="hidden" name="id" id="user_id" value="">
</form>

<script type="text/javascript">
    function deleteRecord(id) {
        $("#operation").val('delete');
        $("#user_id").val(id);
        var conf = confirm("Are you sure want to delete this record");
        if (conf) {
            $("#frm_deleteBanner").submit();
        }
    }
</script>
<form name="status_update" id="status_update" action="<?php echo base_url(); ?>/service-rate/status" method="post">
    <input type="hidden" name="id" id="id" value="">
    <input type="hidden" name="state_status" id="state_status" value="">
</form>

<script type="text/javascript">
    function statusupdate(id, status) {
        $("#id").val(id);
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