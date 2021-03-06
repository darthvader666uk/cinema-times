<title>Cinema</title>
<?php 
error_reporting(E_ALL);
ini_set("display_errors", 1);

date_default_timezone_set("Europe/London");
/**
 * Google Showtime grabber
 * This file will grab the last showtimes of theatres nearby your zipcode.
 * Please make the URL your own! You can also add parameters to this URL: 
 * &date=0|1|2|3 => today|1 day|2 days|etc.. 
 * 
 * Please download the latest version of simple_html_dom.php on sourceForge:
 * http://sourceforge.net/projects/simplehtmldom/files/
 */
//require xml convert
require_once('simple_html_dom.php');

//check if there is a cinema
if(isset($_GET['cinema'])){
	$cinema = $_GET['cinema'];
}else{
	$cinema = "CineworldCardiff";
}

//check if there is a date
if(isset($_GET['date'])){
	$date = $_GET['date'];
}else{
	$date = "all";
}

?>
<table>
	<tr>
		<th>Cinema</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>
	</tr>
	<tr>
		<td><a href="?cinema=CineworldCardiff&date=<?=$date?>">Cineworld - Cardiff</a> | </td>
		<td><a href="?cinema=PremiereCardiff&date=<?=$date?>">Premiere - Cardiff</a> | </td>
		<td><a href="?cinema=VueCardiff&date=<?=$date?>">Vue - Cardiff</a> | </td>
		<td><a href="?cinema=OdeonCardiff&date=<?=$date?>">Odeon - Cardiff</a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><a href="?cinema=OdeonBridgend&date=<?=$date?>">Odeon - Bridgend</a> | </td>
		<td><a href="?cinema=ShowcaseNantgarw&date=<?=$date?>">Showcase - Nantgarw</a> | </td>
		<td><a href="?cinema=MaximeBlackwood&date=<?=$date?>">Maxime - Blackwood</a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>
<hr>
<table>
	<tr>
		<td>Days</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><a href="?cinema=<?=$cinema?>&date=Monday">Monday</a></td>
		<td><a href="?cinema=<?=$cinema?>&date=Tuesday">Tuesday</a></td>
		<td><a href="?cinema=<?=$cinema?>&date=Wednesday">Wednesday</a></td>
		<td><a href="?cinema=<?=$cinema?>&date=Thursday">Thursday</a></td>
		<td><a href="?cinema=<?=$cinema?>&date=Friday">Friday</a></td>
		<td><a href="?cinema=<?=$cinema?>&date=Saturday">Saturday</a></td>
		<td><a href="?cinema=<?=$cinema?>&date=Sunday">Sunday</a></td>
	</tr>
</table>
<hr>
<?php

switch(@$_GET['cinema']){
	case"CineworldCardiff":
		$tid = "3bf1712a861cbb55";
		$cinemaURL = "http://www.cineworld.co.uk/whatson/";
		$cinemaURL2 = "?cinema=cardiff&date=all";
		$directFilm = "Yes";
	break;
	case"OdeonBridgend":
		$tid = "bfdff03fc00e6e9c";
		$cinemaURL = "http://www.odeon.co.uk/cinemas/bridgend/70/";
		$cinemaURL2 = "";
		$directFilm = "No";
	break;
	case"PremiereCardiff":
		$tid = "7890b3b3828bb5bf";
		$cinemaURL = "http://cardiff.premierecinemas.co.uk/PremiereCinemasCardiff.dll";
		$cinemaURL2 = "";
		$directFilm = "No";
	break;
	case"VueCardiff":
		$tid = "a2f154261f29340b";
		$cinemaURL = "http://www.myvue.com/latest-movies/info/cinema/cardiff/film/";
		$cinemaURL2 = "";
		$directFilm = "Yes";
	break;
	case"OdeonCardiff":
		$tid = "36279b7e5ae4aa84";
		$cinemaURL = "http://www.odeon.co.uk/cinemas/cardiff/3/";
		$cinemaURL2 = "";
		$directFilm = "No";
	break;
	case"ShowcaseNantgarw":
		$tid = "3d1dcf580e5fd8b2";
		$cinemaURL = "http://www.showcasecinemas.co.uk/films/";
		$cinemaURL2 = "";
		$directFilm = "Yes";
	break;
	case"MaximeBlackwood":
		$tid = "cef17c9113fe47da";
		$cinemaURL = "http://www.blackwoodcinema.co.uk/";
		$cinemaURL2 = "";
		$directFilm = "No";
	break;
	default:
		$tid = "3bf1712a861cbb55";
		$cinemaURL = "http://www.cineworld.co.uk/whatson/";
		$cinemaURL2 = "?cinema=cardiff&date=all";
		$directFilm = "Yes";
}

$url = 'http://www.google.co.uk/movies?near=cardiff,&tid='.$tid.'&date='.$date;

print("Google URL: <a href=\"$url\" target=\"_blank\">$url</a> <hr>");

$curl = curl_init(); 
curl_setopt($curl, CURLOPT_URL, $url);  
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);  
$str = curl_exec($curl);  
curl_close($curl);  

$html = str_get_html($str);

// print("<pre>");
// print_r($html);
// print("</pre>");

