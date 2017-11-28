<?php /* Template Name: Business directory page */ get_header(); ?>


<?php 
$page_colour = '#00aba0';//get_post_meta(get_the_ID(), 'page-colour-theme', true);
$header_content = apply_filters('the_content', get_the_excerpt());

$terms = get_terms( 'business_directory', array(
    'hide_empty' => false,
) );


?>
	<section role="header" class="header">
		<section class="mainStory" style="background-color: <?php echo $page_colour;?>; position: relative;">
			<div class="header-image-wrapper">
    			<div class="header-image-inner"><img class="img" src="<?php echo wp_get_attachment_image_src( get_option( 'business-directory-featured-image' ), 'page-header' )[0]; ?>" /></div>
			</div>

		<!-- img src="<?php the_post_thumbnail_url('page-header'); ?>" class="feature-image" style="width: 60%; margin-left: 5%; margin-top:2%; margin-bottom: -2%"/ --> 
		<div id="page-header">
			<?php include( locate_template( 'searchform.php', false, false ) );?> 
        	<div class="excerpt_content">
				<h1 style="color:white;"><?php the_title()?></h1> 
		    </div>
        </div>	
		
		</section>
	</section>

<style>
article.news_archive a, article.news_archive a:hover {
	color: <?php echo $page_colour?>;
}
</style>

<?php 
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
    $count = count( $terms );
    $i = 0;
    $term_list = '<p class="my_term-archive">';
    foreach ( $terms as $term ) {
        $i++;
        $term_list .= '<a href="' . esc_url( get_term_link( $term ) ) . '" alt="' . esc_attr( sprintf( __( 'View all post filed under %s', 'my_localization_domain' ), $term->name ) ) . '">' . $term->name . '</a>';
        if ( $count != $i ) {
            $term_list .= ' &middot; ';
        }
        else {
            $term_list .= '</p>';
        }
    }
    echo $term_list;
}
?>
<main role="main">
<!-- section -->
<section>
	<?php if (have_posts()): while (have_posts()) : the_post(); ?>
		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<div class="bursaries">
				<div class="bursary row">
					<div class="col-md-6"><h3><?php the_title();?></h3>
						<div class="content"><?php the_content(); // Dynamic Content ?></div>
					</div>	
					<div class="col-md-6 ">
						<?php 
						$mobile = get_post_meta(get_the_ID(), 'mobile', true);
						$website = get_post_meta(get_the_ID(), 'website', true);
						$phone = get_post_meta(get_the_ID(), 'phone', true);
						$address = get_post_meta(get_the_ID(), 'address', true);
						$logo = get_post_meta(get_the_ID(), 'logo', true);
						if ($logo) {
							echo '<img src="'.wp_get_attachment_url($logo).'" style="max-height: 100px"/><br/>';
						}
						?>
						
						Contact: <?php echo get_post_meta(get_the_ID(), 'contact', true);?><br/>
						Email: <?php echo get_post_meta(get_the_ID(), 'email', true);?><br/>
						
						<?php
						if ($mobile) {
							echo "Mobile: " . $mobile . "<br/>";
						}
						if ($website) {
							if (substr( $website, 0, 4 ) === "http") {
							
							} else {
								$website = "http://" . $website;
							}
							echo 'Website: <a href="' . $website . '">' . $website . '</a><br/>';
						}
						if ($address) {
							echo "Address: " . $address . "</br>";
						}
						
						?>
					</div>

		</article>
		<!-- /article -->
	<?php endwhile; endif; ?>
	
	</section>
	<!-- /section -->
	</main>

<?php get_footer(); ?>

	



<?php get_footer(); ?>
