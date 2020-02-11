<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Cinema Times</a>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">

				<?php
					$allCinemas = serviceManager::get('cinema')->getAllCinema();
					foreach($allCinemas as $cinema => $eachCinema){
						?> 
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=$cinema?> <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<?php
									foreach($eachCinema as $id => $venues){
										?>
										<li><a id="show_days_<?=$cinema?>_<?=$venues?>_<?=$id?>" href="#"><?=$venues?></a></li>
										<?php
									}
								?>
							</ul>
						</li>
						<?php
					}
				?>
			</ul>
			<!-- <ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Username <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">Settings</a></li>
						<li class="divider"></li>
						<li><a href="#">Logout</a></li>
					</ul>
				</li>
			</ul>
			<form class="navbar-form navbar-right search-form" role="search">
					<input type="text" class="form-control" placeholder="Search" />
			</form> -->
		</div><!--/.nav-collapse -->
	</div>
</nav>