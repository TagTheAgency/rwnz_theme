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
<?php if (have_posts()): while (have_posts()) : the_post(); ?>
<?php the_content(); ?>
<?php endwhile; endif; ?>

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
