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
<html class="loading">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Mini Center - AUTHCENTERGG</title>

    <link
        href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700"
        rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="theme-assets/css/vendors.css">
    <link rel="stylesheet" type="text/css" href="theme-assets/css/app-lite.css">
    <link rel="stylesheet" type="text/css" href="theme-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="theme-assets/css/core/colors/palette-gradient.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="theme-assets/js/ghost.js"></script>
    <audio  hidden id="meuAudio" controls>
            <source src="live.mp3" type="audio/mp3">
    </audio>
    <style>
    @import url("http://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700");

    * {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .modal-content {
        display: flex;
        display: -ms-flexbox;
        display: -moz-box;
        display: -webkit-flex;
        display: -webkit-box;
        position: relative;
        flex-direction: column;
        width: 100%;
        pointer-events: auto;
        border: 1px solid transparent;
        border-radius: .35rem;
        outline: 0;
        background-color: #fff;
        -webkit-background-clip: padding-box;
        background-clip: padding-box;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -webkit-flex-direction: column;
        -moz-box-orient: vertical;
        -moz-box-direction: normal;
        -ms-flex-direction: column;
        -webkit-box-shadow: 0 10px 50px 0 rgba(70, 72, 85, .8) !important;
        box-shadow: 0 10px 50px 0 rgba(70, 72, 85, .8) !important;
    }

    .modal-dialog {
        position: relative;
        width: auto;
        margin: .5rem;
        pointer-events: none;
    }

    .modal-dialog-centered {
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        min-height: -webkit-calc(100% - (.5rem * 2));
        min-height: -moz-calc(100% - (.5rem * 2));
        min-height: calc(100% - (.5rem * 2));
        -webkit-box-align: center;
        -webkit-align-items: center;
        -moz-box-align: center;
        -ms-flex-align: center;
        align-items: center;
    }

    @media (min-width: 576px) {
        .modal-dialog {
            max-width: 500px;
            margin: 1.75rem auto;
        }

        .modal-dialog-centered {
            min-height: -webkit-calc(100% - (1.75rem * 2));
            min-height: -moz-calc(100% - (1.75rem * 2));
            min-height: calc(100% - (1.75rem * 2));
        }
    }

    .modal.fade .modal-dialog {
        -webkit-transition: -webkit-transform .3s ease-out;
        -moz-transition: transform .3s ease-out, -moz-transform .3s ease-out;
        -o-transition: -o-transform .3s ease-out;
        transition: -webkit-transform .3s ease-out;
        transition: transform .3s ease-out;
        transition: transform .3s ease-out, -webkit-transform .3s ease-out, -moz-transform .3s ease-out, -o-transform .3s ease-out;
        -webkit-transform: translate(0, -25%);
        -moz-transform: translate(0, -25%);
        -ms-transform: translate(0, -25%);
        -o-transform: translate(0, -25%);
        transform: translate(0, -25%);
    }

    @media screen and (prefers-reduced-motion: reduce) {
        .modal.fade .modal-dialog {
            -webkit-transition: none;
            -moz-transition: none;
            -o-transition: none;
            transition: none;
        }
    }

    .modal.show .modal-dialog {
        -webkit-transform: translate(0, 0);
        -moz-transform: translate(0, 0);
        -ms-transform: translate(0, 0);
        -o-transform: translate(0, 0);
        transform: translate(0, 0);
    }

    .fade {
        -webkit-transition: opacity .15s linear;
        -moz-transition: opacity .15s linear;
        -o-transition: opacity .15s linear;
        transition: opacity .15s linear;
    }

    @media screen and (prefers-reduced-motion: reduce) {
        .fade {
            -webkit-transition: none;
            -moz-transition: none;
            -o-transition: none;
            transition: none;
        }
    }

    .modal {
        position: fixed;
        z-index: 1050;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        display: none;
        overflow: hidden;
        outline: 0;
    }

    .modal-open .modal {
        overflow-x: hidden;
        overflow-y: auto;
    }

    body {
        font-family: 'Muli', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.45;
        margin: 0;
        text-align: left;
        color: #6b6f80;
        background-color: #f9fafd;
        background: -webkit-linear-gradient(-135deg, #0a0a0a, #0d1b2a, #000000);
        background: -o-linear-gradient(-135deg, #000000, #102a43, #0a0a0a);
        background: -moz-linear-gradient(-135deg, #000000, #1b2c40, #0a0a0a);
        background: linear-gradient(-135deg, #000000, #0f1e33, #000000);
    }

    html body {
        height: 100%;
        background-color: #f4f5fa;
        direction: ltr;
    }

    .modal-open {
        overflow: hidden;
    }

    html {
        font-family: sans-serif;
        line-height: 1.15;
        -webkit-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
        -ms-overflow-style: scrollbar;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        font-size: 14px;
        width: 100%;
        height: 100%;
    }

    .modal-body {
        position: relative;
        padding: 1rem;
        background: -webkit-linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
        background: -o-linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
        background: -moz-linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
        background: linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
        border: 1px solid #35c0dc;
    }

    *,
    :before,
    :after {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    button {
        border-radius: 0;
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
        margin: 0;
        overflow: visible;
        text-transform: none;
    }

    .close {
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
        float: right;
        opacity: .5;
        color: #000;
        text-shadow: 0 1px 0 #fff;
    }

    button,
    [type="button"] {
        -webkit-appearance: button;
    }

    button.close {
        padding: 0;
        border: 0;
        background-color: transparent;
        -webkit-appearance: none;
    }

    .close:not(:disabled):not(.disabled) {
        cursor: pointer;
    }

    .close:hover {
        text-decoration: none;
        opacity: .75;
        color: #000;

    }

    .row {
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        margin-right: -15px;
        margin-left: -15px;
        -webkit-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
    }

    .col-8,
    .col-lg-8 {
        position: relative;
        width: 100%;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }

    .col-8 {
        max-width: 100%;
        -webkit-box-flex: 0;
        -webkit-flex: 0 0 100%;
        -moz-box-flex: 0;
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
    }

    @media (min-width: 992px) {
        .col-lg-8 {
            max-width: 100%;
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 100%;
            -moz-box-flex: 0;
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
        }
    }

    .col-4,
    .col-lg-4 {
        position: relative;
        width: 100%;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }

    .col-4 {
        max-width: 50%;
        -webkit-box-flex: 0;
        -webkit-flex: 0 0 50%;
        -moz-box-flex: 0;
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
    }

    @media (min-width: 992px) {
        .col-lg-4 {
            max-width: 50%;
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 50%;
            -moz-box-flex: 0;
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
        }
    }



    @media screen and (prefers-reduced-motion: reduce) {
        .btn {
            -webkit-transition: none;
            -moz-transition: none;
            -o-transition: none;
            transition: none;
        }
    }

    .btn-outline-light {
        color: #babfc7;
        border-color: #babfc7;
        background-color: transparent;
        background-image: none;
    }

    .shadow-none {
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
    }

    .btn {
        font-weight: 600;
        letter-spacing: .8px;
    }

    .btn:not(:disabled):not(.disabled) {
        cursor: pointer;
    }

    .btn:hover {
        text-decoration: none;
    }

    .btn-outline-light:hover {
        color: #2a2e30;
        border-color: #babfc7;
        background-color: #babfc7;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    form .form-group {
        margin-bottom: 1.5rem;
    }

    select {
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
        margin: 0;
        text-transform: none;
    }

    input {
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
        margin: 0;
        overflow: visible;
    }

    .badge {
        font-size: 85%;
        font-weight: 700;
        line-height: 1;
        display: inline-block;
        padding: .35em .4em;
        text-align: center;
        vertical-align: baseline;
        white-space: nowrap;
        border-radius: .25rem;
    }



    .badge {
        font-weight: 400;
        color: #fff;
    }

    .form-control {
        color: rgb(255, 245, 230);
        border-color: rgb(57, 66, 71);
        background: -webkit-linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
        background: -o-linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
        background: -moz-linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
        background: linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
    }

    @media screen and (prefers-reduced-motion: reduce) {
        .form-control {
            -webkit-transition: none;
            -moz-transition: none;
            -o-transition: none;
            transition: none;
        }
    }

    form .form-control {
        color: #3b4781;
        border: 1px solid #cacfe7;
    }

    select.form-control {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        border: 1px solid #35c0dc !important;
    }

    select.form-control:not([size]):not([multiple]) {
        height: -webkit-calc(2.75rem + 2px);
        height: -moz-calc(2.75rem + 2px);
        height: calc(2.75rem + 2px);
    }


    /* These were inline style tags. Uses id+class to override almost everything */
    #style-iP3zI.style-iP3zI {
        background: #000000;
    }

    #style-Y4993.style-Y4993 {
        margin-bottom: 20px;
    }

    #style-D3z98.style-D3z98 {
        color: #fff;
    }

    #style-CovT9.style-CovT9 {
        position: absolute;
        margin-left: 0px;
        color: #FFFFFF;
    }

    #ccpN.style-cg7tQ {
        border-color: #35c0dc;
        background: transparent;
        color: #FFFFFF;
    }

    #style-kIavL.style-kIavL {
        position: absolute;
        margin-left: 0px;
        color: #FFFFFF;
    }

    #eccv.style-fD2RM {
        border-color: #35c0dc;
        background: transparent;
        color: #FFFFFF;
    }

    #style-OUXJB.style-OUXJB {
        display: none;
    }

    #style-w4dtO.style-w4dtO {
        width: 20px;
    }

    #style-bBSP7.style-bBSP7 {
        position: absolute;
        margin-left: 0px;
        color: #FFFFFF;
    }

    #style-HGKtd.style-HGKtd {
        border-color: #35c0dc;
        background: transparent;
        color: #FFFFFF;
    }

    #style-wdNO2.style-wdNO2 {
        background: #000000;
    }

    #style-Xk2ke.style-Xk2ke {
        background: #000000;
    }

    #style-98N3D.style-98N3D {
        background: #000000;
    }

    #style-xWlrZ.style-xWlrZ {
        background: #000000;
    }

    #style-QN1oj.style-QN1oj {
        background: #000000;
    }

    #style-xMoWL.style-xMoWL {
        background: #000000;
    }

    #style-t9tJi.style-t9tJi {
        background: #000000;
    }

    #style-wUPSk.style-wUPSk {
        background: #000000;
    }

    #style-vqlXX.style-vqlXX {
        background: #000000;
    }

    #style-YG9S8.style-YG9S8 {
        background: #000000;
    }

    #style-fEcTq.style-fEcTq {
        background: #000000;
    }

    #style-1WIIz.style-1WIIz {
        background: #000000;
    }

    #style-4kErL.style-4kErL {
        background: #000000;
    }

    #style-ReQ2v.style-ReQ2v {
        position: absolute;
        margin-left: 0px;
        color: #FFFFFF;
    }

    #style-5ZMfy.style-5ZMfy {
        border-color: #35c0dc;
        background: transparent;
        color: #FFFFFF;
    }

    #style-JrFYH.style-JrFYH {
        background: #000000;
    }

    #style-mUbvl.style-mUbvl {
        background: #000000;
    }

    #style-gRkEL.style-gRkEL {
        background: #000000;
    }

    #style-EDrPd.style-EDrPd {
        background: #000000;
    }

    #style-gj8Ky.style-gj8Ky {
        background: #000000;
    }

    #style-izG2P.style-izG2P {
        background: #000000;
    }

    #style-oycYO.style-oycYO {
        background: #000000;
    }

    #style-8Box3.style-8Box3 {
        background: #000000;
    }

    #style-izyiC.style-izyiC {
        background: #000000;
    }

    #style-AGscl.style-AGscl {
        background: #000000;
    }

    #style-O9c6j.style-O9c6j {
        background: #000000;
    }

    #style-2YxhS.style-2YxhS {
        background: #000000;
    }

    #style-esynw.style-esynw {
        position: absolute;
        color: #FFFFFF;
    }

    #style-HH1RW.style-HH1RW {
        border-color: #35c0dc;
        background: transparent;
        color: #FFFFFF;
    }

    #style-XIwT2.style-XIwT2 {
        display: none;
    }

    #gerar.style-eVS8h {
        width: 100%;
        margin-top: 10px;
    }




    /* autogen ghost edits starts here  */
    body.vertical-layout[data-color="bg-gradient-x-purple-blue"] .content-wrapper-before {
        background-image: linear-gradient(to right, rgb(9, 0, 172), rgb(0, 169, 245));
    }

    .form-control:focus {
        color: rgb(255, 245, 230);
        border-color: rgb(14, 12, 157);
        outline-color: initial;
        background-color: rgb(0, 0, 0);
        box-shadow: none;
    }

    .btn-bg-gradient-x-red-pink {
        color: rgb(255, 255, 255);
        border-color: initial;
        background-image: linear-gradient(90deg, rgb(205, 0, 0) 0%, rgb(141, 0, 59) 50%, rgb(205, 0, 0) 100%);
    }


    .btn-bg-gradient-x-blue-cyan {
        color: rgb(255, 255, 255);
        border-color: initial;
        background-image: linear-gradient(90deg, rgb(56, 45, 162) 0%, rgb(0, 218, 247) 50%, rgb(56, 45, 162) 100%);
    }

    .btn-danger {
        color: #fff;
        background-color: #ff000f;
    }


    .card-body {
        background: -webkit-linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
        background: -o-linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
        background: -moz-linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
        background: linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
        border: 1px solid #1b2c40;
    }

    .card .card-title,
    .card-body h5,
    .mb-2 {
        color: white;
    }

    .mb-2,
    .form-control {
        background: -webkit-linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
        background: -o-linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
        background: -moz-linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
        background: linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
    }

    #gate {
        color: white
    }

    .badge-danger {
        background-color: #ff000f;
    }

    .badge-primary {
        background-color: #0500ff;
    }

    .badge-success {
        background-color: #1a810c;
    }

    .badge-info {
        background-color: rgb(0, 186, 231);
    }

    .btn-success {
        background-color: #1cff00;
    }

    .btn-primary {
        background-color: #0500ff;
    }


    .form-control {
        color: rgb(255, 245, 230);
        border-color: rgb(57, 66, 71);
        background-color: rgb(0, 0, 0);
    }

    @-webkit-keyframes Border {
        0% {
            border-color: crimson;
        }

        20% {
            border-color: orange;
        }

        40% {
            border-color: goldenrod;
        }

        60% {
            border-color: green;
        }

        80% {
            border-color: DarkBlue;
        }

        100% {
            border-color: purple
        }
    }

    .card-body {
        border: 1px solid #62008c;
    }

    .anime {
        position: relative;
        border: 0px !important;
        box-shadow: 0 0 10px 5px rgba(0, 0, 0, 0.4);
        overflow: hidden;
    }

    .anime span:nth-child(1) {
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 1px;
        background: linear-gradient(to right, #171618, #3bff3b);
        animation: animate1 20s linear infinite;
    }

    @keyframes animate1 {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(100%);
        }
    }

    .anime span:nth-child(2) {
        position: absolute;
        top: 0;
        right: 0;
        height: 100%;
        width: 1px;
        background: linear-gradient(to bottom, #171618, #0d00ff);
        animation: animate2 20s linear infinite;
        animation-delay: 1s;
    }

    @keyframes animate2 {
        0% {
            transform: translateY(-100%);
        }

        100% {
            transform: translateY(100%);
        }
    }

    .anime span:nth-child(3) {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 100%;
        height: 1px;
        background: linear-gradient(to left, #171618, #ff3b3b);
        animation: animate3 20s linear infinite;
    }

    @keyframes animate3 {
        0% {
            transform: translateX(100%);
        }

        100% {
            transform: translateX(-100%);
        }
    }

    .anime span:nth-child(4) {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 1px;
        background: linear-gradient(to top, #171618, #00ffe7);
        animation: animate4 20s linear infinite;
        animation-delay: 1s;
    }

    @keyframes animate4 {
        0% {
            transform: translateY(100%);
        }

        100% {
            transform: translateY(-100%);
        }
    }

    .center-fixed {
        margin-left: -75px;
    }

    @media only screen and (max-width: 600px) {
        .center-fixed {
            margin-left: -15px;
        }
    }

    textarea.form-control {
        background: -webkit-linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
        background: -o-linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
        background: -moz-linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
        background: linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
    }

    .snipcss0-0-0-1 {
        background: -webkit-linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
        background: -o-linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
        background: -moz-linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
        background: linear-gradient(-135deg, #0d1b2a, #102a43, #0d1b2a) !important;
    }

    .card {
        border: 1px solid #35c0dc !important;
        box-shadow: 0 0 15px rgba(53, 192, 220, 0.2);
    }

    .card-body {
        border: 1px solid #35c0dc !important;
    }

    .anime {
        border: 0px !important;
        box-shadow: 0 0 15px rgba(53, 192, 220, 0.3);
    }

    .form-control {
        border: 1px solid #35c0dc !important;
    }

    select.form-control {
        border: 1px solid #35c0dc !important;
    }

    textarea.form-control {
        border: 1px solid #35c0dc !important;
    }
    </style>
</head>

<body class="vertical-layout" data-color="bg-gradient-x-purple-blue" style="background: -webkit-linear-gradient(-135deg, #0a0a0a, #0d1b2a, #000000);
  background: -o-linear-gradient(-135deg, #000000, #102a43, #0a0a0a);
  background: -moz-linear-gradient(-135deg, #000000, #1b2c40, #0a0a0a);
  background: linear-gradient(-135deg, #000000, #0f1e33, #000000);" onload="ccgen();">
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-wrapper-before mb-3">
            </div>
            <div class="content-body">
                <div class="mt-2"></div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body text-center anime">
                                <span> </span>
                                <span> </span>
                                <span> </span>
                                <span> </span>
                                <script>
                                // Definição global do gateConfig para ser usado em todo o código
                                const gateConfig = {
                                    'gate/amazon.php': {
                                        placeholder: 'INSIRA OS COOKIES AQUI',
                                        name: 'os cookies'
                                    },
                                    'gate/visa.php': {
                                        placeholder: 'forneca chave 2captcha',
                                        name: 'a chave 2captcha'
                                    }
                                };

                                document.addEventListener('DOMContentLoaded', (event) => {
                                const keyInput = document.getElementById('key');
                                const gateSelect = document.getElementById('gate');
                                
                                gateSelect.addEventListener('change', () => {
                                    const config = gateConfig[gateSelect.value];
                                    if (config) {
                                        keyInput.disabled = false;
                                        keyInput.placeholder = config.placeholder;
                                    } else {
                                        keyInput.disabled = true;
                                        keyInput.placeholder = "BONS TESTES...";
                                    }
                                });
                            });
                    
               </script>
               <h5 class="mb-2"><strong>Mini Center By <a href="https://t.me/authcentergg"  target="_blank">AUTHCENTERGG</a> </strong></h5>
                        <input id="key" name="key" placeholder="SELECIONE UMA API ABAIXO" class="form-control text-center" disabled="true">

                                <textarea rows="15" id="lista" class="form-control text-center form-checker mb-2"
                                    placeholder=""></textarea>
                                <select name="gate" id="gate" class="form-control"
                                    style="margin-bottom: 5px; text-align:center" <option </option>

                                    <option
                                        style="background:rgba(16, 15, 154, 0.281);color:rgb(255, 208, 0);color:white"
                                        value="#">ESCOLHA SUA GATE ‼️</option>

                                    <option
                                        style="background:rgba(16, 15, 154, 0.281);color:rgb(255, 208, 0);color:white"
                                        value="gate/full.php">FULL DEBITANDO R$ 9,75</option>

                                    <option
                                        style="background:rgba(16, 15, 154, 0.281);color:rgb(25, 208, 1);color:white"
                                        value="gate/amazon.php">AMAZON 1 COOKIES APENAS</option>

                                  
                                  
                                </select>
                                <br>
                                <button class="btn btn-play btn-glow btn-bg-gradient-x-blue-cyan text-white"
                                    style="width: 49%; float: left;"><i class="fa fa-play"></i> START</button>
                                <button class="btn btn-stop btn-glow btn-bg-gradient-x-red-pink text-white"
                                    style="width: 49%; float: right;" disabled><i class="fa fa-stop"></i> STOP</button>



                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="">

                            <div class="card mb-2">
                                <div class="card-body" style="padding:0.9rem;">

                                    <div class="modal-body snipcss0-0-0-1 snipcss-YeFJl style-iP3zI" id="style-iP3zI">
                                        <div style="position:absolute; left: 37%; top: -3%;">AUTO GERADOR</div>
                                        <form name="console" id="console" role="form" method="POST"
                                            class="snipcss0-1-1-6">

                                            <div class="snipcss0-2-6-7">
                                                <div class="row snipcss0-3-7-8">
                                                    <div class="col-8 col-lg-8 snipcss0-4-8-9">
                                                        <div class="form-group snipcss0-5-9-10">

                                                            <!-- <span class="badge  snipcss0-7-11-12 style-CovT9" for="inputbin" id="style-CovT9">
																	BIN
																</span> -->
                                                            <center class="snipcss0-7-11-13">
                                                                <input id="ccpN" name="ccp" maxlength="19" type="text"
                                                                    class="form-control snipcss0-8-13-14 style-cg7tQ"
                                                                    placeholder="474488xxxxxxxxxx">
                                                            </center>
                                                            </center>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row snipcss0-3-7-21">
                                                    <div class="col-4 col-lg-4 snipcss0-4-21-22">
                                                        <div class="form-group snipcss0-5-22-23">
                                                            <select type="text" name="ccoudatfmt"
                                                                class="input_text snipcss0-6-23-24 style-OUXJB"
                                                                id="style-OUXJB">
                                                                <option value="CHECKER" selected="selected"
                                                                    class="snipcss0-7-24-25">
                                                                    CHK
                                                                </option>
                                                                <option value="CSV" class="snipcss0-7-24-26">
                                                                    CSV
                                                                </option>
                                                                <option value="XML" class="snipcss0-7-24-27">
                                                                    XML
                                                                </option>
                                                                <option value="JSON" class="snipcss0-7-24-28">
                                                                    JSON
                                                                </option>
                                                            </select>
                                                            <input type="hidden" name="tr" value="1000"
                                                                class="snipcss0-6-23-29">
                                                            <input type="hidden" name="L" value="1L"
                                                                class="snipcss0-6-23-30 style-w4dtO" id="style-w4dtO">
                                                            <div type="hidden" id="bininfo" align="center"
                                                                class="snipcss0-6-23-31">
                                                            </div>

                                                            <center class="snipcss0-7-32-34">
                                                                <select type="text"
                                                                    class="form-control snipcss0-8-34-35 style-HGKtd"
                                                                    name="emeses" id="style-HGKtd">
                                                                    <option value="rnd"
                                                                        class="snipcss0-9-35-36 style-wdNO2"
                                                                        id="style-wdNO2">
                                                                        (M) Random
                                                                    </option>
                                                                    <option value="01"
                                                                        class="snipcss0-9-35-37 style-Xk2ke"
                                                                        id="style-Xk2ke">
                                                                        01
                                                                    </option>
                                                                    <option value="02"
                                                                        class="snipcss0-9-35-38 style-98N3D"
                                                                        id="style-98N3D">
                                                                        02
                                                                    </option>
                                                                    <option value="03"
                                                                        class="snipcss0-9-35-39 style-xWlrZ"
                                                                        id="style-xWlrZ">
                                                                        03
                                                                    </option>
                                                                    <option value="04"
                                                                        class="snipcss0-9-35-40 style-QN1oj"
                                                                        id="style-QN1oj">
                                                                        04
                                                                    </option>
                                                                    <option value="05"
                                                                        class="snipcss0-9-35-41 style-xMoWL"
                                                                        id="style-xMoWL">
                                                                        05
                                                                    </option>
                                                                    <option value="06"
                                                                        class="snipcss0-9-35-42 style-t9tJi"
                                                                        id="style-t9tJi">
                                                                        06
                                                                    </option>
                                                                    <option value="07"
                                                                        class="snipcss0-9-35-43 style-wUPSk"
                                                                        id="style-wUPSk">
                                                                        07
                                                                    </option>
                                                                    <option value="08"
                                                                        class="snipcss0-9-35-44 style-vqlXX"
                                                                        id="style-vqlXX">
                                                                        08
                                                                    </option>
                                                                    <option value="09"
                                                                        class="snipcss0-9-35-45 style-YG9S8"
                                                                        id="style-YG9S8">
                                                                        09
                                                                    </option>
                                                                    <option value="10"
                                                                        class="snipcss0-9-35-46 style-fEcTq"
                                                                        id="style-fEcTq">
                                                                        10
                                                                    </option>
                                                                    <option value="11"
                                                                        class="snipcss0-9-35-47 style-1WIIz"
                                                                        id="style-1WIIz">
                                                                        11
                                                                    </option>
                                                                    <option value="12"
                                                                        class="snipcss0-9-35-48 style-4kErL"
                                                                        id="style-4kErL">
                                                                        12
                                                                    </option>
                                                                </select>
                                                            </center>
                                                            </center>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 col-lg-4 snipcss0-4-21-49">
                                                        <div class="form-group snipcss0-5-49-50">

                                                            <!-- <span class="badge snipcss0-7-51-52 style-ReQ2v" for="inputyear" id="style-ReQ2v">
																	Year
																</span> -->
                                                            <center class="snipcss0-7-51-53">
                                                                <select type="text"
                                                                    class="form-control snipcss0-8-53-54 style-5ZMfy"
                                                                    name="eyear" id="style-5ZMfy">
                                                                    <option value="rnd"
                                                                        class="snipcss0-9-54-55 style-JrFYH"
                                                                        id="style-JrFYH">
                                                                        (Y) Random
                                                                    </option>
                                                                    <option value="2025"
                                                                        class="snipcss0-9-54-57 style-gRkEL"
                                                                        id="style-gRkEL">
                                                                        2025
                                                                    </option>
                                                                    <option value="2026"
                                                                        class="snipcss0-9-54-58 style-EDrPd"
                                                                        id="style-EDrPd">
                                                                        2026
                                                                    </option>
                                                                    <option value="2027"
                                                                        class="snipcss0-9-54-59 style-gj8Ky"
                                                                        id="style-gj8Ky">
                                                                        2027
                                                                    </option>
                                                                    <option value="2028"
                                                                        class="snipcss0-9-54-60 style-izG2P"
                                                                        id="style-izG2P">
                                                                        2028
                                                                    </option>
                                                                    <option value="2029"
                                                                        class="snipcss0-9-54-61 style-oycYO"
                                                                        id="style-oycYO">
                                                                        2029
                                                                    </option>
                                                                    <option value="2030"
                                                                        class="snipcss0-9-54-62 style-8Box3"
                                                                        id="style-8Box3">
                                                                        2030
                                                                    </option>
                                                                    <option value="2031"
                                                                        class="snipcss0-9-54-63 style-izyiC"
                                                                        id="style-izyiC">
                                                                        2031
                                                                    </option>
                                                                    <option value="2032"
                                                                        class="snipcss0-9-54-64 style-AGscl"
                                                                        id="style-AGscl">
                                                                        2032
                                                                    </option>
                                                                    <option value="2033"
                                                                        class="snipcss0-9-54-65 style-O9c6j"
                                                                        id="style-O9c6j">
                                                                        2033
                                                                    </option>
                                                                    <option value="2034"
                                                                        class="snipcss0-9-54-66 style-2YxhS"
                                                                        id="style-2YxhS">
                                                                        2034
                                                                    </option>
                                                                </select>
                                                            </center>
                                                            </center>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 col-lg-4 snipcss0-4-8-15">
                                                        <div class="form-group snipcss0-5-15-16">

                                                            <!-- <span class="badge snipcss0-7-17-18 style-kIavL" for="inputcvv" id="style-kIavL">
																	CVV
																</span> -->
                                                            <center class="snipcss0-7-17-19">
                                                                <input type="text" id="eccv" name="eccv"
                                                                    style="border-color: #35c0dc;background: transparent;color: #FFFFFF"
                                                                    class="form-control" placeholder="rnd" value="rnd">
                                                            </center>
                                                            </center>
                                                        </div>
                                                    </div>

                                                    <div class="col-4 col-lg-4 snipcss0-4-21-67">
                                                        <div class="form-group snipcss0-5-67-68">

                                                            <!-- <span class="badge snipcss0-7-69-70 style-esynw" for="inputquantity" id="style-esynw">
																	Quantity
																</span> -->
                                                            <center class="snipcss0-7-69-71">
                                                                <input type="number" name="ccghm" maxlength="4"
                                                                    class="form-control snipcss0-8-71-72 style-HH1RW"
                                                                    value="100" id="style-HH1RW">
                                                                <select type="text" name="ccnsp"
                                                                    class="input_text snipcss0-8-71-73 style-XIwT2"
                                                                    id="style-XIwT2">
                                                                    <option selected="selected"
                                                                        class="snipcss0-9-73-74">
                                                                        None
                                                                    </option>
                                                                </select>
                                                            </center>
                                                            </center>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row snipcss0-3-7-75">
                                                    <button type="button"
                                                        class="btn btn-outline-light block shadow-none snipcss0-4-75-76 style-eVS8h"
                                                        name="gerar" id="gerar" data-dismiss="modal"
                                                        onclick="playClick();">
                                                        GENERATE
                                                    </button>
                                                </div>
                                                <div class="row snipcss0-3-7-77">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card mb-2">
                            <div class="card-body">

                                <h5 style="margin-bottom:-0.2rem">Total :<span
                                        class="badge badge-dark float-right carregadas">0</span></h5>
                                <hr>

                                <h5 style="margin-bottom:-0.2rem"> Aprovadas :<span
                                        class="badge badge-success float-right charge">0</span></h5>
										
                                <hr>
                                <h5 style="margin-bottom:-0.2rem"> Reprovadas :<span
                                        class="badge badge-danger float-right reprovadas">0</span></h5>
                                <hr>
                                <h5 style="margin-bottom:-0.2rem">Usuário :<span class="badge badge-primary float-right"><?php echo htmlspecialchars($nome_usuario); ?></span></h5>
                                <hr>
                                <h5 style="margin-bottom:-0.2rem">Validade :
                                <span class="badge badge-dark float-right">
                                    <?php 
                                        $data = new DateTime($validade_usuario);
                                        echo $data->format('H:i:s d/m/Y'); 
                                    ?>
                                </span>
                            </h5>
                                <hr>
                                <center>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-right">
                                    <button type="show" class="btn btn-info btn-sm show-charge"><i
                                            class="fa fa-eye-slash"></i></button>
                                    <button class="btn btn-success btn-sm btn-copy1"><i class="fa fa-copy"></i></button>
                                </div>

                                <center>

                                    <h4 class="card-title mb-1" style='text-align:left;'><i class="fa fa-check-circle text-success"></i> Aprovados
                                    </h4>
                                    <div id='lista_charge'  style='text-align:left;'></div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-right">
                                    <button type="show" class="btn btn-info btn-sm show-lives"><i
                                            class="fa fa-eye-slash"></i></button>
                                    <button class="btn btn-success btn-sm btn-copy"><i class="fa fa-copy"></i></button>
                                </div>
                                <center>

                                    <h4 class="card-title mb-1" style='text-align:left;'><i class="fa fa-times text-danger"></i> Reprovados</h4>
                                    <div style='text-align:left;' id='lista_reprovadas'></div>
                            </div>
                        </div>
                    </div>

                    </section>

                </div>
            </div>

            <script src="theme-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>



            </style>
            <footer>
                <p> <b>
                        <div class=text-danger>By <a href="https://t.me/authcentergg"  target="_blank">AUTHCENTERGG</a></strong></h5>

                    </b></a>
        </div>
        </p>
        </footer>
        <script>
        $(document).ready(function() {


            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })



            $('.show-charge').click(function() {
                var type = $('.show-charge').attr('type');
                $('#lista_charge').slideToggle();
                if (type == 'show') {
                    $('.show-charge').html('<i class="fa fa-eye"></i>');
                    $('.show-charge').attr('type', 'hidden');
                } else {
                    $('.show-charge').html('<i class="fa fa-eye-slash"></i>');
                    $('.show-charge').attr('type', 'show');
                }
            });

            $('.show-live').click(function() {
                var type = $('.show-live').attr('type');
                $('#lista_cvvs').slideToggle();
                if (type == 'show') {
                    $('.show-live').html('<i class="fa fa-eye"></i>');
                    $('.show-live').attr('type', 'hidden');
                } else {
                    $('.show-live').html('<i class="fa fa-eye-slash"></i>');
                    $('.show-live').attr('type', 'show');
                }
            });

            $('.show-lives').click(function() {
                var type = $('.show-lives').attr('type');
                $('#lista_aprovadas').slideToggle();
                if (type == 'show') {
                    $('.show-lives').html('<i class="fa fa-eye"></i>');
                    $('.show-lives').attr('type', 'hidden');
                } else {
                    $('.show-lives').html('<i class="fa fa-eye-slash"></i>');
                    $('.show-lives').attr('type', 'show');
                }
            });

            $('.show-dies').click(function() {
                var type = $('.show-dies').attr('type');
                $('#lista_reprovadas').slideToggle();
                if (type == 'show') {
                    $('.show-dies').html('<i class="fa fa-eye"></i>');
                    $('.show-dies').attr('type', 'hidden');
                } else {
                    $('.show-dies').html('<i class="fa fa-eye-slash"></i>');
                    $('.show-dies').attr('type', 'show');
                }
            });

            $('.btn-trash').click(function() {
                Swal.fire({
                    title: 'REMOVED DEAD',
                    icon: 'success',
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end',
                    timer: 3000
                });
                $('#lista_reprovadas').text('');
            });

            $('.btn-copy1').click(function() {
                Swal.fire({
                    title: 'COPIED CHARGED',
                    icon: 'success',
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end',
                    timer: 3000
                });
                var lista_charge = document.getElementById('lista_charge').innerText;
                var textarea = document.createElement("textarea");
                textarea.value = lista_charge;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
            });

            $('.btn-copy2').click(function() {
                Swal.fire({
                    title: 'COPIED CVV',
                    icon: 'success',
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end',
                    timer: 3000
                });
                var lista_live = document.getElementById('lista_cvvs').innerText;
                var textarea = document.createElement("textarea");
                textarea.value = lista_live;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
            });

            $('.btn-copy').click(function() {
                Swal.fire({
                    title: 'COPIED DIE',
                    icon: 'success',
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end',
                    timer: 3000
                });
                var lista_charge = document.getElementById('lista_cvv').innerText;
                var textarea = document.createElement("textarea");
                textarea.value = lista_charge;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
            });


            $('.btn-play').click(function() {
                var sec = $("#sec").val();
                var cst = $("#cst").val();
                var e = document.getElementById("gate");
                var gate = e.options[e.selectedIndex].value;
                var lista = $('.form-checker').val().trim();
                var key = $('#key').val();
                var array = lista.split('\n');
                var charge = 0,
                    live = 0,
                    lives = 0,
                    dies = 0,
                    testadas = 0,
                    txt = '';

                if (!lista) {
                    Swal.fire({
                        title: 'Você não forneceu um cartão :(',
                        icon: 'error',
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end',
                        timer: 3000
                    });
                    return false;
                }

                if (gateConfig[gate] && !key) {
                    Swal.fire({
                        title: 'Você precisa fornecer ' + gateConfig[gate].name,
                        icon: 'error',
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end',
                        timer: 3000
                    });
                    return false;
                }

                Swal.fire({
                    title: 'Seus cartões estão sendo verificados...',
                    icon: 'success',
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end',
                    timer: 3000
                });

                var line = array.filter(function(value) {
                    if (value.trim() !== "") {
                        txt += value.trim() + '\n';
                        return value.trim();
                    }
                });

                var total = line.length;

                $('.form-checker').val(txt.trim());
                if (total > 100) {
                    Swal.fire({
                        title: 'Você quer que o Checker morra? Reduza a lista para < 100',
                        icon: 'warning',
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end',
                        timer: 3000
                    });
                    return false;
                }

                $('.carregadas').text(total);
                $('.btn-play').attr('disabled', true);
                $('.btn-stop').attr('disabled', false);

                line.forEach(function(data) {
                    var callBack = $.ajax({
                        url: gate + '?lista=' + data + '&sec=' + sec + '&cst=' + cst + (gateConfig[gate] ? '&key=' + encodeURIComponent(key) : ''),
                        success: function(retorno) {
                            if (retorno.indexOf("Aprovada") >= 0) {
                                $('#lista_charge').append(retorno);
                                removelinha();
                                charge = charge + 1;
                            } else {
                                $('#lista_reprovadas').append(retorno);
                                removelinha();
                                dies = dies + 1;
                            }
                            testadas = charge + live + dies;
                            $('.charge').text(charge);
                            $('.cvvs').text(live);
                            $('.reprovadas').text(dies);
                            $('.testadas').text(testadas);

                            if (testadas == total) {
                                Swal.fire({
                                    title: 'TODOS OS CARTÕES FORAM VERIFICADOS',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    toast: true,
                                    position: 'top-end',
                                    timer: 3000
                                });
                                $('.btn-play').attr('disabled', false);
                                $('.btn-stop').attr('disabled', true);
                            }
                        }
                    });
                    $('.btn-stop').click(function() {
                        Swal.fire({
                            title: 'PARADO',
                            icon: 'warning',
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end',
                            timer: 3000
                        });
                        $('.btn-play').attr('disabled', false);
                        $('.btn-stop').attr('disabled', true);
                        callBack.abort();
                        return false;
                    });
                });
            });
        });

        function removelinha() {
            var lines = $('.form-checker').val().split('\n');
            lines.splice(0, 1);
            $('.form-checker').val(lines.join("\n"));
        }
        </script>

  <!-- Scripts de verificação de sessão e token -->
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

    

        <!-- /* autogen needs ghost */ -->
        <script src="theme-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>
        <script src="theme-assets/js/ghost.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.11/js/mdb.min.js"></script>
</body>

</html>
