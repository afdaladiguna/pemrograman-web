<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "nilai_fikom";

$koneksi    = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Not connected to database.");
}
?>
