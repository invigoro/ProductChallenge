<html>
<?php include './navbar.php';?>
    <div class="container" style="margin-top:80px">
<?php
include '../sqlfunctions.php';
session_start();

if(!isset($_GET['id'])) {
    echo "Item not specified.";
}
else {

    //define variables and get statistic from SQL database
    $cat = $_GET['id'];
    $products = selectByCategory($cat); 
    $globalstats = getStatsCategories();
    $localstats = getStatsCategory($cat);
    $bestsell = getBestProductByCategory($cat);
    $worstsell = getWorstProductByCategory($cat);
    $mostavail = getMostAvailableProductByCategory($cat);
    $worstavail = getLeastAvailableProductByCategory($cat);
    $cheapest = getCheapestProductByCategory($cat);
    $priciest = getMostExpensiveProductByCategory($cat);
    
    if ($localstats || mysqli_num_rows($localstats) > 0) {
        //grab the stats for this specific category
        while($row = mysqli_fetch_assoc($localstats)) {
            
            if($globalstats && mysqli_num_rows($globalstats) == 1) { //get global stats for all categories
            $avgs = mysqli_fetch_assoc($globalstats);

            echo "<div class='row text-center'>";
            echo "<div class='col'><h1 class='display-2'>" . $cat . "</h1></div></div>";

            //total profit, products available/sold, and unique products
            echo "<br><br><div class='row text-center'>";

            echo "<div class='col-md'>";
            echo "<h2 class='display-4'>" . number_format($row['c']) . "</h2>";
            echo "<p>Unique Products Listed</p>";
            echo "</div>";

            echo "<div class='col-md'>";
            echo "<h2 class='display-4'>" . number_format($row['sqa']) . "</h2>";
            echo "<p>Total Available</p>";
            echo "</div>";

            echo "<div class='col-md'>";
            echo "<h2 class='display-4'>" . number_format($row['sqs']) . "</h2>";
            echo "<p>Total Sold</p>";
            echo "</div></div>";
            echo "<div class='row text-center'>";

            //display the total gross profit
            echo "<div class='col jumbotron'>";
            echo "<h2 class='display-2'>$" . number_format($row['profit']) . "</h2>";
            echo "<p>Gross Profit from " . $cat . "</p>";
            echo "</div>";


            echo "</div><div class='row text-center'>";

            //calculate the differences between the category's info and the avg for all other categories
            $aqadiff = round(($row['aqa'] - $avgs['aqa']) / $avgs['aqa'] * 100);
            $aqsdiff = round(($row['aqs'] - $avgs['aqs']) / $avgs['aqs'] * 100);
            $pdiff = round(($row['aprice'] - $avgs['aprice']) / $avgs['aprice'] * 100);

            //change text color depending on whether it's above or below avg
            //for quantity available
            echo "<div class='col-md-4'><h1 class='display-3'>" . $row['aqa'] . "</h1><p>Avg. Available</p>";
            if ($aqadiff <= 0) {
                echo "<h1 class='text-danger display-3'>" . $aqadiff * -1 . "%</h1><p class='text-danger'>Below";
            }
            else {
                echo "<h1 class='text-success display-3'>" . ($aqadiff). "%</h1><p class='text-success'>Above";
            }
            echo " the average for all categories</p></div>";

            //for quantity sold
            echo "<div class='col-md-4'><h1 class='display-3'>" . $row['aqs'] . "</h1><p>Avg. Sold</p>";
            if ($aqsdiff <= 0) {
                echo "<h1 class='text-danger display-3'>" . ($aqsdiff * -1) . "%</h1><p class='text-danger'>Below";
            }
            else {
                echo "<h1 class='text-success display-3'>" . $aqsdiff . "%</h1><p class='text-success'>Above";
            }
            echo " the average for all categories</p></div>";

            //for price
            echo "<div class='col-md-4'><h1 class='display-3'>$" . $row['aprice'] . "</h1><p>Avg. Price</p>";
            if ($pdiff <= 0) {
                echo "<h1 class='text-danger display-3'>" . ($pdiff * -1) . "%</h1><p class='text-danger'>Below";
            }
            else {
                echo "<h1 class='text-success display-3'>" . $pdiff. "%</h1><p class='text-success'>Above";
            }
            echo " the average for all categories</p></div>";
        }}
        echo "</div>";


    }
    else {
        echo "<div class='display-4 text-center'>No item with id '" . $_GET['id'] . "' available.</div>";
    }

    //new rows for products stats

    //best selling item
    echo "<br><br><div class='row text-center align-items-end'>";
    if ($bestsell || mysqli_num_rows($bestsell) > 0) {
        while($row = mysqli_fetch_assoc($bestsell)) {
            echo "<div class='col-md'>";
            echo "<h1 class='display-3'>Best Selling</h1>";
            echo "<h3>" . $row['name'] . "</h3>";
            echo "<img class='img-fluid rounded img-thumbnail' src='" . $row['image'] . "'><br><br>";
            echo "<form action='product.php' method='GET'>" . "<input type='hidden' name='id' value='" . $row["productid"] . "'>" . "<input class='btn btn-info' type='submit' value='See Details'></form></div>";
        }
    }

    //worst selling item
     if ($worstsell || mysqli_num_rows($worstsell) > 0) {
         //grab the stats for this specific category
         while($row = mysqli_fetch_assoc($worstsell)) {
             echo "<div class='col-md'>";
             echo "<h1 class='display-3'>Worst Selling</h1>";
             echo "<h3>" . $row['name'] . "</h3>";
             echo "<img class='img-fluid rounded img-thumbnail' src='" . $row['image'] . "'><br><br>";
             echo "<form action='product.php' method='GET'>" . "<input type='hidden' name='id' value='" . $row["productid"] . "'>" . "<input class='btn btn-info' type='submit' value='See Details'></form></div>";
         }
     }

     
     echo "</div><br><br><div class='row text-center align-items-end'>";
    
     //best stocked item
    if ($mostavail || mysqli_num_rows($mostavail) > 0) {
        while($row = mysqli_fetch_assoc($mostavail)) {
            echo "<div class='col-md'>";
            echo "<h1 class='display-3'>Best Stocked</h1>";
            echo "<h3>" . $row['name'] . "</h3>";
            echo "<img class='img-fluid rounded img-thumbnail' src='" . $row['image'] . "'><br><br>";
            echo "<form action='product.php' method='GET'>" . "<input type='hidden' name='id' value='" . $row["productid"] . "'>" . "<input class='btn btn-info' type='submit' value='See Details'></form></div>";
        }
    }

    //worst stocked item
     if ($worstavail || mysqli_num_rows($worstavail) > 0) {
         //grab the stats for this specific category
         while($row = mysqli_fetch_assoc($worstavail)) {
             echo "<div class='col-md'>";
             echo "<h1 class='display-3'>Worst Stocked</h1>";
             echo "<h3>" . $row['name'] . "</h3>";
             echo "<img class='img-fluid rounded img-thumbnail' src='" . $row['image'] . "'><br><br>";
             echo "<form action='product.php' method='GET'>" . "<input type='hidden' name='id' value='" . $row["productid"] . "'>" . "<input class='btn btn-info' type='submit' value='See Details'></form></div>";
         }
     }

     
     echo "</div><br><br><div class='row text-center align-items-end'>";
    
     //cheapest item
    if ($cheapest || mysqli_num_rows($cheapest) > 0) {
        while($row = mysqli_fetch_assoc($cheapest)) {
            echo "<div class='col-md'>";
            echo "<h1 class='display-3'>Least Expensive</h1>";
            echo "<h3>" . $row['name'] . "</h3>";
            echo "<img class='img-fluid rounded img-thumbnail' src='" . $row['image'] . "'><br><br>";
            echo "<form action='product.php' method='GET'>" . "<input type='hidden' name='id' value='" . $row["productid"] . "'>" . "<input class='btn btn-info' type='submit' value='See Details'></form></div>";
        }
    }

    //most expensive item
     if ($priciest || mysqli_num_rows($priciest) > 0) {
         //grab the stats for this specific category
         while($row = mysqli_fetch_assoc($priciest)) {
             echo "<div class='col-md'>";
             echo "<h1 class='display-3'>Most Expensive</h1>";
             echo "<h3>" . $row['name'] . "</h3>";
             echo "<img class='img-fluid rounded img-thumbnail' src='" . $row['image'] . "'><br><br>";
             echo "<form action='product.php' method='GET'>" . "<input type='hidden' name='id' value='" . $row["productid"] . "'>" . "<input class='btn btn-info' type='submit' value='See Details'></form></div>";
         }
     }
     echo "</div><br><br>";
     
     echo "<div class='row text-center'>";
     
     //get all categories and number of products in them
     if ($products|| mysqli_num_rows($products) > 0) {
         echo "<div class='col'><h2 class='display-3 jumbotron'>All Products in " . $cat . "</h2></div></div><br><br><div class='row text-center align-items-end'>";
         $count = 1;
         while($row = mysqli_fetch_assoc($products)) {
            echo "<div class='col-md-3'><h3>" . $row['name'] . "</h3>";
            echo "<img class='img-fluid rounded img-thumbnail' src='" . $row['image'] . "'><br><br>";
            echo "<form action='product.php' method='GET'>" . "<input type='hidden' name='id' value='" . $row["productid"] . "'>" . "<input class='btn btn-info' type='submit' value='See Details'></form></div>";
            if($count % 4 == 0) {
                echo "</div><br><br><div class='row text-center align-items-end'>";
            }
            $count++;
         }
         }
         else {
         echo "No products";
         }
     
     //start a new row in our responsive grid
     echo "</div><br><br>";
     echo "<div class='row text-center'>";
     
     //button to go to list page
     echo "<div class='col'><a href='./list.php' class='btn btn-info btn-block btn-lg' role='button'>Go to Products</a></div>";
     
     echo "</div><br><br>"; //end the reign of tyranny of this grid layout
    mysqli_close($conn);
}
