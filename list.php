<html>
<?php include './navbar.php';
session_start();
$sort;
$order;
if(isset($_SESSION['order']) && isset($_SESSION['sort'])) {
    if(isset($_GET['sort'])) {
        if($_GET['sort'] == $_SESSION['sort']) { //if it's the same category to sort by, reverse the order
            if($_SESSION['order'] == 'ASC') { //flip order
                $order = 'DESC';
            }
            else {
                $order = 'ASC';
            }
        }
        else {
            $order = 'ASC';
        }
        $sort = $_GET['sort'];
    }
    else {
        $sort = $_SESSION['sort'];
        $order = $_SESSION['order'];
    }
}
else {
    //set the sort to be by product name, ascending by default
    $order = 'ASC';
    $sort = 'name';
}
$_SESSION['order'] = $order;
$_SESSION['sort'] = $sort;

?>
    <div class="container-fluid" style="margin-top:80px">
        <h1 class='text-center display-3'>Product List</h1>
        <table class="table table-striped table-hover"> <!--DEFINE HEAD OF TABLE TO BE POPULATED BY SQL-->
            <thead class='thead-dark'>
                <tr>
                    <?php //forms for each table header. submit sets the order in which the table will be sorted
                    echo "<th><form action='list.php' method='GET'><input type='hidden' name='sort' value='name'>" . "<input class='no-but' type='submit' value='Product Name'></form></th>";
                    echo "<th><form action='list.php' method='GET'><input type='hidden' name='sort' value='productid'>" . "<input class='no-but' type='submit' value='Product ID'></form></th>";
                    echo "<th><form action='list.php' method='GET'><input type='hidden' name='sort' value='quantityavailable'>" . "<input class='no-but' type='submit' value='Quantity Available'></form></th>";
                    echo "<th><form action='list.php' method='GET'><input type='hidden' name='sort' value='quantitysold'>" . "<input class='no-but' type='submit' value='Quantity Sold'></form></th>";
                    echo "<th><form action='list.php' method='GET'><input type='hidden' name='sort' value='category'>" . "<input class='no-but' type='submit' value='Category'></form></th>";
                    echo "<th></th>";
                    ?>
                </tr>
            </thead>
            <tbody>
                
<?php
include '../sqlfunctions.php';

$result = allProducts($sort, $order);

if ($result || mysqli_num_rows($result) > 0) {
    //output available items from each row 
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>"; 
        echo "<td style='font-size: 1.2em; font-weight: 500'>" . $row['name'] . "</td>";
        echo "<td>" . $row['productid'] . "</td>";
        echo "<td>" . $row['quantityavailable'] . "</td>";
        echo "<td>" . $row['quantitysold'] . "</td>";
        echo "<td>" . $row['category'] . "</td>";
        //take user to the page of the specific product
        echo "<td><form action='product.php' method='GET'>" . "<input type='hidden' name='id' value='" . $row["productid"] . "'>" . "<input class='btn btn-info' type='submit' value='See Details >>'></form></td>";
        echo "</tr>";
    }
}
else {
    echo "No items available.";
}
mysqli_close($conn);
?>

    
</tbody>
</table>
    </div>
</body>
</html>