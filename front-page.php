<?php get_header('home'); ?>

<div class="container">
<div class="row homepage-row">
	<div class="col-lg-8 dynamic">
		<div class="homepage-story">
		<h1>Events</h1>
		<?php 
		$upcomingEvents = get_next_event();
		if (empty($upcomingEvents)) {
			echo '<p>There are no events upcoming.</p>';
		} else {
			$event = $upcomingEvents[0];
			$name = $event['name'];
			$description = $event['description'];
			echo "<h2>$name</h2>";
			echo "<div class=\"text\">$description</div>";
		}

		?>
		</div>
		<div class="homepage-story">
		<h1>News</h1>
			<?php
		    $args = array( 'numberposts' => '1' );
	    	$recent_posts = wp_get_recent_posts( $args );
	    	foreach( $recent_posts as $recent ){
		    	setup_postdata($recent['ID']);
				printf( '<h2>%1$s</h2><div class="text">%2$s</div>', apply_filters( 'the_title', $recent['post_title'], $recent['ID'] ),get_the_excerpt($recent['ID']));

		    }
		    wp_reset_postdata();
			?>
		</div>
		<div class="homepage-story">
		<h1>Submissions</h1>
		
		<?php
	    $args = array( 'numberposts' => '1' , 'post_type' => 'submission');
    	$recent_posts = wp_get_recent_posts( $args );
    	foreach( $recent_posts as $recent ){
	    	setup_postdata($recent['ID']);
			printf( '<h2>%1$s</h2><div class="text">%2$s</div>', apply_filters( 'the_title', $recent['post_title'], $recent['ID'] ),get_the_excerpt($recent['ID']));

	    }
	    wp_reset_postdata();
		?>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="homepage-links">
		<div class="homepage-link homepage-link-shop split">
			<span class="link"><a href="shop"></a></span>
			<h1>Shop</h1>
		</div>
		<div class="homepage-link homepage-link-erwa split">
			<span class="link"><a href="http://erwa.org.nz"></a></span>
			<h1>ERWA</h1>
		</div>
	</div>
		<div class="homepage-link homepage-link-aftersocks">
			<span class="link"><a href="http://aftersocks.org.nz"></a></span>
			<h1>Aftersocks</h1>
		</div>
	</div>
</div>

<div class="homepage-row homepage-services">
	<h1>Services</h1>
	<div class="row">
	<div class="col-lg-3 col-sm-6">
Bursaries
	<div class="homepage-services-bursaries image-box image-box-square"></div>
	</div>
	<div class="col-lg-3 col-sm-6">
Directory
<div class="homepage-services-directory image-box image-box-square"></div>
	</div>
	<div class="col-lg-6 col-sm-12">
Women in farming
<div class="homepage-services-womeninfarming image-box image-box-1-in-2"></div>
	</div>
</div>

</div>

<div class="row homepage-row">
	<div class="col-md-8 dynamic">
		
	</div>
	<div class="col-md-4">
	
	</div>
</div>
</div>


<!--  php get_sidebar(); -->

<?php get_footer(); ?>
