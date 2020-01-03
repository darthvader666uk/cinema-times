<?php
/*****************************************************************************************************
Where the Fun begins!
This is where we call the moviesapi API (https://github.com/nickcharlton/moviesapi - Thanks Nick!)
This will sort through the films to get the times
With Date e.g http://moviesapi.org/cinemas/7505/showings/2016-11-08
 ****************************************************************************************************/
// phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable
//get correct ahowing date
if (date('l') == $date) {
	$ShowingDate = date('Y-m-d');
}else{
	$ShowingDate = date('Y-m-d', strtotime('next '.$date));
}

//the moviesapi API URL
$url = 'http://moviesapi.org/cinemas/'.$venue_id.'/showings/'.$ShowingDate;

$url = 'https://www.cineworld.co.uk/uk/data-api-service/v1/quickbook/10108/film-events/in-cinema/8031/at-date/2020-01-04?attr=&lang=en_GB';

$getCinemaTImes = getFileContents($url,$venue_id.$ShowingDate);

print('URL: '.$url.' <pre>');
// print_r($getCinemaTImes->body->films);
print_r($getCinemaTImes->body->events);
print('</pre>');
die("grrrrrrrrrrrr");
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

							$cinemaTitleConvert = convertTitle($cinemaTimes->title);
							$dates = convertYear($cinemaTimes->title);

							$omdbURL = 'http://www.omdbapi.com/?apikey=fbcc7d5f&t='.urlencode($cinemaTitleConvert).'&y='.$dates.'&plot=short&r=json&tomatoes=true&type=movie';

							//get the runtime from Opem IMDB
							$runTimes = getFileContents($omdbURL,urlencode($cinemaTitleConvert),true);

							// print('<pre>');
							// print('<br> omdbapi URL: '.$omdbURL.'<br>');
							// print_r($cinemaTimes); 
							// print('</pre> ');
							?>
								<table>
									<tr>
										<td>Title: <?=$cinemaTimes->title?></td>
										<td>&nbsp;</td>
										<td>OMDB: <a href="<?=$omdbURL?>" target="_blank"> <?=$cinemaTitleConvert?> </a></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>
											<span style="float: left; margin-right: 15px;">
												<a href="<?=$runTimes->tomatoURL?>" target="_blank">
													<img src="<?=$runTimes->Poster?>" width="170" height="250">
												</a>
											</span>
										</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>Runtime: <?=convertToHoursMins($runTimes->Runtime, '%02d hr %02d')?></td>
										<td>&nbsp;</td>
										<td>Total mins: <strong>(<?=$runTimes->Runtime?>)</strong></td>
									</tr>
									<hr>
									<tr>
										<td>Year: <?=$runTimes->Year?></td>
										<td>IMDB Rating: <?=$runTimes->Ratings[0]->Value?></td>
										<td>Rotten Tomates Rating: <?=$runTimes->Ratings[1]->Value?></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
								</table>
								<hr>
							<?php
							//get each timer for each showing
							foreach($cinemaTimes->time as $movieTime){
								$finishTime = getFinishTimes($runTimes->Runtime,$movieTime,$trailerTime);

								// print("<br>runtime min: ".$runTimes['Mins']." - movieTime: $movieTime - trailerTime: $trailerTime<br>");
								print "Start: ".date('h:i:s a', strtotime($movieTime)).'  -  Finish: '.date('h:i:s a', strtotime($finishTime)).'<br />';
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
	print('URL: '.$url.' <pre>');
print_r($getCinemaTImes);
print('</pre>');
}
// phpcs:enable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable