<?php

/**
 * this will get the finish time for the film
 *
 * @param int $runtime
 * @param int $movieTime
 * @param int $trailerTime
 * @return void
 */
function getFinishTimes($runtime, $movieTime,$trailerTime) {
	
				//print('<pre>');
				///print('<br> runtime: ('.$runtime.') - trailerTime: ('.$trailerTime.')<br>');
				//print('</pre>');
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
function getFileContents($url,$cacheFileName,$omdb=null){
	$results = array();
	// Check if the file exists
	if (!file_exists($cacheFileName)) {
		// Initiate curl
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
		file_put_contents(getcwd().'/tmp/'.$cacheFileName.'.tmp', getcwd().'/tmp/'.$contents.'.tmp');

		// Decode the results.
		$results = json_decode($contents);
	} else {
		// Load the results directly from cache.
		$results = json_decode(file_get_contents(getcwd().'/tmp/'.$cacheFileName.'.tmp'));
	}
	
	//Sort out runtime
	$results = sortRuntime($results);

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

function removeFilesEveryWeek($files = array(), $index = array()) {
	$yesterday = strtotime('-1 week');
	if ($handle = opendir(getcwd().'/tmp/')) {
		clearstatcache();
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				$files[] = $file;
				$index[] = filemtime(getcwd().'/tmp/'.$file);
			}
		}
		closedir($handle);
	}
	
	foreach($index as $i => $t) {
			
		if($t < $yesterday) {
            @unlink(getcwd().'/tmp/'.$files[$i]);

            // Set default values
            file_put_contents(getcwd().'/tmp/times.txt', str_replace("TestFilm|100\n", "", file_get_contents(getcwd().'/tmp/times.txt')));
			file_put_contents(getcwd().'/tmp/title.txt', str_replace("TestFilm|TestFilm\n", "", file_get_contents(getcwd().'/tmp/title.txt')));
			file_put_contents(getcwd().'/tmp/year.txt', str_replace("TestFilm|2019\n", "", file_get_contents(getcwd().'/tmp/year.txt')));
		}
		
    }
}

function convertTitle($title){
	// //add custom runtime
	$getConvertTitle = file(getcwd().'/tmp/title.txt', FILE_IGNORE_NEW_LINES);

	// print('<pre>');
	// print('<br> Title: $title<br>');
	// print_r($title);

	foreach($getConvertTitle as $convertTitle){
		$explodeTitle = explode('|',$convertTitle);
		$title = str_replace($explodeTitle['0'],$explodeTitle['1'],$title);
	}



	// print('<br> After Title: $title<br>');
	// print_r($title); 
	// print('</pre> ');

	return $title;
}

function convertYear($title){
	// Get custom year
	$getYear = file(getcwd().'/tmp/year.txt', FILE_IGNORE_NEW_LINES);

	$year = date('Y');

	foreach($getYear as $convertYear){
		$explodeTitle = explode('|',$convertYear);

		// Only add year if there is an override
		if($title == $explodeTitle['0']){

			$year = $explodeTitle['1'];
		}
	}

	return $year;
}

function sortRuntime($results){
	//add custom runtime
	$getCustomRuntimes = file(getcwd().'/tmp/times.txt', FILE_IGNORE_NEW_LINES);

	foreach($getCustomRuntimes as $runTines){
		$explodeTimes = explode('|',$runTines);

		$resTitle = trim(strtolower(str_replace("\0", "", $results->Title)));
        $explodeTitle = trim(strtolower(str_replace("\0", "", $explodeTimes[0])));
        
		switch($resTitle){
			case $explodeTitle:
				// print('<pre>');
				// print('<br> 2 found Times:<br>');
				// print_r($explodeTimes);
				// print('</pre>');
				// Update the time if there isnt one
				if($results->Runtime == "N/A" || $explodeTitle !='' ) {
					$results->Runtime = (int)$explodeTimes[1];
                }
				
				// print("explodeTitle: $explodeTitle - resTitle: $resTitle");
                //Override times if matching title
                if($explodeTitle == $resTitle){
                    $results->Runtime = (int)$explodeTimes[1];
                }
			break;
		}
	}
    // Only show when no Correct times have been updated
    if($results->Runtime == "N/A") {
        print("<br><b></b>Correct Title to use to Add times:");
		print('<pre>');
		var_dump(trim(strtolower(str_replace("\0", "", $results->Title))));
		print('</pre>');
    }
    
	return $results;
}

