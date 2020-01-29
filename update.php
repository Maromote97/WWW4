<?php
$Imie = $Nazwisko = $RodzajStypendium = "";
$ImieErr = $NazwiskoErr = $RodzajStypendiumErr = "";
require_once "polaczenie.php";

if(isset($_POST["IdStudenta"]) && !empty($_POST["IdStudenta"])){
    $IdStudenta = $_POST["IdStudenta"];
    $inputImie = trim($_POST["Imie"]);
    if(empty($inputImie)){
        $ImieErr = "Proszę wpisać Imie.";
    }else{
        $Imie = $inputImie;
    }
    $inputNazwisko = trim($_POST["Nazwisko"]);
    if(empty($inputNazwisko)){
        $NazwiskoErr = "Proszę wpisać Nazwisko.";
    } else{
        $Nazwisko = $inputNazwisko;
    }
    $inputRodzajStypendium = trim($_POST["RodzajStypendium"]);
    if(empty($inputRodzajStypendium)){
        $RodzajStypendiumErr = "Proszę wpisać rodzaj stypendium.";
    } else{
        $RodzajStypendium = $inputRodzajStypendium;
    }
    if(empty($ImieErr) && empty($NazwiskoErr) && empty($RodzajStypendiumErr)){
        $sql = "UPDATE Student SET Imie=:Imie, Nazwisko=:Nazwisko, RodzajStypendium=:RodzajStypendium WHERE IdStudenta=:IdStudenta";
        if($stmt = $conn->prepare($sql)){
            $stmt->bindParam(":Imie", $paramImie);
            $stmt->bindParam(":Nazwisko", $paramNazwisko);
            $stmt->bindParam(":RodzajStypendium", $paramRodzajStypendium);
            $stmt->bindParam(":IdStudenta", $paramIdStudenta);
            $paramImie = $Imie;
            $paramNazwisko = $Nazwisko;
            $paramRodzajStypendium = $RodzajStypendium;
            $paramIdStudenta = $IdStudenta;
            if($stmt->execute()){
                header("location: Student.php");
                exit();
            } else{
                echo "Coś jest nie tak, spróbuj ponownie pózniej.";
            }
        }
        unset($stmt);
    }
    unset($conn);
} else{
    if(isset($_GET["IdStudenta"]) && !empty(trim($_GET["IdStudenta"]))){
        $IdStudenta =  trim($_GET["IdStudenta"]);
        $sql = "SELECT * FROM Student WHERE IdStudenta = :IdStudenta";
        if($stmt = $conn->prepare($sql)){
            $stmt->bindParam(":IdStudenta", $paramIdStudenta);
            $paramIdStudenta = $IdStudenta;
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $Imie = $row["Imie"];
                    $Nazwisko = $row["Nazwisko"];
                    $RodzajStypendium = $row["RodzajStypendium"];
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
    <title>Update Student</title>
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
                    <h2>Update Student</h2>
                </div>
                <p>Wpisz wartości, aby wprowadzić zmiany.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group <?php echo (!empty($ImieErr)) ? 'has-Error' : ''; ?>">
                        <label>Imie</label>
                        <input type="text" name="Imie" class="form-control" value="<?php echo $Imie; ?>">
                        <span class="help-block"><?php echo $ImieErr;?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($NazwiskoErr)) ? 'has-Error' : ''; ?>">
                        <label>Nazwisko</label>
                        <input type="text" name="Nazwisko" class="form-control" value="<?php echo $Nazwisko; ?>">
                        <span class="help-block"><?php echo $NazwiskoErr;?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($RodzajStypendiumErr)) ? 'has-Error' : ''; ?>">
                        <label>RodzajStypendium</label>
                        <input type="text" name="RodzajStypendium" class="form-control" value="<?php echo $RodzajStypendium; ?>">
                        <span class="help-block"><?php echo $RodzajStypendiumErr;?></span>
                    </div>
                    <input type="hidden" name="IdStudenta" value="<?php echo $IdStudenta; ?>"/>
                    <input type="submit" class="btn btn-primary" value="Potwierdź">
                    <a href="Student.php" class="btn btn-default">Anuluj</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>