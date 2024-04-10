<?php include('header.php') ?>
<?php include("mainsidebar.php") ?>

<div id="page-content">
    <div class="uk-grid-small uk-child-width-expand@m" uk-grid>
        <div>
            <div class="uk-card uk-card-body uk-card-default uk-card-small">
                <h3>Add Pages</h3>
                <form action="<?php echo base_url(); ?>/admin/Add_page" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
                    <!-- Basic Form Elements Block -->
                    <div class="block">


                        <div class="form-group">
                            <label>Page Name</label>
                            <div>
                                <input type="text" id="example-text-input" name="pageName" class="form-control" value="">

                            </div>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <div>
                                <textarea id="editor1" name="pageDetails" class="form-control" placeholder="Description"></textarea>

                            </div>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <div>
                                <input type="file" id="example-file-input" name="img" class="form-control" placeholder=" Insert file">
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Page Title</label>
                            <div>
                                <input type="text" id="example-text-input" name="pageTitle" class="form-control" value="">

                            </div>
                        </div>

                        <div class="form-group">
                            <label>Page KeyWord</label>
                            <div>
                                <input type="text" id="example-text-input" name="KeyWord" class="form-control" value="">

                            </div>
                        </div>

                        <div class="form-group">
                            <label>Page Decription</label>
                            <div>
                                <textarea name="PageDescription" class="form-control" value=""></textarea>

                            </div>
                        </div>

                    </div>

                    <div class="form-group form-actions">
                        <div>
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Submit</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div>
            <div class="uk-card uk-card-body uk-card-default uk-card-small">
                <h3>Content Managemnet</h3>
                <div class="table-responsive">
                    <table id="example-datatable" class="table table-vcenter table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th>Sl_no.</th>
                                <th>Page Name</th>
                                <th class="text-center">Image</th>


                                <th class="text-center">Actions</th>
                                <th class="dn"></th>
                                <th class="dn"></th>
                                <th class="dn"></th>
                                <th class="dn"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($allcms as $cms) { ?>
                                <tr>
                                    <td class="text-center"><?= $i++; ?></td>
                                    <td><?= $cms->page_name; ?></td>
                                    <?php if ($cms->image != '') { ?>
                                        <td class="text-center"><img src="<?php echo base_url(); ?>/uploads/<?= $cms->image ?>" alt="avatar" class="img-circle" width="50px"></td>
                                    <?php } else { ?>
                                        <td class="text-center"><img src="<?php echo base_url(); ?>/assets/img/placeholders/avatars/avatar11.jpg" alt="avatar" class="img-circle"></td>
                                    <?php } ?>

                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="<?php echo base_url(); ?>/admin/Edit_cms/<?= $cms->id ?>" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                            <a href="javascript:void(0);" onClick="deleteRecord('<?= $cms->id; ?>');" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                        </div>
                                    </td>
                                    <td class="dn"></td>
                                    <td class="dn"></td>
                                    <td class="dn"></td>
                                    <td class="dn"></td>
                                </tr>
                            <?php } ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>




</div>

<style>
    .dn {
        display: none;
    }
</style>
<form name="frm_deleteBanner" id="frm_deleteBanner" action="<?php echo base_url(); ?>/admin/Delete_page" method="post">
    <input type="hidden" name="operation" id="operation" value="">
    <input type="hidden" name="user_id" id="user_id" value="">
</form>
<script type="text/javascript">
    function deleteRecord(id) {
        $("#operation").val('delete');
        $("#user_id").val(id);
        var conf = confirm("Are you sure want to delete this Page");
        if (conf) {
            $("#frm_deleteBanner").submit();
        }
    }
</script>

<?php include('footer.php') ?>