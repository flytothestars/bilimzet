<?php
namespace App\Http\Controllers\Admin;

class connect_db {
   public $state="";
   public $i="";
   public $dbo=null;
   
   function __construct() {
   try {
		require("./config_2.php");
		////подключение к базе
		$conn=DB_DRIVER.":host=".DB_HOSTNAME.";dbname=".DB_DATABASE;
		$db=new \PDO($conn,DB_USERNAME,DB_PASSWORD);
		$db->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
		$this->dbo=$db;
		$db->exec("set character set ".DB_CHARACTER);
		$db->exec("set character_set_client=".DB_CHARACTER);
		$db->exec("set character_set_results=".DB_CHARACTER);
		$result=$db->exec("set collation_connection=".DB_COLLATION);
		$this->state="connected";
	} catch(PDOException $e) {
	////ошибка доступа к базе ланных
	$this->state="";
	////логируем ошибку
	echo $e->getMessage();
	}
   }
   
   function __destruct() {
	$this->sbo=null;
   }
}


class db_error {
   ///ошибка базы данных, записываем в файл
   function __construct($error) {
   ///создаем файл-ошибку
   file_put_contents("./db_erros/db_error_".date("d_m_Y_H_i_s",time()),$error, FILE_APPEND | LOCK_EX);
   }
}

class log {
		private $dbos;
		private $state;
   ////лог действий пользователей
      function __construct() {
     $db=new connect_db();
	 if($db->state=="connected") {
	   $this->dbos=$db;
	   ///чистим логи?
	   
	   
	   } 
	}
	
	function add($action) {
	if($this->dbos->state=="connected") {
	///вставляем лог в базу данных
	$action=$this->dbos->dbo->quote($action);
	///смотрим что за пользователь
	if($_SESSION['id_user']=="") $user="1"; else $user=$_SESSION['id_user'];
	///получаем ip, данные браузера, дату и время
	$ip=$_SERVER['REMOTE_ADDR'];
	$browser=$_SERVER['HTTP_USER_AGENT'];
	$data=date("d.m.Y H:i:s",time());
	$sql="INSERT INTO log(id_user,action,data,ip,http_client,timestamp) values('$user',$action,'$data','$ip','$browser','".time()."')";
	$this->dbos->dbo->exec($sql);
	}
	}
}


class profiles {
		private $dbos;
		private $state;
   
   function __construct() {
     $db=new connect_db();
	 if($db->state=="connected") 
	   {
			$this->dbos=$db;
	   } 
	}
	
	public static function chromeVersion($version) {
        return rand($version['min'], $version['max']) . '.0.' . rand(1000, 4000) . '.' . rand(100, 400);
    }

    public static function firefoxVersion($version) {
        return rand($version['min'], $version['max']) . '.' . rand(0, 9);
    }
	
	public static function gen_user_agent($os,$browser,$arch) {
		
		//замена для оС
		if(strpos($os,"Windows XP")>-1) $windows_code="Windows NT 5.1";
		if(strpos($os,"Windows 7")>-1) $windows_code="Windows NT 6.1";
		if(strpos($os,"Windows 8")>-1) $windows_code="Windows NT 6.2";
		if(strpos($os,"Windows 8.1")>-1) $windows_code="Windows NT 6.3";
		if(strpos($os,"Windows 10")>-1) $windows_code="Windows NT 10.0";
		
		if($arch=="x64") {
			$windows_code=$windows_code."; Win64; x64";
		}
		
		if(stripos($browser,'chrome')>-1) {
			
            return 'Mozilla/5.0 (' . $windows_code . ') AppleWebKit/' . (rand(1, 100) > 50 ? rand(533, 537) : rand(600, 603)) . '.' . rand(1, 50) . ' (KHTML, like Gecko) Chrome/' . self::chromeVersion([ 'min' => 47,'max' => 55 ]) . ' Safari/' . (rand(1, 100) > 50 ? rand(533, 537) : rand(600, 603));
			
        } elseif(stripos($browser,'firefox')>-1) {
            
            return 'Mozilla/5.0 (' . $windows_code . ') Gecko/' . (rand(1, 100) > 30 ? '20100101' : '20130401') . ' Firefox/' . self::firefoxVersion([ 'min' => 45,'max' => 74 ]);
			
        } elseif(stripos($browser,'explorer')>-1 || stripos($browser,'edge')>=-1) {
			
            return 'Mozilla / 5.0 (compatible; MSIE ' . ($int = rand(7, 11)) . '.0; ' . $windows_code . ' Trident / ' . ($int == 7 || $int == 8 ? '4' : ($int == 9 ? '5' : ($int == 10 ? '6' : '7'))) . '.0)';
			
        }
		
	}
	
