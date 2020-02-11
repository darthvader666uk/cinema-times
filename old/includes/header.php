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
		/**
		 * Set error reporting
		 */
		error_reporting(E_ALL & ~E_NOTICE);
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

		//clear old files
		removeFilesEveryWeek();

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
