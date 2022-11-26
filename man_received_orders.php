<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
$user_id = $user_data['user_id'];

if($_SERVER['REQUEST_METHOD'] == "GET")
{
   
    

        // Reading from the data base
        $query = "select * from manufacturer_orders where exporter_company_id = '{$user_id}'";

        $result = mysqli_query($con, $query);

        if($result)
        {
            if($result && mysqli_num_rows($result) > 0)
            {
                $orders_data = mysqli_fetch_all($result);
            }
            else
            {
                header("Location: noorder.php");
                die;
            }
        }
    
    else{
        echo "problem in getting data";
    }

}

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    // print_r($_POST);
    $check_flag = 0;
    $status = $_POST['status'];
    $product_id = $_POST['product_id'];
    $exporter_id = $_POST['exporter_id'];
    // $harbor_id = $_POST['harbor_id'];

    
    $query = "select order_id,harborId, exporter_company_id,quantity from manufacturer_orders where product_id = '{$product_id}' and exporter_company_id = '{$user_id}' order by order_id desc limit 1";
    $result = mysqli_query($con, $query);
    $data = mysqli_fetch_all($result);
    $harbor_id =  $data[0][1];
    $exporter_id = $data[0][2];
    $accepted_quantity = $data[0][3];
    $manufacturerorder_id = $data[0][0];


    $query = "select productQuantity from harbor_stock_room where exporterId = '{$exporter_id}' and productId = '{$product_id}'  and harborId = '{$harbor_id}'";
    $result = mysqli_query($con, $query);
    $order_data = mysqli_fetch_all($result);
    
    if(count($order_data) == 0)
    {
        $existing_quantity = 0;
        $check_flag = 1;
    }
    else
    {
        echo "existing quantity:";
        // print_r($order_data);
        $existing_quantity = $order_data[0][0];
    }
   

    // $query = "select quantity,harborId from manufacturer_orders where product_id = '{$product_id}' and exporter_company_id = '{$user_id}'";
    // $result = mysqli_query($con, $query);
    // $order_data = mysqli_fetch_all($result);
    // $accepted_quantity = $order_data[0][0];
    // $harborId = $order_data[0][1];
    $new_quantity = (int)$existing_quantity + (int)$accepted_quantity;
    // echo $existing_quantity,$new_quantity,"Quant done",$harbor_id;
    // print_r($data);

    if($check_flag == 1)
    {
        $query = "insert into harbor_stock_room (harborId,productId,productQuantity,exporterId) values ('{$harbor_id}', '{$product_id}', '{$new_quantity}', '{$exporter_id}')";

        mysqli_query($con, $query);
        $check_flag = 0;

    }
    else
    {
        $query = "update harbor_stock_room set productQuantity ='{$new_quantity}' WHERE productId = '{$product_id}' and harborId = '{$harbor_id}' and exporterId = '{$exporter_id}'";

        mysqli_query($con, $query);
    }
    
    // Updating the quantity in products table

    // $query = "update products set quantity ='{$new_quantity}' WHERE product_id = '{$product_id}'";

    // mysqli_query($con, $query);
    
    // deleting the inventory order from manufacturer_orders table
    $query = "delete from manufacturer_orders where order_id = '{$manufacturerorder_id}' and product_id = '{$product_id}' and exporter_company_id = '{$exporter_id}' and harborid = '{$harbor_id}'";

    mysqli_query($con, $query);

   
    header("Location: orderaccepted.php");
    die;
    // if ($status == "accept")
    // {

    // }
    // // print_r($real_data['product_id']);
    // $product_id = $real_data['product_id'];
    // $product_name = $real_data['product_name'];

    // $manufacturer_id = $real_data['manufacturerId'];
    // // echo $manufacturer_id;
    // $quantity = $real_data['quantity'];

    // $query = "insert into manufacturer_orders (exporter_company_id,exporter_name,product_id,product_name,manufacturer_id,quantity) values ('{$user_id}', '{$exporter_name}', '{$product_id}', '{$product_name}','{$manufacturer_id}','{$quantity}')";

    // mysqli_query($con, $query);
    // header("Location: index.php");
    // die;
    // $product_id = $_POST['product_id'];
    // // When the user clicks on the buy product button
    // $query = "select * from products where product_id='{$product_id}'";

    // $result = mysqli_query($con, $query);
    // // print_r( $result);

    // if($result)
    // {
    //     if($result && mysqli_num_rows($result) > 0)
    //     {
    //         $product_data = mysqli_fetch_all($result);
    //     }
    // 

    // else{
    //     echo "problem in getting data";
    // }
    

    //     // Reading from the data base
        
}


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  </head>
  <body >
    <div class="container-fluid">
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">C S M</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Importer
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="test.php">Place order</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="myorders.php">My orders</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="addwarehouse.php">Add warehouse</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Exporter
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="received_loading_orders.php">Received orders</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="manufacturerorder.php">Order inventory</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="addproducts.php">Add products</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="allproducts.php">View all products</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Admin
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="addusers.php">Add users</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="viewusers.php">View all users</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="addharbour.php">Add a harbor</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="addcontainer.php">Add container</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="addmanufacturer.php">Add manufacturer</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="addtrucks.php">Add trucks</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="addtruckingcompanies.php">Add trucking company</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="adddrivers.php">Add driver</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="addship.php">Add ships</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="addshippingcompanies.php">Add shipping company</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="adddrivers.php">Add driver</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="add_FFC.php">Add freight forwarding company</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Orders
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="received_loading_orders.php">Load container</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="shipping_orders.php">Sea shipping order</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="arrived_status.php">Ships arrival</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="truckingorder.php">Truck shipping order</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Trucking and warehouse access
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="orders_trucking.php">Orders for trucking company</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="orders_warehouse.php">Orders for warehouses</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="orders_driver.php">Orders for drivers</a></li>
                    </ul>
                </li>
                

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Manufacturer
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="man_received_orders.php">Export orders</a></li>
                    </ul>
                </li>
            </ul>
            
                <span class="align-middle mr-2">
                    <h1 class="display-4 fs-5 text-center ">Welcome, <?php echo $user_data['user_name']; ?> </h1>
                </span>
                <a href="logout.php">
                    <button class="btn btn-warning  ml-2" type="submit">Log out</button>
                </a>
            </div>
        </div>
    </nav>
