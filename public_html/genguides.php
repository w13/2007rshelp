<?php
$cleanArr = array(  array('id', $_GET['id'], 'int', 's' => '1,2000000')
				  );
/*** MISC PAGE ***/
require(dirname(__FILE__) . '/' . 'backend.php');
start_page('Runescape Player Guides and Tips');
if($disp->errlevel > 0) {
	$id = null;
}
?>

<div class="boxtop">Player Guides and Tips</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px">
<a name="top"></a>
<?php
if(empty($id))
 {
?>
<div style="margin:1px;font-size:large;font-weight:bold;">&raquo; Player Guides and Tips</div>
<hr class="main" noshade="noshade" />
<p style="text-align: center;">This area contains runescape guides and tips made by users of <a href="/community/">Runescape Community's</a>&nbsp;<a href="/community/index.php?showforum=317">General Guides</a> forum. This section is an extension of our <a href="/misc.php">Miscellaneous Runescape Guides</a> section, providing further tips and strategies on a variety of topics and from a variety of perspectives.<br /><br /><strong>These guides are presented as they are on Runescape Community and have not been edited or reviewed by Zybez Staff.</strong></p>
<table style="border-left: 1px solid #000000;" width="90%" cellpadding="1" cellspacing="0" align="center">
 <tr class="boxtop">
  <th class="tabletop">Name:</th>
  <th class="tabletop">Author:</th>
 </tr>
<?php
  $query = $db->query("SELECT * FROM community.ibftopics WHERE tid IN (419821,419345,461780,489291,544278,593495,594920,700893,602346,618073,637289,648279,649316,649919,651587,690930,694215,700893,712072,720807,739903,747407,764696,768793,775950,782534,783229,797142,804273,813274,817880,842034,854650,874623,886282,890113,894325,953733,979320,985520,991655,1029727,1016848,1026157,1016586,1081146,1032676,1079503,1043873,1057950,979770,985746,1005349,1035558,1092398,1095478,1131081,1186381) AND forum_id = 317 AND approved = 1 AND state = 'open' ORDER BY title");
  while($info = $db->fetch_array($query))
   {
    echo '<tr align="center">';
    $seotitle = strtolower(preg_replace("/[^A-Za-z0-9]/", "", $info['title']));
    echo '<td class="tablebottom"><a href="' . $_SERVER['SCRIPT_NAME'] . '?id=' . $info['tid'] . '&amp;runescape_' . $seotitle . '.htm">' . $info['title'] . '</a></td>' . NL;
    echo '<td class="tablebottom">' . $info['starter_name'] . '</td>';
    echo '</tr>';
   } 
?>
</table>
<br />
<?php
 }
else
 {
  $info = $db->fetch_row("SELECT p.*, t.title FROM community.ibfposts p JOIN community.ibftopics t ON p.topic_id=t.tid WHERE topic_id = " . $id);
?>

<div style="margin:1px;font-size:large;font-weight:bold;">
&raquo; <a href="<?php=$_SERVER['SCRIPT_NAME']?>">Player Guides and Tips</a> &raquo; <u><?php=$info['title']?></u></div>
<hr class="main" noshade="noshade" />
<style type="text/css">
#content span, #content p { color:#000 !important; }
</style>
<?php
//$info['post'] = str_replace("<img", "<img onload='javascript: resizeimg()'", $info['post']);
$info['post'] = strip_tags($info['post'], '<b><span><p><br><ol><ul><li><a><img><strike><div><table><tr><td><th>');
?>
<table style="border-left: 1px solid #000; border-top: 1px solid #000" width="100%" cellpadding="5" cellspacing="0">
<?php
  echo '<tr><td style="border-bottom: 1px solid #000; border-right: 1px solid #000"><p style="text-align:center;"><a href="/community/index.php?showtopic='.$id.'">Click here to comment on this guide at Runescape Community.</a></p></td></tr>';
  echo '<tr><td style="border-bottom: 1px solid #000; border-right: 1px solid #000">' . $info['post'] . '</td></tr>';
  echo '<tr><td style="border-bottom: 1px solid #000; border-right: 1px solid #000">Author: <b>' . $info['author_name'] . '</b></td>'
?>  
</tr>
</table>
<br />
<p style="text-align:center;font-weight:bold;"><a href="javascript:history.go(-1)">&lt;-- Go Back</a> | <a href="#top">Top -- ^</a></p>
<br />
<?php
 }
 ?>
[#COPYRIGHT#]
</div>
<?php
end_page( $info['name'] );
?>