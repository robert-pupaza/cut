<?php

function addShortUrl()
{
    if (isset($_POST['url']) && $_POST['url']) {

        $link = $_POST['url'];

        if (isValidUrl($link)) {
            $result = insertShortUrl($link);
            $shortIsValid = $result['success'];
            while (!$shortIsValid) {
                $result = insertShortUrl($link);
                $shortIsValid = $result['success'];
            };

            echo DOMAIN_URL . $result['short'];
        } else {
            echo 'Invalid link !';
        }
    }
}

;


function isValidUrl($url)
{
    if (!filter_var($url, FILTER_VALIDATE_URL) === false)
        return true;
    return false;
}

function insertShortUrl($link)
{
    global $db;

    $short = generateRandomUrl(5);

    $stmt = 'INSERT INTO url(link, short, hash, ip, created_at, updated_at)
    VALUES(:link, :short, :hash, :ip, CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP())';
    $query = $db->prepare($stmt);
    $query->bindParam(':link', $link);
    $query->bindParam(':short', $short);
    $query->bindParam(':hash', sha1($link));
    $query->bindParam(':ip', $_SERVER['REMOTE_ADDR']);
    return array(
        "success" => $query->execute(),
        "short" => $short

    );
}

function generateRandomUrl($lenght)
{
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $lenght);
}

?>