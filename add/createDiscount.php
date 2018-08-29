<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include $_SERVER['DOCUMENT_ROOT']."/connection.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $solution = mysqli_real_escape_string($conn, $_POST["solution"]);
    $companyName = mysqli_real_escape_string($conn, $_POST["companyName"]);
    $promotionName = mysqli_real_escape_string($conn, $_POST["promotionName"]);
    $promotionDescription = mysqli_real_escape_string($conn, $_POST["promotionDescription"]);
    $siteURL = mysqli_real_escape_string($conn, $_POST["siteURL"]);
    $startDate = mysqli_real_escape_string($conn, $_POST["startDate"]);
    $startDateHour = mysqli_real_escape_string($conn, $_POST["startDateHour"]);
    $startDateMinute = mysqli_real_escape_string($conn, $_POST["startDateMinute"]);
    $startDateAMPM = mysqli_real_escape_string($conn, $_POST["startDateAMPM"]);
    $endDate = mysqli_real_escape_string($conn, $_POST["endDate"]);
    $endDateHour = mysqli_real_escape_string($conn, $_POST["endDateHour"]);
    $endDateMinute = mysqli_real_escape_string($conn, $_POST["endDateMinute"]);
    $endDateAMPM = mysqli_real_escape_string($conn, $_POST["endDateAMPM"]);
    $industry = mysqli_real_escape_string($conn, $_POST["industry"]);
    $industry = strtolower($industry);
    $newIndustry = mysqli_real_escape_string($conn, $_POST["newIndustry"]);
    $newIndustry = strtolower($newIndustry);

    if($newIndustry){
        $industry = $newIndustry;
    }
    
    $startDateString = strtotime($startDate);
    $startDateMonth = date('m', $startDateString);
    $startDateDay = date('d', $startDateString);
    $startDateYear = date('Y', $startDateString);

    $endDateString = strtotime($endDate);
    $endDateMonth = date('m', $endDateString);
    $endDateDay = date('d', $endDateString);
    $endDateYear = date('Y', $endDateString);

    if($startDateAMPM == "PM"){
        $startDateHourFormatted = $startDateHour + 12;
    }
    else{
        $startDateHourFormatted = $startDateHour;
    }

    if($endDateAMPM == "PM"){
        $endDateHourFormatted = $endDateHour + 12;
    }
    else{
        $endDateHourFormatted = $endDateHour;
    }

    $startDateFinal=mktime($startDateHourFormatted, $startDateMinute, 00, $startDateMonth, $startDateDay, $startDateYear);
    $startDateFinal = date("Y-m-d H:i:s", $startDateFinal);

    $endDateFinal=mktime($endDateHourFormatted, $endDateMinute, 00, $endDateMonth, $endDateDay, $endDateYear);
    $endDateFinal = date("Y-m-d H:i:s", $endDateFinal);

    date_default_timezone_set("America/Los_Angeles");
    $dateCreated = date("Y-m-d H:i:s"); //LA time

    $sql2 = " INSERT INTO discountsInfo (active, solution, companyName, discountName, discountDescription, startDateTime, endDateTime, industry, siteURL) 
    VALUES (1, '$solution', '$companyName', '$promotionName', '$promotionDescription', '$startDateFinal', '$endDateFinal', '$industry', '$siteURL') ";
    $result2 = mysqli_query( $conn, $sql2 );
    if($result2){

        // Get last event id
        $promotionID = mysqli_insert_id($conn);

        // Only store image data if user uploaded an image     
        if($_FILES['eventImage']['size'] != 0){

            $eventImageName_Original = $_FILES['eventImage']['name'];
            $eventImageExtension = pathinfo($eventImageName_Original, PATHINFO_EXTENSION);
            $eventImageName = $promotionID.".".$eventImageExtension;
            $eventImageType = $_FILES['eventImage']['type'];
            $eventImageSize = $_FILES['eventImage']['size'];
            // image file directory
            $target = "../img/".basename($eventImageName);
            $sql3 = " UPDATE discountsInfo SET image='$eventImageName' WHERE id='$promotionID' ";
            $result3 = mysqli_query( $conn, $sql3 );
            if($result3){
                move_uploaded_file($_FILES['eventImage']['tmp_name'], $target);
                //correctImageOrientation($destinationFilename);
            }
        }
        
        header('Location: /');
        die;
    }
    else{
        die("Please go back.");
    }

}

?>