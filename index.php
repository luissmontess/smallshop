<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmallShop</title>
    <link rel = "stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body
    <div class = "container my-5">
        <h2>SmallShop Client List</h2>
        <a class="btn btn-primary" href = "/smallshop/create.php" role="button"><b>Add Client</b></a>
        <br>
        <table class = "table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Names</th>
                    <th>Last Names</th>
                    <th>E-mail</th>
                    <th>Purchases</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'ssDataBase.php';

                //run sql query for fetching initial client info along with respective amounts of purchases
                $sqlquery1 = "SELECT 
                                client.id_client, 
                                client.names, 
                                client.lastnames, 
                                client.email, 
                                COUNT(purchase.id_client) AS purchases
                              FROM 
                                client
                              INNER JOIN 
                                purchase ON client.id_client = purchase.id_client
                              GROUP BY 
                                client.id_client, client.names, client.lastnames, client.email";

                //pass query throug connection
                $result = $connection->query($sqlquery1);
                //since we use include, have conditional to kill the program
                if(!$result){
                    die('Invalid query: ' . $connection->error);
                }

                while($row = $result->fetch_assoc()){
                    echo "
                        <tr>
                            <td>$row[id_client]</td>
                            <td>$row[names]</td>
                            <td>$row[lastnames]</td>
                            <td>$row[email]</td>
                            <td>$row[purchases]</td>
                            <td>
                                <a class='btn btn-primary btn-sm' href ='/smallshop/viewclient.php?id_client=$row[id_client]'><b>View Info</b></a>
                                <!-- <a class='btn btn-danger btn-sm' href ='/smallshop/delete.php?id_client=$row[id_client]'><b>Delete</b></a>> -->
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