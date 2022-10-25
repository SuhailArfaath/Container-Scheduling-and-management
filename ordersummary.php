<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

$user_id = $user_data['user_id'];

$warehouse_data = [];
$query = "select * from warehouses";

$result = mysqli_query($con, $query);
// print_r( $result);

if($result)
{
    if($result && mysqli_num_rows($result) > 0)
    {
        $warehouse_data = mysqli_fetch_all($result);
        // print_r($warehouse_data);
    }
}

else{
echo "problem in getting data";
}
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    // When the user clicks on the submit button
    $product_data = $_POST;
    // var_dump($product_data['total']);
    // var_dump($product_data['quantity']);

    $quantity = $product_data['quantity'];

    // echo $product_data;
    // $product_data = $_POST['total'];
    // $decoded_json = json_decode($product_data);
    // echo gettype($product_data);
    $real_data = json_decode($product_data['total'],true);
    // echo $real_data[0]['product_id'] ;
    print_r($real_data);


    for ($x = 0; $x < count($real_data); $x++) {
        
        $id = $real_data[$x]['product_id'];
        $name = $real_data[$x]['product_name'];
        $brand = $real_data[$x]['product_brand'];
        $type = $real_data[$x]['product_type'];
        // $quantity = $real_data[$x]['quantity'];
        $exporter_id = $real_data[$x]['exporter_id'];
        $exporter_name = $real_data[$x]['exporter_name'];
        $warehouseId = $real_data[$x]['warehouseId'];
        // echo $real_data[$x]['product_id'];
        $query = "insert into orders (user_id,product_id,product_name,product_brand,product_type,quantity,exporter_id,exporter_name,warehouseId) values ('{$user_id}','{$id}','{$name}','{$brand}','{$type}','{$quantity}','{$exporter_id}','{$exporter_name}','{$warehouseId}')";

        mysqli_query($con, $query);
        
          
      }
    // $query = "insert into products (product_name,product_brand,product_type,quantity) values ('$product_name','$brand','$type','$product_barcode','$product_weight','$product_image')";

    // mysqli_query($con, $query);
    header("Location: test.php");
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
            <h1 class="display-4 fs-2 text-center"><b>Container Management System</b></h1>
        </div>
    </div>
    
      <script>
        var data = [];
        function postData()
        {

            var quantity = document.getElementsByName("quantity").value;
            var warehouseId = document.getElementById("checkbox").value;
            var poster = document.getElementById("poster");

            data[0]['quantity'] = quantity;
            data[0]['warehouseId'] = warehouseId;
            a = {}
            // for (let i = 0; i < data.length; i++) {

            // }
            var poster = document.getElementById("poster");
            data_items = localStorage.length;
            for (let i = 0; i < data_items; i++) {
                    a[i]  = data[i];
            }
            // a.push({ 'quantity': quantity, 'warehouseId': warehouseId });
            console.log("Hello");
            console.log(a,quantity,warehouseId);
            poster.value = JSON.stringify(a);
            localStorage.clear();

            // poster.value = "hello";

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
            // localStorage.setItem("lastname", "Smith");
            // var key = localStorage.key( 0 )
            
            console.log(data[0]);

            var table = document.getElementById("data_table");
            for (let j = 0; j < data.length; j++) {
               var row = table.insertRow();
               cell1  = row.insertCell();
               cell2  = row.insertCell();
               cell3  = row.insertCell();
               cell4  = row.insertCell();

               cell1.innerHTML = data[j]["product_id"];
               cell2.innerHTML = data[j]["product_name"];
               cell3.innerHTML = data[j]["price"];
               cell4.innerHTML = data[j]["exporter_name"];
            }
            // console.log(JSON.stringify(data));
            // postData();
        }
      </script>
  
      
      <h1 class="display-2 fs-3 ">Order summary</h1>
      <div class="row justify-content-center mt-4">
            <div class="col-6">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Product Id</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Exporter Name</th>
                        </tr>
                    </thead>
                    <tbody id="data_table">
                        
                    </tbody >
                </table>
            </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-2">
                <p class="text-right"> Enter quantity: </p>
        </div>
        <div class="col-1 text-left">
            <form method = "post">
                <input type="text" class="form-control" id="exampleFormControlInput1" name = "quantity" id = "quantity">
        </div>
    </div>
    <div class="row justify-content-center mt-2">
        <div class="col-6">
                <p> Choose delivery address: </p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-6">
        <table class="table table-image">
                <tbody>
                    <?php for ($row = 0; $row < count($warehouse_data); $row++) { ?>
                    <tr>
                        <td class="text-center">
                        <input class="text-center form-check-input" type="checkbox" value="<?php echo $warehouse_data[$row][0]; ?>"  id="checkbox" name="check_box">
                        </td>                    
                        <td class="text-left">
                            <p><?php echo $warehouse_data[$row][2]; ?></p>
                            <p> <b>Address:</b> <?php echo $warehouse_data[$row][6]; ?></p>
                        </td>
                    
                    </tr>
                    <?php }?>
                </tbody>
                </table>
        </div>
    </div>
      <script>
        showData();
        // postData();
      </script>
      
        <input type="hidden" name="total" id="poster" value="abc"/>
        <footer class="footer">
            <div class=" text-center bg-light">
            <a href="index.php">
                <button class="btn btn-success  m-2" onclick="postData()" type="submit">Place order</button>
            </a>
            </div>
        </footer>
    </form>
      
        
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>