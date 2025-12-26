<div style="padding:5px 0 0 15px;">
<table border="0" style="color:#fff;font-weight:bold;font-size:11px;" width="100%" id="tabs">
<tr style="padding:0 10px 0 10px;width:30px;border:1px solid grey;">
<td>
<div style="padding:5px 10px;display:inline;cursor:pointer;" onclick="show('account')" id="accountl">Account Management</div> &middot; 
<div style="padding:5px 10px;display:inline;cursor:pointer;" onclick="show('wizards')" id="wizardsl">Wizards</div> &middot; 
<?php
 if($ses->permit(19)) {
 echo '<div style="padding:5px 10px;display:inline;cursor:pointer;" onclick="show(\'upload\')" id="uploadl">Upload</div> &middot; '; 
 }
?>
<div style="padding:5px 10px;display:inline;cursor:pointer;" onclick="show('noobs')" id="noobsl">Getting Started</div>
</td>
</tr>
<tr style="display:none;" id="account">
<td>
<a href="inactive.php" title="Register Inactivity"><img alt="" src="/images/banner/page_white_edit.png" />Going to be inactive?</a> &middot; 
<a href="password.php" title="Change Password"><img src="/images/banner/exclamation.png" alt="" />Change Password</a> &middot; 
<a href="logout.php" title="Logout of the Editor"><img src="/images/banner/door_in.png" alt="" />Logout ([#USER#])</a>
</td>
</tr>
<tr id="wizards" style="display:table-row;">
<td>
<a href="guidewizard.php" title="General Guide Wizard"><img src="/images/banner/book_open.png" alt="" />General</a> &middot;
<a href="guidewizard.php?quest" title="Quest Guide Wizard"><img src="/images/banner/quest.png" alt="" />Quest</a> &middot;
<a href="mapwiz.php" title="Map Wizard"><img src="/images/banner/map_add.png" alt="" />Map</a> &middot;
<a href="keymaker.php" title="City Key Generator"><img src="/images/banner/building_add.png" alt="" />City Keys</a> &middot;
<a href="interwiz.php" title="Interconnection Wizard"><img src="/images/banner/arrow_out.png" alt="" />Interconnection</a> &middot;
<a href="bbcode.php" title="BB-Code > xHTML"><img src="/images/banner/page_code.png" alt="" />BB-Code > xHTML</a>
</td>
</tr>
<?php if($ses->permit(19)) { ?>
<tr style="display:none;" id="upload">
<td>
<a href="upload.php" title="Upload Images"><img src="/images/banner/arrow_up.png" alt="" />Main</a> &middot;
<a href="upload.php?folder=monsters" title="Upload Images"><img src="/images/banner/bug.png" alt="" />Monsters</a> &middot;
<a href="upload.php?folder=skills" title="Upload Images"><img src="/images/banner/chart_bar.png" alt="" />Skills</a> &middot;
<a href="upload.php?folder=quests" title="Upload Images"><img src="/images/banner/quest.png" alt="" />Quests</a> &middot;
<a href="upload.php?folder=misc" title="Upload Images"><img src="/images/banner/book_open.png" alt="" />Misc Guides</a>
</td></tr>
<?php } ?>
<tr style="display:none;" id="noobs">
<td>
<a href="image_guide.php" title="Image Guide" target="_blank"><img src="/images/banner/picture.png" alt="" />Image Guide</a> &middot;
<a href="html_guide.php" title="HTML Guide" target="_blank"><img src="/images/banner/html.png" alt="" />HTML Guide</a> &middot;
<a href="database_management.php" title="Database Management" target="_blank"><img src="/images/banner/drive.png" alt="" />Database Management</a> &middot;
<a href="guide_guide.php" title="Guide Creation" target="_blank"><img src="/images/banner/layout.png" alt="" />Guide Creation</a> &middot; 
<a href="xhtml.php" title="Guide to using xHTML" target="_blank">xHTML Guide</a>
</td>
</tr>
</table>
<script type="text/javascript">if (get_cookie('tab')===null) document.getElementById('wizardsl').style.background='#3C3C3C';</script>
</div>