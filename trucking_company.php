<?php
session_start();

include("connection.php");
include("functions.php");
$user_data = check_login($con);
$user_id = $user_data['user_id'];


$get_ships = "select * from ships";

$result = mysqli_query($con, $get_ships);
// print_r( $result);

if($result)
{
    if($result && mysqli_num_rows($result) > 0)
    {
        $ships_data = mysqli_fetch_all($result);
        // print_r($harbors_data);
    }
}

$get_trucks = "select * from trucks";

$result = mysqli_query($con, $get_trucks);
// print_r( $result);

if($result)
{
    if($result && mysqli_num_rows($result) > 0)
    {
        $trucks_data = mysqli_fetch_all($result);
        // print_r($harbors_data);
    }
}

$get_harbors = "select harborId,harborName from harbors";

$result = mysqli_query($con, $get_harbors);
// print_r( $result);

if($result)
{
    if($result && mysqli_num_rows($result) > 0)
    {
        $harbors_data = mysqli_fetch_all($result);
        // print_r($harbors_data);
    }
}

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

$get_drivers = "select * from drivers";

$result = mysqli_query($con, $get_drivers);
// print_r( $result);

if($result)
{
    if($result && mysqli_num_rows($result) > 0)
    {
        $drivers_data = mysqli_fetch_all($result);
        // print_r( $products_data);

    }
}

else{
echo "problem in getting data";
}

