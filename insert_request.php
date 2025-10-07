<?php
// 1. Database Configuration (CHANGE THESE VALUES)
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // Your database username (often 'root' on local systems)
define('DB_PASSWORD', '');     // Your database password (often empty on local systems)
define('DB_NAME', 'elderassist_db'); // The name of your database (e.g., 'elderassist_db')

// 2. Attempt to connect to MySQL database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("ERROR: Could not connect to the database. " . $conn->connect_error);
}

// Check if the form was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 3. Collect and Sanitize Form Data
    // Use proper sanitation to prevent SQL injection attacks!
    $elder_name = $conn->real_escape_string($_POST['elderName']);
    $service_date = $conn->real_escape_string($_POST['serviceDate']);
    $time_slot = $conn->real_escape_string($_POST['timeSlot']);
    $purpose_of_outing = $conn->real_escape_string($_POST['purpose']);

    // 4. Prepare SQL INSERT statement
    $sql = "INSERT INTO escort_service_requests 
            (elder_name, service_date, time_slot, purpose_of_outing) 
            VALUES (?, ?, ?, ?)";
    
    // Using Prepared Statements for security
    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ssss", $elder_name, $service_date, $time_slot, $purpose_of_outing);
        
        // 5. Execute the statement
        if ($stmt->execute()) {
            echo "<h2>Success!</h2>";
            echo "<p>Your escort service request has been successfully submitted. We will contact you shortly.</p>";
            echo '<p><a href="index.html">Go back to the homepage</a></p>';

            // Optional: Redirect the user instead of displaying a success message
            // header("location: success.html"); 
            // exit();
        } else {
            echo "ERROR: Could not execute query: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        echo "ERROR: Could not prepare statement.";
    }
}

// 6. Close connection
$conn->close();
?>