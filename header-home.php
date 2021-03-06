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
		<div class="fluid-wrapper">
		<div style="position: absolute; top: 0px;width: 100%;max-width:100%" class="container">

		<nav class="navbar navbar-expand-lg navbar-dark" style="width: 95%">
				<a class="navbar-brand"
					href="<?php echo get_site_url()?>"> <img
					src="<?php echo get_theme_file_uri('/img/rwnz-logo-white-300.png')?>"
					class="page-logo home" />
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse"
					data-target="#navbarSupportedContent"
					aria-controls="navbarSupportedContent" aria-expanded="false"
					aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">

					</ul>

                    <?php
                        $menu = wp_nav_menu( array(
                          'theme_location' => 'header-menu',
                          'container'      => false,
                          'menu_class'     => 'nav navbar-nav',
                          'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                          'depth'          => 2,
                          'walker'         => new bootstrap_4_walker_nav_menu(),
                          'echo'           => true
                       ) );
                    ?>
					<ul class="navbar-nav">
				       <?php include( locate_template( 'loginform.php', false, false ) ); ?>
					   <li id="search" class="nav-item">
							<?php include( locate_template( 'searchform.php', false, false ) );?>
					   </li>
				   </ul>
                </div>

			</nav>

		</div>


			<!-- /header -->
	<div class="fullscreen-image" style="background-image: url('<?php the_post_thumbnail_url('full'); ?>'); background-size: cover; margin-bottom: 20px; background-position: center">

	</div>
	</div>
	<div class="wrapper">
