<?php
/*         ~|NICK|~| IDENT |~|         HOST          |
    [0] => :GtoXic!GtoXicznc@admin.topgamearcade.co.cc
    [1] => PRIVMSG
    [2] => #avestri
    [3] => :1
	[4] => 2
	[5] => 3
*/
	$data = fgets($this->sock);
	$data = str_replace(array(chr(10),chr(13)),"",$data);
	$this->disp($data);
	$ex = explode(" ",$data);
	if(isset($ex[1]) && $ex[1] == "PRIVMSG"){
		$info = $ex[0];
		$infoa = explode("!",$info);
		$infob = explode("@",$infoa[1]);
		$nick = substr($info[0],1);
		$ident = $infob[0];
		$host = $infob[1];
		$chan = $ex[2];
		$command = strtolower(substr($ex[3],1));
		switch($command){
			case "~uptime":
				$this->raw("PRIVMSG $chan :Uptime: ".$this->uptime());
				break;
			case "ACTION":
				$this->raw("PRIVMSG $chan :Action");
				break;
		}
	}
	if($ex[0] == "PING"){
		$this->raw("PONG ".$ex[1]);
	}
?>