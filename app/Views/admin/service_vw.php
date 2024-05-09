<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>
<!-- Page content -->
<div id="page-content">

    <div class="uk-grid-small" uk-grid>
        <div class="uk-width-1-3@m">
            <div class="uk-card  uk-card-default uk-card-small">
                <div class="modal-header">
                    <h4 class="modal-title">Add new Service</h4>
                </div>


                <form action="<?php echo base_url(); ?>/service/add" method="post">
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Select Vehicle Owner</label>
                            <select name="vendor_id" id="vendor_id" class="form-control" required onchange="GetVehicle(this.value,'vehicle');">
                                <option value="">-- Select Owner --</option>
                                <?php foreach ($AllVendor as $vendor) { ?>
                                    <option value="<?= $vendor->id; ?>"><?= $vendor->full_name ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Select Vehicle</label>
                            <select name="vehicle" id="vehicle" class="form-control" required onchange="CheckVehicle(this.value,'boarding_date','vehicle');">
                                <option value="">-- Select Vehicle --</option>
                                <?php foreach ($vehicles as $vehicle) { ?>
                                    <option value="<?= $vehicle->id; ?>"><?= $vehicle->model_name ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Choose Boarding Datetime</label>
                            <input type="datetime-local" name="boarding_date" id="boarding_date" onchange="SetMinArrivalTime(this.value,'arrival_datetime','vehicle');" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Choose Expected Arrival Time</label>
                            <input type="datetime-local" name="arrival_datetime" id="arrival_datetime" class="form-control" required>
                        </div>



                        <div class="form-group">
                            <label>From City</label>
                            <select name="from_city" id="from_city" class="form-control" required>
                                <option value="">-- Select City --</option>
                                <?php foreach ($cities as $city) { ?>
                                    <option value="<?= $city->city_id; ?>"><?= $city->city_name ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>To City</label>
                            <select name="to_city" id="to_city" class="form-control" required>
                                <option value="">-- Select City --</option>
                                <?php foreach ($cities as $city) { ?>
                                    <option value="<?= $city->city_id; ?>"><?= $city->city_name ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group" style="display: none;">
                            <label>Full Fare</label>
                            <input type="number" min='00.00' value="0" name="full_fare" class="form-control" required>
                        </div>

                        <div class="form-group" style="display: none;">
                            <label>Fare Per Sit</label>
                            <input type="number" min='00.00' value="0" name="fare_per_sit" class="form-control" required>
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

            <h3>Service Details</h3>
            <div class="table-responsive">
                <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Sl No.</th>
                            <th>Vehicle</th>
                            <th>From City</th>
                            <th>To City</th>
                            <th>Boearding Datetime</th>
                            <th>Arrival Datetime</th>
                            <!-- <th>Full Fare </th>
                            <th>Fare per sit</th> -->
                            <th>Owner </th>
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
                                <td><?= $state->from_city_name; ?></td>
                                <td><?= $state->to_city_name; ?></td>
                                <td><?= $state->boarding_date; ?></td>
                                <td><?= $state->arrival_datetime; ?></td>
                                <!-- <td><?= $state->full_fare; ?></td>
                                <td><?= $state->fare_per_sit; ?></td> -->
                                <td><?= $state->full_name; ?></td>
                                <td class="text-center">
                                    <?php if ($state->status == 1) { ?>
                                        <a href="javascript:void(0);" onClick="statusupdate('<?= $state->id; ?>','0');"><button type="button" class="btn btn-danger ">Deactivate</button></a>
                                    <?php } else { ?>
                                        <a href="javascript:void(0);" onClick="statusupdate('<?= $state->id; ?>','1');"> <button type="button" class="btn btn-success"> Active </button></a>
                                    <?php } ?>
                                </td>

                                <td class="text-center">
                                    <div class="btn-group">
                                        <!-- onclick="GetVehicle(<?= $state->vendor_id ?>,'vehicle<?= $state->id ?>');"  -->
                                        <a href="#modal-center<?= $state->id; ?>" uk-toggle title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0);" onClick="deleteRecord('<?= $state->id; ?>');" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                    </div>
                                </td>
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


                            <form action="<?php echo base_url(); ?>service/edit/<?= $state->id; ?>" method="post">
                                <div class="modal-body uk-text-left">
                                <input type="hidden" name="current_vehicle_id" id="current_vehicle_id" value="<?= $state->vehicle_id ?>">
                                    <div class="form-group">
                                        <label>Select Vehicle Owner</label>
                                        <select name="vendor_id" id="vendor_id" class="form-control" required onchange="GetVehicle(this.value,'vehicle<?= $state->id ?>');">
                                            <option value="">-- Select Owner --</option>
                                            <?php foreach ($AllVendor as $vendor) { ?>
                                                <option value="<?= $vendor->id; ?>" <?php if ($state->vendor_id == $vendor->id) {
                                                                                        echo 'selected';
                                                                                    } ?>><?= $vendor->full_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Select Vehicle</label>
                                        <select name="vehicle" id="vehicle<?= $state->id ?>" class="form-control" required onchange="CheckVehicle(this.value,'arrival_datetime<?= $state->id ?>','vehicle<?= $state->id ?>');">
                                            <option value="">-- Select Vehicle --</option>
                                            <?php foreach ($vehicles as $vehicle) { ?>
                                                <option value="<?= $vehicle->id; ?>" <?php if ($state->vehicle_id == $vehicle->id) {
                                                                                            echo 'selected';
                                                                                        } ?>><?= $vehicle->model_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Choose Boarding Datetime</label>
                                        <input type="datetime-local" name="boarding_date" class="form-control" onchange="SetMinArrivalTime(this.value,'arrival_datetime<?= $state->id ?>','vehicle<?= $state->id ?>');" required value="<?= $state->boarding_date; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Choose Expected Arrival Time</label>
                                        <input type="datetime-local" name="arrival_datetime" id="arrival_datetime<?= $state->id ?>" class="form-control" required value="<?= $state->arrival_datetime; ?>">
                                    </div>



                                    <div class="form-group">
                                        <label>From City</label>
                                        <select name="from_city" id="from_city" class="form-control" required>
                                            <option value="">-- Select City --</option>
                                            <?php foreach ($cities as $city) { ?>
                                                <option value="<?= $city->city_id; ?>" <?php if ($state->from_city == $city->city_id) {
                                                                                            echo 'selected';
                                                                                        } ?>><?= $city->city_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>To City</label>
                                        <select name="to_city" id="to_city" class="form-control" required>
                                            <option value="">-- Select City --</option>
                                            <?php foreach ($cities as $city) { ?>
                                                <option value="<?= $city->city_id; ?>" <?php if ($state->to_city == $city->city_id) {
                                                                                            echo 'selected';
                                                                                        } ?>><?= $city->city_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group" style="display: none;">
                                        <label>Full Fare</label>
                                        <input type="number" min='00.00' name="full_fare" class="form-control" required value="<?= $state->full_fare; ?>">
                                    </div>

                                    <div class="form-group" style="display: none;">
                                        <label>Fare Per Sit</label>
                                        <input type="number" min='00.00' name="fare_per_sit" class="form-control" required value="<?= $state->fare_per_sit; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Remark</label>
                                        <textarea name="remark" id="remark" rows="4" class="form-control"><?= $state->remark; ?></textarea>
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
<form name="frm_deleteBanner" id="frm_deleteBanner" action="<?php echo base_url(); ?>/service/delete" method="post">
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
<form name="status_update" id="status_update" action="<?php echo base_url(); ?>/service/status" method="post">
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

<script>
    function SetMinArrivalTime(val, arrival_id, vehicle_id) {
        $('#' + vehicle_id).val('');
        $('#' + arrival_id).val('');
        $('#' + arrival_id).attr('min', val);
    }

    function CheckVehicle(val, time_id, vehicle_id) {
        let crntVhcl = $('#current_vehicle_id').val();
        if (val != '' && val != crntVhcl) {
            console.log(val, time_id, vehicle_id);
            let boarding_time = $('#' + time_id).val();
            // let boarding_time = $('#'+time_id).val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>/service/check-vehicle",
                data: {
                    boarding_time: boarding_time,
                    vehicle_id: val
                },
                success: function(data) {
                    let result = data.trim();
                    if (result == '1' || result == 1) {
                        alert('Vehicle is busy! please select another one.');
                        $('#' + vehicle_id).val('');
                    } else {
                        return false;
                    }
                }
            });

        } else {
            return false;
        }
    }

    function GetVehicle(vendor_id, vehicle_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>/service/get-vehicle-list",
            data: {
                vendor_id: vendor_id
            },
            success: function(data) {
                let result = data.trim();
                $('#' + vehicle_id).html(result);
            }
        });
    }
</script>

<?php include('footer.php') ?>