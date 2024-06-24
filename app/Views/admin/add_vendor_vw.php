<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>

<style>
    .highlight-error {
        border-color: red;
    }
</style>
<style>
    .field-icon {
        float: right;
        margin-left: -25px;
        margin-top: -25px;
        position: relative;
        z-index: 2;
    }

    .container {
        padding-top: 50px;
        margin: auto;
    }
</style>

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

                <form action="<?php echo base_url(); ?>/Admin/Insertvendor" enctype="multipart/form-data" method="post">
                    <div class="uk-grid-small  uk-grid-divider" uk-grid>
                        <div class="uk-width-expand@m">


                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Enter full name" value="<?= set_value('name'); ?>" required>
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('name'); ?></span><?php } ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?= set_value('email'); ?>" required>
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('email'); ?></span><?php } ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Contact No</label>
                                        <input type="tel" class="form-control" id="contact" name="contact" placeholder="contact no" value="<?= set_value('contact'); ?>" required>
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('contact'); ?></span><?php } ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Alternate Contact No</label>
                                        <input type="tel" class="form-control" id="altcontat" name="altcontact" placeholder="alternate contact no" value="<?= set_value('altcontact'); ?>">
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('altcontact'); ?></span><?php } ?>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Select State</label>
                                        <select class="form-control" name="state" onchange="CheckstateId(this.value)" id="state_id" required>
                                            <option value="">Select State</option>
                                            <?php foreach ($allstate as $state) { ?>
                                                <option value="<?= $state->state_id ?>"><?= $state->state_name ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('state'); ?></span><?php } ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Select City</label>
                                        <select class="form-control" name="city" id="cityDiv" onchange="CheckcityId(this.value)" required>
                                            <option value="">Select City</option>
                                            <?php foreach ($allcity as $city) { ?>
                                                <option value="<?= $city->city_id ?>"><?= $city->city_name ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('city'); ?></span><?php } ?>
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" name="address1" class="form-control" value="">

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>village</label>
                                        <input type="text" name="address2" class="form-control" value="">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Block</label>
                                        <select class="form-control" name="block" id="block" >
                                            <option value="">Select block</option>
                                            <?php foreach ($allblock as $block) { ?>
                                                <option value="<?= $block->id ?>"><?= $block->block_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>District </label>
                                        <select class="form-control" name="ditrict" id="ditrict" >
                                            <option value="">Select block</option>
                                            <?php foreach ($allditrict as $ditrict) { ?>
                                                <option value="<?= $ditrict->id ?>"><?= $ditrict->district_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Pincode </label>
                                        <input type="text" name="pin" class="form-control" value="">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Father's Name</label>
                                        <input type="text" name="father_name" class="form-control" value="">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Mother's Name</label>
                                        <input type="text" name="mother_name" class="form-control" value="">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nominee Name</label>
                                        <input type="text" name="nominee_name" class="form-control" value="">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Relation with Nominee </label>
                                        <input type="text" name="nominee_rltn" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nominee Address</label>
                                        <input type="text" name="nominee_add" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nominee Date of Birth</label>
                                        <input type="date" name="nominee_dob" class="form-control" value="">
                                    </div>
                                </div>



                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Spouse name</label>
                                        <input type="text" name="spouse_name" class="form-control" value="">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Date of Birth</label>
                                        <input type="date" name="dob" class="form-control" value="">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Blood group</label>
                                        <select class="form-control" name="blood_group" id="blood_group" >
                                            <option value="">Select block</option>
                                            <?php foreach ($allbloodgroup as $bloodgroup) { ?>
                                                <option value="<?= $bloodgroup->id ?>"><?= $bloodgroup->blood_group ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Upload cancel cheque</label>
                                        <input type="file" name="cheque" class="form-control">
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Aadhar Card No</label>
                                        <input type="text" data-type="adhaar-number" maxLength="14" class="form-control" id="adharno" name="adharno" required placeholder="Enter Adharno" value="<?= set_value('adharno'); ?>">
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('adharno'); ?></span><?php } ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Aadhar Card Front</label>
                                        <input type="file" name="frontimg" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Aadhar Card Back</label>
                                        <input type="file" name="backimg" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Upload Profile Image</label>
                                        <input type="file" name="img" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Ac Holder Name</label>
                                        <input type="text" class="form-control" id="ac_name" name="ac_name" placeholder="Enter account holder name" value="<?= set_value('ac_name'); ?>">
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('ac_name'); ?></span><?php } ?>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Bank Name</label>
                                        <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Enter Bank name" value="<?= set_value('bank_name'); ?>">
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('bank_name'); ?></span><?php } ?>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Branch Name</label>
                                        <input type="text" class="form-control" id="branch_name" name="branch_name" placeholder="Enter Branch name" value="<?= set_value('branch_name'); ?>">
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('branch_name'); ?></span><?php } ?>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Account Number</label>
                                        <input type="text" class="form-control" id="acc_no" name="acc_no" placeholder="Enter Account Number" value="<?= set_value('acc_no'); ?>">
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('acc_no'); ?></span><?php } ?>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>IFSC Code</label>
                                        <input type="text" class="form-control" id="ifsc" name="ifsc" placeholder="Enter IFSC" value="<?= set_value('ifsc'); ?>">
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('ifsc'); ?></span><?php } ?>
                                    </div>
                                </div>




                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" class="form-control" id="username" name="username" required placeholder="Enter username" value="<?= set_value('username'); ?>">
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('username'); ?></span><?php } ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required placeholder="Enter Password" value="<?= set_value('password'); ?>">
                                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('password'); ?></span><?php } ?>
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Select Role</label>
                                        <select class="form-control" name="role" onchange="CheckRole(this.value)" id="role_id">
                                            <option value="">Select Role</option>
                                            <option value="3">Owner</option>
                                            <option value="4">Driver</option>
                                            <option value="2">Franchise Member</option>
                                        </select>
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('role'); ?></span><?php } ?>
                                    </div>
                                </div>

                                <div class="col-sm-6" id="franchises" style="display: none;">
                                    <div class="form-group ">
                                        <label>Select Franchise</label>
                                        <select class="form-control" name="franchise_id" id="franchise_id" <?php if ($franchise_id != '') {
                                                                                                                echo 'disabled';
                                                                                                            } ?>>
                                            <option value="">Select option</option>
                                            <?php foreach ($franchises as $franchise) { ?>
                                                <option value="<?= $franchise->id; ?>" <?php if ($franchise_id != '' && $franchise_id == $franchise->id) {
                                                                                            echo 'selected';
                                                                                        } ?>><?= $franchise->franchise_name; ?></option>

                                            <?php } ?>
                                        </select>
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('is_driver'); ?></span><?php } ?>
                                    </div>
                                    <?php if ($franchise_id != '') {
                                        echo "<input type='hidden' name='franchise_id' value='" . $franchise_id . "'>";
                                    } ?>
                                </div>

                                <div class="col-sm-6 is_driver" style="display: none;">
                                    <div class="form-group ">
                                        <label>Are you a Driver?</label>
                                        <select class="form-control" name="is_driver" onchange="IsDriver(this.value)" id="is_driver">
                                            <option value="">Select option</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('is_driver'); ?></span><?php } ?>
                                    </div>
                                </div>

                                <div class="col-sm-6 driver_div" style="display: none;">
                                    <div class="form-group">
                                        <label>License No.</label>
                                        <input type="text" class="form-control driver_input" id="license_no" name="license_no" placeholder="Enter your License N0." value="<?= set_value('license_no'); ?>">
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('license_no'); ?></span><?php } ?>
                                    </div>
                                </div>

                                <div class="col-sm-6 driver_div" style="display: none;">
                                    <div class="form-group">
                                        <label>License Type</label>

                                        <select name="license_type" id="license_type" class="form-control driver_input">
                                            <option value="">-Please select license type-</option>
                                            <option value="mcwg">MCWG (Motorcycles with and without gear) </option>
                                            <option value="lmv-nt">LMV-NT (Non-transport Light Motor Vehicles like cars, jeeps, etc.)</option>
                                        </select>
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('license_type'); ?></span><?php } ?>
                                    </div>
                                </div>

                                <div class="col-sm-6 driver_div" style="display: none;">
                                    <div class="form-group">
                                        <label>License Expiry Date</label>
                                        <input type="text" class="form-control driver_input" id="license_expire_date" name="license_expire_date" placeholder="Enter your License Expire date." value="<?= set_value('license_expire_date'); ?>">
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('license_expire_date'); ?></span><?php } ?>
                                    </div>
                                </div>


                                <div class="col-sm-6 driver_div" style="display: none;">
                                    <div class="form-group">
                                        <label>License Image</label>
                                        <input type="file" class="form-control driver_input" id="license_img" name="license_img">
                                    </div>
                                </div>

                                <div class="col-sm-6 driver_div" style="display: none;">
                                    <div class="form-group">
                                        <label>Year of Experience</label>
                                        <input type="number" class="form-control driver_input" id="exp_year" name="exp_year" placeholder="Enter Year of experience" value="<?= set_value('exp_year'); ?>">
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('exp_year'); ?></span><?php } ?>
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
        function CheckstateId(arg) {
            //alert($('#state_id').val()); 

            var state_id = $('#state_id').val();
            $.ajax({
                url: "<?php echo base_url(); ?>/Admin/GetcityAjax",
                method: "POST",
                data: {
                    state_id: state_id
                },

                success: function(data) {
                    $('#cityDiv').html(data);
                    //alert(data); //Unterminated String literal fixed
                }

            });
            event.preventDefault();
            return false; //stop the actual form post !important!

        }

        function CheckRole(val) {
            $('#is_driver').val('');
            $("#franchises").css("display", "none");
            $('#franchise_id').prop('required', false);
            if (val == 3) {
                $('.driver_input').prop('required', false);
                $(".driver_div").css("display", "none");
                $('.is_driver').css("display", "block");
                $('#is_driver').prop('required', true);
            } else if (val == 4) {
                $('#is_driver').prop('required', false);
                $('.is_driver').css("display", "none");
                $(".driver_div").css("display", "block");
                $('.driver_input').prop('required', true);
            } else if (val == 2) {
                $('.driver_input').prop('required', false);
                $(".driver_div").css("display", "none");
                $('#is_driver').prop('required', false);
                $('.is_driver').css("display", "none");
                $("#franchises").css("display", "block");
                $('#franchise_id').prop('required', true);
            } else {
                $('.driver_input').prop('required', false);
                $(".driver_div").css("display", "none");
                $('#is_driver').prop('required', false);
                $('.is_driver').css("display", "none");
            }
            return false;
        }

        function IsDriver(val) {
            if (val == 1) {
                $(".driver_div").css("display", "block");
                $('.driver_input').prop('required', true);
            } else {
                $('.driver_input').prop('required', false);
                $(".driver_div").css("display", "none");
            }
            return false;
        }
    </script>
    <script>
        function CheckcityId(arg) {
            //alert($('#cityDiv').val()); 

            var cityDiv = $('#cityDiv').val();
            $.ajax({
                url: "<?php echo base_url(); ?>/Admin/GetpinAjax",
                method: "POST",
                data: {
                    cityDiv: cityDiv
                },

                success: function(data) {
                    $('#pincode').html(data);
                    //alert(data); //Unterminated String literal fixed
                }

            });
            event.preventDefault();
            return false; //stop the actual form post !important!

        }


        $('[data-type="adhaar-number"]').keyup(function() {
            var value = $(this).val();
            value = value.replace(/\D/g, "").split(/(?:([\d]{4}))/g).filter(s => s.length > 0).join("-");
            $(this).val(value);
        });

        $('[data-type="adhaar-number"]').on("change, blur", function() {
            var value = $(this).val();
            var maxLength = $(this).attr("maxLength");
            if (value.length != maxLength) {
                $(this).addClass("highlight-error");
            } else {
                $(this).removeClass("highlight-error");
            }
        });


        $(".toggle-password").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>

    <?php include('footer.php') ?>