<?php
session_start();

    include("connection.php");
    include("functions.php");


    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        // When the user clicks on the create account button
        $user_name = $_POST['username'];
        $password  = $_POST['password'];
        $password = md5($password);
        $user_company  = $_POST['user_company_name'];
        $contact_number  = $_POST['user_contact_number'];

        if(!empty($user_name) &&
            (!empty($password)) &&
            (!empty($user_company))&&
            (!empty($contact_number)))
        {
            // Saving to data base
            $query = "insert into users (user_name,password,user_company,contact_number) values ('$user_name','$password','$user_company','$contact_number')";

            mysqli_query($con, $query);

            header("Location: login.php");
            die;
        }
        else{
            echo "Please enter valid information!";
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
  </head>
  <body>
    <div class="container mt-5 text-center">
        <div class="row justify-content-center mt-5">
            <div class="col-8">
                <h2> Create your account </h2>
                <div class="card text-center mt-5 p-2">
                    <div class="card-body"> 
                       <form method = "post">
                            <div class="mb-4">
                                <input type="email" class="form-control" id="exampleFormControlInput1" name = "username" placeholder="Create your username">
                            </div>
            
                            <div class="mb-4">
                                <input type="password" class="form-control" id="exampleFormControlInput1" name = "password" placeholder="Create your password">
                            </div>

                            <div class="mb-4">
                                <input type="text" class="form-control" id="exampleFormControlInput1" name = "user_company_name" placeholder="Enter your company name">
                            </div>

                            <div class="mb-4">
                                <input type="text" class="form-control" id="exampleFormControlInput1" name = "user_contact_number" placeholder="Enter your contact number">
                            </div>
                                <button type="submit" class="btn btn-primary mb-2">Create account</button>
                        </form>
                    </div>

                  </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>