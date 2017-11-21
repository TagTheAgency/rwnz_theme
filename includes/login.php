<?php 	

if ($_SESSION["member_name"] != null) {
    echo "<p>You are logged in as " . $_SESSION["member_name"] . "</p><button id=\"logoutButton\" onclick=\"logout();\">Logout</button>";
} else {
    
?>
<span id="loginOverlay"></span>
<form id="loginForm" action="<?php echo admin_url( "admin-ajax.php" )?>">
  <input type="hidden" name="action" value="rwnz_login"/>
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" tabindex="100" name="u">
    <small id="emailHelp" class="form-text text-muted">Not a member? <a href="signup">Join today</a>.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" tabindex="101" name="p">
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
			var bits = JSON.parse(data);
			if (xhr.status == 200) {
				console.log(bits.firstName);
				jQuery('#loginSubmit').html('Authenticated. Welcome.');
				jQuery('#login_dropdown').html("<p>You are logged in as " + bits.firstName + " " + bits.lastName + ".</p><button id='logoutButton' onclick='logout();'>Logout</button>");
			} else {

			}

            console.log(data); 
            jQuery('#loginSubmit').html('Login');
            jQuery('#loginSubmit').prop('disabled', false);

		}
	});

    e.preventDefault();
});


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