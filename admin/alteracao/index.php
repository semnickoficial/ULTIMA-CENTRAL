<?php

error_reporting(0);
session_start();
date_default_timezone_set('America/Sao_Paulo');

include_once("../../conn.php");

$rank = $_SESSION["usuario"];


if(isset($_GET["id"]) AND is_numeric($_GET["id"])){
    $id = $_GET["id"];
    
    $getUser = mysqli_query($conn, "SELECT * FROM usuarios WHERE id = '$id'");
    
    if(mysqli_num_rows($getUser) < 1){
        $_SESSION["erro"] = "Usuário não Encontrado!";
        header("Location: ../usuarios");
        exit;
    }
    
    $result = mysqli_fetch_assoc($getUser);
    
}else{
    $_SESSION["erro"] = "ID Inválido!";
    header("Location: ../usuarios");
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../../assets/images/favicon.ico">
    <title>ADMIN - ALTERAR ACESSO</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/vendors_css.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/skin_color.css">
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/sweetalert2.js"></script>
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
                        <li class="btn-group nav-item d-none d-xl-inline-block">
                            <a href="#" class="waves-effect waves-light nav-link rounded svg-bt-icon" title="">
                                <i class="ti-check-box"></i>
                            </a>
                        </li>
                        <li class="btn-group nav-item d-none d-xl-inline-block">
                            <a href="calendar.html" class="waves-effect waves-light nav-link rounded svg-bt-icon" title="">
                                <i class="ti-calendar"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="navbar-custom-menu r-side">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu mr-3">
                            <a href="#" class="waves-effect waves-light rounded dropdown-toggle p-0" data-toggle="dropdown" title="User">
                                <img src="../../assets/images/avatar.jpg" alt="">
                            </a>
                            <ul class="dropdown-menu border border-dark" style="min-width: 17rem; border-radius: 0.6rem;">
                                <li class="user-body">
                                    <a class="dropdown-item" href="../dados.php"><i class="fa fa-user text-muted mr-2"></i>MEU PERFIL</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="../cadastro"><i class="fa fa-plus text-muted mr-2"></i> CADASTRAR USUARIO</a>
                                    <a class="dropdown-item" href="../renovacao"><i class="fa fa-refresh text-muted mr-2"></i> RENOVAR ACESSO</a>
                                    <a class="dropdown-item" href="../usuarios"><i class="fa fa-edit text-muted mr-2"></i> TABELA DE USUARIOS</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="../../?sair=true"><i class="fa fa-sign-out text-muted mr-2"></i> SAIR</a>
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
                        <a href="../">
                            <div class="d-flex align-items-center justify-content-center">
                                <h3><b class="text-white">𝐑𝐎𝐓𝐀𝟔𝟔 𝐂𝐇𝐄𝐂𝐊𝐄𝐑𝐒</b></h3>
                            </div>
                        </a>
                    </div>
                </div>
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="active">
                        <a href="../">
                            <i data-feather="home"></i>
                            <span>DASHBOARD</span>
                        </a>
                    </li>
                    <li>
                        <a href="../cadastro/">
                            <i data-feather="user-plus"></i>
                            <span>CADASTRAR USUARIO</span>
                        </a>
                    </li>
                    <li>
                        <a href="../renovacao/">
                            <i data-feather="refresh-ccw"></i>
                            <span>RENOVAR ACESSO</span>
                        </a>
                    </li>
                    <li>
                        <a href="../usuarios/">
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
                    <div class="row">
                        <div class="col-md-8" style="margin: auto;">
                            <div class="box">
                                <div class="box-body">
                                    <h4 class="text-center mb-3"><i class="fa fa-edit"></i> ALTERAR ACESSO</h4>
                                    <?php if (isset($_SESSION["erro"])) { ?>
                                        <div class="alert alert-danger text-center mb-3 mt-3">
                                            <b>Erro!</b> <?php echo $_SESSION["erro"]; ?>
                                        </div>
                                    <?php
                                        unset($_SESSION["erro"]);
                                    } else if (isset($_SESSION["success"])) {  ?>
                                        <div class="alert alert-success text-center mb-3 mt-3">
                                            <b>Sucesso!</b> Acesso Alterado!
                                        </div>
                                    <?php unset($_SESSION["success"]); } ?>
                                    <form action="alterar.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo $result["id"]; ?>">
                                        <input name="usuario" value="<?php echo $result["usuario"]; ?>" type="text" class="form-control mb-3 rounded p-2 text-white" placeholder="USUARIO">
                                        <input name="senha" type="password" class="form-control mb-3 rounded p-2 text-white" placeholder="SENHA">
                                        
                                        <div class="mb-3">
                                            <label class="form-label">VALIDADE</label>
                                            <input name="validade" value="<?php echo $result["validade"]; ?>" type="datetime-local" class="form-control rounded p-2 text-white">
                                        </div>

                                        <select name="rank" class="form-control rounded mb-3 p-2 text-white">
                                            <option value="" selected="" disabled="">RANK</option>
                                            <option value="1" <?php if($result["rank"] == 1) echo "selected"; ?>>ADMINISTRADOR</option>
                                            <option value="3" <?php if($result["rank"] == 3) echo "selected"; ?>>USUARIO</option>
                                        </select>
                                        <button type="submit" class="btn btn-info btn-block rounded">ALTERAR</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <footer style="z-index: 1;" class="main-footer text-center">
            &copy; 2024 <a href="#">𝐑𝐎𝐓𝐀𝟔𝟔 𝐂𝐇𝐄𝐂𝐊𝐄𝐑𝐒</a>. All Rights Reserved.
        </footer>
    </div>
    <script src="../../assets/js/vendors.min.js"></script>
    <script src="../../assets/vendors/icons/feather-icons/feather.min.js"></script>
    <script src="../../assets/js/template.js"></script>
    <script src="../../assets/js/pages/dashboard.js"></script>
</body>
</html>