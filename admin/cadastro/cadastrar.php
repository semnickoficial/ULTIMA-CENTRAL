<?php
session_start();
error_reporting(0);
include_once("../../conn.php");
date_default_timezone_set('America/Sao_Paulo');

$rank = $_SESSION["rank"];
$admin = $_SESSION["usuario"];

if (!isset($rank) || ($rank != 1 && $rank != 2)) {
    header("Location: ../../?sair=true");
    exit();
} else {
    $usuario = mysqli_real_escape_string($conn, $_POST["usuario"]);
    $senha = mysqli_real_escape_string($conn, $_POST["senha"]);
    $validade = mysqli_real_escape_string($conn, $_POST["validade"]);

    // Define rank based on user's permission
    if ($rank == 1 && isset($_POST["rank"])) {
        $ranker = mysqli_real_escape_string($conn, $_POST["rank"]);
    } else {
        $ranker = 3; // Default to regular user
    }

    // Validate required fields
    if (empty($usuario) || empty($senha)) {
        $_SESSION["erro"] = "Preencha todos os campos obrigatórios!";
        header("Location: ../cadastro");
        exit;
    }

    // Validate validade
    if (empty($validade)) {
        $_SESSION["erro"] = "Escolha uma validade!";
        header("Location: ../cadastro");
        exit;
    }

    // Formata a data para o formato correto do MySQL
    $validade_formatada = date('Y-m-d H:i:s', strtotime($validade));

    // Check if username already exists
    $consulta = mysqli_query($conn, "SELECT usuario FROM usuarios WHERE usuario = '$usuario'");

    if (mysqli_num_rows($consulta) > 0) {
        $_SESSION["erro"] = "Usuário já cadastrado!";
        header("Location: ../cadastro");
        exit;
    }

    // Insert new user
    $result = mysqli_query($conn, "INSERT INTO `usuarios` 
        (`usuario`, `senha`, `data_cadastro`, `criador`, `rank`, `lives`, `validade`) 
        VALUES 
        ('$usuario', md5('$senha'), NOW(), '$admin', '$ranker', '0', '$validade_formatada')");

    if ($result) {
        $_SESSION["success"] = true;
        header("Location: ../cadastro");
        exit;
    } else {
        $_SESSION["erro"] = "Erro ao cadastrar: " . mysqli_error($conn);
        header("Location: ../cadastro");
        exit;
    }
}

?>