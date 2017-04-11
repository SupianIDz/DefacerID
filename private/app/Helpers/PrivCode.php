<?php

if(!function_exists('getStr')) {
	function getStr($string,$start,$end){
		$string = str_replace("\n", '', $string);
		$string = str_replace("\t", '', $string);
		$str    = explode($start,$string,2);
    	$str    = explode($end,$str[1],2);
    	return $str[0];
	}
}

if(!function_exists('inStr')) {
	function inStr($string, $keys){
    	$string = strtoupper($string);
    	
    	if(!is_array($keys)){
    		$keys = array($keys);
    	}

    	for($i = 0; $i < count($keys); $i++){
    		
    	}

    	foreach ($keys as $key) {
    		if(strpos(($string), strtoupper($key)) !== false){
    			return true;
    		}
    	}

    	return false;
	}
}

if(!function_exists('ip')) {
	function ip($fp) {
   		rewind($fp);
    	$str = fread($fp, 8192);
    	$regex = '/\b\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\b/';
    	if (preg_match_all($regex, $str, $matches)) {
        	return array_unique($matches[0]);  // Array([0] => 74.125.45.100 [2] => 208.69.36.231)
    	}
       	return false;
	}
}

if(!function_exists('server')) {
	function server($response){
		preg_match_all('/(^|\r\n\r\n)(HTTP\/)/', $response, $matches, PREG_OFFSET_CAPTURE);
        $x =  preg_split("/\r?\n/", substr($response, $matches[2][count($matches[2]) - 1][1], strpos($response, "\r\n\r\n", $matches[2][count($matches[2]) - 1][1]) - $matches[2][count($matches[2]) - 1][1]));
        preg_match('|^Server:\s+(.+)|',$x[2], $y);

		$servers = array('Apache', 'Nginx', 'Litespeed', 'Lighttpd', 'Cloudflare', 'Microsoft', 'ATS');
		foreach ($servers as $server) {
			if(inStr($y[1], $server)){
				return $server;
			}
		}
		return 'Unknown';
	}
}

if(!function_exists('important')) {
	function important($domain){
		$gov = array('.go', '.mil');
		if(inStr($domain, $gov)){
			return true;
		}
		return false;
	}
}

if(!function_exists('home')){
	function home($path){
		$main = array("", '/', '/index.php', '/index.html', '/index.htm');
		foreach ($main as $value) {
			if($path == $value){
				return true;
			}
		}
		return false;
	}
}

if(!function_exists('defaced')){
	function defaced($response){
		$arrayHacked = array('Accept By Priv Code','Hacked','H4cked','H4ck3d','Hack3d','Owned','0wned','Own3d','0wn3d','Pwn3d','Tusboled','Tusb0led','Stamped','St4mped','Laughed','Laugh3d','Greetz','Gr33tz','Shoot','Shootz','Sh00t','Zone-H','Lulz');

        if(inStr($response, $arrayHacked)){
            return true;
        }

        return false;
	}
}