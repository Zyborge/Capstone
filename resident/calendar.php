<!DOCTYPE html>
<html>
<head>
  <title>Calendar</title>
  <link rel="stylesheet" type="text/css" href="calendar.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="../css/resident-calendar.css">

  
    
</head>

<body>
<?php include('../navbar/nav.php'); ?>

    <div class="container">
  <div class="calendar">
    <div class="header">
        <button id="prev" onclick="previousMonth()">&lt;</button>
        <h1 id="month-year"></h1>
        <button id="next" onclick="nextMonth()">&gt;</button>
      </div>
      
    
    <table id="calendar-table">
      <thead>
        <tr>
          <th>Sun</th>
          <th>Mon</th>
          <th>Tue</th>
          <th>Wed</th>
          <th>Thu</th>
          <th>Fri</th>
          <th>Sat</th>
        </tr>
      </thead>
      <tbody id="calendar-body">
      </tbody>
    </table>
  </div>
  <div id="form-container" style="display: none;">
  <h2>Booking Form</h2>
  <form id="booking-form" action="../php/booking-process.php" method="post">
  <div>
    <label for="event-type">Event Venue:</label>
    <select id="event-type" name="event-type" required>
    <option value="" disabled selected>Select Venue</option>
      <option value="covered-court">Covered Court</option>
      <option value="clubhouse">Clubhouse</option>
    </select>
  </div>
  <div>
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required>
  </div>
  <div>
    <label for="description">Description:</label>
    <textarea id="description" name="description" required></textarea>
  </div>
  <div>
    <label for="start-date">Start Date:</label>
    <input type="date" id="start-date" name="start-date" required>
  </div>
  <div>
    <label for="end-date">End Date:</label>
    <input type="date" id="end-date" name="end-date" required>
  </div>
  <div>
    <label for="start-time">Start Time:</label>
    <input type="time" id="start-time" name="start-time" required>
  </div>
  <div>
    <label for="end-time">End Time:</label>
    <input type="time" id="end-time" name="end-time" required>
  </div>
  <button type="submit" id="submit-button" data-bs-toggle="tooltip" data-bs-placement="top" title="Please fill in all required fields">
  <i class='bx bx-check'></i>
  <span>Submit</span>
</button>

<button type="button" id="back-button">
  <i class='bx bx-arrow-back'></i>
  <span>Back</span>
</button>
<div id="selected-day"></div>

</form>


</div>

</div>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
  const bookingForm = document.getElementById("booking-form");
  const submitButton = document.getElementById("submit-button");

  bookingForm.addEventListener("input", function() {
    const requiredFields = bookingForm.querySelectorAll("input:required, select:required, textarea:required");
    let hasEmptyFields = false;

    requiredFields.forEach(function(field) {
      if (!field.value) {
        hasEmptyFields = true;
      }
    });

    submitButton.disabled = hasEmptyFields;

    const tooltipText = Array.from(requiredFields).map(field => field.labels[0].textContent).join(", ");
    submitButton.setAttribute("data-bs-original-title", tooltipText);
    new bootstrap.Tooltip(submitButton);
  });
</script>
 <script>
  var currentDate = new Date();
var currentMonth = currentDate.getMonth();
var currentYear = currentDate.getFullYear();

function renderCalendar() {
  var calendarBody = document.getElementById("calendar-body");
  var monthYear = document.getElementById("month-year");
  monthYear.innerHTML = getMonthName(currentMonth) + " " + currentYear;

  // Clear calendar
  calendarBody.innerHTML = "";

  var firstDay = new Date(currentYear, currentMonth, 1);
  var startingDay = firstDay.getDay();
  var daysInMonth = getDaysInMonth(currentMonth, currentYear);

  var date = 1;
  for (var i = 0; i < 6; i++) {
    var row = document.createElement("tr");

    for (var j = 0; j < 7; j++) {
      if (i === 0 && j < startingDay) {
        var cell = document.createElement("td");
        row.appendChild(cell);
      } else if (date > daysInMonth) {
        break;
      } else {
        var cell = document.createElement("td");
        cell.innerHTML = date;
        cell.addEventListener("click", function() {
          showFormContainer(this);
        });
        if (
          currentYear === currentDate.getFullYear() &&
          currentMonth === currentDate.getMonth() &&
          date === currentDate.getDate()
        ) {
          cell.classList.add("current-day");
        }

        row.appendChild(cell);

        date++;
      }
    }

    calendarBody.appendChild(row);
  }

  // Add CSS styles for the selected date
  var selectedDate = new Date(currentYear, currentMonth, currentDate.getDate());
  var selectedDateString = selectedDate.toISOString().split("T")[0];
  var selectedDayElement = document.getElementById(selectedDateString);
  if (selectedDayElement) {
    selectedDayElement.classList.add("selected-day");
  }
}

