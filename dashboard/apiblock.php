<?php
session_start();
error_reporting(0);
include_once("../conn.php");

$id = $_SESSION["id"];

if (!isset($id) || empty($id)) {
	echo '<script type="text/javascript">window.location.reload()</script>';
    header("Location: ../?sair=true");
    exit;
}

$query =mysqli_query($conn , "SELECT `auth_token` FROM `usuarios` WHERE `id` = '$id'");

$re = mysqli_fetch_assoc($query);

if ((string) $_SESSION["auth_token"] != $re['auth_token']){

	session_destroy();
	die(json_encode(array("status" => 1)));
}else{
	die(json_encode(array("status" => 0)));
}