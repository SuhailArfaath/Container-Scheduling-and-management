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
    $order_id = $_GET['oid'];
    $query = "select warehouseId from orders where order_id = '{$order_id}'";
    $result = mysqli_query($con, $query);
    $warehousedata = mysqli_fetch_all($result);
    $warehouseId = $warehousedata[0][0];
    
    $query = "select harbor_Id from warehouses where warehouse_id = '{$warehouseId}'";
    $result = mysqli_query($con, $query);
    $destinationHarbordata = mysqli_fetch_all($result);
    $destinationHarborId = $destinationHarbordata[0][0];

    // echo $warehouseId,$sourceHarborId;

    $departure_harbors = "select harborId,harborName from harbors where harborId <> '{$destinationHarborId}'";

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
    if (sizeof($_GET,1) == 1)
    {
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
                // print_r( $order_data);
                // $selected_product_flag = 1;
            }
        }

        


    }
    if (sizeof($_GET,1) > 1)
    {
        $order_id = $_GET['oid'];
        // print_r( $_GET);
        $harborid = $_GET['hid'];
        $onShip = "No";
        // $capacity = 2;
        // Reading from the data base
        // $query = "select * from containers where sourceHarborId = '{$harborid}' and destinationHarborId in (0,'{$destinationHarborId}') and capacity <> '{$capacity}'";
        $query = "select * from containers where sourceHarborId = '{$harborid}' and destinationHarborId in (0,'{$destinationHarborId}') and onShip = '{$onShip}'";

        $result = mysqli_query($con, $query);
        // print_r( $result);

        if($result)
        {
            if($result && mysqli_num_rows($result) > 0)
            {
                $containers_data = mysqli_fetch_all($result);
                // print_r( $selected_product_data);
                $fetched_containers = 1;
            }
        }
        // Reading from the data base
        $query = "select * from orders where order_id = '{$order_id}'";

        $result = mysqli_query($con, $query);
        // print_r( $result);

        if($result)
        {
            if($result && mysqli_num_rows($result) > 0)
            {
                $order_data = mysqli_fetch_all($result);
                // print_r( $order_data);
                // $selected_product_flag = 1;
            }
        }

    }

   
}



