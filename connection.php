<?php
    $conn = mysqli_connect("db750917595.db.1and1.com", "dbo750917595", "DiscountLibrary1!", "db750917595");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>