<?php
include 'ssDataBase.php';
$id_client = "";
$names = "";
$lastnames = "";
$email = "";
$telephone = "";
$address = ""; //remember that in the database the value is address with 2 d's

$successmsg = "";
$errormsg = "";


if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(!isset($_GET['id_client'])){
        header('location: http://localhost/smallshop/no_idclient_error_page.php');
        exit;
    }else{
        $id_client = $_GET['id_client'];
        $sql_get_client = "SELECT 
                            names, lastnames, email, telephone, address, created_at     
                           FROM 
                            client
                           WHERE
                            id_client = $id_client";
        $result_get_client = $connection->query($sql_get_client);

        if(!$result_get_client){
            die('Invalid query: ' . $connection->error);
        }

        $client_array = $result_get_client->fetch_assoc();
        $names = $client_array['names'];
        $lastnames = $client_array['lastnames'];
        $email = $client_array['email'];
        $telephone = $client_array['telephone'];
        $address = $client_array['address'];
    }
}else{
    $id_client = $_POST['id_client'];
    $names = $_POST['names'];
    $lastnames = $_POST['lastnames'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $address = $_POST['address'];

    if(empty($id_client)||empty($names)||empty($lastnames)||empty($email)||empty($telephone)||empty($address)){
        $errormsg = 'All fields are required';
    }else{
        $sql_edit_client= "UPDATE client
                        SET
                            names = '$names', lastnames = '$lastnames', email = '$email', telephone = '$telephone', address = '$address'
                        WHERE
                            id_client = '$id_client'";
        $result_edit_client = $connection->query($sql_edit_client);

        if(!$result_edit_client){
            $errormsg = 'Invalid query: ' . $conneciton->error;
        }else{
            $successmsg = 'User odified correctly!';
            header('location: http://localhost/smallshop/index.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client</title>
    <link rel = "stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2><?php echo 'Editing: ' . $names . ' ' . $lastnames; ?></h2>

        <?php
        if(!empty($errormsg)){
            echo"
            <div class = 'alert alert-warning alert-dismissible fade show' role = 'alert'>
                <strong>$errormsg</strong>
                <button type = 'button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button>
            </div>
            "; 
        }
        ?>  
        <br>
        <form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
            <input type="hidden" name="id_client" value=<?php echo $id_client; ?>>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label"><b>Name(s)</b></label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="names" value=<?php echo $names; ?>>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label"><b>Last Name(s)</b></label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="lastnames" value=<?php echo $lastnames; ?>>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label"><b>Email</b></label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value=<?php echo $email; ?>>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label"><b>Telephone</b></label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="telephone" value=<?php echo $telephone; ?>>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label"><b>Address</b></label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value=<?php echo $address; ?>>
                </div>
            </div>

            <?php 
            if(!empty($successMessage)){
                echo "
                <div class = 'row mb-3'>
                    <div class = 'offset-sm-3 col-sm-6'>
                    <div class = 'alert alert-success alert-dismissible fade show' role = 'alert'>
                    <strong>$successMessage</strong>
                    <button type = 'button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button>
                </div>
                    </div>
                </div>
                ";
            }
            ?>

            <div class = "row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary"><b>Submit</b></button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class = "btn btn-outline-primary" href="/smallshop/index.php" role="button"><b>Cancel</b></a>
                </div>
            </div>

        </form>
    </div>
</body>
</html>