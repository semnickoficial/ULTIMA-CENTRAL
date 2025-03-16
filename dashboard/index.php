<?php
session_start();
error_reporting(0);
include_once("../conn.php");
date_default_timezone_set('America/Sao_Paulo');

$id = $_SESSION["id"];

// Verifica se está logado
if (!isset($id) || empty($id)) {
    header("Location: ../?sair=true");
    exit;
}

// Verifica o auth_token
$query = mysqli_query($conn, "SELECT auth_token, validade FROM usuarios WHERE id = '$id'");
$dados = mysqli_fetch_assoc($query);

// Verifica se o token é válido
if ((string) $_SESSION["auth_token"] !== $dados['auth_token']) {
    session_destroy();
    header("Location: ../?sair=true");
    exit;
}

// Verifica se a validade expirou
$validade = $dados['validade'];
$agora = date("Y-m-d H:i:s");
if (strtotime($validade) <= strtotime($agora)) {
    session_destroy();
    header("Location: ../?sair=true&msg=validade_expirada");
    exit;
}

// Busca informações do usuário para exibição
$user_query = mysqli_query($conn, "SELECT usuario, validade FROM usuarios WHERE id = '$id'");
$user_data = mysqli_fetch_assoc($user_query);
$nome_usuario = $user_data['usuario'];
$validade_usuario = $user_data['validade'];
?>
<!DOCTYPE html>
<html class="loading" lang="pt-BR" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Checker Dashboard">
    <meta name="author" content="Niklausec">
    <title>AUTHCENTERGG</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #000000;
            min-height: 100vh;
            color: white;
            position: relative;
            overflow-x: hidden;
        }

        .main-container {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
            padding: 10px;
        }

        .title-section {
            margin: 15px 0;
            text-align: center;
        }

        .title-section h5 {
            font-size: 24px;
            font-weight: 600;
            color: #fff;
            margin: 0;
        }

        .input-section {
            background: #111111;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
        }

        #lista {
            background: #0a0a0a;
            border: 1px solid #222;
            border-radius: 4px;
            color: white;
            font-size: 14px;
            transition: all 0.3s ease;
            width: 100%;
            resize: none;
        }

        .counters {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 15px 0;
            flex-wrap: wrap;
        }

        .counter-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 15px 0;
        }

        .action-btn {
            min-width: 120px;
            padding: 8px 15px;
            border-radius: 4px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-align: center;
            font-size: 14px;
        }

        #status_ccs {
            background: #111111;
            padding: 8px 15px;
            border-radius: 4px;
            font-size: 13px;
            margin: 10px auto;
            display: inline-block;
            border: 1px solid #222;
        }

        .results-section {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 15px;
        }

        .result-card {
            background: #111111;
            border-radius: 4px;
            padding: 15px 20px;
            position: relative;
            min-height: 40px;
            border: 1px solid #222;
        }

        .result-card .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 8px;
            margin-bottom: 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .result-card .card-header h6 {
            font-size: 15px;
            font-weight: 500;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 5px;
            color: #fff;
        }

        #bode, #bode2 {
            display: none;
            padding: 10px 0;
            font-family: monospace;
            font-size: 14px;
            line-height: 1.6;
            color: #fff;
            word-break: break-all;
            white-space: pre-wrap;
        }

        .btn-control {
            background: transparent;
            border: none;
            padding: 4px 6px;
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease;
        }

        .btn-control:hover {
            color: #fff;
        }

        @media screen and (max-width: 768px) {
            .main-container {
                padding: 10px;
            }

            .counters {
                gap: 10px;
            }

            .action-buttons {
                flex-wrap: wrap;
            }

            .action-btn {
                width: calc(50% - 5px);
            }
        }

        .copyright {
            position: fixed;
            bottom: 10px;
            right: 15px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.3);
            font-weight: 500;
            z-index: 1000;
            pointer-events: none;
        }

        .aprovadas, .reprovadas {
            display: block;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="copyright">copyright: @semnickoficial</div>
    <div class="main-container">
        <!-- Título -->
        <div class="title-section">
            <h5>
                <i class="fa fa-credit-card"></i> Multi checkers - Authcentergg <i class="fa fa-credit-card"></i>
            </h5>
        </div>
        <!-- Informações do usuário em um novo estilo -->
        <div style="background: #111111; border-radius: 6px; margin-bottom: 20px;">
            <div style="padding: 10px 15px; border-bottom: 1px solid #222;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: #fff;">Usuário:</span>
                    <span class="badge badge-primary"><?php echo htmlspecialchars($nome_usuario); ?></span>
                </div>
            </div>
            <div style="padding: 10px 15px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: #fff;">Validade:</span>
                    <span class="badge badge-dark">
                        <?php 
                            $data = new DateTime($validade_usuario);
                            echo $data->format('H:i:s d/m/Y'); 
                        ?>
                    </span>
                </div>
            </div>
        </div>
        <!-- Seção de Input -->
        <div class="input-section">
            <textarea id="lista" placeholder="XXXXXXXXXXXXXXXX|XX|XXXX|XXX" class="form-control" rows="5"></textarea>
            <div class="mt-3">
                <select id="apiSelector" class="form-control" style="background: #0a0a0a; color: white; border: 1px solid #222;">
                    <option value="">Selecione uma API</option>
                    <option value="pagarme">ALLBINS VISA/MASTER</option>
                    <option value="full">FULL DEBITANDO R$ 9,75</option>
                </select>
            </div>
        </div>

        <!-- Estatísticas -->
        <div class="counters">
            <div class="counter-item">
                <i class="la la-check" style="color: #4CAF50;"></i>
                <span>Aprovados: <span id="cLive">0</span></span>
            </div>
            <div class="counter-item">
                <i class="la la-close" style="color: #f44336;"></i>
                <span>Reprovados: <span id="cDie">0</span></span>
            </div>
            <div class="counter-item">
                <i class="la la-clock-o" style="color: #FF9800;"></i>
                <span>Testados: <span id="total">0</span></span>
            </div>
            <div class="counter-item">
                <i class="la la-cloud-upload" style="color: #2196F3;"></i>
                <span>Carregados: <span id="carregadas">0</span></span>
            </div>
        </div>

        <!-- Botões de Ação -->
        <div class="action-buttons">
            <button type="button" class="action-btn btn" id="testar" onclick="enviar()" 
                    style="background: rgba(76, 175, 80, 0.2); border: 1px solid #4CAF50; color: white;">
                <i class="fas fa-play"></i> INICIAR
            </button>
            <button type="button" class="action-btn btn" id="parar" disabled 
                    style="background: rgba(244, 67, 54, 0.2); border: 1px solid #f44336; color: white;">
                <i class="fas fa-stop"></i> PARAR
            </button>
            <a href="../../" class="action-btn btn" 
               style="background: rgba(255, 193, 7, 0.2); border: 1px solid #FFC107; color: white;">
                <i class="fas fa-arrow-left"></i> VOLTAR
            </a>
        </div>

        <!-- Status -->
        <div class="text-center">
            <div id="status_ccs">Aguardando início...</div>
        </div>

        <!-- Resultados -->
        <div class="results-section">
            <!-- Aprovados -->
            <div class="result-card">
                <div class="card-header">
                    <h6>
                        Aprovados - <span id="cLive2" style="color: #4CAF50;">0</span>
                    </h6>
                    <div>
                        <button id="mostra" class="btn-control">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-control btn-copy">
                            <i class="fa fa-copy"></i>
                        </button>
                    </div>
                </div>
                <div id="bode"><span class="aprovadas"></span></div>
            </div>

            <!-- Reprovados -->
            <div class="result-card">
                <div class="card-header">
                    <h6>
                        Reprovados - <span id="cDie2" style="color: #f44336;">0</span>
                    </h6>
                    <button id="mostra2" class="btn-control">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div id="bode2"><span class="reprovadas"></span></div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="assets/js/protection.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $("#bode").hide();
            $("#esconde").show();
            $('#mostra').click(function() {
                $("#bode").slideToggle();
            });
        });

        $(document).ready(function() {
            $("#bode2").hide();
            $("#esconde2").show();
            $('#mostra2').click(function() {
                $("#bode2").slideToggle();
            });
        });

        $('.btn-copy').click(function() {
            Swal.fire({
                title: 'Aprovadas Copiadas!',
                icon: 'success',
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                timer: 3000
            });

            var cards_aprovadas = document.querySelector('.aprovadas').innerText;
            var textarea = document.createElement("textarea");
            textarea.value = cards_aprovadas;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
        });

        var audioLive = new Audio('live.mp3');

        function enviar() {
            var listado = document.getElementById("lista").value;
            var selectedApi = $('#apiSelector').val();

            // Verifica se uma API foi selecionada
            if (!selectedApi) {
                Swal.fire({
                    title: '<span style="color:#212529;">Escolha uma API no <b class="text-primary">SELECIONE API</b></span>',
                    icon: 'warning',
                    showConfirmButton: false,
                    background: '#ffffff',
                    toast: true,
                    position: 'top',
                    timer: 3000
                });
                return false;
            }

            // Verifica se tem lista
            if (!listado) {
                Swal.fire({
                    title: 'Cadê suas lista ?? adicione uma lista!!',
                    icon: 'error',
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end',
                    timer: 3000
                });
                return false;
            }

            var linha = $("#lista").val();
            var linhaenviar = linha.split("\n");
            var total = linhaenviar.length;

            if (total > 100) {
                Swal.fire({
                    title: 'Limite de Linhas Excedido!',
                    icon: 'warning',
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end',
                    timer: 3000
                });
                return false;
            }

            var ap = 0;
            var rp = 0;
            $('#testar').attr('disabled', 'disabled');
            $('#parar').attr('disabled', null);
            linhaenviar.forEach(function(value, index) {
                setTimeout(
                    function() {
                        var ajaxCall = $.ajax({
                            url: 'semnickapis/' + selectedApi + '.php?lista=' + value,
                            type: 'GET',
                            async: true,
                            success: function(resultado) {
                                if (resultado.match("LIVE") || resultado.match("✔️")) {
                                    removelinha();
                                    ap++;
                                    aprovadas(resultado + "");
                                    audioLive.play();
                                    $('#status_ccs').html('Cartão Aprovado').css('color', 'green');
                                } else {
                                    removelinha();
                                    rp++;
                                    reprovadas(resultado + "");
                                    $('#status_ccs').html('Cartão Recusado').css('color', 'red');
                                }
                                $('#carregadas').html(total);
                                var fila = parseInt(ap) + parseInt(rp);
                                $('#cLive').html(ap);
                                $('#cDie').html(rp);
                                $('#total').html(fila);
                                $('#cLive2').html(ap);
                                $('#cDie2').html(rp);

                                if (fila == total) {
                                    $('#testar').attr('disabled', null);
                                    $('#parar').attr('disabled', 'disabled');
                                    $('#lista').attr('disabled', null);
                                    document.getElementById("status_ccs").innerHTML = "FINALIZADO";
                                    setTimeout(function() {
                                        document.getElementById("status_ccs").innerHTML = "AGUARDANDO INICIO...";
                                    }, 2000);
                                }
                            }
                        });

                        $('#parar').click(function() {
                            ajaxCall.abort();
                            $('#testar').attr('disabled', null);
                            $('#parar').attr('disabled', 'disabled');
                            $('#lista').attr('disabled', null);
                            $('#status_ccs').html('PARADO').css('color', 'yellow');
                        });
                    }, 20 * index);
            });
        }

        function aprovadas(str) {
            $(".aprovadas").prepend(str + "<br>");
        }

        function reprovadas(str) {
            $(".reprovadas").prepend(str + "<br>");
        }

        function removelinha() {
            var lines = $("#lista").val().split('\n');
            lines.splice(0, 1);
            $("#lista").val(lines.join("\n"));
        }
    </script>

<script>
        // Função para redirecionar com mensagem de erro
        function redirectWithError(message) {
            Swal.fire({
                title: 'Sessão Encerrada',
                text: message,
                icon: 'warning',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                window.location.href = '../?sair=true';
            });
        }

        // Verifica a validade a cada 30 segundos
        setInterval(function() {
            $.ajax({
                url: 'verificar_diaria.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (!response.success) {
                        redirectWithError(response.message || 'Sua sessão expirou!');
                    }
                },
                error: function() {
                    redirectWithError('Erro ao verificar validade!');
                }
            });
        }, 30000);

        // Verifica o auth_token a cada 1 minuto
        setInterval(function() {
            $.ajax({
                url: 'apiblock.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 1) {
                        redirectWithError('Sessão invalidada!');
                    }
                },
                error: function() {
                    redirectWithError('Erro ao verificar autenticação!');
                }
            });
        }, 60000);
    </script>

</body>
</html>