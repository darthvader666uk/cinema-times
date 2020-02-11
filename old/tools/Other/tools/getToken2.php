<?php

print_r($_GET);

$link = mysql_connect('localhost', 'root', 'sTu4rT321');
if (!$link) {
    die('Could not connect: ' . mysql_error() . '<br>');
}else{
	echo 'Connected successfully<br>';
}


$db_selected = mysql_select_db('ts3db', $link);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error() . '<br>');
}else{
		echo 'Connected DB successfully<br>';
}


srand((double)microtime()*1000000); 
$tkey = substr(md5(rand(0,9999999)),0,20); 

if($_GET['access'] == ""){

	print("Please Specify Access");
	mysql_close($link);

}else{

$tsinsert = "INSERT INTO tokens (server_id, token_key, token_type, token_id1, token_id2) VALUES ('1', '$tkey', '0', '".$_GET['access']."', '0')"; 
$tsdbinsert = mysql_query($tsinsert); 

if($tsdbinsert == "1"){
	print("Token Generated Success");
}else{
	print("Token Generated Fail");
}

mysql_close($link);
}


?>