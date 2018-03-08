			<!-- footer -->
			</div>
			<div class="fluid-wrapper">
			<footer class="footer" role="contentinfo">

				<div class="container" style="padding-left:30px;">
					<div class="row">
						<div class="col-sm">
							<div class="social">
								<a href="#" id="fbshare"><i class="fa fa-lg fa-facebook"></i></a><a href="#" id="twittershare"><i class="fa fa-lg fa-twitter"></i></a><a href="#" id="lnshare"><i class="fa fa-lg fa-instagram"></i></a>
							</div>
						</div>
						<div class="col-sm btt-button">
							<span id="to-top"><i class="fa fa-lg fa-arrow-up"></i> Back To Top</span>
						</div>
					</div>
					<div class="row">
						<div class="col-sm">
							<h3>News</h3>
							<ul>
							<?php
							$next_args = array(
                        	    'post_type' => 'post',
                        	    'post_status' => 'publish',
                        	    'posts_per_page'=>6,
                        	    'order'=>'DESC',
                        	    'orderby'=>'date',
	                         );

                            	$query = new WP_Query( $next_args );
                            	while ( $query->have_posts() ) {
                            	        $query->the_post();
                            	        ?>
								<li><a href="<?php the_permalink()?>"><?php the_title()?></a></li>
							<?php
                            	}
							wp_reset_postdata();
							?>
							</ul>
						</div>
						<div class="col-sm">
							<h3>Events</h3>
							<ul>
								<li>Lorem ipsum</li>
								<li>Lorem ipsum</li>
							</ul>
						</div>
						<div class="col-sm">
							<h3>Members</h3>
							<ul>
								<li><a href="<?php echo get_site_url() ?>/members">Members area</a></li>
								<li><a href="<?php echo get_site_url() ?>/join-us">Become a member</a></li>
							</ul>
						</div>
						<div class="col-sm">
							<h3>Shop</h3>
							<ul>
								<li>Lorem ipsum</li>
								<li>Lorem ipsum</li>
							</ul>
						</div>
						<div class="col-sm">
							<h3>Services</h3>
							<ul>
								<li>Directory</li>
								<li>Business</li>
								<li>Women in farming</li>
								<li>Home care</li>
							</ul>
						</div>
						<div class="col-sm">
							<h3>Submissions</h3>
							<ul>
								<?php
							$next_args = array(
                        	    'post_type' => 'submission',
                        	    'post_status' => 'publish',
                        	    'posts_per_page'=>6,
                        	    'order'=>'DESC',
                        	    'orderby'=>'date',
	                         );

                            	$query = new WP_Query( $next_args );
                            	while ( $query->have_posts() ) {
                            	        $query->the_post();
                            	        ?>
								<li><a href="<?php the_permalink()?>"><?php the_title()?></a></li>
							<?php
                            	}
							wp_reset_postdata();
							?>
							</ul>
						</div>
					</div>
				</div>

			</footer>
			<!-- /footer -->
			<div><strong>Current template:</strong> <?php get_current_template( true ); ?></div>
		</div>
		<!-- /wrapper -->

		<?php wp_footer(); ?>

		<!-- analytics -->
		<script>
		(function(f,i,r,e,s,h,l){i['GoogleAnalyticsObject']=s;f[s]=f[s]||function(){
		(f[s].q=f[s].q||[]).push(arguments)},f[s].l=1*new Date();h=i.createElement(r),
		l=i.getElementsByTagName(r)[0];h.async=1;h.src=e;l.parentNode.insertBefore(h,l)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-XXXXXXXX-XX', 'yourdomain.com');
		ga('send', 'pageview');
		</script>

	</body>
</html>
