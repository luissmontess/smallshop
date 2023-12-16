<?php
/*1. I propose the following: Once create purchase is clicked, send the client id, 
     go ahead and create the purchase, but do not end the interaction. Beign a while loop, 
     while the client doesnt actually press confirm purchase, keep on asking for a product.
     put all of those products into an array of products. After that, begin collecting them,
     place them into queries and send them off. */

?>

<?php
//ask for inputting a product function
function getProducts($connection) {
    echo "<h2>Available Products:</h2>
    <table class='table'>
        <thead>
            <th>ID</th>
            <th>Type</th>
            <th>Price</th>
        </thead>
        <tbody>";

    // Section for retrieving available products for purchase
    $sql_get_products = 'SELECT * FROM product';
    $result_get_products = $connection->query($sql_get_products);

    if (!$result_get_products) {
        die('Invalid query: ' . $connection->error);
    }

    while ($row_products = $result_get_products->fetch_assoc()) {
        echo "
            <tr>
                <td>{$row_products['id_product']}</td>
                <td>{$row_products['type']}</td>
                <td>{$row_products['price']}</td>
            </tr>";
    }

    echo "
        </tbody>
    </table>";
}
?>

<?php

//function make

?>

<?php
//section for creating purchase one we have our objects
include 'ssDataBase.php';
if(!isset($_GET['id_client'])){
    header('location: http://localhost/smallshop/index.php/');
    exit;
}else{
    $id_client = $_GET['id_client'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Creator</title>
    <link rel = "stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>

    <div class="container my-5">
        <?php 
        $errormsg = "";
        $successmsg = "";
        $prduct_id_array = array();
            getProducts($connection);
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $id_product = $_POST['id_product'];
                    if(empty($id_product)){
                        $errormsg = "Product ID is required";
                        $_GET['addsubmit'] == false;
                    }else{
                        $successmsg = "Product ID entered.";
                        echo $successmsg;
                    }
                }

            echo "<form method = 'post'>
            <div class = 'row mb-3'>
                <label class = 'col-sm-3 col-form-label'>Enter Product ID: </label>
                <div class = 'col-sm-6'>
                    <input type = 'number' class = 'form-control' name='id_product'> 
                </div>
            </div>
            <div class='row mb-3'>
                <div class='col-sm-6 offset-sm-3'>
                    <button type='submit' class='btn btn-primary'>Submit</button>
                </div>
            </div>
            </form>";
        ?>

        
    </div>
</body>
</html>