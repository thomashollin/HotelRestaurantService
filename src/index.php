<!DOCTYPE HTML>
<html>
<head>
    <title>Hotel Restaurant Reservierungen</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

    <!-- custom css -->
    <style>
    .m-r-1em{ margin-right:1em; }
    .m-b-1em{ margin-bottom:1em; }
    .m-l-1em{ margin-left:1em; }
    .mt0{ margin-top:0; }
    </style>

</head>
<body>
    <div class="container">

        <div class="page-header">
            <h1>Aktuelle Reservierungen</h1>
        </div>
        <?php
        // include database connection
        include 'config/database.php';

        // delete message prompt will be here
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        // if it was redirected from delete.php
        if($action=='deleted'){
            echo "<div class='alert alert-success'>Reservierung wurde gelöscht.</div>";
        }

        // select all data
        $query = "SELECT res_id, res_zimmer, res_name, res_datum, res_uhrzeit, res_anzahl  FROM reservierungen ORDER BY res_id DESC";
        $stmt = $con->prepare($query);
        $stmt->execute();

        // this is how to get number of rows returned
        $num = $stmt->rowCount();

        // link to create record form
        echo "<a href='create.php' class='btn btn-primary m-b-1em'>Neue Reservierung erstellen</a>";

        //check if more than 0 record found
        if($num>0){
          echo "<table class='table table-hover table-responsive table-bordered'>";

              echo "<tr>
                  <th>ID</th>
                  <th>Zimmernummer</th>
                  <th>Name</th>
                  <th>Datum</th>
                  <th>Uhrzeit</th>
                  <th>Personen</th>
                  <th>Funktionen</th>
              </tr>";

              // retrieve the table contents
              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                  // extract row
                  extract($row);
                  // creating new table row per record
                  echo "<tr>
                      <td>{$res_id}</td>
                      <td>{$res_zimmer}</td>
                      <td>{$res_name}</td>
                      <td>{$res_datum}</td>
                      <td>{$res_uhrzeit}</td>
                      <td>{$res_anzahl}</td>
                      <td>";
                          // read one record
                          echo "<a href='read_one.php?res_id={$res_id}' class='btn btn-info m-r-1em'>Ansehen</a>";

                          // we will use this links on next part of this post
                          echo "<a href='update.php?res_id={$res_id}' class='btn btn-primary m-r-1em'>Bearbeiten</a>";

                          // we will use this links on next part of this post
                          echo "<a href='delete.php?res_id={$res_id}'  class='btn btn-danger'>Löschen</a>";
                      echo "</td>";
                  echo "</tr>";
              }

          // end table
          echo "</table>";

        }

        // if no records found
        else{
            echo "<div class='alert alert-danger'>Noch keine Einträge vorhanden.</div>";
        }
        ?>

    </div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>