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
    echo "</ul><button id=\"logoutButton\" onclick=\"logout();\">Logout</button>";
} else {
    
?>
<span id="loginOverlay"></span>
<form id="loginForm" action="<?php echo admin_url( "admin-ajax.php" )?>">
  <input type="hidden" name="action" value="rwnz_login"/>
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="text" class="form-control" id="loginUsername" aria-describedby="emailHelp" placeholder="Enter email" tabindex="100" name="u">
    <small id="emailHelp" class="form-text text-muted">Not a member? <a href="signup">Join today</a>.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="loginPassword" placeholder="Password" tabindex="101" name="p">
    <small id="passwordHelp" class="form-text text-muted"><a href="forgotten">Forgotten password?</a>.</small>
  </div>
  <button id="loginSubmit" type="submit" class="btn btn-primary" tabindex="102">Login</button>
</form>
<script>
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