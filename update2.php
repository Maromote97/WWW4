<?php
$Nazwa = $Kwota = "";
$NazwaErr = $KwotaErr = "";
require_once "polaczenie.php";

if(isset($_POST["IdStypendium"]) && !empty($_POST["IdStypendium"])){
    $IdStypendium = $_POST["IdStypendium"];
    $inputNazwa = trim($_POST["Nazwa"]);
    if(empty($inputNazwa)){
        $NazwaErr = "Proszę wpisać nazwe.";
    }else{
        $Nazwa = $inputNazwa;
    }
    $inputKwota = trim($_POST["Kwota"]);
    if(empty($inputKwota)){
        $KwotaErr = "Proszę wpisać kwote.";
    }elseif(!ctype_digit($inputKwota)){
        $salary_err = "Proszę wpisać liczbę dodatnią.";
    }  else{
        $Kwota = $inputKwota;
    }
    if(empty($NazwaErr) && empty($KwotaErr)){
        $sql = "UPDATE Stypendium SET Nazwa=:Nazwa, Kwota=:Kwota WHERE IdStypendium=:IdStypendium";
        if($stmt = $conn->prepare($sql)){
            $stmt->bindParam(":Nazwa", $paramNazwa);
            $stmt->bindParam(":Kwota", $paramKwota);
            $stmt->bindParam(":IdStypendium", $paramIdStypendium);
            $paramNazwa = $Nazwa;
            $paramKwota = $Kwota;
            $paramIdStypendium = $IdStypendium;
            if($stmt->execute()){
                header("location: Stypendium.php");
                exit();
            } else{
                echo "Coś jest nie tak, spróbuj ponownie pózniej.";
            }
        }
        unset($stmt);
    }
    unset($conn);
} else{
    if(isset($_GET["IdStypendium"]) && !empty(trim($_GET["IdStypendium"]))){
        $IdStypendium =  trim($_GET["IdStypendium"]);
        $sql = "SELECT * FROM Stypendium WHERE IdStypendium = :IdStypendium";
        if($stmt = $conn->prepare($sql)){
            $stmt->bindParam(":IdStypendium", $paramIdStypendium);
            $paramIdStypendium = $IdStypendium;
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
    }  else{
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Update Stypendium</title>
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
                    <h2>Update Stypendium</h2>
                </div>
                <p>Wpisz wartości, aby wprowadzić zmiany.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group <?php echo (!empty($NazwaErr)) ? 'has-Error' : ''; ?>">
                        <label>Nazwa</label>
                        <input type="text" name="Nazwa" class="form-control" value="<?php echo $Nazwa; ?>">
                        <span class="help-block"><?php echo $NazwaErr;?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($KwotaErr)) ? 'has-Error' : ''; ?>">
                        <label>Kwota</label>
                        <input type="text" name="Kwota" class="form-control" value="<?php echo $Kwota; ?>">
                        <span class="help-block"><?php echo $KwotaErr;?></span>
                    </div>
                    <input type="hidden" name="IdStypendium" value="<?php echo $IdStypendium; ?>"/>
                    <input type="submit" class="btn btn-primary" value="Potwierdź">
                    <a href="Stypendium.php" class="btn btn-default">Anuluj</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>