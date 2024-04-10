<?php include("header.php"); ?>

       
<!--Start breadcrumb area-->

<div class="uk-cover-container uk-background-cover uk-height-small uk-flex" uk-parallax="bgy: -200" style=" overflow:hidden; background-image: url('<?php echo base_url(); ?>/uploads/<?= $cms->image;?>');">
	  <div class="uk-overlay-defaultr uk-position-cover">
	    <div class="uk-position-center ">
	      <h1 class="uk-text-center" style="font-weight:700; color:#fff;"> <?= $cms->page_name;?> </h1>

	    </div>
	  </div>
	</div>
        
        
        
        <!--End breadcrumb area-->

        <!--Start Company Overview Area-->
         <section class="as_about_wrapper as_padderTop80 as_padderBottom80">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                         <div class="sec-title">
                                <h1><?= $cms->page_name;?></h1>
                                <hr>
                            </div>
                                <?= $cms->details;?>
                    </div>
                </div>
                
                

            </div>
        </section>
        <!--End Company Overview Area-->
       
       



<?php include("footer.php");?>