<?php
session_start();

include("connection.php");
include("functions.php");
$user_data = check_login($con);
$user_id = $user_data['user_id'];

$fetched_containers = 0;


// $get_containers = "select containerId,ISO6346_Code from containers WHERE ownerCompanyId = '{$user_id}'";

// $result = mysqli_query($con, $get_containers);
// // print_r( $result);

// if($result)
// {
//     if($result && mysqli_num_rows($result) > 0)
//     {
//         $containers_data = mysqli_fetch_all($result);
//         // print_r($harbors_data);
//     }
// }

// $get_harbors = "select harborId,harborName from harbors";

// $result = mysqli_query($con, $get_harbors);
// // print_r( $result);

// if($result)
// {
//     if($result && mysqli_num_rows($result) > 0)
//     {
//         $harbors_data = mysqli_fetch_all($result);
//         // print_r($harbors_data);
//     }
// }

$get_exporters = "select user_id,user_name from users where account_type = 'Exporter'";

$result = mysqli_query($con, $get_exporters);
// print_r( $result);

if($result)
{
    if($result && mysqli_num_rows($result) > 0)
    {
        $exporters_data = mysqli_fetch_all($result);
        // print_r($products_data);
    }
}

else{
echo "problem in getting data";
}

$get = "select product_name,product_id from products where exporter_id = '{$user_id}'";

$result = mysqli_query($con, $get);
// print_r( $result);

if($result)
{
    if($result && mysqli_num_rows($result) > 0)
    {
        $products_data = mysqli_fetch_all($result);
        // print_r( $products_data);

    }
}

else{
echo "problem in getting data";
}

if($_SERVER['REQUEST_METHOD'] == "GET")
{   
    // $order_id = $_GET['oid'];
    // $query = "select warehouseId from orders where order_id = '{$order_id}'";
    // $result = mysqli_query($con, $query);
    // $warehousedata = mysqli_fetch_all($result);
    // $warehouseId = $warehousedata[0][0];
    
    // $query = "select harbor_Id from warehouses where warehouse_id = '{$warehouseId}'";
    // $result = mysqli_query($con, $query);
    // $destinationHarbordata = mysqli_fetch_all($result);
    // $destinationHarborId = $destinationHarbordata[0][0];

    // echo $warehouseId,$sourceHarborId;

    $departure_harbors = "select harborId,harborName from harbors";

    $result = mysqli_query($con, $departure_harbors);
    // print_r( $result);

    if($result)
    {
        if($result && mysqli_num_rows($result) > 0)
        {
            $harbors_data = mysqli_fetch_all($result);
            // print_r($harbors_data);
        }
    }
    // echo sizeof($_GET,1);
    // print_r( $_GET);
    // if (sizeof($_GET,1) == 1)
    // {
    //     $order_id = $_GET['oid'];
    //     // Reading from the data base
    //     $query = "select * from orders where order_id = '{$order_id}'";

    //     $result = mysqli_query($con, $query);
    //     // print_r( $result);

    //     if($result)
    //     {
    //         if($result && mysqli_num_rows($result) > 0)
    //         {
    //             $order_data = mysqli_fetch_all($result);
    //             // print_r( $order_data);
    //             // $selected_product_flag = 1;
    //         }
    //     }

        


    // }
    if (sizeof($_GET,1) == 1)
    {
        // $order_id = $_GET['hid'];
        // print_r( $_GET);
        $harborid = $_GET['hid'];
        // $onShip = "No";
        // $capacity = 2;
        // Reading from the data base
        // $query = "select * from containers where sourceHarborId = '{$harborid}' and destinationHarborId in (0,'{$destinationHarborId}') and capacity <> '{$capacity}'";
        $query = "select distinct shipID from shipping_order where destinationHarborId = '{$harborid}'";

        $result = mysqli_query($con, $query);
        // print_r( $result);

        if($result)
        {
            if($result && mysqli_num_rows($result) > 0)
            {
                $ship_data = mysqli_fetch_all($result);
                // print_r( $selected_product_data);
                $fetched_containers = 1;
            }
        }
        // Reading from the data base
        // $query = "select * from orders where order_id = '{$order_id}'";

        // $result = mysqli_query($con, $query);
        // print_r( $result);

        // if($result)
        // {
        //     if($result && mysqli_num_rows($result) > 0)
        //     {
        //         $order_data = mysqli_fetch_all($result);
        //         // print_r( $order_data);
        //         // $selected_product_flag = 1;
        //     }
        // }

    }

   
}



