<?php
require(  dirname( __FILE__ ) . '/' . 'backend.php' );
start_page( 'Runescape Treasure Trail Locator' );

?>
<div class="boxtop">Runescape Coordinate Locator</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">

<div style="font-size: large; font-weight: bold;">&raquo; Runescape Coordinate Locator</div>

<hr class="main" noshade="noshade" />

<p>This tool is designed to help players find the exact location of their treasure trail coordinate clues. As an alternative to using the traditional Watch, Sextant and Navigation Chart to find the location, you can use the form below to generate a map of the location of your clue.</p>

<p><b>IMPORTANT!</b> You will always need to bring your <b>Spade, Watch, Sextant and Navigation Chart</b> when completing co-ordinate clues. If you don't have them, you will not be able to find your next clue or get your reward! Don't forget!</p>

<form action="locator_image.php" method="post" target="map">
<table style="border-left: 1px solid #000000;" width="400" cellpadding="1" cellspacing="0" align="center">
<tr>
<td class="tabletop" rowspan="6" style="font: 14px Verdana; font-weight: bold; line-height: 1.3; border-right: none;">T R E A S U R E<br /><br />T R A I L<br /><br />L O C A T O R</td>
<td class="tabletop">CO-ORDINATES</td>
</tr>
<tr>
<td class="tablebottom" style="border-bottom: none; border-left: 1px solid black;">

Degrees: <input type="text" name="v_deg" size="5" maxlength="2" value="00" /> - 
Minutes: <input type="text" name="v_min" size="5" maxlength="2" value="00" /> - 
<select name="v_direction">
<option value="north" selected="selected">North</option>
<option value="south">South</option>
</select><br />
Degrees: <input type="text" name="h_deg" size="5" maxlength="2" value="00" /> - 
Minutes: <input type="text" name="h_min" size="5" maxlength="2" value="00" /> - 
<select name="h_direction">
<option value="east" selected="selected">East&nbsp;</option>
<option value="west">West&nbsp;</option>
</select>
</td>
</tr>
<tr>
<td class="tablebottom" style="border-left: 1px solid black;">
<center><input type="submit" value="Locate my Clue!" /> <input type="reset" value="Reset" /></center>
</td>
</tr>
<tr>
<td class="tablebottom" style="border-left: 1px solid black;">
<iframe name="map" frameborder="0" width="400" height="400" src="locator_image.php" marginheight="0" marginwidth="0"></iframe>
</td>
</tr>
</table>
</form>
<br />
Proper Steps to use the OSRS RuneScape Help Locator:<ol>
<li>Select the 'Read' option on your clue in the game.</li>
<li>Copy the numbers into the appropriate boxes and select the directions of the co-ordinate clue.</li>
<li>Press 'Locate my Clue'.</li>
<li>Your map will be automatically generated. Your destination will be where the crosshairs meet.</li>
</ol>

</div>

<?php
end_page();
?>