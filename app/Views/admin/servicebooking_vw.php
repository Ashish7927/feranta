<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>
<!-- Page content -->
<div id="page-content">

    <div class="uk-grid-small" uk-grid>
        <div class="uk-width-1-3@m" style="display: none;">
            <div class="uk-card  uk-card-default uk-card-small">
                <div class="modal-header">
                    <h4 class="modal-title">Book a Service</h4>
                </div>
                <?php if (session('booking_message') !== null) : ?>
                    <p><?= session('booking_message'); ?></p>
                <?php endif; ?>


                <form action="<?php echo base_url(); ?>/service-booking/add" method="post">
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Select Service Type</label>
                            <select name="booking_type" id="booking_type" class="form-control" required onchange="setType(this.value);">
                                <option value="">-- Select Type --</option>
                                <option value="cab"> Cab Booking</option>
                                <option value="sharing"> Cab Share Booking</option>
                                <option value="future_cab">Future Cab Booking</option>
                            </select>
                        </div>

                        <div class="form-group" id="boarding_div" style="display: none;">
                            <label>Choose Boarding Datetime</label>
                            <input type="datetime-local" name="boarding_date" id="boarding_date" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Select Vehicle Type</label>
                            <select name="vehicle_type" id="vehicle_type" class="form-control" required>
                                <option value="">-- Select Vehicle Type --</option>
                                <?php foreach ($vehicleType as $type) { ?>
                                    <option value="<?= $type->id; ?>"><?= $type->type_name ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>From City</label>
                            <select name="from_location" id="from_city" class="form-control" required onchange="getFromCity(this.value);">
                                <option value="">-- Select City --</option>
                                <?php foreach ($cities as $city) { ?>
                                    <option value="<?= $city->city_id; ?>"><?= $city->city_name ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>To City</label>
                            <select name="to_location" id="to_city" class="form-control" required>
                                <option value="">-- Select City --</option>
                                <?php foreach ($cities as $city) { ?>
                                    <option value="<?= $city->city_id; ?>"><?= $city->city_name ?></option>
                                <?php } ?>
                            </select>
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

            <h3>Booking Details</h3>
            <div class="table-responsive">
                <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Sl No.</th>
                            <th>Service Type</th>
                            <th>Vehicle Type</th>
                            <th>From City</th>
                            <th>To City</th>
                            <th>Vehicle Name</th>
                            <th>Redg No.</th>
                            <th>Driver Name</th>
                            <th>Driver Number</th>
                            <th>Total Fare</th>
                            <th>Driver Request</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($allBooking as $booking) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td><?= $booking->booking_type; ?></td>
                                <td><?= $booking->type_name; ?></td>
                                <td><?= $booking->from_location; ?></td>
                                <td><?= $booking->to_location; ?></td>
                                <td><?= $booking->model_name; ?></td>
                                <td><?= $booking->regd_no; ?></td>
                                <td><?= $booking->full_name; ?></td>
                                <td><?= $booking->contact_no; ?></td>
                                <td><?= $booking->fare; ?></td>
                                <td><button type="button" onclick="getDriverList(<?= $booking->id; ?>);" class="btn btn-primary" data-toggle="modal" data-target="#myModal">List</button></td>
                                <td class="text-center">
                                    <?php if ($booking->status == 0) {
                                        echo 'Pending';
                                    } elseif ($booking->status == 1) {
                                        echo 'Confirm';
                                    } elseif ($booking->status == 2) {
                                        echo 'Cancel';
                                    } elseif ($booking->status == 4) {
                                        echo 'Complete';
                                    } else {
                                        echo 'Denied';
                                    } ?>
                                </td>

                                <td class="text-center">
                                    <a href="javascript:void(0);" onClick="statusupdate('<?= $booking->id; ?>','0');"><button type="button" class="btn btn-danger ">Cancel</button></a>
                                    <?php if($booking->vehicle_id > 0 && $booking->driver_id > 0){ ?>
                                    <a href="javascript:void(0);" onClick="statusupdate('<?= $booking->id; ?>','1');"> <button type="button" class="btn btn-success"> Complete </button></a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

</div>

<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Driver Subscription Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Sl no</th>
              <th>Driver Name</th>
              <th>Driver Contact</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="driverListData">
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
  function getDriverList(id) {
    $('#driverListData').html('');
    $.ajax({
      url: "<?php echo base_url(); ?>/service-booking/get-request-list",
      method: "POST",
      data: {
        booking_id: id
      },
      success: function(response) {
        $('#driverListData').html(response);
      }
    });
  }
</script>


<form name="status_update" id="status_update" action="<?php echo base_url(); ?>/service-booking/status" method="post">
    <input type="hidden" name="state_id" id="state_id" value="">
    <input type="hidden" name="state_status" id="state_status" value="">
</form>

<script type="text/javascript">
    function statusupdate(id, status) {
        $("#state_id").val(id);
        $("#state_status").val(status);
        if (status == 1) {
            var conf = confirm("Are you sure want to Complete the booking");
        }else{
            var conf = confirm("Are you sure want to Cancel the booking");
        }
       
        if (conf) {
            $("#status_update").submit();
        }
    }
</script>

<script>
    UIkit.modal('#modal-center<?= session()->getFlashdata('uid') ?>').show();
</script>

<script>
    function setType(val) {
        if (val == 'future_cab') {
            $("#boarding_div").css("display", "block");
            $('#boarding_date').prop('required', true);
        } else {
            $('#boarding_date').prop('required', false);
            $("#boarding_div").css("display", "none");
        }
        return false;
    }


</script>

<?php include('footer.php') ?>