<!-- login -->
<?php if (is_logged_in()) { ?>
	<a href="members" class="nav-link">Members</a>
<?php } else { ?>
	<a href="login" class="login-popup nav-link" data-toggle="modal" data-target="#loginModal">Login</a>
	
	<script>

	$(function() {
		console.log($("#loginForm"));
		$('#loginForm').submit(handleLogin);
	});

	function handleLogin(e) {
		console.log('submitting');

		var url = jQuery(this).attr('action');

		jQuery('#loginButton').prop('disabled', true);
		jQuery('#loginButton').html('Authenticating... <i class="fa fa-circle-o-notch fa-spin "></i>');

		//jQuery('#loginOverlay').addClass('overlay');

		jQuery.ajax({
			type: "POST",
			url: url,
			data: jQuery("#loginForm").serialize(), 
			success: function(data, status, xhr) {
		//		jQuery('#loginOverlay').removeClass('overlay');

				if (xhr.status != 200) {
					failedLogin();
					
		            return;
				}
				
				var loginData = JSON.parse(data);
				if (loginData.error) {
					failedLogin();
		            return;
				}
				var bits = loginData.body;
				var links = loginData.links;
				if (xhr.status == 200) {
					console.log(bits.firstName);
					jQuery('#loginButton').html('Authenticated. Forwarding.');
					location.href="<?php echo get_site_url() ?>/members";
					return;					
							
				}

	            jQuery('#loginButton').html('Login');
	            jQuery('#loginButton').prop('disabled', false);

			},
			error: function() {
				failedLogin()
			}
		});

	    e.preventDefault();
	};
	
	function failedLogin() {
		var failedLogin = '<div id="failedLogin" class="alert alert-danger" role="alert" style="font-size:0.9em">Invalid username or password. <a href="#" class="alert-link">Forgotten your password?</a>.</div>';

		jQuery('#failedLogin').remove();
		jQuery('#loginBody').prepend(failedLogin);
		jQuery('#loginPassword').addClass('is-invalid');
		jQuery('#loginUsername').addClass('is-invalid');
		jQuery('#loginButton').html('Login');
	    jQuery('#loginButton').prop('disabled', false);
	}

	</script>
	
<?php } ?>
<!-- /login -->
