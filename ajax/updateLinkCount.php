<?php
include("../config.php"); //goes back one directory from 'ajax' and includes the DB connection file.

if(isset($_POST["linkId"]))
{
    $query = $con->prepare("UPDATE sites SET clicks = clicks + 1 WHERE id=:id");//id=:id placeholder
    $query->bindParam(":id", $_POST["linkId"]);//this updates the value of clicks

    $query->execute();
}
else
{
    echo "No link passed to the page.";//for debugging any error.
}
?>