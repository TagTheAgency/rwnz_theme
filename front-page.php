<?php get_header('home'); ?>
<div class="fullscreen-image" style="background-image: url('<?php the_post_thumbnail_url('full'); ?>'); background-size: cover; margin-bottom: 100px;">

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
