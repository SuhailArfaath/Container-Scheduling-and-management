<?php
session_start();

include("connection.php");
include("functions.php");

function pre($data, $flag = false) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    if($flag == '1') die;
}

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    // When the user clicks on the create account button
   
    $table = $_POST["table"];
        // Reading from the data base
        $column = array();
        $query = 'SHOW COLUMNS FROM '.$table;
        //pre($query,1);
        $result = mysqli_query($con, $query);
        // print_r( $result);

        if($result){

            if($result && mysqli_num_rows($result) > 0)
            {
                $column = mysqli_fetch_all($result);
            }
            $html = '<option value="">Select column</option>';
            foreach ($column as $key => $value) {
                $html .= '<option value="'.$value[0].'">'.$value[0].'</option>';
            }
            echo $html;
        }else{
            echo '<option value="">No data found</option>';
        }

}


?>