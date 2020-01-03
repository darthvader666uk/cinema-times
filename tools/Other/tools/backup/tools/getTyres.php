<?php

include $_SERVER['DOCUMENT_ROOT']."/tools/config.php";
include_once (ROOT ."function-curlPull.php");


	        $url  = "http://www.aberamantyres.co.uk/VRNSearch/Details?VRN=wr04+ryw";
			$vars = "";
	        $page    = curlPull($url, $vars, null, null, null, null, $url);

	       	$url  = "http://www.aberamantyres.co.uk/VRNSearch/Results?width=165&amp;profile=70&amp;rim=14&amp;speed=T&amp;loadindex=81";
			$vars = "";
	        $page    = curlPull($url, $vars, null, null, null, null, $url);
?>