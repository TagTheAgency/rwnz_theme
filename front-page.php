<?php get_header('home'); ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.11&appId=1641844519171679&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

! function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (!d.getElementById(id)) {
        js = d.createElement(s);
        js.id = id;
        js.src = "//platform.twitter.com/widgets.js";
        fjs.parentNode.insertBefore(js, fjs);
    }
}(document, "script", "twitter-wjs");
</script>

<div class="container-fluid">
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
	<h1 class="homepage-section">Services</h1>
	<div class="row">
	<div class="col-lg-3 col-sm-6"><h1>Bursaries</h1>
	<div class="homepage-services-bursaries image-box image-box-square"></div>
	</div>
	<div class="col-lg-3 col-sm-6">
	<h1>Directory</h1>
<div class="homepage-services-directory image-box image-box-square"></div>
	</div>
	<div class="col-lg-6 col-sm-12">
	<h1>Women in farming</h1>
<div class="homepage-services-womeninfarming image-box image-box-1-in-2"></div>
	</div>
</div>

</div>

<div class="homepage-row homepage-partners">
	<h1 class="homepage-section">Partners</h1>
	<div class="row">
		<div class="col-md-3">
		<img src="<?php echo get_template_directory_uri(); ?>/img/partners/1.png"/>
		</div>
		<div class="col-md-3">
		<img src="<?php echo get_template_directory_uri(); ?>/img/partners/2.png"/>
		</div>
		<div class="col-md-3">
		<img src="<?php echo get_template_directory_uri(); ?>/img/partners/3.png"/>
		</div>
		<div class="col-md-3">
		<img src="<?php echo get_template_directory_uri(); ?>/img/partners/4.png"/>
		</div>
	</div>
</div>

<div class="homepage-row homepage-social">

	<h1 class="homepage-section">Social Media</h1>
	<div class="row">
		<div class="col-md-6 fb-column">
<div class="fb-page" data-href="https://www.facebook.com/ruralwomennz" data-tabs="timeline" data-width="500" data-height="300" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/ruralwomennz" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/ruralwomennz">Rural Women New Zealand</a></blockquote></div>		
</div>
		<div class="col-md-6">
<div id="twitter-feed"> <a class="twitter-timeline" href="https://twitter.com/ruralwomennz" data-widget-id="408213811233976320">Tweets by @RuralWomenNZ</a>

</div>
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
