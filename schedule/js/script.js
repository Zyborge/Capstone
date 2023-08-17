var calendar;
var events = [];

$(function() {
    if (!!scheds) {
        Object.keys(scheds).map(k => {
            var row = scheds[k];
            var eventColor = '';

            // Check if the logged-in user booked the event
            if (scheds[k].display === 'BOOKED') {
                // Use a color for your own booked events
                eventColor = '#428bca';
            } else {
                // Use a different color for events booked by others
                eventColor = '#f0ad4e';
            }

            events.push({
                id: row.id,
                title: row.title,
                start: row.start_date,
                end: row.end_date,
                color: eventColor // Assign color based on the booking type
            });
        });
    }

    calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek,list'
        },
        selectable: true,
        themeSystem: 'bootstrap',
        events: function(fetchInfo, successCallback) {
            successCallback(events);
        },
        select: function(info) {
            var startDate = info.start;
            var endDate = info.end;
            
            // Check if the selected time slot is already booked
            if (isTimeSlotAvailable(startDate, endDate)) {
                // Allow booking
                // Add your booking logic here
                
                // Example code to add a new event to the calendar
            
                
                calendar.refetchEvents(); // Refresh the calendar to display the new event
            } else {
                // Selected time slot is already booked
                alert('The selected time slot is not available.');
            }
            
            calendar.unselect(); // Clear the selection
        },
        eventClick: function(info) {
            var _details = $('#event-details-modal');
            var id = info.event.id;
            if (!!scheds[id]) {
                _details.find('#Venue').text(scheds[id].Venue);
                _details.find('#title').text(scheds[id].title);
                _details.find('#description').text(scheds[id].description);
                _details.find('#start-date').text(scheds[id].sdate);
                _details.find('#end-date').text(scheds[id].edate);
                _details.find('#start-time').text(scheds[id].start_time);
                _details.find('#end-time').text(scheds[id].end_time);

                // Check if the logged-in user booked the event
                if (scheds[id].display === 'BOOKED') {
                    _details.find('#edit,#delete').attr('data-id', id).show();
                } else {
                    _details.find('#edit,#delete').hide();
                }

                _details.modal('show');
            } else {
                alert("Event is undefined");
            }
        },
        eventDidMount: function(info) {
            // Do Something after events mounted
        },
        editable: false // Disable drag and drop
    });

    calendar.render();

    // Form reset listener
    $('#schedule-form').on('reset', function() {
        $(this).find('input:hidden').val('');
        $(this).find('input:visible').first().focus();
    });

    // Edit Button
    $('#edit').click(function() {
        var id = $(this).attr('data-id');
        if (!!scheds[id]) {
            var _form = $('#schedule-form');
            _form.find('[name="id"]').val(id);
            _form.find('[name="title"]').val(scheds[id].title);
            _form.find('[name="description"]').val(scheds[id].description);
            _form.find('[name="start-date"]').val(scheds[id].sdate.split(" ")[0]);
            _form.find('[name="start-time"]').val(scheds[id].sdate.split(" ")[1]);
            _form.find('[name="end-date"]').val(scheds[id].edate.split(" ")[0]);
            _form.find('[name="end-time"]').val(scheds[id].edate.split(" ")[1]);
            $('#event-details-modal').modal('hide');
            _form.find('[name="title"]').focus();
        } else {
            alert("Event is undefined");
        }
    });

    // Delete Button / Deleting an Event
    $('#delete').click(function() {
        var id = $(this).attr('data-id');
        if (!!scheds[id]) {
            var _conf = confirm("Are you sure to delete this scheduled event?");
            if (_conf === true) {
                location.href = "./delete_schedule.php?id=" + id;
            }
        } else {
            alert("Event is undefined");
        }
        
    });
    
    function isTimeSlotAvailable(startDate, endDate) {
        // Convert the selected start and end dates to moment objects for easier comparison
        var selectedStartTime = moment(startDate, 'HH:mm');
        var selectedEndTime = moment(endDate, 'HH:mm');
      
        // Check if the selected time slot conflicts with existing events
        for (var i = 0; i < events.length; i++) {
          var event = events[i];
      
          // Convert the event start and end dates to moment objects for comparison
          var eventStartTime = moment(event.start, 'HH:mm');
          var eventEndTime = moment(event.end, 'HH:mm');
      
          // Check if the selected time slot overlaps with the current event
          if (
            (selectedStartTime.isSameOrAfter(eventStartTime) && selectedStartTime.isBefore(eventEndTime)) || // Check if start time overlaps
            (selectedEndTime.isAfter(eventStartTime) && selectedEndTime.isSameOrBefore(eventEndTime)) || // Check if end time overlaps
            (selectedStartTime.isBefore(eventStartTime) && selectedEndTime.isAfter(eventEndTime)) // Check if selected time slot completely overlaps the event
          ) {
            return false; // Conflict found, time slot not available
          }
        }
      
        return true; // No conflicts found, time slot available
      }
      
      
      
});
