<?php
include 'ssDataBase.php';
session_start();
    
/*1. The main idea is to start an interaction with the user, revolving around storing the id_client in
     SESSION (At first id_client will be sent through the initial GET). Then, it will immediately taken to 
     a menu for inserting products. The flow is to insert as many productas needed, controlled by a GET['status']
     key. Once the purchase is done, the user confirms and the information is queried in to the database.
     The array where the information of a purchase is stored, is sent through POST when modified, and stored
     in SESSION. There is error handling for a missing id_client or empty product array */
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
if(!isset($_SESSION['id_client'])){
    if(isset($_GET['id_client'])){
        $_SESSION['id_client'] = $_GET['id_client'];
    }
}

if(!isset($_SESSION['data'])){
    $_SESSION['data'] = array();
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
        getProducts($connection);
        ?>

        <form action="create_purchase_middle.php" method='post'>
            <div class = "row mb-3">
                <label class = "col-sm-3 col-form-label">Enter Product ID: </label>
                <div class = "col-sm-6">
                    <input type = "number" class ="form-control" name="id_product"> 
                </div>
            </div>
            <input type="hidden" name="product_id_array" value=<?php echo implode(",", $_SESSION['data']); ?>>
            <div class="row mb-3">
                <div class="col-sm-6 offset-sm-3">
                    <button type="submit" name="submit_button" value="purchase_ongoing" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>

        <?php
        if(isset($_GET['status'])){
            if($_GET['status'] == 'confirmed'){

                $product_id_array = $_SESSION['data'];
                $id_client = $_SESSION['id_client'];

                if(empty($product_id_array)){
                    echo "<div class='row mb-3'>
                              <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                  <strong>Please submit at least one product in purchase.</strong>
                              </div>
                          </div>";
                }elseif(empty($id_client)){
                    //user screwed up impressively

                    session_unset();
                    session_destroy();
                    
                    header('location: http://localhost/smallshop/no_idclient_error_page.php');
                    exit;
                }else{
                    //now we know that an id_client exists and there are items within $product_id_array

                    $sql_insert_purchase = "INSERT INTO 
                                                purchase (id_client)
                                            VALUES 
                                                ($id_client)";
                    $result_insert_purchase = $connection->query($sql_insert_purchase);
                    if(!$result_insert_purchase){
                        die('Invalid query: ' . $connection->error);
                    }

                    $id_purchase = $connection->insert_id;

                    foreach ($product_id_array as $id_product) {
                        $sql_insert_product = "INSERT INTO 
                                                   purchase_product (id_purchase, id_product)
                                               VALUES
                                                   ($id_purchase, $id_product)";
                        $result_insert_product = $connection->query($sql_insert_product);

                        if(!$result_insert_product){
                            die('Invalid query: ' . $connection->error);
                        }   
                    }

                    session_unset();
                    session_destroy();
                    header('location: http://localhost/smallshop/view_client_purchases.php?id_client='.$id_client);
                    exit;
                }
            }elseif($_GET['status'] == 'canceled'){
                $id_client = $_SESSION['id_client'];
                if(empty($id_client)){
                    session_unset();
                    session_destroy();
                    header('location: http://localhost/smallshop/no_idclient_error_page.php');
                    exit;
                }else{
                    session_unset();
                    session_destroy();
                    header('location: http://localhost/smallshop/view_client_purchases.php?id_client='.$id_client);
                    exit;
                }
            }
        }
        ?>
    </div>
</body>
</html>