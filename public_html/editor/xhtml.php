<?php
require(dirname(__FILE__) . '/' . 'backend.php');
start_page('How To Use xHTML');
?>
<div class="boxtop">How To Use xHTML</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<font size="+3"><b>How To Use xHTML</b></font>
<hr size="1" noshade="noshade" />
<br />
<p>OSRS RuneScape Help is fully x-HTML Transitional Compliant. Due to this, there are a number of points you MUST observe when editing the HTML code in a guide. If you wish to learn more about xHTML, read through this <a href="http://w3schools.com/XHTML">tutorial by W3Schools</a>.</p>

<blockquote><p>In HTML there are <strong>elements</strong> (&lt;table&gt;&lt;tr&gt;&lt;td&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/table&gt;, &lt;strong&gt;&lt;/strong&gt;, &lt;em&gt;&lt;/em&gt;, &lt;p&gt;&lt;/p&gt;) and <strong>attributes</strong> (align, style, width, height, etc). Some of these attributes and elements are deprecated. This means that as web browsers advance, they will not recognise these attributes. More people have up-to-date browsers, and if we have outdated code, they won't be able to view the website properly. Having proper standards for code also increases our search engine ranking a bit.</p>

<p>As we redesign OSRS RuneScape Help section by section, we will be phasing out deprecated HTML. A full list of deprecated HTML can be found <a href="http://webdesign.about.com/od/htmltags/a/bltags_deprctag.htm" style="color:red; font-weight:bold;">here</a>.</p></blockquote>

<ol>
<li>HTML guides: <a href="http://www.w3schools.com/html/default.asp" style="color:red; font-weight:bold;">w3schools</a>, <a href="http://htmlgoodies.com/primers/html/" style="color:red; font-weight:bold;">HTMLgoodies</a></li>
<li>To check whether a guide is valid or not, use the W3Schools <a href="http://validator.w3.org" style="color:red; font-weight:bold;">xHTML Transitional Validator</a>.</li>
<li>To convert a guide from BB-Code to xHTML, use the <a href="bbcode.php" style="color:red; font-weight:bold;">BB-Code > xHTML</a> tool.<br />- <em>Please note that it does not do it at a 100% success rate - there will be code you need to clean up.</em></li>
<li>Rather than inter-connecting a guide by hand, use our <a href="interwiz.php" style="color:red; font-weight:bold;">Inter-Connection Wizard</a></li>
<li>To 'batch' check guides for xHTML validness, use the <a href="http://www.htmlhelp.com/tools/validator/batch.html.en" style="color:red; font-weight:bold;">WDG HTML Validator - Batch Mode</a>, using <a href="/development/list.php">this</a> list to copy the URLs from.</li></ol><br />

If you use FireFox (recommended), you can use the <a href="https://addons.mozilla.org/firefox/60/"><b>Web Developer</b></a> extension. This is a toolbar that you can enable and disable that has many features for a web developer (lets you disable javascript, view CSS in-page, view document size, links to validationg etc). To use it to validate the HTML of a guide, simply open the guide you want to validate, and go to Tools > Validate HTML.</p>

<p>Miscellaneous points to observe:<br />
- Always remember to CLOSE your tags (&lt;/a&gt;, &lt;/p&gt;, &lt;/li&gt;, &lt;/ul&gt;, &lt;/ol&gt;, &lt;/table&gt;, &lt;/td&gt;, &lt;/tr&gt;, style="", href="", src="" etc)<br />
- Note that &lt;br /&gt;, &lt;hr /&gt;, &lt;img src="" alt="" /&gt; do NOT need to be closed. The /&gt; closes them.</p>

