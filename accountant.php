<?php
session_start();

include("connection.php");
include("functions.php");

function pre($data, $flag = false) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    if($flag == '1') die;
}

$user_data = check_login($con);
$user_id = $user_data['user_id'];

$tables = array();
$query = "SHOW TABLES";
$result = mysqli_query($con, $query);
if($result)
{
    if($result && mysqli_num_rows($result) > 0)
    {
        $tables = mysqli_fetch_all($result);
    }
}
$datacolumn = array();
$data = array();
if($_SERVER['REQUEST_METHOD'] == "POST")
{
     $table = $_POST["table"];
     $column = $_POST["column"];
     $search = $_POST["search"];

     
    $query = 'SHOW COLUMNS FROM '.$table;
    $result = mysqli_query($con, $query);
    if($result){
        if($result && mysqli_num_rows($result) > 0) {
            
            $datacolumn = mysqli_fetch_all($result);
        }
    }
    
    $query = "select * from ".$table." where LOWER(".$column.") like '%".strtolower($search)."%'";
    $result = mysqli_query($con, $query);
    if($result){
        if($result && mysqli_num_rows($result) > 0) {
            
            $data = mysqli_fetch_all($result);
        }
    }
}


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accountant</title>
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
 
<div class="container-fluid">
    <div class="row justify-content-center mt-2">
        <div class="col-6">
            <h1 class="display-4 fs-2 text-center"><b>Accountant</b></h1>
        </div>
    </div>
  
    <form method = "post">
    <div class="row">
        <div class="col-md-3">
            <select class="form-control" id="table" name="table" required>
                <option value="">Select table</option>
                <?php foreach ($tables as $key => $value) { ?>
                    <option value="<?php echo $value[0]; ?>"><?php echo $value[0]; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-control" id="column" name="column" required>
                <option value="">Select column</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" required >
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-success">Search</button>
        </div>
    </div>
     </form> 

      <div class="row mt-4">
          <table class="table">
            <thead>
                <tr>
                   <?php foreach ($datacolumn as $key => $value) { ?> 
                        <th scope="col"><?php echo $value[0] ?></th>
                    <?php  } ?>
                </tr>
            </thead>
            <tbody>
             <?php foreach ($data as $key => $value) { ?> 
              <tr>
                <?php foreach ($value as $k => $v) { ?> 
                    <td><?php echo $v ?></td>
                <?php  } ?>
              </tr>
              <?php } ?>
            </tbody>
          </table>     
      </div>
    </div>
</div>
      <footer class="footer">
        <div class=" text-center bg-light">
          <a href="index.php">
              <button class="btn btn-warning  m-2" type="button">Back</button>
          </a>
        </div>
      </footer>
      
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        <?php 

            $currentPath = $_SERVER['PHP_SELF']; 

            // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
            $pathInfo = pathinfo($currentPath); 

            // output: localhost
            $hostName = $_SERVER['HTTP_HOST']; 

            // output: http://
            $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
            $baseurl =  $protocol.'://'.$hostName.$pathInfo['dirname']."/";
         ?>

        $(document).ready(function(){
            $("#table").change(function(){
                $.ajax({  
                    type:"POST",  
                    url:"<?php echo $baseurl; ?>getdata.php",  
                    data:{table:$(this).val()},  
                    success:function(data){  
                        $("#column").html(data);
                    }  
                });  
            });
        });
    </script>
  </body>
</html>

