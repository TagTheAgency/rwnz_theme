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
		?>
		<div class="container-fluid">
			<div class="row blog_summary">
				<div class="col-sm-9">
					<article class="news_archive">
						<div class="page-header-wrapper">
							<h1><?php the_title() ?></h1>
							<!-- <h4><?php the_content() ?></h4> -->
						</div>
						<?php while($query->have_posts()): $query->the_post(); ?>
							<div class="post-content-wrapper">
								<a href="<?php the_permalink()?>"><span class="link"></span></a>
								<div class="post-image-thumb">
									<?php if (has_post_thumbnail('') ): ?>
									<?php the_post_thumbnail('') ?>
									<?php else: ?>
									<img src="<?php echo get_theme_file_uri('/img/placeholderthumbnail.png')?>" alt="">
									<?php endif; ?>
								</div>
								<div class="post-list-info">
									<div>
										<h2 class="post-list-title"><a href="<?php the_permalink()?>"><?php the_title() ?></a></h2>
										<h3><?php the_date()?></h3>
										<p><?php the_excerpt() ?></p>
									</div>
								</div>
							</div>
						<?php endwhile;?>
					</article>
				</div>
				<div class="col-sm-3 archive-wrapper">
					<h2>Archive</h2>
					<ul class="archive">
						<?php wp_get_archives('type=monthly'); ?>
					</ul>
				</div>
			</div>
		</div>
	<?php
	    wp_reset_postdata();
	} else {
	    // none were found
	}
?>

<?php get_footer(); ?>
