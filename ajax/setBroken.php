<?php
include("../config.php");//includes config.php by going to prev directory.

if(isset($_POST["src"]))  
{
    $query = $con->prepare("UPDATE images SET broken = 1 WHERE imageUrl=:src");//imageUrl parameter
    $query->bindParam(":src", $_POST["src"]);//binding param

    $query->execute();
}

else
{
    echo "No link passed to the page.";//for debugging any error.
}

?>