//set trailer time
$trailerTime = 30;
if($html->find('#movie_results .theater')){
	print '<pre>';
	foreach($html->find('#movie_results .theater') as $div) {
	    // print theater and address info
		print "Theate:  <strong>".$div->find('<h2 class="name"',0)->innertext."</strong><br>";
		print "Approx Trailer Time:  <strong>".$trailerTime."</strong><br><br>";

	    // print all the movies with showtimes
		foreach($div->find('.movie') as $key=> $movie) {
			$movieName = strtolower($movie->find('.name a',0)->innertext);
			$movieName = str_replace(" - ","-",$movieName);
			$movieName = str_replace(" ","-",$movieName);
			$movieName = str_replace("&","and",$movieName);
			$movieName = str_replace("amp","",$movieName);
			$movieName = preg_replace("/[^A-Za-z0-9\-]/","",$movieName);
			$movieName = str_replace("and39","",$movieName);

			if($directFilm == "Yes"){
				print "Movie:    <a href=\"".$cinemaURL.$movieName.$cinemaURL2."\" target=\"_blank\">"
				."<strong>".$movie->find('.name a',0)->innertext.'</strong></a><br><br>';
			}else{
				print "Movie:    <a href=\"".$cinemaURL.$cinemaURL2."\" target=\"_blank\">"
				."<strong>".$movie->find('.name a',0)->innertext.'</strong></a><br><br>';
			}

			$runTimes = getRunTimes($movie->find('.info',0)->innertext);

			print "Runtime: <u>".$runTimes['Hour']."</u> - <strong>(".$runTimes['Mins'].")</strong></b><br><br>";

			//get move times
			$movieTimes = getMovieTimes($movie->find('.times',0)->innertext);

			foreach($movieTimes as $movieTime){
				$finishTime = getFinishTimes($runTimes['Mins'],$movieTime,$trailerTime);

				// print("<br>runtime min: ".$runTimes['Mins']." - movieTime: $movieTime - trailerTime: $trailerTime<br>");

				print "Start: ".$movieTime.' - Finish: '.$finishTime.'<br />';
			}
			print "<br><hr>";
		}
	}
}else{
	print "<strong>No Films Today</strong><br>";
}

// clean up memory
$html->clear();


//this will get the finish time for the film
function getFinishTimes($runtime, $movieTime,$trailerTime)
{
	$time = $runtime+$trailerTime;
	$Hour = $time / 60;
	$explodeTime = explode(".",$Hour);

	if(!isset($explodeTime[1])){
		$remainMins = "0.".substr($explodeTime[0],0,2);
	}else{
		$remainMins = "0.".substr($explodeTime[1],0,2);
	}
	$Min = explode(".",$remainMins * 60);

   //get rough  time of film star and end
	$splitMovieTime = explode(":",$movieTime);
	$startime = $splitMovieTime['0'].":".$splitMovieTime['1'].":00"; 
	$duration = $explodeTime[0].":".str_pad($Min[0],2, "0", STR_PAD_LEFT).":00";

	$aryDeparture = explode(":", $startime); 
	$aryDuration = explode(":", $duration); 

	$timeDeparture = mktime($aryDeparture[0], $aryDeparture[1], $aryDeparture[2]); 

	$arrive = date("H:i:s", strtotime("+" . $aryDuration[0] . " hours +" . $aryDuration[1] . " minutes +" . $aryDuration[2] . " seconds", $timeDeparture)); 

	return $arrive;
}

//this will bring back a nice array of movie times
function getMovieTimes($movieTimes)
{
	// print("html:".htmlspecialchars($movieTimes));
	// $movieTimes = strip_tags( str_replace( '>', '> ', $movieTimes ));
	// $movieTimes = str_replace("<span style=\"color:#666\"><span style=\"padding:0 \"></span><!--  -->","",$movieTimes);
	// $movieTimes = str_replace("<span style=\"color:#666\"><span style=\"padding:0 \"> &nbsp<!--  -->","",$movieTimes);
	// $movieTimes = str_replace("</span>","",$movieTimes);
	// $movieTimes = str_replace("&nbsp;","",$movieTimes);
	// $movieTimes = str_replace("      ","|",$movieTimes);
	preg_match_all('/<!--  -->([0-9\:]*)/', $movieTimes, $matches);
	// print("<br>html after :");
	// print_r($matches);
	// $movieTimes = explode("|",ltrim($movieTimes));
	return $matches['1'];
}

//this will bring back a nice array of movie times
function getRunTimes($runTimes)
{
	$runTimes = str_replace("&#8206;","",$runTimes);
	$runTimes = explode("-",ltrim($runTimes));
	$runTime = $runTimes['0'];
	$runTimes = str_replace("hr ",":",$runTime);
	$runTimes = str_replace("min","",$runTimes);
	$runTimes = hoursToMinutes($runTimes);

	$runTimer['Hour'] = rtrim($runTime);
	$runTimer['Mins'] = $runTimes;

	return $runTimer;
}

# Transform hours like "1:45" into the total number of minutes, "105".
function hoursToMinutes($hours)
{
	if (strstr($hours, ':')){
		# Split hours and minutes.
		$separatedData = explode(':', $hours);

		$minutesInHours    = $separatedData[0] * 60;
		$minutesInDecimals = $separatedData[1];

		$totalMinutes = $minutesInHours + $minutesInDecimals;
	}
	else
	{
		$totalMinutes = $hours * 60;
	}

	return $totalMinutes;
}

?>