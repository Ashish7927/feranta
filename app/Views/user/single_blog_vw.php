<?php include("header.php"); ?>


<?php foreach( $singleBlog as $blog_data){ } ?>



<div class="uk-cover-container uk-background-cover uk-height-small uk-flex" uk-parallax="bgy: -200" style=" overflow:hidden; background-image: url('<?php echo base_url(); ?>/uploads/1615375782838-f890f8.jpeg');">
    <div class="uk-overlay-defaultr uk-position-cover">
        <div class="uk-position-center ">
            <h1 class="uk-text-center" style="font-weight:700; color:#fff;"> <?= $blog_data->title;?> </h1>

        </div>
    </div>
</div>

<div class="uk-card uk-card-body uk-card-default uk-card-small">
    <div class="uk-container">
        <ul class="uk-breadcrumb">
            <li><a href="<?php echo base_url(); ?>/">Home</a></li>
            <li><a href="<?php echo base_url(); ?>/Blog">Blog</a></li>
            <li><span><?= $blog_data->title;?> </span></li>
        </ul>
    </div>


</div>


<div class="uk-section">
    <div class="uk-container">
<div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin" uk-grid>
    <div class="uk-card-media-left uk-cover-container">
        <img src="<?php echo base_url(); ?>/uploads/<?=$blog_data->image; ?>" alt="" uk-cover>
        <canvas width="600" height="700"></canvas>
    </div>
    <div>
        <div class="uk-card-body">
            <h3 class="uk-card-title"><?= $blog_data->title;?></h3>
            <p><?= $blog_data->message;?></p>
        </div>
    </div>
</div>
</div>
</div>



<?php include("footer.php"); ?>
