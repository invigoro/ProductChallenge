<html>
<?php include './navbar.php';?>
    <div class="container-fluid" style="margin-top:80px">
    <h1 class='text-center display-2'>Store Overview</h1><br><br>
<?php
include '../sqlfunctions.php';
session_start();

//do some SQL queries to get our stats
$totalproducts = getTotalProductsCarried();
$totalavailable = getTotalProductsAvailable();
$totalsold = getTotalProductsSold();
$totalprofit = getTotalGross();
$result1 = getTop5Categories();
$result2 = getBottom5Categories();

echo "<div class='row text-center'>"; //start the first row of our responsive grid

//show the total number of unique products
if ($totalproducts || mysqli_num_rows($totalproducts) > 0) {
    echo "<div class='col-md-4'>";
    while($row = mysqli_fetch_assoc($totalproducts)) {
        echo "<h2 class='display-4'>" . number_format($row['ca']) . "</h2>";
        echo "<p>Unique Products Listed</p>";
    }
    echo "</div>";
}
else {
    echo "No result";
}

//display the total available products
if ($totalavailable || mysqli_num_rows($totalavailable) > 0) {
    echo "<div class='col-md-4'>";
    while($row = mysqli_fetch_assoc($totalavailable)) {
        echo "<h2 class='display-4'>" . number_format($row['sqa']) . "</h2>";
        echo "<p>Total Items in Stock</p>";
    }
    echo "</div>";
}
else {
    echo "No result";
}

//display the total sold products
if ($totalsold || mysqli_num_rows($totalsold) > 0) {
    echo "<div class='col-md-4'>";
    while($row = mysqli_fetch_assoc($totalsold)) {
        echo "<h2 class='display-4'>" . number_format($row['sqs']) . "</h2>";
        echo "<p>Total Items Sold</p>";
    }
    echo "</div>";
}
else {
    echo "No result";
}

//start a new row in our responsive grid
echo "</div><br><br>";
echo "<div class='row text-center'>";

//display the total gross profit
if ($totalprofit || mysqli_num_rows($totalprofit) > 0) {
    echo "<div class='col jumbotron'>";
    while($row = mysqli_fetch_assoc($totalprofit)) {
        echo "<h2 class='display-2'>$" . number_format($row['sqtp']) . "</h2>";
        echo "<p>Total Gross Profit</p>";
    }
    echo "</div>";
}
else {
    echo "No result";
}

//start a new row in our responsive grid
echo "</div><br><br>";
echo "<div class='row text-center'>";

if ($result1 || mysqli_num_rows($result1) > 0) {
        //output available items from each row 
    echo "<div class='col'><h2 class='display-4'>Best Selling Categories</h2></div></div><br><br><div class='row text-center'>";
    while($row = mysqli_fetch_assoc($result1)) {
       echo "<div class='col-md'><h3>" . $row['category'] . "</h3>";
       echo "<p>" . $row['sqs'] . " items sold</p></div>";
    }
}
else {
    echo "No categories";
}

//start a new row in our responsive grid
echo "</div><br><br>";
echo "<div class='row text-center'>";

mysqli_close($conn);

?>
</div>
</html>

