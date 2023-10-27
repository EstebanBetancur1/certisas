<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\Block;
use Illuminate\Support\Facades\Auth;

use App\Libs\AmountsWithLetters;

function getYears(){

    $years = [];
    $now = Carbon::now(config('app.timezone'));
    $yearStart = $now->year;
    $y = 0;

    $providers = [];

    for($i = 6; $i > 0; $i--){
        $years[$yearStart - $y] = $yearStart - $y;
        $y++;
    }

    return $years;
}
function convertAmountToText($amount){
    return AmountsWithLetters::convertirNumeroEnLetras($amount, 0);
}

function removeAccents($cadena){
    $replacements = array(
      'á' => 'a',
      'é' => 'e',
      'í' => 'i',
      'ó' => 'o',
      'ú' => 'u',
      'ñ' => 'n',
      'Á' => 'A',
      'É' => 'E',
      'Í' => 'I',
      'Ó' => 'O',
      'Ú' => 'U',
      'Ñ' => 'N',
    );
  
    $cadena = strtr($cadena, $replacements);
  
    return $cadena;
   }

function getAgent(){
    $repository = repository("Company");
    return $repository->findWhere(["id" => session("companyID")])->first();
}

function getPeriod($type, $period){
    $type = (int)$type;
    $period = (int)$period;

    if($type === 1){

        if($period === 1){
            return "Enero";
        }elseif($period === 2){
            return "Febrero";
        }elseif($period === 3){
            return "Marzo";
        }elseif($period === 4){
            return "Abril";
        }elseif($period === 5){
            return "Mayo";
        }elseif($period === 6){
            return "Junio";
        }elseif($period === 7){
            return "Julio";
        }elseif($period === 8){
            return "Agosto";
        }elseif($period === 9){
            return "Septiembre";
        }elseif($period === 10){
            return "Octubre";
        }elseif($period === 11){
            return "Noviembre";
        }elseif($period === 12){
            return "Diciembre";
        }elseif($period === -1){
            return "Todo el año";
        }
    }elseif($type === 2){

        if($period === 1){
            return "Enero - Febrero";
        }elseif($period === 2){
            return "Marzo - Abril";
        }elseif($period === 3){
            return "Mayo - Junio";
        }elseif($period === 4){
            return "Julio - Agosto";
        }elseif($period === 5){
            return "Septiembre - Octubre";
        }elseif($period === 6){
            return "Noviembre - Diciembre";
        }elseif($period === -1){
            return "Todo el año";
        }
    }

    return null;
}

function getCityString($code){
    $repository = repository("City");

    $item = $repository->findWhere(["code" => $code])->first();

    if($item && $item->state){
        return "{$item->state->name}, {$item->name}";
    }

    return null;
}

function getOnlyCity($code){
    $repository = repository("City");

    $item = $repository->findWhere(["code" => $code])->first();

    if($item){
        return "{$item->code}, {$item->name}";
    }

    return null;
}

function getCityById($id){
    $repository = repository("City");

    $item = $repository->findWhere(["id" => $id])->first();

    if($item){
        return "{$item->name}";
    }

    return null;
}

function getEntityByCityId($id){

    $repository = repository("City");

    $item = $repository->findWhere(["id" => $id])->first();


    if($item && $item->entity){
        return "{$item->entity->name}";
    }else{
        $item->name;
    }

    return null;
}

function getSectionalString($code){

    $repository = repository("Sectional");

    $item = $repository->findWhere(["code" => $code])->first();

    if($item){
        return "{$item->title}";
    }

    return null;
}

function parsePdf($text){
    $lines = preg_split("/\n/", $text);
    $data = [];

    array_walk($lines, function(&$element, $key){
        $element = trim(preg_replace('/\s+/', ' ', $element));

        if(! $element || $element === ""){
            return false;
        }
        return $element;
    });
    $campos = [
        'Documento identidad:',
        "Nombre","Apellidos"
    ];
    $data["nit"]                = getNit($lines);
    $data["dv"]                 = getDv($lines);
    $data["sectional"]          = getSectional($lines);
    $data["type"]               = getRutType($lines);
    $data["name"]               = getName($lines);
    $data["city"]               = getCity($lines);
    $data["address"]            = getAddress($lines);
    $data["email"]              = getEmail($lines);
    $data["phone"]              = getPhone($lines);
    $data["activities"]         = getActivities($lines, $data["type"]);
    $data["responsibilities"]   = getResponsibilities($lines, $data["type"]);
    $data["date"]               = getRutDate($lines, $data["type"]);
    return $data;
}