if($_SERVER['REQUEST_METHOD'] == "POST")
{
    print_r($_POST);
    $buyerOrderId = $_POST['Product_id'];
    $packId = $_POST['packId'];
    $grossWeight = $_POST['grossWeight'];
    $grossCubeFeet = $_POST['grossCubeFeet'];
    $quantity = $_POST['Quantity'];
    $product_id = $_POST['product_id'];
    $onShip = "NO";
    


    $real_data = json_decode($_POST['total'],true);
    $harborId = $real_data['harborId'];
    $loadingDate = $real_data['loadingDate'];
    $status = $real_data['status'];

    // Changing the date format
    $formatDate = explode("-",$loadingDate);
    $c = $formatDate[0];
    $formatDate[0] = $formatDate[1];
    $formatDate[1] = $formatDate[2];
    $formatDate[2] = $c;
    $formattedDate = implode("-",$formatDate);
    $loadingDate = $formattedDate;
    // echo "Formatted date:",$b;

    $containerId = $real_data['containerId'];
    // echo "Container:",$containerId;
    if(!empty($_FILES["image_file"]["name"])) { 
        // echo "Inside image code!";
        // Get file info 
        $fileName = basename($_FILES["image_file"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)){ 
            // echo "In!";
            $image = $_FILES['image_file']['tmp_name']; 

            $imgContent = addslashes(file_get_contents($image)); 
        }
    }
    $query = "select productQuantity from harbor_stock_room where productId = '{$product_id}'";
    $result = mysqli_query($con, $query);
    $order_data = mysqli_fetch_all($result);
    // print_r($order_data[0][0]);
    $existing_quantity = (int)$order_data[0][0];
    $new_quantity = (int)$existing_quantity - (int)$quantity;
    echo $new_quantity;

    $query = "update harbor_stock_room set productQuantity ='{$new_quantity}' WHERE productId = '{$product_id}'";

    mysqli_query($con, $query);

    $query = "update orders set status ='{$status}',containerId ='{$containerId}' WHERE order_id = '{$buyerOrderId}'";

    mysqli_query($con, $query);

    // getting warehouse Id of the order
    $query = "select warehouseId from orders where order_id = '{$buyerOrderId}'";
    $result = mysqli_query($con, $query);
    $warehousedata = mysqli_fetch_all($result);
    $warehouseId = $warehousedata[0][0];

    // getting warehouse harbor Id (To be set as detination for container)
    $query = "select harbor_Id from warehouses where warehouse_id = '{$warehouseId}'";
    $result = mysqli_query($con, $query);
    $destinationHarbordata = mysqli_fetch_all($result);
    $destinationHarborId = $destinationHarbordata[0][0];

    // Checking if the container is full or not
    // $query = "select count(order_id) from orders where warehouseId = '{$warehouseId}'";
    // $result = mysqli_query($con, $query);
    // $destinationHarbordata = mysqli_fetch_all($result);
    // $count_of_orders = $destinationHarbordata[0][0];
    // if ($count_of_orders == 2)
    // {
    //     $full = "Yes";
    // }
    // else
    // {
    //     $full = "No";
    // }



    // $query = "update containers set destinationHarborId ='{$destinationHarborId}',full ='{$full}' where containerId = '{$containerId}'";

    // mysqli_query($con, $query);
    // $status = "Loaded";
    // $query = "update orders set status ='{$status}' WHERE order_id = '{$order_id}'";

    // mysqli_query($con, $query);

    // Getting container capacity
    // $query = "select capacity from containers where containerId = '{$containerId}'";
    // $result = mysqli_query($con, $query);
    // $container_capacitydata = mysqli_fetch_all($result);
    // $container_capacity = $container_capacitydata[0][0];
    // $new_capacity = $container_capacity + 1;
    $onShip = "Yes";

    $query = "update containers set destinationHarborId ='{$destinationHarborId}' where containerId = '{$containerId}'";

    mysqli_query($con, $query);


    $query = "insert into loading_orders (containerId,buyerOrderId,harborId,packId,grossWeight,grossCubeFeet,loadingImage,loadingDate,onShip,orderDate) values ('{$containerId}', '{$buyerOrderId}', '{$harborId}', '{$packId}', '{$grossWeight}', '{$grossCubeFeet}', '{$imgContent}', '{$loadingDate}',0,CURDATE())";

    mysqli_query($con, $query);
    
    
    header("Location: successloading.php");
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
            <div class="col-6">
                <img src="container_loading.jpg" class="img-fluid" alt="Responsive image">
                
                    <ul>
                        <li><p class="mt-4"> Fill the details after loading the order into container</p> </li>
                    </ul>
            </div>
            <div class="col-6">
                <div class="card p-2">
                    <div class="card-body"> 
                        <form action="loadingorder.php" method = "post" enctype="multipart/form-data">
                            <div class="mb-4">
                                    <label for="exampleFormControlInput1" class="form-label">Select your harbor</label>
                                    <div class="dropdown">
                                    <select class="form-select" aria-label="Default select example" onchange="location = this.value;" onclick="setHarbor()" id="harbor">
                                        <option selected>Choose harbor from the list</option>
                                        <?php for ($row = 0; $row < count($harbors_data); $row++) { ?>
                                            <option name="<?php echo $harbors_data[$row][0]; ?>" value="http://localhost/Container-Scheduling-and-management/loadingorder.php?hid=<?php echo $harbors_data[$row][0]; ?>&oid=<?php echo $order_id; ?>">
                                                <?php echo $harbors_data[$row][1]; ?>
                                            </option>
                                        <?php }?>
                                    </select>
                                    </div>                  
                                    
                            </div>
                                    
                            <div class="mb-4">
                                <label for="exampleFormControlInput1" class="form-label">Choose Container at the  harbor</label>

                                <div class="dropdown">
                                    <select class="form-select" aria-label="Default select example" onchange="setContainer()" id="container">
                                        <option selected>Choose container</option>
                                        <?php if($fetched_containers == 1) { ?>
                                        <?php for ($row = 0; $row < count($containers_data); $row++) { ?>
                                            
                                            <option value="<?php echo $containers_data[$row][0];?><?php echo "+"?><?php echo $containers_data[$row][3]; ?>" >
                                                <?php echo $containers_data[$row][1]; ?>
                                            </option>
                                        <?php }?>
                                        <?php }?>

                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="exampleFormControlInput1" class="form-label">Order Id</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name = "Product_id" value=" <?php echo $order_data[0][0] ?>" readonly>
                            </div>

                            <div class="mb-4">
                                <label for="exampleFormControlInput1" class="form-label">Product name</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name = "Product_name" value=" <?php echo $order_data[0][4]," ",$order_data[0][3]; ?>" readonly>
                            </div>

                            <div class="mb-4">
                                <label for="exampleFormControlInput1" class="form-label">Quantity </label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name = "Quantity" value=" <?php echo $order_data[0][6]; ?>" readonly>
                            </div>
                            
                            <div class="mb-2">
                                <label for="exampleFormControlInput1" class="form-label">pack Id</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name = "packId" value=" <?php echo $order_data[0][0]; ?>">
                            </div>
                            <div class="mb-2">
                                <label for="exampleFormControlInput1" class="form-label">Gross weight (in Kilograms)</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name = "grossWeight">
                            </div>
                            <div class="mb-2">
                                <label for="exampleFormControlInput1" class="form-label">Gross height (in Foot)</label>
                                <input type="hidden" class="form-control" id="exampleFormControlInput1" name = "product_id" value="<?php echo $order_data[0][2]; ?>">
                                <input type="text" class="form-control" id="exampleFormControlInput1" name = "grossCubeFeet">
                            </div>
                            <div class="mb-2">
                                <label for="exampleFormControlInput1" class="form-label">Click on the calendar to select date</label>
                                <input type="date" id="date" class="form-control" name="date">
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Choose the container image file</label>
                                <input class="form-control" type="file" id="formFile" name="image_file">
                            </div>
                          
                            <input type="hidden" name="total" id="poster" value="abc"/>  
                            <button type="submit" onclick = "setJson()"class="btn btn-primary">Container loaded</button>
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

        function setHarbor()
        {
            var subjectIdNode = document.getElementById('harbor');
            harborId = subjectIdNode.options[subjectIdNode.selectedIndex].value;
            harborId.split("?")[0];
            console.log("The selected name=" + harborId);

        }
        function setContainer()
        {
            var subjectIdNode = document.getElementById('container');
            info = subjectIdNode.options[subjectIdNode.selectedIndex].value;
            containerId = info.split("+")[0];
            harborId = info.split("+")[1];
            console.log("The selected name=" + containerId.split("+")[0],harborId);

        }
        function setProduct()
        {
            var subjectIdNode = document.getElementById('product');
            productId = subjectIdNode.options[subjectIdNode.selectedIndex].value;
            // console.log("The selected name=" + productId);

        }
        function setJson()
        {
            var currentdate = new Date();
            var selected_date = document.getElementById("date").value;
            var date = currentdate.getMonth().toString()+"/"+currentdate.getDate().toString()+"/"+currentdate.getFullYear().toString()
            var poster =  document.getElementById("poster");
            var order_data = {
                    "harborId"    : parseInt(harborId),
                    "loadingDate" : selected_date,
                    "containerId" : parseInt(containerId),
                    "status"      : "Loaded"
                    }
            json_data = JSON.stringify(order_data);
            poster.value = json_data;


        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>