	function add($user_id,$name,$browser,$cache_file,$lang,$base_ip,$windows_version,$windows_name,$system_arch,$cpu,$ram,$screen_size,$display_device,$cache_file_crc,$user_agent,$host,$account,$account_password,$profile_checked) {
		if($this->dbos->state=="connected") {
			
			if($browser=="") $browser="Chrome";
			
			///генерация user-agent-a в зависимости от наших данных
			if($user_agent=="") {
				
				$user_agent=self::gen_user_agent($windows_name,$browser,$system_arch);
				
				$user_agent=$this->dbos->dbo->quote("(blocked,unpaid_version)");
			} else {
				$user_agent=$this->dbos->dbo->quote("(blocked,unpaid_version)");
			}
			
			///экранировка данных
			$user_id=$this->dbos->dbo->quote($user_id);
			$name=$this->dbos->dbo->quote($name);
			$browser=$this->dbos->dbo->quote($browser);
			$cache_file=$this->dbos->dbo->quote($cache_file);
			
			$lang=$this->dbos->dbo->quote($lang);
			
			$windows_version=$this->dbos->dbo->quote($windows_version);
			$windows_name=$this->dbos->dbo->quote($windows_name);
			$system_arch=$this->dbos->dbo->quote($system_arch);
			$cpu=$this->dbos->dbo->quote($cpu);
			$ram=$this->dbos->dbo->quote($ram);
			$screen_size=$this->dbos->dbo->quote($screen_size);
			$display_device=$this->dbos->dbo->quote($display_device);
			$cache_file_crc=$this->dbos->dbo->quote($cache_file_crc);
			
			$host=$this->dbos->dbo->quote($host);
			$account=$this->dbos->dbo->quote($account);
			$account_password=$this->dbos->dbo->quote($account_password);
			if($profile_checked=="0") $profile_checked=""; else $profile_checked=time();
			$profile_checked=$this->dbos->dbo->quote($profile_checked);
			
			//определяем код страны
			$ip2location_json=json_decode(file_get_contents("https://api.ipgeolocation.io/ipgeo?apiKey=".apiKey."&ip=$base_ip"));
			
			$country_code=$ip2location_json->country_code2;
			$country_code=$this->dbos->dbo->quote($country_code);
			
			$base_ip=$this->dbos->dbo->quote($base_ip);
			
			$sql="INSERT INTO user_profiles(user_id,name,browser,cache_file,user_agent,lang,base_ip,windows_version,windows_name,system_arch,cpu,ram,screen_size,display_device,data_add,cache_file_crc,country_code,host,account,account_password,checked) values($user_id,$name,$browser,$cache_file,$user_agent,$lang,$base_ip,$windows_version,$windows_name,$system_arch,$cpu,$ram,$screen_size,$display_device,'".time()."',$cache_file_crc,$country_code,$host,$account,$account_password,$profile_checked)";


			$this->dbos->dbo->exec($sql);
	
		
		///получаем последний вставленный ид
		$profile_id=$this->dbos->dbo->lastInsertId();
		
		$result->result="success";
		$result->profile_id=$profile_id;
		
		return json_encode($result);
		
		}
	}
	
	function edit($profile_id,$name,$browser,$cache_file,$lang,$base_ip,$windows_version,$windows_name,$system_arch,$cpu,$ram,$screen_size,$display_device,$cache_file_crc,$user_agent,$host,$account,$account_password,$profile_checked) {
		if($this->dbos->state=="connected") {
			
			if($browser=="") $browser="Chrome";
			
			///генерация user-agent-a в зависимости от наших данных
			if($user_agent=="") {
				
				$user_agent=self::gen_user_agent($windows_name,$browser,$system_arch);
				$user_agent=$this->dbos->dbo->quote("(blocked,unpaid_version)");
			} else {
				$user_agent=$this->dbos->dbo->quote("(blocked,unpaid_version)");
			}
			
			///экранировка данных
			$profile_id=$this->dbos->dbo->quote($profile_id);
			$name=$this->dbos->dbo->quote($name);
			$browser=$this->dbos->dbo->quote($browser);
			
			
			$lang=$this->dbos->dbo->quote($lang);
			$windows_version=$this->dbos->dbo->quote($windows_version);
			$windows_name=$this->dbos->dbo->quote($windows_name);
			$system_arch=$this->dbos->dbo->quote($system_arch);
			$cpu=$this->dbos->dbo->quote($cpu);
			$ram=$this->dbos->dbo->quote($ram);
			$screen_size=$this->dbos->dbo->quote($screen_size);
			$display_device=$this->dbos->dbo->quote($display_device);
			$cache_file_crc=$this->dbos->dbo->quote($cache_file_crc);
			
			$host=$this->dbos->dbo->quote($host);
			$account=$this->dbos->dbo->quote($account);
			$account_password=$this->dbos->dbo->quote($account_password);
			if($profile_checked=="0") $profile_checked=""; else $profile_checked=time();
			$profile_checked=$this->dbos->dbo->quote($profile_checked);
			
			//определяем код страны
			$ip2location_json=json_decode(file_get_contents("https://api.ipgeolocation.io/ipgeo?apiKey=".apiKey."&ip=$base_ip"));
			
			///var_dump("https://api.ipgeolocation.io/ipgeo?apiKey=".apiKey."&ip=$base_ip");
			
			$country_code=$ip2location_json->country_code2;
			$country_code=$this->dbos->dbo->quote($country_code);
			
			$base_ip=$this->dbos->dbo->quote($base_ip);
			

			$sql="UPDATE user_profiles set name=$name,browser=$browser,user_agent=$user_agent,lang=$lang,base_ip=$base_ip,windows_version=$windows_version,windows_name=$windows_name,system_arch=$system_arch,cpu=$cpu,ram=$ram,screen_size=$screen_size,display_device=$display_device,cache_file_crc=$cache_file_crc,country_code=$country_code,host=$host,account=$account,account_password=$account_password,checked=$profile_checked where id=$profile_id";
			
			$this->dbos->dbo->exec($sql);
			
			if($cache_file!="") {
				$cache_file=$this->dbos->dbo->quote($cache_file);
				$sql="UPDATE user_profiles set cache_file=$cache_file where id=$profile_id";
				$this->dbos->dbo->exec($sql);
			}
			
	
		
		$result->result="success";
		
		return json_encode($result);
		
		}
	}
	