if($_SERVER['REQUEST_METHOD'] == "GET")
{
    // print_r( $_GET['product_id']);
    $trucking_order_id = $_GET['tid'];
    // Reading from the data base
    $query = "select * from truck_orders where truckOrderId = '{$trucking_order_id}'";

    $result = mysqli_query($con, $query);
    // print_r( $result);

    if($result)
    {
        if($result && mysqli_num_rows($result) > 0)
        {
            $trucking_order_data = mysqli_fetch_all($result);
            // print_r( $loading_order_data);
            // $selected_product_flag = 1;
        }
    }

    else{
        echo "problem in getting data";
    }
}

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    // print_r($_POST);
    $trucking_order_id = $_POST['truckingcontainerId'];
    $mileage =  $_POST['mileage'];
    $eta = $_POST['eta'];
    $arrival_date = $_POST['arrival_date'];
    $pickup_time = $_POST['pickup_time'];
    $real_data = json_decode($_POST['total'],true);
    $driver_id = $real_data['driverId'];
    $truck_id = $real_data['truck_id'];
    $accepted = "Yes";
    $query = "update truck_orders set truckId='{$truck_id}', driverId = '{$driver_id}' ,acceptedByTruckCom ='{$accepted}',arriveDate='{$arrival_date}',pickupTime='{$pickup_time}' where truckOrderId = '{$trucking_order_id}'";

    mysqli_query($con, $query);
    header("Location: success_accepted.php");
    die;
    // $containerId = $_POST['containerId'];
    // $sourceHarborId = $_POST['sourceHarborId'];
    // $destinationHarborId = $_POST['destinationHarborId'];
    // $arrivalDate = $_POST['arrival_date'];
    // // Changing the date format
    // $formatDate = explode("-",$arrivalDate);
    // $c = $formatDate[0];
    // $formatDate[0] = $formatDate[1];
    // $formatDate[1] = $formatDate[2];
    // $formatDate[2] = $c;
    // $formattedDate = implode("-",$formatDate);
    // $arrivalDate = $formattedDate;

    

    // $real_data = json_decode($_POST['total'],true);
    // $onShipDate = $real_data['onShipDate'];
    // $ship_id = $real_data['shipId'];
    // $ffcId = $user_id;

    // // echo $ship_id;

    // $query = "insert into shipping_order (containerId,sourceHarborId,destinationHarborId,FFCId,shipID,onShipDate,arrivalDate,arrived,completedByTruck) values ('{$containerId}', '{$sourceHarborId}', '{$destinationHarborId}', '{$ffcId}', '{$ship_id}', '{$onShipDate}', '{$arrivalDate}', 0,0)";

    // mysqli_query($con, $query);
    // $status = 1;
    
    // $query = "update loading_orders set onShip ='{$status}' where containerId = '{$containerId}'";

    // mysqli_query($con, $query);

    // $onShip = "Yes";
    
    // $query = "update containers set onShip ='{$onShip}' where containerId = '{$containerId}'";

    // mysqli_query($con, $query);

    // 
    // When the user clicks on the create account button
    // $harborName = $_POST['harbourName'];
    // $country  = $_POST['country'];
    // $address = $_POST['address'];
    // $telephone = $_POST['telephone'];

    // if((!empty($harborName)) && (!empty($country)) && (!empty($address))&&
    //         (!empty($telephone)))
    //     {

    //         // Saving to data base
    //         $query = "insert into harbors (harborName,country,address,telephone) values ('$harborName','$country','$address','$telephone')";

    //         mysqli_query($con, $query);
    //         // echo '<script>alert("Please enter valid information!")</script>';

    //         header("Location: addharbour.php");
    //         die;
    //     }
    //     else{
    //         echo '<script>alert("Please enter valid information!")</script>';
            
    //     }

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
                <img src="driver.jpg" class="img-fluid" alt="Responsive image">
                
                    <ul>
                        <li><p class="mt-4"> Fill the details to assign a driver for delivery.</p> </li>
                    </ul>
            </div>
            <div class="col-6">
                <div class="card p-2">
                    <div class="card-body"> 
                        <form action="trucking_company.php" method = "post">

                            <div class="mb-2">
                                <label for="exampleFormControlInput1" class="form-label">Trucking order ID</label>
                                <input type="text" class="form-control" id="truckingcontainerId" name = "truckingcontainerId" value=" <?php echo $trucking_order_data[0][0]; ?>" readonly>
                            </div>

                            <div class="mb-2">
                                <label for="exampleFormControlInput1" class="form-label">Distance to cover(miles)</label>
                                <input type="text" class="form-control" id="mileage" name = "mileage" value=" <?php echo $trucking_order_data[0][10]; ?>" readonly>
                            </div>  
                            
                            <div class="mb-2">
                                <label for="exampleFormControlInput1" class="form-label">ETA(minutes)</label>
                                <input type="text" class="form-control" id="eta" name = "eta" value=" <?php echo $trucking_order_data[0][11]; ?>" readonly>
                            </div>  

                            <div class="mb-2">
                                <label for="exampleFormControlInput1" class="form-label">Delivery departure Date and Time (Click on the clock to select time)</label>
                                <input type="datetime-local" id="pickup_time" class="form-control" name="pickup_time">
                                <!-- <input type="text" class="form-control" id="exampleFormControlInput1" name = "grossCubeFeet"> -->
                            </div>

                            <div class="mb-2">
                                <label for="exampleFormControlInput1" class="form-label">Delivery date (Click on the calendar to select date)</label>
                                <input type="date" id="arrival_date" class="form-control" name="arrival_date">
                                <!-- <input type="text" class="form-control" id="exampleFormControlInput1" name = "grossCubeFeet"> -->
                            </div>
                            <div class="mb-2">
                                <label for="exampleFormControlInput1" class="form-label">Select driver</label>
                                
                                <div class="dropdown">
                                    <select class="form-select" aria-label="Default select example" onchange="setdriverId()" id="driver_id">
                                        <option selected>Choose driver from the list</option>
                                        <?php for ($row = 0; $row < count($drivers_data); $row++) { ?>
                                            
                                            <option value="<?php echo $drivers_data[$row][0]; ?>" >
                                                <?php echo $drivers_data[$row][1]; ?>
                                            </option>
                                        <?php }?>
                                    </select>
                                </div>
                                <!-- <input type="hidden" class="form-control" id="exampleFormControlInput1" name = "sourceHarbourId" vlue=""> -->
                            </div>

                            <div class="mb-2">
                                <label for="exampleFormControlInput1" class="form-label">Select truck</label>
                                
                                <div class="dropdown">
                                    <select class="form-select" aria-label="Default select example" onchange="setTruckId()" id="truck_id">
                                        <option selected>Choose truck from the list</option>
                                        <?php for ($row = 0; $row < count($trucks_data); $row++) { ?>
                                            
                                            <option value="<?php echo $trucks_data[$row][0]; ?>" >
                                                <?php echo $trucks_data[$row][1]; ?>
                                            </option>
                                        <?php }?>
                                    </select>
                                </div>
                                <!-- <input type="hidden" class="form-control" id="exampleFormControlInput1" name = "sourceHarbourId" vlue=""> -->
                            </div>

                          
                            <input type="hidden" name="total" id="poster" value="abc"/>  
                            <button  type="submit" onclick = "setJson()"class=" mb-0 btn btn-primary">Confirm</button>
                        </form>
                    </div>

                  </div>
            </div>
        </div>
        
    </div>

    <script>
        var onship = "";
        var driverId = 0;
        var truck_id = 0;
        var productId = 0;

        function setdriverId()
        {
            console.log("The selected name=" + driverId);

            var subjectIdNode = document.getElementById('driver_id');
            driverId = subjectIdNode.options[subjectIdNode.selectedIndex].value;
            console.log("The selected name=" + driverId);

        }

        function setTruckId()
        {
            console.log("The selected name=" + driverId);

            var subjectIdNode = document.getElementById('truck_id');
            truck_id = subjectIdNode.options[subjectIdNode.selectedIndex].value;
            // console.log("The selected name=" + driverId);

        }
        
        function setJson()
        {
            var currentdate = new Date();
            // var date = currentdate.getMonth().toString()+"-"+currentdate.getDate().toString()+"-"+currentdate.getFullYear().toString()
            var poster =  document.getElementById("poster");
            var order_data = {
                    "driverId"    : parseInt(driverId),
                    "truck_id"    : parseInt(truck_id)
                    // "onShipDate" : date
                    }
            json_data = JSON.stringify(order_data);
            poster.value = json_data;


        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>