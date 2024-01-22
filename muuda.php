<?php
require('conf2.php');
require('funktsioonid.php');

if (isset($_POST["inimene_uuendamine"])) {
    $muuda_id = $_POST["muuda_id"];
    $eesnimi = $_POST["eesnimi"];
    $perenimi = $_POST["perenimi"];
    $maakond_id = $_POST["maakond_id"];

    // Validate input if needed

    // Perform the update
    muudaInimene($muuda_id, $eesnimi, $perenimi, $maakond_id);

    // Redirect back to the index.php page after updating
    header("Location: index.php");
    exit();
} else {
    // Handle invalid access to muuda.php
    echo "Invalid access to this page.";
}
?>
