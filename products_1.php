<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

if($_SERVER['REQUEST_METHOD'] == "GET")
{
    // When the user clicks on the create account button
   
    

        // Reading from the data base
        $query = "select * from products";

        $result = mysqli_query($con, $query);
        // print_r( $result);

        if($result)
        {
            if($result && mysqli_num_rows($result) > 0)
            {
                $products_data = mysqli_fetch_all($result);
                // header("Content-type: " . $products_data[product_image][".jpg"]);
                // echo $products_data[produt];
            }
            print_r($products_data); 
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
                <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Link
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
                </li>
                <li class="nav-item">
                <a class="nav-link disabled">Link</a>
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
    
    <div class="row justify-content-center mt-2">
        <div class="col-6">
            <h1 class="display-4 fs-3 text-center"><b>Content Scheduling and Management</b></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="row">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Product_id</th>
                    <th scope="col">Product_name</th>
                    <th scope="col">brand</th>
                    <th scope="col">Type</th>
                    <th scope="col">Product_barcode</th>
                    <th scope="col">Product_weight</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        for ($row = 0; $row < count($products_data); $row++) {
                            echo "<tr>";
                         
                            for ($col = 0; $col < 7; $col++) {
                              echo "<td>".$products_data[$row][$col]."</td>";
                            }
                            echo "</tr>";
                          }
                    ?>
                    
                </tbody>
                </table>
            </div>
            <div class="row">
                <a href="addproducts.php">
                    <button class="btn btn-success  ml-2" type="button">Add product</button>
                </a>
            </div>
        </div>
    </div>

   

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>