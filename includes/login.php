<div class="dropdown" id="login_dropdown">
<?php 	

if ($_SESSION["member_name"] != null) {
    echo "<p>You are logged in as " . $_SESSION["member_name"] . "</p>";
    echo "<ul>";
    $links = login_links();
    foreach ($links as $link) {
        $href = $link['href'];
        $title = $link['link'];
        echo "<li><a href=\"$href\">$title</a></li>";
    }
    echo "</ul><button id=\"logoutButton\" onclick=\"logout();\">Logout</button></div>";
} else {
    
?>
<span id="loginOverlay"></span>
<form id="loginForm" action="<?php echo admin_url( "admin-ajax.php" )?>">
  <input type="hidden" name="action" value="rwnz_login"/>
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="text" class="form-control" id="loginUsername" aria-describedby="emailHelp" placeholder="Enter email" tabindex="100" name="u">
    <small id="emailHelp" class="form-text text-muted">Not a member? <a id="createAccountLink" href="#signupModal" data-toggle="modal">Join today</a>.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="loginPassword" placeholder="Password" tabindex="101" name="p">
    <small id="passwordHelp" class="form-text text-muted"><a id="forgottenPasswordLink" href="#forgottenPasswordModal" data-toggle="modal" data-target="#forgottenPasswordModal">Forgotten password?</a>.</small>
  </div>
  <button id="loginSubmit" type="submit" class="btn btn-primary" tabindex="102">Login</button>
</form>

</div>

<!-- Forgotten password Modal -->
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
<!-- Sign up Modal -->

<script>
jQuery().ready(function() {
	jQuery('#createAccountLink').click(function(evt) {
		evt.preventDefault();
		$('#login_dropdown').slideUp("fast");
		$('#signupModal').modal();
	});
	jQuery("#forgottenPasswordLink").click(function(evt) {
		console.log('clicky');
		evt.preventDefault();
		$('#login_dropdown').slideUp("fast");
		$('#forgottenPasswordModal').modal();

	});
	jQuery('#resetPasswordForm').on('submit', submitPasswordReset);
	jQuery('#resetPasswordButton').click(submitPasswordReset);

	jQuery('#becomeMemberForm').on('submit', becomeMember);
	jQuery('#becomeMemberButton').click(becomeMember);

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

function becomeMember(evt) {
	evt.preventDefault();
	jQuery.ajax({
		type: "POST",
		url: '<?php echo admin_url( "admin-ajax.php" )?>',
		data: {
			"action":"rwnz_create_account", 
			"email" : document.getElementById('signupEmail').value, 
			"firstName" : document.getElementById('signupFirstName').value,
			"lastName" : document.getElementById('signupLastName').value,
			"subscription" : document.getElementById('signupSubscription').value
		},
		success: function(data, status, xhr) {
			console.log(data);
			console.log(JSON.parse(data));
		}
	});

}

jQuery("#loginForm").submit(function(e) {

	var url = jQuery(this).attr('action');

	jQuery('#loginSubmit').prop('disabled', true);
	jQuery('#loginSubmit').html('Authenticating... <i class="fa fa-circle-o-notch fa-spin "></i>');

	jQuery('#loginOverlay').addClass('overlay');

	jQuery.ajax({
		type: "POST",
		url: url,
		data: jQuery("#loginForm").serialize(), 
		success: function(data, status, xhr) {
			jQuery('#loginOverlay').removeClass('overlay');

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
				jQuery('#loginSubmit').html('Authenticated. Welcome.');

				var content = "<p>You are logged in as " + bits.firstName + " " + bits.lastName + ".</p>" +
					"<ul>";
				links.forEach(function(link) {
					content += "<li><a href=\"" + link.href + "\">" + link.link + "</a></li>";
				});
				content += "</ul><button id='logoutButton' onclick='logout();'>Logout</button>";
				
				jQuery('#login_dropdown').html(content);
						
			} else {
				
			}

            console.log(data); 
            jQuery('#loginSubmit').html('Login');
            jQuery('#loginSubmit').prop('disabled', false);

		},
		error: function() {
			failedLogin()
		}
	});

    e.preventDefault();
});
function failedLogin() {
	var failedLogin = '<div id="failedLogin" class="alert alert-danger" role="alert" style="font-size:0.9em">Invalid username or password. <a href="#" class="alert-link">Forgotten your password?</a>.</div>';

	jQuery('#failedLogin').remove();
	jQuery('#loginForm').prepend(failedLogin);
	jQuery('#loginPassword').addClass('is-invalid');
	jQuery('#loginUsername').addClass('is-invalid');
	jQuery('#loginSubmit').html('Login');
    jQuery('#loginSubmit').prop('disabled', false);
}

</script>
<?php 
} //end else
?>
<script>
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