<table style="border-left: 1px solid #000;" width="100%" cellpadding="5" cellspacing="0">
<tr>
<td class="tabletop">USE THIS</td>
<td class="tabletop">NOT THIS</td></tr>
<tr>
<td class="tablebottom">" '</td>
<td class="tablebottom">“ ‘ (these are "Auto-Corrected" in MS word)</td></tr>
<tr>
<td class="tablebottom">&lt;li&gt;Dot point&lt;/li&gt;</td>
<td class="tablebottom">&lt;li /&gt;Dot point</td></tr>
<tr>
<td class="tablebottom">&lt;br /&gt;</td>
<td class="tablebottom">&lt;br&gt; or &lt;br/&gt;</td></tr>
<tr>
<td class="tablebottom">&lt;hr /&gt; or &lt;hr noshade="noshade" /&gt;</td>
<td class="tablebottom">&lt;hr&gt; or &lt;hr/&gt; or &lt;hr noshade/&gt;</td></tr>
<tr>
<td class="tablebottom">&lt;img src="/img/directory/folder/file.ext" alt="" /&gt; <a href="#1"></td>
<td class="tablebottom">&lt;img src="/img/directory/folder/file.ext"&gt;</td></tr>
<tr>
<td class="tablebottom">&lt;a href="/page.php?id=" title="OSRS RuneScape Help's _______________"&gt;Text&lt;/a&gt;</td>
<td class="tablebottom">&lt;ahref="http://2007rshelp.com/page.php?id=" /&gt;Text&lt;/a&gt;</td></tr>
<tr>
<td class="tablebottom">&lt;p&gt;&lt;/p&gt;</td>
<td class="tablebottom">&lt;br /&gt;&lt;br /&gt; (can use &lt;br /&gt;&lt;br /&gt; if text is separated in same section)</td></tr>
<tr>
<td class="tablebottom">&lt;!-- text --&gt;<br />(only used to "comment out" part of a guide in testing area)</td>
<td class="tablebottom">&lt;!--- text ---!&gt;</td></tr>
<tr>
<td class="tablebottom">&lt;table width="100%" border="0" cellspacing="0" style="border-left: 1px solid #000"&gt;</td>
<td class="tablebottom">All else - centering a table: style="width:70%;margin:0 15%"<br />this means 70% width, margin left 15% and margin right 15% makes 30%, thus centered. width:60%;margin:0 20%; width:90%;margin:0 5%;</td>
<tr>
<td class="tablebottom">&lt;span style="color:red;"&gt;text&lt;/span&gt;</td>
<td class="tablebottom">&lt;font color="red"&gt;text&lt;/font&gt;</td></tr>
<tr>
<td class="tabletop" style="border-top: 0px;" colspan="2">OSRS RuneScape Help CSS Classes</td></tr>
<tr>
<td class="tablebottom">Image classes</td>
<td class="tablebottom">Just add: class="<em>class</em>" to the &lt;img src tag... <em>class</em> = fright (align right), fleft (left), fmid (middle)</td></tr>
<tr>
<td class="tablebottom">Content classes</td>
<td class="tablebottom">Just add: class="<em>class</em>" to the &lt;p tag... <em>class</em> = notice (pink warning), info (blue info box)</td></tr>
<tr>
<td class="tabletop" style="border-top: 0px;" colspan="2">x-HTML Strict (start using strict, but don't go converting everything)</td></tr>
<tr>
<td class="tabletop" style="border-top: 0px;">Strict</td>
<td class="tabletop" style="border-top: 0px;">Transitional</td></tr>
<tr>
<td class="tablebottom">&lt;strong&gt;&lt;/strong&gt;</td>
<td class="tablebottom">&lt;b&gt;&lt;/b&gt;</td></tr>
<tr>
<td class="tablebottom">&lt;em&gt;&lt;/em&gt;</td>
<td class="tablebottom">&lt;i&gt;&lt;/i&gt;</td></tr>
<tr>
<td class="tablebottom">&lt;del&gt;&lt;/del&gt;</td>
<td class="tablebottom">&lt;s&gt;&lt;/s&gt;</td></tr>
</table>

<div class="title1">Structuring Code</div>

<u>Title1 (#.0) sections</u><br /><br />
&lt;a name=""&gt;&lt;/a&gt;<br />
&lt;div class="title1"&gt;#.0 - Title&lt;/div&gt;<br /><br />
&lt;p&gt;PARAGRAPH TEXT&lt;/p&gt;<br /><br />

<u>Section lists</u><br /><br />
&lt;ul&gt;<br />
&lt;li&gt;Dot Point&lt;/li&gt;<br />
&lt;li&gt;Dot Point&lt;/li&gt;<br />
&lt;li&gt;Dot Point<br />
&lt;ul&gt;&lt;li&gt;Sub-dot point&lt;/li&gt;<br />
&lt;li&gt;Sub-dot point&lt;/li&gt;<br />
&lt;li&gt;Sub-dot point&lt;/li&gt;&lt;/ul&gt;&lt;/li&gt;<br />
&lt;li&gt;Dot Point&lt;/li&gt;&lt;/ul&gt;&lt;br /&gt;<br /><br />

</div>
<?php
end_page();
?>