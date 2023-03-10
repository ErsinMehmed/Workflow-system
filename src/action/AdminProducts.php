<?php
date_default_timezone_set('Europe/Sofia');

include 'dbconn.php';
include 'function.php';

error_reporting(E_ERROR | E_PARSE);

//Create product
if (isset($_POST['admin_product_order'])) {

    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $kind = $_POST['kind'];
    $supplier = $_POST['supplier'];
    $manufacturer = $_POST['manufacturer'];
    $onePrice = $_POST['onePrice'];
    $price = $_POST['price'];
    $date = date('Y-m-d H:i:s');

    if (!$name || !$quantity || !$supplier || !$manufacturer || !$onePrice) {
        jsonResponse(500, 'Попълнете всички полета');
    } else {
        $query = "SELECT * FROM stocks WHERE name = '$name'";
        $query_go = mysqli_query($con, $query);

        if (mysqli_num_rows($query_go) == 1) {

            while ($rows = mysqli_fetch_array($query_go)) {
                $quantityStock = $rows['quantity'];
                $quantityResult = $quantityStock + $quantity;

                $queryy = "UPDATE stocks SET quantity = '$quantityResult' WHERE name = '$name'";
                $query_run = mysqli_query($con, $queryy);

                $queryyy = "INSERT INTO product_orders (name,quantity,kind,supplier,manufacturer,price_per_one,total_price,date) VALUES ('$name','$quantity','$kind','$supplier','$manufacturer','$onePrice','$price','$date')";
                $query_runn = mysqli_query($con, $queryyy);

                jsonResponseMain2($query_run, $query_runn, 'Успешно добавена поръчка', 'Неуспешно добавяне на поръчка');
            }
        } else {
            jsonResponse(500, 'Продукт с име ' . $name . ' не съществува');
        }
    }
}

// Delete order 
if (isset($_POST['admin_delete_team'])) {

    $id = $_POST['id'];

    $query = "SELECT * FROM product_orders WHERE id = '$id'";
    $query_run = mysqli_query($con, $query);

    while ($row = mysqli_fetch_array($query_run)) {
        $quantityProduct = $row["quantity"];
        $name = $row["name"];

        $queryy = "SELECT * FROM stocks WHERE name = '$name'";
        $query_runn = mysqli_query($con, $queryy);

        while ($rows = mysqli_fetch_array($query_runn)) {
            $quantity = $rows["quantity"];

            if ($quantityProduct <= $quantity) {
                $quantity = $quantity - $quantityProduct;

                $query1 = "UPDATE stocks SET quantity = '$quantity' WHERE name = '$name'";
                $query_runnn = mysqli_query($con, $query1);

                $query2 = "DELETE FROM product_orders WHERE id = '$id'";
                $query_runnnn = mysqli_query($con, $query2);

                jsonResponseMain2($query_runnn, $query_runnnn, 'Успешно изтриване', 'Неуспешно изтриване');
            } else {
                jsonResponse(500, 'Няма достатъчна наличност в склад за да бъде изтрита тази поръчка');
            }
        }
    }
}
