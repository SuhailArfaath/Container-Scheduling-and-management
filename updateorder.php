<?php 
include("connection.php");
include("functions.php");

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        print_r($_POST);
        $quantity = (int)$_POST['quantity'];
        $order_id = (int)$_POST['order_id'];
        echo $quantity;

        $query = "update orders set quantity = '{$quantity}' where order_id = '{$order_id}'";
        mysqli_query($con, $query);
        header("Location: myorders.php");
        die;
    }
        