	function get_data($profile_id) {
		
		if($this->dbos->state=="connected") {
		
			$profile_id=$this->dbos->dbo->quote($profile_id);
		
			$sql="SELECT id,user_id,name,browser,cache_file,user_agent,lang,base_ip,windows_version,windows_name,system_arch,cpu,ram,screen_size,display_device,data_add,cache_file_crc,country_code,host,account,account_password,checked from user_profiles where id=$profile_id";
				foreach ($this->dbos->dbo->query($sql) as $row){
						$profile_id=$row[0];
						$user_id=$row[1];
						$name=$row[2];
						$browser=$row[3];
						$cache_file=$row[4];
						$user_agent=$row[5];
						$lang=$row[6];
						$base_ip=$row[7];
						$windows_version=$row[8];
						$windows_name=$row[9];
						$system_arch=$row[10];
						$cpu=$row[11];
						$ram=$row[12];
						$screen_size=$row[13];
						$display_device=$row[14];
						$data_add=$row[15];
						$cache_file_crc=$row[16];
						$country_code=$row[17];
						$host=$row[18];
						$account=$row[19];
						$account_password=$row[20];
						$checked=$row[21];
					}
			
			if($user_id!="") {

				$result->result="success";
				$result->profile_id=$profile_id;
				$result->user_id=$user_id;
				$result->name=$name;
				$result->browser=$browser;
				$result->cache_file=$cache_file;
				$result->user_agent=$user_agent;
				$result->lang=$lang;
				$result->base_ip=$base_ip;
				$result->windows_version=$windows_version;
				$result->windows_name=$windows_name;
				$result->system_arch=$system_arch;
				$result->cpu=$cpu;
				$result->ram=$ram;
				$result->screen_size=$screen_size;
				$result->display_device=$display_device;
				$result->data_add=$data_add;
				$result->cache_file_crc=$cache_file_crc;
				$result->country_code=$country_code;
				$result->host=$host;
				$result->account=$account;
				$result->account_password=$account_password;
				$result->checked=$checked;
				

			} else {
				
				$result->result="not_found";
			}
			
			return json_encode($result);
		
		}
	}
	
