<html>
<?php include './navbar.php';?>
    <div class="container-fluid" style="margin-top:80px">
<?php
include '../sqlfunctions.php';
session_start();

$result1 = selectAllCategories();
$result2 = selectAllCategories();
if ($result || mysqli_num_rows($result) > 0) {
        //output available items from each row 
    while($row = mysqli_fetch_assoc($result)) {
        echo "<h1>" . $row['name'] . "</h1>";
        echo "<img src=\"" . $row['image'] . "\" width='300px'>";
        echo "<p>Product ID: " . $row['productid'] . "</p>";
        echo "<p>Quantity Available: " . $row['quantityavailable'] . "</p>";
        echo "<p>Quantity Sold: " . $row['quantitysold'] . "</p>";
        echo "<p>Price: $" . $row['price'] . "</p>";
        echo "<pCategory: " . $row['category'] . "</p>";
    }
}
else {
    echo "No categories";
}

mysqli_close($conn);

