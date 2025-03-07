<?php
session_start();
error_reporting(0);
date_default_timezone_set('America/Sao_Paulo');
include_once("../../conn.php");
$rank = $_SESSION["rank"];

if (!isset($rank) or $rank <> 1 and $rank <> 2) {
header("Location: ../../?sair=true");
exit();
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="../../assets/images/favicon.ico">
<title>ADMIN - CADASTRO</title>
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
<a hidden class="dropdown-item" href="../cadastro"><i class="fa fa-plus text-muted mr-2"></i> CADASTRAR USUARIO</a>
<a class="dropdown-item" href="../renovacao"><i class="fa fa-refresh text-muted mr-2"></i> RENOVAR ACESSO</a>
<?php if($rank == 1){ ?>
<a class="dropdown-item" href="../usuarios"><i class="fa fa-edit text-muted mr-2"></i> TABELA DE USUARIOS</a>
<?php } ?>
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
<!--<img style="width: 30px;" src="../../assets/images/logo-dark.png" alt=""> -->
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
<a href="../renovacao/">
<i data-feather="refresh-ccw"></i>
<span>RENOVAR ACESSO</span>
</a>
</li>
<?php if ($rank == 1){ ?>
<li>
<a href="../usuarios/">
<i data-feather="users"></i>
<span>TABELA DE USUARIOS</span>
</a>
</li>
<?php }?>
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
<h4 class="text-center mb-3"><i class="fa fa-user-plus"></i> CADASTRAR USUARIO</h4>
<?php if (isset($_SESSION["erro"])) { ?>
<div class="alert alert-danger text-center mb-3 mt-3">
<b>Erro!</b> <?php echo $_SESSION["erro"]; ?>
</div>
<?php
unset($_SESSION["erro"]);
} else if (isset($_SESSION["success"])) {  ?>
<div class="alert alert-success text-center mb-3 mt-3">
<b>Sucesso!</b> Usuario Cadastrado!
</div>
<?php unset($_SESSION["success"]); } ?>
<form action="cadastrar.php" method="post">
<input name="usuario" type="text" class="form-control mb-3 rounded p-2 text-white" placeholder="USUARIO" required="">
<input name="senha" type="password" class="form-control mb-3 rounded p-2 text-white" placeholder="SENHA" required="">

<div class="mb-3">
<label class="form-label">VALIDADE</label>
<input type="datetime-local" class="form-control mb-3 rounded p-2 text-white" name="validade" required>
</div>

<?php if($rank == 1){ ?>
<select name="rank" class="form-control rounded mb-3 p-2 text-white" required>
<option value="" selected="" disabled="">RANK</option>
<option value="1">ADMINISTRADOR</option>
<option value="3">USUARIO</option>
</select>
<?php } ?>

<button type="submit" class="btn btn-info btn-block rounded">CADASTRAR</button>
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
<script>
$('#diaria').change(function(){
var diaria = document.getElementById("diaria").value;
var validade = document.getElementById("validade");
var saldo_div = document.getElementById("saldo_div");
if (diaria == 1){
validade.style.display = "block";
saldo_div.style.display = "none";
}else{
validade.style.display = "none";
saldo_div.style.display = "block";
}});
</script>
</body>
</html>