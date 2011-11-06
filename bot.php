<?php
	class Bot{
		var $config;
		var $sock;
		var $starttime;
		function __construct(){
			$this->starttime = time();
			$this->config = parse_ini_file("./config.ini");
			$this->sock = fsockopen($this->config['server'],$this->config['port']);
			$nick = $this->config['nick'];
			$this->raw("NICK $nick");
			$this->raw("USER $nick $nick $nick $nick :$nick");
			$this->raw("JOIN {$this->config['channel']}");
			$this->main();
		}
		function main(){
			if(!feof($this->sock)){
				include("commands.php");
				$this->main();
			}
		}
		function read(){ //DO NOT USE!
			$stdin = fopen("php://stdin", 'r');
			return(fgets($stdin));
		}
		function uptime(){
			$time = time()-$this->starttime;
			$hours = 0;
			$minutes = 0;
			$seconds = $time;
			while($seconds > 60){
				$minutes++;
				$seconds = $seconds - 60;
			}
			while($minutes > 60){
				$hours++;
				$minutes = $minutes - 60;
			}
			$ret = $hours;
			if($hours == 1){
				$ret .= " hour";
			}else{
				$ret .= " hours";
			}
			$ret .= ", ".$minutes;
			if($minutes == 1){
				$ret .= " minute";
			}else{
				$ret .= " minutes";
			}
			$ret .= ", ".$seconds;
			if($seconds == 1){
				$ret .= " second";
			}else{
				$ret .= " seconds";
			}
			$ret .= ".";
			return($ret);
		}
		function raw($data){
			fwrite($this->sock,$data."\r\n");
			$this->disp($data);
		}
		function disp($msg){
			echo("[".date("h:i:s", time())."] $msg\r\n");
		}

	}
	$bot = new Bot();
?>