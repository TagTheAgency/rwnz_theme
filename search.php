<?php get_header(); ?>

<div class="container-fluid">
	<div class="row blog_summary">
		<div class="col-sm-9">
			<article class="news_archive">
				<div class="page-header-wrapper">
					<h1><?php echo sprintf( __( '%s Search Results for ', 'html5blank' ), $wp_query->found_posts ); echo get_search_query(); ?></h1>
					<?php if ($wp_query->found_posts > 8) {
					   get_template_part('pagination'); 
					} ?>
				</div>
				<?php if (have_posts()): ?>
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
				<?php if ($wp_query->found_posts > 10) {
            		   get_template_part('pagination'); 
            		} ?>
            		<?php else: ?>
            		<p>No results were found for that search.</p>
            		<?php endif; ?>
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


<?php get_footer(); ?>