	function get_random_data() {
		
		if($this->dbos->state=="connected") {
		
			unset($browsers);
			unset($langs);
			unset($windows_versions);
			unset($windows_names);
			unset($system_archs);
			unset($cpus);
			unset($rams);
			unset($screen_sizes);
			unset($base_ips);
		
			$sql="SELECT id,user_id,name,browser,cache_file,user_agent,lang,base_ip,windows_version,windows_name,system_arch,cpu,ram,screen_size,display_device,data_add,cache_file_crc,country_code from user_profiles";
				foreach ($this->dbos->dbo->query($sql) as $row){
						$profile_id=$row[0];
						$user_id=$row[1];
						$name=$row[2];
						$browser=$row[3];
						$cache_file=$row[4];
						$user_agent=$row[5];
						$lang=$row[6];
						$base_ip=$row[7];
						$windows_version=$row[8];
						$windows_name=$row[9];
						$system_arch=$row[10];
						$cpu=$row[11];
						$ram=$row[12];
						$screen_size=$row[13];
						$display_device=$row[14];
						$data_add=$row[15];
						$cache_file_crc=$row[16];
						$country_code=$row[17];
						
						$browsers[]=$browser;
						$langs[]=$lang;
						$windows_versions[]=$windows_version;
						$windows_names[]=$windows_name;
						$system_archs[]=$system_arch;
						$cpus[]=$cpu;
						$rams[]=$ram;
						$screen_sizes[]=$screen_size;
						$base_ips[]=$base_ip;
					}
					
			///случайная генерация
			
				$result->result="success";
				
				$rand_pos=mt_rand(0,count($browsers)-1);
				$result->browser=$browsers[$rand_pos];
				
				$rand_pos=mt_rand(0,count($langs)-1);
				$result->lang=$langs[$rand_pos];
				
				$rand_pos=mt_rand(0,count($base_ips)-1);
				$result->base_ip=$base_ips[$rand_pos];
				
				$rand_pos=mt_rand(0,count($windows_versions)-1);
				$result->windows_version=$windows_versions[$rand_pos];
				$result->windows_name=$windows_names[$rand_pos];
				
				$rand_pos=mt_rand(0,count($system_archs)-1);
				$result->system_arch=$system_archs[$rand_pos];
				
				$rand_pos=mt_rand(0,count($cpus)-1);
				$result->cpu=$cpus[$rand_pos];
				
				$rand_pos=mt_rand(0,count($rams)-1);
				$result->ram=$rams[$rand_pos];
				
				$rand_pos=mt_rand(0,count($screen_sizes)-1);
				$result->screen_size=$screen_sizes[$rand_pos];
				
				$rand_pos=mt_rand(0,count($base_ips)-1);
				$result->base_ip=$base_ips[$rand_pos];
				
				
				
			
			return json_encode($result);
		
		}
		
	}
	
	
		function get_mac_random_data() {
		
		if($this->dbos->state=="connected") {
		
			unset($browsers);
			unset($langs);
			unset($windows_versions);
			unset($windows_names);
			unset($system_archs);
			unset($cpus);
			unset($rams);
			unset($screen_sizes);
			unset($base_ips);
			unset($mac_os_useragents);
		
			$sql="SELECT id,user_id,name,browser,cache_file,user_agent,lang,base_ip,windows_version,windows_name,system_arch,cpu,ram,screen_size,display_device,data_add,cache_file_crc,country_code from user_profiles";
				foreach ($this->dbos->dbo->query($sql) as $row){
						$profile_id=$row[0];
						$user_id=$row[1];
						$name=$row[2];
						$browser=$row[3];
						$cache_file=$row[4];
						$user_agent=$row[5];
						$lang=$row[6];
						$base_ip=$row[7];
						$windows_version=$row[8];
						$windows_name=$row[9];
						$system_arch=$row[10];
						$cpu=$row[11];
						$ram=$row[12];
						$screen_size=$row[13];
						$display_device=$row[14];
						$data_add=$row[15];
						$cache_file_crc=$row[16];
						$country_code=$row[17];
						
						$browsers[]=$browser;
						$langs[]=$lang;
						$windows_versions[]=$windows_version;
						$windows_names[]=$windows_name;
						$system_archs[]=$system_arch;
						$cpus[]=$cpu;
						$rams[]=$ram;
						$screen_sizes[]=$screen_size;
						$base_ips[]=$base_ip;
					}
					
			///список случайных юзерагентов
			
				$sql="SELECT naim from mac_os_useragents";
				foreach ($this->dbos->dbo->query($sql) as $row){
						$mac_naim=$row[0];
						
						$mac_os_useragents[]=$mac_naim;
						
					}
					
			///случайная генерация
			
				$result->result="success";
				
				$rand_pos=mt_rand(0,count($browsers)-1);
				$result->browser=$browsers[$rand_pos];
				
				$rand_pos=mt_rand(0,count($langs)-1);
				$result->lang=$langs[$rand_pos];
				
				$rand_pos=mt_rand(0,count($base_ips)-1);
				$result->base_ip=$base_ips[$rand_pos];
				
				$rand_pos=mt_rand(0,count($windows_versions)-1);
				$result->windows_version="Mac OS X";
				$result->windows_name="Mac OS X";
				
				$rand_pos=mt_rand(0,count($system_archs)-1);
				$result->system_arch=$system_archs[$rand_pos];
				
				$rand_pos=mt_rand(0,count($cpus)-1);
				$result->cpu=$cpus[$rand_pos];
				
				$rand_pos=mt_rand(0,count($rams)-1);
				$result->ram=$rams[$rand_pos];
				
				$rand_pos=mt_rand(0,count($screen_sizes)-1);
				$result->screen_size=$screen_sizes[$rand_pos];
				
				$rand_pos=mt_rand(0,count($mac_os_useragents)-1);
				$result->user_agent=$mac_os_useragents[$rand_pos];
				
				
				
			
			return json_encode($result);
		
		}
		
	}
	
	
	function get_autofill_data() {
		
		if($this->dbos->state=="connected") {
		
			unset($browsers);
			unset($langs);
			unset($windows_versions);
			unset($windows_names);
			unset($system_archs);
			unset($cpus);
			unset($rams);
			unset($screen_sizes);
			unset($base_ips);
			
		
			$sql="SELECT id,user_id,name,browser,cache_file,user_agent,lang,base_ip,windows_version,windows_name,system_arch,cpu,ram,screen_size,display_device,data_add,cache_file_crc,country_code,host,account,account_password from user_profiles";
				foreach ($this->dbos->dbo->query($sql) as $row){
						$profile_id=$row[0];
						$user_id=$row[1];
						$name=$row[2];
						$browser=$row[3];
						$cache_file=$row[4];
						$user_agent=$row[5];
						$lang=$row[6];
						$base_ip=$row[7];
						$windows_version=$row[8];
						$windows_name=$row[9];
						$system_arch=$row[10];
						$cpu=$row[11];
						$ram=$row[12];
						$screen_size=$row[13];
						$display_device=$row[14];
						$data_add=$row[15];
						$cache_file_crc=$row[16];
						$country_code=$row[17];
						$host=$row[18];
						$account=$row[19];
						$account_password=$row[20];
						
						if(!in_array($browser,$browsers)) $browsers[]=$browser;
						if(!in_array($lang,$langs)) $langs[]=$lang;
						if(!in_array($windows_version,$windows_versions)) $windows_versions[]=$windows_version;
						if(!in_array($windows_name,$windows_names)) $windows_names[]=$windows_name;
						if(!in_array($system_arch,$system_archs)) $system_archs[]=$system_arch;
						if(!in_array($cpu,$cpus)) $cpus[]=$cpu;
						if(!in_array($ram,$rams)) $rams[]=$ram;
						if(!in_array($screen_size,$screen_sizes)) $screen_sizes[]=$screen_size;
						if(!in_array($base_ip,$base_ips)) $base_ips[]=$base_ip;
					}
					
			///случайная генерация
			
				$result->result="success";
				
				$result->browser=$browsers;
				$result->lang=$langs;
				$result->windows_version=$windows_versions;
				$result->windows_name=$windows_names;
				$result->system_arch=$system_archs;
				$result->cpu=$cpus;
				$result->ram=$rams;
				$result->screen_size=$screen_sizes;
				$result->base_ip=$base_ips;
				
				
			return json_encode($result);
		
		}
		
	}
	
	
	function get_all($user_id) {
		
		
		if($this->dbos->state=="connected") {
		
			$user_id=$this->dbos->dbo->quote($user_id);
			
			unset($full_result);
			unset($list_profiles);
		
			$sql="SELECT id,user_id,name,browser,cache_file,user_agent,lang,base_ip,windows_version,windows_name,system_arch,cpu,ram,screen_size,display_device,data_add,cache_file_crc,country_code,host,account,account_password,checked from user_profiles where user_id=$user_id and del=''";
				foreach ($this->dbos->dbo->query($sql) as $row){
						$profile_id=$row[0];
						$user_id=$row[1];
						$name=$row[2];
						$browser=$row[3];
						$cache_file=$row[4];
						$user_agent=$row[5];
						$lang=$row[6];
						$base_ip=$row[7];
						$windows_version=$row[8];
						$windows_name=$row[9];
						$system_arch=$row[10];
						$cpu=$row[11];
						$ram=$row[12];
						$screen_size=$row[13];
						$display_device=$row[14];
						$data_add=$row[15];
						$cache_file_crc=$row[16];
						$country_code=$row[17];
						$host=$row[18];
						$account=$row[19];
						$account_password=$row[20];
						$checked=$row[21];
						
						$last_usage=date("d.m.Y H:i:s",$last_usage);
						$data_add=date("d.m.Y H:i:s",$data_add);
				
				unset($result);				
			
				$result->profile_id=$profile_id;
				$result->user_id=$user_id;
				$result->name=$name;
				$result->browser=$browser;
				$result->cache_file=$cache_file;
				$result->user_agent=$user_agent;
				$result->lang=$lang;
				$result->base_ip=$base_ip;
				$result->windows_version=$windows_version;
				$result->windows_name=$windows_name;
				$result->system_arch=$system_arch;
				$result->cpu=$cpu;
				$result->ram=$ram;
				$result->screen_size=$screen_size;
				$result->display_device=$display_device;
				$result->data_add=$data_add;
				$result->cache_file_crc=$cache_file_crc;
				$result->country_code=$country_code;
				$result->host=$host;
				$result->account=$account;
				$result->account_password=$account_password;
				$result->checked=$checked;
				
				$list_profiles[]=$result;
			
			}
			
			$full_result->result="success";
			$full_result->list_profiles=$list_profiles;
			
			return json_encode($full_result);
		
		}
		
	}
	
	
	function del($profile_id) {
		
		if($this->dbos->state=="connected") {
		
			$profile_id=$this->dbos->dbo->quote($profile_id);
			
			$sql="UPDATE user_profiles set del='".time()."' where id=$profile_id";
			$this->dbos->dbo->exec($sql);
			
			$full_result->result="success";
			
			return json_encode($full_result);
		}
	}
	
	
		function get_count($user_id) {
			if($this->dbos->state=="connected") {
			
				$user_id=$this->dbos->dbo->quote($user_id);
		
				$count=0;
		
				$sql="SELECT count(id) from user_profiles where user_id=$user_id and del=''";
					foreach ($this->dbos->dbo->query($sql) as $row){
							$count=$row[0]*1;
					}
		
				return $count;
			}
		}
		
	
	function update_cache($profile_id,$cache_file) {
		if($this->dbos->state=="connected") {
			
		
			$profile_id=$this->dbos->dbo->quote($profile_id);
			$cache_file=$this->dbos->dbo->quote($cache_file);
			

			$sql="UPDATE user_profiles set cache_file=$cache_file where id=$profile_id";

			$this->dbos->dbo->exec($sql);
	
		
			$result->result="success";
		
			return json_encode($result);
		
		}
	}
	
	
	function update_check($profile_id) {
		if($this->dbos->state=="connected") {
			
		
			$profile_id=$this->dbos->dbo->quote($profile_id);
			
			

			$sql="UPDATE user_profiles set checked='".time()."' where id=$profile_id";

			$this->dbos->dbo->exec($sql);
	
		
			$result->result="success";
		
			return json_encode($result);
		
		}
	}
	
	
}


