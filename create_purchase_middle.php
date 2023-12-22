<?php
session_start();

//validate
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['submit_button'])){

        $button_value = $_POST['submit_button'];//handle what is inside with a variable

        if($button_value == 'purchase_ongoing'){
            $product_id_array = explode(",", $_POST['product_id_array']);
            $product_id_array = array_filter($product_id_array);
            $id_product = $_POST['id_product'];
            if(empty($id_product)){
                $errormsg = "Product ID is required";
            }else{
                array_push($product_id_array, $id_product);
                //print_r($product_id_array);
                $_SESSION['data'] = $product_id_array;
                $successmsg = "Product ID entered.";
            }
        }elseif($button_value == 'cancel_product'){
            $product_id_array = explode(",", $_POST['product_id_array']);
            array_pop($product_id_array);
            $_SESSION['data'] = $product_id_array;
            $successmsg = "Product eliminated.";
        }else{
            echo "another hi";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Middleman</title>
    <link rel = "stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <?php if(!empty($successmsg)): ?>
            <?php if($button_value == 'purchase_ongoing'): ?>
                <br>
                <br>
                <br>
                <br>
                <br>
                <h2 style="text-align: center;">Product Entered Successfully!</h2>
                <br>
                <div class="row mb-3">

                    <div class="offset-sm-2 col-sm-2 d-grid">
                        <a class="btn btn-outline-primary"  href="/smallshop/create_purchase.php"><b>Add Product</b></a>
                    </div>

                    <div class="col-sm-2 d-grid">
                        <form action="create_purchase_middle.php" method="post">
                            <input type="hidden" name="product_id_array" value=<?php echo implode(",", $_SESSION['data']); ?>>
                            <button type="submit" name="submit_button" value="cancel_product" class="btn btn-outline-primary"><b>Cancel Recent Product</b></button>
                        </form>
                    </div>
                
                
                    <div class="col-sm-2 d-grid">
                        <a class="btn btn-outline-primary"  href="/smallshop/create_purchase.php?status=confirmed"><b>Confirm Purchase</b></a>
                    </div>
                
                    <div class="col-sm-2 d-grid">
                        <a class="btn btn-outline-primary"  href="/smallshop/create_purchase.php?status=canceled"><b>Cancel Purchase</b></a>
                    </div>

                </div>
            <?php elseif($button_value == 'cancel_product'): ?>
                <br>
                <br>
                <br>
                <br>
                <br>
                <h2 style="text-align: center;">Last Product Cancelled!</h2>
                <br>
                <div class="row mb-3">

                    <div class="offset-sm-2 col-sm-2 d-grid">
                        <a class="btn btn-outline-primary"  href="/smallshop/create_purchase.php"><b>Add Product</b></a>
                    </div>

                    <div class="col-sm-2 d-grid">
                        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                            <input type="hidden" name="product_id_array" value=<?php echo implode(",", $_SESSION['data']) ?>>
                            <button type="submit" name="submit_button" value="cancel_product" class="btn btn-outline-primary"><b>Cancel Recent Product</b></button>
                        </form>
                    </div>
                
                    <div class="col-sm-2 d-grid">
                        <a class="btn btn-outline-primary"  href="/smallshop/create_purchase.php?status=confirmed"><b>Confirm Purchase</b></a>
                    </div>
                
                    <div class="col-sm-2 d-grid">
                        <a class="btn btn-outline-primary"  href="/smallshop/create_purchase.php?status=canceled"><b>Cancel Purchase</b></a>
                    </div>
            <?php endif; ?> 
        <?php endif; ?>
        <?php if(!empty($errormsg)): ?>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="row mb-3">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong><?php echo $errormsg; ?></strong>
                    <a class="btn btn-outline-primary"  href="/smallshop/create_purchase.php?status=null"><b>Go back</b></a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>