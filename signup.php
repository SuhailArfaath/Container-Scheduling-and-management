<?php
session_start();

    include("connection.php");
    include("functions.php");


    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        // When the user clicks on the submit button
        $user_name     = $_POST['username'];
        $password      = $_POST['password'];
        $password      = md5($password);
        $user_company  = $_POST['user_company_name'];
        $account_type  = $_POST['account_type'];
        $address       = $_POST['user_company_address'];
        $status        = "active";
        $contact_number= $_POST['user_contact_number'];

        if((!empty($user_name)) && (!empty($password)) && (!empty($user_company))&&
            (!empty($account_type))&& (!empty($address))&&(!empty($status))&&
            (!empty($contact_number)))
        {

            // Saving to data base
            $query = "insert into users (user_name,password,user_company,account_type,address,status,contact_number) values ('$user_name','$password','$user_company','$account_type','$address','$status','$contact_number')";

            mysqli_query($con, $query);

            header("Location: login.php");
            die;
        }
        else{
            echo '<script>alert("Please enter valid information!")</script>';
            
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
    <div class="container mt-3">

        <div class="row justify-content-center">
            
            <div class="col-8">
                <div class="card mt-1 p-2">
                    <div class="card-body"> 
                       <form method = "post">
                            <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Create your username</label>

                                <input type="text" class="form-control"  id = "username" name = "username"  placeholder="">
                            </div>
            
                            <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Create your password</label>

                                <input type="password" class="form-control" id = "password" name = "password" placeholder="">
                            </div>

                            <div class="mb-2">
                                
                                <div class="row">
                                    <div class="col-4">
                                        <p> What type of account is this? </p>
                                    </div>
                                    <div class="col-4">
                                        <input class="form-check-input" id = "exporter" type="checkbox" name="account_type" onclick="setexport()" value="Exporter">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Exporter Account
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <input class="form-check-input" id = "importer" type="checkbox"  name="account_type" onclick="setimport()" value="Importer">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Importer Account
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <input class="form-check-input" id = "importer" type="checkbox"  name="account_type" onclick="setimport()" value="FFC">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            FFC Account
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <input class="form-check-input" id = "importer" type="checkbox"  name="account_type" onclick="setimport()" value="driver">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Driver Account
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <input class="form-check-input" id = "importer" type="checkbox"  name="account_type" onclick="setimport()" value="Importer">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Dispatcher Account
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <input class="form-check-input" id = "importer" type="checkbox"  name="account_type" onclick="setimport()" value="Importer">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Accounting Account
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <input class="form-check-input" id = "importer" type="checkbox"  name="account_type" onclick="setimport()" value="Importer">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Staff Account
                                        </label>
                                    </div>
                                </div>
                                                            
                            </div>

                            <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Enter your company name</label>

                                <input type="text" class="form-control" id = "user_company_name" name = "user_company_name" placeholder="">
                            </div>

                            <div class="mb-4">
                                <div class="row">
                                    <div class="col-4">
                                        <p class="text-left"> Enter your company's address </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <textarea class="form-control" id = "user_company_address" name = "user_company_address" rows="3"></textarea>
                                    </div>
                                </div>


                            </div>

                            

                            <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Enter your contact number</label>

                                <input type="text" class="form-control" id = "user_contact_number" name = "user_contact_number" placeholder="">
                            </div>
                            <div id="sender">
                                <button type="submit" class="btn btn-primary mb-2" id="button" onclick="reviewInfo()">Create account</button>
                            </div>
                        </form>
                    </div>

                  </div>
            </div>
        </div>
        
    </div>
    <script>
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