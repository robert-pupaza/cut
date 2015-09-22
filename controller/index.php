<?php
require_once '../bootstrap.php';
require_once '../model/index.php';

if(isset($_GET['url']) && $_GET['url']){

    $short = getLink($_GET['url']);

    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$short['link']);
} else {

    header("Location: insert.php");
}



?>