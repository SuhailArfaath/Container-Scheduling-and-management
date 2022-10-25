<?php
session_start();

include("connection.php");
include("functions.php");
$user_data = check_login($con);
$user_id = $user_data['user_id'];


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


if($_SERVER['REQUEST_METHOD'] == "POST")
{
    print_r($_POST);
    $real_data = json_decode($_POST['total'],true);
    $code = $_POST['ISO6346_code'];
    $exporterId = $real_data['exporterId'];
    // echo $code;

    if(!empty($_FILES["image_file"]["name"])) { 
        echo "Inside image code!";
        // Get file info 
        $fileName = basename($_FILES["image_file"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)){ 
            echo "In!";
            $image = $_FILES['image_file']['tmp_name']; 

            $imgContent = addslashes(file_get_contents($image)); 
        }
    }

    $query = "insert into containers (ISO6346_Code,ownerCompanyId,containerImage,sourceHarbor,destinationHarbor) values ('{$code}', '{$exporterId}','{$imgContent}',0,0)";

    mysqli_query($con, $query);

    header("Location: addcontainer.php");
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
    <div class="container mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-6">
                <img src="containers.jpeg" class="img-fluid" alt="Responsive image">
                
                    <ul>
                        <li><p class="mt-4"> Fill the details to add a harbour stock room</p> </li>
                    </ul>
            </div>
            <div class="col-6">
                <div class="card p-2">
                    <div class="card-body"> 
                        <form action="addcontainer.php" method = "post" enctype="multipart/form-data">  
                            <div class="mb-4">
                                <label for="exampleFormControlInput1" class="form-label">ISO6346 code of container </label>
                                <input type="text" class="form-control" name = "ISO6346_code" id="ISO6346_code">
                            </div>

                            <div class="mb-4">
                                <div class="dropdown">
                                    <select class="form-select" aria-label="Default select example" onchange="setExporter()" id="exporter">
                                        <option selected>Choose exporter from the list</option>
                                        <?php for ($row = 0; $row < count($exporters_data); $row++) { ?>
                                            
                                            <option value="<?php echo $exporters_data[$row][0]; ?>" >
                                                <?php echo $exporters_data[$row][1]; ?>
                                            </option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                        
                            <div class="mb-4">
                                <label for="formFile" class="form-label">Choose the container image file</label>
                                <input class="form-control" type="file" id="formFile" name="image_file">
                            </div>

                            
                         
                            <input type="hidden" name="total" id="poster" value="abc"/>  
                           
                            <button type="submit" class="btn btn-primary" onclick="setJson()">Add container</button>
                        </form>
                    </div>

                  </div>
            </div>
        </div>
        
    </div>

    <script>
        var exporterId = 0;
        var container_ISO_code = document.getElementById('ISO6346_code').value;
        var productId = 0;

        function setcode()
        {
            container_ISO_code = document.getElementById('code').value;
            console.log("The selected name=" + container_ISO_code);

        }
        function setExporter()
        {
            var subjectIdNode = document.getElementById('exporter');
            exporterId = subjectIdNode.options[subjectIdNode.selectedIndex].value;
            console.log("The selected name=" + exporterId);

        }
        function setJson()
        {
            var poster =  document.getElementById("poster");
            var order_data = {
                    "exporterId": parseInt(exporterId)
                    }
            json_data = JSON.stringify(order_data);
            poster.value = json_data;


        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>