<?php get_header('home'); ?>


<div class="row homepage-row">
	<div class="col-md-8 dynamic">
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

//		echo '<p><a href="events">See all events</a></p>';
		?>
	</div>
	<div class="col-md-4">
		<div class="homepage-link homepage-link-shop">
			<span class="link"><a href="shop"></a></span>
			<h1>Shop</h1>
		</div>
	</div>
</div>

<div class="row homepage-row">
	<div class="col-md-8 dynamic">
		<h1>News</h1>
		<?php
	    $args = array( 'numberposts' => '1' );
    	$recent_posts = wp_get_recent_posts( $args );
    	foreach( $recent_posts as $recent ){
	    	setup_postdata($recent['ID']);
        	/*printf( 
        		'<div class="left"><img src="%1$s"/><h2><a href="%2$s">%3$s</a></h2><h3>%4$s</h3>%5$s</div>', 
        		get_the_post_thumbnail_url($recent['ID'], 'thumbnail'), 
        		esc_url( get_permalink( $recent['ID'] ) ), 
        		apply_filters( 'the_title', $recent['post_title'], $recent['ID'] ),
        		get_the_date('', $recent['ID']),
        		get_the_excerpt($recent['ID'])
        		);*/
			printf( '<h2>%1$s</h2><div class="text">%2$s</div>', apply_filters( 'the_title', $recent['post_title'], $recent['ID'] ),get_the_excerpt($recent['ID']));

	    }
	    wp_reset_postdata();
		?>
	</div>
	<div class="col-md-4">
		<div class="homepage-link homepage-link-erwa">
			<span class="link"><a href="http://erwa.org.nz"></a></span>
			<h1>ERWA</h1>
		</div>
	</div>
</div>

<div class="row homepage-row">
	<div class="col-md-8 dynamic">
		<h1>Submissions</h1>
		
		<?php
	    $args = array( 'numberposts' => '1' , 'post_type' => 'submission');
    	$recent_posts = wp_get_recent_posts( $args );
    	foreach( $recent_posts as $recent ){
	    	setup_postdata($recent['ID']);
        	/*printf( 
        		'<div class="left"><img src="%1$s"/><h2><a href="%2$s">%3$s</a></h2><h3>%4$s</h3>%5$s</div>', 
        		get_the_post_thumbnail_url($recent['ID'], 'thumbnail'), 
        		esc_url( get_permalink( $recent['ID'] ) ), 
        		apply_filters( 'the_title', $recent['post_title'], $recent['ID'] ),
        		get_the_date('', $recent['ID']),
        		get_the_excerpt($recent['ID'])
        		);*/
			printf( '<h2>%1$s</h2><div class="text">%2$s</div>', apply_filters( 'the_title', $recent['post_title'], $recent['ID'] ),get_the_excerpt($recent['ID']));

	    }
	    wp_reset_postdata();
		?>
	</div>
	<div class="col-md-4">
		<div class="homepage-link homepage-link-aftersocks">
			<span class="link"><a href="http://aftersocks.org.nz"></a></span>
			<h1>Aftersocks</h1>
		</div>
	</div>
</div>

<!--  div class="homepage_grid_row clearfix">
	<div class="homepage_grid rectangle"></div>
	<div class="homepage_grid square"></div>
	<div class="homepage_grid square"></div>
</div>
<div class="homepage_grid_row clearfix">
	<div class="homepage_grid square"></div>
	<div class="homepage_grid square"></div>
	<div class="homepage_grid rectangle"></div>
</div -->

<?php 
	$count = 0;
	
	$widths = array('rectangle', 'square', 'square', 'square', 'square', 'rectangle');
	$overlays = array('rgba(116, 182, 74, 0.85)','rgba(32,196,244,0.85)','rgba(116, 182, 74, 0.85)','rgba(32,196,244,0.85)','rgba(116, 182, 74, 0.85)','rgba(32,196,244,0.85)');
	

	$menuLocations = get_nav_menu_locations(); // Get our nav locations (set in our theme, usually functions.php)

	$menuID = $menuLocations['frontpage-menu']; // Get the  menu ID

	$primaryNav = wp_get_nav_menu_items($menuID);

	foreach ( $primaryNav as $navItem ) {
		$post_id = get_post_meta( $navItem->ID, '_menu_item_object_id', true );

		if ($count % 3 == 0) {
            ?><div class="homepage_grid_row clearfix"><?php 
        }
		$page_colour = get_post_meta($post_id, 'page-colour-theme', true);
        if ($page_colour) {
            $rgb = hex2RGB($page_colour);
            $rgba = 'rgba('.$rgb['r'].','.$rgb['g'].','.$rgb['b'].',0.4)';
        } else {
            $rgba = 'rgba(116, 182, 74, 0.85)';
        }

        ?>	

		<div class="homepage_grid bg <?php echo $widths[$count]?>" style="background-image:linear-gradient(<?php echo $rgba?>,<?php echo $rgba?>),url('<?php echo get_the_post_thumbnail_url($post_id, 'large'); ?>');">
			<a href="<?php echo get_page_link($post_id); ?>"><span class="link" style="display: block; width: 100%; height: 100%; z-index: 10; position: absolute; top: 0; left: 0;"></span></a>
			<div class="content">
				<a href="<?php echo get_page_link($post_id); ?>" style="color: white; text-decoration: none;"><?php echo get_the_title($post_id);?></a>
			</div>
		</div>
		
		<?php if ($count % 3 == 2) { ?></div><?php } 
		$count++;
		
		

	}
?>

<div class="container" style="margin-top: 100px;">

</div>

<!--  php get_sidebar(); -->

<?php get_footer(); ?>
