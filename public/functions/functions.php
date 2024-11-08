<?php


function secondsRussianReadable($secs){
    if($secs < 1){
        return '0 секунд';
    }
    if($secs < 60){
        $recalculated = $secs;
        $mode = 'secs';
    }elseif($secs < 60*60){
        $recalculated = round($secs/60);
        $mode = 'mins';
    }elseif($secs < 60*60*24){
        $recalculated = round($secs/(60*60));
        $mode = 'hours';
    }elseif($secs < 60*60*24*30){
        $recalculated = round($secs/(60*60*24));
        $mode = 'days';
    }elseif($secs < 60*60*24*365){
        $recalculated = round($secs/(60*60*24*30));
        $mode = 'month';
    }else{
        $recalculated = round($secs/(60*60*24*365));
        $mode = 'years';
    }
    $words = [
        'secs' => ['секунда', 'секунды', 'секунд'],
        'mins' => ['минута', 'минуты', 'минут'],
        'hours' => ['час', 'часа', 'часов'],
        'days' => ['день', 'дня', 'дней'],
        'month' => ['месяц', 'месяца', 'месяцев'],
        'years' => ['год', 'года', 'лет'],
    ];
    $getSuffix = function($number, $suffix) {
        $keys = array(2, 0, 1, 1, 1, 2);
        $mod = $number % 100;
        $suffix_key = ($mod > 7 && $mod < 20) ? 2: $keys[min($mod % 10, 5)];
        return $suffix[$suffix_key];
    };
    return ($recalculated*1).' '.$getSuffix($recalculated, $words[$mode]);
}



function format_size($size){
     $metrics[0] = 'байт';
     $metrics[1] = 'KB';
     $metrics[2] = 'MB';
     $metrics[3] = 'GB';
     $metrics[4] = 'TB';
     $metric = 0;
     while(floor($size/1024) > 0){
         ++$metric;
         $size /= 1024;
     }
     $ret =  round($size,1)." ".(isset($metrics[$metric])?$metrics[$metric]:'??');
     return $ret;
 }

function get_metka_naim($id) {
	$db=new connect_db();
	if($db->state=="connected") {

		////получаем текущий счетчик договоров
		$sql="SELECT naim from dogs_metki where id=$id";
				foreach ($db->dbo->query($sql) as $row){
					$metka_naim=$row[0];
				}
	
		
		return $metka_naim;

	}
}

function delete_folder($path)
{
    if (is_dir($path) === true)
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($files as $file)
        {
            if (in_array($file->getBasename(), array('.', '..')) !== true)
            {
                if ($file->isDir() === true)
                {
                    rmdir($file->getPathName());
                }

                else if (($file->isFile() === true) || ($file->isLink() === true))
                {
                    unlink($file->getPathname());
                }
            }
        }

        return rmdir($path);
    }

    else if ((is_file($path) === true) || (is_link($path) === true))
    {
        return unlink($path);
    }

    return false;
}

function array_map_recursive( $callback, $mixed ) {
	if( is_array( $mixed ) || is_object( $mixed ) ) {
		$return = is_array( $mixed ) ? array() : new stdClass;
		foreach ($mixed as $key => $value){
			if( is_array( $mixed ) )
				$return[call_user_func( $callback, $key )] = array_map_recursive( $callback, $value );
			else
				$return->{call_user_func( $callback, $key )} = array_map_recursive( $callback, $value );
		}
		return $return;
	} else {
		return call_user_func( $callback, $mixed );
	}
}
function mb_json_encode( $mixed ) {
	$apply = function ( $string ) {
		return str_replace( array( "\"", "'" ), array( "\u0022", "\u0027" ), utf8_encode( $string ) );
	};
	return json_encode( array_map_recursive( $apply, $mixed ) );
}
function mb_json_decode( $string ) {
	$apply = function ( $string ) {
		return str_replace( array( "\u0022", "\u0027" ), array( "\"", "'" ), utf8_decode( $string ) );
	};
	$on = json_decode( str_replace( "\\\"", "\"", $string ), true );
	return array_map_recursive( $apply, $on );
}


function ip_details($ip) {

$db=new connect_db();
		if($db->state=="connected") {

	
		$iplong = ip2long($ip);

		
		$sql="SELECT country_code2,country_name FROM countries_list_g WHERE $iplong BETWEEN ip_from AND ip_to LIMIT 1";
				foreach ($db->dbo->query($sql) as $row){
					$country_code2=$row[0];
					$country_name=$row[1];
				}
	
		$location->countryName=$country_name;
		$location->countryCode=$country_code2;

}

if($location->countryName=="") {

$str=file_get_contents("http://www.geoplugin.net/json.gp?ip=$ip");

$details = json_decode($str);

		$location->countryName=$details->geoplugin_countryName;
		$location->countryCode=$details->geoplugin_countryCode;
}

	
	return  $location;


}


function gps_distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $unit) {

	$theta = $longitudeFrom - $longitudeTo;
	$dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515* 1.609344*1000;
	return $miles;
}

function gen_new_password() {
	$chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP"; 
	$max=6; 
	$size=StrLen($chars)-1; 
	$password=null; 
	while($max--) 
		$password.=$chars[rand(0,$size)]; 
	return $password;
}

