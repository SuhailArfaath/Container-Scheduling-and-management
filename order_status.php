<?php
session_start();

include("connection.php");
include("functions.php");
$user_data = check_login($con);
$user_id = $user_data['user_id'];

$data_loaded = 0;

$get_drivers = "select * from drivers ";
    $result = mysqli_query($con, $get_drivers);
    // print_r( $result);

    if($result)
    {
        if($result && mysqli_num_rows($result) > 0)
        {
            $drivers_data = mysqli_fetch_all($result);
            // print_r($harbors_data);
        }
    }

if($_SERVER['REQUEST_METHOD'] == "GET")
{

    if (sizeof($_GET,1) == 1)
    {
        // print_r( $_GET['product_id']);
        $order_id = $_GET['oid'];
        // Reading from the data base
        $query = "select * from orders where order_id = '{$order_id}'";
        $result = mysqli_query($con, $query);
        // print_r( $result);

        if($result)
        {
            if($result && mysqli_num_rows($result) > 0)
            {
                $order_data = mysqli_fetch_all($result);
                $order_container = $order_data[0][11];
                $warehouse_delivery =  $order_data[0][9];
              // getting the delivery address from the warehouse
              $query = "select harbor_id from warehouses where warehouse_id = '{$warehouse_delivery}'";
              $result = mysqli_query($con, $query);
          if($result && mysqli_num_rows($result) > 0)
                {
                    $warehouse_data = mysqli_fetch_all($result);
                    $harofwarehouse_id = $warehouse_data[0][0];


                    $query = "select * from harbors where harborId = '{$harofwarehouse_id}'";
                    $result = mysqli_query($con, $query);   
                    if($result && mysqli_num_rows($result) > 0){
                        $harbor_det = mysqli_fetch_all($result);

                        $harbor_na = $harbor_det[0][1];


                    }

                    
                     }
                


                // Getting the container loading status
                $query = "select * from loading_orders where containerId = '{$order_container}'AND buyerOrderId ='{$order_id}'";
                $result = mysqli_query($con, $query);
                if($result && mysqli_num_rows($result) > 0)
                {
                    $container_dat = mysqli_fetch_all($result);
                    $sourceharborId = $container_dat[0][3];
                    $container_loaded = "Yes";
                }
                else
                {
                    
                    $container_loaded = "No";
                }
                // Getting the container shipping status
                $query = "select * from containers where containerId = '{$order_container}'";
                $result = mysqli_query($con, $query);
                if($result && mysqli_num_rows($result) > 0)
                {
                    $container_data = mysqli_fetch_all($result);
                    $onShip = $container_data[0][5];
                  //  $sourceharborId = $container_data[0][3];
                    $destinationharborId = $container_data[0][4];
                    // getting source harbor name
                    $query = "select harborName from harbors where harborId = '{$sourceharborId}'";
                    $result = mysqli_query($con, $query);
                    if($result && mysqli_num_rows($result) > 0)
                    {
                        $harbor_details = mysqli_fetch_all($result);
                        $harbor_name = $harbor_details[0][0];
                    } 
                    // getting destination harbor name
                    $query = "select harborName from harbors where harborId = '{$destinationharborId}'";
                    $result = mysqli_query($con, $query);
                    if($result && mysqli_num_rows($result) > 0)
                    {
                        $harbor_details = mysqli_fetch_all($result);
                        $destination_harbor_name = $harbor_details[0][0];
                    } 
                }
                else
                {
                    $onShip = "No";
                    $harbor_name = "Not available";
                }

        // get whether the container is on ship or not before getting the loaded and arrival dates.
                
    


                // getting the loaded and arrival dates
                $query = "select shipId,onShipDate,arrivalDate from shipping_order where containerId = '{$order_container}'AND importer_orders_in_container LIKE '%$order_id%'";
                $result = mysqli_query($con, $query);
                if($result && mysqli_num_rows($result) > 0)
                {
                    $dates = mysqli_fetch_all($result);
                    $shipId = $dates[0][0];
                    $onShip_date = $dates[0][1];
                    $arrival_date = $dates[0][2];
                }
                else
                {
                    $onShip_date = "MM//DD//YYYY";
                    $arrival_date = "MM//DD//YYYY";
                }



       
                // Getting the delivery by truck status
                $query = "select truckId,driverId,warehouseId,pickedUp,pickupTime,arriveDate from truck_orders where containerId = '{$order_container}'AND importer_orders_in_container LIKE '%$order_id%'";
                $result = mysqli_query($con, $query);
                if($result && mysqli_num_rows($result) > 0)
                {
                    $pick_up_status = mysqli_fetch_all($result);
                    $truckId = $pick_up_status[0][0];
                    $driverId = $pick_up_status[0][1];
                    $warehouseId = $pick_up_status[0][2];
                    $arrive_Date = $pick_up_status[0][5];
                    // Getting driver name
                    $query = "select driverName from drivers where driverId = '{$driverId}'";
                    $result = mysqli_query($con, $query);
                    if($result && mysqli_num_rows($result) > 0)
                    {
                        $driver_details = mysqli_fetch_all($result);
                        $driverName = $driver_details[0][0];
                    }
                    $picked_up = $pick_up_status[0][3];
                    $pickupTime = $pick_up_status[0][4];
                    // Getting warehouse address
                    $query = "select * from warehouses where warehouse_id = '{$warehouseId}'";
                    $result = mysqli_query($con, $query);
                    if($result && mysqli_num_rows($result) > 0)
                    {
                        $warehouse_details = mysqli_fetch_all($result);
                        $warehouse_name = $warehouse_details[0][2];
                        $warehouse_address = $warehouse_details[0][6];
                        $warehouse_contact_number = $warehouse_details[0][5];

                    }

                }
                else
                {
                    $truckId = "Not available";
                    $driverName = "Not available";
                    $picked_up = "Yet to be picked up from the port";
                    $pickupTime = "MM//DD//YYYY";
                    $warehouse_name = "Not available";
                    $warehouse_address =  "Not available";
                    $warehouse_contact_number =  "Not available";
                }

               // If the order_id is present in the truck then only show 
                  // Get the orders from the trucking Orders
              //    $query ="select importer_orders_in_container FROM truck_orders WHERE importer_orders_in_container"


               

                // Getting the delivery status
                $query = "select delivered from truck_orders where containerId = '{$order_container}' AND importer_orders_in_container LIKE '%$order_id%'";
                $result = mysqli_query($con, $query);
                if($result && mysqli_num_rows($result) > 0)
                {
                    $delivered_status = mysqli_fetch_all($result);
                    $delivered = $delivered_status[0][0];
                }
                else
                {
                    $delivered = "Yet to be delivered";
                }
                // Getting the return order status
                $query = "select ifLoadOnReturn from truck_orders where containerId = '{$order_container}'AND importer_orders_in_container LIKE '%$order_id%'";
                $result = mysqli_query($con, $query);
                if($result && mysqli_num_rows($result) > 0)
                {
                    $returned_status = mysqli_fetch_all($result);
                    $returned = $returned_status[0][0];
                }
                else
                {
                    $returned = "Not returned";
                }
                // 
                $data_loaded = 1;
                // header("Location: orders_trucking.php");
                // die;
                // print_r( $loading_order_data);
                // $selected_product_flag = 1;
            }
            // echo "orderId:",$order_container,"container_loaded:",$container_loaded,"onShip:", $onShip_date, $arrival_date,$onShip," picked_up:", $picked_up;
        }

        else{
            echo "problem in getting data";
        }

    }
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
  <body>
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
    <div class="container mt-1">
        <div class="row justify-content-center mt-1">
            
            <div class="col-3 p-3">
                <?php if($container_loaded == "Yes"){ ?>
                    <div>
                        <img src="container_loaded.jpg" class="card-img-top" alt="..." width = "150px" height="250px">
                        <p class="card-text text-center"><b>Order loaded into container</b></p>
                        <hr>
                        <p class="card-text">Details:</p>
                        <p class="card-text"><b>Container Id:</b> <?php echo $order_container; ?></p>
                        <?php if($picked_up != "Yes" && $delivered != "Yes"){ ?>
                        <p class="card-text"><b>Port of loading:</b> <?php echo $harbor_name; ?></p>
                        <p class="card-text"><b>Port of arrival:</b> <?php echo $destination_harbor_name; ?></p>
                        <?php } ?>
                        <?php if(($picked_up == "Yes" || $delivered == "Yes" || $returned == "Yes" )){ ?>
                        <p class="card-text"><b>Port of arrival:</b> <?php echo $harbor_na; ?></p>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if($container_loaded != "Yes"){ ?>
                    <div>
                        <img src="not_yet_loaded.jpeg" class="card-img-top" alt="..." width = "150px" height="250px">
                        <p class="card-text text-center"><b>Your order is yet to be loaded into a container</b></p>
                    </div>
                <?php } ?>
            </div>

            <!-- shipping and transit status -->

            <div class="col-3 p-3">
                <?php if($onShip == "Yes"|| ($onShip != "Yes" && $delivered == "Yes")||($onShip != "Yes" && $returned == "Yes")){ ?>
                    <div>
                        <img src="container_onship.jpg" class="card-img-top" alt="..." width = "150px" height="250px">
                        <p class="card-text text-center"><b>Container loaded onto ship</b></p>
                        <hr>
                        <p class="card-text">Details:</p>
                        <p class="card-text"><b>Ship Id: </b><?php echo $shipId; ?></p>
                        <p class="card-text"><b>Date of loading: </b><?php echo $onShip_date; ?></p>
                        <p class="card-text"><b>Date of arrival: </b><?php echo $arrival_date; ?></p>

                    </div>
                <?php } ?>
                <?php if($onShip != "Yes"  && $delivered != "Yes" && $returned != "Yes"){ ?>
                    <div>
                        <img src="not_yet_shipped.jpeg" class="card-img-top" alt="..." width = "150px" height="250px">
                        <p class="card-text  text-center"><b>Your order is yet to be loaded onto a ship.</b></p>
                    </div>
                <?php } ?>
            </div>

            <!-- truck transit delivery status -->

            <div class="col-3 p-3" >
                <?php if($picked_up == "Yes"){ ?>
                    <div >
                        <img src="transit.jpg" class="card-img-top" alt="..." width = "150px" height="250px">
                        <p class="card-text text-center"><b>In transit</b></p>
                        <hr>
                        <p class="card-text">Details:</p>
                        <p class="card-text"><b>Truck Id: </b><?php echo $truckId; ?></p>
                        <p class="card-text"><b>Picked up at: </b><?php echo $pickupTime; ?></p>
                        <p class="card-text"><b>Delivery Date: </b><?php echo $arrive_Date; ?></p>

                        <p class="card-text"><b>Driver name: </b><?php echo $driverName; ?></p>
                    </div>
                <?php } ?>
                <?php if($picked_up != "Yes"){ ?>
                    <div>
                        <img src="not_yet_transit1.jpeg" class="card-img-top" alt="..." width = "150px" height="250px">
                        <p class="card-text text-center"><b>Your order is yet to be picked up by a truck</b></p>
                    </div>
                <?php } ?>
            </div>

            <!-- delievered/retured status -->

            <div class="col-3 p-3">
                <?php if($delivered == "Yes"){ ?>
                    <div>
                        <img src="greentick.png" class="card-img-top" alt="..." width = "150px" height="250px">
                        <p class="card-text text-center"><b>Delivered</b></p>
                        <hr>
                        <p class="card-text">Details:</p>  
                        <p class="card-text"><b>Delivered at: </b><?php echo $warehouse_name; ?></p> 
                        <p class="card-text"><b>Address: </b><?php echo $warehouse_address; ?></p> 
                        <p class="card-text"><b>Contact number: </b><?php echo $warehouse_contact_number; ?></p>                  
                 
                    </div>
                <?php } ?>
                <?php if($delivered != "Yes" && $returned != "Yes"){ ?>
                    <div>
                        <img src="not_yet_delivered.jpeg" class="card-img-top" alt="..." width = "150px" height="250px">
                        <p class="card-text text-center"><b>Your order is yet to be delivered</b></p>
                    </div>
                <?php } ?>
                <?php if($delivered != "Yes" && $returned == "Yes"){ ?>
                    <div>
                        <img src="returned.png" class="card-img-top" alt="...">
                        <p class="card-text text-center"><b>Your order was returned</b></p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>