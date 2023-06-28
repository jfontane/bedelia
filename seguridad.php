<?php
session_start();
$mi_url = $_SERVER["HTTP_HOST"];
$redirect = "https://escuela40.net/logout.php";
if ($mi_url=='127.0.0.1') {
  $redirect = "$mi_url/bedel/logout.php";
};
if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
   session_destroy();
   header("location: $redirect");
}
?>
