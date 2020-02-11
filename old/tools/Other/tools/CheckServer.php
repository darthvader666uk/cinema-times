<?php 

get_header(); 
/*
Template Name: Server
*/

			//print("usesssss:<pre>");
			//print_r($user);
			//print("</pre>");
if ( is_user_logged_in() ) {
	$res = null;
	$err = null;
	exec("uptime", $res, $err);

	$uptime = explode(",", $res['0']);
	if(count($uptime)==6){
		$serverup = $uptime[0];
		$usercount = $uptime[2];
		$loadstring = $uptime[3];
	}else{
		$serverup = $uptime[0];
		$usercount = $uptime[1];
		$loadstring = $uptime[2];
	}
	$load = explode(": ", $loadstring);
	$load = $load[1];

	$res = null;
	$err = null;
	exec("/sbin/service httpd status", $res, $err);
	if(preg_match("/running.../", $res['0'])){
		$apachestatus = "1";
	}else{
		$apachestatus = "0";
	}

	$res = null;
	$err = null;
	exec("/sbin/service crond status", $res, $err);
	if(preg_match("/running.../", $res['0'])){
		$cronstatus = "1";
	}else{
		$cronstatus = "0";
	}

	function getmicrotime(){ 
		list($usec, $sec) = explode(" ",microtime()); 
		return ((float)$usec + (float)$sec); 
	} 

	$res = null;
	$err = null;
	exec("ps -ef | grep php  | grep -v grep | wc -l", $res, $err);
	$phpprocesses = $res[0];



	$res = null;
	$err = null;
	exec("ps -ef | grep mysql  | grep -v grep | wc -l", $res, $err);
	$mysqlprocesses = $res[0];

	$res = null;
	$err = null;
	exec("ps -ef | grep apache  | grep -v grep | wc -l", $res, $err);
	$apacheprocesses = $res[0];
	if($apacheprocesses>0){
		$apachestatus = "1";
	}

	$res = null;
	$err = null;
	exec("ps -ef | grep crond  | grep -v grep | wc -l", $res, $err);
	$cronprocesses = $res[0];

	$res = null;
	$err = null;
	exec("ps -ef | grep rsync  | grep -v grep | wc -l", $res, $err);
	$rsyncprocesses = $res[0];


	$res = null;
	$err = null;
	exec("ps -ef | wc -l", $res, $err);
	$totalprocesses = $res[0];


	$res = null;
	$err = null;
	exec("mysqladmin -uroot -psTu4rT321 proc stat | grep Uptime", $res, $err);
	$mysqlprocstat = $res;

	preg_match_all('([0-9.]+)', $mysqlprocstat[0], $mysqlprocstatarr1);
	preg_match_all('([A-Za-z :]+)', $mysqlprocstat[0], $mysqlprocstatarr2);

	for($a=0;$a<count($mysqlprocstatarr1[0]);$a++){
		if($mysqlprocstatarr2[0][$a] == "  Threads: "){
			$Threads = $mysqlprocstatarr1[0][$a];
		}
	}

    //slow queries per second, avg
	$mysqlslowquery = number_format((($mysqlprocstatarr1[0][3])/($mysqlprocstatarr1[0][2] / $mysqlprocstatarr1[0][7])), 2);

    //check disk space
	$res = null;
	$err = null;
	exec("df -h | grep %", $res, $err);
	$arrDiskSpaces = $res;

	//explode the disk space
	$arrDiskSpacesExplode = explode(" ",$arrDiskSpaces['1']);

	$arrDiskSpacestatus = "Size: ".$arrDiskSpacesExplode['23']." - Used: ".$arrDiskSpacesExplode['25']." - Available: ".$arrDiskSpacesExplode['28']." - Used: ".$arrDiskSpacesExplode['31'];

	?>

	<div id="wrap">
		<div id="page-header">
			<div class="headerbar">
				<div class="inner">
					<div id="site-description">
						<table width="500" border="0" align="center" cellpadding="5" cellspacing="0">
							<tr><h2>Server Status</h2></tr>
							<tr> 
								<td nowrap>Server Load:</td>
								<td><? print $load; ?></td>
								<td nowrap>mySQL Threads:</td>
								<td><? print $Threads; ?></td>
							</tr> 
							<tr> 
								<td nowrap>Total Processes:</td>
								<td><? print $totalprocesses; ?></td>
								<td nowrap>PHP Processes:</td>
								<td><? print $phpprocesses; ?></td>
							</tr> 
							<tr> 
								<td nowrap>Apache Processes:</td>
								<td><? print $apacheprocesses; ?></td>
							</tr> 
						</table>
					</div>
				</div>

			</div>
		</div>
	</div>

	<?php 
}else {
	the_content();
}
get_footer(); ?>