<?php

error_reporting(0);
session_start();
date_default_timezone_set('America/Sao_Paulo');
include_once("../../conn.php");

$rank = $_SESSION["rank"];

if ($rank <> 1) {
    header("Location: ./");
    exit;
} else {

    $id = mysqli_real_escape_string($conn, $_GET["id"]);

    if (is_numeric($id)) {
        $result = mysqli_query($conn, "DELETE FROM usuarios WHERE id = '$id'");

        if ($result == true) {
            $_SESSION["success"] = true;
            header("Location: ../usuarios");
            exit;
        } else {
            $_SESSION["erro"] = mysqli_error($result);
            header("Location: ../usuarios");
            exit;
        }
    } else {
        $_SESSION["erro"] = "ID INVALIDO!";
        header("Location: ../usuarios");
        exit;
    }



}

?>