<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>

<!-- Page content -->
<div id="page-content">
  <!-- Dashboard Header -->

  <div class="uk-card uk-card-body uk-card-default uk-card-small">
    <h3>Lift Driver Subscription</h3>
    <div class="table-responsive">
      <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
        <thead>
          <tr>
            <th class="text-center">Sl No</th>
            <th class="text-center">Image</th>
            <th class="text-center">Driver Name</th>
            <th class="text-center">Email</th>
            <th class="text-center">Contact No</th>
            <th class="text-center">Subscription Status</th>
            <th class="text-center">Subscription Details</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          foreach ($allvendor as $vendor) {
          ?>
            <tr>
              <td class="text-center"><?= $i++; ?></td>
              <?php if ($vendor->profile_image != '') { ?>
                <td class="text-center"><img src="<?php echo base_url(); ?>/uploads/<?= $vendor->profile_image ?>" alt="avatar" class="img-circle" width="50px"></td>
              <?php } else { ?>
                <td class="text-center"><img src="img/placeholders/avatars/avatar11.jpg" alt="avatar" class="img-circle"></td>
              <?php } ?>
              <td class="text-center"><?= $vendor->full_name; ?></td>
              <td class="text-center"><?= $vendor->email; ?></td>
              <td class="text-center"><?= $vendor->contact_no; ?></td>
              <td class="text-center">Expire</td>
              <td class="text-center">
                <button type="button" onclick="getSubscriptionData(<?= $vendor->id; ?>);" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Details</button>
              </td>
            </tr>
          <?php } ?>

        </tbody>
      </table>
    </div>

  </div>
</div>

<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Member Attendance Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Sl no</th>
              <th>Amount</th>
              <th>Start Date</th>
              <th>Expiry Date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="attendanceData">
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">
  function getSubscriptionData(id) {
    $('#attendanceData').html('');
    $.ajax({
      url: "<?php echo base_url(); ?>/franchises/get-attendance-data",
      method: "POST",
      data: {
        member_id: id
      },
      success: function(response) {
        $('#attendanceData').html(response);
      }
    });
  }
</script>

<?php include('footer.php') ?>