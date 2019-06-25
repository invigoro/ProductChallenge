<html>
<?php include './navbar.php';?>
    <div class="container" style="margin-top:80px">
    <h1 class='text-center display-2'>Product Categories</h1><br><br>
<?php
include '../sqlfunctions.php';
session_start();

//do some SQL queries to get our stats
$result1 = getTop5Categories();
$result2 = getBottom5Categories();
$result3 = countProductsInCategories();

echo "<div class='row text-center'>"; //start the first row of our responsive grid

//get the top 5 best selling categories
if ($result1 || mysqli_num_rows($result1) > 0) {
    echo "<div class='col'><h2 class='display-4'>Top Selling Categories</h2></div></div><br><br><div class='row text-center align-items-end'>";
    while($row = mysqli_fetch_assoc($result1)) {
       echo "<div class='col-md'><h3>" . $row['category'] . "</h3>";
       echo "<img class='img-fluid rounded img-thumbnail' src='" . $row['img'] . "'>";
       echo "<p>" . $row['sqs'] . " items sold</p>";
       echo "<form action='category.php' method='GET'>" . "<input type='hidden' name='id' value='" . $row["category"] . "'>" . "<input class='btn btn-info' type='submit' value='See Details'></form></div>";
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
echo "<div class='col'><h2 class='display-4'>Lowest Selling Categories</h2></div></div><br><br><div class='row text-center align-items-end'>";
while($row = mysqli_fetch_assoc($result2)) {
   echo "<div class='col-md'><h3>" . $row['category'] . "</h3>";
   echo "<img class='img-fluid rounded img-thumbnail' src='" . $row['img'] . "'>";
   echo "<p>" . $row['sqs'] . " items sold</p>";
   echo "<form action='category.php' method='GET'>" . "<input type='hidden' name='id' value='" . $row["category"] . "'>" . "<input class='btn btn-info' type='submit' value='See Details'></form></div>";
}
}
else {
echo "No categories";
}

//start a new row in our responsive grid
echo "</div><br><br>";
echo "<div class='row text-center'>";

//get all categories and number of products in them
if ($result3 || mysqli_num_rows($result3) > 0) {
    echo "<div class='col'><h2 class='display-3 jumbotron'>All Categories</h2></div></div><br><br><div class='row text-center align-items-end'>";
    $count = 1;
    while($row = mysqli_fetch_assoc($result3)) {
       echo "<div class='col-md-3'><h3>" . $row['category'] . " (" . $row['cc'] . ")</h3>";
       echo "<img class='img-fluid rounded img-thumbnail' src='" . $row['img'] . "'><br><br>";
       echo "<form action='category.php' method='GET'>" . "<input type='hidden' name='id' value='" . $row["category"] . "'>" . "<input class='btn btn-info' type='submit' value='See Details'></form></div>";
       if($count % 4 == 0) {
           echo "</div><br><br><div class='row text-center align-items-end'>";
       }
       $count++;
    }
    }
    else {
    echo "No categories";
    }

//start a new row in our responsive grid
echo "</div><br><br>";
echo "<div class='row text-center'>";

//button to go to list page
echo "<div class='col'><a href='./list.php' class='btn btn-info btn-block btn-lg' role='button'>Go to Products</a></div>";

echo "</div><br><br>"; //end the reign of tyranny of this grid layout

mysqli_close($conn);

?>
</div>
</html>

