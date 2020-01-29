<?php
if(isset($_GET["IdStypendium"]) && !empty(trim($_GET["IdStypendium"]))){
    require_once "polaczenie.php";
    $sql = "SELECT * FROM Stypendium WHERE IdStypendium = :IdStypendium";
    if($stmt = $conn->prepare($sql)){
        $stmt->bindParam(":IdStypendium", $paramIdStypendium);
        $paramIdStypendium = trim($_GET["IdStypendium"]);
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $Nazwa = $row["Nazwa"];
                $Kwota = $row["Kwota"];
            } else{
                header("location: error.php");
                exit();
            }
        } else{
            echo "Coś jest nie tak, spróbuj ponownie pózniej.";
        }
    }
    unset($stmt);
    unset($conn);
} else{
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Read Stypendium</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/solar/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style type="text/css">
        body{
            background: lightblue;
        }
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h1>Read Stypendium</h1>
                </div>
                <div class="form-group">
                    <label style="font-weight: bold">Nazwa</label>
                    <p class="form-control-static"><?php echo $row["Nazwa"]; ?></p>
                </div>
                <div class="form-group">
                    <label style="font-weight: bold">Kwota</label>
                    <p class="form-control-static"><?php echo $row["Kwota"]; ?></p>
                </div>
                <p><a href="Stypendium.php" class="btn btn-primary">Powrót</a></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>