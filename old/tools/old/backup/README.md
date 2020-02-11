# Cinema Start and end Times for South Wales

This site was setup to show all film start and finish times in order to see which films can be seen without any overlap. Currently it is statically set in South Wales but work is in progress to make it dynamic.

### Prerequisites

You will need to install composer in order to get the correct packages

Install the [composer package manager](https://getcomposer.org/download/)
	* If Using Windows and a Virtual Machine (e.g. Not Insalled WAMP etc.) then use the following guide to use Composer with PHP Binary files:
		*  Download and Setup PHP; see: http://php.net/manual/en/install.windows.php . The rest of these instructions will assume that PHP is installed in C:\Program Files\PHP; if not, then adjust accordingly.
		*  Enable the php-openssl extension - this would usually involve something like editing the files C:\Program Files\PHP\php.ini-development and C:\Program Files\PHP\php.ini-production in a text editor (like Notepad) and remove the semicolon (;) from the line loading the php-openssl extension (it should be extension=php_openssl.dll)
		* Make a copy of C:\Program Files\PHP\php.ini-production and call it C:\Program Files\PHP\php.ini
		* Make PHP Available to Windows:
			Right-click on the Start button (bottom left corner) and go to “System”
			Click on “Advanced system settings”
			Click on “Environment Variables…”
			Under “System variables” scroll down and highlight the variable “Path”
			Click “Edit…”
			Click “New”
			Create a new entry “C:\Program Files\PHP”
			Click “New”
			Create a new entry “C:\PHP”
			Click “OK”
			Under “System variables”, click “New…”
			For “Variable name” put “OPENSSL_CONF”
			For “Variable value” put “C:\Program Files\PHP\extras\ssl\openssl.cnf”
		* Install Visual C++ Redistributable for Visual Studio 2012 Update 4
			Use this link: https://www.microsoft.com/en-us/download/details.aspx?id=30679#
			Download a copy of “vcredist_x64.exe” (or “vcredist_x86.exe” if you’re running x86)
			Run the executable to install the missing .dll files you’ll need for Composer
		* Download and Install Composer
			Simply go to http://getcomposer.org/download/ and look for the Composer-Setup.exe link
			Install Composer
		* If Linux:
			* Verify your Composer install with `composer -V`
		* If WAMP / MAMP / XAMPP:
			* If `php` isn't a recognized command, then:
				* make sure that the directory with your php binary in it is in the system `PATH` variable 
				* install `PHP` by installing (XAMPP)[https://www.apachefriends.org/index.html], [WAMP](http://www.wampserver.com/en/), a LAMP stack, [mamp](https://www.mamp.info/en/), another web stack, or the PHP packages for your operating system.
			* If `composer` isn't a recognized command, then
				* add the directory with your composer binary in it to the system `PATH` variable

### Installing

This a PHP Project so would need a LAMP stack or equivalnt in order to run

## Authors

* **dartvader666uk** - [dartvader666uk](https://bitbucket.org/dartvader666uk)
* **porter707** - [porter707](https://bitbucket.org/porter707/)

## Acknowledgments

* Thanks to **nickcharlton** - [nickcharlton](https://github.com/nickcharlton/moviesapi) for letting me use moviesapi API! (http://moviesapi.herokuapp.com/)