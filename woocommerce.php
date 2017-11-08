<?php get_header(); ?>
<?php 
$page_colour = get_post_meta(get_the_ID(), 'page-colour-theme', true);
$header_content = get_post_meta(get_the_ID(), '_rwnz_extra_content', true);
?>
	<section role="header" class="header">
		<!-- section -->
		<section class="mainStory" style="background-color: <?php echo $page_colour;?>; position: relative;">
		<img src="<?php the_post_thumbnail_url('page-header'); ?>" style="width: 60%; margin-left: 5%; margin-top:2%; margin-bottom: -2%"/>
		<div id="page-header" style="position: absolute; padding-left: 70%;  top:8%;width: 90%">
			<?php include( locate_template( 'searchform.php', false, false ) );?> 
		<h1 style="color:white;"><?php the_title()?></h1>
        <?php echo $header_content; ?>
        </div>	
		
		</section>
		<!-- /section -->
	</section>
	<?php woocommerce_content(); ?>

	
    				
	

<?php get_footer(); ?>
