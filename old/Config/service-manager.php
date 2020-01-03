<?php

/**
* Otherwise known as a ClassManager or ServiceManager.
*
* It provides a means to avoid instantiating objects which do not
* need re-instantiation when used multiple times in a single page.
*/
class serviceManager {

	private static $classes = array();

	public static function register($path) {
        // /** 
        //  * try autoloading recursively inside the root Classes folder. 
        //  */ 
        // $class_filename = strtolower($className) . '.php'; 
        // $class_root = $this->_includePath !== null ? $this->_includePath . DIRECTORY_SEPARATOR : ROOT . '/model/'; 

        // // Retrieve a recursive, traversable list of directories in the class root. 
        // $directories = new RecursiveDirectoryIterator($class_root); 

        // // Loop through each directory, itself being recursively iterable. 
        // foreach(new RecursiveIteratorIterator($directories) as $file) { 

        //     // Each $file is an SplFileInfo object, so we can get the filename easily 
        //     if (strtolower($file->getFilename()) == $class_filename) { 

        //         // Retrieve the full path to require the class. 
        //         $full_path = $file->getRealPath(); 
        //         require_once $full_path; 

        //         // Break out of the loop to stop wasting time looking 
        //         // for something that's already been found. 
        //         break; 
        //     } 
        // }


		if ($dh = opendir($path)) {
			while (($file = readdir($dh)) !== false) {
				if ('.' == $file || '..' == $file) continue;
				if (is_dir($path.'/'.$file)) continue;

				$fileInfo = pathinfo($path.'/'.$file);

				if ($fileInfo['extension'] == 'php') {
					require_once($path.'/'.$file);
					
					$className = $fileInfo['filename'];

					if (!array_key_exists($className, self::$classes)) {
						self::$classes[$className] = new $className();
					}
				}
			}
			closedir($dh);
		}
	}

	/**
	 * Retrieve an instance of a class, cached from a previous request
	 * if the class instantiation has previously been done.
	 *
	 * @param  [string]  $className
	 * @return [Object]
	 */
	public static function get($className) {
	    // // If the class does not already exist or is forced to be recreated. 
	    // if( ! array_key_exists($className, self::$classes) || $new) { 
	    //   // Instantiate and store that class. 
	    //   self::$classes[$className] = new $className; 
	    // } 
		return self::$classes[$className];
	}
}