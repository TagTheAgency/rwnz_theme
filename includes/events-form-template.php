<form id="eventForm"> 
  <div class="form-group row" >
    <label for="eventName" class="col-sm-2 col-form-label">Event name</label>
    <div class="col-sm-10">
    <input type="text" class="form-control" id="eventName" aria-describedby="eventNameHelp" placeholder="Enter event name">
    </div>
  </div>
  <div class="form-group row">
    <label for="eventDate" class="col-sm-2 col-form-label">Event date</label>
	<div class="col-sm-10">
    <input type="date" class="form-control" id="eventDate" placeholder="Event date">
    </div>
  </div>
  <div class="form-group row">
    <label for="eventLocation" class="col-sm-2 col-form-label">Event location</label>
	<div class="col-sm-10">
	    <input type="text" class="form-control" id="eventLocation" placeholder="Start typing an address" aria-describedby="addressHelp">
    		<small id="addressHelp" class="form-text text-muted">Start typing an address then select from the dropdown.</small>
    </div>
  </div>
  <div class="form-group row">
  	<label for="eventName" class="col-sm-2 col-md-2 col-form-label">Your name</label>
	<div class="col-sm-10 col-md-4"><input type="text" class="form-control" id="eventName" placeholder="Enter your name" ></div>
  	<label for="eventName" class="col-md-2 col-sm-2 col-form-label">Contact number</label>
	<div class="col-md-4 col-sm-10"><input type="text" class="form-control" id="eventName" placeholder="Enter a contact number" ></div>
  </div>

  <div class="form-group row">
    <label for="eventEmail" class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="eventEmail" placeholder="Enter your email" aria-describedby="emailHelp" >
      <small id="emailHelp" class="form-text text-muted">Please supply your email address so we can contact you if we have any queries about this event.</small>
    </div>
  </div>

  <div class="form-group row">
    <label for="eventDescription" class="col-sm-2 col-form-label">Description</label>
    <div class="col-sm-10">
    <textarea class="form-control" id="eventDescription" rows="3"></textarea>    
    <small id="descriptionHelp" class="form-text text-muted">Enter a brief description of your event.</small>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Add event</button>
</form>

<script>
$(function() {
    autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('eventLocation')),
        {types: ['geocode'], componentRestrictions: {country: "nz"}});
});
</script>