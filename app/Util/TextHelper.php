<?php namespace App\Util;

class TextHelper
{
	public static function esc($item, $fields)
	{
		$outItem = $item;
		foreach ($fields as $field) {
			$value = $outItem->{ $field };
			$value = str_replace(PHP_EOL . "<p>", PHP_EOL, $value);
			$value = str_replace("<p>", PHP_EOL, $value);
			$value = str_replace("<br>" . PHP_EOL, PHP_EOL, $value);
			$outItem->{ $field } = $value;
		}
		return $outItem;
	}

	public static function unesc($item, $fields)
	{
		$outItem = $item;
		foreach ($fields as $field) {
			$value = $outItem->{ $field };
			$value = str_replace(PHP_EOL, "<br>" . PHP_EOL, $value);
			$outItem->{ $field } = $value;
		}
		return $outItem;
	}

	public static function russain_clear($str) {
		$str = str_replace("й","00", $str);
		$str = str_replace("ц","01", $str);
		$str = str_replace("у","02", $str);
		$str = str_replace("к","03", $str);
		$str = str_replace("е","04", $str);
		$str = str_replace("н","05", $str);
		$str = str_replace("г","06", $str);
		$str = str_replace("ш","07", $str);
		$str = str_replace("щ","08", $str);
		$str = str_replace("з","09", $str);
		$str = str_replace("х","32", $str);
		$str = str_replace("ъ","10", $str);
		$str = str_replace("ё","11", $str);
		$str = str_replace("ф","12", $str);
		$str = str_replace("ы","13", $str);
		$str = str_replace("в","14", $str);
		$str = str_replace("а","15", $str);
		$str = str_replace("п","16", $str);
		$str = str_replace("р","17", $str);
		$str = str_replace("о","18", $str);
		$str = str_replace("л","19", $str);
		$str = str_replace("д","20", $str);
		$str = str_replace("ж","21", $str);
		$str = str_replace("э","22", $str);
		$str = str_replace("я","23", $str);
		$str = str_replace("ч","24", $str);
		$str = str_replace("с","25", $str);
		$str = str_replace("м","26", $str);
		$str = str_replace("и","27", $str);
		$str = str_replace("т","28", $str);
		$str = str_replace("ь","29", $str);
		$str = str_replace("б","30", $str);
		$str = str_replace("ю","31", $str);

		$str = str_replace("й","00", $str);
		$str = str_replace("Й","01", $str);
		$str = str_replace("Ц","01", $str);
		$str = str_replace("У","02", $str);
		$str = str_replace("К","03", $str);
		$str = str_replace("Е","04", $str);
		$str = str_replace("Н","05", $str);
		$str = str_replace("Г","06", $str);
		$str = str_replace("Ш","07", $str);
		$str = str_replace("Щ","08", $str);
		$str = str_replace("З","09", $str);
		$str = str_replace("Х","32", $str);
		$str = str_replace("Ъ","10", $str);
		$str = str_replace("Ё","11", $str);
		$str = str_replace("Ф","12", $str);
		$str = str_replace("Ы","13", $str);
		$str = str_replace("В","14", $str);
		$str = str_replace("А","15", $str);
		$str = str_replace("П","16", $str);
		$str = str_replace("Р","17", $str);
		$str = str_replace("О","18", $str);
		$str = str_replace("Л","19", $str);
		$str = str_replace("Д","20", $str);
		$str = str_replace("Ж","21", $str);
		$str = str_replace("Э","22", $str);
		$str = str_replace("Я","23", $str);
		$str = str_replace("Ч","24", $str);
		$str = str_replace("С","25", $str);
		$str = str_replace("М","26", $str);
		$str = str_replace("И","27", $str);
		$str = str_replace("Т","28", $str);
		$str = str_replace("Ь","29", $str);
		$str = str_replace("Б","30", $str);
		$str = str_replace("Ю","31", $str);
		$str = str_replace(" ","_", $str);
		return $str;
	}
}
