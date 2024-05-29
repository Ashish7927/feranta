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

                <form action="<?php echo base_url(); ?>/Admin/Insertvendor" enctype="multipart/form-data" method="post">
                    <div class="uk-grid-small  uk-grid-divider" uk-grid>
                        <div class="uk-width-expand@m">


                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Enter full name" value="<?= set_value('name'); ?>">
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('name'); ?></span><?php } ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?= set_value('email'); ?>">
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('email'); ?></span><?php } ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Contact No</label>
                                        <input type="tel" class="form-control" id="contact" name="contact" placeholder="contact no" value="<?= set_value('contact'); ?>">
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
                                        <select class="form-control" name="state" onchange="CheckstateId(this.value)" id="state_id">
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
                                        <select class="form-control" name="city" id="cityDiv" onchange="CheckcityId(this.value)">
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
                                        <label>Address1</label>
                                        <input type="text" name="address1" class="form-control" value="">

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Address2</label>
                                        <input type="text" name="address2" class="form-control" value="">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>PIN</label>
                                        <select class="form-control" name="pincode" id="pincode">
                                            <option value="">Select Pin</option>
                                            <?php foreach ($pincode as $pin) { ?>
                                                <option value="<?= $pin->pin_id ?>"><?= $pin->pincode ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('pincode'); ?></span><?php } ?>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Details</label>
                                            <div>
                                                <textarea id="editor1" name="details" class="form-control" placeholder="Description">

                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                 <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Adharno</label>
                                        <input type="text" class="form-control" id="adharno" name="adharno" placeholder="Enter Adharno" value="<?= set_value('adharno'); ?>">
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('adharno'); ?></span><?php } ?>
                                    </div>
                                </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Adhar Front Image</label>
                                        <input type="file" name="frontimg" class="form-control">
                                    </div>
                                </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Adhar Back Image</label>
                                        <input type="file" name="backimg" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Upload Image</label>
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
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" value="<?= set_value('username'); ?>">
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('username'); ?></span><?php } ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" value="<?= set_value('password'); ?>">
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
                                        <select class="form-control" name="franchise_id"  id="franchise_id">
                                            <option value="">Select option</option>
                                            <?php foreach($franchises as $franchise){?>
                                            <option value="<?= $franchise->id; ?>"><?= $franchise->franchise_name; ?></option>

                                            <?php } ?>
                                        </select>
                                        <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('is_driver'); ?></span><?php } ?>
                                    </div>
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
                                    <label>License Image</label>
                                        <input type="file" class="form-control driver_input" id="license_img" name="license_img" >
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
        function CheckRole(val)
        {
            $('#is_driver').val('');
            $("#franchises").css("display", "none");
            $('#franchise_id').prop('required',false); 
            if(val == 3){
                $('.driver_input').prop('required',false);
                $(".driver_div").css("display", "none");
                $('.is_driver').css("display", "block");
                $('#is_driver').prop('required',true); 
            }else if(val == 4){
                $('#is_driver').prop('required',false);
                $('.is_driver').css("display", "none");
                $(".driver_div").css("display", "block");
                $('.driver_input').prop('required',true);
            }else if(val == 2){
                $('.driver_input').prop('required',false);
                $(".driver_div").css("display", "none");
                $('#is_driver').prop('required',false);
                $('.is_driver').css("display", "none"); 
                $("#franchises").css("display", "block");
                $('#franchise_id').prop('required',true);
            }else{
                $('.driver_input').prop('required',false);
                $(".driver_div").css("display", "none");
                $('#is_driver').prop('required',false);
                $('.is_driver').css("display", "none"); 
            }
            return false;
        }

        function IsDriver(val)
        {
            if(val == 1){
                $(".driver_div").css("display", "block");
                $('.driver_input').prop('required',true);
            }else{
                $('.driver_input').prop('required',false);
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
    </script>

    <?php include('footer.php') ?>