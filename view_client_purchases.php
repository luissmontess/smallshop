<?php
include 'ssDataBase.php';
if(!isset($_GET['id_client'])){
    header('location: http://localhost/smallshop/index.php/');
    exit;
}else{
    $id_client = $_GET['id_client'];
    $addsubmit = true;
}

$sql_cname_query = "SELECT names, lastnames FROM client WHERE id_client = $id_client";
$result_cname_query = $connection->query($sql_cname_query);
if(!$result_cname_query){
    die('Invalid query: ' . $connection->error);
}
$row_cname = $result_cname_query->fetch_assoc();
$names = $row_cname['names'];
$lastnames = $row_cname['lastnames'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $names . ' ' . $lastnames . ' Purchases' ?></title>
    <link rel = "stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h1><?php echo $names . ' ' . $lastnames . ' Purchase List' ?></h1>
        <a class="btn btn-primary" href=<?php echo "'/smallshop/create_purchase.php?id_client=$id_client&addsubmit=$addsubmit'";?>><b>Add Purchase</b></a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Products</th>
                    <th>Revenue</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //run purchase query, will return at least one, but no real limit
                $sql_purchases_query = "SELECT 
                                            purchase.id_purchase, 
                                            purchase.date, 
                                            COUNT(purchase_product.id_product) AS product_count,
                                            SUM(product.price) AS total_price
                                        FROM 
                                            purchase
                                        JOIN 
                                            purchase_product ON purchase.id_purchase = purchase_product.id_purchase
                                        JOIN 
                                            product ON purchase_product.id_product = product.id_product
                                        WHERE 
                                            purchase.id_client = 1
                                        GROUP BY 
                                            purchase.id_purchase, purchase.date";
                //pass query through connection
                $result_purchases_query = $connection->query($sql_purchases_query);

                //if query is wrong, kill program
                if(!$result_purchases_query){
                    die('Invalid query: ' . $connection->error);
                }

                //query is correct, retirieve purchase information until nothing left inside result
                while($row_purchase = $result_purchases_query->fetch_assoc()){
                    echo "
                        <tr>
                            <td>$row_purchase[id_purchase]</td>
                            <td>$row_purchase[date]</td>
                            <td>$row_purchase[product_count]</td>
                            <td>$row_purchase[total_price]</td>
                            <td>
                                <a class='btn btn-primary btn-sm' href ='/smallshop/view_purchase_details.php?id_purchase=$row_purchase[id_purchase]'><b>View Details</b></a>
                            </td>
                        </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>