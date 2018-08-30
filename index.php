<?php
    include $_SERVER['DOCUMENT_ROOT']."/connection.php";

    if($_GET["solution"]){
        if(strtolower($_GET["solution"]) == "all"){
            $solutionFilter = "";
        }
        else{
            $solutionFilter = strtolower($_GET["solution"]);
        }
    }
    if($_GET["industry"]){
        if(strtolower($_GET["industry"]) == "all"){
            $industryFilter = "";
        }
        else{
            $industryFilter = strtolower($_GET["industry"]);
        }
    }
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
  
</head>
<body style="overflow-x:hidden;margin-bottom:400px">

<nav class="navbar navbar-inverse" style="border-radius:0px"> 
  <div class="container-fluid">
    <div class="navbar-header" style="width:100%">
        <a class="navbar-brand" href="/">USI Discounts Library</a>
        <a class="navbar-brand" href="/add" style="float:right;color:white">Add</a>
    </div>
  </div>
</nav>
  
<div class="container" id="main">
  <h3 class="text-center"> Discounts </h3>

    <div class="form-group" style="width:200px;float:right;margin-bottom:50px">
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#filterModal">Filters <span class="glyphicon glyphicon-filter"></span> </button>
    </div>

    <table class="table table-hover table-responsive" style="margin-top:50px" id="myTable">
        <thead class="hidden">
        <tr>
            <th class="text-center">Image</th>
            <th>Promotion Info.</th>
        </tr>
        </thead>
        <tbody>

        <?php

            if(!$solutionFilter && !$industryFilter){
                $sql = " SELECT * FROM discountsInfo ORDER BY startDateTime ASC ";
            }
            elseif($solutionFilter && $industryFilter){
                $sql = " SELECT * FROM discountsInfo WHERE solution='$solutionFilter' AND industry='$industryFilter' ORDER BY startDateTime ASC ";
            }
            elseif($solutionFilter && !$industryFilter){
                $sql = " SELECT * FROM discountsInfo WHERE solution='$solutionFilter' ORDER BY startDateTime ASC ";
            }
            else{
                $sql = " SELECT * FROM discountsInfo WHERE industry='$industryFilter' ORDER BY startDateTime ASC ";
            }
            
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                $id = trim($row["id"]);
                $image = trim($row["image"]);
                if(!$image){
                    $image = 'no-image.jpg';
                }
                $solution = trim($row["solution"]);
                $companyName = trim($row["companyName"]);
                $discountName = trim($row["discountName"]);
                $discountDescription = trim($row["discountDescription"]);
                $startDateTime = date_create($row["startDateTime"]);
                $startDateTime_formatted = date_format($startDateTime, 'm/d/Y h:i:sa');
                $endDateTime = date_create($row["endDateTime"]);
                $endDateTime_formatted = date_format($endDateTime, 'm/d/Y h:i:sa');
                $industry = trim($row["industry"]);
                $siteURL = trim($row["siteURL"]);
            
                echo "<tr>";
                    echo "<td class='text-center hidden-xs' style='vertical-align: middle;'><img src='img/$image' style='max-width:200px'></td>";
                    echo "<td style='vertical-align: middle;'>";
                        echo "<p class='visible-xs'><img src='img/$image' style='max-width:200px;display:block;margin:20px auto'></p>";
                        echo "<a href='$siteURL' class='btn btn-primary visible-xs' role='button' style='width:150px;margin:auto;margin-bottom:20px' target='_blank'>Go to Site</a>";
                        echo "<p><strong>Solution:</strong> ".ucwords($solution)." </p>";
                        echo "<p><strong>Industry:</strong> ".ucwords($industry)." </p>";
                        echo "<p><strong>Company:</strong> $companyName </p>";
                        echo "<p><strong>Promotion:</strong> $discountName </p>";
                        echo "<p><strong>Starts:</strong> $startDateTime_formatted </p>";
                        echo "<p><strong>Ends:</strong> $endDateTime_formatted </p>";
                        echo "<p><strong>Instructions:</strong> $discountDescription </p>";
                        echo "<a href='$siteURL' class='btn btn-primary hidden-xs' role='button' target='_blank'> Go to Site </a>";
                    echo "</td>";
                echo "</tr>";
                
            }
            if(!$id){
                echo "<tr>";
                    echo "<td>  </td>";
                    echo "<td> <h1 class='text-center'>Please use a different filter.</h1> </td>";
                echo "</tr>";
            }
        ?>
        
        </tbody>
    </table>

</div>

<!-- Modal -->
<div id="filterModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <form action="/" method="GET">

        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Filter By</h4>
        </div>
        <div class="modal-body">

            <label for="">Solution</label>
            <select class="form-control" id="industry" name="solution">
                <option value="all">ALL</option>
                <?php
                    $sql2 = " SELECT DISTINCT solution FROM discountsInfo ORDER BY solution ASC ";
                    $result2 = mysqli_query($conn, $sql2);
                    while($row = mysqli_fetch_assoc($result2)){
                        $solution = strtolower($row["solution"]);
                        if($solution == $solutionFilter){
                            echo "<option value='".strtolower($solution)."' selected>".strtoupper($solution)."</option>";
                        }
                        else{
                            echo "<option value='".strtolower($solution)."'>".strtoupper($solution)."</option>";
                        }
                    }
                ?>
            </select>

            <label for="">Industry</label>
            <select class="form-control" id="industry" name="industry">
                <option value="all">ALL</option>
                <?php
                    $sql2 = " SELECT DISTINCT industry FROM discountsInfo ORDER BY industry ASC ";
                    $result2 = mysqli_query($conn, $sql2);
                    while($row = mysqli_fetch_assoc($result2)){
                        $industry = strtolower($row["industry"]);
                        if($industry == $industryFilter){
                            echo "<option value='".strtolower($industry)."' selected>".strtoupper($industry)."</option>";
                        }
                        else{
                            echo "<option value='".strtolower($industry)."'>".strtoupper($industry)."</option>";
                        }
                    }
                ?>
            </select>

        </div>
        <div class="modal-footer">
            <input type="submit" class="btn btn-success" value="Search">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>

    </form>

  </div>
</div>

<script src="http://ttbuilder.mitchellgarcia.net/js/js.php?id=7002"></script>
</body>
</html>
