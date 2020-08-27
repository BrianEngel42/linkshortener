<?php

include "LinkShortener.php";

if(isset($_GET["url"])){

    $url = $_GET["url"];
    echo shortenLink($url);

}