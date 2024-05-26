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

                <form action="<?php echo base_url(); ?>vehicle/update/<?= $state->id; ?>" enctype="multipart/form-data" method="post">
                    <div class="uk-grid-small  uk-grid-divider" uk-grid>
                        <div class="uk-width-expand@m">


                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Select Vehicle Owner</label>
                                        <select name="vendor_id" id="vendor_id" class="form-control" required>
                                            <option value="">-- Select Owner --</option>
                                            <?php foreach ($AllVendor as $vendor) { ?>
                                                <option value="<?= $vendor->id; ?>"><?= $vendor->full_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Select Vehicle Type</label>
                                        <select name="vehicle_type" id="vehicle_type" class="form-control" required>
                                            <option value="">-- Select Vehicle Type --</option>
                                            <?php foreach ($vehicleType as $type) { ?>
                                                <option value="<?= $type->id; ?>"><?= $type->type_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Enter Vehicle Redg. No</label>
                                        <input type="text" name="redg_no" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Enter Vehicle Make</label>
                                        <input type="text" name="vehicle_make" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Enter Vehicle Model</label>
                                        <input type="text" name="model_name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Enter Vehicle Body</label>
                                        <input type="text" name="vehicle_body" class="form-control" required>
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Enter Vehicle Enginee Number</label>
                                        <input type="text" name="engine_no" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Enter Vehicle Chassis Number</label>
                                        <input type="text" name="chassis_no" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Enter Vehicle Manufacture Year</label>
                                        <input type="text" name="manufacture_yr" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Enter Vehicle CC</label>
                                        <input type="text" name="vehicle_cc" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>No. of passanger sit</label>
                                        <input type="number" min='0' name="no_of_sit" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Insurance Date from</label>
                                        <input type="date" name="insurance_date_from" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Insurance Date To</label>
                                        <input type="date" name="insurance_date_to" class="form-control" required>
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
                                        <input type="date" class="form-control" id="fit_expr" name="fit_expr">
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
                                        <input type="date" class="form-control" id="polution_exp_date" name="polution_exp_date">
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
                                        <input type="date" class="form-control" id="permit_expr_date" name="permit_expr_date">
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

    <?php include('footer.php') ?>