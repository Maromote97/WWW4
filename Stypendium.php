<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tabela Stypendium</title>
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
                    <h2 class="pull-left">Tabela Stypendium</h2>
                    <a href="create2.php" class="btn btn-success pull-right">Dodaj nowe Stypendium</a>
                </div>
                <?php
                require_once "polaczenie.php";
                $sql = "SELECT * FROM Stypendium";
                if($result = $conn->query($sql)){
                    if($result->rowCount() > 0){
                        echo "<table class='table table-bordered table-striped'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>Nazwa</th>";
                        echo "<th>Kwota</th>";
                        echo "<th>Operacja</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while($row = $result->fetch()){
                            echo "<tr>";
                            echo "<td>" . $row['Nazwa'] . "</td>";
                            echo "<td>" . $row['Kwota'] . " zł</td>";
                            echo "<td>";
                            echo "<a href='read2.php?IdStypendium=". $row['IdStypendium'] ."' title='Read Stypendium' data-toggle='tooltip'><span class='fa fa-eye'></span></a>";
                            echo "<a href='update2.php?IdStypendium=". $row['IdStypendium'] ."' title='Update Stypendium' data-toggle='tooltip'><span class='fa fa-pencil'></span></a>";
                            echo "<a href='delete2.php?IdStypendium=". $row['IdStypendium'] ."' title='Delete Stypendium' data-toggle='tooltip'><span class='fa fa-trash'></span></a>";
                            echo "</td>";
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
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>