function getNit($lines){
    $line = $lines["2"];

    preg_match_all('/^([0-9\s]+)/', $line, $matches, PREG_PATTERN_ORDER);

    if(is_array($matches) && count($matches)){
       $line = trim(preg_replace('/\s+/', '', $matches[0][0]));
    }

    if(strlen($line) > 1){
        $line = substr($line, 0, -1);
    }

    return $line;
}

function getDv($lines){
    $line = $lines["2"];

    preg_match_all('/^([0-9\s]+)/', $line, $matches, PREG_PATTERN_ORDER);

    if(is_array($matches) && count($matches)){
       $line = trim(preg_replace('/\s+/', '', $matches[0][0]));
    }

    if(strlen($line) > 1){
        $line = substr($line, -1);
    }

    return $line;
}

function getSectional($lines){
    $line = $lines["2"];

    preg_match_all('/([0-9\s]+)$/', $line, $matches, PREG_PATTERN_ORDER);

    if(is_array($matches) && count($matches)){
       $line = trim(preg_replace('/\s+/', '', $matches[0][0]));
    }

    if(strlen($line) === 1){
        $line = "0{$line}";
    }

    return $line;
}



function getRutType($lines){
    $line = $lines["3"];

    if(preg_match("/(natural)/", $line)){
        return 2;
    }elseif(preg_match("/(jurídica)/", $line)){
        return 1;
    }

    return 0;
}

function getName($lines){
    $type = getRutType($lines);

    // Juridico
    if($type === 1){
        return $lines[6];
    }elseif($type === 2){ // Natural
        return $lines[5];
    }

    return null;
}

function getCity($lines){
    $line = $lines["8"];
    $code1 = "";
    $code2 = "";
    $items = [];

    preg_match_all('/([0-9\s])+/', $line, $matches, PREG_PATTERN_ORDER);

    if(is_array($matches) && count($matches)){

       if(count($matches[0])){

            $_matches = $matches[0];

            array_walk($_matches, function(&$element, $key){
                $element = trim(preg_replace('/\s+/', '', $element));
            });

            foreach($_matches as $_match){
                if($_match){
                    $items[] = $_match;
                }
            }

            if(count($items) === 3){
                $code1 = $items[1];
                $code2 = $items[2];
            }
        }
    }

    return "{$code1}{$code2}";
}

function getAddress($lines){
    return $lines[9];
}

function getEmail($lines){
    $line = $lines["10"];

    $line = trim(preg_replace('/\s+/', '#', $line));
    $parts = explode("#", $line);

    if(count($parts) > 0){
        return $parts[0];
    }

    return "";
}

function getPhone($lines){
    $line = $lines["10"];

    $line = trim(preg_replace('/\s+/', '#', $line));
    $parts = explode("#", $line);

    if(count($parts) === 1){
        $line = $lines["11"];

        $line = trim(preg_replace('/\s+/', '#', $line));
        $parts = explode("#", $line);

        if(count($parts)){
            if(preg_match('/^([0-9]+)$/', $parts[0])){
                return $parts[0];
            }
        }

    }elseif(count($parts) === 2){
        return $parts[1];
    }elseif(count($parts) === 3){
        return $parts[1];
    }elseif(count($parts) === 4){
        return $parts[2];
    }

    return "";
}

function getActivities($lines){
    $line = $lines["12"];
    $code1 = "";
    $code2 = "";
    $activities = [];

    $line = preg_replace("/(\d{8})/", "", $line);
    $line = preg_replace("/(\d{1})/", "\\1 ", $line);
    $line = preg_replace("/(\s{2,})/", " ", $line);
    $line = trim($line);

    preg_match_all('/(\d{1}\s\d{1}\s\d{1}\s\d{1})+/', $line, $matches, PREG_PATTERN_ORDER);

    if(is_array($matches) && count($matches)){

       if(count($matches[0])){

            $_matches = $matches[0];

            array_walk($_matches, function(&$element, $key){
                $element = trim(preg_replace('/\s+/', '', $element));
            });

            $i = 0;

            foreach($_matches as $_match){
                if($i < 4 && $_match){
                    $activities[] = $_match;
                }

                $i++;
            }

            if(count($activities)){
                // Modify this line to join with quotes and comma
                return '' . implode(', ', $activities) . '';
            }
        }
    }

    return null;
}


