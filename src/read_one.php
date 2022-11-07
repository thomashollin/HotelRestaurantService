<!DOCTYPE HTML>
<html>
<head>
    <title>Hotel Restaraunt Reservierung</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

</head>
<body>
    <div class="container">

        <div class="page-header">
            <h1>Reservierung</h1>
        </div>

        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $res_id=isset($_GET['res_id']) ? $_GET['res_id'] : die('ERROR: Eintrag nicht vorhanden.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT res_id, res_zimmer, res_name, res_datum, res_uhrzeit, res_anzahl  FROM reservierungen WHERE res_id = ? LIMIT 0,1";
            $stmt = $con->prepare( $query );

            // this is the first question mark
            $stmt->bindParam(1, $res_id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $name = $row['res_name'];
            $zimmernummer = $row['res_zimmer'];
            $datum = $row['res_datum'];
            $zeit = $row['res_uhrzeit'];
            $personen = $row['res_anzahl'];
        }

        // show error
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

       <!--we have our html table here where the record will be displayed-->
       <table class='table table-hover table-responsive table-bordered'>
       <tr>
                   <td>Zimmernummer</td>
                   <td><?php echo htmlspecialchars($zimmernummer, ENT_QUOTES);  ?></td>
               </tr>
               <tr>
                   <td>Name</td>
                   <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
               </tr>
               <tr>
                   <td>Datum</td>
                   <td><?php echo htmlspecialchars($datum, ENT_QUOTES);  ?></td>
               </tr>
                <tr>
                   <td>Zeit</td>
                   <td><?php echo htmlspecialchars($zeit, ENT_QUOTES);  ?></td>
                </tr>
               <tr>
                <tr>
                   <td>Personen</td>
                   <td><?php echo htmlspecialchars($personen, ENT_QUOTES);  ?></td>
                </tr>

           <tr>
               <td></td>
               <td>
                   <a href='index.php' class='btn btn-danger'>Zurück zu den Reservierungen</a>
               </td>
           </tr>
       </table>

    </div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>