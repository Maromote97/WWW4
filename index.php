<?php
require_once "polaczenie.php";
$sql2 =('SELECT RodzajStypendium, COUNT(*) AS dupes FROM Student GROUP BY RodzajStypendium');
$result2 = $conn->query($sql2)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tabela Stypendium Student</title>
    <meta charset="UTF-8">
    <title>Student i Stypendium</title>
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
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Główna</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Student.php">Student</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Stypendium.php">Stypendium</a>
        </li>
    </ul>
</nav><br><br>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Zbiór wszystkich studentów i przypisanych do nich stypendiów</h2>
                </div>
                <?php
                require_once "polaczenie.php";
                $sql = 'SELECT * FROM Stypendium INNER JOIN Student ON Stypendium.Nazwa = Student.rodzajStypendium ORDER BY Stypendium.Nazwa ASC';
                if($result = $conn->query($sql)){
                    $sum=0;
                    if($result->rowCount() > 0){
                        echo "<table class='table table-bordered table-striped'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>Imię</th>";
                        echo "<th>Nazwisko</th>";
                        echo "<th>Rodzaj stypendium</th>";
                        echo "<th>Kwota</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while($row = $result->fetch()){
                            $sum+=$row["Kwota"];
                            echo "<tr>";
                            echo "<td>" . $row['Imie'] . "</td>";
                            echo "<td>" . $row['Nazwisko'] . "</td>";
                            echo "<td>" . $row['Nazwa'] . "</td>";
                            echo "<td>" . $row['Kwota'] . " zł</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        unset($result);
                    } else{
                        echo "<p class='lead'><em>Brak rekordów w tabeli.</em></p>";
                    }
                } else{
                    echo "ERROR: Nie można wykonać operacji $sql. " . $mysqli->error;
                }
                unset($conn);
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                $Email = "";
                $inputEmail = trim($_POST["Email"]);
                if(empty($inputEmail)){
                    $EmailErr = "Wprowadź email.";
                } elseif(!filter_var(inputEmail, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/")))){
                    $EmailErr = "Wprowadź poprawmy email.";
                } else{
                    $Email = $inputEmail;
                }
                    $subject = "Podsumowanie kosztów stypendium";
                    $message = "Szanowny panie rektorze, suma do wypłacenia wynosi $sum złotych.";
                if(empty($EmailErr)) {
                    mail($Email, $subject, $message);
                }}?>

                <form method="post">
                    <div class="form-group <?php echo (!empty($EmailErr)) ? 'has-Error' : ''; ?>">
                        <label>Email</label>
                        <input type="text" name="Email" class="form-control" value="<?php echo $to; ?>">
                        <span class="help-block"><?php echo $EmailErr;?></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Wyslij podsumowanie">
                    <input id="save-pdf" class="btn btn-primary" type="button" value="Pobierz zestawienie stypendiów w PDF" disabled />
                </form>
            </div>
        </div>
    </div>
</div>
<div id="chart_div"></div>
<div id="piechart" style="visibility: hidden"></div>
</body>
</html>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Language', 'Rating'],
            <?php
            while($row = $result2->fetch())
            {
                echo "['".$row['RodzajStypendium']."',".$row['dupes']."],";
            }
            ?>
        ]);

        var options = {
            title: 'Ilość wybranych stypendiów',
            width: 900,
            height: 500,
            is3D: true,
            pieSliceText: 'value-and-percentage'
        }
        var container = document.getElementById('piechart');
        var chart = new google.visualization.PieChart(container);
        var btnSave = document.getElementById('save-pdf');

        google.visualization.events.addListener(chart, 'ready', function () {
            btnSave.disabled = false;
        });

        btnSave.addEventListener('click', function () {
            var doc = new jsPDF();
            doc.addImage(chart.getImageURI(), 0, 0);
            doc.save('chart.pdf');
        }, false);
        chart.draw(data, options);
    }
</script>