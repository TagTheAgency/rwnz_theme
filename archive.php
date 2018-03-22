<?php get_header(); ?>


<?php 
$page_colour = '#00aba0';//get_post_meta(get_the_ID(), 'page-colour-theme', true);
$header_content = apply_filters('the_content', get_the_excerpt());

$archive_title = "News Archive";
$archive_sub_title = get_the_archive_title();

if (get_query_var('post_type') && get_query_var('post_type') == 'submission') {
    $archive_title = "Submissions Archive";
}

?>

	<section role="header" class="header">
		<section class="mainStory header-content-wrapper">
			<div class="header-image-wrapper">
    			<div class="header-image-inner"><img class="img" src="<?php if (has_post_thumbnail('')) { the_post_thumbnail_url('page-header'); } else { echo get_theme_file_uri('/img/placeholderthumbnail.png'); } ?>" /></div>
			</div>
			<div class="page-title-container">
				<h1><?php echo $archive_title ?></h1>
			</div>
		</section>
	</section>


<style>
article.news_archive a, article.news_archive a:hover {
	color: <?php echo $page_colour?>;
}
</style>

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


<?php get_footer(); ?>
