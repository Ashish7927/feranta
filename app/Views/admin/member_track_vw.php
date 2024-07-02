<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>

<!-- Page content -->
<div id="page-content">
  <!-- Dashboard Header -->
  <!-- For an image header add the class 'content-header-media' and an image as in the following example -->

  <div class="uk-card uk-card-body uk-card-default uk-card-small">
    <div>
      <div class="col-sm-6">
        <a href="<?php echo base_url(); ?>/Admin/Addvendor"><button type="submit" class="btn btn-primary">Add</button></a>
      </div>

    </div>
    <h3>Franchise Member</h3>
    <form action="<?php echo base_url(); ?>franchises/export-member-activity" method="GET">
      <div class="row">

        <div class="col-sm-3">
          <div class="form-group">
            <label> Select Franchise</label>
            <select name="franchise_id" id="franchise_id" class="form-control" onchange="getMembers(this.value);">
              <option value="">Select Franchise</option>
              <?php foreach ($franchises as $franchise) { ?>
                <option value="<?= $franchise->id ?>" <?php if (isset($_REQUEST['franchise_id']) && $_REQUEST['franchise_id'] == $franchise->id) {
                                                        echo 'selected';
                                                      } ?>><?= $franchise->franchise_name ?></option>
              <?php } ?>

            </select>
          </div>
        </div>

        <div class="col-sm-3">
          <div class="form-group">
            <label> Select Role</label>
            <select name="member_id" id="member_id" class="form-control">
              <option value="">Select Member</option>
              <option value="all" <?php if (isset($_REQUEST['member_id']) && $_REQUEST['member_id'] == 'all') {
                                  echo 'selected';
                                } ?>>All</option>
             
            </select>
          </div>
        </div>


        <div class="col-sm-3">
          <div class="form-group">
            <label>From Date</label>
            <input type="date" class="form-control" name="from_date" value="<?= isset($_REQUEST['from_date']) ? $_REQUEST['from_date'] : ''; ?>">
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <label>To Date</label>
            <input type="date" class="form-control" name="to_date" value="<?= isset($_REQUEST['to_date']) ? $_REQUEST['to_date'] : ''; ?>">
          </div>
        </div>
        <div class="col-sm-4">
          <button type="submit" class="btn btn-primary">Export</button>
          <!-- <a href="<?php echo base_url(); ?>admin/Vendor" class="btn btn-warning">Reset</a> -->
        </div>
      </div>
    </form>
    <p></p>
    <div class="table-responsive">
      <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
        <thead>
          <tr>
            <th class="text-center">Sl No</th>
            <th class="text-center">Image</th>
            <th class="text-center">User Name</th>
            <th class="text-center">Franchise Name</th>
            <th class="text-center">Email</th>
            <th class="text-center">Contact No</th>
            <th>
              Attendance Details
            </th>
            <th class="text-center">Status</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          foreach ($allvendor as $vendor) {
            if ($vendor->is_admin == 1) {
              continue;
            }
          ?>
            <tr>
              <td class="text-center"><?= $i++; ?></td>
              <?php if ($vendor->profile_image != '') { ?>
                <td class="text-center"><img src="<?php echo base_url(); ?>/uploads/<?= $vendor->profile_image ?>" alt="avatar" class="img-circle" width="50px"></td>
              <?php } else { ?>
                <td class="text-center"><img src="img/placeholders/avatars/avatar11.jpg" alt="avatar" class="img-circle"></td>
              <?php } ?>
              <td class="text-center"><?= $vendor->full_name; ?></td>
              <td class="text-center"><?= $vendor->franchise_name; ?></td>
              <td class="text-center"><?= $vendor->email; ?></td>
              <td class="text-center"><?= $vendor->contact_no; ?></td>
              <td class="text-center">
                <button type="button" onclick="getAttendanceData(<?= $vendor->id; ?>);" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Attendance</button>
              </td>
              <td class="text-center">
                <?php if ($vendor->status == 0) { ?>
                  <a href="javascript:void(0);" onClick="statusupdate('<?= $vendor->id; ?>','1');"><button type="button" class="btn btn-danger ">Deactivate</button></a>
                <?php } else { ?>
                  <a href="javascript:void(0);" onClick="statusupdate('<?= $vendor->id; ?>','0');"> <button type="button" class="btn btn-success"> Active </button></a>
                <?php } ?>
              </td>
              <td class="text-center">
                <div class="btn-group">
                  <a href="<?php echo base_url(); ?>/Admin/Editvendor/<?= $vendor->id; ?>" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                  <a href="javascript:void(0);" onClick="deleteRecord('<?= $vendor->id; ?>');" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                </div>
              </td>

            </tr>


          <?php } ?>

        </tbody>
      </table>
    </div>

  </div>
</div>

<!-- Attendance Modal  -->

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
              <th>Type</th>
              <th>Date</th>
              <th>Time</th>
              <th>Location</th>
              <th>Image</th>
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



<!-- END Page Content -->
<form name="frm_deleteBanner" id="frm_deleteBanner" action="<?php echo base_url(); ?>/Admin/deletevendor" method="post">
  <input type="hidden" name="user_id" id="user_id" value="">
</form>

<script type="text/javascript">
  function deleteRecord(id) {
    $("#operation").val('delete');
    $("#user_id").val(id);
    var conf = confirm("Are you sure want to delete this Vendor");
    if (conf) {
      $("#frm_deleteBanner").submit();
    }
  }
</script>
<form name="status_update" id="status_update" action="<?php echo base_url(); ?>/Admin/statusvendor" method="post">
  <input type="hidden" name="center_id" id="center_id" value="">
  <input type="hidden" name="center_status" id="center_status" value="">
</form>

<script type="text/javascript">
  function statusupdate(id, status) {
    // alert(id);
    $("#center_id").val(id);
    $("#center_status").val(status);
    var conf = confirm("Are you sure want to change the status");
    if (conf) {
      $("#status_update").submit();
    }
  }

  function getAttendanceData(id) {
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

  function getMembers(id)
  {
    $.ajax({
      url: "<?php echo base_url(); ?>/franchises/get-member-data",
      method: "POST",
      data: {
        franchise_id: id
      },
      success: function(response) {
        $('#member_id').html(response);
      }
    });
  }
</script>



<script>
  UIkit.modal('#modal-center<?= session()->getFlashdata('uid') ?>').show();
</script>


<?php include('footer.php') ?>