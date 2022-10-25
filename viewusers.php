<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
$user_id = $user_data['user_id'];


if($_SERVER['REQUEST_METHOD'] == "GET")
{
    // When the user clicks on the create account button
   
    

        // Reading from the data base
        $query = "select * from users where user_name != 'admin@admin.com'";

        $result = mysqli_query($con, $query);
        // print_r( $result);

        if($result)
        {
            if($result && mysqli_num_rows($result) > 0)
            {
                $users_data = mysqli_fetch_all($result);
            }
        }
    
    else{
        echo "problem in getting data";
    }

}

if($_SERVER['REQUEST_METHOD'] == "POST")
{
  echo "Posted!";
  $user_id = (int)$_POST['user_id'];
  $status = $_POST['user_status'];  
  // echo $order_id;
  // Deleting the order from the data base
  $query = "update users set status ='{$status}' WHERE user_id = '{$user_id}'";
  
  // $query = "delete from orders where order_id = 9";

  mysqli_query($con, $query);

  header("Location: viewusers.php");
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
    
      
    <div class="row justify-content-center mt-2 mb-1">
        <div class="col-6">
            <h1 class="display-4 fs-2 text-center"><b>User accounts</b></h1>
        </div>
    </div>
  
  
      

      <div class="row mt-1">
          <table class="table">
            <thead>
                <tr>
                <th scope="col" class="text-center">Userid</th>
                <th scope="col" class="text-center">Username</th>
                <th scope="col" class="text-center">Company name</th>
                <th scope="col" class="text-center">Account</th>
                <th scope="col" class="text-center">Address</th>
                <th scope="col" class="text-center">Contact</th>
                <th scope="col" class="text-center">Status</th>

                </tr>
            </thead>
            <tbody>
            <?php for ($row = 0; $row < count($users_data); $row++) {?>
              <tr>
                <th scope="row"><?php echo $users_data[$row][0] ?></th>
                <td><?php echo $users_data[$row][1] ?></td>
                <td><?php echo $users_data[$row][3] ?></td>
                <td><?php echo $users_data[$row][4] ?></td>
                <td><?php echo $users_data[$row][5] ?></td>
                <td><?php echo $users_data[$row][7] ?></td>
                <td><?php echo $users_data[$row][6] ?></td>
                
                <td>
                  <?php 
                    if($users_data[$row][6] == "active")
                    { ?>
                        <div class="row">
                            <div class="col-12">
                                <form action= "viewusers.php" method = "post">
                                    <input type="hidden"  name="user_id" value="<?php echo $users_data[$row][0]; ?>"/>
                                    <input type="hidden"  name="user_status" value="<?php echo "inactive"; ?>"/>
                                    <button type="submit" class="btn btn-danger">
                                    <?php echo "Deactivate" ?>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if($users_data[$row][6] == "inactive") {?>
                            <div class="row">
                                <div class="col-12">
                                    <form action= "viewusers.php" method = "post">
                                        <input type="hidden"  name="user_id" value="<?php echo $users_data[$row][0]; ?>"/>
                                        <input type="hidden"  name="user_status" value="<?php echo "active"; ?>"/>  
                                        <button type="submit" class="btn btn-success">
                                            <?php echo "Activate" ?>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                  
                  
                  </div>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>     
      </div>
      <footer class="footer">
        <div class=" text-center bg-light">
          <a href="index.php">
              <button class="btn btn-warning  m-2" type="button">Back</button>
          </a>
        </div>
      </footer>
      <script>
        var check = 1;
        function add_to_cart(product_id,product_name,
                            product_brand,product_type)
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
        "quantity"      : quantity
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