function getResponsibilities($lines, $type)
{
    $l = 12;
    $responsibilities = [];

    if((int)$type === 1 || (int)$type === 2){
        for($i = $l; $i < 50; $i++){
            if(array_key_exists($i, $lines)){
                if(preg_match("/^([0-9]{2})\s?\-\s\w+/", $lines[$i], $matches)){

                    if(count($matches) === 2){
                        $responsibilities[(string)$matches[1]] = $lines[$i];
                    }else{
                        $responsibilities[] = $lines[$i];
                    }
                }
            }
        }
    }

    if(count($responsibilities)){
        array_walk($responsibilities, function(&$element, $key){
            $element = trim(preg_replace('/^([0-9]{2})\s\-/', "\\1-", $element));
        });

        return json_encode($responsibilities, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }

    return json_encode([]);
}

function getRutDate($lines, $type){
    $dateString = null;

    foreach($lines as $i => $line){
        if($line && (preg_match("/^X\s[0-9]?\s?([0-9]{8})$/", $line, $matches)) || preg_match("/^([0-9]{8})$/", $line, $matches)){
            $dateString = $matches[1];
            break;
        }
    }

    return $dateString;
}

function repository($model){
    return app("App\Repositories\\{$model}Repository");
}

function setting($key, $default = -1){

    $hasTable = false;

    try {
        $hasTable = Schema::hasTable('settings');
    } catch (Exception $e) {
        if($default !== -1){
            return $default;
        }
    }

    if ($hasTable)
    {
        $setting = cache()->get('setting');

        if(! $setting){
            cache()->rememberForever('setting', function () {
                return \DB::table('settings')->first();
            });

            $setting = cache()->get('setting');
        }

        if($setting && isset($setting->$key) && $setting->$key){
            return $setting->$key;
        }
    }


    if($default !== -1){
        return $default;
    }

    return null;
}

function convertToArray($items, $key, $value){
    $data = [];

    foreach($items as $item){
        $data[$item->$key] = $item->$value;
    }

    return $data;
}

function priceFormat($price){
    return number_format(ceil($price), 0, '', '.');
}

function randomPassword($lenght = 5){

    $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";

    $password = "";

    for($i=0; $i<$lenght; $i++) {
        // Obtenemos un caracter aleatorio escogido de la cadena de caracteres
        $password .= substr($str,rand(0,62),1);
    }

    return $password;
}


function datetimeToken(){
    return preg_replace('/[^0-9]+/', '', Carbon::now()->format('Y-m-d H:i:s'));
}

if (! function_exists('datetimeFormat')) {
    function datetimeFormat($value = null, $format = 'Y-m-d H:i:s')
    {
        if ($value) {
            $d = Carbon::instance(new \DateTime($value, new \DateTimeZone(config('app.timezone'))))->format($format);
        } else {
            $d = Carbon::now(config('app.timezone'))->format($format);
        }

        return $d;
    }
}

if (! function_exists('generateCode')) {
    function generateCode($length){
        $code = "";

        $string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        $max = strlen($string) - 1;

        for($i=0;$i < $length;$i++){
            $code .= $string[rand(0,$max)];
        }

        return $code;
    }
}

if (! function_exists('getBlock')) {

    function getBlock($label, $default = -1){
        $item = Block::where(['label' => $label])->first();

        if($item){
            return $item->content . ((Auth::guard('admin')->check()) ? '<a href="'.route('admin.blocks.edit', ["id" => $item->id]).'">Editar</a>' : '');
        }

        if($default !== -1){
            return $default;
        }

        return null;
    }
}

if (! function_exists('clearString')) {
    /**
     * Escape HTML special characters in a string.
     * @return string
     */
    function clearString($string)
    {
        $string = strip_tags($string);

        $string = str_replace(
            array("\\", "¨", "º", "~",
                "#", "@", "|", "!", "\"",
                "·", "$", "%", "&", "/",
                "(", ")", "?", "'", "¡",
                "¿", "[", "^", "`", "]",
                "+", "}", "{", "¨", "´",
                ">", "<", ";", ":", "*"),
            '',
            $string
        );

        $string = html_entity_decode($string, ENT_COMPAT, 'UTF-8');
        $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
        $string = trim($string);

        return $string;
    }
}

if (! function_exists('clearHtml')) {
    /**
     * Escape HTML special characters in a string.
     * @return string
     */
    function clearHtml($string)
    {
        $string = strip_tags($string);
        $string = html_entity_decode($string, ENT_COMPAT, 'UTF-8');
        $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
        $string = trim($string);

        return $string;
    }
}

if (! function_exists('repository')) {

    function repository($model){
        return app("App\Repositories\\{$model}Repository");
    }
}

if (! function_exists('createToken')) {

    function createToken($string = '')
    {
        return sha1($string.config('app.name'));
    }
}
