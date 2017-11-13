<?php get_header(); ?>


<?php 
$page_colour = '#00aba0';//get_post_meta(get_the_ID(), 'page-colour-theme', true);
$header_content = apply_filters('the_content', get_the_excerpt());
?>
	<section role="header" class="header">
		<section class="mainStory" style="background-color: <?php echo $page_colour;?>; position: relative;">
		<img src="<?php the_post_thumbnail_url('page-header'); ?>" style="width: 60%; margin-left: 5%; margin-top:2%; margin-bottom: -2%"/>
		<div id="page-header" style="position: absolute; padding-left: 70%;  top:8%;width: 90%">
			<?php include( locate_template( 'searchform.php', false, false ) );?> 
			<h1 style="color:white;"><?php the_title()?></h1>
			<div class="excerpt_content">
	        	<?php echo $header_content; ?>
	    	</div>
        </div>	
		
		</section>
	</section>


<div class="row blog_summary">
   	<div class="col-sm-8">
   		<article style="margin-left: 8%; margin-right: 0%;">

<?php if (have_posts()) {
	the_post();
	?>
	<h1><?php the_title()?></h1>
	<h3><?php the_date()?></h3>
	<?php the_excerpt();?>
	<?php
}
?>
<?php $side = 'false';?>
<?php if (have_posts()): while (have_posts()) : the_post(); ?>
	<div style="border-top: 4px solid <?php echo $page_colour;?>; margin-top: 20px;"></div>
	<div class="<? $side = !$side; if ($side) echo 'left'; else echo 'right';?>">
	<img src="<?php the_post_thumbnail_url('thumbnail') ?>"/>
	<h2><?php the_title() ?></h2>
	<h3><?php the_date()?></h3>
	<?php the_excerpt() ?>
	</div>
<?php endwhile; ?>

<?php else: ?>

<?php endif; ?>
   		</article>
   	</div>
	<div class="col-sm-4" style="padding: 40px;margin-top: 50px;">
		<div style="border-top: 4px solid <?php echo $page_colour;?>; padding-bottom: 20px;"></div>
		<h2>ARCHIVE:</h2>
		<ul class="archive">
			<?php wp_get_archives('type=monthly'); ?>
		</ul>
	</div>
</div>


	



<?php get_footer(); ?>
