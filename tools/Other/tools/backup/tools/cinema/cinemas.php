<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cinema</title>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $(".accordion .accord-header").click(function() {
      if($(this).next("div").is(":visible")){
        $(this).next("div").slideUp("slow");
      } else {
        //$(".accordion .accord-content").slideUp("slow");
        $(this).next("div").slideToggle("slow");
      }
    });
  });
</script>

<style type="text/css">
	.accordion { border: 1px solid #666; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; padding: 1px; width: 500px; }
	.accord-header { background: #EFEFEF; }
	.accord-header:hover { cursor: pointer; }
	.accord-content { display: none; }
	table_Films{
	    table-layout: fixed;
	    width: 1100px;
	}

	table_Nav {
		font-family: sans-serif;
		font-size: 30px;
	}

	#navBar {
		z-index: 1;
		/*position: fixed;*/
		top: 0;
		left: 0;
		width: 100%;
		text-align: center;
		background: #E7E7E7;
		-moz-box-shadow: 10px 10px 10px #ccc;
		-webkit-box-shadow: 10px 10px 10px #ccc;
		-ms-box-shadow: 10px 10px 10px #ccc;
		-o-box-shadow: 10px 10px 10px #ccc;
		box-shadow: 10px 10px 10px #ccc;
	}

	#navBar a {
		display: block;
		color: #000;
		text-decoration: none;
	}

	#navBar a:hover {
		color: #000;
		background: #B9B9B9;
		text-decoration: none;
	}

	#navBar a.selected {
		color: #000;
		background: #B9B9B9;
		text-decoration: none;
	}

</style>
</head>

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
	$_GET['cinema'] = $cinema;
}

//check if there is a date
if(isset($_GET['date'])){
	$date = $_GET['date'];
}else{
	$date = date ('l');
	$_GET['date'] = $date;
}
//id="navBar" class="table_Nav"
?>
<table cellpadding="0px" cellspacing="0px" class="table_Nav" id="navBar">
	<tr>
		<td><a class="selected"><u><strong>Cinema</strong></u></a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><a class="selected"><strong>Cineworld</strong></a></td>
		<td><a <?php echo ($_GET['cinema'] == "CineworldCardiff" ? 'class="selected"' : '');?> href="?cinema=CineworldCardiff&date=<?=$date?>">Cardiff</a></td>
		<td><a <?php echo ($_GET['cinema'] == "CineworldNewportFriars" ? 'class="selected"' : '');?> href="?cinema=CineworldNewportFriars&date=<?=$date?>">Newport Friars Walk</a></td>
		<td><a <?php echo ($_GET['cinema'] == "MaximeBlackwood" ? 'class="selected"' : '');?> href="?cinema=MaximeBlackwood&date=<?=$date?>">Newport Spytty Park</a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><a class="selected"><strong>Odeon</strong></a></td>
		<td><a <?php echo ($_GET['cinema'] == "OdeonBridgend" ? 'class="selected"' : '');?> href="?cinema=OdeonBridgend&date=<?=$date?>">Bridgend</a></td>
		<td><a <?php echo ($_GET['cinema'] == "OdeonCardiff" ? 'class="selected"' : '');?> href="?cinema=OdeonCardiff&date=<?=$date?>">Cardiff</a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><a class="selected"><strong>Vue</strong></a></td>
		<td><a <?php echo ($_GET['cinema'] == "VueMerthyr" ? 'class="selected"' : '');?> href="?cinema=VueMerthyr&date=<?=$date?>">Merthyr</a></td>
		<td><a <?php echo ($_GET['cinema'] == "VueCardiff" ? 'class="selected"' : '');?> href="?cinema=VueCardiff&date=<?=$date?>">Cardiff</a></td>
		<td><a <?php echo ($_GET['cinema'] == "VueSwansea" ? 'class="selected"' : '');?> href="?cinema=VueSwansea&date=<?=$date?>">Swansea</a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td><a class="selected"><strong>Other</strong></a></td>
		<td><a <?php echo ($_GET['cinema'] == "MaximeBlackwood" ? 'class="selected"' : '');?> href="?cinema=MaximeBlackwood&date=<?=$date?>">Maxime - Blackwood</a></td>
		<td><a <?php echo ($_GET['cinema'] == "PremiereCardiff" ? 'class="selected"' : '');?> href="?cinema=PremiereCardiff&date=<?=$date?>">Premiere - Cardiff</a></td>
		<td><a <?php echo ($_GET['cinema'] == "ShowcaseNantgarw" ? 'class="selected"' : '');?> href="?cinema=ShowcaseNantgarw&date=<?=$date?>">Showcase - Nantgarw</a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><a class="selected"><u><strong>Days</strong></u></a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><a <?php echo ($_GET['date'] == "Monday" ? 'class="selected"' : '');?> href="?cinema=<?=$cinema?>&date=Monday">Monday</a></td>
		<td><a <?php echo ($_GET['date'] == "Tuesday" ? 'class="selected"' : '');?>href="?cinema=<?=$cinema?>&date=Tuesday">Tuesday</a></td>
		<td><a <?php echo ($_GET['date'] == "Wednesday" ? 'class="selected"' : '');?>href="?cinema=<?=$cinema?>&date=Wednesday">Wednesday</a></td>
		<td><a <?php echo ($_GET['date'] == "Thursday" ? 'class="selected"' : '');?>href="?cinema=<?=$cinema?>&date=Thursday">Thursday</a></td>
		<td><a <?php echo ($_GET['date'] == "Friday" ? 'class="selected"' : '');?>href="?cinema=<?=$cinema?>&date=Friday">Friday</a></td>
		<td><a <?php echo ($_GET['date'] == "Saturday" ? 'class="selected"' : '');?>href="?cinema=<?=$cinema?>&date=Saturday">Saturday</a></td>
		<td><a <?php echo ($_GET['date'] == "Sunday" ? 'class="selected"' : '');?>href="?cinema=<?=$cinema?>&date=Sunday">Sunday</a></td>
	</tr>
