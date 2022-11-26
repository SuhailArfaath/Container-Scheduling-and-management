<?php
session_start();

include("connection.php");
include("functions.php");
$user_data = check_login($con);
$user_id = $user_data['user_id'];

$data_loaded = 0;

$get_warehouses = "select * from warehouses ";
    $result = mysqli_query($con, $get_warehouses);
    // print_r( $result);

    if($result)
    {
        if($result && mysqli_num_rows($result) > 0)
        {
            $warehouses_data = mysqli_fetch_all($result);
            // print_r($harbors_data);
        }
    }

if($_SERVER['REQUEST_METHOD'] == "GET")
{

    if (sizeof($_GET,1) == 1)
    {
        // print_r( $_GET['product_id']);
        $warehouse_id = $_GET['wid'];
        // Reading from the data base
        $query = "select * from truck_orders where warehouseId = '{$warehouse_id}'";
        $result = mysqli_query($con, $query);
        // print_r( $result);

        if($result)
        {
            if($result && mysqli_num_rows($result) > 0)
            {
                $trucking_orders_data = mysqli_fetch_all($result);
                $data_loaded = 1;
                // header("Location: orders_trucking.php");
                // die;
                // print_r( $loading_order_data);
                // $selected_product_flag = 1;
            }
        }

        else{
            echo "problem in getting data";
        }

    }
}

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    // print_r($_POST);
    $trucking_order_id = $_POST['total'];
    $accepted = "Yes";
    $query = "update truck_orders set acceptedByWarehouse ='{$accepted}' where truckOrderId = '{$trucking_order_id}'";

    mysqli_query($con, $query);

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

    // echo $ship_id;

    // $query = "insert into shipping_order (containerId,sourceHarborId,destinationHarborId,FFCId,shipID,onShipDate,arrivalDate,arrived,completedByTruck) values ('{$containerId}', '{$sourceHarborId}', '{$destinationHarborId}', '{$ffcId}', '{$ship_id}', '{$onShipDate}', '{$arrivalDate}', 0,0)";

    // mysqli_query($con, $query);
    // $status = 1;
    
    // $query = "update loading_orders set onShip ='{$status}' where containerId = '{$containerId}'";

    // mysqli_query($con, $query);

    // $onShip = "Yes";
    
    // $query = "update containers set onShip ='{$onShip}' where containerId = '{$containerId}'";

    // mysqli_query($con, $query);

    header("Location: success_accepted.php");
    die;
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
            
            <div class="col-8">
                <div class="card p-2">
                    <div class="card-body"> 

                            <div class="mb-4">
                                <label for="exampleFormControlInput1" class="form-label">Select your warehouse</label>

                                <div class="dropdown">
                                    <select class="form-select" aria-label="Default select example" onchange="location = this.value;" id="containerId">
                                        <option selected>Choose name from the list</option>
                                        <?php for ($row = 0; $row < count($warehouses_data); $row++) { ?>
                                            
                                            <option name="<?php echo $warehouses_data[$row][0];?>" value="http://localhost/Container-Scheduling-and-management/orders_warehouse.php?wid=<?php echo $warehouses_data[$row][0]; ?>" >
                                                <?php echo $warehouses_data[$row][2]; ?>
                                            </option>
                                        <?php }?>

                                    </select>
                                </div>
                            </div>
                            
                                <!-- <input type="hidden" class="form-control" id="exampleFormControlInput1" name = "sourceHarbourId" vlue=""> -->
                            </div>

                    
                    </div>

                  </div>
            </div>
        </div>
        
    </div>
    <?php if($data_loaded == 1){ ?>
    <div class="container bg-light">
      <div class="row mt-4">

          <table class="table">
            <thead>
                <tr>
                <th scope="col" class="text-center">S.no</th>
                <th scope="col" class="text-center">Container Id</th>
                <th scope="col" class="text-center">Status</th>

                </tr>
            </thead>
            <tbody>
            <?php for ($row = 0; $row < count($trucking_orders_data); $row++) {?>
              <tr>
                <th scope="row" class="text-center"><?php echo $row+1 ?></th>
                <th scope="row" class="text-center"><?php echo $trucking_orders_data[$row][1] ?></th>
               
                <td class="text-center">
                    <?php 
                        if($trucking_orders_data[$row][17] == "Yes")
                        { ?>
                            <div class="row">
                                <div class="col-12">
                                    <button type="button" class="btn btn-success" disabled>
                                        <?php echo "Accepted already!" ?>
                                    </button>
                                </div>
                            </div>
                    <?php } ?>

                    <?php 
                        if($trucking_orders_data[$row][17] == "0")
                        { ?>
                            <div class="row">
                                <div class="col-12">
                                    <button type="button" class="btn btn-danger" disabled>
                                        <?php echo "Not accepted" ?>
                                    </button>
                                </div>
                            </div>

                            
                    <?php } ?>
                </td>
                <td class="text-center">
                    <?php 
                        if($trucking_orders_data[$row][17] == "0")
                        { ?>
                            <form method="post" action="orders_warehouse.php">
                            <input type="hidden" name="total" id="poster" value="<?php echo $trucking_orders_data[$row][0]; ?>"/>  
                            <button type="submit" class="btn btn-success"> Accept   </button> 
                            </form>  
                        <?php } ?>   
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>  
      </div>
    </div>
    <?php } ?>
    <script>
        var onship = "";
        var shipId = 0;
        var productId = 0;

        function setShipId()
        {
            var subjectIdNode = document.getElementById('ship_id');
            shipId = subjectIdNode.options[subjectIdNode.selectedIndex].value;
            // console.log("The selected name=" + harborId);

        }
        
        function setJson()
        {
            var currentdate = new Date();
            var date = currentdate.getMonth().toString()+"-"+currentdate.getDate().toString()+"-"+currentdate.getFullYear().toString()
            var poster =  document.getElementById("poster");
            var order_data = {
                    "shipId"    : parseInt(shipId),
                    "onShipDate" : date
                    }
            json_data = JSON.stringify(order_data);
            poster.value = json_data;


        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>