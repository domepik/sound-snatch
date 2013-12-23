<html>
<head><title>Sound Snatch</title></head>
<body>
<center>
<form action="" method="post">
Sound:<br><input type="text" name="soundcloudlink" /><br /><br />
<input type="submit" />
</form>

<?php

function sendRequest($target) {

	$curl = curl_init($target);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13");
	return curl_exec($curl);
	curl_close($curl);

}

if(isset($_POST["soundcloudlink"])) {

	$soundcloudlink = $_POST["soundcloudlink"];
	$soundcloudclientkey = "b45b1aa10f1ac2941910a7f0d10f8e28";
	$soundcloudidlink = "http://api.soundcloud.com/resolve.json?url={$soundcloudlink}&client_id={$soundcloudclientkey}";
	$soundcloudtrackid = sendRequest($soundcloudidlink);

	preg_match_all("#tracks/(.*?).json#", $soundcloudtrackid, $trackid);

	$trackid = $trackid[1][0];
	$tracklink = file_get_contents("https://api.soundcloud.com/i1/tracks/{$trackid}/streams?client_id={$soundcloudclientkey}");

	preg_match_all('#:"(.*?)"#', $tracklink, $trackmp3);

	$trackmp3 = $trackmp3[1][0];
	$track = file_get_contents($trackmp3);

	$handle = fopen("{$trackid}.mp3", "w");
	fwrite($handle, $track);
	fclose($handle);

}

?>

</center>
</body>
</html>