</table>
<hr>
<?php

switch(@$_GET['cinema']){
	case"CineworldCardiff":
		$tid = "3bf1712a861cbb55";
		$cinemaURL = "http://www.cineworld.co.uk/cinemas/";
		$cinemaURL2 = "cardiff";
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
	case"VueMerthyr":
		$tid = "17fb2a385b17ef28";
		$cinemaURL = "http://www.myvue.com/home/cinema/merthyr-tydfil/film";
		$cinemaURL2 = "";
		$directFilm = "Yes";
	break;
	case"VueSwansea":
		$tid = "a4a9c0ef15dadd3a";
		$cinemaURL = "http://www.myvue.com/home/cinema/swansea/film";
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
	case"CineworldNewportFriars":
		$tid = "cbe7647188cf31d0";
		$cinemaURL = "http://www.cineworld.co.uk/cinemas/";
		$cinemaURL2 = "newport-friars-walk";
		$directFilm = "Yes";
	break;
	case"CineworldNewportSpytty":
		$tid = "66825e242a92b9af";
		$cinemaURL = "http://www.cineworld.co.uk/cinemas/";
		$cinemaURL2 = "newport-spytty-park";
		$directFilm = "Yes";
	break;
	default:
		$tid = "3bf1712a861cbb55";
		$cinemaURL = "http://www.cineworld.co.uk/cinemas/";
		$cinemaURL2 = "cardiff";
		$directFilm = "Yes";
}

$url = 'http://www.google.co.uk/movies?near=cardiff,&tid='.$tid.'&date='.$date;

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
$str = curl_exec($curl);
curl_close($curl);

$html = str_get_html($str);

//set trailer time
$trailerTime = 30;
if($html->find('#movie_results .theater')){
	$columns = 2;       // The number of columns you want.
	?>
	<hr />
	<table class="table_Films">
	<?php
	foreach($html->find('#movie_results .theater') as $div) {
		// print theater and address info
		?>
		<tr>
			<td>Google Films URL:</td>
			<td><a href="<?=$url?>" target="_blank"><?=$url?></a></td>
		</tr>
		<tr>
		<td>Meerkat Movies:</td>
			<td><a href="https://your-rewards.comparethemarket.com/" target="_blank">https://your-rewards.comparethemarket.com/</a></td>
		</tr>
		<tr>
			<td>Theate:  <strong><?=$div->find('<h2 class="name"',0)->innertext?></strong></td>
			<td>Approx Trailer Time:  <strong><?=$trailerTime?></strong></td>
		</tr>
		<?php

	    // print all the movies with showtimes
		foreach($div->find('.movie') as $key=> $movie) {
		    // If we've reached the end of a row, close it and start another
		    if(!($key % $columns)) {
		        if($key > 0) {
		            echo "</tr>";       // Close the row above this if it's not the first row
		        }
		        echo "<tr>";    // Start a new row
		    }

			$movieName = strtolower($movie->find('.name a',0)->innertext);
			$movieName = str_replace(" - ","-",$movieName);
			$movieName = str_replace(" ","-",$movieName);
			$movieName = str_replace("&","and",$movieName);
			$movieName = str_replace("amp","",$movieName);
			$movieName = preg_replace("/[^A-Za-z0-9\-]/","",$movieName);
			$movieName = str_replace("and39","",$movieName);

			echo "<td>";
				print '<div class="accordion">';
					print '<div class="accord-header"><h3>'.$movie->find('.name a',0)->innertext.'</h3></div>';
						print '<div class="accord-content">';

							if($directFilm == "Yes"){
								$movieName = "\\".$movieName;
								print "Movie:    <a href=\"".$cinemaURL.$cinemaURL2.$movieName."\" target=\"_blank\">"
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

						print "</div>";
				print "</div>";
			echo "</td>";
		}
	}
	// Close the last row, and the table
	echo "</tr>
	</table>";
}else{
	print "<strong>No Films Today</strong><br>";
}

// clean up memory
$html->clear();
?>
</body>
</html>
<?php
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