function showFormContainer(cell) {
  var formContainer = document.getElementById("form-container");
  formContainer.style.display = "block";

  // Remove the existing highlight from all cells
  var calendarCells = document.querySelectorAll("#calendar-body td");
  calendarCells.forEach(function(cell) {
    cell.classList.remove("selected-day");
  });

  // Add the highlight to the clicked cell
  cell.classList.add("selected-day");

  // Retrieve the selected day value
  var selectedDay = cell.innerHTML;

  // Echo the selected day
  var selectedDayElement = document.getElementById("selected-day");
  selectedDayElement.innerHTML = "Selected Day: " + selectedDay;
}
  

  function previousMonth() {
    currentYear = currentMonth === 0 ? currentYear - 1 : currentYear;
    currentMonth = currentMonth === 0 ? 11 : currentMonth - 1;
    renderCalendar();
  }

  function nextMonth() {
    currentYear = currentMonth === 11 ? currentYear + 1 : currentYear;
    currentMonth = currentMonth === 11 ? 0 : currentMonth + 1;
    renderCalendar();
  }

  function getMonthName(month) {
    var monthNames = [
      "January", "February", "March", "April", "May", "June",
      "July", "August", "September", "October", "November", "December"
    ];
    return monthNames[month];
  }

  function getDaysInMonth(month, year) {
    return new Date(year, month + 1, 0).getDate();
  }

  function isBookedDate(day, month, year) {
    // Make an AJAX request to fetch the booked dates from the server
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var bookedDates = JSON.parse(xhr.responseText);
        var currentDate = new Date(year, month, day);
        for (var i = 0; i < bookedDates.length; i++) {
          var bookedDate = new Date(bookedDates[i]);
          if (
            bookedDate.getFullYear() === currentDate.getFullYear() &&
            bookedDate.getMonth() === currentDate.getMonth() &&
            bookedDate.getDate() === currentDate.getDate()
          ) {
            return true;
          }
        }
      }
    };
    xhr.open("GET", "get-booked-dates.php", true);
    xhr.send();
    return false;
  }
  function showFormContainer(cell) {
  var formContainer = document.getElementById("form-container");
  formContainer.style.display = "block";

  // Remove the existing highlight from all cells
  var calendarCells = document.querySelectorAll("#calendar-body td");
  calendarCells.forEach(function(cell) {
    cell.classList.remove("selected-day");
  });

  // Add the highlight to the clicked cell
  cell.classList.add("selected-day");

  // Retrieve the selected day value
  var selectedDay = cell.innerHTML;

  // Echo the selected day
  var selectedDayElement = document.getElementById("selected-day");
  selectedDayElement.innerHTML = "Selected Day: " + selectedDay;
}



  var backButton = document.getElementById("back-button");
  backButton.addEventListener("click", function() {
    hideFormContainer();
  });

  function hideFormContainer() {
    var formContainer = document.getElementById("form-container");
    formContainer.style.display = "none";
  }


  // Initial rendering
  renderCalendar();
  var startDateInput = document.getElementById("start-date");
var currentDate = new Date();
var timezoneOffset = currentDate.getTimezoneOffset() * 60000; // Get the timezone offset in milliseconds
var currentDateString = new Date(Date.now() - timezoneOffset).toISOString().split("T")[0];
startDateInput.setAttribute("min", currentDateString);

var startDateInput = document.getElementById("start-date");
var endDateInput = document.getElementById("end-date");

startDateInput.addEventListener("input", function() {
  endDateInput.setAttribute("min", this.value);
});

endDateInput.addEventListener("input", function() {
  var startDate = new Date(startDateInput.value);
  var endDate = new Date(this.value);

  if (endDate < startDate) {
    this.value = "";
  }
});
var startTimeInput = document.getElementById("start-time");
var endTimeInput = document.getElementById("end-time");
var currentTime = new Date();

startTimeInput.addEventListener("input", function() {
  var selectedTime = new Date(currentDateString + "T" + this.value);
  if (selectedTime < currentTime) {
    this.value = currentTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
  }
});

endTimeInput.addEventListener("input", function() {
  var startTime = new Date(currentDateString + "T" + startTimeInput.value);
  var endTime = new Date(currentDateString + "T" + this.value);

  if (endTime < startTime) {
    this.value = startTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
  }
});

  
</script>




</body>
</html>
