<?php
if(!isset($_GET['url'])){ die('Enter link to video and press "Get Info" button'); }

function TextBetween($s1,$s2,$s) {
  $s1 = strtolower($s1);
  $s2 = strtolower($s2);
  $L1 = strlen($s1);
  $scheck = strtolower($s);
  if($L1>0){$pos1 = strpos($scheck,$s1);} else {$pos1=0;}
  if($pos1 !== false){
    if($s2 == '') return substr($s,$pos1+$L1);
    $pos2 = strpos(substr($scheck,$pos1+$L1),$s2);
    if($pos2!==false) return substr($s,$pos1+$L1,$pos2);
  }
  return '';
}

// CURL THE URL AND LOAD INTO $output
  $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
  $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
  $header[] = "Cache-Control: max-age=0";
  $header[] = "Connection: keep-alive";
  $header[] = "Keep-Alive: 300";
  $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
  $header[] = "Accept-Language: en-us,en;q=0.5";
  $header[] = "Pragma: ";

// Security Fix: Whitelist domains to prevent SSRF
$allowed_domains = array('youtube.com', 'www.youtube.com', 'filefront.com', 'www.filefront.com');
$url_parts = parse_url($_GET['url']);
$is_allowed = false;
foreach($allowed_domains as $domain) {
    if(isset($url_parts['host']) && (strtolower($url_parts['host']) == $domain || substr(strtolower($url_parts['host']), -strlen('.'.$domain)) == '.'.$domain)) {
        $is_allowed = true;
        break;
    }
}

if (!$is_allowed) {
    die('Invalid or unauthorized video URL.');
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $_GET['url']);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// ... existing options ...
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$output = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);
// ----------------------------------------------------------

// Which video hosting service do we need to grab info from? 
if(stripos($_GET['url'],"youtube") != FALSE){
	$videoprovider = 'youtube';
	$videoname =  substr(TextBetween('<title>','</title>',$output),10);
	$description = TextBetween('<meta name="description" content="','">',$output);
	$part = substr($_GET['url'],strpos($_GET['url'],'?v=')+3); $url = 'http://www.youtube.com/v/' . $part; $embedurl=$url;
	$thumb = 'http://img.youtube.com/vi/' . $part . '/default.jpg';
}elseif(stripos($_GET['url'],"filefront") != FALSE){
	$videoprovider = 'filefront';
	$videoname =  substr(TextBetween('<title>','</title>',$output),0,-16);
	$description = TextBetween('<meta name="description" content="','">',$output);
	$embedurl = TextBetween('</param><embed src="','" type="applicati',$output);
	$url = $embedurl;
	$thumb = TextBetween('<link rel="videothumbnail" href="','" type="image/jpeg" />',$output);
	echo '<div style="width:400px;height:400px;overflow:scroll;">'.htmlspecialchars($output).'</div>';
}else{
	echo 'NO VIDEO SERVICE SPECIFIED';
}

if(isset($_GET['debug'])){ echo htmlspecialchars($error . $output); }

?>
<html><head>
<script language="javascript">
// Security Fix: Escape for JS
top.document.form.videoname.value = <?=json_encode($videoname)?>;
top.document.form.description.value = <?=json_encode($description)?>;
top.document.form.embedurl.value = <?=json_encode($embedurl)?>;
top.document.form.thumb.value = <?=json_encode($thumb)?>;
</script>
</head><body style="margin: 0px; padding: 0px;">
<? if($videoprovider=='youtube'){
	echo '<object width="450" height="350"><param name="movie" value="'.$url.'"></param><param name="wmode" value="transparent"></param><embed src="'.$url.'" type="application/x-shockwave-flash" wmode="transparent" width="450" height="350"></embed></object>';
}elseif($videoprovider=='filefront'){
	echo '<object width="450" height="338"><param name="movieID" value="'.$url.'"></param><param name="wmode" value="transparent"></param><embed src="'.$url.'" type="application/x-shockwave-flash" wmode="transparent" width="450" height="338"></embed></object>';
}
?>
</body>
</html>