<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
		<link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
		<link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">

		<?php wp_head(); ?>
		<script>
		// conditionizr.com
		// configure environment tests
		conditionizr.config({
			assets: '<?php echo get_template_directory_uri(); ?>',
			tests: {}
		});
		</script>

	</head>
	<body <?php body_class(); ?>>


		<!-- wrapper -->
		<div class="wrapper">
		<div style="position: absolute; top: 0px;width: 100%;"> 
			<div class="row home-nav-row" >
				<div class="col-md-6 order-1 order-md-2" style="text-align: right; color: white;">
					<div class="home-page-header-menu">
						<div id="menu" style=" position:relative; display: inline-block;padding-right: 5px;">
							<div id="showmenu">
							<i class="fa fa-bars" style="padding-right: 10px" aria-hidden="true"></i><b>MENU</b>
							</div>
							<div class="dropdown" style="width: 150px; right: 65%;" id="menu_dropdown">
									<?php wp_nav_menu( array(
										'theme_location'    => 'header-menu',
										'container'         => false,
										'menu_id'           => '',
										'echo'              => true,
										'depth'             => 1
									)); ?>
							</div>
						</div>


						<i class="fa fa-user" aria-hidden="true" style="padding-right: 5px;display:inline-block" id="login_menu"></i>
						<i class="fa fa-search" aria-hidden="true" style="padding-right: 5px;;display:inline-block"></i>
						<i class="fa fa-shopping-cart" aria-hidden="true" style="padding-right: 5px;display:inline-block"></i>
						<?php include( get_template_directory().'/includes/login.php');?>
						
					</div>
				</div>
				<div class="col-md-6 order-2 order-md-1 home-logo-col">
					<a href="<?php echo get_site_url()?>">
					<img src="<?php echo get_theme_file_uri('/img/rural-women-logo-white.png')?>" style="width:300px; margin-top: -40px"/>
					</a>
				</div>

			</div>
		</div>
		<script>
			(function($) {
			$(document).ready(function() {
				$('#showmenu').click(function(e) {
					$('#login_dropdown').slideUp("fast");
					e.stopPropagation();
					$('#menu_dropdown').slideToggle("fast");
				});
				$('#login_menu').click(function(e) {
					$('#menu_dropdown').slideUp("fast");
					e.stopPropagation();
					$('#login_dropdown').slideToggle("fast");
				});
				$('.dropdown').click(function(e) {
					e.stopPropagation();
				});
				$(document).click(function(e) {
					if(!$(e.target).hasClass('solid') )
					$('.dropdown').slideUp("fast");
				});
			});
			})(jQuery);
		</script>
		
		

			
			<!-- /header -->
