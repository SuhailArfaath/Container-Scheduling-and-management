<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
$selected_product_flag = 0;
$products_data = [];
$user_id = $user_data['user_id'];
$exporter_name = $user_data['user_name'];

$query = "select harborId,harborName from harbors";

$result = mysqli_query($con, $query);
// print_r( $result);

if($result)
{
    if($result && mysqli_num_rows($result) > 0)
    {
        $harbors_data = mysqli_fetch_all($result);
        // print_r($products_data);
    }
}

$query = "select * from products";

$result = mysqli_query($con, $query);
// print_r( $result);

if($result)
{
    if($result && mysqli_num_rows($result) > 0)
    {
        $products_data = mysqli_fetch_all($result);
        // print_r($products_data);
    }
}

else{
echo "problem in getting data";
}

$get_manufacturers = "select * from manufacturer";

$result = mysqli_query($con, $get_manufacturers);
// print_r( $result);

if($result)
{
    if($result && mysqli_num_rows($result) > 0)
    {
        $manufacturers_data = mysqli_fetch_all($result);
        // print_r($products_data);
    }
}

else{
echo "problem in getting data";
}

$get = "select distinct product_name from products";

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
    print_r( $_GET['product_id']);
    $product_name = $_GET['product_name'];
    // Reading from the data base
    $query = "select * from products where product_name = '{$product_name}'";

    $result = mysqli_query($con, $query);
    // print_r( $result);

    if($result)
    {
        if($result && mysqli_num_rows($result) > 0)
        {
            $selected_product_data = mysqli_fetch_all($result);
            // print_r( $selected_product_data);
            $selected_product_flag = 1;
        }
    }

    else{
        echo "problem in getting data";
    }
}

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    print_r($_POST);
    $real_data = json_decode($_POST['total'],true);
    // print_r($real_data['product_id']);
    $product_id = $real_data['product_id'];
    $product_name = $real_data['product_name'];

    $manufacturer_id = $real_data['manufacturerId'];
    $harborId = $real_data['harborId'];

    // echo $manufacturer_id;
    $quantity = $real_data['quantity'];

    $query = "insert into manufacturer_orders (exporter_company_id,harborId,exporter_name,product_id,product_name,manufacturer_id,quantity) values ('{$user_id}','{$harborId}', '{$exporter_name}', '{$product_id}', '{$product_name}','{$manufacturer_id}','{$quantity}')";

    mysqli_query($con, $query);
    header("Location: index.php");
    die;
    // $product_id = $_POST['product_id'];
    // // When the user clicks on the buy product button
    // $query = "select * from products where product_id='{$product_id}'";

    // $result = mysqli_query($con, $query);
    // // print_r( $result);

    // if($result)
    // {
    //     if($result && mysqli_num_rows($result) > 0)
    //     {
    //         $product_data = mysqli_fetch_all($result);
    //     }
    // }

    // else{
    //     echo "problem in getting data";
    // }
    

    //     // Reading from the data base
        
}


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="product_display.css" rel="stylesheet">
    <style>
        
        .wrapper{
        width:230px;
        padding:0px;
        height: 150px;
        }
        
    </style>
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
      
    <div class="container-fluid  mt-2">
        <div class="row justify-content-center bg-light">
            <div class="col-6">
                <div class="row justify-content-center bg-light">
                    <div class="col-8 p-2">
                    
                        <div class="dropdown">
                        <select class="form-select" aria-label="Default select example" onchange="location = this.value;">
                            <option selected>Choose product from the list</option>
                            <?php for ($row = 0; $row < count($products_data); $row++) { ?>
                                <option id="product" value="http://localhost/Container-Scheduling-and-management/manufacturerorder.php?product_name=<?php echo $products_data[$row][0]; ?>">
                                    <?php echo $products_data[$row][0]; ?>
                                </option>
                            <?php }?>
                        </select>
                        </div>                  
                    </div>
                </div>
               
                
        </div>
    </div>
    <?php if($selected_product_flag == 1) 
    { ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10">
                <table class="table table-image">
                <thead>
                    <tr>
                    <th scope="col" class="text-center">Select</th>
                    <th scope="col" class="text-center">Product Id</th>
                    <th scope="col" class="text-center">Product</th>
                    <th scope="col" class="text-left">Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($row = 0; $row < count($selected_product_data); $row++) { ?>
                    <tr>
                    <td class="text-center">
                    <input class="text-center form-check-input" type="checkbox" value="<?php echo $selected_product_data[$row][0],"/",$selected_product_data[$row][1],"/",$selected_product_data[$row][2],"/",$selected_product_data[$row][3],
                                                                                                    "/",$selected_product_data[$row][7],"/",$selected_product_data[$row][8],"/",$selected_product_data[$row][9]; ?>"  id="checkbox" name="check_box">
                    </td>
                    <th scope="row" class="text-center"><?php echo $selected_product_data[$row][0]; ?></th>
                    

                    <td class="w-25 text-center">
                        <img class="img" src="data:image/png;charset=utf8;base64,<?php echo base64_encode($selected_product_data[$row][6]); ?>" width = "150px" height="150px">
                    </td>
                    <td class="text-left">
                        <p><?php echo $selected_product_data[$row][2]," ",$selected_product_data[$row][1]; ?></p>
                        <p>Type: <?php echo $selected_product_data[$row][3]; ?></p>
                        <p> <b>Price:</b>  <?php echo "$",$selected_product_data[$row][8]; ?></p>
                        <p> <b>Exported by:</b> <?php echo $selected_product_data[$row][10]; ?></p>
                    </td>
                    
                    </tr>
                    <?php }?>
                </tbody>
                </table>   
            </div>
        </div>
    </div>
    <?php } ?>
    
    <div class="container-fluid  mt-2">
        <div class="row justify-content-center bg-light">
            <div class="col-6">
                <div class="row justify-content-center bg-light">
                    <div class="col-8 p-2">
                        <div class="dropdown">
                        <select class="form-select" aria-label="Default select example" onchange="setName()" id="manufacturer">
                            <option selected>Choose manufacturer from the list</option>
                            <?php for ($row = 0; $row < count($manufacturers_data); $row++) { ?>
                                
                                <option name="manufacturer" value="<?php echo $manufacturers_data[$row][0]; ?>" >
                                    <?php echo $manufacturers_data[$row][1]; ?>
                                </option>
                            <?php }?>
                        </select>
                        </div>                  
                    </div>
                </div>
               
                
        </div>
    </div>

    <div class="container-fluid  mt-2">
        <div class="row justify-content-center bg-light">
            <div class="col-6">
                <div class="row justify-content-center bg-light">
                    <div class="col-8 p-2">
                    <div class="dropdown">
                                    <select class="form-select" aria-label="Default select example" onchange="setHarbor()" id="harbor">
                                        <option selected>Choose harbor from the list</option>
                                        <?php for ($row = 0; $row < count($harbors_data); $row++) { ?>
                                            
                                            <option name="manufacturer" value="<?php echo $harbors_data[$row][0]; ?>" >
                                                <?php echo $harbors_data[$row][1]; ?>
                                            </option>
                                        <?php }?>
                                    </select>
                                </div>                  
                    </div>
                </div>
               
                
        </div>
    </div>


    <div class="container-fluid text-center mt-2">

    <div class="container-fluid justify-content-center mt-2">
        <div class="row justify-content-center">
            
                    <label for="exampleFormControlInput1" class="form-label">Quantity</label>
                <div class="col-3 mb-4">
                    <input type="text" class="form-control" name = "quantity" id="quantity">
                </div>
            </div>
        </div>
    </div>
    <form method = "post">
        <a href="ordersummary.php">  
            <input type="hidden" name="total" id="poster" value="abc"/>  
            <button type="submit" onclick="set_product_id()" class="btn btn-primary">Place order</button>
        </a>
    </div>
    </form>
    
            
       
