<?php
// require_once('twitteroauth.php');

// define('CONSUMER_KEY', 'insert_your_consumer_key_here');
// define('CONSUMER_SECRET', 'insert_your_consumer_secret_here');
// define('ACCESS_TOKEN', 'insert_your_access_token_here');
// define('ACCESS_TOKEN_SECRET', 'insert_your_access_token_secret_here');

// $twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
// $twitter->host = "https://api.twitter.com/1.1/";
// $search = $twitter->get('search', array('q' => 'search key word', 'rpp' => 15));

// $twitter->host = "https://api.twitter.com/1.1/";
// foreach($search->results as $tweet) {
// 	$status = 'RT @'.$tweet->from_user.' '.$tweet->text;
// 	if(strlen($status) > 140) $status = substr($status, 0, 139);
// 	$twitter->post('statuses/update', array('status' => $status));
// }

// echo "Success! Check your twitter bot for retweets!";
require "autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

// define('CONSUMER_KEY', 'RaGgCpeRD5hgF6R8DLwmH37Hc');
// define('CONSUMER_SECRET', 'a09OnWU9zQetm9eRNgMy7QdEZsMgfmVr78QFjz0kMBySoPzc09');
// define('ACCESS_TOKEN', '36314176-23G5gjzwbCaDwfDd95yMH2NiK1Fr6lTPbAg26IBwP');
// define('ACCESS_TOKEN_SECRET', 'qzJhUJ0baqEn2kR2Z9hSjnCOkuahR1kaxT7JV6kvlq2wk');

define('CONSUMER_KEY', 'WY10DZnqTTMeVVUDzLFu4ERor');
define('CONSUMER_SECRET', 'QrIZanMgX6G9jvLTBO2Jv5HQNsabIkf2CsQGhks2kc87eq4T2');
define('ACCESS_TOKEN', '36314176-PK0fUdgW0q6Y4yxqYKLQhLc12FocFrHQKOfyc48m7');
define('ACCESS_TOKEN_SECRET', '6kUm379FkrPua37SQE2oAHYfNmEJbHc3PrtnXXyDhjnv8');

$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
$content = $twitter->get("account/verify_credentials");

if($_GET['result_type'] == ""){
	$result_type = "mixed";
}else{
	$result_type = $_GET['result_type'];
}

print("<br>Results Type: ".$result_type."<hr>");

$sstring = 'retweet%20to%20win%20uk%20-Filter%3ARetweets-Filter%3AReplies&src=typd&lang=en';
$searchresult = $twitter->get("search/tweets", array("q" => $sstring, "count" => 10, "result_type" => $result_type,'exclude_replies' => true, 'include_rts' => false,));

foreach($searchresult as $eachTweet) {
	foreach($eachTweet as $tweet){
		$status = null;
		if($tweet->text !=""){
			$tweettext = $tweet->text;
			$tweetid = $tweet->id;
			$created_at = $tweet->created_at;
			$userID = $tweet->user->id;

			print("<br>Text: ".$tweettext." <br> ID: ".$tweetid." <br> Date: ".$created_at);

			//do re-tweet
			$status = 'RT @'.$tweet->from_user.' '.$tweet->text;

			print("<br>Status Length: ".strlen($status));

			if(strlen($status) > 140){
				$status = substr($status, 0, 140);
			} 

			$retweeted = $twitter->post('statuses/update', array('status' => $status));
			print("<br>Retweet:<pre>");
			print_r($retweeted);
			print("</pre>");

			//follow user is needed
			if (strpos($tweettext,'follow') !== false) {
	    		$follow = $twitter->post('friendships/create',array('user_id'=>$userID));
	    		print("<br>New Users added :".$userID);
				print("<pre>");
				print_r($follow);
				print("</pre>");
			}
			print("<hr>");
		}
	}
}
?>