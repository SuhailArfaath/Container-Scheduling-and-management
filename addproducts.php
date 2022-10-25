<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);


if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        // When the user clicks on the submit button
        $product_name = $_POST['product_name'];
        $brand  = $_POST['product_brand'];
        $type  = $_POST['product_type'];
        $product_barcode  = $_POST['product_barcode'];
        $product_weight  = $_POST['product_weight'];
        $price  = $_POST['product_price'];
        $exporter_id     = $user_data['user_id'];
        $exporter_name     = $user_data['user_company'];

       
        if(!empty($_FILES["image_file"]["name"])) { 
            echo "Inside image code!";
            // Get file info 
            $fileName = basename($_FILES["image_file"]["name"]); 
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
             
            // Allow certain file formats 
            $allowTypes = array('jpg','png','jpeg','gif'); 
            if(in_array($fileType, $allowTypes)){ 
                $image = $_FILES['image_file']['tmp_name']; 
                $imgContent = addslashes(file_get_contents($image)); 
            }
        }



        if(!empty($product_name) &&
            (!empty($brand)) &&
            (!empty($type))&&
            (!empty($product_barcode))&&
            (!empty($product_weight)))
        {
            // Saving to data base
            $query = "insert into products (product_name,brand,type,product_barcode,product_weight,product_image,quantity,price,exporter_id,exporter_name) values ('$product_name','$brand','$type','$product_barcode','$product_weight','$imgContent',0,'$price','$exporter_id','$exporter_name')";

            mysqli_query($con, $query);

            


            header("Location: index.php");
            die;
        }
        else{
            echo "Please fill all the fields!";
        }

    }

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home page</title>
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

    <div class="row justify-content-center mt-5">
        <div class="col-6">
            <h1 class="display-4 fs-2 text-center"><b>Add product details</b></h1>
        </div>
    </div>

    <div class="row mt-5 justify-content-center">
        <div class="col-6">
        <form method = "post" enctype="multipart/form-data">
            <div class="row">
                <div class="mb-4">
                    <input type="text" class="form-control" id="exampleFormControlInput1" name = "product_name" placeholder="Enter the product name">
                </div>
            </div>
            <div class="row">
                <div class="mb-4">
                    <input type="text" class="form-control" id="exampleFormControlInput1" name = "product_brand" placeholder="Enter the product brand">
                </div>
            </div>
            <div class="row">
                <div class="mb-4">
                    <input type="text" class="form-control" id="exampleFormControlInput1" name = "product_type" placeholder="Enter the product type">
                </div>
            </div>
            <div class="row">
                <div class="mb-4">
                    <input type="number" class="form-control" id="exampleFormControlInput1" name = "product_price" placeholder="Enter the product price">
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="row">
                <div class="mb-4">
                    <input type="text" class="form-control" id="exampleFormControlInput1" name = "product_barcode" placeholder="Enter the product barcode">
                </div>
            </div>
            <div class="row">
                <div class="mb-4">
                    <input type="text" class="form-control" id="exampleFormControlInput1" name = "product_weight" placeholder="Enter the product weight">
                </div>
            </div>
            <div class="row">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Choose the product image file</label>
                    <input class="form-control" type="file" id="formFile" name="image_file">
                </div>
            </div>
        </div>
        <div class="row-6">

            <button type="submit" class="btn btn-primary mb-2">Submit</button>
        </div>
        </form>
        </div>
    </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>