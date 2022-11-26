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

if($_SERVER['REQUEST_METHOD'] == "GET")
{
    // When the user clicks on the create account button
   
    
        $check_onship = 1;
        // Reading from the data base
        $query = "select distinct containerId from loading_orders where onShip = '{$check_onship}'";

        $result = mysqli_query($con, $query);

        if($result)
        {
            if($result && mysqli_num_rows($result) > 0)
            {
                $onship_data = mysqli_fetch_all($result);
                // echo "loading_orders:";
                // print_r($loaded_containers_data);
                $ships = array();
                for ($x = 0; $x < count($onship_data); $x++) {

                    $query = "select distinct * from shipping_order where containerId = '{$onship_data[$x][0]}' and arrived = 0";
                    $result = mysqli_query($con, $query); 
                    if($result && mysqli_num_rows($result) > 0)
                    {
                        $shipIds = mysqli_fetch_all($result);
                        // for ($y = 0; $y < count($onship_data); $y++) {

                        //     $query = "select distinct * from shipping_order where shipId = '{$shipIds[$y][0]}'";
                        //     $result = mysqli_query($con, $query); 
                        //     if($result && mysqli_num_rows($result) > 0)
                        //     {
                        //         $data = mysqli_fetch_all($result);
                        //     }
                        // }
                    }
                //     print_r($shipIds);
                //     // echo "\n";
                //     // print_r($data);
                }
                print_r($onship_data);
                print_r($shipIds);

            }
            // print_r($toship);
            // else
            // {
            //     header("Location: addproducts.php");
            //     die;
            // }
        }
    
    else{
        echo "problem in getting data";
    }

}
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $containerId = $_POST['total'];
    $arrived = "Yes";
    $update_shipping_order = "update shipping_order set arrived = '{$arrived}' where containerId = '{$containerId}'";
    $result = mysqli_query($con, $update_shipping_order);

    $get_container = "select * from containers where containerId = '{$containerId}'";
    $result = mysqli_query($con, $get_container);
    $container_data = mysqli_fetch_all($result); 
    $source = $container_data[0][3];
    $destination = "0000";
    // echo "SD:",$source,$destination;
    $update_source = "update containers set sourceHarborId = '{$source}',destinationHarborId = '{$destination}' where containerId = '{$containerId}'";
    $result = mysqli_query($con, $update_source);
    // print_r( $result);
    header("Location: index.php");
    die;

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
                        <li><a class="dropdown-item" href="index.php">Truck shipping order</a></li>
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
      
    <div class="row justify-content-center mt-2">
        <div class="col-6">
            <h1 class="display-4 fs-2 text-center"><b>Ships arrival</b></h1>
        </div>
    </div>
    
    <div class="container">
      <div class="row mt-4">

      <table class="table">
            <thead>
                <tr>
                <th class="text-center" scope="col">Ship Id</th>
                <th class="text-center" scope="col">Source Harbor Id</th>
                <th class="text-center" scope="col">Destination Harbor Id</th>
                </tr>
            </thead>
            <tbody>
            <?php for ($row = 0; $row < count($shipIds); $row++) {?>
              <tr>
                <th class="text-center" scope="row"><?php echo $shipIds[$row][5] ?></th>
                <td class="text-center"><?php echo $shipIds[$row][2] ?></td>
                <td class="text-center"><?php echo $shipIds[$row][3] ?></td>
                <td>
                    <form action= "shiparrived.php" method = "post">
                        <input type="hidden" name="total" id="poster" value="<?php echo $shipIds[$row][1] ?>"/>
                        <button type="submit" class="btn btn-success">
                        <?php echo "Arrived" ?>
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
              <button class="btn btn-success  m-2" type="button">Back</button>
          </a>
        </div>
      </footer>
      
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>

