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
	
	$child_pages = new WP_Query( array(
	    'orderby'	=> 'menu_order',
	    'post_type'      => 'page', // set the post type to page
	    'post_parent'    => get_the_ID(),
	    //    'no_found_rows'  => true, // no pagination necessary so improve efficiency of loop
	    'order'	=> 'asc'
	) );
	
	
	if ( $child_pages->have_posts() ) : while ( $child_pages->have_posts() ) : $child_pages->the_post();
        if ($count % 3 == 0) {
            ?><div class="homepage_grid_row clearfix"><?php 
        }
        
        $page_colour = get_post_meta(get_the_ID(), 'page-colour-theme', true);
        if ($page_colour) {
            $rgb = hex2RGB($page_colour);
            $rgba = 'rgba('.$rgb['r'].','.$rgb['g'].','.$rgb['b'].',0.7)';
        } else {
            $rgba = 'rgba(116, 182, 74, 0.85)';
        }
	?>	
		
		<div class="homepage_grid bg <?php echo $widths[$count]?>" style="background-image:linear-gradient(<?php echo $rgba?>,<?php echo $rgba?>),url('<?php the_post_thumbnail_url('large'); ?>');">
			<a href="<?php echo get_page_link(get_the_ID()); ?>"><span class="link" style="display: block; width: 100%; height: 100%; z-index: 10; position: absolute; top: 0; left: 0;"></span></a>
			<div class="content">
				<a href="<?php echo get_page_link(get_the_ID()); ?>" style="color: white; text-decoration: none;"><?php the_title()?></a>
			</div>
		</div>
		
		<?php if ($count % 3 == 2) { ?></div><?php } 
		$count++;
		
		?>

<?php
endwhile; endif;  

wp_reset_postdata();
?>


<div class="container" style="margin-top: 100px;">

</div>

<!--  php get_sidebar(); -->

<?php get_footer(); ?>
