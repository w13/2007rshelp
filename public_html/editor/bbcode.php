<?php

require(dirname(__FILE__) . '/' . 'backend.php');
//--------------------------------------\
// OSRS RuneScape Help BBcode Guide Convertor v2.03\	\n// Created: Dec. 16, 2005 [12/16/05]\	\n// Created by: No1 1000\	\	\n//--------------------------------------\
// Last modified: 01/28/2006\	\n// Last modified by: No1 1000\	\n//--------------------------------------\

$act = isset($_GET['act']) ? $_GET['act'] : '';
$version = ' v2.03';

if ($act == 'preview') {
  $title = 'Previewing XHTML';
}
else {
  $title = 'BBCode > XHTML';
}

start_page( 1, $title );
?>

<div class="boxtop"><?php echo $title; ?></div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">

<div align="left" style="margin:1">
<b><font size="+1">&raquo; BBCode > XHTML</font></b>
</div>
<hr class="main" noshade="noshade" /><br />
<?php

$txt = '';
if ($act == 'convert') {
 $txt = isset($_POST['cont']) ? $_POST['cont'] : '';

 // Basic BBcode -> HTML [Plus some extra] -- Sadly, essential for the later replacements. Gotta love PERL.
    $txt = str_replace('[', '<', $txt);
    $txt = str_replace(']', '>', $txt);
    $txt = str_replace('\n', '<br />', $txt);
	$txt = str_replace('&', '&amp;', $txt);
	$txt = str_replace('', '-', $txt);
	$txt = str_replace('', '"', $txt);
	$txt = str_replace('', '"', $txt);
	$txt = str_replace('', "'", $txt);
	$txt = str_replace('', "'", $txt);
	$txt = str_replace('', '...', $txt);

 // Titles - All working now! :D Not picky anymore.
    $txt = preg_replace("#<br />(<b>|)<size=[0-9]>(<b>|)(.+?)(</b>|)</size>(</b>|)#is", "<div class=\"title1\">$3</div>", $txt); // Title1
    $txt = preg_replace("#<br />(<u><b>|<b><u>)(.+?)(</b></u>|</u></b>)#i", "<div class=\"title2\">$2</div>", $txt); // Title2
    $txt = preg_replace("#<br /><b>([\s\w]+?)</b>.{1}<br />#i", "<div class=\"title3\">$1</div>\r<br />", $txt); // Title3

 // Misc - All working
	$txt = preg_replace("#<content>(.+?)</content>#is", "<table>\n<tr>\n<td class=\"linksmenu\">$1\n</td>\n</tr>\n</table>", $txt); // Table of contents
	$txt = preg_replace("#<hr>#i", "<hr />", $txt); // Horizontal Rule
    $txt = preg_replace("#<img>(.+?)\\</img>#i", "<img src=\" $1 \" alt=\"OSRS RuneScape Help's Placeholder\" />", $txt); // Images
    $txt = preg_replace("#<url>(.+?)</url>#i", "<a href=\" $1 \">$1</a>", $txt); // Url-1
    $txt = preg_replace("#<url=(.+?)>(.+?)</url>#i", "<a href=\" $1 \">$2</a>", $txt); // Url-2
    $txt = preg_replace("#<anchor>(.+?)</anchor>#i", "<a name=\" $1 \"></a>", $txt); // Anchor
    $txt = preg_replace("#<color=(.+?)>(.+?)</color>#is", "<span style=\"color: $1\">$2</span>", $txt); // Color
    $txt = preg_replace("#<left>(.+?)</left>#is", "<div align=\"left\">$1</div>", $txt); // Left-align
    $txt = preg_replace("#<center>(.+?)</center>#is", "<div align=\"center\">$1</div>", $txt); // Center-align
	$txt = preg_replace("#<right>(.+?)</right>#is", "<div align=\"right\">$1</div>", $txt); // Right-align
    $txt = preg_replace("#<list>(.+?)</list>#is", "<ul>$1</ul>", $txt); // Unordered List
    $txt = preg_replace("#<list>(.+?)</list>#is", "<ul>$1</ul>", $txt); // Unordered List [2]
    $txt = preg_replace("#<list=.>(.+?)</list>#is", "<ol>$1</ol>", $txt); // Ordered List
    $txt = preg_replace("#<list=.>(.+?)</list>#is", "<ol>$1</ol>", $txt); // Ordered List [2]
    $txt = preg_replace("#(<br />|)<\*>
(.+?)#i", "<li>$2</li>\r", $txt); // List Items
    $txt = preg_replace("#<br /></(u|o)l>#i", "</$1l>", $txt); // List Closing

 // Clean up the line breaks - Better..
    $txt = preg_replace("#<br />\r<br />(.+?)\r<br />\r#i", "\r<br />\r<p>$1</p>\r<br />\r", $txt); // BR-1
    $txt = preg_replace("#<br />\r<br />(.+?)\r<br />\r#i", "\r\r<p>$1</p>\r\r", $txt); // BR-2

 // And we're done! Or are we? Rrgh.. Okay, spit the code out. Then we can go take a nap. Yayy. 3AM probably isn't the best time to work on this kind of thing...
 // [2] - The repeat coding is required for embedded lists. Meh.

}
if ($act == 'preview') {

  $text = isset($_POST['code']) ? stripslashes($_POST['code']) : '';
  ?>
  <table style="border-left: 1px solid #000000; border-top: 1px solid #000000" width="100%" cellpadding="5" cellspacing="0">
  <tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000"><u>Guide Name</u>: Preview</td></tr>
  <tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000"><?php echo $text; ?></td></tr>
  <tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Author: <b>Preview</b></td></tr>
  </table>
  <?php
}
elseif($act == 'news') {
    $text = isset($_POST['content']) ? stripslashes($_POST['content']) : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $mem_id = isset($_POST['mem_id']) ? $_POST['mem_id'] : '';
    $ftime = time();
    $dnum = date( 'd', $ftime );
    $mname = date( 'F', $ftime );
   
	 $date = date( 'F jS Y, g:iA', $ftime );
?>
<div id="news-section">
<div class="date">
<p class="dateNumber"><?php echo $dnum; ?></p>
<p class="dateMonth"><?php echo $mname; ?></p>
</div>
<div class="newspost">
<img src="/img/staff/Ben_Goten78.png" class="avatar" alt="Author Name" />
<h2><?php echo $title; ?></h2>

<span class="postmeta">Written by <a href="/community/index.php?showuser=<?php echo $mem_id; ?>" title="Author Name">Author Name</a> on <?php echo $date; ?></span>
<p><?php echo $text; ?></p>

</div></div>
<?php

}
else {

$cont = isset($_POST['cont']) ? stripslashes($_POST['cont']) : '';

echo '<form action="bbcode.php?act=convert" method="post">
Enter in BBcode-Form: <input type="submit" value="Convert!" /><br />
<textarea rows="10" name="cont" style="width: 95%;">' . $cont . '</textarea>
</form><br /><br />

<form action="bbcode.php?act=preview" method="post" target="new">
XHTML-Form: <input type="submit" value="Preview code" /><br />
<textarea rows="15" name="code" style="width: 95%;">' . stripslashes($txt) . '</textarea>
</form>';

} ?>

<div style="text-align: center; width: 100%; font-family: verdana; font-size: 10px;"><br /><br /><a href="bbcode.php" >BBcode -> XHTML Convertor<?php echo $version;?></a><br />
BBcode Convertor &copy; Copyright 2004-2006 No1 1000</div>

</div>

<?php
end_page();
?>
