<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $room = $_POST["Rooms"];
    $arrivalDeparture = $_POST["date1"]; // Combined arrival and departure date
    $numberOfGuests = $_POST["number2"]; // Number of guests
    
    // Split the combined arrival and departure date into separate values
    list($arrivalDate, $departureDate) = explode(" to ", $arrivalDeparture);
    
    // Database connection details (replace with your own)
    $hostname = "your_database_hostname";
    $username = "your_database_username";
    $password = "your_database_password";
    $database = "your_database_name";
    
    // Create a new MySQLi connection
    $mysqli = new mysqli($hostname, $username, $password, $database);
    
    // Check the connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    
    // Prepare and execute an SQL INSERT statement
    $sql = "INSERT INTO bookings (name, email, room, arrival_date, departure_date, number_of_guests) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("sssssi", $name, $email, $room, $arrivalDate, $departureDate, $numberOfGuests);
        $stmt->execute();
        $stmt->close();
        // Close the database connection
        $mysqli->close();
        
        // Redirect to a thank-you page or display a confirmation message
        header("Location: thank_you.html"); // Replace with your thank-you page URL
        exit;
    } else {
        echo "Error: " . $mysqli->error;
    }
}

// If the form hasn't been submitted, you can display your HTML form here
?>
