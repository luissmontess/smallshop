<?php
include 'ssDataBase.php';
$names = "";
$lastnames = "";
$email = "";
$telephone = "";
$adress = "";

$errormsg = "";
$successmsg = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $names = $_POST['names'];
    $lastnames = $_POST['lastnames'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $adress = $_POST['adress'];
    if(empty($names)||empty($lastnames)||empty($email)||empty($telephone)||empty($adress)){
        $errormsg = 'All fields are required.';
    }else{
        try{
            $sql = "INSERT INTO client(names, lastnames, email, telephone, address)" . "VALUES('$names', '$lastnames', '$email', '$telephone', '$adress')";
            $result = $connection->query($sql);
            
            if($result === false){
                if($connection->errno == 1062){
                    $errormsg = "Duplicate entry: The data you are trying to insert, already exists.";
                }else{
                    $errormsg = "Invalid query: " . $connection->error;
                }
            }else{
                $names = "";
                $lastnames = "";
                $email = "";
                $telephone = "";
                $adress = "";
                $successmsg = "Register added correctly!";
                header("location: http://localhost/smallshop/index.php/");
                exit;
            }
        }catch(mysqli_sql_exception $e){
            $errormsg = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmallShop</title>
    <link rel = "stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>New Client</h2>
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

        <form method="post">
            <div class = "row mb-3">
                <label class = "col-sm-3 col-form-label">Names</label>
                <div class = "col-sm-6>">
                    <input type = "text" class = "form-control" name = "names" value = "<?php echo $names; ?>"> 
                </div>
            </div>

            <div class = "row mb-3">
                <label class = "col-sm-3 col-form-label">Last Names</label>
                <div class = "col-sm-6>">
                    <input type = "text" class = "form-control" name = "lastnames" value = "<?php echo $lastnames; ?>"> 
                </div>
            </div>

            <div class = "row mb-3">
                <label class = "col-sm-3 col-form-label">E-mail</label>
                <div class = "col-sm-6>">
                    <input type = "text" class = "form-control" name = "email" value = "<?php echo $email; ?>"> 
                </div>
            </div>

            <div class = "row mb-3">
                <label class = "col-sm-3 col-form-label">Telephone</label>
                <div class = "col-sm-6>">
                    <input type = "text" class = "form-control" name = "telephone" value = "<?php echo $telephone; ?>"> 
                </div>
            </div>

            <div class = "row mb-3">
                <label class = "col-sm-3 col-form-label">Address</label>
                <div class = "col-sm-6>">
                    <input type = "text" class = "form-control" name = "adress" value = "<?php echo $adress; ?>"> 
                </div>
            </div>

            <?php 
            if(!empty($successmsg)){
                echo "
                <div class = 'row mb-3'>
                    <div class = 'offset-sm-3 col-sm-6'>
                    <div class = 'alert alert-success alert-dismissible fade show' role = 'alert'>
                    <strong>$successmsg</strong>
                    <button type = 'button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button>
                </div>
                    </div>
                </div>
                ";
            }
            ?>

            <div class = "row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class = "btn btn-outline-primary" href="/smallshop/index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>