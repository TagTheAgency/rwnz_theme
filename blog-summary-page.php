<?php /* Template Name: Summary page for blog posts */ get_header(); ?>
<?php
$page_colour = get_post_meta(get_the_ID(), 'page-colour-theme', true);
$header_content = apply_filters('the_content', get_the_excerpt());
?>
	<section role="header" class="header">
		<section class="mainStory header-content-wrapper">
			<div class="header-image-wrapper">
    			<div class="header-image-inner"><img class="img" src="<?php the_post_thumbnail_url('page-header'); ?>" /></div>
			</div>
			<div class="page-title-container">
				<h1><?php the_title()?></h1>
			</div>
		</section>
	</section>

<style>
article.news_archive a, article.news_archive a:hover {
	color: <?php echo $page_colour?>;
}

</style>
<?php


	$next_args = array(
	    'post_type' => 'post',
	    'post_status' => 'publish',
	    'posts_per_page'=>6,
	    'order'=>'DESC',
	    'orderby'=>'date',
	);

	$query = new WP_Query( $next_args );
	if ( $query->have_posts() ) {
	        $query->the_post();
	        ?>
	        <div class="row blog_summary">
	        	<div class="col-sm-8">
	        		<article class="news_archive">
	        					<h1><a href="<?php the_permalink()?>"><?php the_title()?></a></h1>
	        					<h3><?php the_date()?></h3>
	        					<?php the_excerpt();?>
	        					<div style="border-top: 4px solid <?php echo $page_colour;?>; margin-top: 20px;"></div>
								<?php $query->the_post(); ?>
								<div class="left">
	        					<img src="<?php the_post_thumbnail_url('thumbnail') ?>"/>
	        					<h2><a href="<?php the_permalink()?>"><?php the_title() ?></a></h2>
	        					<h3><?php the_date()?></h3>
	        					<?php the_excerpt() ?>
	        					</div>

								<?php $query->the_post(); ?>
								<div class="right">
	        					<img src="<?php the_post_thumbnail_url('thumbnail') ?>"/>
	        					<h2><a href="<?php the_permalink()?>"><?php the_title() ?></a></h2>
	        					<h3><?php the_date()?></h3>
	        					<?php the_excerpt() ?>
	        					</div>

								<?php $query->the_post(); ?>
								<div class="left">
	        					<img src="<?php the_post_thumbnail_url('thumbnail') ?>"/>
	        					<h2><a href="<?php the_permalink()?>"><?php the_title() ?></a></h2>
	        					<h3><?php the_date()?></h3>
	        					<?php the_excerpt() ?>
	        					</div>

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
	<?php
	    wp_reset_postdata();
	} else {
	    // none were found
	}
?>





<?php get_footer(); ?>
