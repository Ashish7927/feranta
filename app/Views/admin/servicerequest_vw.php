<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>
<!-- Page content -->
<div id="page-content">
    <div class="uk-width-expand@m">
        <div class="uk-card uk-card-body uk-card-default uk-card-small">
            <h3>Service Request Details</h3>
            <div class="table-responsive">
                <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Sl No.</th>
                            <th>Booking Type</th>
                            <th>Customer Name</th>
                            <th>Redg No</th>
                            <th>From Location</th>
                            <th>TO Location</th>
                            <th>Fare</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($AllServiceRequest as $request) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td><?= $request->booking_type; ?></td>
                                <td><?= $request->full_name; ?></td>
                                <td><?= $request->regd_no; ?></td>
                                <td><?= $request->from_location; ?></td>
                                <td><?= $request->to_location; ?></td>
                                <td><?= $request->fare; ?></td>

                                <td class="text-center">
                                    <?php if ($request->status == 0) { ?>
                                        <a href="javascript:void(0);" onClick="statusupdate('<?= $request->id; ?>','1');"> <button type="button" class="btn btn-success"> Accept </button></a>
                                        <a href="javascript:void(0);" onClick="statusupdate('<?= $request->id; ?>','0');"><button type="button" class="btn btn-danger ">Reject</button></a>

                                    <?php } elseif ($request->status == 1) {
                                        echo 'Accepted';
                                    }elseif($request->status == 3 ){ echo 'Cancel/Reject'; } else {
                                        echo 'Taken';
                                    } ?>
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
<!-- END Page Content -->
<form name="status_update" id="status_update" action="<?php echo base_url(); ?>/service-request/status" method="post">
    <input type="hidden" name="id" id="id" value="">
    <input type="hidden" name="state_status" id="state_status" value="">
</form>

<script type="text/javascript">
    function statusupdate(id, status) {
        $("#id").val(id);
        $("#state_status").val(status);
        if (status == 1) {
            var conf = confirm("Are you sure want to Accept the booking");
        } else {
            var conf = confirm("Are you sure want to Reject the booking");
        }

        if (conf) {
            $("#status_update").submit();
        }
    }
</script>
<?php include('footer.php') ?>