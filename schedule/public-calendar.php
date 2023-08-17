
<?php
require_once('db-connect.php');

$bookingsSql = "SELECT b.*, u.email FROM bookings AS b INNER JOIN approved_users AS u ON b.resident_id = u.resident_id";
$bookingsResult = $conn->query($bookingsSql);

$sched_res = [];
while ($row = $bookingsResult->fetch_assoc()) {
    $row['sdate'] = date("F d, Y", strtotime($row['start_date']));
    $row['edate'] = date("F d, Y", strtotime($row['end_date']));

    // Hide specific event details for events booked by other users
    $row['display'] = '';
    $row['title'] = 'BOOKED';
    $row['description'] = '';
    $sched_res[$row['id']] = $row;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduling</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./fullcalendar/lib/main.min.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <style>
        :root {
            --bs-success-rgb: 71, 222, 152 !important;
        }

        html,
        body {
            height: 100%;
            width: 100%;
            background-color: #4CAF50 !important; 
            font-family: Apple Chancery, cursive;
        }

        .btn-info.text-light:hover,
        .btn-info.text-light:focus {
            background: BLUE;
        }

        table,
        tbody,
        td,
        tfoot,
        th,
        thead,
        tr {
            border-color: #ededed !important;
            border-style: solid;
            border-width: 1px !important;
            text-decoration: none;
        }
        #page-container {
            margin-top:100px;
            height: auto;
            width: auto;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.5); /* Set the background color with an alpha value */
            backdrop-filter: blur(10px); /* Apply a blur effect to create the glass effect */
            }
            .event-details {
    margin-bottom: 20px;
}

.event-details dt {
    margin-bottom: 5px;
}

.event-details dd {
    margin-bottom: 10px;
    font-weight: normal;
    font-size: 16px;
}


    </style>
</head>
<?php include('../navbar/nav.php'); ?>

<body>
    <div class="container py-5" id="page-container">
        <?php if (isset($_SESSION['resident_id'])) : ?>
            <div class="row">
                <div class="col-md-9">
                    <div id="calendar"></div>
                </div>
                
                        <div class="card-footer">
                            <div class="text-center">
                                <button class="btn btn-primary btn-sm rounded-0" type="submit" form="schedule-form"><i class='bx bx-check'></i> Book</button>
                                <button class="btn btn-default border btn-sm rounded-0" type="reset" form="schedule-form"><i class="fa fa-reset"></i> Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <div class="row">
                <div class="col-md-12">
                    <div id="calendar"></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title">Schedule Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body rounded-0">
                            <div class="container-fluid">
                <dl>
                <dt class="text-muted">Venue</dt> <!-- Add this line for the venue -->
                    <dd id="Venue" class=""></dd> <!-- Add this line for the venue -->
                    <dt class="text-muted">Title</dt>
                    <dd id="title" class="fw-bold fs-4"></dd>
                    <dt class="text-muted">Start Date</dt>
                    <dd id="start-date" class=""></dd>
                    <dt class="text-muted">End Date</dt>
                    <dd id="end-date" class=""></dd>
                    <dt class="text-muted">Start Time</dt>
                    <dd id="start-time" class=""></dd>
                    <dt class="text-muted">End Time</dt>
                    <dd id="end-time" class=""></dd>
              
                </dl>
            </div>

                </div>
                <div class="modal-footer rounded-0">
                    <div class="text-end">
                        
                        <button type="button" class="btn btn-danger btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var scheds = <?= json_encode($sched_res) ?>;
    </script>
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./fullcalendar/lib/main.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.33/moment-timezone-with-data.min.js"></script>

    <script src="./js/script.js"></script>
    <script>
        
    </script>
    
</body>

</html>