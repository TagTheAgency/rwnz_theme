<?php get_header(); ?>
<?php 
$page_colour = get_post_meta(get_the_ID(), 'page-colour-theme', true);
$header_content = get_the_excerpt();
?>
<p>CSJM Header above, then header content below with id <?php echo get_the_ID() ?></p>
	<section role="header" class="header">
		<!-- section -->
		<section class="mainStory" style="background-color: <?php echo $page_colour;?>; position: relative;">
			<div class="header-image-wrapper">
    			<div class="header-image-inner"><img class="img" src="<?php the_post_thumbnail_url('page-header'); ?>" /></div>
			</div>
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

	<p> And now the woo content</p>
	<?php woocommerce_content(); ?>

	
    				
	

<?php get_footer(); ?>
