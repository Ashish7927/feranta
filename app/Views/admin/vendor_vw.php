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
    <h3>All Owner & Driver</h3>

    <form action="<?php echo base_url(); ?>admin/Vendor" method="GET">
      <div class="row">
        <div class="col-sm-3">
          <div class="form-group">
            <label>Registred From</label>
            <input type="date" class="form-control" name="from_date" value="<?= isset($_REQUEST['from_date']) ? $_REQUEST['from_date'] : ''; ?>">
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <label>Registred To</label>
            <input type="date" class="form-control" name="to_date" value="<?= isset($_REQUEST['to_date']) ? $_REQUEST['to_date'] : ''; ?>">
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <label> Select Role</label>
            <select name="user_type" id="user_type" class="form-control">
              <option value="">Select Role</option>
              <option value="3" <?php if (isset($_REQUEST['user_type']) && $_REQUEST['user_type'] == 3) {
                                  echo 'selected';
                                } ?>>Owner</option>
              <option value="4" <?php if (isset($_REQUEST['user_type']) && $_REQUEST['user_type'] == 4) {
                                  echo 'selected';
                                } ?>>Driver</option>
            </select>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <label> Select Franchise</label>
            <select name="franchise_id" id="franchise_id" class="form-control">
              <option value="">Select Franchise</option>
              <?php foreach ($franchises as $franchise) { ?>
                <option value="<?= $franchise->id ?>" <?php if (isset($_REQUEST['franchise_id']) && $_REQUEST['franchise_id'] == $franchise->id) {
                                                        echo 'selected';
                                                      } ?>><?= $franchise->franchise_name ?></option>
              <?php } ?>

            </select>
          </div>
        </div>


        <div class="col-sm-4">
          <button type="submit" class="btn btn-primary">Update</button>
          <a href="<?php echo base_url(); ?>admin/Vendor" class="btn btn-warning">Reset</a>
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
            <th class="text-center">Role Name</th>
            <th class="text-center">Email</th>
            <th class="text-center">Contact No</th>
            <th class="text-center">Registerd By</th>
            <th class="text-center">Franchisis</th>
            <th class="text-center">Status</th>
            <th class="text-center">Actions</th>
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
              <td class="text-center"><?php if ($vendor->user_type == 3) {
                                        echo 'Owner';
                                      } else {
                                        echo 'Driver';
                                      } ?></td>
              <td class="text-center"><?= $vendor->email; ?></td>
              <td class="text-center"><?= $vendor->contact_no; ?></td>
              <td class="text-center"><?= $vendor->member_name; ?></td>
              <td class="text-center"><?php if ($vendor->created_by == 1) {
                                        echo 'Super Admin';
                                      } elseif ($vendor->created_by == '') {
                                        echo 'Self';
                                      } else {
                                        echo $vendor->franchise_name;
                                      } ?></td>
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

<!-- END Page Content -->
<form name="frm_deleteBanner" id="frm_deleteBanner" action="<?php echo base_url(); ?>admin/deletevendor" method="post">
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
</script>



<script>
  UIkit.modal('#modal-center<?= session()->getFlashdata('uid') ?>').show();
</script>


<?php include('footer.php') ?>