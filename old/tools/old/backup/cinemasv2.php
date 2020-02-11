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
	<body>
		<?php
		//Set error reporting
		error_reporting(E_ALL);
		ini_set("display_errors", 1);

		//Make sure default time zone is active
		date_default_timezone_set("Europe/London");

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
			$date = date('l');
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
				<td><a <?php echo ($_GET['cinema'] == "CineworldNewportSpytty" ? 'class="selected"' : '');?> href="?cinema=CineworldNewportSpytty&date=<?=$date?>">Newport Spytty Park</a></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><a class="selected"><strong>Odeon</strong></a></td>
				<td><a <?php echo ($_GET['cinema'] == "OdeonBridgend" ? 'class="selected"' : '');?> href="?cinema=OdeonBridgend&date=<?=$date?>">Bridgend</a></td>
				<td><a <?php echo ($_GET['cinema'] == "OdeonCardiff" ? 'class="selected"' : '');?> href="?cinema=OdeonCardiff&date=<?=$date?>">Cardiff</a></td>
				<td><a <?php echo ($_GET['cinema'] == "OdeonSwansea" ? 'class="selected"' : '');?> href="?cinema=OdeonSwansea&date=<?=$date?>">Swansea</a></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><a class="selected"><strong>Vue</strong></a></td>
				<td><a <?php echo ($_GET['cinema'] == "VueMerthyr" ? 'class="selected"' : '');?> href="?cinema=VueMerthyr&date=<?=$date?>">Merthyr</a></td>
				<td><a <?php echo ($_GET['cinema'] == "VueCardiff" ? 'class="selected"' : '');?> href="?cinema=VueCardiff&date=<?=$date?>">Cardiff</a></td>
				<td><a <?php echo ($_GET['cinema'] == "VueSwansea" ? 'class="selected"' : '');?> href="?cinema=VueSwansea&date=<?=$date?>">Swansea</a></td>
				<td><a <?php echo ($_GET['cinema'] == "VueCwmbran" ? 'class="selected"' : '');?> href="?cinema=VueCwmbran&date=<?=$date?>">Cwmbran</a></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td><a class="selected"><strong>Other</strong></a></td>
				<!-- <td><a <?php //echo ($_GET['cinema'] == "MaximeBlackwood" ? 'class="selected"' : '');?> href="?cinema=MaximeBlackwood&date=<?=$date?>">Maxime - Blackwood</a></td> -->
				<td><a <?php echo ($_GET['cinema'] == "PremiereCardiff" ? 'class="selected"' : '');?> href="?cinema=PremiereCardiff&date=<?=$date?>">Premiere - Cardiff</a></td>
				<!-- <td><a <?php //echo ($_GET['cinema'] == "ShowcaseNantgarw" ? 'class="selected"' : '');?> href="?cinema=ShowcaseNantgarw&date=<?=$date?>">Showcase - Nantgarw</a></td> -->
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

		//TODO: Need to sort this switch out as its hard codeded
		//This is where we grab the correct cinema
		switch(@$_GET['cinema']){
			//cardiff
			case"CineworldCardiff":
				$venue_id = "7505";
				$cinemaURL = "http://www.cineworld.co.uk/cinemas/cardiff";
			break;
			case"OdeonCardiff":
				$venue_id = "9418";
				$cinemaURL = "http://www.odeon.co.uk/cinemas/cardiff/3/";
			break;
			case"VueCardiff":
				$venue_id = "9487";
				$cinemaURL = "https://www.myvue.com/cinema/cardiff?SC_CMP=AFF_indtrust";
			break;
			case"PremiereCardiff":
				$venue_id = "9044";
				$cinemaURL = "http://cardiff.premierecinemas.co.uk/PremiereCinemasCardiff.dll";
			break;
			//newport
			case"CineworldNewportFriars":
				$venue_id = "10316";
				$cinemaURL = "http://www.cineworld.co.uk/cinemas/newport-friars-walk";
			break;
			case"CineworldNewportSpytty":
				$venue_id = "10453";
				$cinemaURL = "http://www.cineworld.co.uk/cinemas/newport-spytty-park";
			break;
			//bridgend
			case"OdeonBridgend":
				$venue_id = "9406";
				$cinemaURL = "http://www.odeon.co.uk/cinemas/bridgend/70/";
			break;
			//merthyr
			case"VueMerthyr":
				$venue_id = "9673";
				$cinemaURL = "http://www.myvue.com/home/cinema/merthyr-tydfil/film";
			break;
			//swansea
			case"VueSwansea":
				$venue_id = "9506";
				$cinemaURL = "http://www.myvue.com/home/cinema/swansea/film";
			break;
			case"OdeonSwansea":
				$venue_id = "9390";
				$cinemaURL = "http://www.myvue.com/home/cinema/swansea/film";
			break;
			//caerphilly
			case"ShowcaseNantgarw":
				$venue_id = "3d1dcf580e5fd8b2";
				$cinemaURL = "http://www.showcasecinemas.co.uk/films/";
			break;
			//blackwood
			case"MaximeBlackwood":
				$venue_id = "cef17c9113fe47da";
				$cinemaURL = "http://www.blackwoodcinema.co.uk/";
			break;
			//Cwmbran
			case"VueCwmbran":
				$venue_id = "9674";
				$cinemaURL = "http://www.blackwoodcinema.co.uk/";
			break;
			//default: cardiff
			default:
				$venue_id = "7505";
				$cinemaURL = "http://www.cineworld.co.uk/cinemas/cardiff";
		}

		/*****************************************************************************************************
			Where the Fun begins!
			This is where we call the moviesapi API (https://github.com/nickcharlton/moviesapi - Thanks Nick!)
			This will sort through the films to get the times
			With Date e.g http://moviesapi.herokuapp.com/cinemas/7505/showings/2016-11-08
		 ****************************************************************************************************/

		//get correct ahowing date
		if (date('l') == $date) {
		    $ShowingDate = date('Y-m-d');
		}else{
			$ShowingDate = date('Y-m-d', strtotime('next '.$date));
		}

		//the moviesapi API URL
		$url = 'http://moviesapi.herokuapp.com/cinemas/'.$venue_id.'/showings/'.$ShowingDate;

		$getCinemaTImes = getFileContents($url,$venue_id.$ShowingDate);

		// print('<pre>');
		// print_r($getCinemaTImes);
		// print('</pre>');
		// die();

		//set trailer time
		$trailerTime = 30;
		if(is_array($getCinemaTImes)){

			$columns = 2;       // The number of columns you want.
			?>
			<hr />
			<table class="table_Films">
				<tr>
					<td>Cinema URL:</td>
					<td><a href="<?=$cinemaURL?>" target="_blank"><?=$cinemaURL?></a></td>
				</tr>
				<tr>
					<td>Meerkat Movies:</td>
					<td><a href="https://your-rewards.comparethemarket.com/" target="_blank">https://your-rewards.comparethemarket.com/</a></td>
				</tr>
				<tr>
					<td>Approx Trailer Time:</td>
					<td><strong><?=$trailerTime?></strong> Mins</td>
				</tr>
				<?php

			    // print all the movies with showtimes
				foreach($getCinemaTImes as  $key=> $cinemaTimes) {
				    // If we've reached the end of a row, close it and start another
				    if(!($key % $columns)) {
				        if($key > 0) {
				            echo "</tr>";       // Close the row above this if it's not the first row
				        }
				        echo "<tr>";    // Start a new row
				    }
					echo "<td>";
						print '<div class="accordion">';
							print '<div class="accord-header"><h3>'.$cinemaTimes->title.'</h3></div>';
								print '<div class="accord-content">';
									
									//get the runtime from Opem IMDB
									$runTimes = getFileContents('http://www.omdbapi.com/?t='.urlencode($cinemaTimes->title).'&y='.date('Y').'&plot=short&r=json&tomatoes=true',urlencode($cinemaTimes->title));

									// print('<pre>');
									// print_r($runTimes);
									// print('</pre>');

									?>
										<table>
											<tr>
												<td>Runtime: <?=convertToHoursMins($runTimes->Runtime, '%02d hr %02d')?> - </td>
												<td>Total mins: <strong>(<?=$runTimes->Runtime?>)</strong></td>
											</tr>
											<tr>
												<td>IMDB Rating: <?=$runTimes->imdbRating?> - </td>
												<td>Rotten Tomates Rating: <?=$runTimes->tomatoMeter?>%</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											</tr>
										</table>
									<?php
									//get each timer for each showing
									foreach($cinemaTimes->time as $movieTime){
										$finishTime = getFinishTimes($runTimes->Runtime,$movieTime,$trailerTime);

										// print("<br>runtime min: ".$runTimes['Mins']." - movieTime: $movieTime - trailerTime: $trailerTime<br>");

										print "Start: ".$movieTime.' - Finish: '.$finishTime.'<br />';
									}

								print "</div>";
						print "</div>";
					echo "</td>";
				}
			// Close the last row, and the table
			echo "</tr>
			</table>";
		}else{
			print "<strong>No Films Today</strong><br>";
		}
		?>
		<table class="table_Films">
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Thanks to Nick for letting me use moviesapi API!</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>API Link: <a href="http://moviesapi.herokuapp.com/" target="_blank">http://moviesapi.herokuapp.com/</a></td>
				<td>GitHub Link: <a href="https://github.com/nickcharlton/moviesapi" target="_blank">https://github.com/nickcharlton/moviesapi</a></td>
			</tr>
		</table>
	</body>
</html>
<?php
	//this will get the finish time for the film
	function getFinishTimes($runtime, $movieTime,$trailerTime) {
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

	//this will get contents and decode json from URL
	function getFileContents($url,$cacheFileName){
		// $results = array();
		// // Check if the file exists
		// if (!file_exists($cacheFileName)) {
			//  Initiate curl
			$ch = curl_init();
			// Disable SSL verification
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// Will return the response, if false it print the response
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// Set the url
			curl_setopt($ch, CURLOPT_URL,$url);
			// Execute
			$contents = curl_exec($ch);
			// Closing
			curl_close($ch);

			// Write to the cache file.
			// file_put_contents($cacheFileName, $contents);

			// Decode the results.
			$results = json_decode($contents);
		// } else {
		//   // Load the results directly from cache.
		//   $results = json_decode(file_get_contents($cacheFileName));
		// }

		return $results;
	}

	function convertToHoursMins($time, $format = '%02d:%02d') {
	    if ($time < 1) {
	        return;
	    }
	    $hours = floor($time / 60);
	    $minutes = ($time % 60);
	    return sprintf($format, $hours, $minutes);
	}
?>