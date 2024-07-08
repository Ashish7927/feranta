<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>

<!-- Page content -->
<div id="page-content">
    <div class="uk-grid-small uk-child-width-expand@m" uk-grid>
        <div class="uk-width-2-5@m">
            <div class="uk-card uk-card-body uk-card-small uk-card-default">
                <div class="modal-header">
                    <h4 class="modal-title">Add Subadmin</h4>
                </div>
                <form action="<?php echo base_url(); ?>/admin/addsubadmin" enctype="multipart/form-data" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter full name" value="<?= set_value('name') ?>">
                                    <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('name'); ?></span><?php } ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php echo set_value('email'); ?>">
                                    <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('email'); ?></span><?php } ?>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Contact No</label>
                                    <input type="tel" class="form-control" id="contat" name="contact" placeholder="contact no" value="<?php echo set_value('contact'); ?>">
                                    <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('contact'); ?></span><?php } ?>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label>Uploade Image</label>
                                <input type="file" name="img" id="exampleFormControlFile1" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" value="<?php echo set_value('username'); ?>">
                                    <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('username'); ?></span><?php } ?>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" value="<?php echo set_value('password'); ?>">
                                    <?php if (isset($validation)) { ?><span class="text-danger"><?= $error = $validation->getError('password'); ?></span><?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <div>
            <div class="uk-card uk-card-body uk-card-default uk-card-small">
                <h3>Sub admin</h3>
                <div class="table-responsive">
                    <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center"><i class="gi gi-user"></i></th>
                                <th>Client</th>
                                <th>Email</th>
                                <th>Phone no.</th>

                                <th>Status</th>
                                <th class="text-center">Actions</th>
                                <th class="text-center">Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($allsubadmin as $subadmin) {
                                if($subadmin->id == 1){
                                    continue;
                                }
                            ?>
                                <tr>
                                    <td class="text-center"><?= $i++; ?></td>
                                    <?php if ($subadmin->profile_image != '') { ?>
                                        <td class="text-center"><img src="<?php echo base_url(); ?>/uploads/<?= $subadmin->profile_image ?>" alt="avatar" class="img-circle" width="50px"></td>
                                    <?php } else { ?>
                                        <td class="text-center"><img src="img/placeholders/avatars/avatar11.jpg" alt="avatar" class="img-circle"></td>
                                    <?php } ?>
                                    <td><?= $subadmin->full_name; ?></td>
                                    <td><?= $subadmin->email; ?></td>
                                    <td><?= $subadmin->contact_no; ?></td>

                                    <td>
                                        <?php if ($subadmin->status == 0) { ?>
                                            <a href="<?php echo base_url(); ?>/admin/statusActive/<?php echo $subadmin->id; ?>"><button type="button" class="btn btn-danger ">Deactivate</button></a>
                                        <?php } else { ?>
                                            <a href="<?php echo base_url(); ?>/admin/statusBlock/<?php echo $subadmin->id; ?>"> <button type="button" class="btn btn-success"> Active </button></a>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="#modal-center<?= $subadmin->id; ?>" uk-toggle title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                            <a href="javascript:void(0);" onClick="deleteRecord('<?= $subadmin->id; ?>');" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                        </div>
                                    </td>
                                      <td class="text-center">
                                                <a class="btn btn-primary" href="#modal-sections<?= $subadmin->id;?>" uk-toggle>Role</a>
<?php if($subadmin->roles!=''){ ?>
 <?php $jobAssign = explode(',',$subadmin->roles);   ?>  
<?php }else{ ?>
<?php $jobAssign = explode(',',0,0.0);   ?>
<?php } ?>

<div id="modal-sections<?= $subadmin->id;?>" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title"><?= $subadmin->full_name;?>'s Role</h2>
        </div>
        <form action="<?php echo base_url();?>/admin/role" enctype="multipart/form-data" method="post">
            
        <div class="uk-modal-body">
            <input type="hidden" value="<?= $subadmin->id;?>" name="id">
            <input type="hidden" name="role[]" class="uk-checkbox" value="0" />
           
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
            <button class="uk-button uk-button-primary" type="submit">Save</button>
        </div>
        </form>
    </div>
</div>
                                            
                                            </td>
                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>

                    <?php foreach ($allsubadmin as $subadmin) { ?>
                        <div id="modal-center<?= $subadmin->id; ?>" class="uk-flex-top" uk-modal>
                            <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
                                <button class="uk-modal-close-default" type="button" uk-close></button>
                                <form action="<?php echo base_url(); ?>/admin/editsubadmin" enctype="multipart/form-data" method="post">
                                    <div class="modal-body">
                                        <?php if (session()->getFlashdata('uid') == $subadmin->id) : ?>
                                            <div class="alert alert-warning">
                                                <?= session()->getFlashdata('msg') ?>
                                            </div>
                                        <?php endif; ?>
                                        <input type="hidden" name="id" value="<?= $subadmin->id; ?>">
                                        <div class="row uk-text-left">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" value="<?= $subadmin->full_name; ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Email address</label>
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?= $subadmin->email; ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Contact No</label>
                                                    <input type="tel" class="form-control" id="contat" name="contact" title="Enter Only 10 digit Mobile no " value="<?= $subadmin->contact_no; ?>" placeholder="contact no" pattern="[1-9]{1}[0-9]{9}" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <label>Upload Image</label>
                                                <input type="file" name="img" id="exampleFormControlFile1" class="form-control">
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" value="<?= $subadmin->user_name; ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="text" class="form-control" id="password" name="password" placeholder="Enter Password" value="<?= base64_decode(base64_decode($subadmin->password)); ?>" required>
                                                </div>
                                            </div>
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
    <!-- END Mini Top Stats Row -->
</div>
<!-- END Page Content -->

<form name="frm_deleteBanner" id="frm_deleteBanner" action="<?php echo base_url(); ?>/admin/deleteSubadmin" method="post">
    <input type="hidden" name="operation" id="operation" value="">
    <input type="hidden" name="user_id" id="user_id" value="">
</form>
<script type="text/javascript">
    function deleteRecord(id) {
        $("#operation").val('delete');
        $("#user_id").val(id);
        var conf = confirm("Are you sure want to delete this Subadmin");
        if (conf) {
            $("#frm_deleteBanner").submit();
        }
    }
</script>



<script>
    UIkit.modal('#modal-center<?= session()->getFlashdata('uid') ?>').show();
</script>


<?php include('footer.php') ?>