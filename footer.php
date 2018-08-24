			<!-- footer -->
				</div>
			</div>
			<div class="fluid-wrapper">
			<footer class="footer" role="contentinfo">

				<div class="container" style="padding-left:30px;">
					<div class="row">
						<div class="col-sm">
							<div class="social">
								<a href="http://www.facebook.com/ruralwomennz" id="fbshare"><i class="fa fa-lg fa-facebook"></i></a><a href="http://twitter.com/ruralwomennz" id="twittershare"><i class="fa fa-lg fa-twitter"></i></a>
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
							<h3><a href="<?php echo get_site_url() ?>/events/">Events</a></h3>

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

						</div>
						<div class="col-sm">
							<h3><a href="<?php echo get_site_url() ?>/scholarships-and-bursaries/">Services</a></h3>
							<ul>
								<li><a href="<?php echo get_site_url() ?>/scholarships-and-bursaries/business-directory/">Directory</a></li>
								<li><a href="<?php echo get_site_url() ?>/scholarships-and-bursaries/bursaries/">Bursaries</a></li>
								<li><a href="<?php echo get_site_url() ?>/scholarships-and-bursaries/women-in-farming/">Women in farming</a></li>
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
		</div>
		<!-- /wrapper -->

		<!-- modals -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <form id="loginForm" action="<?php echo admin_url( "admin-ajax.php" )?>">
  <input type="hidden" name="action" value="rwnz_login"/>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="text-align: left;" id="loginBody">
      <div class="form-group">
	      <label for="loginUsername">Username</label>
	      <input id="loginUsername" type="text" style="width: 100%;" name="u" class="form-control"/>
	      <small id="emailHelp" class="form-text text-muted">Not a member? <a id="createAccountLink" href="<?php echo get_site_url() ?>/join-us">Join today</a>.</small>

	  </div>
	  <div class="form-group">
	      <label for="loginPassword">Password</label>
	      <input id="loginPassword" type="password" style="width: 100%;" name="p" class="form-control"/>
		  <small id="passwordHelp" class="form-text text-muted"><a id="forgottenPasswordLink" href="#forgottenPasswordModal" data-toggle="modal" data-target="#forgottenPasswordModal">Forgotten password?</a>.</small>
	  </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" id="loginButton">Login</button>
      </div>
    </div>
  </div>
  </form>
</div>

<div class="modal fade" id="forgottenPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgottenPasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forgottenPasswordModalLabel">Forgotten your password?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="text-align: left;" id="forgottenPasswordBody">
        <form id="resetPasswordForm">
	      <label for="forgottenPasswordUsername">Enter your username below and we'll send you a reset link</label>
	      <input id="forgottenPasswordUsername" type="text" style="width: 100%;" name="forgottenPassword" class="form-control"/>
	      <div class="invalid-feedback">
    	    That isn't a valid username.
	      </div>
	    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="resetPasswordButton">Send reset link</button>
      </div>
    </div>
  </div>
</div>

		<!-- /modals -->
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
