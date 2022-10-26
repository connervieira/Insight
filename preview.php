<?php
include "./config.php"; // Import the configuration.
include "./utils.php"; // Import the utilities script.



// Load and initialize the database.
if (file_exists($config["database_location"]) == false) { // If the database file doesn't exist, create it.
    $visit_database_file = fopen($config["database_location"], "w") or die("Unable to create database file!"); // Create the file.
    fwrite($visit_database_file, "a:0:{}"); // Set the contents of the database file to a blank database.
    fclose($visit_database_file); // Close the database file.
}

if (file_exists($config["database_location"]) == true) { // Check to see if the item database file exists. The database should have been created in the previous step if it didn't already exists.
    $visit_database = unserialize(file_get_contents($config["database_location"])); // Load the database from the disk.
} else {
    echo "<p>The database failed to load</p>"; // Inform the user that the database failed to load.
    exit(); // Terminate the script.
}



echo "<pre>";
print_r($visit_database);
echo "</pre>";

?>
