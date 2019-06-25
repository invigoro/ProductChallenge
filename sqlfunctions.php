<?php
$host = "localhost";
$username = /**REMOVED FOR GITHUB**/;
$password = /**REMOVED FOR GITHUB**/;
$dbname = /**REMOVED FOR GITHUB**/;

$conn = mysqli_connect($host, $username, $password, $dbname);

if(!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}

function allProducts($sort, $order) { //SELECT ALL PRODUCT IDS, NAMES, CATEGORY, QUANTITIES ORDERED BY SPECIFIED COLUMN AND ASC/DESC
    global $conn;
    $select = "SELECT productid, name, category, quantityavailable, quantitysold FROM product ORDER BY " . $sort . " " . $order . ";";
    $result = mysqli_query($conn, $select);
    return $result;
}

function getProductInfo($pid) {  //SELECT SPECIFIC PRODUCT BY ITS ID
    global $conn;
    $select = "SELECT * FROM product WHERE productid=" . $pid . ";";
    $result = mysqli_query($conn, $select);
    return $result;
}

function selectByCategory($cat) {   //SELECT ALL PRODUCTS IN A SPECIFIED CATEGORY
    global $conn;
    $select = "SELECT * FROM product WHERE category='" . $cat . "';";
    $result = mysqli_query($conn, $select);
    return $result;
}

function selectAllCategories() {    //SELECT ALL PRODUCTS GROUPED BY THEIR CATEGORY
    global $conn;
    $select = "SELECT * FROM product GROUP BY category ORDER BY COUNT(category);";
    $result = mysqli_query($conn, $select);
    return $result;
}

function countProductsInCategories() { //COUNT PRODUCTS AND GET A SAMPLE IMAGE IN EACH CATEGORY
    global $conn;
    $select = "SELECT category, COUNT(category) as cc, MAX(image) as img from product GROUP BY category";
    $result = mysqli_query($conn, $select);
    return $result;
}

function countProductsSoldInCategories() { //COUNT PRODUCTS IN EACH CATEGORY
    global $conn;
    $select = "SELECT category, SUM(quantitysold) AS aqs FROM product GROUP BY category;";
    $result = mysqli_query($conn, $select);
    return $result;
}

function getStatsCategories(){  //GET AVGS FOR CATEGORIES
    global $conn;
    $select = "SELECT AVG(aprice) as aprice, AVG(aqa) as aqa, AVG(aqs) as aqs FROM (SELECT AVG(price) as aprice, AVG(quantityavailable) as aqa, AVG(quantitysold) as aqs FROM product AS T1 GROUP BY category) AS T2;";
    $result = mysqli_query($conn, $select);
    return $result;
}

function getStatsCategory($cat) { //GET AVGS AND SUMS OF STATS FOR SPECIFIED CATEGORY
    global $conn;
    $select = "SELECT COUNT(productid) as c, AVG(price) as aprice, AVG(quantityavailable) as aqa, AVG(quantitysold) as aqs, SUM(price * quantitysold) as profit, SUM(quantityavailable) as sqa, SUM(quantitysold) as sqs FROM product WHERE category='" . $cat . "';";
    $result = mysqli_query($conn, $select);
    return $result;
}

function getTop5Categories() { //best selling categories
    global $conn;
    $select = "SELECT category, SUM(quantitysold) as sqs, MAX(image) as img FROM product GROUP BY category ORDER BY SUM(quantitysold) DESC LIMIT 5;";
    $result = mysqli_query($conn, $select);
    return $result;
}
function getBottom5Categories() { //worst selling categories
    global $conn;
    $select = "SELECT category, SUM(quantitysold) as sqs, MAX(image) as img FROM product GROUP BY category ORDER BY SUM(quantitysold) ASC LIMIT 5;";
    $result = mysqli_query($conn, $select);
    return $result;
}
function getTotalProductsSold() { //total sold from all categories
    global $conn;
    $select = "SELECT SUM(quantitysold) AS sqs FROM product;";
    $result = mysqli_query($conn, $select);
    return $result;
}
function getTotalProductsAvailable() { //total available from all categories
    global $conn;
    $select = "SELECT SUM(quantityavailable) AS sqa FROM product;";
    $result = mysqli_query($conn, $select);
    return $result;
}
function getTotalProductsCarried() { //total unique products
    global $conn;
    $select = "SELECT COUNT(productid) AS ca FROM product;";
    $result = mysqli_query($conn, $select);
    return $result;
}
function getTotalGross() { //total gross profit 
    global $conn;
    $select = "SELECT SUM(quantitysold * price) AS sqtp FROM product;";
    $result = mysqli_query($conn, $select);
    return $result;
}
function getBottom5Products() { //worst selling items
    global $conn;
    $select = "SELECT productid, name, image, quantitysold FROM product ORDER BY quantitysold ASC LIMIT 5;";
    $result = mysqli_query($conn, $select);
    return $result;
}
function getTop5Products() { //best selling items
    global $conn;
    $select = "SELECT productid, name, image, quantitysold FROM product ORDER BY quantitysold DESC LIMIT 5;";
    $result = mysqli_query($conn, $select);
    return $result;
}

function getBestProductByCategory($cat) { //return the best selling product in category
    global $conn;
    $select = "SELECT productid, name, image FROM product WHERE category='$cat' ORDER BY quantitysold DESC LIMIT 1;";
    $result = mysqli_query($conn, $select);
    return $result;
}

function getWorstProductByCategory($cat) { //return the worst selling product in category
    global $conn;
    $select = "SELECT productid, name, image FROM product WHERE category='$cat' ORDER BY quantitysold ASC LIMIT 1;";
    $result = mysqli_query($conn, $select);
    return $result;
}

function getMostAvailableProductByCategory($cat) { //return the most overstocked product in category
    global $conn;
    $select = "SELECT productid, name, image FROM product WHERE category='$cat' ORDER BY quantityavailable DESC LIMIT 1;";
    $result = mysqli_query($conn, $select);
    return $result;
}

function getLeastAvailableProductByCategory($cat) { //return the least product in category
    global $conn;
    $select = "SELECT productid, name, image FROM product WHERE category='$cat' ORDER BY quantityavailable ASC LIMIT 1;";
    $result = mysqli_query($conn, $select);
    return $result;
}

function getCheapestProductByCategory($cat) { //get cheapest
    global $conn;
    $select = "SELECT productid, name, image FROM product WHERE category='$cat' ORDER BY price ASC LIMIT 1;";
    $result = mysqli_query($conn, $select);
    return $result;
}

function getMostExpensiveProductByCategory($cat) { //get most expensive
    global $conn;
    $select = "SELECT productid, name, image FROM product WHERE category='$cat' ORDER BY price DESC LIMIT 1;";
    $result = mysqli_query($conn, $select);
    return $result;
}


?>