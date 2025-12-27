<?php

/* Security For Our Info */
define( 'IN_OSRS_HELP' , TRUE );


 require(dirname(__FILE__) . '/' . 'backend.php');
 start_page(10, 'MKP Queries');
?>
<script language="JavaScript">
function hide(i)
{
   var el = document.getElementById(i)
   if (el.style.display=="none")
   {
      el.style.display="block";
   }
   else
   {
      el.style.display="none";
   }
}
</script>

<div class="boxtop">Item Database</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">

<div align="left" style="margin:1">
<b><font size="+1">&raquo; <a href="<?php echo $_SERVER['PHP_SELF']; ?>">Item Database</a></font></b></div>
<hr class="main" noshade="noshade" />
<p>Click to expand lists.</p>

<a href="#" onclick=hide('tohide3')><span style="font-variant:small-caps; font-size: 14px;">These don't have a price history at all.</span></a><br />
<div id="tohide3" style="display:none">
You'll need to change the price, hit submit, and then hit F5 when you get the MYSQL error. Go back and fix the price up if you had to up it 1gp.
<ol>
<?php
  $query = $db->query("SELECT * FROM price_items WHERE id NOT IN ( SELECT pid FROM price_history) AND phold_id=0");
  while($info = $db->fetch_array($query))
   {
    echo '<li><a href="javascript: void(0)" onclick="javascript:window.open( \'/editor/price.php?search_terms='.mysqli_real_escape_string($db->connect, $info['name']).'\', \'market\', \'width=600,height=600,scrollbars=yes,location=yes\' )">' . $info['name'] . '</a></li>';
   }
  echo '</ol><br /></div>';
		?>
		
<a href="#" onclick=hide('tohide2')>
<span style="font-variant:small-caps; font-size: 14px;">Prices that we say haven't changed in a year (need updating!!!):</span></a><br />
<div id="tohide2" style="display:none">
If the price is the same, just up it 1gp, submit, go back and put it back to what it was before.
<ol>
<?php
  $query = $db->query("SELECT pid, name FROM price_history h JOIN price_items i ON i.id=h.pid GROUP BY pid HAVING count( * ) = 1 ORDER BY pid DESC ");
  while($info = $db->fetch_array($query))
   {
    echo '<li><a href="javascript: void(0)" onclick="javascript:window.open( \'/editor/price.php?search_terms='.mysqli_real_escape_string($db->connect, $info['name']).'\', \'market\', \'width=600,height=600,scrollbars=yes,location=yes\' )">' . $info['name'] . '</a></li>';
   }
  echo '</ol><br /></div>';

		?>

</div><br />
<?php
end_page();
?>