<?php
session_start();
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    include_once("conn.php");
    date_default_timezone_set('America/Sao_Paulo');

    $usuario = isset($_POST["usuario"]) ? mysqli_real_escape_string($conn, $_POST["usuario"]) : '';
    $senha = isset($_POST["senha"]) ? mysqli_real_escape_string($conn, $_POST["senha"]) : '';

    if (empty($usuario) || empty($senha)) {
        $_SESSION["erro"] = "Preencha todos os campos!";
        echo json_encode(array("success" => false, "message" => "Preencha todos os campos!"));
        exit();
    }

    $result = mysqli_query($conn, "SELECT * FROM usuarios WHERE usuario = '$usuario' AND senha = md5('$senha')");

    if (!$result) {
        throw new Exception("Erro na consulta ao banco de dados");
    }

    if (mysqli_num_rows($result) > 0) {
        $dados = mysqli_fetch_assoc($result);
        
        // Verifica se existe data de validade
        if (!empty($dados["validade"])) {
            $validade = $dados["validade"];
            $datadeHoje = date("Y-m-d H:i:s");
            $timestamp_dt_atual = strtotime($datadeHoje);
            $timestamp_dt_expira = strtotime($validade);

            if ($timestamp_dt_expira > $timestamp_dt_atual) {
                // Usuário com validade ativa
                $_SESSION["success"] = true;
                $_SESSION["id"] = $dados["id"];
                $_SESSION["rank"] = intval($dados["rank"]); // Garante que é um inteiro
                $_SESSION["usuario"] = $dados["usuario"];
                $_SESSION["validade"] = $dados["validade"];
                $_SESSION["lives"] = intval($dados["lives"]); // Mantém lives para armazenamento
                
                $auth_token = md5(uniqid());
                $id = $dados["id"];
                
                $update_result = mysqli_query($conn, "UPDATE usuarios SET auth_token = '$auth_token' WHERE id = '$id'");
                if (!$update_result) {
                    throw new Exception("Erro ao atualizar token");
                }
                
                $_SESSION["auth_token"] = $auth_token;
                echo json_encode(array(
                    "success" => true,
                    "rank" => intval($dados["rank"]),
                    "usuario" => $dados["usuario"]
                ));
                exit();
            } else {
                $_SESSION["erro"] = "Sua Validade Expirou!";
                echo json_encode(array("success" => false, "message" => "Sua Validade Expirou!"));
                exit();
            }
        } else {
            $_SESSION["erro"] = "Usuário sem data de validade definida!";
            echo json_encode(array("success" => false, "message" => "Usuário sem data de validade definida!"));
            exit();
        }
    } else {
        $_SESSION["erro"] = "Usuario ou Senha Inválidos!";
        echo json_encode(array("success" => false, "message" => "Usuario ou Senha Inválidos!"));
        exit();
    }
} catch (Exception $e) {
    error_log("Erro no login: " . $e->getMessage());
    echo json_encode(array("success" => false, "message" => "Erro interno do servidor"));
    exit();
}
?>
