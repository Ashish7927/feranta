<?php include("header.php"); ?>


<div class="uk-cover-container uk-background-cover uk-height-small uk-flex" uk-parallax="bgy: -200" style=" overflow:hidden; background-image: url('<?php echo base_url(); ?>/uploads/<?= $cms->image;?>');">
	  <div class="uk-overlay-defaultr uk-position-cover">
	    <div class="uk-position-center ">
	      <h1 class="uk-text-center" style="font-weight:700; color:#fff;"> Contact Us </h1>

	    </div>
	  </div>
	</div>
	<div class="uk-card uk-card-body uk-card-default uk-card-small">
	  <div class="uk-container">
	    <ul class="uk-breadcrumb">
	      <li><a href="<?php echo base_url(); ?>/">Home</a></li>

	      <li><span>Contact Us</span></li>
	    </ul>
	  </div>


	</div>

        <!--Start Contact Address Area-->
        <section class="uk-section uk-background-muted">
            <div class="uk-container">
                <div class="uk-grid-small uk-child-width-expand@m uk-text-center" uk-grid>
                    <!--Start Single Contact Address Box-->
                    <div class="">
                        <div class="single-contact-address-box">
                            <span class="icon-global"></span>
                            <h3>Visit Our Office</h3>
                            <?= $cms->address;?>
                        </div>
                    </div>
                    <!--End Single Contact Address Box-->
                    <!--Start Single Contact Address Box-->
                    <div class="">
                        <div class="single-contact-address-box">
                            <span class="icon-support1"></span>
                            <h3>Call Us</h3>
                             <?= $cms->phone;?>
                        </div>
                    </div>
                    <!--End Single Contact Address Box-->
                    <!--Start Single Contact Address Box-->
                    <div class="">
                        <div class="single-contact-address-box">
                            <span class="icon-shipping-and-delivery"></span>
                            <h3>Mail Us</h3>
                             <?= $cms->email;?>
                        </div>
                    </div>
                    <!--End Single Contact Address Box-->
                </div>
                
            </div>
        </section>
        <!--End Contact Address Area-->

        <!--Start contact form area-->
        <section class="uk-section">
            <div class="uk-container"/>
            <?= $cms->iframe;?>
                
                
            </div>
        </section>
        <!--End contact form area-->
       




<?php include("footer.php");?>