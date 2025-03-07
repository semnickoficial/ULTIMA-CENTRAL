<?php

error_reporting(0);
session_start();

include_once("../../conn.php");
date_default_timezone_set('America/Sao_Paulo');

$rank = $_SESSION["rank"];
$admin = $_SESSION["usuario"];

if ($rank <> 1 AND $rank <> 2) {
    header("Location: ./");
    exit;
} else {
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $validade = mysqli_real_escape_string($conn, $_POST['validade']);

    if (empty($usuario) || empty($validade)) {
        $_SESSION["erro"] = "Preencha Todos os Campos";
        header("Location: ../renovacao");
        exit;
    }

    $result = mysqli_query($conn, "SELECT * FROM usuarios WHERE usuario = '$usuario'");

    if (mysqli_num_rows($result) < 1) {
        $_SESSION["erro"] = "Usuário não Encontrado!";
        header("Location: ../renovacao");
        exit;
    }

    $dados = mysqli_fetch_assoc($result);
    $id = $dados["id"];

    // Formata a data para o formato correto do MySQL
    $validade_formatada = date('Y-m-d H:i:s', strtotime($validade));

    $update = mysqli_query($conn, "UPDATE usuarios SET validade = '$validade_formatada', data_cadastro = NOW() WHERE id = '$id'");

    if ($update) {
        $_SESSION["success"] = true;
        header("Location: ../renovacao");
        exit;
    } else {
        $_SESSION["erro"] = "Erro ao renovar: " . mysqli_error($conn);
        header("Location: ../renovacao");
        exit;
    }
}

?>