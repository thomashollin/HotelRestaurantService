
<!DOCTYPE HTML>
<html>
<head>
    <title>Hotel Restaraunt Reservierung</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

</head>
<body>

    <div class="container">

        <div class="page-header">
            <h1>Reservierung aktualisieren</h1>
        </div>

    <!-- Read record by id-->
      <?php
      // get passed parameter value, in this case, the record ID
      // isset() is a PHP function used to verify if a value is there or not
      $res_id=isset($_GET['res_id']) ? $_GET['res_id'] : die('ERROR: Kein Eintrag gefunden.');

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

      <?php

      // check if form was submitted
      if($_POST){

          try{

              // write update query
              // in this case, it seemed like we have so many fields to pass and
              // it is better to label them and not use question marks

           $query = "UPDATE reservierungen SET res_zimmer=:zimmernummer, res_name=:name, res_datum=:datum, res_uhrzeit=:zeit, res_anzahl=:personen WHERE res_id = :res_id";
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
            $stmt->bindParam(':res_id', $res_id);


              // Execute the query
              if($stmt->execute()){
                  echo "<div class='alert alert-success'>Reservierung wurde aktualisiert.</div>";
              }else{
                  echo "<div class='alert alert-danger'>Reservierung konnte nicht aktualisiert werden.</div>";
              }

          }

          // show errors
          catch(PDOException $exception){
              die('ERROR: ' . $exception->getMessage());
          }
      }
      ?>

         <!--we have our html form here where new record information can be updated-->
               <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?res_id={$res_id}");?>" method="post">
                   <table class='table table-hover table-responsive table-bordered'>
                       <tr>
                           <td>Zimmernummer</td>
                           <td><input type='number' name='zimmernummer' value="<?php echo htmlspecialchars($zimmernummer, ENT_QUOTES);  ?>" class='form-control' /></td>
                       </tr>
                        <tr>
                            <td>Name</td>
                            <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>" class='form-control' /></td>
                        </tr>
                        <tr>
                            <td>Datum</td>
                            <td><input type='date' name='datum' value="<?php echo htmlspecialchars($datum, ENT_QUOTES);  ?>" class='form-control' /></td>
                        </tr>
                         <tr>
                            <td>Zeit</td>
                            <td><input type='time' name='zeit' value="<?php echo htmlspecialchars($zeit, ENT_QUOTES);  ?>" class='form-control' /></td>
                         </tr>
                        <tr>
                         <tr>
                            <td>Personen</td>
                            <td><input type='number' name='personen' value="<?php echo htmlspecialchars($personen, ENT_QUOTES);  ?>" class='form-control' /></td>
                         </tr>

                       <tr>
                           <td></td>
                           <td>
                               <input type='submit' value='Speichern' class='btn btn-primary' />
                               <a href='index.php' class='btn btn-danger'>Zurück zu den Reservierungen</a>
                           </td>
                       </tr>
                   </table>
               </form>

    </div> <!-- end .container -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>
