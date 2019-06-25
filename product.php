<html>
<?php include './navbar.php';?>
    <div class="container" style="margin-top:80px">
<?php
include '../sqlfunctions.php';
session_start();
unset($_SESSION['order']);
unset($_SESSION['sort']);

if(!isset($_GET['id'])) {
    echo "Item not specified.";
}
else {
    $result1 = getProductInfo($_GET['id']);
    if ($result1 && mysqli_num_rows($result1) == 1) {
        //output available items from each row 
        while($row = mysqli_fetch_assoc($result1)) {
            $result2 = getStatsCategory($row['category']); //get the average values of price, quantity available, and quantity sold for items in the same category
            if($result2 && mysqli_num_rows($result2) == 1) {
            $avgs = mysqli_fetch_assoc($result2);

            echo "<div class='row text-center'>";
            echo "<div class='col'><h1 class='display-2'>" . $row['name'] . "</h1>"
            . "<p>Product ID: " . $row['productid'] . " &#183 Category: " . $row['category'] . "</p>"
            . "<img src=\"" . $row['image'] . "\" width='300px'></div></div>";
            echo "<br><br><div class='row text-center'>";

            //calculate the differences between the product's info and the avg for other items in the same category
            $aqadiff = round(($row['quantityavailable'] - $avgs['aqa']) / $avgs['aqa'] * 100);
            $aqsdiff = round(($row['quantitysold'] - $avgs['aqs']) / $avgs['aqs'] * 100);
            $pdiff = round(($row['price'] - $avgs['aprice']) / $avgs['aprice'] * 100);

            //change text color depending on whether it's above or below avg
            //for quantity available
            echo "<div class='col-md-4'><h1 class='display-3'>" . $row['quantityavailable'] . "</h1><p>Available</p>";
            if ($aqadiff <= 0) {
                echo "<h1 class='text-danger display-3'>" . $aqadiff * -1 . "%</h1><p class='text-danger'>Below";
            }
            else {
                echo "<h1 class='text-success display-3'>" . ($aqadiff). "%</h1><p class='text-success'>Above";
            }
            echo " the average for " . $row['category'] . "</p></div>";

            //for quantity sold
            echo "<div class='col-md-4'><h1 class='display-3'>" . $row['quantitysold'] . "</h1><p>Sold</p>";
            if ($aqsdiff <= 0) {
                echo "<h1 class='text-danger display-3'>" . ($aqsdiff * -1) . "%</h1><p class='text-danger'>Below";
            }
            else {
                echo "<h1 class='text-success display-3'>" . $aqsdiff . "%</h1><p class='text-success'>Above";
            }
            echo " the average for " . $row['category'] . "</p></div>";

            //for price
            echo "<div class='col-md-4'><h1 class='display-3'>$" . $row['price'] . "</h1><p>Price</p>";
            if ($pdiff <= 0) {
                echo "<h1 class='text-danger display-3'>" . ($pdiff * -1) . "%</h1><p class='text-danger'>Below";
            }
            else {
                echo "<h1 class='text-success display-3'>" . $pdiff. "%</h1><p class='text-success'>Above";
            }
            echo " the average for " . $row['category'] . "</p></div>";
        }}
    }
    else {
        echo "<div class='display-4 text-center'>No item with id '" . $_GET['id'] . "' available.</div>";
    }
    echo "</div><br><br>";
    echo "<div class='row text-center'>";
    
    //button to go to list page
    echo "<div class='col'><a href='./list.php' class='btn btn-info btn-block btn-lg' role='button'>Go to Products</a></div>";
    
    echo "</div><br><br>"; //end the reign of tyranny of this grid layout
   mysqli_close($conn);
}
