<h3>Enter your details below to create an account and become a member</h3>
<form id="becomeMemberForm">
	<div class="form-group">
	    <label for="signupEmail">Email address</label>
	    <input type="email" class="form-control" id="signupEmail" aria-describedby="emailHelp" placeholder="Enter email">
	    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
	</div>
	<div class="form-group">
	    <label for="signupFirstName">First name</label>
	    <input type="text" class="form-control" id="signupFirstName" aria-describedby="emailHelp" placeholder="Enter first name">
	</div>
	<div class="form-group">
	    <label for="signupLastName">Last name</label>
	    <input type="email" class="form-control" id="signupLastName" aria-describedby="emailHelp" placeholder="Enter last name">
	</div>
	<select class="form-control" name="subscription" id="signupSubscription">
		<option value="personal">RWNZ Membership - $50 Yearly</option>
		<option value="corporate">RWNZ Corporate Membership - $100 Yearly</option>
		<option value="none">No membership, just create an account</option>
	</select>
</form>
<script>

jQuery().ready(function() {
	jQuery('#becomeMemberForm').on('submit', becomeMember);
	jQuery('#becomeMemberButton').click(becomeMember);

});

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

</script>