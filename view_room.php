<?php
include 'config.php';
// session_start();
include 'navbar.php';

// Get room ID from URL (e.g., /view_room.php?id=1)
$room_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Query to get room data based on room ID
$sql = "SELECT * FROM rooms WHERE id = $room_id";
$result = mysqli_query($conn, $sql);

// Check if the room exists
if ($row = mysqli_fetch_assoc($result)) {
    // Room details
    $room_name = $row['name'];
    $room_type = $row['room_type'];
    $room_price = $row['price'];
    $room_description = $row['description'];
    $room_amenities = $row['amenities'];
    $images = explode(',', $row['images']); // Assuming images are stored as a comma-separated string
} else {
    echo "Room not found.";
    exit;
}

// Query to count available rooms of the same type
$available_sql = "SELECT COUNT(*) AS available_count FROM rooms WHERE room_type = '" . mysqli_real_escape_string($conn, $row['room_type']) . "' AND status = 'vacant'";
$available_result = mysqli_query($conn, $available_sql);
$available_data = mysqli_fetch_assoc($available_result);
$available_rooms = (int)$available_data['available_count']; // Number of available rooms
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user']['id']; // Replace with actual logged-in user ID
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $number_of_rooms = (int)$_POST['number_of_rooms'];
    $total_price = $number_of_rooms * $room_price;

    // Fetch available rooms for the selected room type
    $available_rooms_sql = "SELECT id FROM rooms WHERE room_type = '" . mysqli_real_escape_string($conn, $row['room_type']) . "' AND status = 'Vacant' LIMIT $number_of_rooms";
    $available_rooms_result = mysqli_query($conn, $available_rooms_sql);

    if (!$available_rooms_result) {
        die("Error fetching available rooms: " . mysqli_error($conn));
    }

    $booked_rooms = [];
    while ($room = mysqli_fetch_assoc($available_rooms_result)) {
        $room_id = $room['id'];

        // Insert booking for each room
        $insert_sql = "INSERT INTO bookings (user_id, room_id, status, check_in, check_out, total_price, created_at) 
                       VALUES ('$user_id', '$room_id', 'pending', '$check_in', '$check_out', '$room_price', NOW())";

        if (mysqli_query($conn, $insert_sql)) {
            // Update the room status to "occupied"
            $update_sql = "UPDATE rooms SET status = 'occupied' WHERE id = $room_id";
            if (!mysqli_query($conn, $update_sql)) {
                echo "Error updating room status for room $room_id: " . mysqli_error($conn);
            } else {
                $booked_rooms[] = $room_id; // Keep track of successfully booked rooms
            }
        } else {
            echo "Error inserting booking for room $room_id: " . mysqli_error($conn);
        }
    }

    if (count($booked_rooms) > 0) {
        echo "Booking successful for rooms: " . implode(", ", $booked_rooms);
    } else {
        echo "No rooms were booked.";
    }
}

?>
  <link rel="stylesheet" href="./admin/css/roombook.css">

