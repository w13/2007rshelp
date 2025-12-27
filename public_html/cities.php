<?php
$cleanArr = array(  array('id', $_GET['id'] ?? null, 'int', 's' => '1,250')
				  );
/*** CITY PAGE ***/
require(dirname(__FILE__) . '/' . 'backend.php');
start_page('City Guides');
if($disp->errlevel > 0) {
	$id = null;
}
?>
<div class="boxtop">
  Runescape City Guides
</div>
<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<a name="top"></a>
  <?php
  if(empty($id))
   {
  ?>
<div style="margin:1pt; font-size:large; font-weight:bold;">&raquo; Runescape City Guides</div>
<hr class="main" noshade="noshade" />
<br />
<table style="border-left: 1px solid #000000;" width="100%" cellpadding="1" cellspacing="0">
<tr class="boxtop">
<th class="tabletop">Name</th>
<th class="tabletop" width="80">Type</th>
<th class="tabletop" width="40%">Author</th>
<th class="tabletop" width="100">Last Update</th>
</tr>
  <?php
    $query = $db->query( "SELECT * FROM `cities` ORDER BY `name`" );
    while( $info = $db->fetch_array( $query ) )
	{
        $info['type'] = $info['type'] == 1 ? 'P2P' : 'Free';
        echo '<tr align="center">' . NL;
		echo '<td class="tablebottom"><a href="?id=' . $info['id'] . '">' . htmlspecialchars($info['name']) . '</a></td>' . NL;
        echo '<td class="tablebottom">' . htmlspecialchars($info['type']) . '</td>' . NL;
		echo '<td class="tablebottom">' . htmlspecialchars($info['author']) . '</td>' . NL;
		echo '<td class="tablebottom">'.date('M j, Y', $info['time']).'</td>'.NL;
		echo '</tr>' . NL;
	}
  ?>
</table>
<br />
  <?php
  }
  else
  {
    $info = $db->fetch_row("SELECT * FROM `cities` WHERE `id` = " . $id);
    if (!$info) {
        echo 'Error: Invalid City ID.';
    } else {
  ?>
<script language="JavaScript" type="text/javascript">
function scroll(i)
{
   var el = document.getElementById(i)
   if (el.style.overflow=="hidden")
   {
      el.style.overflow="auto";
   }
   else
   {
      el.style.overflow="hidden";
   }
}
</script>

<div style="margin:1pt; font-size:large; font-weight:bold;">
&raquo; <a href="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>">OSRS RuneScape City Guides</a> &raquo; <u><?php echo htmlspecialchars($info['name']); ?></u></div>
<hr class="main" noshade="noshade" /><br />
<table style="border-left: 1px solid #000; border-top: 1px solid #000" width="100%" cellpadding="5" cellspacing="0">
    <?php
    echo '<tr><td class="tablebottom" style="text-align:center;"><a href="/correction.php?area=cities&amp;id=' . $id . '" title="Submit a Correction"><img src="/img/correct.gif" alt="Submit Correction" border="0" /></a></td></tr>' . NL;
    $text = explode('<!--s-->',$info['text']);
    $intro = $text[0];
    $content = $text[1] ?? '';
    echo '<tr><td style="border-bottom: 1px solid #000; border-right: 1px solid #000">'.NL
        .'<div style="float:left;width:70%; padding-top:5px;">';
      echo '<div style="width:55%;height:250px;float:left;line-height:1.4;text-align:justify;padding:0 5px 0 5px;">
        <h3>Introduction</h3>'.$intro.'</div>';
      if($info['city_key'] !='NA') {
      echo '<div style="margin-left:5px;margin-right:12px;width:36%;height:250px;padding:0 5px 0 5px;overflow:auto;">';
        $citykeys = explode(',',$info['city_key']);
        for($num=0; array_key_exists($num,$citykeys);$num++) {
          echo city_key($citykeys[$num]);
        }
      echo '</div>';
     }
    echo '</div>';
    echo '<div onclick="javascript:scroll(\'toscroll\')" id="toscroll" title="Click Me" style="overflow:hidden;height:250px;text-align:center;width:34%; margin-top:5px;">' . ($info['map'] ?? '') . '</div>';
    echo '<br style="clear:left;"/>';

    echo '<div style="width:98%;padding-left:5px;">' . $content . '</div>';
    echo city_shops($id);
    echo city_npc($id);
    echo '</td></tr>';
   echo '<tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Author: <b>' . htmlspecialchars($info['author']) . '</b></td></tr>' . NL;
    ?>
</table>
<br />
<p style="text-align:center; font-weight:bold;">
<a href="javascript:history.go(-1)">&lt;-- Go Back</a> | <a href="#top">Top -- ^</a>
</p>
<br />

  <?php
    }
  }
  ?>
[#COPYRIGHT#]
</div>
<?php
end_page( htmlspecialchars($info['name'] ?? '') );
?>
