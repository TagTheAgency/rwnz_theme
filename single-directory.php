<?php get_header(); ?>

<?php 
$terms = get_terms( 'business_directory', array(
    'hide_empty' => false,
) );
?>	

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-9">
			<article class="news_archive">
				<div class="page-header-wrapper">
					<h1><?php the_title();?></h1>
				</div>
				<?php while(have_posts()): the_post(); ?>
				<?php the_content(); ?>
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
