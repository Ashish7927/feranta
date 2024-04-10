<?php include("header.php"); ?>

	<div class="uk-cover-container uk-background-cover uk-height-small uk-flex" uk-parallax="bgy: -200" style=" overflow:hidden; background-image: url('<?php echo base_url(); ?>/uploads/1615375782838-f890f8.jpeg');">
	  <div class="uk-overlay-defaultr uk-position-cover">
	    <div class="uk-position-center ">
	      <h1 class="uk-text-center" style="font-weight:700; color:#fff;"> Blog </h1>

	    </div>
	  </div>
	</div>
	<div class="uk-card uk-card-body uk-card-default uk-card-small">
	  <div class="uk-container">
	    <ul class="uk-breadcrumb">
	      <li><a href="<?php echo base_url(); ?>/">Home</a></li>

	      <li><span>Blog</span></li>
	    </ul>
	  </div>


	</div>
	<div class="uk-section uk-background-muted">
	  <div class="uk-container">
      <div class="uk-child-width-1-3@m" uk-grid>
      <?php foreach ($Allblog as $allblog) { ?>
        <div>
          <div class="uk-card uk-card-default">


            <div class="uk-card-media-left uk-cover-container">
              <img src="<?php echo base_url(); ?>/uploads/<?= $allblog->image ?>" alt="" uk-cover>
              <canvas width="500" height="400"></canvas>
            </div>



            <div class="uk-card-body uk-padding-small">
              <a href="<?php echo base_url(); ?>/single_blog/<?= $allblog->blog_id; ?>" class="uk-text-secondary">

              </a>
              <h4 class="uk-text-center uk-margin-remove" style="font-weight:700"><a href="<?php echo base_url(); ?>/single_blog/<?= $allblog->blog_id; ?>" class="text-decoration-none uk-text-secondary"><?= $allblog->title; ?></a>
              </h4>
              <p class="uk-text-center uk-margin-remove uk-text-danger"><b>Category: </b> <?= $allblog->category; ?> </p>
              <div class="uk-grid-small uk-grid-divider uk-child-width-expand" uk-grid>
                <div><a href="<?php echo base_url(); ?>/single_blog/<?= $allblog->blog_id; ?>" class="uk-text-secondary">
                    <strong>Author</strong> : <?= $allblog->name; ?>
                  </a></div>

                <div class="uk-text-right"><a href="<?php echo base_url(); ?>/single_blog/<?= $allblog->blog_id; ?>" class="uk-text-secondary">
                    <strong>Date</strong>: <?= $allblog->date; ?>
                  </a></div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
   

	  </div>

	</div>
<h1></h1>

	<?php include("footer.php"); ?>