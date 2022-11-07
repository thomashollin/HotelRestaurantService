<!DOCTYPE HTML>
<html>
<head>
    <title>Hotel Restaraunt Reservierung </title>

    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

</head>
<body>

    <!-- container -->
    <div class="container">

        <div class="page-header">
            <h1>Tischreservierung</h1>
        </div>

<?php
if($_POST){

    // include database connection
    include 'config/database.php';

    try{

        // insert query
        $query = "INSERT INTO reservierungen SET res_name=:name, res_datum=:datum, res_uhrzeit=:zeit, res_anzahl=:personen, res_zimmer=:zimmernummer";

        // prepare query for execution
        $stmt = $con->prepare($query);

        // posted values
        $name=htmlspecialchars(strip_tags($_POST['name']));
        $zimmernummer=htmlspecialchars(strip_tags($_POST['zimmernummer']));
        $personen=htmlspecialchars(strip_tags($_POST['personen']));
        $datum=htmlspecialchars(strip_tags($_POST['datum']));
        $zeit=htmlspecialchars(strip_tags($_POST['zeit']));

        // bind the parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':zimmernummer', $zimmernummer);
        $stmt->bindParam(':personen', $personen);
        $stmt->bindParam(':datum', $datum);
        $stmt->bindParam(':zeit', $zeit);

        // Execute the query
        if($stmt->execute()){
            echo "<div class='alert alert-success'>Reservierung bestätitgt.</div>";
        }else{
            echo "<div class='alert alert-danger'>Reservierung fehlgeschlagen.</div>";
        }

    }

    // show error
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Zimmernummer</td>
            <td><input type='number' name='zimmernummer' class='form-control' /></td>
        </tr>
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' class='form-control' /></td>
        </tr>
        <tr>
            <td>Datum</td>
            <td><input type='date' name='datum' class='form-control' /></td>
        </tr>
         <tr>
            <td>Zeit</td>
            <td><input type='time' name='zeit' class='form-control' /></td>
         </tr>
        <tr>
         <tr>
            <td>Personen</td>
            <td><input type='number' name='personen' class='form-control' /></td>
         </tr>
        <tr>
            <td></td>
            <td>
                <input type='submit' value='Speichern' class='btn btn-primary' />
                <a href='index.php' class='btn btn-danger'>Zurück</a>
            </td>
        </tr>
    </table>
</form>

 </div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>