class get_repositary_profit {
		private $dbos;
		private $state;
   ////лог действий пользователей
      function __construct() {
			 $db=new connect_db();
			 if($db->state=="connected") {
			   $this->dbos=$db;
			   ///чистим логи?
			   
			   
			   } 
			}
			
	////////для репозитария лаунчера
				function full_size_to_del($current_repo_id) {
					if($this->dbos->state=="connected") {
							
									////получаем выбранного обновленния и считаем все актуальные файлы для него.
						$sql="SELECT version from list_updates where id='$current_repo_id'";
						foreach ($this->dbos->dbo->query($sql) as $row){
							$current_update_number=$row[0];
						}
							
						
						unset($full_list_files);
						unset($repo_files);
						unset($sizes);
						$first_repo="";

						$sql="SELECT id,version from list_updates order by version asc";
						foreach ($this->dbos->dbo->query($sql) as $row){
							$id_update=$row[0];
							$version=$row[1];
							
							if($first_repo=="") $first_repo=$version;

							if($version<=$current_update_number) {
								
								////получаем все файлы, которые к этому обновлени.
								$sql_file="SELECT id,server_name,local_name,size,zip_size from update_files where update_id='$id_update'";
								foreach ($this->dbos->dbo->query($sql_file) as $row_file){
									$id_file=$row_file[0];
									$server_name=$row_file[1];
									$local_name=$row_file[2];
									$size=$row_file[3];
									$zip_size=$row_file[4];
									
									if($zip_size!="") $size=$zip_size;
									
									$repo_files[$local_name]=$id_file;
									$sizes[$local_name]=$size;
									
									////полный список файлов
									$full_list_files[$id_file]=$size;
								}
											
								
							}
							
						}


						///подсчет общего размера
						foreach($sizes as $sz) {
							$total_size=$total_size+$sz;
						}
						
						////полный список файлов построили, а теперь посмотрим какие файлы туда не вошли
						unset($except_list_files);
						
						foreach($full_list_files as $id_file=>$size_file) {
							
							$exist=0;
							
							foreach($repo_files as $local_name=>$id_file_ex) {
								if($id_file_ex==$id_file) { $exist=1;  }
							}
							
							///файл в обновление не вошел, добавляем его на удаление
							if($exist==0) $except_list_files[$id_file]=$size_file;
						}
						
						
						///будут удалены только эти файлы- так как они уже повторяются и больше не нжуны
						//echo "<pre>";
						//var_dump($except_list_files);
						//echo "</pre>";
						
						////считаем общий размер файлов, которые будут удалены
						$size_to_del=0;
						foreach($except_list_files as $size_del) {
							$size_to_del=$size_to_del+$size_del;
						}
				
				return $size_to_del;
				
				///$sql="INSERT INTO log(id_user,action,data,ip,http_client,timestamp) values('$user',$action,'$data','$ip','$browser','".time()."')";
				////$this->dbos->dbo->exec($sql);
		}
	}
	