function clear($string,$type=2) {
		if($type==1) {
		////это число
		return $string*1;
		}
		if($type==2) {
		////это строка
		return trim(strip_tags($string));
		}
		if($type==3) {
		////это массив
		if(is_array($string)) {
			foreach($string as $st) {
			$res_arr[]=trim(strip_tags($st));
			}
		return $res_arr;
		}	

		else
		return array();
		}
}

function translit($s) {
  $s = (string) $s; // преобразуем в строковое значение
  $s = strip_tags($s); // убираем HTML-теги
  $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
  $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
  $s = trim($s); // убираем пробелы в начале и конце строки
  $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
  $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
  $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // очищаем строку от недопустимых символов
  $s = str_replace(" ", "-", $s); // заменяем пробелы знаком минус
  return $s; // возвращаем результат
}

function num2str($num) {
	$nul='ноль';
	$ten=array(
		array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
		array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
	);
	$a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
	$tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
	$hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
	$unit=array( // Units
		array('копейка' ,'копейки' ,'копеек',	 1),
		array('рубль'   ,'рубля'   ,'рублей'    ,0),
		array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
		array('миллион' ,'миллиона','миллионов' ,0),
		array('миллиард','милиарда','миллиардов',0),
	);
	//
	list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
	$out = array();
	if (intval($rub)>0) {
		foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
			if (!intval($v)) continue;
			$uk = sizeof($unit)-$uk-1; // unit key
			$gender = $unit[$uk][3];
			list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
			// mega-logic
			$out[] = $hundred[$i1]; # 1xx-9xx
			if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
			else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
			// units without rub & kop
			if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
		} //foreach
	}
	else $out[] = $nul;
	$out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
	$out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
	return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}

/**
 * Склоняем словоформу
 * @ author runcore
 */
function morph($n, $f1, $f2, $f5) {
	$n = abs(intval($n)) % 100;
	if ($n>10 && $n<20) return $f5;
	$n = $n % 10;
	if ($n>1 && $n<5) return $f2;
	if ($n==1) return $f1;
	return $f5;
}

function russian_date($t) {
$date=explode(".", date("d.m.Y",$t));
switch ($date[1]){
case 1: $m='января'; break;
case 2: $m='февраля'; break;
case 3: $m='марта'; break;
case 4: $m='апреля'; break;
case 5: $m='мая'; break;
case 6: $m='июня'; break;
case 7: $m='июля'; break;
case 8: $m='августа'; break;
case 9: $m='сентября'; break;
case 10: $m='октября'; break;
case 11: $m='ноября'; break;
case 12: $m='декабря'; break;
}
return $date[0].' '.$m.' '.$date[2];
}

 
function russain_clear($str) {
	$str=str_replace("й","00",$str);
	$str=str_replace("ц","01",$str);
	$str=str_replace("у","02",$str);
	$str=str_replace("к","03",$str);
	$str=str_replace("е","04",$str);
	$str=str_replace("н","05",$str);
	$str=str_replace("г","06",$str);
	$str=str_replace("ш","07",$str);
	$str=str_replace("щ","08",$str);
	$str=str_replace("з","09",$str);
	$str=str_replace("х","32",$str);
	$str=str_replace("ъ","10",$str);
	$str=str_replace("ё","11",$str);
	$str=str_replace("ф","12",$str);
	$str=str_replace("ы","13",$str);
	$str=str_replace("в","14",$str);
	$str=str_replace("а","15",$str);
	$str=str_replace("п","16",$str);
	$str=str_replace("р","17",$str);
	$str=str_replace("о","18",$str);
	$str=str_replace("л","19",$str);
	$str=str_replace("д","20",$str);
	$str=str_replace("ж","21",$str);
	$str=str_replace("э","22",$str);
	$str=str_replace("я","23",$str);
	$str=str_replace("ч","24",$str);
	$str=str_replace("с","25",$str);
	$str=str_replace("м","26",$str);
	$str=str_replace("и","27",$str);
	$str=str_replace("т","28",$str);
	$str=str_replace("ь","29",$str);
	$str=str_replace("б","30",$str);
	$str=str_replace("ю","31",$str);
	
		$str=str_replace("й","00",$str);
	$str=str_replace("Й","01",$str);
	$str=str_replace("Ц","01",$str);
	$str=str_replace("У","02",$str);
	$str=str_replace("К","03",$str);
	$str=str_replace("Е","04",$str);
	$str=str_replace("Н","05",$str);
	$str=str_replace("Г","06",$str);
	$str=str_replace("Ш","07",$str);
	$str=str_replace("Щ","08",$str);
	$str=str_replace("З","09",$str);
	$str=str_replace("Х","32",$str);
	$str=str_replace("Ъ","10",$str);
	$str=str_replace("Ё","11",$str);
	$str=str_replace("Ф","12",$str);
	$str=str_replace("Ы","13",$str);
	$str=str_replace("В","14",$str);
	$str=str_replace("А","15",$str);
	$str=str_replace("П","16",$str);
	$str=str_replace("Р","17",$str);
	$str=str_replace("О","18",$str);
	$str=str_replace("Л","19",$str);
	$str=str_replace("Д","20",$str);
	$str=str_replace("Ж","21",$str);
	$str=str_replace("Э","22",$str);
	$str=str_replace("Я","23",$str);
	$str=str_replace("Ч","24",$str);
	$str=str_replace("С","25",$str);
	$str=str_replace("М","26",$str);
	$str=str_replace("И","27",$str);
	$str=str_replace("Т","28",$str);
	$str=str_replace("Ь","29",$str);
	$str=str_replace("Б","30",$str);
	$str=str_replace("Ю","31",$str);
	$str=str_replace(" ","_",$str);
	return $str;
}