if($_SERVER['REQUEST_METHOD'] == "POST")
{
    // print_r($_POST);
   
    $real_data = json_decode($_POST['total'],true);
    // $containerId = $real_data['containerId'];
    $shipId = $real_data['shipId'];

    $arrived = "Yes";
    $update_shipping_order = "update shipping_order set arrived = '{$arrived}' where shipID = '{$shipId}'";
    $result = mysqli_query($con, $update_shipping_order);
    // Setting the destinationId for all the containers in the ship
    $get_container = "select containerId from shipping_order where shipID = '{$shipId}'";
    $result = mysqli_query($con, $get_container);
    $container_data = mysqli_fetch_all($result);
    for ($x = 0; $x < count($container_data); $x++) {
        $get_destinationId = "select destinationHarborId from containers where containerId = '{$container_data[$x][0]}'";
        $result = mysqli_query($con, $get_destinationId);
        $destinationId_data = mysqli_fetch_all($result);
        $update_container = "update containers set sourceHarborId  = '{$destinationId_data[0][0]}' where containerId = '{$container_data[$x][0]}'";
        $result = mysqli_query($con, $update_container);
    } 

    header("Location: success.php");
    die;
    // $source = $container_data[0][3];
    // $destination = "0000";

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
            <div class="col-6">
                <img src="ship.jpg" class="img-fluid" alt="Responsive image">
                
                    <ul>
                        <li><p class="mt-4"> Select the appropriate details to mark the ships "Arrived".</p> </li>
                    </ul>
            </div>
            <div class="col-6">
                <div class="card p-2">
                    <div class="card-body"> 
                        <form action="arrived_status.php" method = "post" enctype="multipart/form-data">
                            <div class="mb-4">
                                    <label for="exampleFormControlInput1" class="form-label">Select your harbor</label>
                                    <div class="dropdown">
                                    <select class="form-select" aria-label="Default select example" onchange="location = this.value;" onclick="setHarbor()" id="harbor">
                                        <option selected>Choose harbor from the list</option>
                                        <?php for ($row = 0; $row < count($harbors_data); $row++) { ?>
                                            <option name="<?php echo $harbors_data[$row][0]; ?>" value="http://localhost/Container-Scheduling-and-management/arrived_status.php?hid=<?php echo $harbors_data[$row][0]; ?>">
                                                <?php echo $harbors_data[$row][1]; ?>
                                            </option>
                                        <?php }?>
                                    </select>
                                    </div>                  
                                    
                            </div>
                                    
                            <div class="mb-4">
                                <label for="exampleFormControlInput1" class="form-label">Choose ship at your harbor</label>

                                <div class="dropdown">
                                    <select class="form-select" aria-label="Default select example" onchange="setShipId()" id="shipId">
                                        <option selected>Choose ship Id</option>
                                        <?php if($fetched_containers == 1) { ?>
                                        <?php for ($row = 0; $row < count($ship_data); $row++) { ?>
                                            
                                            <option value="<?php echo $ship_data[$row][0];?>" >
                                                <?php echo $ship_data[$row][0]; ?>
                                            </option>
                                        <?php }?>
                                        <?php }?>

                                    </select>
                                </div>
                            </div>
                          
                            <input type="hidden" name="total" id="poster" value="abc"/>  
                            <button type="submit" onclick = "setJson()"class="btn btn-primary">Arrived</button>
                        </form>
                    </div>

                  </div>
            </div>
        </div>
        
    </div>

    <script>
         
        var containerId = 0;
        var harborId = 0;
        var productId = 0;
        var shipId = 0;

        function setHarbor()
        {
            var subjectIdNode = document.getElementById('harbor');
            harborId = subjectIdNode.options[subjectIdNode.selectedIndex].value;
            harborId.split("?")[0];
            console.log("The selected name=" + harborId);

        }
        function setShipId()
        {
            var subjectIdNode = document.getElementById('shipId');
            shipId = subjectIdNode.options[subjectIdNode.selectedIndex].value;
            console.log("ship_Id:",shipId);
        }
        function setProduct()
        {
            var subjectIdNode = document.getElementById('product');
            productId = subjectIdNode.options[subjectIdNode.selectedIndex].value;
            // console.log("The selected name=" + productId);

        }
        function setJson()
        {
            var poster =  document.getElementById("poster");
            var order_data = {
                    "shipId"    : parseInt(shipId)
                    }
            json_data = JSON.stringify(order_data);
            console.log("Data:",json_data);
            poster.value = json_data;


        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>