<?php
include('../dbConnection.php');

// Add status column with default value 'pending'
$sql1 = "ALTER TABLE assignwork_tb ADD COLUMN status VARCHAR(20) DEFAULT 'pending'";
if($conn->query($sql1) == TRUE){
    echo "Status column added successfully<br>";
} else {
    echo "Error adding status column: " . $conn->error . "<br>";
}

// Add completion_date column
$sql2 = "ALTER TABLE assignwork_tb ADD COLUMN completion_date DATETIME DEFAULT NULL";
if($conn->query($sql2) == TRUE){
    echo "Completion date column added successfully<br>";
} else {
    echo "Error adding completion_date column: " . $conn->error . "<br>";
}

// Update existing records to have 'pending' status
$sql3 = "UPDATE assignwork_tb SET status = 'pending' WHERE status IS NULL";
if($conn->query($sql3) == TRUE){
    echo "Existing records updated successfully<br>";
} else {
    echo "Error updating existing records: " . $conn->error . "<br>";
}

echo "<br>All operations completed. You can now go back to the work orders page.";
?> 