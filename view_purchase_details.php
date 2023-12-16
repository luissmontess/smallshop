<?php
include 'ssDataBase.php';
if(!isset($_GET['id_purchase'])){
    header('location: http://localhost/smallshop/index.php/');
    exit;
}

$id_purchase = $_GET['id_purchase'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo 'Purchase ID: ' . $id_purchase; ?></title>
    <link rel = "stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="overflow-auto">
        <div class="container my-5">
            <h2><?php echo 'Purchase ID: ' . $id_purchase; ?></h2>
            <br>
            <table class="table">
                <thead>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Price</th>
                </thead>
                <tbody>
                    <?php
                    $sql_purchases = "SELECT 
                                        product.id_product, product.type, product.price
                                    FROM
                                        purchase_product
                                    JOIN
                                        product ON purchase_product.id_product = product.id_product
                                    WHERE
                                        purchase_product.id_purchase = $id_purchase";

                    $result_purchases = $connection->query($sql_purchases);

                    if(!$result_purchases){
                        die('Invalid query: ' . $connection->error);
                    }

                    while($row_purchases = $result_purchases->fetch_assoc()){
                        echo "
                        <tr>
                            <td>$row_purchases[id_product]</td>
                            <td>$row_purchases[type]</td>
                            <td>$row_purchases[price]</td>
                        </tr>
                        ";
                    }
                    ?>
                </tbody>
            </table>    
        </div>
    </div>
</body>
</html>