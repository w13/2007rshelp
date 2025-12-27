<?php
$cleanArr = array(  array('image', $_GET['i'], 'sql', 'l' => 50)
				  );
				  
require(dirname(__FILE__) . '/' . 'backend.php');
start_page('Viewing Full Image');
?>
<div class="boxtop">OSRS RuneScape Help Uploader: Viewing Full Image</div>
<div class="boxbottom" style="padding: 6px 24px; text-align: center;">
<img src="http://www.runescapetop.com/up/images/<?=$image?>" />

<div style="padding: 10px;font-size:1.5em;"><a href="http://www.runescapetop.com/upload/">Go to the OSRS RuneScape Help Uploader</a></div>
</div>
<?php
end_page();
?>