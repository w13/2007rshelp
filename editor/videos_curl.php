<?php
if(isset($_GET['url'])){ }else{ die('Enter link to video and press "Get Info" button'); }

function TextBetween($s1,$s2,$s){
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

/*
// create a new curl resource
$ch = curl_init();

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, $_GET['url']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// grab URL, and return output
$output = curl_exec($ch);

// close curl resource, and free up system resources
curl_close($ch);
*/

  if(stripos($_GET['url'],"youtube") != FALSE) { ## YOUTUBE
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_GET['url']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $output = curl_exec($ch);
    curl_close($ch);

    $videoprovider = 'youtube';
    $videoname =  substr(TextBetween('<title>','</title>',$output),10);
    $description = TextBetween('<meta name="description" content="','">',$output);
    $part = substr($_GET['url'],strpos($_GET['url'],'?v=')+3);
    $url = 'http://www.youtube.com/v/' . $part;
    $embedurl=$url;
    $thumb = 'http://img.youtube.com/vi/' . $part . '/default.jpg';
    $keyword = TextBetween('<meta name="keywords" content="','">',$output);
    $keyword = str_replace(',','',$keyword);
  }
  elseif(stripos($_GET['url'],"filefront") != FALSE) { ## FILEFRONT
  
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_GET['url']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    echo curl_error($ch);
    curl_close($ch);

    $videoprovider = 'filefront';
    $videoname =  substr(TextBetween('<title>','</title>',$output),0,-16);
    $videoname = str_replace('_',' ',$videoname);
    $videoname = str_replace('.wmv','',$videoname);
    $fsize = TextBetween('File Size</p></td><td class="cellTwo">','</td>',$output);
    $description = htmlentities(TextBetween('<meta name="description" content="','">',$output));
    $description = $description . '\n\n<br /><br /><b>File Size: ' . $fsize . '</b>';
    $url = TextBetween('</param><embed src="','" type="applicati',$output);
    $embedurl = $url;
    $thumb = TextBetween('<link rel="videothumbnail" href="','" type="image/jpeg" />',$output);
    $keyword = NULL;
}
  elseif(stripos($_GET['url'],"putfile") != FALSE) { ## PUTFILE
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_GET['url']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $output = curl_exec($ch);
    curl_close($ch);

    $videoprovider = 'putfile';
    $videoname =  TextBetween('self.ss_contentTitle = "','";',$output);
    $description = TextBetween('self.ss_contentDescription = "','";',$output);
    $part = TextBetween('self.ss_externalId = "','";',$output);
    $url = 'http://feat.putfile.com/flow/putfile.swf?videoFile=' . $part;
    $embedurl=$url;
    $thumb = TextBetween('<link rel="image_src" href="','" />',$output);
    $keyword = TextBetween('self.ss_contentKeywords = "','";',$output);
  }
  elseif(stripos($_GET['url'],"metacafe") != FALSE) { ## METACAFE
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_GET['url']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $output = curl_exec($ch);
    curl_close($ch);

    $videoprovider = 'metacafe';
    $videoname =  TextBetween('<title>','</title>',$output);
    $description = TextBetween('<meta name="description" content="','" />',$output);
    $url = str_replace('/watch/','/fplayer/',$_GET['url']);
    $url = substr($url,-1) == '/' ? substr($url,0,-1) : $url;
    $url = $url . '.swf';
    $embedurl=$url;
    $thumb = TextBetween('<link rel="image_src" href="','" />',$output);
    $keyword = TextBetween('<meta name="keywords" content="','" />',$output);
    $keyword = str_replace(',',' ',$keyword);
  }
  elseif(stripos($_GET['url'],"veoh") != FALSE) { ## METACAFE
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_GET['url']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $output = curl_exec($ch);
    curl_close($ch);

    $videoprovider = 'veoh';
    $videoname =  TextBetween('<meta name="title" content="','" />',$output);
    $description = TextBetween('<meta name="description" content="','" />',$output);
    $description = str_replace("\n", " ", $description);
    $url = TextBetween('<link rel="video_src" href="','"/>',$output);
    $embedurl=$url;
    $thumb = TextBetween('<link rel="image_src" href="','"/>',$output);
    $keyword = TextBetween('<meta name="keywords" content="','" />',$output);
    $keyword = str_replace(',',' ',$keyword);
  }
  else {
    echo 'NO VIDEO SERVICE SPECIFIED';
  }

?>
<html><head>
<script language="javascript">
top.document.form.name.value = "<?=$videoname?>";
top.document.form.description.value = "<?=$description?>";
top.document.form.url.value = "<?=$embedurl?>";
top.document.form.thumb.value = "<?=$thumb?>";
top.document.form.keyword.value = "<?=$keyword?>";
</script>
</head><body style="margin: 0px; padding: 0px;">
<?

  if($videoprovider=='youtube') {
    echo '<object width="450" height="350">'
    .'<param name="movie" value="'.$url.'"></param><param name="wmode" value="transparent"></param>'
    .'<embed src="'.$url.'" type="application/x-shockwave-flash" wmode="transparent" width="450" height="350"></embed></object>';
  }
  
  elseif($videoprovider=='filefront') {
    echo '<object width="450" height="338">'
    .'<param name="movieID" value="'.$url.'"></param><param name="wmode" value="transparent"></param>'
    .'<embed src="'.$url.'" type="application/x-shockwave-flash" wmode="transparent" width="450" height="338"></embed></object>';
  }
  
  elseif($videoprovider=='putfile') {
    echo '<object width="450" height="338">'
    .'<param name="movie" value="'.$url.'"></param><param name="wmode" value="transparent"></param>'
    .'<embed src="'.$url.'" type="application/x-shockwave-flash" wmode="transparent" width="450" height="338"></embed></object>';
  }
  
  elseif($videoprovider=='metacafe') {
    echo '<object width="450" height="338">'
    .'<param name="movie" value="'.$url.'"></param><param name="wmode" value="transparent"></param>'
    .'<embed src="'.$url.'" type="application/x-shockwave-flash" wmode="transparent" width="450" height="338"></embed></object>';
  }

  elseif($videoprovider=='veoh') {
    echo '<object width="450" height="338">'
    .'<param name="movie" value="'.$url.'"></param><param name="wmode" value="transparent"></param>'
    .'<embed src="'.$url.'" type="application/x-shockwave-flash" wmode="transparent" width="450" height="338"></embed></object>';
  }
?>
</body>
</html>