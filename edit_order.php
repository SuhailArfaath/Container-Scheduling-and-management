<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
$order_id = 0;

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    
            $order_id = (int)$_POST['order_id'];
   
            

            // Reading from the data base
            $query = "select * from orders where order_id = '{$order_id}'";

            $result = mysqli_query($con, $query);
            // print_r( $result);

            if($result)
            {
                if($result && mysqli_num_rows($result) > 0)
                {
                    $product_data = mysqli_fetch_all($result);
                }
            }
            
            else{
                echo "problem in getting data";
            }

        
        
        
}


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="edit_order.css" rel="stylesheet">
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
  
  
      
      <div class="container-fluid">
        <div class="row mt-4">

            
            <div class="col-12 m-0 p-0 mx-auto">
                  <div class="image">
                      <img class="image__img" src="pic1.jpg" alt="Bricks">
                      <div class="image__overlay image__overlay--primary">
                          <div class="image__title text-center"><?php echo $product_data[0][4]," ", $product_data[0][3]?></div>
                          
                                              
                              <div class="row text-center">
                                  <div class="col-4">
                                    <button type="button" class="btn btn-success" onclick="quantity_counter(1,<?php echo $product_data[0][2] ?>)">+</button>
                                  </div>
                                  <div class="col-4 text-center">
                                      <div class="row">
                                          <div class="col">
                                            <p class="text-center p-0 m-0" name="quantity" id="<?php echo $product_data[0][2] ?>"><?php echo $product_data[0][6] ?></p>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-4">
                                    <button type="button" class="btn btn-warning"  onclick="quantity_counter(-1, <?php echo $product_data[0][2] ?>)">-</button>
                                  </div>
                              </div>
                              
                          
                      </div>
                  </div>   
              </div>
        
          
      </div>
            </div>
           
             
      </div>
      <form action= "updateorder.php" method = "post">
        <input type="hidden" name="order_id" id="order_id" value="<?php echo $product_data[0][0]; ?>"/>
        <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_data[0][2]; ?>"/>
        <input type="hidden" name="quantity" id="quantity" value="abc"/>
       
        <footer class="footer">
            <div class=" text-center bg-light">
            <a href="checkout.php">
                <button class="btn btn-success  m-2" onclick="postData()" type="submit">Confirm order</button>
            </a>
            </div>
        </footer>
    </form>
      <script>
        // var data = [];
        echo("id:",document.getElementById("order_id").value);
        function postData()
        {
            var id          = document.getElementById("product_id").value;

            var quantity       = parseInt(document.getElementById(String(id)).innerHTML);
            var update         = document.getElementById("quantity");
            // var id             = document.getElementById("idposter");
            // id.value = id;
            update.value = quantity
           
        }

        var check = 1;
        function add_to_cart(product_id,product_name,
                            product_brand,product_type,
                            exporter_id,exporter_name)
        {
          if (check == 1)
          {
            localStorage.clear();
            check = 2;
          }
          console.log(product_id,product_name,
                            product_brand,product_type);

        var quantity = parseInt(document.getElementById(String(product_id)).innerHTML);
        console.log(quantity)
        var product_data = {
        "product_id"    : product_id,
        "product_name"  : product_name,
        "product_brand" : product_brand,
        "product_type"  : product_type,
        "quantity"      : quantity,
        "exporter_id"   : exporter_id,
        "exporter_name" : exporter_name
        }

        data = JSON.stringify(product_data);
        // data = JSON.parse(data_crude);

         localStorage.setItem(product_id, data);
        //  console.log(JSON.parse(localStorage.getItem(7)));
        }


        function quantity_counter(operation,element_id)
        {
          // localStorage.clear();
          // var i = localStorage.getItem(6);
          // var obj = JSON.stringify(i);
          // alert(JSON.stringify(i));
          // console.log(obj);
          value = parseInt(document.getElementById(String(element_id)).innerHTML);
          if (operation > 0)
          {
            document.getElementById(String(element_id)).innerHTML = value + 1;
          }
          else
          {
            if(value > 0)
            document.getElementById(String(element_id)).innerHTML = value - 1;
            else
            {
              document.getElementById(String(element_id)).innerHTML = value;
            }
          }
          
        }
        </script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>