// Save Times
function saveTimes(){
    if(isset($_POST['field1']) && isset($_POST['field2'])) {
        $data = $_POST['field1'] . '|' . $_POST['field2'] . "\n";
        $ret = file_put_contents(getcwd().'/tmp/times.txt', $data, FILE_APPEND | LOCK_EX);
        if($ret === false) {
            die('There was an error writing this file');
        }
        else {
            echo "$ret bytes saved to file <br>";
			echo file_get_contents(getcwd().'/tmp/times.txt');
			Redirect();
        }
    }
    else {
       die('no post times to process');
    }
}

// Save Time
function removeTimes(){
    if(isset($_POST['field1']) && isset($_POST['field2'])) {
        $data = $_POST['field1'] . '|' . $_POST['field2'] . "\n";
        $ret = file_put_contents(getcwd().'/tmp/times.txt', str_replace($data, "", file_get_contents(getcwd().'/tmp/times.txt')));
        if($ret === false) {
            die('There was an error removing this line');
        }
        else {
            echo "$ret bytes removed from file <br>";
			echo file_get_contents(getcwd().'/tmp/times.txt');
			Redirect();
        }
    }
    else {
       die('no post time to process');
    }
}

// Save Title
function saveTitle(){
    if(isset($_POST['field1']) && isset($_POST['field2'])) {
        $data = $_POST['field1'] . '|' . $_POST['field2'] . "\n";
        $ret = file_put_contents(getcwd().'/tmp/title.txt', $data, FILE_APPEND | LOCK_EX);
        if($ret === false) {
            die('There was an error writing this file');
        }
        else {
            echo "$ret bytes saved to file <br>";
			echo file_get_contents(getcwd().'/tmp/title.txt');
			Redirect();
        }
    }
    else {
       die('no post title to process');
    }
}

// Save Time
function removeTitle(){
    if(isset($_POST['field1']) && isset($_POST['field2'])) {
        $data = $_POST['field1'] . '|' . $_POST['field2'] . "\n";
        $ret = file_put_contents(getcwd().'/tmp/title.txt', str_replace($data, "", file_get_contents(getcwd().'/tmp/title.txt')));
        if($ret === false) {
            die('There was an error removing this line');
        }
        else {
            echo "$ret bytes removed from file <br>";
			echo file_get_contents(getcwd().'/tmp/title.txt');
			Redirect();
        }
    }
    else {
       die('no post time to process');
    }
}

// Save Year
function saveYear(){
    if(isset($_POST['field1']) && isset($_POST['field2'])) {
        $data = $_POST['field1'] . '|' . $_POST['field2'] . "\n";
        $ret = file_put_contents(getcwd().'/tmp/year.txt', $data, FILE_APPEND | LOCK_EX);
        if($ret === false) {
            die('There was an error writing this file');
        }
        else {
            echo "$ret bytes saved to file <br>";
			echo file_get_contents(getcwd().'/tmp/year.txt');
			Redirect();
        }
    }
    else {
       die('no post year to process');
    }
}

// Save Year
function removeYear(){
    if(isset($_POST['field1']) && isset($_POST['field2'])) {
        $data = $_POST['field1'] . '|' . $_POST['field2'] . "\n";
        $ret = file_put_contents(getcwd().'/tmp/year.txt', str_replace($data, "", file_get_contents(getcwd().'/tmp/year.txt')));
        if($ret === false) {
            die('There was an error removing this line');
        }
        else {
            echo "$ret bytes removed from file <br>";
			echo file_get_contents(getcwd().'/tmp/year.txt');
			Redirect();
        }
    }
    else {
       die('no post time to process');
    }
}

function Redirect() {
	flush(); // Flush the buffer
	ob_flush();
	header('Location:: current_page_url');
	die;
}