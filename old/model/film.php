<?php
	
	class film {
		
		public function getFilms($id,$date){
			$this-removeFilesEveryWeek();//remove films every 7 days
			return $this->generateFilmContent($id,$date);
		}

		private function generateFilmContent($id,$date){
			$trailerTime = 30;

			//the moviesapi API URL
			$getCinemaTimes = $this->getFileContents('http://moviesapi.herokuapp.com/cinemas/'.$id.'/showings/'.$date,null);

			$contents = '';
			$counters = 0;
			foreach($getCinemaTimes as  $key=> $cinemaTimes){

				//get the runtime from Opem IMDB
				$runTimes = $this->getFileContents('http://www.omdbapi.com/?t='.urlencode($cinemaTimes->title).'&y=&plot=short&r=json&tomatoes=true',urlencode($cinemaTimes->title));

				if($counters == 3){
					$contents .= '</div>';
					$counters = 0;
				}

				if($counters == 0){
					$contents .= '<div class="row" >';
				}
				$contents .= '<div class="col-sm-4 col-md-4 col-lg-4">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<a data-toggle="collapse" href="#film'.$key.'">'.$cinemaTimes->title.'</a>
						</div>
						<div id="film'.$key.'" class="panel-collapse collapse">
							<div class="panel-body">
								Runtime: '.$runTimes->Runtime.'
							</div>
							<div class="panel-body">
								IMBD Rating: '.$runTimes->imdbRating.'
								Rotten Tomatoes: '.$runTimes->tomatoMeter.'
							</div>
							<table class="table">
									<thead>
										<tr>
											<th>Start Time</th>
											<th>Finish Time</th>
										</tr>
									</thead>
									<tbody>';
								foreach($cinemaTimes->time as $movieTime){
									$finishTime  = $this->getFinishTimes($runTimes->Runtime,$movieTime,$trailerTime);
									$contents	.= '<tr>
														<td>'.$movieTime.'</td>
														<td>'.$finishTime.'</td>
													</tr>';
								}
				$contents	.= '</tbody>
							</table>
						</div>
					</div>
				</div>';

				$counters++;
			}
			return $contents;
		}

		// TODO: this curl stuff should be extracted to class-curl.php
		//this will get contents and decode json from URL
		private function getFileContents($url,$cacheFileName){
		$results = array();
		// Check if the file exists
		if (!file_exists($cacheFileName)) {
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
			file_put_contents(ROOT.'/tmp/'.$cacheFileName.'.tmp', ROOT.'/tmp/'.$contents.'.tmp');

			// Decode the results.
			$results = json_decode($contents);
		} else {
		  // Load the results directly from cache.
		  $results = json_decode(file_get_contents(ROOT.'/tmp/'.$cacheFileName.'.tmp'));
		}

		return $results;
		}

		//this will get the finish time for the film
		private function getFinishTimes($runtime, $movieTime,$trailerTime) {
			
			$time 			= $runtime+$trailerTime;
			$Hour 			= $time / 60;
			$explodeTime 	= explode(".",$Hour);

			if(!isset($explodeTime[1])){
				$remainMins = "0.".substr($explodeTime[0],0,2);
			}else{
				$remainMins = "0.".substr($explodeTime[1],0,2);
			}

			$Min = explode(".",$remainMins * 60);

			//get rough  time of film star and end
			$splitMovieTime = explode(":",$movieTime);
			$startime 		= $splitMovieTime['0'].":".$splitMovieTime['1'].":00";
			$duration 		= $explodeTime[0].":".str_pad($Min[0],2, "0", STR_PAD_LEFT).":00";
			$aryDeparture 	= explode(":", $startime);
			$aryDuration 	= explode(":", $duration);
			$timeDeparture 	= mktime($aryDeparture[0], $aryDeparture[1], $aryDeparture[2]);

			$arrive 		= date("H:i:s", strtotime("+" . $aryDuration[0] . " hours +" . $aryDuration[1] . " minutes +" . $aryDuration[2] . " seconds", $timeDeparture));
			return $arrive;
		}

		private function convertToHoursMins($time, $format = '%02d:%02d') {
			if ($time < 1) { return; }

			$hours 		= floor($time / 60);
			$minutes 	= ($time % 60);

			return sprintf($format, $hours, $minutes);
		}
	}

	function removeFilesEveryWeek(){
		$yesterday = strtotime('-1 week');
		if ($handle = opendir(ROOT.'/tmp/')) {
			clearstatcache();
			while (false !== ($file = readdir($handle))) {
		   		if ($file != "." && $file != "..") {
		   			$files[] = $file;
					$index[] = filemtime(ROOT.'/tmp/'.$file);
		   		}
			}
		  	closedir($handle);
		}
			
		asort( @$index );
			
		foreach($index as $i => $t) {
				
			if($t < $yesterday) {
				@unlink(ROOT.'/tmp/'.$files[$i]);
			}
			
		}
	}