<?php
$mysqli = @new mysqli('localhost', 'root', '', 'giftbox');

if ($mysqli->connect_errno) {
    die('Connect Error: ' . $mysqli->connect_errno);
}

define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/tutro/');
require_once BASEURL.'/helpers/helpers.php';



