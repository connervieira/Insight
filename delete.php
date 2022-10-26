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




// Delete any visits that need to be deleted.
$deleted_count = 0; // This is a placeholder that will be incremented by 1 for each visit entry deleted.
foreach ($visit_database as $key => $information) { // Iterate through all recorded visits in the database.
    if ($_GET["ip"] !== "" and $_GET["ip"] !== null and $_GET["ip"] == $information["ip"]) { // Check to see if this entry matches the IP to remove.
        unset($visit_database[$key]); // Remove this visit from the database.
        $deleted_count++;
    }
    if ($_GET["os"] !== "" and $_GET["os"] !== null and $_GET["os"] == $information["os"]) { // Check to see if this entry matches the OS to remove.
        unset($visit_database[$key]); // Remove this visit from the database.
        $deleted_count++; // Increment the deleted counter.
    }
    if ($_GET["url"] !== "" and $_GET["url"] !== null and $_GET["url"] == $information["url"]) { // Check to see if this entry matches the URL to remove.
        unset($visit_database[$key]); // Remove this visit from the database.
        $deleted_count++; // Increment the deleted counter.
    }
    if ($_GET["time"] !== "" and $_GET["time"] !== null and $_GET["time"] == $information["time"]) { // Check to see if this entry matches the timestamp to remove.
        unset($visit_database[$key]); // Remove this visit from the database.
        $deleted_count++; // Increment the deleted counter.
    }
}


file_put_contents($config["database_location"], serialize($visit_database)); // Save the database to the disk.

?>

<!DOCTYPE>
<html lang="en">
    <head>
        <title>Insight - Delete</title>
    </head>
    <body>
        <main>
            <?php
                if ($deleted_count > 0) { // Check to see if any entries were deleted.
                    echo "<p>Deleted " . $deleted_count . " entries.</p>";
                }
            ?>
            <form method="get">
                <label for="ip">IP: </label><input type="text" id="ip" name="ip"><br>
                <label for="os">OS: </label><input type="text" id="os" name="os"><br>
                <label for="url">URL: </label><input type="text" id="url" name="url"><br>
                <label for="time">Time: </label><input type="text" id="time" name="time"><br>
                <input type="submit">
            </form>
        </main>
    </body>
</html>