	//////для репозитария игры
	function full_size_to_del_game_repo($current_repo_id) {
					if($this->dbos->state=="connected") {
							
									////получаем выбранного обновленния и считаем все актуальные файлы для него.
						$sql="SELECT version from list_games_updates where id='$current_repo_id'";
						foreach ($this->dbos->dbo->query($sql) as $row){
							$current_update_number=$row[0];
						}
							
						
						unset($full_list_files);
						unset($repo_files);
						unset($sizes);
						$first_repo="";

						$sql="SELECT id,version from list_games_updates order by version asc";
						foreach ($this->dbos->dbo->query($sql) as $row){
							$id_update=$row[0];
							$version=$row[1];
							
							if($first_repo=="") $first_repo=$version;

							if($version<=$current_update_number) {
								
								////получаем все файлы, которые к этому обновлени.
								$sql_file="SELECT id,server_name,local_name,size,zip_size from update_games_files where update_id='$id_update'";
								foreach ($this->dbos->dbo->query($sql_file) as $row_file){
									$id_file=$row_file[0];
									$server_name=$row_file[1];
									$local_name=$row_file[2];
									$size=$row_file[3];
									$zip_size=$row_file[4];
									
									if($zip_size!="") $size=$zip_size;
									
									$repo_files[$local_name]=$id_file;
									$sizes[$local_name]=$size;
									
									////полный список файлов
									$full_list_files[$id_file]=$size;
								}
											
								
							}
							
						}


						///подсчет общего размера
						foreach($sizes as $sz) {
							$total_size=$total_size+$sz;
						}
						
						////полный список файлов построили, а теперь посмотрим какие файлы туда не вошли
						unset($except_list_files);
						
						foreach($full_list_files as $id_file=>$size_file) {
							
							$exist=0;
							
							foreach($repo_files as $local_name=>$id_file_ex) {
								if($id_file_ex==$id_file) { $exist=1;  }
							}
							
							///файл в обновление не вошел, добавляем его на удаление
							if($exist==0) $except_list_files[$id_file]=$size_file;
						}
						
						
						///будут удалены только эти файлы- так как они уже повторяются и больше не нжуны
						//echo "<pre>";
						//var_dump($except_list_files);
						//echo "</pre>";
						
						////считаем общий размер файлов, которые будут удалены
						$size_to_del=0;
						foreach($except_list_files as $size_del) {
							$size_to_del=$size_to_del+$size_del;
						}
				
				return $size_to_del;
				
				///$sql="INSERT INTO log(id_user,action,data,ip,http_client,timestamp) values('$user',$action,'$data','$ip','$browser','".time()."')";
				////$this->dbos->dbo->exec($sql);
		}
	}
	

}


class permissions {
		private $dbos;
		private $state;
   ////лог действий пользователей
      function __construct() {
     $db=new connect_db();
	 if($db->state=="connected") {
	   $this->dbos=$db;
	   ///
	  
	   
	   } 
	}
	
	function check($code,$id_user=0) {
	if($this->dbos->state=="connected") {
	///проверяем рзрешение на это действие
	$code=$this->dbos->dbo->quote($code);
	///смотрим что за пользователь
	
	if($id_user==0) {
		if($_SESSION['id_user']=="") $user="0"; else $user=$_SESSION['id_user'];
	} else {
		$user=$id_user;
	}
	
		$is_access=0;
		//////запрос к базе
		 $sql="SELECT is_access from access_list where id_user=$user and id_role in (SELECT id from roles where code=$code)";
			foreach ($this->dbos->dbo->query($sql) as $row){
				$is_access=$row[0];
				}
		if($is_access!=0) return true; else return false;
	
	}
	}
}



