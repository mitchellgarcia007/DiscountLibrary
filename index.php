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

    <div class="form-group" style="width:200px;float:right;margin-bottom:50px">
      <label for="sel1">Industry</label>
      <select class="form-control" id="industrySelect" onchange="industrySelected(this.value)">
        <option value="">All</option>
        <option value="home">Home</option>
        <option value="electronics">Electronics</option>
      </select>
    </div>

    <table class="table table-hover" style="margin-top:50px" id="myTable">
        <thead>
        <tr>
            <th class="text-center">Image</th>
            <th>Promotion Info.</th>
            <th>Description</th>
            <th>Industry</th>
        </tr>
        </thead>
        <tbody>

        <?php
            $sql = " SELECT * FROM discountsInfo ORDER BY startDateTime ASC ";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                $id = trim($row["id"]);
                $image = trim($row["image"]);
                $companyName = trim($row["companyName"]);
                $discountName = trim($row["discountName"]);
                $discountDescription = trim($row["discountDescription"]);
                $startDateTime = date_create($row["startDateTime"]);
                $startDateTime_formatted = date_format($startDateTime, 'm/d/Y h:i:sa');
                $endDateTime = date_create($row["endDateTime"]);
                $endDateTime_formatted = date_format($endDateTime, 'm/d/Y h:i:sa');
                $industry = trim($row["industry"]);

                echo "<tr>";
                    echo "<td class='text-center'><img src='img/$image' style='max-width:200px'></td>";
                    echo "<td style='vertical-align: middle;'>";
                        echo "<p><strong>Company</strong> $companyName</p>";
                        echo "<p><strong>Promotion</strong> $discountName</p>";
                        echo "<p><strong>Starts</strong> $startDateTime_formatted</p>";
                        echo "<p><strong>Ends</strong> $endDateTime_formatted</p>";
                        echo "<p><strong>Industry</strong> $industry</p>";
                    echo "</td>";
                    echo "<td style='vertical-align: middle;'>$discountDescription</td>";
                    echo "<td>$industry</td>";
                echo "</tr>";
            }
        ?>
        
        </tbody>
    </table>

</div>

 <script>
    function industrySelected(str){
        var value = str.toLowerCase();
        $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    }
</script> 

</body>
</html>
