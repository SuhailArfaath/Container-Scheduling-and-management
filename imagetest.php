<?php

$connect = mysqli_connect("localhost","root","","container_project_db");
if(isset($_POST['insert']))
{
    
    $file = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    $query = "INSERT INTO product_images(image_data) VALUES ('$file')";
    if(mysqli_query($connect,$query))
    {
        echo "Updated";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <title> Image test </title>
</head>
<body>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="image" id="image"/>
    <br/>
    <input type="submit" name="insert" id="insert" value="insert"/>
</form>
<?php
$query = "SELECT * FROM product_images";
$result = mysqli_query($connect,$query);
while($row = mysqli_fetch_array($result))
{
    echo' 
        <span>
        <img src="data:image/jpeg;base64,'.base64_encode($row['name']).' "/>
        </span>
        ';
}
?>
</body>
</html>