class backup {
		private $dbos;
		private $dump_dir="";
		private $dump_name="";
		
		
	function __construct() {
		////берем данные из настроек и смотрим, когда бекапитсяъ
		  $db=new connect_db();
		if($db->state=="connected") 
		{ 
		$this->dbos=$db;
		$this->dump_dir="backup";
		$this->dump_name=date("d-m-Y-h-i-s",time()).".sql";
		  ///если надо - делаем бекап
		$sett=$this->dbos->dbo->query("SELECT period_backup,last_backup,period_del_backup from settings where id=1")->fetch(PDO::FETCH_BOTH);
	    $period_backup=$sett[0]*1;
	    $last_backup=$sett[1]*1;
	    $period_del_backup=$sett[2]*1;
		if($period_del_backup==0) $period_del_backup=2592000;
		if((time()-$last_backup)>=$period_backup) $this->make();
		////теперь удаляем старые бэкапы
		$files=scandir($this->dump_dir);
		$cnt_files=count($files);
		foreach($files as $fl) {
		if($fl!="." and $fl!="..") {
			if((filemtime($this->dump_dir."/".$fl))<=time()-$period_del_backup) unlink($this->dump_dir."/".$fl);
		}
		}		
		}
	}
	
	function make() {
	if($this->dbos->state=="connected") {
	////принудительный бэкап базы данных
		$insert_records = 50; //записей в одном INSERT
		$gzip = true; 		//упаковать файл дампа
		$stream = false;		//вывод файла в поток

		$fp = fopen( $this->dump_dir."/".$this->dump_name, "w" );
		foreach ($this->dbos->dbo->query("SHOW TABLES") as $table){
				
		$query="";
			if ($fp)
			{
				///$res1 = mysql_query("SHOW CREATE TABLE ".$table[0]);
				$res1=$this->dbos->dbo->query("SHOW CREATE TABLE ".$table[0]);
				$row1=$res1->fetch(PDO::FETCH_BOTH);
				$query="\nDROP TABLE IF EXISTS ".$table[0].";\n".$row1[1].";\n";
				fwrite($fp, $query); $query="";
				////получаем число записей в таблице
					foreach ($this->dbos->dbo->query('SELECT count(*) FROM `'.$table[0].'`') as $count_row){
					$count=$count_row[0];
					}
				if($count>0){
				$query_ins = "\nINSERT INTO `".$table[0]."` VALUES ";
				fwrite($fp, $query_ins);
				$i=1;
				foreach ($this->dbos->dbo->query('SELECT * FROM `'.$table[0].'`') as $row){
				$query="";
					foreach ( $row as $field )
					{
						if ( is_null($field) )$field = "NULL";
						else $field = $this->dbos->dbo->quote( $field );
						if ( $query == "" ) $query = $field;
						else $query = $query.', '.$field;
					}
					if($i>$insert_records){
									$query_ins = ";\nINSERT INTO `".$table[0]."` VALUES ";
									fwrite($fp, $query_ins);
									$i=1;
									}
					if($i==1){$q="(".$query.")";}else $q=",(".$query.")";
					fwrite($fp, $q); $i++;
				}
				fwrite($fp, ";\n");
			}
			}
		} 
		
		fclose ($fp);

		if($gzip||$stream){ $data=file_get_contents($this->dump_dir."/".$this->dump_name);
		$ofdot="";
		if($gzip){
			$data = gzencode($data, 9);
			unlink($this->dump_dir."/".$this->dump_name);
			$ofdot=".gz";
		}

		if($stream){
				header('Content-Disposition: attachment; filename='.$this->dump_name.$ofdot);
				if($gzip) header('Content-type: application/x-gzip'); else header('Content-type: text/plain');
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
				header("Pragma: public");
				echo $data;
		}else{
				$fp = fopen($this->dump_dir."/".$this->dump_name.$ofdot, "w");
				fwrite($fp, $data);
				fclose($fp);
			}
		}
	////отмечаем о том, что мы сделали бэкап в базу
	$this->dbos->dbo->exec("UPDATE settings set last_backup='".time()."'");
	}
	}
}

	


class keys {
   ////генерация уникального ключа пользователя
		private $dbos;
		private $state;
		private $key_dir="";
		private $ley_name="";
   ////лог действий пользователей
      function __construct() {
     $db=new connect_db();
	 if($db->state=="connected") {
	   $this->dbos=$db;
	   $this->key_dir="user_keys";
	   $this->key_name=md5(time()).".key";
	   } 
	}


	function set_key($login_user) {
	if($this->dbos->state=="connected") {

	////генерация ключа
	$key=md5(md5($login_user).time().md5($login_user)).md5(md5($login_user).md5($login_user).time());

	///вставляем лог в базу данных
	$key=$this->dbos->dbo->quote($key);
	$login_user=$this->dbos->dbo->quote($login_user);
	$sql="UPDATE users set key_value=$key where login=$login_user";
	$this->dbos->dbo->exec($sql);
	}
	}


	function get_key($login_user) {
	if($this->dbos->state=="connected") {
	$login_user=$this->dbos->dbo->quote($login_user);
		$sql="SELECT key_value,login from users where login=$login_user";
			foreach ($this->dbos->dbo->query($sql) as $row){
				$key=$row[0];
				$login=$row[1];
				}
	////сохранение его в файл
		$fp = fopen($this->key_dir."/$login"."_".$this->key_name, "w");
		fwrite($fp, $key);
		fclose($fp);
		return $this->key_dir."/$login"."_".$this->key_name;
	}
	}
}
		





