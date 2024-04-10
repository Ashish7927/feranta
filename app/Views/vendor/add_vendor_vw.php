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
                                        <select class="form-control" name="state" onchange="CheckCityId(this.value)" id="state_id">
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
                                        <select class="form-control" name="city" id="cityDiv">
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
        function CheckCityId(arg) {
            //alert($('#city_id').val()); 

            var city_id = $('#city_id').val();
            $.ajax({
                url: "<?php echo base_url(); ?>/Admin/GetAreaAjax",
                method: "POST",
                data: {
                    city_id: city_id
                },

                success: function(data) {
                    $('#areaDiv').html(data);
                    //alert(data); //Unterminated String literal fixed
                }

            });
            event.preventDefault();
            return false; //stop the actual form post !important!

        }
    </script>

    <?php include('footer.php') ?>