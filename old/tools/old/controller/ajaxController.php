<?php
	ob_start();
		$config_dir = __DIR__;
		$config_dir = str_replace('/controller', '', $config_dir);

		define('ROOT', $config_dir);

		require_once(ROOT.'/config/config.php'); 

			$film = $_POST['class'];
			$function = $_POST['function'];
			$var1 = $_POST['var1'];
			$var2 = $_POST['var2'];

			if ('getFilms' == $function) {
				$ajax = serviceManager::get($film)->getFilms($var1,$var2);
			}

	ob_end_clean();
	return print($ajax);
?>