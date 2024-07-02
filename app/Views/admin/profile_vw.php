<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>
<?php foreach ($singleuser as $singledata) {
} ?>



<!-- Page content -->
<div id="page-content">
  <!-- Dashboard Header -->
  <!-- For an image header add the class 'content-header-media' and an image as in the following example -->

  <!-- END Dashboard Header -->

  <!-- Mini Top Stats Row -->
  <div class="uk-card uk-card-body uk-card-default uk-card-small">

    <h3>
      Pofile
      <small>Pofile </small>
    </h3>


    <section class="content container-fluid">

      <div class="row">
        <div class="col-xs-12">
          <form action="<?php echo base_url(); ?>/admin/pro" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="exampleInputEmail1"> Name</label>
              <input type="text" class="form-control" name="fullname" id="fullname" value="<?= $singledata->full_name; ?>">
              <?php if (isset($validation)) { ?>
                <span class="text-danger"><?= $error = $validation->getError('fullname'); ?></span>
              <?php } ?>

            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Email </label>
              <input type="email" class="form-control" id="email" name="email" value="<?= $singledata->email; ?>">
              <?php if (isset($validation)) { ?>
                <span class="text-danger"><?= $error = $validation->getError('email'); ?></span>
              <?php } ?>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Contat No </label>
              <input type="tel" class="form-control" id="contact" name="contact" value="<?= $singledata->contact_no; ?>">
              <?php if (isset($validation)) { ?>
                <span class="text-danger"><?= $error = $validation->getError('contact'); ?></span>
              <?php } ?>
            </div>


            <?php if ($singledata->user_type == 2) { ?>

              <div class="form-group">
                <label>Select State</label>
                <select class="form-control" name="state" onchange="CheckstateId(this.value)" id="state_id" required>
                  <option value="">Select State</option>
                  <?php foreach ($allstate as $state) { ?>
                    <option value="<?= $state->state_id ?>" <?php if ($singledata->state_id == $state->state_id) {
                                                              echo 'selected';
                                                            } ?>><?= $state->state_name ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="form-group">
                <label>Select City</label>
                <select class="form-control" name="city" id="cityDiv" onchange="CheckcityId(this.value)">
                  <option value="">Select City</option>
                  <?php foreach ($allcity as $city) { ?>
                    <option value="<?= $city->city_id ?>" <?php if ($singledata->city_id == $city->city_id) {
                                                            echo 'selected';
                                                          } ?>><?= $city->city_name ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="<?= $singledata->address1;  ?>" >
              </div>

              <div class="form-group">
                <label>Pincode</label>
                <input type="text" name="pincode" class="form-control" value="<?= $singledata->pin;  ?>" >
              </div>

            <?php } ?>

            <div class="form-group">
              <label for="exampleInputPassword1">User Name</label>
              <input type="text" class="form-control" id="username" name="username" value="<?= $singledata->user_name; ?>">
              <?php if (isset($validation)) { ?>
                <span class="text-danger"><?= $error = $validation->getError('username'); ?></span>
              <?php } ?>
            </div>

            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="text" class="form-control" name="password" id="password" value="<?= base64_decode(base64_decode($singledata->password)); ?>">
              <?php if (isset($validation)) { ?>
                <span class="text-danger"><?= $error = $validation->getError('password'); ?></span>
              <?php } ?>
            </div>

            <div class="form-group">
              <label for="exampleInputFile">File input</label>
              <input type="file" class="form-control" id="img" name="img">

              <?php if ($singledata->profile_image <> '') { ?>
                <img src="<?php echo base_url(); ?>/uploads/<?= $singledata->profile_image; ?>" width="100" height="100">
              <?php } else { ?>
                <img src="images/default.png">
              <?php } ?>

            </div>



            <button class="btn btn-primary" type="submit">submit</button>
          </form>



        </div>
      </div>

    </section>
  </div>
  <!-- END Mini Top Stats Row -->


</div>
<!-- END Page Content -->

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
</script>

<?php include('footer.php') ?>