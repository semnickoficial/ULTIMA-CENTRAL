<?php

error_reporting(0);
session_start();

include_once("../../conn.php");
date_default_timezone_set('America/Sao_Paulo');

$rank = $_SESSION["rank"];
$admin = $_SESSION["usuario"];

if ($rank <> 1) {
    header("Location: /");
    exit;
} else {
    $usuario = mysqli_real_escape_string($conn, $_POST["usuario"]);
    $senha = mysqli_real_escape_string($conn, $_POST["senha"]);
    $ranke = mysqli_real_escape_string($conn, $_POST["rank"]);
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $validade = mysqli_real_escape_string($conn, $_POST["validade"]);

    $getUser = mysqli_query($conn, "SELECT * FROM usuarios WHERE id = '$id'");
    $result = mysqli_fetch_assoc($getUser);

    if (empty($usuario)) {
        $usuario = $result["usuario"];
    }

    $verificar = mysqli_query($conn, "SELECT id FROM usuarios WHERE usuario = '$usuario' AND id <> '$id'");

    if (mysqli_num_rows($verificar) > 0) {
        $_SESSION["erro"] = "Usuário já cadastrado!";
        header("Location: ./?id=$id");
        exit;
    }

    if (empty($senha)) {
        $senha = $result["senha"];
    } else {
        $senha = md5($senha);
    }

    if (empty($ranke)) {
        $ranke = $result["rank"];
    }

    if (empty($validade)) {
        $validade = $result["validade"];
    } else {
        // Formata a data para o formato correto do MySQL
        $validade = date('Y-m-d H:i:s', strtotime($validade));
    }

    $update = mysqli_query($conn, "UPDATE usuarios SET usuario = '$usuario', senha = '$senha', rank = '$ranke', validade = '$validade' WHERE id = '$id'");

    if ($update == true) {
        $_SESSION["success"] = true;
        header("Location: ./?id=$id");
        exit;
    } else {
        $_SESSION["erro"] = mysqli_error($conn);
        header("Location: ./?id=$id");
        exit;
    }
}

?>