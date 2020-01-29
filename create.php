<?php
require_once "polaczenie.php";
$Imie = $Nazwisko = $RodzajStypendium = "";
$ImieError = $NazwiskoError = $RodzajStypendiumError = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $inputImie = $_POST["Imie"];
    if(empty($inputImie)){
        $ImieError = "Proszę wpisać Imie.";
    } else{
        $Imie = $inputImie;
    }
    $inputNazwisko = $_POST["Nazwisko"];
    if(empty($inputNazwisko)){
        $NazwiskoError = "Proszę wpisać Nazwisko.";
    } else{
        $Nazwisko = $inputNazwisko;
    }
    $inputRodzajStypendium = trim($_POST["RodzajStypendium"]);
    if(empty($inputRodzajStypendium)) {
        $RodzajStypendiumError = "Proszę wpisać rodzaj stypendium.";
    }else{
        $RodzajStypendium = $inputRodzajStypendium;
    }
    if(empty($ImieError) && empty($NazwiskoError) && empty($RodzajStypendiumError)){
        $sql = "INSERT INTO Student (Imie, Nazwisko, RodzajStypendium) VALUES (:Imie, :Nazwisko, :RodzajStypendium)";
        if($stmt = $conn->prepare($sql)){
            $stmt->bindParam(":Imie", $paramImie);
            $stmt->bindParam(":Nazwisko", $paramNazwisko);
            $stmt->bindParam(":RodzajStypendium", $paramRodzajStypendium);
            $paramImie = $Imie;
            $paramNazwisko = $Nazwisko;
            $paramRodzajStypendium = $RodzajStypendium;
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
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Create Student</title>
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
                    <h2>Create Student</h2>
                </div>
                <p>Uzupełnij formularz, aby dodać studenta do bazy danych.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($ImieError)) ? 'has-error' : ''; ?>">
                        <label>Imie</label>
                        <input type="text" name="Imie" class="form-control" value="<?php echo $Imie; ?>">
                        <span class="help-block"><?php echo $ImieError;?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($NazwiskoError)) ? 'has-error' : ''; ?>">
                        <label>Nazwisko</label>
                        <input name="Nazwisko" class="form-control" value="<?php echo $Nazwisko; ?>">
                        <span class="help-block"><?php echo $NazwiskoError;?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($RodzajStypendiumError)) ? 'has-error' : ''; ?>">
                        <label>Rodzaj Stypendium</label>
                        <input type="text" name="RodzajStypendium" class="form-control" value="<?php echo $RodzajStypendium; ?>">
                        <span class="help-block"><?php echo $RodzajStypendiumError;?></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Zatwierdź">
                    <a href="Student.php" class="btn btn-default">Anuluj</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>