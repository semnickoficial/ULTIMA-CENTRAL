<?php
error_reporting(0);
session_start();
include_once("../conn.php");
date_default_timezone_set('America/Sao_Paulo');

$rank = $_SESSION["rank"];

if (!isset($rank) || $rank != 1) {
    header("Location: ../?sair=true");
    exit;
}

// Estatísticas
$total_usuarios = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM usuarios"))['total'];
$total_admins = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM usuarios WHERE rank = 1"))['total'];
$total_usuarios_ativos = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM usuarios WHERE validade > NOW()"))['total'];
$total_usuarios_expirados = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM usuarios WHERE validade <= NOW()"))['total'];

// Últimos usuários cadastrados
$ultimos_usuarios = mysqli_query($conn, "SELECT * FROM usuarios ORDER BY data_cadastro DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../assets/images/favicon.ico">
    <title>PAINEL ADMINISTRATIVO</title>
    <link rel="stylesheet" href="../assets/css/vendors_css.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/skin_color.css">
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/sweetalert2.js"></script>
</head>
<body class="hold-transition dark-skin sidebar-mini theme-primary fixed">
    <div class="wrapper">
        <header class="main-header">
            <nav class="navbar navbar-fixed-top pl-1">
                <div>
                    <ul class="nav">
                        <li class="btn-group nav-item">
                            <a href="#" class="nav-link rounded svg-bt-icon" data-toggle="push-menu" role="button" style="font-size: 30px;">
                                <i class="nav-link-icon mdi mdi-menu"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="navbar-custom-menu r-side">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu mr-3">
                            <a href="#" class="waves-effect waves-light rounded dropdown-toggle p-0" data-toggle="dropdown" title="User">
                                <img src="../assets/images/avatar.jpg" alt="">
                            </a>
                            <ul class="dropdown-menu border border-dark" style="min-width: 17rem; border-radius: 0.6rem;">
                                <li class="user-body">
                                    <a class="dropdown-item" href="dados.php"><i class="fa fa-user text-muted mr-2"></i>MEU PERFIL</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="cadastro/"><i class="fa fa-user-plus text-muted mr-2"></i>CADASTRAR USUARIO</a>
                                    <a class="dropdown-item" href="renovacao/"><i class="fa fa-refresh text-muted mr-2"></i>RENOVAR ACESSO</a>
                                    <a class="dropdown-item" href="usuarios/"><i class="fa fa-users text-muted mr-2"></i>TABELA DE USUARIOS</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="../?sair=true"><i class="fa fa-sign-out text-muted mr-2"></i>SAIR</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="main-sidebar">
            <section class="sidebar">
                <div class="user-profile">
                    <div class="ulogo">
                        <a href="./">
                            <div class="d-flex align-items-center justify-content-center">
                                <h3><b class="text-white">𝐑𝐎𝐓𝐀𝟔𝟔 𝐂𝐇𝐄𝐂𝐊𝐄𝐑𝐒</b></h3>
                            </div>
                        </a>
                    </div>
                </div>
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="active">
                        <a href="./">
                            <i data-feather="home"></i>
                            <span>DASHBOARD</span>
                        </a>
                    </li>
                    <li>
                        <a href="cadastro/">
                            <i data-feather="user-plus"></i>
                            <span>CADASTRAR USUARIO</span>
                        </a>
                    </li>
                    <li>
                        <a href="renovacao/">
                            <i data-feather="refresh-ccw"></i>
                            <span>RENOVAR ACESSO</span>
                        </a>
                    </li>
                    <li>
                        <a href="usuarios/">
                            <i data-feather="users"></i>
                            <span>TABELA DE USUARIOS</span>
                        </a>
                    </li>
                </ul>
            </section>
        </aside>
        <div class="content-wrapper">
            <div class="container-full">
                <section class="content">
                    <!-- Cards de Estatísticas -->
                    <div class="row">
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="box bg-primary">
                                <div class="box-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="text-white mb-0"><?php echo $total_usuarios; ?></h3>
                                            <p class="text-white mb-0">Total de Usuários</p>
                                        </div>
                                        <div class="text-white">
                                            <i class="fa fa-users fa-3x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="box bg-success">
                                <div class="box-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="text-white mb-0"><?php echo $total_usuarios_ativos; ?></h3>
                                            <p class="text-white mb-0">Usuários Ativos</p>
                                        </div>
                                        <div class="text-white">
                                            <i class="fa fa-check-circle fa-3x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="box bg-danger">
                                <div class="box-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="text-white mb-0"><?php echo $total_usuarios_expirados; ?></h3>
                                            <p class="text-white mb-0">Usuários Expirados</p>
                                        </div>
                                        <div class="text-white">
                                            <i class="fa fa-clock-o fa-3x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="box bg-warning">
                                <div class="box-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="text-white mb-0"><?php echo $total_admins; ?></h3>
                                            <p class="text-white mb-0">Administradores</p>
                                        </div>
                                        <div class="text-white">
                                            <i class="fa fa-star fa-3x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Últimos Usuários Cadastrados -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title">Últimos Usuários Cadastrados</h4>
                                </div>
                                <div class="box-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>USUÁRIO</th>
                                                    <th>RANK</th>
                                                    <th>VALIDADE</th>
                                                    <th>DATA DE CADASTRO</th>
                                                    <th>CRIADOR</th>
                                                    <th>AÇÕES</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($usuario = mysqli_fetch_assoc($ultimos_usuarios)) { ?>
                                                    <tr>
                                                        <td><?php echo strtoupper($usuario["usuario"]); ?></td>
                                                        <td>
                                                            <?php if ($usuario["rank"] == 1) { ?>
                                                                <span class="badge badge-warning">ADMIN</span>
                                                            <?php } else { ?>
                                                                <span class="badge badge-secondary">USUARIO</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                $validade = strtotime($usuario["validade"]);
                                                                $hoje = time();
                                                                if ($validade > $hoje) {
                                                                    echo '<span class="badge badge-success">'.date('d/m/Y H:i', $validade).'</span>';
                                                                } else {
                                                                    echo '<span class="badge badge-danger">EXPIRADO</span>';
                                                                }
                                                            ?>
                                                        </td>
                                                        <td><?php echo date('d/m/Y H:i', strtotime($usuario["data_cadastro"])); ?></td>
                                                        <td><?php echo $usuario["criador"]; ?></td>
                                                        <td>
                                                            <a href="alteracao/?id=<?php echo $usuario["id"]; ?>" class="btn btn-primary btn-sm" style="font-size: 12px;">ALTERAR</a>
                                                            <a href="usuarios/deletar.php?id=<?php echo $usuario["id"]; ?>" class="btn btn-danger btn-sm" style="font-size: 12px;">DELETAR</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ações Rápidas -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title">Ações Rápidas</h4>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a href="cadastro/" class="btn btn-primary btn-block btn-lg mb-3">
                                                <i class="fa fa-user-plus"></i> Cadastrar Novo Usuário
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="renovacao/" class="btn btn-success btn-block btn-lg mb-3">
                                                <i class="fa fa-refresh"></i> Renovar Acesso
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="usuarios/" class="btn btn-info btn-block btn-lg mb-3">
                                                <i class="fa fa-users"></i> Gerenciar Usuários
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <footer class="main-footer text-center">
            &copy; 2024 <a href="#">𝐑𝐎𝐓𝐀𝟔𝟔 𝐂𝐇𝐄𝐂𝐊𝐄𝐑𝐒</a>. All Rights Reserved.
        </footer>
    </div>
    <script src="../assets/js/vendors.min.js"></script>
    <script src="../assets/vendors/icons/feather-icons/feather.min.js"></script>
    <script src="../assets/js/template.js"></script>
</body>
</html> 