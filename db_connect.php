<?php
/**
 * ElderAssist Database Connection File (db_connect.php)
 * Uses MySQLi Object-Oriented Style.
 */

// 1. Define Connection Parameters (XAMPP Defaults)
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', ''); // Must be empty if you haven't set a root password
define('DB_NAME', 'elderassist_db'); // Must match the database name exactly

// 2. Establish the Database Connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// 3. Check Connection for Errors
if ($conn->connect_error) {
    // If connection fails, stop the script and display a detailed error
    // If you see this, check XAMPP and the DB_NAME in phpMyAdmin.
    die("Connection Failed: " . $conn->connect_error);
} 

// The $conn object is now ready to use for queries.
?>