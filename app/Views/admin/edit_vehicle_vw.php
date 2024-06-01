<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<div id="loader" class="uk-overlay-primary uk-position-cover" style="display:none; z-index:1000000000;">
    <div class="uk-position-center">
        <span uk-spinner="ratio: 2"></span>
    </div>
</div>

<!-- Page content -->
<div id="page-content">

    <div class="row">
        <div class="col-xs-12">
            <div class="uk-card uk-card-body uk-card-default uk-card-small">
                <h4>Basic Info</h4>
                <hr>
                <form action="<?php echo base_url(); ?>vehicle/update/<?= $vehicle->id; ?>" enctype="multipart/form-data" method="post">
                    <div class="uk-grid-small  uk-grid-divider" uk-grid>
                        <div class="uk-width-expand@m">


                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Select Vehicle Owner</label>
                                        <select name="vendor_id" id="vendor_id" class="form-control" required>
                                            <option value="">-- Select Owner --</option>
                                            <?php foreach ($AllVendor as $vendor) { ?>
                                                <option value="<?= $vendor->id; ?>" <?php if ($vendor->id == $vehicle->vendor_id) {
                                                                                        echo 'selected';
                                                                                    } ?>><?= $vendor->full_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Select Booking Type</label>
                                        <select name="booking_type" id="booking_type" class="form-control" onclick="checkBookingType(this.value);" required>
                                            <option value="">-- Select Booking Type --</option>
                                            <option value="1" <?php if (1 == $vehicle->booking_type) {
                                                                    echo 'selected';
                                                                } ?>>Cab Booking</option>
                                            <option value="2" <?php if (2 == $vehicle->booking_type) {
                                                                    echo 'selected';
                                                                } ?>>Lift Booking</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 vehicle_type">
                                    <div class="form-group">
                                        <label>Select Vehicle Type</label>
                                        <select name="vehicle_type" id="vehicle_type" class="form-control">
                                            <option value="">-- Select Vehicle Type --</option>
                                            <?php foreach ($vehicleType as $type) { ?>
                                                <option value="<?= $type->id; ?>" <?php if ($type->id == $vehicle->type_id) {
                                                                                        echo 'selected';
                                                                                    } ?>><?= $type->type_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 lift_vehicle_type" style="display:none;">
                                    <div class="form-group">
                                        <label>Select Vehicle Type</label>
                                        <select name="lift_vehicle_type" id="lift_vehicle_type" class="form-control">
                                            <option value="">-- Select Vehicle Type --</option>
                                            <option value="1" <?php if (1 == $vehicle->lift_vehicle_type) {
                                                                    echo 'selected';
                                                                } ?>>Car</option>
                                            <option value="2" <?php if (2 == $vehicle->lift_vehicle_type) {
                                                                    echo 'selected';
                                                                } ?>>Bike</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Enter Vehicle Redg. No</label>
                                        <input type="text" name="redg_no" class="form-control" required value="<?= $vehicle->regd_no ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Enter Vehicle Make</label>
                                        <input type="text" name="vehicle_make" class="form-control" required value="<?= $vehicle->vehicle_make ?>">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Enter Vehicle Model</label>
                                        <input type="text" name="model_name" class="form-control" required value="<?= $vehicle->model_name ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Enter Vehicle Body</label>
                                        <input type="text" name="vehicle_body" class="form-control" required value="<?= $vehicle->vehicle_body ?>">
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Enter Vehicle Enginee Number</label>
                                        <input type="text" name="engine_no" class="form-control" required value="<?= $vehicle->engine_no ?>">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Enter Vehicle Chassis Number</label>
                                        <input type="text" name="chassis_no" class="form-control" required value="<?= $vehicle->chassis_no ?>">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Enter Vehicle Manufacture Year</label>
                                        <input type="text" name="manufacture_yr" class="form-control" required value="<?= $vehicle->manufacture_yr ?>">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Enter Vehicle CC</label>
                                        <input type="text" name="vehicle_cc" class="form-control" required value="<?= $vehicle->vehicle_cc ?>">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>No. of passanger sit</label>
                                        <input type="number" min='0' name="no_of_sit" class="form-control" required value="<?= $vehicle->no_of_sit ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Insurance Date from</label>
                                        <input type="date" name="insurance_date_from" class="form-control" required value="<?= $vehicle->insurance_date_from ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Insurance Date To</label>
                                        <input type="date" name="insurance_date_to" class="form-control" required value="<?= $vehicle->insurance_date_to ?>">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Upload insurance</label>
                                        <input type="file" name="insurance_img" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Fitness expr. Date</label>
                                        <input type="date" class="form-control" id="fit_expr" name="fit_expr" value="<?= $vehicle->fit_expr ?>">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Fitness Document</label>
                                        <input type="file" class="form-control " id="fit_doc" name="fit_doc">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Pollution expiary date</label>
                                        <input type="date" class="form-control" id="polution_exp_date" name="polution_exp_date" value="<?= $vehicle->polution_exp_date ?>">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Pollution Document</label>
                                        <input type="file" class="form-control " id="pollurion_doc" name="pollurion_doc">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Permit Expiry Document </label>
                                        <input type="date" class="form-control" id="permit_expr_date" name="permit_expr_date" value="<?= $vehicle->permit_expr_date ?>">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Permit pdf or images </label>
                                        <input type="file" class="form-control " id="permit_doc" name="permit_doc">
                                    </div>
                                </div>


                            </div>


                        </div>

                        <div class="uk-width-1-1">
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function checkBookingType(val) {
            if (val == 2 || val == "2") {
                $('#vehicle_type').prop('required', false);
                $(".vehicle_type").css("display", "none");
                $('#lift_vehicle_type').prop('required', true);
                $(".lift_vehicle_type").css("display", "block");
            } else {
                $('#lift_vehicle_type').prop('required', false);
                $(".lift_vehicle_type").css("display", "none");
                $('#vehicle_type').prop('required', true);
                $(".vehicle_type").css("display", "block");
            }
        }

        $(document).ready(function() {
            checkBookingType(<?= $vehicle->booking_type; ?>);
        });

        
    </script>

    <?php include('footer.php') ?>