<div class="container my-5">
    <div class="row">
        <div class="col-6">
            <!-- Carousel for Room Images -->
            <img src="./uploads/<?php echo $images[0] ?>" alt="" style="width: 100%; height: 412px">
        </div>
        <div class="col-6">
            <div class="row">
                <?php
                // Skip the first image and show the rest
                foreach (array_slice($images, 1) as $image) {
                    echo '<div class="col-6 p-1">';
                    echo '<img src="./uploads/' . $image . '" style="width: 100%; height: 200px" alt="Room Image">';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Room Description -->
        <div class="col-lg-7">
            <div class="room-description mt-4">
                <h3><?php echo htmlspecialchars($room_name); ?></h3>
                <p class="room-details"><?php echo htmlspecialchars($room_type); ?></p>
                <p class="room-details"><?php echo htmlspecialchars($room_description); ?></p>

                <div class="text-h6">Amenities</div>
                <p class="room-details mt-2"><?php echo htmlspecialchars($room_amenities); ?></p>
            </div>
        </div>

        <!-- Right Column - Reservation Section -->
        <div class="col-lg-5">
            <form method="POST" action="">
                <div class="border p-3 rounded shadow-sm">
                    <h4 class="price">₱<?php echo number_format($room_price, 2); ?> / night</h4>
                    <div class="row">
                        <div class="mb-3 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label for="checkIn" class="form-label">Check-in</label>
                            <input type="date" class="form-control" id="checkIn" name="check_in" required>
                        </div>
                        <div class="mb-3 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label for="checkOut" class="form-label">Check-out</label>
                            <input type="date" class="form-control" id="checkOut" name="check_out" required>
                        </div>
                        <div class="mb-3 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label for="guests" class="form-label">Guests</label>
                            <select class="form-select" id="guests">
                                <option value="1">1 guest</option>
                                <option value="2">2 guests</option>
                                <option value="3">3 guests</option>
                                <option value="4">4 guests</option>
                            </select>
                        </div>
                        <div class="mb-3 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label for="number_of_rooms" class="form-label">No. of Rooms</label>
                            <!-- <select class="form-select" id="number_of_rooms" name="number_of_rooms" required>
                                <?php
                                // Generate room options based on available rooms
                                // for ($i = 1; $i <= $available_rooms; $i++) {
                                //     echo "<option value='$i'>$i room" . ($i > 1 ? 's' : '') . "</option>";
                                // }
                                ?>
                            </select> -->
                            <select class="form-select" id="number_of_rooms" name="number_of_rooms" required>
                                <?php
                                // Check if there are any available rooms
                                if ($available_rooms > 0) {
                                    // Generate room options based on available rooms
                                    for ($i = 1; $i <= $available_rooms; $i++) {
                                        echo "<option value='$i'>$i room" . ($i > 1 ? 's' : '') . "</option>";
                                    }
                                } else {
                                    // Display a message when no rooms are available
                                    echo "<option value='' disabled selected>No rooms available</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <button class="btn reserve-btn w-100" onclick="openbookbox()">Reserve</button>
                </div>
            </form>
            <button class="btn reserve-btn w-100" onclick="openbookbox()">Reserve</button>

        </div>
    </div>
</div>

<div id="guestdetailpanel">
    <form action="" method="POST" class="guestdetailpanelform">
        <div class="head">
            <h3>RESERVATION</h3>
            <i class="fa-solid fa-circle-xmark" onclick="closebox()"></i>
        </div>
        <div class="middle">
            <div class="guestinfo">
                <h4>Guest information</h4>
                <input type="text" name="Name" placeholder="Enter Full name">
                <input type="email" name="Email" placeholder="Enter Email">

                <?php
                $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
                ?>

                <select name="Country" class="selectinput">
                    <option value selected>Select your country</option>
                    <?php
                    foreach ($countries as $key => $value):
                        echo '<option value="' . $value . '">' . $value . '</option>';
                    //close your tags!!
                    endforeach;
                    ?>
                </select>
                <input type="text" name="Phone" placeholder="Enter Phoneno">
            </div>

            <div class="line"></div>

            <div class="reservationinfo">
                <h4>Reservation information</h4>
                <select name="RoomType" class="selectinput">
                    <option value selected>Type Of Room</option>
                    <option value="Superior Room">SUPERIOR ROOM</option>
                    <option value="Deluxe Room">DELUXE ROOM</option>
                    <option value="Guest House">GUEST HOUSE</option>
                    <option value="Single Room">SINGLE ROOM</option>
                </select>
                <select name="Bed" class="selectinput">
                    <option value selected>Bedding Type</option>
                    <option value="Single">Single</option>
                    <option value="Double">Double</option>
                    <option value="Triple">Triple</option>
                    <option value="Quad">Quad</option>
                    <option value="None">None</option>
                </select>
                <select name="NoofRoom" class="selectinput">
                    <option value selected>No of Room</option>
                    <option value="1">1</option>
                    <!-- <option value="1">2</option>
                <option value="1">3</option> -->
                </select>
                <select name="Meal" class="selectinput">
                    <option value selected>Meal</option>
                    <option value="Room only">Room only</option>
                    <option value="Breakfast">Breakfast</option>
                    <option value="Half Board">Half Board</option>
                    <option value="Full Board">Full Board</option>
                </select>
                <div class="datesection">
                    <span>
                        <label for="cin"> Check-In</label>
                        <input name="cin" type="date">
                    </span>
                    <span>
                        <label for="cin"> Check-Out</label>
                        <input name="cout" type="date">
                    </span>
                </div>
            </div>
        </div>
        <div class="footer">
            <button class="btn btn-success" name="guestdetailsubmit">Submit</button>
        </div>
    </form>

    <!-- ==== room book php ====-->
    <?php
    if (isset($_POST['guestdetailsubmit'])) {
        $Name = $_POST['Name'];
        $Email = $_POST['Email'];
        $Country = $_POST['Country'];
        $Phone = $_POST['Phone'];
        $RoomType = $_POST['RoomType'];
        $Bed = $_POST['Bed'];
        $NoofRoom = $_POST['NoofRoom'];
        $Meal = $_POST['Meal'];
        $cin = $_POST['cin'];
        $cout = $_POST['cout'];

        if ($Name == "" || $Email == "" || $Country == "") {
            echo "<script>swal({
                title: 'Fill the proper details',
                icon: 'error',
            });
            </script>";
        } else {
            $sta = "NotConfirm";
            $sql = "INSERT INTO roombook(Name,Email,Country,Phone,RoomType,Bed,NoofRoom,Meal,cin,cout,stat,nodays) VALUES ('$Name','$Email','$Country','$Phone','$RoomType','$Bed','$NoofRoom','$Meal','$cin','$cout','$sta',datediff('$cout','$cin'))";
            $result = mysqli_query($conn, $sql);


            if ($result) {
                echo "<script>swal({
                        title: 'Reservation successful',
                        icon: 'success',
                    });
                </script>";
            } else {
                echo "<script>swal({
                            title: 'Something went wrong',
                            icon: 'error',
                        });
                </script>";
            }
        }
    }
    ?>
</div>

<script>
    var bookbox = document.getElementById("guestdetailpanel");

    openbookbox = () => {
        bookbox.style.display = "flex";
    }
    closebox = () => {
        bookbox.style.display = "none";
    }
</script>