class balance {
   ////генерация уникального ключа пользователя
		private $dbos;
		private $state;
		private $balance_naim;
   ////лог действий пользователей
      function __construct() {
     $db=new connect_db();
	 if($db->state=="connected") {
	   $this->dbos=$db;

		////получение наименование баланса
		$sql="SELECT balance_naim from settings where id=1";
				foreach ($this->dbos->dbo->query($sql) as $row){
					$balance_naim=$row[0];
				}
		$this->balance_naim=$balance_naim;
	   } 
	}


	/////запрос баланса
	function get_balance($id_user,$type='') {
	if($this->dbos->state=="connected") {
		$id_user=$this->dbos->dbo->quote($id_user);
		$balance=0;

		if($type=='')   $sql="SELECT current from balance where id_user=$id_user";
		if($type=='vk') $sql="SELECT current from balance where id_user in (SELECT id from users where social_id=$id_user)";

				foreach ($this->dbos->dbo->query($sql) as $row){
				$balance=$row[0]*1;
				}
		return $balance.$this->balance_naim;

	}
	}


	/////пополнение баланса
	function add_balance($summa,$id_user,$prichina,$type='') {
	if($this->dbos->state=="connected") {
		$id_user=$this->dbos->dbo->quote($id_user);
		$summa=$summa*1;

		///а есть ли такая запись о балансе с этим пользователем?
		if($type=='')   $sql="SELECT id,history from balance where id_user=$id_user";
		if($type=='vk') $sql="SELECT id,history from balance where id_user in (SELECT id from users where social_id=$id_user)";

				foreach ($this->dbos->dbo->query($sql) as $row){
					$id_balance=$row[0];
					$history=$row[1];
				}

		if($id_balance*1==0) {
			////такого пользователя еще нет в таблице, добавляем
		if($type=='') $sql="INSERT INTO balance(id_user) values($id_user)";
		if($type=='vk') $sql="INSERT INTO balance(id_user) values((SELECT id from users where social_id=$id_user LIMIT 0,1))";
		$this->dbos->dbo->exec($sql);
		} else {

			if($history!="") $history=unserialize($history);
		}


		////пополняем баланс
		if($type=='')   $sql="UPDATE balance set current=current+$summa where id_user=$id_user";
		if($type=='vk') $sql="UPDATE balance set current=current+$summa where id_user in (SELECT id from users where social_id=$id_user)";
		$this->dbos->dbo->exec($sql);
		////заносим запись в историю
		
		///начинаем историю движения денежных средств
		$history[time()]="На ваш счет внесено $summa".$this->balance_naim." $prichina";
		$history=serialize($history);
		$history=$this->dbos->dbo->quote($history);

		if($type=='')   $sql="UPDATE balance set history=$history where id_user=$id_user";
		if($type=='vk') $sql="UPDATE balance set history=$history where id_user in (SELECT id from users where social_id=$id_user)";
		$this->dbos->dbo->exec($sql);

	}
	}


	/////пополнение баланса
	function minus_balance($summa,$id_user,$prichina,$type='') {
	if($this->dbos->state=="connected") {
		$id_user=$this->dbos->dbo->quote($id_user);
		$summa=$summa*1;
		///а есть ли такая запись о балансе с этим пользователем?
		if($type=='')   $sql="SELECT id,history from balance where id_user=$id_user";
		if($type=='vk') $sql="SELECT id,history from balance where id_user in (SELECT id from users where social_id=$id_user)";

				foreach ($this->dbos->dbo->query($sql) as $row){
					$id_balance=$row[0];
					$history=$row[1];
				}
		if($id_balance*1==0) {
			////такого пользователя еще нет в таблице, добавляем
		if($type=='') $sql="INSERT INTO balance(id_user) values($id_user)";
		if($type=='vk') $sql="INSERT INTO balance(id_user) values((SELECT id from users where social_id=$id_user LIMIT 0,1))";
		$this->dbos->dbo->exec($sql);
		} else {

			if($history!="") $history=unserialize($history);
		}
		
		////получаем текущий баланс пользователя
		if($type=='')   $sql="SELECT id,current from balance where id_user=$id_user";
		if($type=='vk') $sql="SELECT id,current from balance where id_user in (SELECT id from users where social_id=$id_user)";
		
				foreach ($this->dbos->dbo->query($sql) as $row){
					$id_balance=$row[0];
					$current=$row[1]*1;
				}
		/////проверяем, можно ли выполнить данную операцию
		$may_do=false;
		if($current>=$summa) $may_do=true; else $may_do=false;
		if(MINUS_BALANCE==true) $may_do=true;

		if($may_do==true) {
		////снимаем средства
		if($type=='')   $sql="UPDATE balance set current=current-$summa where id_user=$id_user";
		if($type=='vk') $sql="UPDATE balance set current=current-$summa where id_user in (SELECT id from users where social_id=$id_user)";
		$this->dbos->dbo->exec($sql);
		////заносим запись в историю
		
		///начинаем историю движения денежных средств
		$history[time()]="С вашего счета списана сумма ".$summa.$this->balance_naim." $prichina";
		$history=serialize($history);
		$history=$this->dbos->dbo->quote($history);

		if($type=='')   $sql="UPDATE balance set history=$history where id_user=$id_user";
		if($type=='vk') $sql="UPDATE balance set history=$history where id_user in (SELECT id from users where social_id=$id_user)";
		$this->dbos->dbo->exec($sql);
			return "success";
		} else {
			return "error";
		}

	}
	}



	
}

	
	
?>
