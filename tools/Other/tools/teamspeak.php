<?php get_header(); ?>
<?
/*
3	Single Post Template: Teamspeak
4	Description: This part is optional, but helpful for describing the Post Template
5	*/

			//print("usesssss:<pre>");
			//print_r($user);
			//print("</pre>");
if ( is_user_logged_in() ) {
	?>

	<a name="start_here"></a>
	<div id="page-body">
		<div class="navbar">
			<div class="inner"><span class="corners-top"><span></span></span>
				<table width="500" border="0" align="center" cellpadding="5" cellspacing="0">
					<tr><h2>Teamspeak Status</h2></tr>
					<tr> 
						<?php 
						require_once("/var/www/html/colourblindnerd.com/Live/wp-content/uploads/CheckService/tsstatus.php"); 
						$tsstatus = new TSStatus("colourblindnerd.com", 10011, 1); 
						$tsstatus->imagePath = "http://colourblindnerd.com/wp-content/uploads/CheckService/img/"; 
						$tsstatus->showNicknameBox = true; 
						$tsstatus->showPasswordBox = false; 
						$tsstatus->decodeUTF8 = true; 
						$tsstatus->timeout = 10; 
						$tsstatus->setLoginPassword("serveradmin", "zrzarV3y"); 
						echo $tsstatus->render(); 
						?>
					</tr>
				</table>
				the URL: fadetodarkness.com
				<br>
				Username: for now, whatever you like but im trying to link it with the forum!
				<br>
				PAssword: f4d32d4rkn3ss1
			</div>
		</div>
	</div>
</div>

<?php 
} else {
	the_content();
}
get_footer(); ?>