</div>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-6">
            <h1 class="display-4 fs-2 text-center"><b>Container Management System</b></h1>
        </div>
    </div>
  
  
      

      <div class="row mt-4">
          <h1 class="display-4 fs-3 "><b>Your orders</b></h1>  
          <table class="table">
            <thead>
                <tr>
                <th scope="col">Order_id</th>
                <th scope="col">Product_name</th>
                <th scope="col">Exporter_name</th>
                <th scope="col">Quantity</th>
                </tr>
            </thead>
            <tbody>
            <?php for ($row = 0; $row < count($orders_data); $row++) {?>
              <tr>
                <th scope="row"><?php echo $orders_data[$row][0] ?></th>
                <td><?php echo $orders_data[$row][5] ?></td>
                <td><?php echo $orders_data[$row][3] ?></td>
                <td><?php echo $orders_data[$row][7] ?></td>
                <td>
                    <form action= "man_received_orders.php" method = "post">
                                    <input type="hidden"  name="product_id" value="<?php echo $orders_data[$row][4]; ?>" />
                                    <input type="hidden"  name="exporter_id" value="<?php echo $orders_data[$row][1]; ?>"/>
                                    <input type="hidden"  name="harbor_id" id="harbor_id" value="abc" onload="setHarborId('<?php echo $orders_data[$row][4]; ?>')"/>
                                    <input type="hidden"  name="status" value="<?php echo "accept"; ?>"/>
                                    <button type="submit" class="btn btn-success">
                                    <?php echo "accept" ?>
                                    </button>
                                </form>
                </td>    
              </tr>
              <?php } ?>
            </tbody>
          </table>     
      </div>
</div>
      <footer class="footer">
        <div class=" text-center bg-light">
          <a href="index.php">
              <button class="btn btn-danger  m-2" type="button">Back</button>
          </a>
        </div>
      </footer>
      <script>
        function setHarborId(product_id)
        {
            data = JSON.parse(localStorage.getItem(parseInt(product_id)))
            console.log(data,product_id,parseInt(product_id));
            document.getElementById('harbor_id').value = data["harborId"];
        }
      </script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>

