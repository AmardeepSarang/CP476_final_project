<!DOCTYPE html>
<html lan="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>

    <link href="css/styles.css" rel="stylesheet">

</head>

<body>
    <header>
        <img src="images/grt-logo.PNG">
        <h1 class="title">MobilityPLUS Online Booking</h1>
    </header>

    <main>
        <div class="msgBox">
            <?php
            include_once 'include/config.php';

            //check that user is loged in
            session_start();
            $_SESSION["loggedin"] = true;
            if(!isset($_SESSION["loggedin"])&&!$_SESSION["loggedin"]){
                header("location: index.html");
            }
            $userId=$_SESSION["id"];
        
            //get values from post
            
            $pickUpDate = $_POST["pickupDate"];
            $pickUpTime = $_POST["pickupTime"];
            $pickUpAddress = $_POST["pickupaddress"];
            $pickupCity = $_POST["pickupCity"];
            $pickupPostalcode = $_POST["pickupPostalcode"];
            $pickUpNotes = $_POST["pickupNotes"];
            $returnTripDate = $_POST["returnTripDate"];
            $returnTripTime = $_POST["returnTripTime"];
            $returnTripAddress = $_POST["returnTripaddress"];
            $returnTripCity = $_POST["returnTripCity"];
            $returnTripPostalcode = $_POST["returnTripPostalcode"];
            $returnTripNotes = $_POST["returnTripNotes"];
            $device = $_POST["device"];
            $guest = $_POST["guest"];


            //notes can be empty
            if (empty($pickUpNotes)) {
                $pickUpNotes = "None";
            }
            if (empty($returnTripNotes)) {
                $returnTripNotes = "None";
            }

            //check for empty values
            if (
                !empty($pickUpDate) && !empty($pickUpTime) && !empty($pickUpAddress) && !empty($pickupCity) && !empty($pickupPostalcode)
                && !empty($returnTripDate) && !empty($returnTripTime) && !empty($returnTripAddress) && !empty($returnTripCity) && !empty($returnTripPostalcode) && !empty($device)
            ) {

                // Connect to MySQL
                $db = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

                // Error checking
                if (!$db) {
                    print "<p>Error - Could not connect to MySQL</p>";
                    exit;
                }
                $error = mysqli_connect_error();

                if ($error != null) {
                    $output = "<p>Unable to connet to database</p>" . $error;
                    exit($output);
                }


                $query = "INSERT Into bookings (user_id, pick_up_date, pick_up_time, pick_up_address, pick_up_city, pick_up_postal, pick_up_notes, return_date, return_time, return_pick_up_address, return_pick_up_city, return_pick_up_postal, return_pick_up_notes, mobility_device, guests) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                if ($statement = mysqli_prepare($db, $query)) {

                    // bind parameters s - string,
                    $result = mysqli_stmt_bind_param($statement, 'sssssssssssssss', $userId, $pickUpDate, $pickUpTime, $pickUpAddress, $pickupCity, $pickupPostalcode, $pickUpNotes, $returnTripDate, $returnTripTime, $returnTripAddress, $returnTripCity, $returnTripPostalcode, $returnTripNotes, $device, $guest);
                    if (!$result) {
                        print "<p>bounding error</p>";
                    }
                    // execute query
                    $result = mysqli_stmt_execute($statement);

                    if ($result) {
                        print "<p>Your booking was successful</p>";
                    } else {
                        print "Mysql insert Error" . mysqli_stmt_error($statement);
                    }
                } else {
                    print "<p>Error on prepare</p>";
                }
            } else {
                print "<p>Error All fields, other then notes, are required</p>";
                die();
            }

            ?>


            <button class="dashbutton lgbt" onclick="window.location.href='booking.html'">Book another trip</button>
            <button class="dashbutton lgbt" onclick="window.location.href='dashboard.html'">Go to Dashboard</button>
        </div>
    </main>
</body>