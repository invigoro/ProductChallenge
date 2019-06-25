<html>
<?php include './navbar.php';?>
    <div class="container" style="margin-top:80px">
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
$result3 = getTop5Products();
$result4 = getBottom5Products();

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

//get the top 5 best selling categories
if ($result1 || mysqli_num_rows($result1) > 0) {
    echo "<div class='col'><h2 class='display-4'>Top Selling Categories</h2></div></div><br><br><div class='row text-center'>";
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

//get the bottom 5 selling categories
if ($result2 || mysqli_num_rows($result2) > 0) {
echo "<div class='col'><h2 class='display-4'>Lowest Selling Categories</h2></div></div><br><br><div class='row text-center'>";
while($row = mysqli_fetch_assoc($result2)) {
   echo "<div class='col-md'><h3>" . $row['category'] . "</h3>";
   echo "<p>" . $row['sqs'] . " items sold</p></div>";
}
}
else {
echo "No categories";
}

//start a new row in our responsive grid
echo "</div><br><br><hr>";
echo "<div class='row text-center'>";

//get the top 5 selling products
if ($result3 || mysqli_num_rows($result3) > 0) {
echo "<div class='col'><h2 class='display-4'>Top Selling Items</h2></div></div><br><br><div class='row text-center'>";
while($row = mysqli_fetch_assoc($result3)) {
   echo "<div class='col-md'><h3>" . $row['name'] . "</h3>";
   echo "<img class='img-fluid rounded img-thumbnail' src='" . $row['image'] . "'>";
   echo "<p>" . $row['quantitysold'] . " sold</p>";
   echo "<form action='product.php' method='GET'>" . "<input type='hidden' name='id' value='" . $row["productid"] . "'>" . "<input class='btn btn-info' type='submit' value='See Details'></form></div>";
}
}
else {
echo "No categories";
}

//start a new row in our responsive grid
echo "</div><br><br>";
echo "<div class='row text-center'>";

//get the bottom 5 selling products
if ($result4 || mysqli_num_rows($result4) > 0) {
echo "<div class='col'><h2 class='display-4'>Lowest Selling Items</h2></div></div><br><br><div class='row text-center'>";
while($row = mysqli_fetch_assoc($result4)) {
   echo "<div class='col-md'><h3>" . $row['name'] . "</h3>";
   echo "<img class='img-fluid rounded img-thumbnail' src='" . $row['image'] . "'>";
   echo "<p>" . $row['quantitysold'] . " sold</p>";
   echo "<form action='product.php' method='GET'>" . "<input type='hidden' name='id' value='" . $row["productid"] . "'>" . "<input class='btn btn-info' type='submit' value='See Details'></form></div>";
}
}
else {
echo "No categories";
}

//start a new row in our responsive grid
echo "</div><br><br>";
echo "<div class='row text-center'>";

//button to go to list page
echo "<div class='col'><a href='./list.php' class='btn btn-info btn-block btn-lg' role='button'>See All Products</a></div>";

echo "</div><br><br>"; //end the reign of tyranny of this grid layout

mysqli_close($conn);

?>
</div>
</html>

