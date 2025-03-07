<?php
session_start();
error_reporting(0);
include_once("../conn.php");
date_default_timezone_set('America/Sao_Paulo');

// Verifica se o usuário está logado
if (!isset($_SESSION["id"])) {
    $json = ["success" => false, "message" => "Sessão expirada! Faça login novamente."];
    die(json_encode($json));
}

$ID = $_SESSION["id"];
$RESULTADO = mysqli_query($conn, "SELECT validade FROM usuarios WHERE id = '$ID'");

if (!$RESULTADO) {
    $json = ["success" => false, "message" => "Erro ao verificar validade!"];
    die(json_encode($json));
}

$dados = mysqli_fetch_assoc($RESULTADO);
$VALIDADE = $dados['validade'];
$DATA_DE_HOJE = date("Y-m-d H:i:s");

// Converte as datas para timestamp para comparação precisa
$timestamp_dt_atual = strtotime($DATA_DE_HOJE);
$timestamp_dt_expira = strtotime($VALIDADE);

if ($timestamp_dt_expira <= $timestamp_dt_atual) {
    // Se a validade expirou
    session_destroy(); // Destroi a sessão
    $json = ["success" => false, "message" => "🗣️ SEU PLANO ACABOU!\nCONTATE O SUPORTE PARA RENOVAR O SEU PLANO!"];
    die(json_encode($json));
} else {
    // Ainda válido
    $json = ["success" => true, "message" => "Acesso Válido!", "validade" => $VALIDADE];
    die(json_encode($json));
}

?>