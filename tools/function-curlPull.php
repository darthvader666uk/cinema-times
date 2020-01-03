<?php
  /** 
   * The new page scraping function using cURL
   * Written by Leigh Ashton. 
   * 
   * string curlPull ( string str [, string str [, int flags]] )
   * 
   *    $url  = the URL you are going to scrape.
   *    $vars = the Variables you are passing to the page
   *    $get  = true if using GET, default is false for POST 
   */

    function curlPull($url=null, $vars=null, $get=null, $user=null, $pass=null, $xml=null, $referrer=NULL, $Follow=TRUE){

        global $cookiejar;

        if (!$cookiejar){
             preg_match("/([a-zA-Z0-9-_]*)\.(com|co\.uk|org|net)/", $url, $regex);
             $cookiejar = tempnam("./cookies", $regex[1]);
        }

        if($url){

            if (($get) and ($vars)){
                $url .= $vars;
            }

            $x = curl_init($url);

            $agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";

            curl_setopt($x, CURLOPT_USERAGENT, $agent);
            curl_setopt($x, CURLOPT_COOKIEFILE, $cookiejar);
            curl_setopt($x, CURLOPT_COOKIEJAR, $cookiejar);
            curl_setopt($x, CURLOPT_SSL_VERIFYHOST, 0);        
            curl_setopt($x, CURLOPT_SSL_VERIFYPEER, 0);              
            curl_setopt($x, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($x, CURLOPT_VERBOSE, 1);
            curl_setopt($x, CURLOPT_HEADER, 1);
            
            if ($xml){
                curl_setopt($x, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
            }
            
            if (($user) and ($pass)){
                curl_setopt($x, CURLOPT_USERPWD, "$user:$pass");   
            }

            if ((!$get) and ($vars)){
                curl_setopt($x, CURLOPT_POST, 1);
                curl_setopt($x, CURLOPT_POSTFIELDS, $vars);
            }

            if ($referrer) {
                curl_setopt($x, CURLOPT_REFERER, $referrer);
            }
            
            if($Follow){
                curl_setopt($x, CURLOPT_FOLLOWLOCATION, 1);    
            }
			
			curl_setopt($x,CURLOPT_TIMEOUT,10); 
			
            $results = curl_exec($x);
            
            curl_close($x);
            
            if (function_exists('checkCurlTimeout')){
                checkCurlTimeout($results);
            }

            // output

                // highlight prices for easier diagnostic scanning
                $results = "\$cookiejar='$cookiejar'<br>" . preg_replace("/((&pound;|£)[0-9]+(,[0-9]+|)(\.[0-9]{2}|))/", "<div style='background-color: #33CC66;'>$0</div>", $results);

                // split the var string to make it easier to read
                $vars = preg_replace("/&/", "<br>$0", $vars);

                // print the diagnostics
                print "<b>\$url = </b><i>$url</i><br /><br /><b>\$vars = </b><i>$vars</i><br /><b>\$cookiejar = </b><i>$cookiejar</i><hr></div>$results<hr>";

            return $results;
        }
    }

    // silent version, no output
    function silentCurlPull($url=null, $vars=null, $get=null, $user=null, $pass=null, $xml=null, $referrer=NULL, $Follow=TRUE){
    
            global $cookiejar;
            
            ob_start();  
            $results = curlPull($url, $vars, $get, $user, $pass, $xml, $referrer, $Follow);            
            ob_end_clean();
            
            return $results;        
    }
?>