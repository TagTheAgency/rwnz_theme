<?php get_header(); ?>
	
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
