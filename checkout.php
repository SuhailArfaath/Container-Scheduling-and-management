<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

$user_id = $user_data['user_id'];
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    // When the user clicks on the submit button
    $product_data = $_POST;
    // var_dump($product_data['total']);
    // echo $product_data;
    // $product_data = $_POST['total'];
    // $decoded_json = json_decode($product_data);
    // echo gettype($product_data);
    $real_data = json_decode($product_data['total'],true);
    // echo $real_data[0]['product_id'] ;
    // print_r($real_data);

    for ($x = 0; $x < count($real_data); $x++) {
        
        $id = $real_data[$x]['product_id'];
        $name = $real_data[$x]['product_name'];
        $brand = $real_data[$x]['product_brand'];
        $type = $real_data[$x]['product_type'];
        $quantity = $real_data[$x]['quantity'];
        $exporter_id = $real_data[$x]['exporter_id'];
        $exporter_name = $real_data[$x]['exporter_name'];
        // echo $real_data[$x]['product_id'];
        $query = "insert into orders (user_id,product_id,product_name,product_brand,product_type,quantity,exporter_id,exporter_name) values ('{$user_id}','{$id}','{$name}','{$brand}','{$type}','{$quantity}','{$exporter_id}','{$exporter_name}')";

        mysqli_query($con, $query);
        
          
      }
    // $query = "insert into products (product_name,product_brand,product_type,quantity) values ('$product_name','$brand','$type','$product_barcode','$product_weight','$product_image')";

    // mysqli_query($con, $query);
    header("Location: products.php");
    die;
    


    // header("Location: index.php");
    // die;
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
                        <li><a class="dropdown-item" href="products.php">Place order</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="myorders.php">My orders</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Exporter
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="received_orders.php">Received orders</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="addproducts.php">Add products</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="products.php">View all products</a></li>
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
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Orders
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="addusers.php">Container loading order</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="viewusers.php">Sea shipping order</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="viewusers.php">Truck shipping order</a></li>
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
            <h1 class="display-4 fs-2 text-center"><b>Container Management System</b></h1>
        </div>
    </div>
    
      <script>
        var data = [];
        function postData()
        {
            a = {}
            // for (let i = 0; i < data.length; i++) {

            // }
            var poster = document.getElementById("poster");
            data_items = localStorage.length;
            for (let i = 0; i < data_items; i++) {
                    a[i]  = data[i];
            }

            console.log(a);
            poster.value = JSON.stringify(a);
            // window.location.href = "checkout.php?data=" + data; 
        }

        function showData()
        {
            data_items = localStorage.length;
            // data = []
            for (let i = 0; i < data_items; i++) {
                var key = localStorage.key( i )
                data[i] = JSON.parse(localStorage.getItem(key))
            }
            console.log(data);

            var table = document.getElementById("data_table");
            for (let j = 0; j < data.length; j++) {
               var row = table.insertRow();
               cell1  = row.insertCell();
               cell2  = row.insertCell();
               cell3  = row.insertCell();
               cell4  = row.insertCell();
               cell5  = row.insertCell();

               cell1.innerHTML = data[j]["product_id"];
               cell2.innerHTML = data[j]["product_name"];
               cell3.innerHTML = data[j]["product_brand"];
               cell4.innerHTML = data[j]["product_type"];
               cell5.innerHTML = data[j]["quantity"];
            }
            // console.log(JSON.stringify(data));
            postData();
        }
      </script>
  
      
      <h1 class="display-2 fs-3 ">Selected items:</h1>
      <div class="row mt-4">

                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Product Id</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Product Brand</th>
                        <th scope="col">Product Type</th>
                        <th scope="col">Quantity</th>
                        </tr>
                    </thead>
                    <tbody id="data_table">
                        
                    </tbody >
                </table>
      </div>
      <script>
        showData();
      </script>
      <form action= "checkout.php" method = "post">
        <input type="hidden" name="total" id="poster" value="abc"/>
        <footer class="footer">
            <div class=" text-center bg-light">
            <a href="checkout.php">
                <button class="btn btn-success  m-2" onclick="postData()" type="submit">Place order</button>
            </a>
            </div>
        </footer>
    </form>
      
        
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>