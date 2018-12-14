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

<!-- Mission statement goes here -->

	<div class="col-lg-8 dynamic">
		<div class="homepage-story">

		<h1>Events</h1>
		<?php
		$upcomingEvents = $rwnzEvents -> get_next_event();
		if (empty($upcomingEvents->events)) {
			echo '<div class="text">There are no events upcoming.</div>';
      echo '<div class="text">For more on our events and to register yours, <a href="events">please click here</a></div>';

		} else {
      error_log($upcomingEvents->events[0]);
			$event = $upcomingEvents->events[0];
			$name = $event['name'];
			$date = $event['date'];
			$datetime = DateTime::createFromFormat('Y-m-d\TH:i:s+', $date);
			$datetime->setTimezone(new DateTimeZone('Pacific/Auckland'));
			$formatted_date = $datetime->format("l dS F");//date("l ddS F", $datetime);
			$description = $event['description'];
			echo "<h2>$name - $formatted_date</h2>";
			echo "<div class=\"text\">$description</div>";
		}

		?>
		</div>
		<div class="homepage-story">
		<h1>News</h1>
		<?php
		$the_query = new WP_Query(array(
		    'post_type'         => 'post',
		    'posts_per_page'    => 1
		));

		while ( $the_query->have_posts() ) : $the_query->the_post();
		printf('<h2>%1$s</h2><div class="text">%2$s</div>', get_the_title(), get_custom_excerpt(300, 'content'));
        endwhile; wp_reset_postdata(); ?>

		</div>
		<div class="homepage-story">
		<h1>Submissions</h1>
		<?php
		$the_query = new WP_Query(array(
		    'post_type'         => 'submission',
		    'posts_per_page'    => 1
		));

		while ( $the_query->have_posts() ) : $the_query->the_post();
		printf('<h2>%1$s</h2><div class="text">%2$s</div>', get_the_title(), get_custom_excerpt(300, 'content'));
        endwhile; wp_reset_postdata(); ?>

		</div>
	</div>
	<div class="col-lg-4">
		<div class="homepage-links">

				<div>
					<div class="homepage-link homepage-link-national-conference">
						<a href="national-conference-2"><span class="link"></span></a>
						<h1>National Conference</h1>
					</div>

					<div class="homepage-link homepage-link-annual-summit">
						<a href="annual-summit"><span class="link"></span></a>
						<h1>Annual Summit</h1>
					</div>
				</div>

        		<div class="homepage-link homepage-link-erwa split">
        			<span class="link"><a href="http://erwa.org.nz"></a></span>
        		</div>
        	</div>
        	<div class="homepage-links">
        		<div class="homepage-link homepage-link-aftersocks">
        			<a href="http://aftersocks.nz"><span class="link"></span></a>
        			<h1>Aftersocks</h1>
        		</div>
        	</div>
	</div>
</div>

<div class="row homepage-row member-row" >
	<div class="col-md-6">
		<div class="homepage-link homepage-link-memberzone" style="height: 200px">
        			<a href="join-us"><span class="link"></span></a>
        			<h1>Become a member</h1>
        		</div>

	</div>
	<div class="col-md-6">
        		<div class="homepage-link homepage-link-memberzone" style="height: 200px">
        			<a href="members"><span class="link"></span></a>
        			<h1>Member Zone</h1>
        		</div>

        	</div>
</div>

<div class="homepage-row homepage-services">
	<?php
	$menu_name = 'services-menu';
    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
        $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
        $menu_items = wp_get_nav_menu_items($menu->term_id);

        $services = '<div class="row">';
        $idx = 0;
        foreach ( (array) $menu_items as $key => $menu_item ) {
            $title = $menu_item->title;
            $url = $menu_item->url;
            if ($idx < 2) {
                $services .= '<div class="col-lg-3 col-sm-6"><h1>' . $title . '</h1><div class="image-box image-box-square" style="background-image: url(' . get_the_post_thumbnail_url($menu_item->object_id, 'full') . ')"><a href="' . $url . '"><span class="link"></span></a></div></div>';
            } else {
                $services .= '<div class="col-lg-6 col-sm-12"><h1>' . $title . '</h1><div class="image-box image-box-1-in-2" style="background-image: url(' . get_the_post_thumbnail_url($menu_item->object_id, 'full') . ')"> <a href="' . $url . '"><span class="link"></span></a></div></div>';
            }
            $idx++;
        }

        $services .= '</div>';
        echo $services;
    } else {
        echo '<p>Please populate the services menu to list services here.</p>';
    }
    ?>

</div>

<div class="homepage-row homepage-partners">
	<h1 class="homepage-section">Partners</h1>
	<div class="row">
		<div class="col-md-3 col-sm-6">
		<img src="<?php echo get_template_directory_uri(); ?>/img/partners/Federated-Farmers-logo.jpg"/>
		</div>
		<div class="col-md-3 col-sm-6">
		<img src="<?php echo get_template_directory_uri(); ?>/img/partners/vocus-communications-logo.jpg"/>
		</div>
		<div class="col-md-3 col-sm-6">
		<img src="<?php echo get_template_directory_uri(); ?>/img/partners/NZI-logo.png"/>
		</div>
		<div class="col-md-3 col-sm-6">
		<img src="<?php echo get_template_directory_uri(); ?>/img/partners/4.png"/>
		</div>
	</div>
</div>

<div class="homepage-row homepage-social">

	<h1 class="homepage-section">Social Media</h1>
	<div class="row">
		<div class="col-md-6 fb-column">
<div class="fb-page" data-href="https://www.facebook.com/ruralwomennz" data-tabs="timeline" data-width="500" data-height="750" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/ruralwomennz" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/ruralwomennz">Rural Women New Zealand</a></blockquote></div>
</div>
<div class="col-md-6">
		<?php echo do_shortcode('[instagram-feed]'); ?>
		<div id="twitter-feed" style="margin-top: 30px;"> <a class="twitter-timeline" href="https://twitter.com/ruralwomennz" data-height="300" data-widget-id="408213811233976320">Tweets by @RuralWomenNZ</a>
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
