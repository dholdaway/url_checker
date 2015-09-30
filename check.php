<?php

	function get_all_redirects ($url) {
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		curl_setopt($ch, CURLOPT_URL, $url);
		$out = curl_exec($ch);
		
		$out = str_replace("\r", "", $out);
		
		$headers_end = strpos($out, "\n\n");
		if( $headers_end !== false ) { 
			$out = substr($out, 0, $headers_end);
		}   
		
		$headers = explode("\n", $out);
		
		foreach($headers as $header) {
			if( substr($header, 0, 10) == "Location: " ) { 
				$target = substr($header, 10);
				
				return "$target";
			}   
		}   
		
		return false;
	}
	
	function check ($url) {
		$urls = [];
		while (get_all_redirects ($url) != false) {
			$url = get_all_redirects ($url);
			array_push($urls, $url);
		}
		return $urls;
	}

	$myURL = $_POST['urlToCheck'];
	$r = check($myURL);
	echo implode ( '; ', $r);
?>