<?PHP
require(dirname(__FILE__) . '/' . 'backend.php');
start_page('Search');
?>
<div class="boxtop">Search</div>
<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<!-- SiteSearch Google -->
<form method="get" action="http://2007rshelp.com/googlesearch.php" target="_top">
<table border="0">
<tr><td nowrap="nowrap" valign="top" align="left" height="32">
<a href="http://www.google.com/">
<img src="http://www.google.com/logos/Logo_25wht.gif" border="0" alt="Google" align="middle"></img></a>
</td>
<td nowrap="nowrap">
<input type="hidden" name="domains" value="2007rshelp.com"></input>
<label for="sbi" style="display: none">Enter your search terms</label>
<input type="text" name="q" size="31" maxlength="255" value="" id="sbi"></input>
<label for="sbb" style="display: none">Submit search form</label>
<input type="submit" name="sa" value="Search" id="sbb"></input>
</td></tr>
<tr>
<td>&nbsp;</td>
<td nowrap="nowrap">
<table>
<tr>
<td>
<input type="radio" name="sitesearch" value="" id="ss0"></input>
<label for="ss0" title="Search the Web"><font size="-1">Web</font></label></td>
<td>
<input type="radio" name="sitesearch" value="2007rshelp.com" checked id="ss1"></input>
<label for="ss1" title="Search 2007rshelp.com"><font size="-1">2007rshelp.com</font></label></td>
</tr>
</table>
<input type="hidden" name="client" value="pub-0109004644664993"></input>
<input type="hidden" name="forid" value="1"></input>
<input type="hidden" name="channel" value="5506166622"></input>
<input type="hidden" name="ie" value="ISO-8859-1"></input>
<input type="hidden" name="oe" value="ISO-8859-1"></input>
<input type="hidden" name="cof" value="GALT:#008000;GL:1;DIV:#336699;VLC:663399;AH:center;BGC:FFFFFF;LBGC:336699;ALC:0000FF;LC:0000FF;T:000000;GFNT:0000FF;GIMP:0000FF;FORID:11"></input>
<input type="hidden" name="hl" value="en"></input>
</td></tr></table>
</form>
<!-- SiteSearch Google -->
<center>
<!-- Google Search Result Snippet Begins -->
<div id="googleSearchUnitIframe" width="90%"></div>

<script type="text/javascript">
   var googleSearchIframeName = 'googleSearchUnitIframe';
   var googleSearchFrameWidth = 700;
   var googleSearchFrameborder = 1 ;
   var googleSearchDomain = 'www.google.com';
</script>
<script type="text/javascript"
         src="http://www.google.com/afsonline/show_afs_search.js">
</script>
<!-- Google Search Result Snippet Ends -->
</center>
<br />
</div>
<?php
end_page();
?>