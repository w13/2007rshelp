<?php
$url = $_SERVER['HTTP_REFERER'];
 if (!isset($url)) $url = 'https://2007rshelp.com/index.php';
 
  if(isset($_GET['lang']) && $_GET['lang'] == 'nl') {
      header( 'Location: https://www.google.com/translate?u=' . $url . '&langpair=en%7Cnl&hl=en&ie=UTF8' );
  }
  if(isset($_GET['lang']) && $_GET['lang'] == 'de') {
      header( 'Location: https://www.google.com/translate?u=' . $url . '&langpair=en%7Cde&hl=en&ie=UTF8' );
  }
  if(isset($_GET['lang']) && $_GET['lang'] == 'lt') {
      header( 'Location: https://vertimas.vdu.lt/twsas/translations/transhtml.aspx?uid=&dirid=16777217&tplid=Bendras&auto=1&translateurl=' . $url );
  }
  if(isset($_GET['lang']) && $_GET['lang'] == 'fr') {
      header( 'Location: https://www.google.com/translate?u=' . $url . '&langpair=en%7Cfr&hl=en&ie=UTF8' );
  }
  if(isset($_GET['lang']) && $_GET['lang'] == 'it') {
      header( 'Location: https://www.google.com/translate?u=' . $url . '&langpair=en%7Cit&hl=en&ie=UTF8' );
  }
  if(isset($_GET['lang']) && $_GET['lang'] == 'pt') {
      header( 'Location: https://www.google.com/translate?u=' . $url . '&langpair=en%7Cpt&hl=en&ie=UTF8' );
  }
  if(isset($_GET['lang']) && $_GET['lang'] == 'es') {
      header( 'Location: https://www.google.com/translate?u=' . $url . '&langpair=en%7Ces&hl=en&ie=UTF8' );
  }
  if(isset($_GET['lang']) && $_GET['lang'] == 'ru') {
      header( 'Location: https://www.google.com/translate?u=' . $url . '&langpair=en%7Cru&hl=en&ie=UTF8' );
  }
  if(isset($_GET['lang']) && $_GET['lang'] == 'jp') {
      header( 'Location: https://translate.google.com/translate?u=' . $url . '&langpair=en%7Cja&hl=en&ie=UTF8' );
  }
  if(!isset($_GET['lang'])) {
  die();
  }
?>