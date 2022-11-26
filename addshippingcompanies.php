<?php
session_start();

    include("connection.php");
    include("functions.php");

    $user_data = check_login($con);

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

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        // print_r($_POST);
        // When the user clicks on the submit button
        $name     = $_POST['name'];
        $emailId      = $_POST['emailId'];
        $contact_name  = $_POST['contact_name'];
        $company_address = $_POST['company_address'];
        $contact_number= $_POST['contact_number'];
        $website_link = $_POST['website'];
        $user_id = $user_data['user_id'];

        // $real_data = json_decode($_POST['total'],true);
        // $harborId = $real_data['harborId'];
        // echo $harborId;

        if((!empty($name)) && (!empty($emailId)) && (!empty($contact_name))&&
            (!empty($company_address))&& (!empty($website_link))&& (!empty($contact_number)))
        {
            // Saving to data base
            $query = "insert into shipping_companies (companyName,email,website,contactPerson,address,contactNumber) values ('$name','$emailId','$website_link','$contact_name','$company_address','$contact_number')";

            mysqli_query($con, $query);

            header("Location: successfully_added.php");
            die;
        }
        else{
            echo '<script>alert("Please enter valid information!")</script>';
            header("Location: addshippingcompanies.php");
            die;
            
        }
        

    }

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add user</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
    <div class="container mt-3">

        <div class="row justify-content-center">
            
            <div class="col-8">
                <div class="card mt-1 p-2">
                    <div class="card-body"> 
                       <form method = "post">

                            <div class="mb-4">
                                <label for="exampleFormControlInput1" class="form-label">Enter shipping company name</label>

                                <input type="text" class="form-control"  id = "name" name = "name"  placeholder="" >
                            </div>
                            <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Enter email Id</label>

                                <input type="email" class="form-control" id = "emailId" name = "emailId" placeholder="">
                            </div>
                            <div class="mb-4">
                                <label for="exampleFormControlInput1" class="form-label">Paste link to company website</label>

                                <input type="text" class="form-control" id = "website" name = "website" placeholder="">
                            </div>                          
                            <div class="mb-4">
                                <label for="exampleFormControlInput1" class="form-label">Enter the name of point of contact</label>

                                <input type="text" class="form-control" id = "contact_name" name = "contact_name" placeholder="">
                            </div>

                            <div class="mb-4">
                                <div class="row">
                                    <div class="col-4">
                                        <p class="text-left"> Enter company address </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <textarea class="form-control" id = "company_address" name = "company_address" rows="3"></textarea>
                                    </div>
                                </div>


                            </div>

                            

                            <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Enter the contact number</label>

                                <input type="text" class="form-control" id = "contact_number" name = "contact_number" placeholder="Enter the contact number">
                            </div>
                            <div id="sender">
                                <input type="hidden" name="total" id="poster" value="abc"/>  

                                <button type="submit" onclick = "setJson()" class="btn btn-primary mb-2" id="button">Add shipping company</button>
                            </div>
                        </form>
                    </div>

                  </div>
            </div>
        </div>
        
    </div>
    <script>
         function setHarbor()
        {
            var subjectIdNode = document.getElementById('harbor');
            harborId = subjectIdNode.options[subjectIdNode.selectedIndex].value;
            console.log("The selected name=",harborId);
            setJson();
        }

        function setJson()
        {
            var poster =  document.getElementById("poster");
            var warehouse_data = {
                    "harborId"    : harborId,
                    }
            json_data = JSON.stringify(warehouse_data);
            poster.value = json_data;
            console.log(poster.value);


        }

        var checkAccountType = 0;
        var  user_data       = {}
        // the selector will match all input controls of type :checkbox
        // and attach a click event handler 
        $("input:checkbox").on('click', function() {
        // in the handler, 'this' refers to the box clicked on
        var $box = $(this);
        if ($box.is(":checked")) {
            // the name of the box is retrieved using the .attr() method
            // as it is assumed and expected to be immutable
            var group = "input:checkbox[name='" + $box.attr("name") + "']";
            // the checked state of the group/box on the other hand will change
            // and the current value is retrieved using .prop() method
            $(group).prop("checked", false);
            $box.prop("checked", true);
        } else {
            $box.prop("checked", false);
        }
        });

        // function setexport()
        // {
        //     checkAccountType = 1;
        //     console.log(checkAccountType," Export");
        // }

        // function setimport()
        // {
        //     checkAccountType = 0;
        //     console.log(checkAccountType," Import");
        // }

        // function reviewInfo()
        // {
        //     button = document.getElementById('button');
        //     buttonName = button.innerHTML
            
        //     username     = document.getElementById("username").value;
        //     console.log(username);
        //     password     = document.getElementById('password').value;
        //     exporter_account = document.getElementById('exporter').value;
        //     importer_account = document.getElementById('importer').value;
        //     console.log(exporter_account,importer_account)
        //     companyname  = document.getElementById('user_company_name').value;
        //     address      = document.getElementById('user_company_address').value;
        //     contactnumber= document.getElementById('user_contact_number').value;
        //     console.log(checkAccountType)
        //     if (checkAccountType == 1) {
        //         account_type = "Exporter";
        //         } 
        //     else {
        //     account_type = "Importer";
        //     }
        //     console.log("Exp/imp:",account_type)
        //     p1 = document.getElementById('Username');
        //     p2 = document.getElementById('Password');
        //     p3 = document.getElementById('Account_type');
        //     p4 = document.getElementById('Companyname');
        //     p5 = document.getElementById('Address');
        //     p6 = document.getElementById('Contactnumber');
        //     button = document.getElementById('button');

        //     p1.innerHTML = "Username: "+username;

        //     p2.innerHTML = "Password: "+password;

        //     p3.innerHTML = "Account type: "+account_type;

        //     p4.innerHTML = "Company Name: "+companyname;

        //     p5.innerHTML = "Address: "+address;


        //     p6.innerHTML = "Contact number: "+"+"+contactnumber;

        //     // button.innerHTML = "Submit"
        //     // button.type      = "submit"
        //         // user_data = {"userData":{
        //         // "user_name"     : username,
        //         // "password"     : password,
        //         // "user_company" : companyname,
        //         // "account_type" : account_type,
        //         // "address"      : address+", "+landmark+", "+state+" - "+pincode,
        //         // "status"       : "activate",
        //         // "contactnumber": contactnumber
        //         // }}

        // }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>