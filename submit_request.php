<?php
// submit_request.php

// Enable error reporting for debugging
error_reporting(E_ALL); 
ini_set('display_errors', 1);

// Import the database connection
require_once 'db_connect.php'; 

// Check if the request method is POST and all required fields are present
if ($_SERVER["REQUEST_METHOD"] == "POST" && 
    isset($_POST['name'], $_POST['age'], $_POST['contact'], $_POST['address'], $_POST['serviceNeeded'], $_POST['problemDescription'])) {

    // 1. Sanitize and prepare variables
    $name = trim($_POST['name']);
    // CRITICAL: Ensure age is an integer (for the 'i' binding type)
    $age = intval(trim($_POST['age'])); 
    $contact = trim($_POST['contact']);
    $address = trim($_POST['address']);
    $service_needed = trim($_POST['serviceNeeded']);
    $problem_description = trim($_POST['problemDescription']);

    // 2. Prepare the SQL INSERT statement
    // NOTE: Column names must match your 'requests' table exactly
    $sql = "INSERT INTO requests (name, age, contact, address, service_needed, problem_description) VALUES (?, ?, ?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        
        // 3. Bind parameters: s (name), i (age), s (contact), s (address), s (service), s (description)
        $stmt->bind_param("sissss", $name, $age, $contact, $address, $service_needed, $problem_description);

        // 4. Execute the statement
        if ($stmt->execute()) {
            
            // SUCCESS: Redirect the user back to the home page
            echo "<script>alert('Thank you, your request has been submitted successfully!'); window.location.href='index.html';</script>";
            
        } else {
            // EXECUTION FAILURE: Show the exact MySQL error for immediate debugging
            echo "<h1>Database Submission Error</h1>";
            echo "<p>Failed to execute statement. Check data types and constraints.</p>";
            echo "<p>MySQL Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        // PREPARATION FAILURE: Show the exact connection error (often a SQL syntax mistake)
        echo "<h1>Database Preparation Error</h1>";
        echo "<p>Failed to prepare SQL statement. Check the column names in your query.</p>";
        echo "<p>Connection Error: " . $conn->error . "</p>";
    }

    $conn->close();
} else {
    // FAILURE: The POST request method was not used, or form data was incomplete/missing.
    echo "<script>alert('Error: Data was not received. Please submit the form from the Contact Us section.'); window.location.href='index.html';</script>";
    exit();
}
?>