function stripWhitespaces($string) {
  $old_string = $string;
  $string = strip_tags($string);
  $string = preg_replace('/([^\pL\pN\pP\pS\pZ])|([\xC2\xA0])/u', ' ', $string);
  $string = str_replace('  ',' ', $string);
  $string = trim($string);
  
  if ($string === $old_string) {
    return $string;
  } else {
    return stripWhitespaces($string); 
  }  
}


function generate_password() {

	$chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
	$max=10; 
	$size=StrLen($chars)-1; 
	$password=null; 
	while($max--) 
    $password.=$chars[rand(0,$size)];
	return $password;
}


function readExelFile($filepath){
 require_once($_SERVER['DOCUMENT_ROOT'].'/PHPExcel.php'); //подключаем наш фреймворк
$ar=array(); /// инициализируем массив
$inputFileType = PHPExcel_IOFactory::identify($filepath);  // узнаем тип файла, excel может хранить файлы в разных форматах, xls, xlsx и другие
 $objReader = PHPExcel_IOFactory::createReader($inputFileType); // создаем объект для чтения файла
 $objPHPExcel = $objReader->load($filepath); // загружаем данные файла в объект
 $ar = $objPHPExcel->getActiveSheet()->toArray(); // выгружаем данные из объекта в массив
return $ar; //возвращаем массив
 }



function check_interval($data,$data1,$data2) {
////дату на массив
$arr=explode(".",$data);
$arr1=explode(".",$data1);
$arr2=explode(".",$data2);

if(($arr[0]>=$arr1[0] and $arr[0]<=$arr2[0]) and $arr[1]=$arr1[1] and $arr[1]=$arr2[1]  and $arr[2]=$arr1[2] and $arr[2]=$arr2[2]) return true; else return false;
}

/*
send_mail_from_gmail("markviktor2018@gmail.com","Помогите нам пожалуйста!","Содержание сообщения о помощи",array($_SERVER["DOCUMENT_ROOT"]."/files/result_file_240749b3a29eb25ed2071ee25e29d2c21585561811_1570288090.jpg",$_SERVER["DOCUMENT_ROOT"]."/files/photo_33081a4fdccc7b0b28485421260790c71585488804_1568640599.jpg"));
*/
function send_mail_from_gmail($email, $subject, $msg, $files=array()) {
	
	$files=serialize($files);
	
	$curl = curl_init();
	
		    curl_setopt($curl, CURLOPT_URL, 'https://kcppk.kz/classes/send_mail.php');
			///curl_setopt($curl, CURLOPT_PORT, 8000);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_POSTFIELDS, "to=$email&tema=".$subject."&message=".$msg."&files=$files");
			
			$out = curl_exec($curl);
			
			//////echo "to=$email&tema=".$subject."&message=".$msg."&files=$files";
		
			curl_close($curl);
	
		return $out;
}


function send_mail($email, $subject, $msg, $file='',$email_from="register@alpachini.com")
    {   
		if(is_array($file)) {
		$boundary=time();
        foreach ($file as $key => $value) {
           $fp = fopen($value, "r");
           $ffile = fread($fp, filesize($value));
           $message_part .= "--$boundary\n";
           $message_part .= "Content-Type: application/octet-stream\n";
           $message_part .= "Content-Transfer-Encoding: base64\n";
           $message_part .= "Content-Disposition: attachment; filename=\"".basename($value)."\"\n\n";
           $message_part .= chunk_split(base64_encode($ffile)) . "\n";
        }
        $multipart .= $message_part . "--$boundary--\n";
		}

		
			$curl = curl_init();
		    curl_setopt($curl, CURLOPT_URL, 'http://alpachini.com/send_email.php');
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_POSTFIELDS, "to=$email&tema=".urlencode($subject)."&message=".urlencode($msg)."&email_from=$email_from");
			
			$out = curl_exec($curl);
		
		curl_close($curl);
		/*
		$header = "From: $email_from\r\n";
		$header .= "Reply-To: $email_from\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
		mail($email, urlencode($subject), urlencode($msg), $header);
		*/	

    }
	
function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}
	
function email_check($email) {
if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i",trim($email)))
{
return false;
}
else return true;
}

function gen_uniq_id() {
	return md5(uniqid())."-".md5(time())."-".uniqid()."-".uniqid();
}

function myUrlEncode($string) {
    $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
    $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
    return str_replace($entities, $replacements, urlencode($string));
}
	
?>
