<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>
<!-- Page content -->
<div id="page-content">
    <div class="uk-width-expand@m">
        <div class="uk-card uk-card-body uk-card-default uk-card-small">

            <div>
                <div class="col-sm-6">
                    <a href="<?php echo base_url(); ?>/vehicle/create"><button type="submit" class="btn btn-primary">Add</button></a>
                </div>

            </div>

            <h3>Vehicle Details</h3>
            <?php if (session('message') !== null) : ?>
                <p><?= session('message'); ?></p>
            <?php endif; ?>
            <div class="table-responsive">
                <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Sl No.</th>
                            <th>Vehicle Model</th>
                            <th>Vehicle Booking Type</th>
                            <th>Vehicle Type</th>
                            <th>Redg. <Noframes></Noframes>
                            </th>
                            <th>Owner</th>
                            <th>Driver</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($Allstate as $state) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td><?= $state->model_name; ?></td>
                                <td><?php if($state->booking_type == 1){
                                    echo 'Cab Booking';
                                }else{
                                    echo 'Lift Booking';
                                }  ?></td>
                                <td><?php if($state->booking_type == 2){
                                    echo $state->lift_vehicle_type == 1 ? 'Car' : 'Bike';
                                }else{
                                    echo $state->type_name;
                                }  ?></td>
                                <td><?= $state->regd_no; ?></td>
                                <td><?= $state->full_name; ?></td>
                                <td><a href="#driver-modal" uk-toggle class="btn btn-success" onclick="GetDriverDetails(<?= $state->id; ?>,'<?= $state->driver_id; ?>');">Details</a></td>
                                <td class="text-center">
                                    <?php if ($state->status == 1) { ?>
                                        <a href="javascript:void(0);" onClick="statusupdate('<?= $state->id; ?>','0');"><button type="button" class="btn btn-danger ">Deactivate</button></a>
                                    <?php } else { ?>
                                        <a href="javascript:void(0);" onClick="statusupdate('<?= $state->id; ?>','1');"> <button type="button" class="btn btn-success"> Active </button></a>
                                    <?php } ?>
                                </td>

                                <td class="text-center">
                                    <div class="btn-group">

                                        <a href="<?php echo base_url(); ?>vehicle/edit/<?= $state->id; ?>" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0);" onClick="deleteRecord('<?= $state->id; ?>');" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
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


<!-- Driver Details Modal Start  -->

<div id="driver-modal" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

        <button class="uk-modal-close-default" type="button" uk-close></button>


        <form action="<?php echo base_url(); ?>vehicle/update-driver" method="post" id="driver_form">
            <input type="hidden" name="vehicleId" id="vehicleId" value="">

            <div class="modal-body uk-text-left">
                <div class="form-group">
                    <label>Driver</label>
                    <select name="driver_id" id="driver_id" class="form-control" required onchange="UpdateDriverDetails(this.value);">
                        <option value="">-- Select Driver --</option>
                        <?php foreach ($AllDriver as $driver) { ?>
                            <option value="<?= $driver->id; ?>"><?= $driver->full_name ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Phone No</label>
                    <input type="text" readonly name="phoneNo" id="phoneNo" class="form-control" value="">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="text" readonly name="emailId" id="emailId" class="form-control" value="">
                </div>

                <div class="form-group">
                    <label>License No</label>
                    <input type="text" readonly name="licenseNo" id="licenseNo" class="form-control" value="">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <input type="text" readonly name="driverStatus" id="driverStatus" class="form-control" value="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update</button>

            </div>
        </form>
    </div>
</div>


</div>
<!-- END Page Content -->
<form name="frm_deleteBanner" id="frm_deleteBanner" action="<?php echo base_url(); ?>/vehicle/delete" method="post">
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
<form name="status_update" id="status_update" action="<?php echo base_url(); ?>/vehicle/status" method="post">
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

    function GetDriverDetails(id, driver_id) {
        // Reset Driver Form 
        $("#driver_form")[0].reset();

        $('#vehicleId').val(id);
        if (driver_id != '') {
            $('#driver_id').val(driver_id);
            UpdateDriverDetails(driver_id);
        }
    }

    function UpdateDriverDetails(val) {
        let vehicleId = $('#vehicleId').val();
        $.ajax({
            url: "<?php echo base_url(); ?>/Admin/getDriverData",
            method: "POST",
            data: {
                driver_id: val,
                vehicleId: vehicleId
            },

            success: function(response) {
                let data = JSON.parse(response);
                $('#licenseNo').val(data.userdata.license_no);
                $('#emailId').val(data.userdata.email);
                $('#phoneNo').val(data.userdata.contact_no);
                if (data.status == 0 || data.status == "0") {
                    $('#driverStatus').val('Requested');
                } else if (data.status == 1 || data.status == "1") {
                    $('#driverStatus').val('Accepted');
                } else {
                    $('#driverStatus').val('--');
                }
            }

        });
        // event.preventDefault();
        // return false; 
    }
</script>

<?php include('footer.php') ?>