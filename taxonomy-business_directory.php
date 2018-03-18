<?php get_header(); ?>


<?php 
$page_colour = '#00aba0';//get_post_meta(get_the_ID(), 'page-colour-theme', true);
$header_content = apply_filters('the_content', get_the_excerpt());

$terms = get_terms( 'business_directory', array(
    'hide_empty' => false,
) );


?>
<?php rwnz_page_header('Business Directory'/*get_the_archive_title()*/, wp_get_attachment_image_src( get_option( 'business-directory-featured-image' ), 'page-header' )[0]); ?>


<div class="container-fluid">
	<div class="row blog_summary">
		<div class="col-sm-9">
			<article class="news_archive">
				<div class="page-header-wrapper">
					<h1><?php the_archive_title() ?></h1>
				</div>
				<?php while(have_posts()): the_post(); ?>
					<?php 
						$mobile = get_post_meta(get_the_ID(), 'mobile', true);
						$website = get_post_meta(get_the_ID(), 'website', true);
						$phone = get_post_meta(get_the_ID(), 'phone', true);
						$address = get_post_meta(get_the_ID(), 'address', true);
						$logo = get_post_meta(get_the_ID(), 'logo', true);
					?>
					<div class="post-content-wrapper">
						<a href="<?php the_permalink()?>"><span class="link"></span></a>
						<div class="post-image-thumb">
							<?php if ($logo ): ?>
							<img src="<?php echo wp_get_attachment_url($logo) ?>"/>
							<?php else: ?>
							<img src="<?php echo get_theme_file_uri('/img/placeholderthumbnail.png')?>" alt="">
							<?php endif; ?>
						</div>
						<div class="post-list-info">
							<div>
								<h2 class="post-list-title"><a href="<?php the_permalink()?>"><?php the_title() ?></a></h2>
								<p><?php the_excerpt() ?></p>
							</div>
						</div>
					</div>
				<?php endwhile;?>
			</article>
		</div>
		<div class="col-sm-3 archive-wrapper" style="padding-right: 40px; margin-top: 50px;">
			<h2>Categories</h2>
			<?php 
            $term_id = get_queried_object_id();
            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                $count = count( $terms );
                $i = 0;
                $term_list = '<ul class="archive">';
                foreach ( $terms as $term ) {
                    $i++;
                    $term_list .= '<li><a ' . ($term->term_id == $term_id ? ' class="active"' : '') . '" href="' . esc_url( get_term_link( $term ) ) . '">' . $term->name . '</a></li>';
                    if ( $count == $i ) {
                        $term_list .= '</ul>';
                    }
                }
                echo $term_list;
            }
            ?>
			
		</div>
	</div>
</div>



<?php get_footer(); ?>