</div>

            
      <script>
        var product_ids = [];
        var selected = [];
        var manufacturerId = 0;
        var harborId = 0;
        function setHarbor()
        {
            var subjectIdNode = document.getElementById('harbor');
            harborId = subjectIdNode.options[subjectIdNode.selectedIndex].value;
            console.log("The selected name=" + harborId);

        }
        function setName()
        {
            var subjectIdNode = document.getElementById('manufacturer');
            manufacturerId = subjectIdNode.options[subjectIdNode.selectedIndex].value;
            console.log("The selected name=" + manufacturerId);

        }
        function set_warehouse(warehouse_name)
        {
            console.log("WN:",warehouse_name);

        }
        function addToCart(products)
        {
            console.log("PIds:",[...new Set(selected)]);
            // quantity = document.getElementById("quantity").value;
            // document.getElementById("product_id").innerHTML = "Hello";
        }
        function set_product_id()
        {
            // console.log("Warehouse:",document.getElementById("warehouse").innerHTML)
            console.log("Ids:",[...new Set(selected)]);
            localStorage.clear();
            // checkbox = document.getElementById("checkbox");
           var checkboxes = document.getElementsByName("check_box");
           var quantity = document.getElementById("quantity").value;
           var poster =  document.getElementById("poster");
        //    var value  = document.getElementsByName("quantity").value;
        //    var quantity   = document.getElementById("quantity").value;
        //    console.log("check:", value);
            // var selected = [];
            for (var i=0; i<checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    selected.push(checkboxes[i].value);
                    console.log("Inside checkbox:",checkboxes[i].value.split("/"));
                    data = checkboxes[i].value.split("/");

                    var order_data = {
                    "product_id"    : parseInt(data[0]),
                    "product_name"  : data[1],
                    "manufacturerId": parseInt(manufacturerId),
                    "harborId"      : parseInt(harborId),
                    "quantity"  : parseInt(quantity)
                    }
                    json_data = JSON.stringify(order_data);
                    poster.value = json_data;

                    localStorage.setItem(parseInt(data[0]), json_data);

                }
            }
            console.log(selected);
        
        

        console.log("PIds:",[...new Set(selected)]);
        // poster = document.getElementById("poster");
        // poster.value = JSON.stringify(selected);

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

