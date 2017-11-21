<?php get_header(); ?>
<?php 
$page_colour = get_post_meta(get_the_ID(), 'page-colour-theme', true);
$header_content = get_the_excerpt();
?>
	<section role="header" class="header">
		<!-- section -->
		<section class="mainStory" style="background-color: <?php echo $page_colour;?>; position: relative;">
			<div class="header-image-wrapper">
    			<div class="header-image-inner"><img class="img" src="<?php the_post_thumbnail_url('page-header'); ?>" /></div>
			</div>

		<!-- img src="<?php the_post_thumbnail_url('page-header'); ?>" class="feature-image" style="width: 60%; margin-left: 5%; margin-top:2%; margin-bottom: -2%"/ --> 
		<div id="page-header">
			<?php include( locate_template( 'searchform.php', false, false ) );?> 
        	<div class="excerpt_content">
				<h1 style="color:white;"><?php the_title()?></h1>
		        <?php echo $header_content; ?>
		    </div>
        </div>	
		
		</section>
		<!-- /section -->
	</section>
	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

            			<!-- article -->
            			<article id="post-<?php the_ID(); ?>"  ><!-- ?php post_class('two-column'); ? -->
            				<?php the_content(); ?>
            
            				<?php comments_template( '', true ); // Remove if you don't want comments ?>
            
            				<br class="clear">
            
            				<?php edit_post_link(); ?>
            
            			</article>
            			<!-- /article -->

	<?php endwhile; endif; ?>

	
    				
	<?php 
	
	$child_pages = new WP_Query( array(
	    'orderby'	=> 'menu_order',
	    'post_type'      => 'page', // set the post type to page
	    'post_parent'    => get_the_ID(),
	    //    'no_found_rows'  => true, // no pagination necessary so improve efficiency of loop
	    'order'	=> 'asc'
	) );
	
    if ($child_pages -> have_posts()) { ?>
    	<article>
    
	<?php 
	
	if ( $child_pages->have_posts() ) : while ( $child_pages->have_posts() ) : $child_pages->the_post();
    ?>	
		<div class="services subbox" style="border-top: 5px solid #00aba1; background-image:url('<?php the_post_thumbnail_url('large'); ?>');background-size:cover;position:relative;">
			<a href="<?php echo get_page_link(get_the_ID()); ?>"><span class="link" style="display: block; width: 100%; height: 100%; z-index: 10; position: absolute; top: 0; left: 0"></span></a>
			<div class="subHeading" style="background-color:#e6e6e8;height: 40px;width: 100%; left: 0; right: 0; margin: 0 auto; color:#00aba1; text-align: center; font-size: 1.4em; padding-top: 10px; text-transform: uppercase; font-weight: bold;"><?php the_title()?></div>
    	
    	</div>

<?php
endwhile; endif;  

wp_reset_postdata();

?>
   </article>
	<?php 
}
?>

<div class="container" style="margin-top: 100px;">
</div>

<script>
var docWidth = document.documentElement.offsetWidth;

[].forEach.call(
  document.querySelectorAll('*'),
  function(el) {
    if (el.offsetWidth > docWidth) {
      console.log(el);
    }
  }
);
</script>

<?php get_footer(); ?>
