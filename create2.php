<?php
require_once "polaczenie.php";
$Nazwa = $Kwota = "";
$NazwaError = $KwotaError = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $inputNazwa = $_POST["Nazwa"];
    if(empty($inputNazwa)){
        $NazwaError = "Proszę wpisać nazwę.";
    } else{
        $Nazwa = $inputNazwa;
    }
    $inputKwota = $_POST["Kwota"];
    if(empty($inputKwota)){
        $KwotaError = "Proszę wpisać kwotę.";
    }elseif(!ctype_digit($inputKwota)){
        $salary_err = "Proszę wpisać liczbę dodatnią.";
    }  else{
        $Kwota = $inputKwota;
    }
    if(empty($NazwaError) && empty($KwotaError)){
        $sql = "INSERT INTO Stypendium (Nazwa, Kwota) VALUES (:Nazwa, :Kwota)";
        if($stmt = $conn->prepare($sql)){
            $stmt->bindParam(":Nazwa", $paramNazwa);
            $stmt->bindParam(":Kwota", $paramKwota);
            $paramNazwa = $Nazwa;
            $paramKwota = $Kwota;
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
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Create Stypendium</title>
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
                    <h2>Create Stypendium</h2>
                </div>
                <p>Uzupełnij formularz, aby dodać stypendium do bazy danych.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"">
                    <div class="form-group <?php echo (!empty($NazwaError)) ? 'has-error' : ''; ?>">
                        <label>Nazwa</label>
                        <input type="text" name="Nazwa" class="form-control" value="<?php echo $Nazwa; ?>">
                        <span class="help-block"><?php echo $NazwaError;?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($KwotaError)) ? 'has-error' : ''; ?>">
                        <label>Kwota</label>
                        <input name="Kwota" class="form-control" value="<?php echo $Kwota; ?>">
                        <span class="help-block"><?php echo $KwotaError;?></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Zatwierdź">
                    <a href="Stypendium.php" class="btn btn-default">Anuluj</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>