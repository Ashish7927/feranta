<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>
<!-- Page content -->
<div id="page-content">
    <div class="uk-width-expand@m">
        <div class="uk-card uk-card-body uk-card-default uk-card-small">

            <h3>Driver-Vehicle Management</h3>
            <?php if (session('message') !== null) : ?>
                <p><?= session('message'); ?></p>
            <?php endif; ?>
            <div class="table-responsive">
                <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Sl No.</th>
                            <th>Driver Name</th>
                            <th>Redg. No. </th>
                            <th>Vehicle name</th>
                            <th>Owner</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($allDriverVehicle as $single) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td><?= $single->drivername; ?></td>
                                <td><?= $single->regd_no; ?></td>
                                <td><?= $single->model_name; ?></td>
                                <td><?= $single->full_name; ?></td>
                                <td class="text-center">
                                    <?php if ($single->status == 1) { 
                                        echo 'Active';
                                    }elseif($single->status == 0){
                                        echo 'Requested';
                                    }else if($single->status == 2){
                                        echo 'Rejected';
                                    }else{
                                        echo 'closed';
                                    }?>
                                </td>

                                <td class="text-center">
                                    <?php if($single->status == 0){?>
                                <a href="<?php echo base_url(); ?>/vehicle/accept/<?= $single->id; ?>" class="btn btn-success" >Accept</a>
                                <a href="<?php echo base_url(); ?>/vehicle/reject/<?= $single->id; ?>" class="btn btn-warning">Decline</a>
                                <?php }elseif($single->status == 1){?>
                                    <a href="<?php echo base_url(); ?>/vehicle/leave/<?= $single->id; ?>" class="btn btn-danger"> Leave </a>
                                <?php } elseif($single->status == 2){ ?>
                                    <a href="#" class="btn btn-default"> Declied </a>
                                    <?php }else{  ?>
                                        <a href="#" class="btn btn-default"> Deactivated </a>
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
<?php include('footer.php') ?>