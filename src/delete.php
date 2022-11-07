<?php
// include database connection
include 'config/database.php';

try {

    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $res_id=isset($_GET['res_id']) ? $_GET['res_id'] : die('ERROR: Kein Eintrag gefunden.');

    // delete query
    $query = "DELETE FROM reservierungen WHERE res_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $res_id);

    if($stmt->execute()){
        // redirect to read records page and
        // tell the user record was deleted
        header('Location: index.php?action=deleted');
    }else{
        die('Reservierung konnte nicht gelöscht werden.');
    }
}

// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>