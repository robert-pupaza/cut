<?php
require_once 'bootstrap.php';

function getLink($short){
    global $db;
    $stmt = "select link from url where short= :short";
    $query = $db->prepare($stmt);
    $query->bindParam(":short", $short);
    $query->execute();

    $result = $query->fetchAll();
    if(isset($result[0]))
        return $result[0];
    return null;
}
?>