<?php
if(isset($_POST["IdStudenta"]) && !empty($_POST["IdStudenta"])){
    require_once "polaczenie.php";
    $sql = "DELETE FROM Student WHERE IdStudenta = :IdStudenta";
    if($stmt = $conn->prepare($sql)){
        $stmt->bindParam(":IdStudenta", $paramIdStudenta);
        $paramIdStudenta = trim($_POST["IdStudenta"]);
        if($stmt->execute()){
            header("location: Student.php");
            exit();
        } else{
            echo "Coś jest nie tak, spróbuj ponownie pózniej.";
        }
    }
    unset($stmt);
    unset($conn);
} else{
    if(empty(trim($_GET["IdStudenta"]))){
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Delete Student</title>
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
                    <h1>Delete Student</h1>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="alert alert-secondary">
                        <input type="hidden" name="IdStudenta" value="<?php echo trim($_GET["IdStudenta"]); ?>"/>
                        <p>Czy na pewno chcesz usunąć tego studenta?</p><br>
                        <p>
                            <input type="submit" value="Tak" class="btn btn-danger">
                            <a href="Student.php" class="btn btn-default">Nie</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>