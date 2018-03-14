<!-- login -->
<?php if (is_logged_in()) { ?>
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" id="membersDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	Members
</a>
	    <div class="dropdown-menu" aria-labelledby="membersDropdown">
          <a class="dropdown-item" href="<?php echo get_site_url() ?>/members">Members zone</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" id="logoutLink">Logout</a>
        </div>
       
	<script>

	$(function() {
		$('#logoutLink').click(logout);
	});
	
	function logout() {
		jQuery.ajax({
			type: "POST",
			url: '<?php echo admin_url( "admin-ajax.php" )?>',
			data: {"action":"rwnz_logout"},
			success: function() {
				window.location.reload(false); 
			}
		});
	}
	
	</script>
</li>
<?php } else { ?>
<li class="nav-item">
	<a href="login" class="login-popup nav-link" data-toggle="modal" data-target="#loginModal">Login</a>
	
	<script>

	$(function() {
		console.log($("#loginForm"));
		$('#loginForm').submit(handleLogin);

		$("#forgottenPasswordLink").click(function(evt) {
			evt.preventDefault();
			$('#loginModal').modal('hide');
			$('#forgottenPasswordModal').modal();

		});

		jQuery('#resetPasswordForm').on('submit', submitPasswordReset);
		jQuery('#resetPasswordButton').click(submitPasswordReset);

	});

	function submitPasswordReset(evt) {
		evt.preventDefault();
		jQuery.ajax({
			type: "POST",
			url: '<?php echo admin_url( "admin-ajax.php" )?>',
			data: {"action":"rwnz_forgotten_password", "username" : document.getElementById('forgottenPasswordUsername').value},
			success: function(data, status, xhr) {
				if (data.length > 0) {
					var response = JSON.parse(data);
					if (response.code === 'NOT_FOUND') {
						$('#forgottenPasswordUsername').addClass('is-invalid');
					}
				} else {
					$('#forgottenPasswordBody').html("<p>We've sent you a link to reset your password</p>");
				}
			}
		});
	}

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
</li>
<?php } ?>
<!-- /login -->
