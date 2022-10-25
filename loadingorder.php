<?php
session_start();

include("connection.php");
include("functions.php");
$user_data = check_login($con);
$user_id = $user_data['user_id'];

$get_containers = "select containerId,ISO6346_Code from containers WHERE ownerCompanyId = '{$user_id}'";

$result = mysqli_query($con, $get_containers);
// print_r( $result);

if($result)
{
    if($result && mysqli_num_rows($result) > 0)
    {
        $containers_data = mysqli_fetch_all($result);
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
            print_r( $order_data);
            // $selected_product_flag = 1;
        }
    }

    else{
        echo "problem in getting data";
    }
}

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    print_r($_POST);
    $buyerOrderId = $_POST['buyerOrderId'];
    $packId = $_POST['packId'];
    $grossWeight = $_POST['grossWeight'];
    $grossCubeFeet = $_POST['grossCubeFeet'];
    $quantity = $_POST['Quantity'];
    $product_id = $_POST['product_id'];
    $onShip = "NO";

    $real_data = json_decode($_POST['total'],true);
    $harborId = $real_data['harborId'];
    $loadingDate = $real_data['loadingDate'];
    $containerId = $real_data['containerId'];
    echo "Container:",$containerId;
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
    $query = "select productQuantity from harbor_stock where productId = '{$product_id}'";
    $result = mysqli_query($con, $query);
    $order_data = mysqli_fetch_all($result);
    // print_r($order_data[0][0]);
    $existing_quantity = (int)$order_data[0][0];
    $new_quantity = (int)$existing_quantity - (int)$quantity;

    $query = "update harbor_stock set productQuantity ='{$new_quantity}' WHERE exporterId = '{$user_id}'";

    mysqli_query($con, $query);

    $query = "update products set quantity ='{$new_quantity}' WHERE product_id = '{$product_id}'";

    mysqli_query($con, $query);


    $query = "insert into loading_orders (containerId,buyerOrderId,harborId,packId,grossWeight,grossCubeFeet,loadingImage,loadingDate,onShip) values ('{$containerId}', '{$buyerOrderId}', '{$harborId}', '{$packId}', '{$grossWeight}', '{$grossCubeFeet}', '{$imgContent}', '{$loadingDate}',0)";

    mysqli_query($con, $query);
    

    header("Location: index.php");
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
                        <li><a class="dropdown-item" href="received_orders.php">Received orders</a></li>
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
                        <li><a class="dropdown-item" href="add_harbor_stock.php">Add stock</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="addharbour.php">Add a harbor</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="addcontainer.php">Add container</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="addmanufacturer.php">Add manufacturer</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Orders
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="received_orders.php">Load container</a></li>
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
    <div class="container mt-1">
        <div class="row justify-content-center mt-1">
            <div class="col-6">
                <img src="loadingcontainer.jpg" class="img-fluid" alt="Responsive image">
                
                    <ul>
                        <li><p class="mt-4"> Fill the details to add a harbour stock room</p> </li>
                    </ul>
            </div>
            <div class="col-6">
                <div class="card p-2">
                    <div class="card-body"> 
                        <form action="loadingorder.php" method = "post" enctype="multipart/form-data">
                            <div class="mb-4">
                                <div class="dropdown">
                                    <select class="form-select" aria-label="Default select example" onchange="setHarbor()" id="harbor">
                                        <option selected>Choose harbor from the list</option>
                                        <?php for ($row = 0; $row < count($harbors_data); $row++) { ?>
                                            
                                            <option value="<?php echo $harbors_data[$row][0]; ?>" >
                                                <?php echo $harbors_data[$row][1]; ?>
                                            </option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="dropdown">
                                    <select class="form-select" aria-label="Default select example" onchange="setContainer()" id="container">
                                        <option selected>Choose Container from the list</option>
                                        <?php for ($row = 0; $row < count($containers_data); $row++) { ?>
                                            
                                            <option value="<?php echo $containers_data[$row][0]; ?>" >
                                                <?php echo $containers_data[$row][1]; ?>
                                            </option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="exampleFormControlInput1" class="form-label">Product name</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name = "Product_name" value=" <?php echo $order_data[0][4]," ",$order_data[0][3]; ?>" readonly>
                            </div>

                            <div class="mb-4">
                                <label for="exampleFormControlInput1" class="form-label">Buyer order Id</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name = "buyerOrderId" value=" <?php echo $order_data[0][0]; ?>" readonly>
                            </div>

                            <div class="mb-4">
                                <label for="exampleFormControlInput1" class="form-label">Quantity </label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name = "Quantity" value=" <?php echo $order_data[0][6]; ?>" readonly>
                            </div>
                            
                            <div class="mb-2">
                                <label for="exampleFormControlInput1" class="form-label">pack Id</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name = "packId">
                            </div>
                            <div class="mb-2">
                                <label for="exampleFormControlInput1" class="form-label">Gross weight</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name = "grossWeight">
                            </div>
                            <div class="mb-2">
                                <label for="exampleFormControlInput1" class="form-label">Gross height (in Cubicfeet)</label>
                                <input type="hidden" class="form-control" id="exampleFormControlInput1" name = "product_id" value="<?php echo $order_data[0][2]; ?>">
                                <input type="text" class="form-control" id="exampleFormControlInput1" name = "grossCubeFeet">
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
            // console.log("The selected name=" + harborId);

        }
        function setContainer()
        {
            var subjectIdNode = document.getElementById('container');
            containerId = subjectIdNode.options[subjectIdNode.selectedIndex].value;
            // console.log("The selected name=" + exporterId);

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
            var date = currentdate.getDate().toString()+"/"+currentdate.getMonth().toString()+"/"+currentdate.getFullYear().toString()
            var poster =  document.getElementById("poster");
            var order_data = {
                    "harborId"    : parseInt(harborId),
                    "loadingDate"  : date,
                    "containerId": parseInt(containerId),
                    }
            json_data = JSON.stringify(order_data);
            poster.value = json_data;


        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>