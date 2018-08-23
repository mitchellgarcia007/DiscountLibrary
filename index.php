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
</head>
<body>

<nav class="navbar navbar-inverse" style="border-radius:0px"> 
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">USI Discounts Library</a>
    </div>
  </div>
</nav>
  
<div class="container">
  <h3 class="text-center">Discounts</h3>

    <table class="table table-hover" style="margin-top:50px">
        <thead>
        <tr>
            <th>Company Name</th>
            <th>Promotion Name</th>
            <th>Description</th>
            <th>Start Date/Time</th>
            <th>End Date/Time</th>
            <th>Industry</th>
        </tr>
        </thead>
        <tbody>

        <?php
            $sql = " SELECT * FROM discountsInfo ";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                $companyName = trim($row["companyName"]);
                $discountName = trim($row["discountName"]);
                $discountDescription = trim($row["discountDescription"]);
                $startDateTime = $row["startDateTime"];
                $endDateTime = $row["endDateTime"];
                $industry = trim($row["industry"]);

                echo "<tr>";
                    echo "<td>$companyName</td>";
                    echo "<td>$discountName</td>";
                    echo "<td>$discountDescription</td>";
                    echo "<td>$startDateTime</td>";
                    echo "<td>$endDateTime</td>";
                    echo "<td>$industry</td>";
                echo "</tr>";
            }
        ?>
        
        </tbody>
    </table>

</div>

</body>
</html>
