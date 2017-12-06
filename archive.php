<?php get_header(); ?>


<?php 
$page_colour = '#00aba0';//get_post_meta(get_the_ID(), 'page-colour-theme', true);
$header_content = apply_filters('the_content', get_the_excerpt());
?>
	<section role="header" class="header">
		<section class="mainStory" style="background-color: <?php echo $page_colour;?>; position: relative;">
			<div class="header-image-wrapper">
    			<div class="header-image-inner"><img class="img" src="<?php the_post_thumbnail_url('page-header'); ?>" /></div>
			</div>

		<!-- img src="<?php the_post_thumbnail_url('page-header'); ?>" class="feature-image" style="width: 60%; margin-left: 5%; margin-top:2%; margin-bottom: -2%"/ --> 
		<div id="page-header">
			<?php include( locate_template( 'searchform.php', false, false ) );?> 
        	<div class="excerpt_content">
        		<?php echo the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
				<!-- h1 style="color:white;"><?php the_title()?></h1 --> 
		    </div>
        </div>	
		
		</section>
	</section>

<style>
article.news_archive a, article.news_archive a:hover {
	color: <?php echo $page_colour?>;
}
</style>

<div class="row blog_summary">
   	<div class="col-sm-8">
   		<article class="news_archive">

<?php if (have_posts()) {
	the_post();
	?>
	<h1><a href="<?php the_permalink()?>"><?php the_title()?></a></h1>
	<h3><?php the_date()?></h3>
	<?php the_excerpt();?>
	<?php
}
?>
<?php $side = 'false';?>
<?php if (have_posts()): while (have_posts()) : the_post(); ?>
	<div style="border-top: 4px solid <?php echo $page_colour;?>; margin-top: 20px;"></div>
	<div class="<?php $side = !$side; if ($side) echo 'left'; else echo 'right';?>">
	<img src="<?php the_post_thumbnail_url('thumbnail') ?>"/>
	<h2><a href="<?php the_permalink()?>"><?php the_title() ?></a></h2>
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
			<?php 
				$params = 'type=monthly';
				if (get_query_var(post_type)) {
					$params .= '&post_type='.get_query_var(post_type);
				}
				wp_get_archives($params); 
			?>
		</ul>
	</div>
</div>


	



<?php get_footer(); ?>
