<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>
<!-- Page content -->
<div id="page-content">
    <!-- Dashboard Header -->
    <!-- For an image header add the class 'content-header-media' and an image as in the following example -->



    <div class="uk-grid-small" uk-grid>
        <div class="uk-width-1-3@m">
            <div class="uk-card  uk-card-default uk-card-small">
                <div class="modal-header">
                    <h4 class="modal-title">Add Pincode</h4>
                </div>


                <form action="<?php echo base_url(); ?>/Admin/addpincode" method="post">
                    <div class="modal-body">


                        <div>
                            <label>Select State</label>
                            <select class="form-control" name="state_id" id="stateid" onChange="GetMasterdis(this.value)" required>
                                <option value="">- Select -</option>
                                <?php foreach ($Allstate as $state) { ?>
                                    <option value="<?= $state->state_id; ?>"><?= $state->state_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <p></p>
                        <div>
                            <label>Select City</label>
                            <select class="form-control" name="city_id" id="resultDiv" required>
                                <option value="">- Select -</option>
                                <?php foreach ($city as $cityy) { ?>
                                    <option value="<?= $cityy->city_id; ?>"><?= $cityy->city_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Enter Pincode</label>
                            <input type="text" name="pincode" value="<?php echo set_value('pincode'); ?>" class="form-control" />
                            <?php if (isset($validation)) { ?>
                                <span class="text-danger"><?= $error = $validation->getError('pincode'); ?></span>
                            <?php } ?>
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

            <h3>Pincode</h3>
            <div class="table-responsive">
                <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">SL.No</th>
                            <th class="text-center">State Name</th>

                            <th class="text-center">City Name</th>
                            <th class="text-center">Pincode</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                            <th style="display:none"></th>
                            <th style="display:none"></th>

                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $i = 1;
                        foreach ($pincode as $pincodee) { ?>
                            <tr>
                                <td class="text-center"><?= $i++ ?></td>
                                <td>
                                    <?php foreach ($Allstate as $state) {
                                        if ($state->state_id == $pincodee->state_id) {
                                    ?>
                                            <?= $state->state_name; ?>
                                    <?php }
                                    } ?>

                                </td>

                                <td>
                                    <?php foreach ($city as $cityy) {
                                        if ($cityy->city_id == $pincodee->city_id) {
                                    ?>
                                            <?= $cityy->city_name; ?>
                                    <?php }
                                    } ?>
                                </td>
                                <td><?= $pincodee->pincode; ?></td>
                                <td class="text-center">
                   <?php if($pincodee->status ==0){?>
                  <a href="javascript:void(0);" onClick="statusupdate('<?= $pincodee->pin_id;?>','1');" ><button type="button" class="btn btn-danger ">Deactivate</button></a>
                  <?php }else{?>
                   <a href="javascript:void(0);" onClick="statusupdate('<?= $pincodee->pin_id;?>','0');"> <button type="button" class="btn btn-success"> Active </button></a>
                    <?php }?>
                                    </td>

                                <td class="text-center">
                                    <div class="btn-group">

                                        <a href="#modal-center<?= $pincodee->pincode; ?>" uk-toggle title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>

                                        <div id="modal-center<?= $pincodee->pincode; ?>" class="uk-flex-top" uk-modal>
                                            <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

                                                <button class="uk-modal-close-default" type="button" uk-close></button>
                                                <?php if (session()->getFlashdata('uid') == $pincodee->pincode) : ?>
                                                    <div class="alert alert-warning">
                                                        <?= session()->getFlashdata('msg') ?>
                                                    </div>
                                                <?php endif; ?>


                                                <form action="<?php echo base_url(); ?>/admin/editpincode" method="post">
                                                    <div class="modal-body uk-text-left">

                                                        <input type="hidden" name="pin_id" value="<?= $pincodee->pin_id; ?>">

                                                        <div class="form-group">
                                                            <label> Select State</label>
                                                            <select class="form-control" name="state_id" id="stateid" onChange="GetMasterdis(this.value)" >
                                                                <option>- Select -</option>
                                                                <?php foreach ($Allstate as $state) { ?>
                                                                    <option <?php if ($state->state_id == $pincodee->state_id) {
                                                                                echo "selected";
                                                                            } ?> value="<?= $state->state_id; ?>"><?= $state->state_name; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label> Select City</label>
                                                           <select class="form-control" name="city_id" id="resultDiv" required>
                                                                <option>- Select -</option>
                                                                <?php foreach ($city as $cityy) { ?>
                                                                    <option <?php if ($cityy->city_id == $pincodee->city_id) {
                                                                                echo "selected";
                                                                            } ?> value="<?= $cityy->city_id; ?>"><?= $cityy->city_name; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Enter Pincode</label>
                                                            <input type="text" name="pincode" value="<?= $pincodee->pincode; ?>" class="form-control" />
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Submit</button>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>


                                        <a href="javascript:void(0);" onClick="deleteRecord('<?= $pincodee->pin_id; ?>');" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                    </div>
                                </td>
                                <th style="display:none"></th>
                                <th style="display:none"></th>
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
<!-- END Page Content -->
<form name="frm_deleteBanner" id="frm_deleteBanner" action="<?php echo base_url(); ?>/Admin/deletepincode" method="post">
    <input type="hidden" name="user_id" id="user_id" value="">
</form>

<script type="text/javascript">
    function deleteRecord(id) {
        $("#operation").val('delete');
        $("#user_id").val(id);
        var conf = confirm("Are you sure want to delete this Pincode");
        if (conf) {
            $("#frm_deleteBanner").submit();
        }
    }
</script>
<form name="status_update" id="status_update" action="<?php echo base_url(); ?>/Admin/statuspincode" method="post">
   <input type="hidden" name="pin_id" id="pin_id" value="">
   <input type="hidden" name="pin_status" id="pin_status" value="">
</form>

<script type="text/javascript">
  function statusupdate(id,status) {
   // alert(id);
    $("#pin_id").val(id);
	$("#pin_status").val(status);
    var conf = confirm("Are you sure want to change the status");
    if (conf) {
      $("#status_update").submit();
    }
  }
</script>

<script>
    UIkit.modal('#modal-center<?= session()->getFlashdata('uid') ?>').show();
</script>

<script>
    function GetMasterdis(val) {
        var stateid = $('#stateid').val();
        //alert(cityid);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>/Admin/getcity",
            data: {
                state_id: stateid
            },
            success: function(data) {
                $("#loader").attr("style", "display:none;");
                $('#resultDiv').html(data);
                //alert(data); //Unterminated String literal fixed
            }
        });
        event.preventDefault();
        return false; //stop the actual form post !important!
    }
</script>

<?php include('footer.php') ?>