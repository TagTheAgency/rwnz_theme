<form id="eventForm">
	<div class="form-group row">
		<label for="eventOrganiser" class="col-sm-2 col-form-label">Company /
			Organisation</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="eventOrganiser"
				placeholder="Company/Organisation" required>
		</div>
	</div>
	<div class="form-group row">
		<label for="eventName" class="col-sm-2 col-form-label">Name of the
			event</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="eventName"
				placeholder="Name of the event" required>
		</div>
	</div>
	<div class="form-group row nativeDatePicker">
			
			<label for="eventDateNative" class="col-sm-2 col-form-label">Event date:</label> 
			<div class="col-sm-10">
			<input type="date" class="form-control"	id="eventDateNative" name="eventDateNative"> 
			<span class="validity"></span>
			</div>
	</div>
		<div class="form-group row fallbackDatePicker">
			<label for="day" class="col-sm-2 col-md-2 col-form-label">Day of week</label>
			<div class="col-sm-2 col-md-2">
				<select id="day" name="day" class="form-control">
				</select>
			</div>

			<label for="month" class="col-sm-4 col-md-4 col-form-label">Event
				month</label>
			<div class="col-sm-4 col-md-4">
				<select id="month" name="month" class="form-control">
					<option selected>January</option>
					<option>February</option>
					<option>March</option>
					<option>April</option>
					<option>May</option>
					<option>June</option>
					<option>July</option>
					<option>August</option>
					<option>September</option>
					<option>October</option>
					<option>November</option>
					<option>December</option>
				</select>
			</div>

			<label for="year" class="col-sm-4 col-md-4 col-form-label">Event
				month</label>
			<div class="col-sm-4 col-md-4" >
				<select id="year" name="year" class="form-control">
				</select>
			</div>
		</div>


	<label for="eventContact" class="col-md-2 col-sm-2 col-form-label">Contact
		number</label>
	<div class="col-md-4 col-sm-10">
		<input type="text" class="form-control" id="eventContact"
			placeholder="Enter a contact number">
	</div>

	<label for="eventDate" class="col-sm-2 col-form-label">Event date</label>
	<div class="col-sm-10">
		<input type="date" class="form-control" id="eventDate"
			placeholder="Event date" required>
	</div>


	<div class="form-group row">
		<label for="eventLocation" class="col-sm-2 col-form-label">Event
			location</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="eventLocation"
				placeholder="Start typing an address" aria-describedby="addressHelp">
			<small id="addressHelp" class="form-text text-muted">Start typing an
				address then select from the dropdown.</small>
		</div>
	</div>
	<div class="form-group row">
		<label for="eventSubmitterName" class="col-sm-2 col-md-2 col-form-label">Your
			name</label>
		<div class="col-sm-10 col-md-4">
			<input type="text" class="form-control" id="eventSubmitterName"
				placeholder="Enter your name">
		</div>
		<label for="eventContactNumber" class="col-md-2 col-sm-2 col-form-label">Contact
			number</label>
		<div class="col-md-4 col-sm-10">
			<input type="text" class="form-control" id="eventContactNumber"
				placeholder="Enter a contact number">
		</div>
	</div>

	<div class="form-group row">
		<label for="eventEmail" class="col-sm-2 col-form-label">Email</label>
		<div class="col-sm-10">
			<input type="email" class="form-control" id="eventEmail"
				placeholder="Enter your email" aria-describedby="emailHelp"> <small
				id="emailHelp" class="form-text text-muted">Please supply your email
				address so we can contact you if we have any queries about this
				event.</small>
		</div>
	</div>

	<div class="form-group row">
		<label for="eventDescription" class="col-sm-2 col-form-label">Description</label>
		<div class="col-sm-10">
			<textarea class="form-control" id="eventDescription" rows="3"></textarea>
			<small id="descriptionHelp" class="form-text text-muted">Enter a
				brief description of your event.</small>
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

//define variables
var nativePicker = document.querySelector('.nativeDatePicker');
var fallbackPicker = document.querySelector('.fallbackDatePicker');
var fallbackLabel = document.querySelector('.fallbackLabel');

var yearSelect = document.querySelector('#year');
var monthSelect = document.querySelector('#month');
var daySelect = document.querySelector('#day');

// hide fallback initially
fallbackPicker.style.display = 'none';
fallbackLabel.style.display = 'none';

// test whether a new date input falls back to a text input or not
var test = document.createElement('input');
test.type = 'date';

// if it does, run the code inside the if() {} block
if(test.type === 'text') {
  // hide the native picker and show the fallback
  nativePicker.style.display = 'none';
  fallbackPicker.style.display = 'block';
  fallbackLabel.style.display = 'block';

  // populate the days and years dynamically
  // (the months are always the same, therefore hardcoded)
  populateDays(monthSelect.value);
  populateYears();
}

function populateDays(month) {
  // delete the current set of <option> elements out of the
  // day <select>, ready for the next set to be injected
  while(daySelect.firstChild){
    daySelect.removeChild(daySelect.firstChild);
  }

  // Create variable to hold new number of days to inject
  var dayNum;

  // 31 or 30 days?
  if(month === 'January' || month === 'March' || month === 'May' || month === 'July' || month === 'August' || month === 'October' || month === 'December') {
    dayNum = 31;
  } else if(month === 'April' || month === 'June' || month === 'September' || month === 'November') {
    dayNum = 30;
  } else {
  // If month is February, calculate whether it is a leap year or not
    var year = yearSelect.value;
    (year - 2016) % 4 === 0 ? dayNum = 29 : dayNum = 28;
  }

  // inject the right number of new <option> elements into the day <select>
  for(i = 1; i <= dayNum; i++) {
    var option = document.createElement('option');
    option.textContent = i;
    daySelect.appendChild(option);
  }

  // if previous day has already been set, set daySelect's value
  // to that day, to avoid the day jumping back to 1 when you
  // change the year
  if(previousDay) {
    daySelect.value = previousDay;

    // If the previous day was set to a high number, say 31, and then
    // you chose a month with less total days in it (e.g. February),
    // this part of the code ensures that the highest day available
    // is selected, rather than showing a blank daySelect
    if(daySelect.value === "") {
      daySelect.value = previousDay - 1;
    }

    if(daySelect.value === "") {
      daySelect.value = previousDay - 2;
    }

    if(daySelect.value === "") {
      daySelect.value = previousDay - 3;
    }
  }
}

function populateYears() {
  // get this year as a number
  var date = new Date();
  var year = date.getFullYear();

  // Make this year, and the 100 years before it available in the year <select>
  for(var i = 0; i <= 100; i++) {
    var option = document.createElement('option');
    option.textContent = year-i;
    yearSelect.appendChild(option);
  }
}

// when the month or year <select> values are changed, rerun populateDays()
// in case the change affected the number of available days
yearSelect.onchange = function() {
  populateDays(monthSelect.value);
}

monthSelect.onchange = function() {
  populateDays(monthSelect.value);
}

//preserve day selection
var previousDay;

// update what day has been set to previously
// see end of populateDays() for usage
daySelect.onchange = function() {
  previousDay = daySelect.value;
}

</script>