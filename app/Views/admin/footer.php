 <!-- Footer -->
                    <footer class="clearfix">
                        <div class="pull-right">
                            Crafted with <i class="fa fa-heart text-danger"></i> by <a href="http://goo.gl/vNS3I" target="_blank">pixelcave</a>
                        </div>
                        <div class="pull-left">
                            <span id="year-copy"></span> &copy; <a href="http://goo.gl/TDOSuC" target="_blank">ProUI 3.7</a>
                        </div>
                    </footer>
                    <!-- END Footer -->
                </div>
                <!-- END Main Container -->

 </div>
            <!-- END Page Container -->
        

</div>
        <!-- END Page Wrapper -->
 		<script src="<?php echo base_url(); ?>/assets/js/vendor/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/js/vendor/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/js/plugins.js"></script>
        <script src="<?php echo base_url(); ?>/assets/js/app.js"></script>

        <!-- Load and execute javascript code used only in this page -->
        <script src="<?php echo base_url(); ?>/assets/js/pages/tablesDatatables.js"></script>
        <script>$(function(){ TablesDatatables.init(); });</script>
        
        <script>
        	$(document).ready(function() {
    $('#example').dataTable();
} );

$(document).ready(function() {
        $(".select2").select2({});
        });
        </script>
        
        
  
<script src="<?php echo base_url(); ?>/assets/ckeditor/ck_editor.js"></script>
<script>
    CKEDITOR.replace('editor1');
</script>
        
    </body>
</html>