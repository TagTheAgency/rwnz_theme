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
		<div style="position: absolute; top: 20px;width: 100%; padding-right:20px;">
			<div class="row" style="padding-top: 60px;padding-bottom: 40px;">
				<div class="col-sm-6">

				<a href="<?php echo get_site_url()?>">
				<img src="<?php echo get_theme_file_uri('/img/rural-women-logo-white.png')?>" style="width:200px; margin-top: -40px"/>
				</a>
				</div>
				<div class="col-sm-6" style="text-align: right; color: white;">
					<div id="menu" style=" position:relative; display: inline-block;padding-right: 5px;">
                		<div id="showmenu">
                		<i class="fa fa-bars fa-3" style="font-size: 2em;vertical-align: -23%;padding-right: 10px" aria-hidden="true"></i><b>MENU</b>
                		</div>
                		<div class="dropdown" style="width: 150px; right: 70%;">
                			<ul>
                				<li>Events</li>
                				<li>Shop non members</li>
                				<li>services</li>
                				<li>blog posts</li>
                				<li>social media feed</li>
                			</ul>
                		</div>
            		</div>
            		<script>
            		(function($) {
            		$(document).ready(function() {
            		    $('#showmenu').click(function(e) {
            		    	e.stopPropagation();
            		        $('.dropdown').slideToggle("fast");
            		    });
            		    $('.dropdown').click(function(e) {
            		    	e.stopPropagation();
            		    });
            		    $(document).click(function(e) {
            		    	$('.dropdown').slideUp("fast");
            		    });
            		});
            		})(jQuery);
            		</script>
				<i class="fa fa-user" aria-hidden="true" style="padding-right: 5px;display:inline-block"></i>
				<i class="fa fa-search" aria-hidden="true" style="padding-right: 5px;;display:inline-block"></i>
				<i class="fa fa-shopping-cart" aria-hidden="true" style="padding-right: 5px;display:inline-block"></i>
				</div>
			</div>
		</div>
		
		
		

			
			<!-- /header -->
