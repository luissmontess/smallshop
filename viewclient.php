<?php
//not finished
include 'ssDataBase.php';
$id_client = "";
$names = "";
$lastnames = "";
$email = "";
$telephone = "";
$address = "";
$created_at = "";

$errormsg = "";
$successmsg = "";

if(!isset($_GET['id_client'])){
    header('location: http://localhost/smallshop/index.php/');
    exit;
}else{
    //query for retrieving client info
    $id_client = $_GET['id_client'];
    $sql = "SELECT * FROM client WHERE id_client = $id_client";
    $result = $connection->query($sql);

    $row = $result->fetch_assoc();

    if(!$row){
        header("location: http://localhost/smallshop/index.php/");
        exit;
    }else{
        $names = $row['names'];
        $lastnames = $row['lastnames'];
        $email = $row['email'];
        $telephone = $row['telephone'];
        $address = $row['address'];
        $created_at = $row['created_at'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $names .  ' '. $lastnames;?></title>
    <link rel = "stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2><?php echo $names . ' ' . $lastnames;?></h2>
        <div class="row mb-3">
            <label class = "col-sm-3 col-form-label"><b>E-mail</b></label>
            <div class = "col-sm-6>">
                <p><?php echo $email;?></p> 
            </div>
        </div>
        <div class="row mb-3">
            <label class = "col-sm-3 col-form-label"><b>Telephone</b></label>
            <div class = "col-sm-6>">
                <p><?php echo $telephone;?></p> 
            </div>
        </div>
        <div class="row mb-3">
            <label class = "col-sm-3 col-form-label"><b>Address</b></label>
            <div class = "col-sm-6>">
                <p><?php echo $address;?></p> 
            </div>
        </div>
        <div class="row mb-3">
            <label class = "col-sm-3 col-form-label"><b>Creation</b></label>
            <div class = "col-sm-6>">
                <p><?php echo $created_at;?></p> 
            </div>
        </div>
        <div class = "row mb-3">
            <div class="offset-sm-3 col-sm-2 d-grid">
                <a class = "btn btn-outline-primary" href="/smallshop/index.php" role="button"><b>Main Client List</b></a>
            </div>
            <div class="col-sm-2 d-grid">
                <a class = "btn btn-outline-primary" href=<?php echo "'/smallshop/editclient.php?id_client=$row[id_client]'";?> role="button"><b>Edit Client Info</b></a>
            </div>
            <div class="col-sm-2 d-grid">
                <a class= "btn btn-outline-primary" href=<?php echo "'/smallshop/view_client_purchases.php?id_client=$row[id_client]'";?> role="button"><b>View Client Purchases</b></a>
            </div>
        </div>
    </div>
</body>
</html>