<?php get_header(); ?>

<div class="container-fluid">
	<div class="row blog_summary">
		<div class="col-sm-9">
			<article class="news_archive">
				<div class="page-header-wrapper">
					<h1><?php echo $archive_sub_title ?></h1>
				</div>
				<?php while (have_posts()): the_post(); ?>
					<div class="post-content-wrapper">
						<a href="<?php the_permalink()?>"><span class="link"></span></a>
						<div class="post-image-thumb">
							<?php if (has_post_thumbnail('') ): ?>
							<?php rwnz_archive_image(get_post_thumbnail_id($post->ID)); ?>
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
		<div class="col-sm-3 archive-wrapper" style="padding-right: 40px; margin-top: 50px;">
			<h2><?php echo $archive_title ?></h2>
			<ul class="archive">
			<?php 
        			$params = 'type=monthly';
				if (get_query_var('post_type')) {
					$params .= '&post_type='.get_query_var('post_type');
				}
				wp_get_archives($params); 
		    ?>
			</ul>
		</div>
	</div>
</div>


	<main role="main">
		<!-- section -->
		<section>

			<h1><?php echo sprintf( __( '%s Search Results for ', 'html5blank' ), $wp_query->found_posts ); echo get_search_query(); ?></h1>

			<?php get_template_part('loop'); ?>

			<?php get_template_part('pagination'); ?>

		</section>
		<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
