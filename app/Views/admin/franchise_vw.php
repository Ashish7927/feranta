<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>
<!-- Page content -->
<div id="page-content">



    <div class="uk-grid-small" uk-grid>
        <div class="uk-width-1-3@m">
            <div class="uk-card  uk-card-default uk-card-small">
                <div class="modal-header">
                    <h4 class="modal-title">Add Franchise</h4>
                </div>


                <form action="<?php echo base_url(); ?>/franchises/add" method="post">
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="franchise_name" placeholder="Enter full name" value="<?= set_value('franchise_name'); ?>" require>
                        </div>

                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?= set_value('email'); ?>" require>
                        </div>

                        <div class="form-group">
                            <label>Contact No</label>
                            <input type="tel" class="form-control" id="contact" name="contact" placeholder="contact no" value="<?= set_value('contact'); ?>" require>
                        </div>


                        <div class="form-group">
                            <label>Select State</label>
                            <select class="form-control" name="state" onchange="CheckstateId(this.value)" id="state_id" require>
                                <option value="">Select State</option>
                                <?php foreach ($allstate as $state) { ?>
                                    <option value="<?= $state->state_id ?>"><?= $state->state_name ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Select City</label>
                            <select class="form-control" name="city" id="cityDiv" onchange="CheckcityId(this.value)" require>
                                <option value="">Select City</option>
                                <?php foreach ($allcity as $city) { ?>
                                    <option value="<?= $city->city_id ?>"><?= $city->city_name ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" value="">
                        </div>

                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username " value="<?= set_value('username'); ?>" require>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" value="<?= set_value('password'); ?>" require>
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

            <h3>Franchises</h3>
            <div class="table-responsive">
                <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Sl no</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($franchises as $franchise) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td><?= $franchise->franchise_name; ?></td>
                                <td><?= $franchise->email; ?></td>
                                <td><?= $franchise->contact; ?></td>
                                <td class="text-center">
                                    <?php if ($franchise->status == 1) { ?>
                                        <a href="javascript:void(0);" onClick="statusupdate('<?= $franchise->id; ?>','0');"><button type="button" class="btn btn-danger ">Deactivate</button></a>
                                    <?php } else { ?>
                                        <a href="javascript:void(0);" onClick="statusupdate('<?= $franchise->id; ?>','1');"> <button type="button" class="btn btn-success"> Active </button></a>
                                    <?php } ?>
                                </td>

                                <td class="text-center">
                                    <div class="btn-group">

                                        <a href="#modal-center<?= $franchise->id; ?>" uk-toggle title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0);" onClick="deleteRecord('<?= $franchise->id; ?>');" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>


                    </tbody>
                </table>



                <?php foreach ($franchises as $franchise) { ?>

                    <div id="modal-center<?= $franchise->id; ?>" class="uk-flex-top" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

                            <button class="uk-modal-close-default" type="button" uk-close></button>
                            <?php if (session()->getFlashdata('uid') == $franchise->id) : ?>
                                <div class="alert alert-warning">
                                    <?= session()->getFlashdata('msg') ?>
                                </div>
                            <?php endif; ?>


                            <form action="<?php echo base_url(); ?>franchises/edit/<?= $franchise->id; ?>" method="post">
                                <div class="modal-body uk-text-left">
                                    <input type="hidden" name="francise_user_id" value="<?= $franchise->user_id; ?>">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="franchise_name" placeholder="Enter full name" value="<?= $franchise->franchise_name; ?>" require>
                                    </div>

                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?= $franchise->email;  ?>" require>
                                    </div>

                                    <div class="form-group">
                                        <label>Contact No</label>
                                        <input type="tel" class="form-control" id="contact" name="contact" placeholder="contact no" value="<?= $franchise->contact;  ?>" require>
                                    </div>


                                    <div class="form-group">
                                        <label>Select State</label>
                                        <select class="form-control" name="state" onchange="CheckstateId(this.value)" id="state_id" require>
                                            <option value="">Select State</option>
                                            <?php foreach ($allstate as $state) { ?>
                                                <option value="<?= $state->state_id ?>" <?php if ($franchise->state == $state->state_id) {
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
                                                <option value="<?= $city->city_id ?>" <?php if ($franchise->city == $city->city_id) {
                                                                                            echo 'selected';
                                                                                        } ?>><?= $city->city_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" name="address" class="form-control" value="<?= $franchise->address;  ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username " value="<?= $franchise->user_name;  ?>" require>
                                    </div>

                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" value="<?= base64_decode(base64_decode($franchise->password));  ?>" require>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>

                                </div>
                            </form>
                        </div>
                    </div>

                <?php } ?>
            </div>
        </div>
    </div>
</div>
</div>




</div>
<!-- END Page Content -->
<form name="frm_deleteBanner" id="frm_deleteBanner" action="<?php echo base_url(); ?>/franchises/delete" method="post">
    <input type="hidden" name="id" id="franchiseid" value="">
</form>

<script type="text/javascript">
    function deleteRecord(id) {
        $("#operation").val('delete');
        $("#franchiseid").val(id);
        var conf = confirm("Are you sure want to delete this State");
        if (conf) {
            $("#frm_deleteBanner").submit();
        }
    }
</script>
<form name="status_update" id="status_update" action="<?php echo base_url(); ?>/franchises/status" method="post">
    <input type="hidden" name="franchise_id" id="franchise_id" value="">
    <input type="hidden" name="state_status" id="state_status" value="">
</form>

<script type="text/javascript">
    function statusupdate(id, status) {
        $("#franchise_id").val(id);
        $("#state_status").val(status);
        var conf = confirm("Are you sure want to change the status");
        if (conf) {
            $("#status_update").submit();
        }
    }

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



<script>
    UIkit.modal('#modal-center<?= session()->getFlashdata('uid') ?>').show();
</script>



<?php include('footer.php') ?>