<?php
    include $_SERVER['DOCUMENT_ROOT']."/connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>USI Discounts Library</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel='stylesheet' type='text/css' href='http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css'/>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
</head>
<body style="overflow-x:hidden;margin-bottom:400px">

<nav class="navbar navbar-inverse" style="border-radius:0px"> 
  <div class="container-fluid">
    <div class="navbar-header" style="width:100%">
        <a class="navbar-brand" href="/">USI Discounts Library</a>
    </div>
  </div>
</nav>
  
<div class="container">
  <h3 class="text-center"> Add Discount </h3>

    <div id="divForm">

        <form id="createDiscount" action="createDiscount.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="">Company Name:</label>
                <input type="text" class="form-control" id="companyName" name="companyName" required>
            </div>
            <div class="form-group">
                <label for="">Promotion Name:</label>
                <input type="text" class="form-control" id="promotionName" name="promotionName" required>
            </div>
            <div class="form-group">
                <label for="">Promotion Description:</label>
                <input type="text" class="form-control" id="promotionDescription" name="promotionDescription" required>
            </div>
            <div class="form-group">
                <label for="">Site URL:</label>
                <input type="text" class="form-control" id="siteURL" name="siteURL" required>
            </div>
            <div class="form-group">
                <label for="">Promotion Start Date:</label>
                <input type="text" class="form-control" placeholder="Click here to select the Start Date" name="startDate" id="datepickerStartDate" readonly required>
            </div>
            <div class="form-group">
                <label for="">Promotion Start Time:</label><br>
                <select class="form-control" name="startDateHour" style="width:80px;display:inline" required>
                    <option value="">Hour</option>
                    <?php 
                        for ($startTime = 1; $startTime <= 12; $startTime++) {
                            echo "<option value='$startTime'>$startTime</option>";
                        } 
                    ?>
                </select>
                <span><strong>:</strong></span>
                <select class="form-control" name="startDateMinute" style="width:90px;display:inline" required>
                    <option value="">Minute</option>
                    <option value="00">00</option>
                    <option value="30">30</option>
                </select>
                <select class="form-control" name="startDateAMPM" style="width:95px;display:inline" required>
                    <option value="">AM/PM</option>
                    <option value="AM">AM</option>
                    <option value="PM">PM</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">Promotion End Date:</label>
                <input type="text" class="form-control" placeholder="Click here to select the End Date" name="endDate" id="datepickerEndtDate" readonly required>
            </div>
            <div class="form-group">
                <label for="">Promotion End Time:</label><br>
                <select class="form-control" name="endDateHour" style="width:80px;display:inline" required>
                    <option value="">Hour</option>
                    <?php 
                        for ($startTime = 1; $startTime <= 12; $startTime++) {
                            echo "<option value='$startTime'>$startTime</option>";
                        } 
                    ?>
                </select>
                <span><strong>:</strong></span>
                <select class="form-control" name="endDateMinute" style="width:90px;display:inline" required>
                    <option value="">Minute</option>
                    <option value="00">00</option>
                    <option value="30">30</option>
                </select>
                <select class="form-control" name="endDateAMPM" style="width:95px;display:inline" required>
                    <option value="">AM/PM</option>
                    <option value="AM">AM</option>
                    <option value="PM">PM</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">Promotion Image:</label>
                <input type="file" name="eventImage">
            </div>
            <div class="form-group">
                <label for="">Industry:</label>
                <select class="form-control" id="industry" name="industry" onchange="industrySelected(this.value)" required>
                    <option value="">Select an Industry</option>
                    <?php
                        $sql2 = " SELECT DISTINCT industry FROM discountsInfo ORDER BY industry ASC ";
                        $result2 = mysqli_query($conn, $sql2);
                        while($row = mysqli_fetch_assoc($result2)){
                            $industry = $row["industry"];
                            echo "<option value='$industry'>".ucwords($industry)."</option>";
                        }
                    ?>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group newIndustryDiv hidden">
                <label for="">New Industry:</label>
                <input type="text" class="form-control" id="newIndustry" name="newIndustry" required>
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
        </form>

    </div>

</div>

<style>
#divForm{
    margin: 50px auto;
    max-width: 700px;
    height: auto;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    border-radius: 3px;
    padding: 60px 30px 60px 30px;
}
</style>

<script>
$(document).ready(function(){
    $("#datepickerStartDate, #datepickerEndtDate").datepicker({
        minDate: 0,
        dateFormat: "m/d/yy",
        buttonText: "Select date",
    });    

    $("form").submit(function(e){
        if(!$("#datepickerStartDate").val()){
            e.preventDefault();
            alert("Please select a start date.");
            return;
        }
        if(!$("#datepickerEndtDate").val()){
            e.preventDefault();
            alert("Please select an end date.");
            return;
        }

        $( "#createDiscount" ).submit();
    });
});

function industrySelected(str){
    var value = str.toLowerCase();
    if(value == "other"){
        $(".newIndustryDiv").removeClass("hidden");
    }
    else{
        $(".newIndustryDiv").addClass("hidden");
        $("#newIndustry").val("");
    }
}
</script>

</body>
</html>
