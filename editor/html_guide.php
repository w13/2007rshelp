<?php
require('backend.php');
start_page(1,'The Guide to Using HTML on Zybez');
?>
<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<div style="margin:1pt; font-size:large; font-weight:bold;">
&raquo; <u>The Guide to Using HTML on Zybez</u></div>
<hr class="main" noshade="noshade" />
<table style="border-left: 1px solid #000000; border-top: 1px solid #000000" width="100%" cellpadding="5" cellspacing="0">
<tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">
<div class="title1">Table of Contents</div>
<ul class="toc">
<li><a href="#1">Understanding CSS</a>
<ul>
<li><a href="#1.1">Properties and Values</a></li>
<li><a href="#1.2">Classes</a></li>
</ul></li>
<li><a href="#2">General HTML & Text</a></li>
<ul>
<li><a href="#2.1">Lists</a></li>
<li><a href="#2.2">Links</a></li>
<li><a href="#2.3">Pointers</a></li>
</ul></li>
<li><a href="#3">Images</a></li>
<li><a href="#4">Tables</a></li>
</ul>

<div class="title1" id="1">Understanding CSS</div>
<p>In basic terms, CSS is used to make things look "pretty".  It allows you to align things the way you want them, pad images and text, alter the appearance of text, and much more.  It's key in making a good looking guide that people will want to read.  To put CSS on an HTML tag, you must use the <span style="font-family:Courier New;">style</span> attribute.</p>

<div class="title2" id="1.1">Properties and Values</div>
<p>Below you'll notice a table of the most used CSS properties, possible values, and descriptions that may seem daunting at first glance.  However, it's not really that bad.  You just add the property, followed by a colon, then the value followed by a semicolon inside the style tag.  The result appears as such: <span style="font-family:Courier New;">&lt;img src="/img/genimg/pyre/splitbark_set.gif" style="property:value;property:value;"&gt;</span>.  You may use the style attribute on any HTML tag, and you may use as many properties as you desire.</p>
<br />
<table cellspacing="0" style="border-left:1px #000 solid;">
<tr><td class="tabletop">Property</td><td class="tabletop">Values</td><td class="tabletop" width="50%">Description</td></tr>
<tr><td class="tablebottom">text-align</td><td class="tablebottom">center<br />right</td><td class="tablebottom">As the name suggests, it aligns the text to your desired alignment.  Never use the left value you with this property as that's the default.</td>
<tr><td class="tablebottom">padding</td><td class="tablebottom">#em<br />#px</td><td class="tablebottom">1em usually works well, but if you need to pad by a certain amount of pixels, you can do that as well. You may also use <span style="font-family:Courier New;">padding-left</span>, <span style="font-family:Courier New;">-right</span>, <span style="font-family:Courier New;">-bottom</span>, and <span style="font-family:Courier New;">-top</span> if you only want to pada certain side of the object.</td></tr>
<tr><td class="tablebottom">margin</td><td class="tablebottom">auto<br />#px<br />#em</td><td class="tablebottom">This is good for centering tables.  <span style="font-family:Courier New;">margin:0 auto;</span> will center objects.  That's pretty much the only practical use of this property on Zybez. You can pad just certain sides of an opject just like with the padding property.</td></tr>
<tr><td class="tablebottom">width & height</td><td class="tablebottom">#%<br />#px</td><td class="tablebottom">Defines the height or width of an object.</td></tr>
<tr><td class="tablebottom">color</td><td class="tablebottom">average color names (red, blue, green...)<br />HEX color codes (#000,#FFF,#333333...)</td><td class="tablebottom">Colors text.</td></tr>
<tr><td class="tablebottom">font-size</td><td class="tablebottom">#px<br />#em</td><td class="tablebottom">Resizes text.  You shouldn't usually need this.</td></tr>
<tr><td class="tablebottom">font-weight</td><td class="tablebottom">bold</td><td class="tablebottom">Has the same effect as <span style="font-family:Courier New;">&lt;strong&gt;</span> tags.  Only use this when you're using <span style="font-family:Courier New;">&lt;p&gt;</span> tags.  Otherwise, use <span style="font-family:Courier New;">&lt;strong&gt;</span> tags.  If you need extra properties, you may use the <span style="font-family:Courier New;">style</span> attribute on <span style="font-family:Courier New;">&lt;strong&gt;</span> tags.</td></tr>
</table>
<p class="info">A note about centering: if you're trying to center something with text in it, but you don't want the text to be center, wrap it in <span style="font-family:Courier New;">&lt;div style="text-align:center;"&gt;</span> and <span style="font-family:Courier New;">&lt;/div&gt;</span> tags and add <span style="font-family:Courier New;">style="text-align:left;"</span> to the object.</p>

<div class="title2" id="1.2">Classes</div>
<p>Classes may also be used to save you time writing CSS.  They're applied via the <span style="font-family:Courier New;">class</span> attribute, and can be used in any HTML tag.  An example of how to use a class is <span style="font-family:Courier New;">&lt;div class="title1"&gt;</span>  Most classes for Zybez however have tag specific style.  Below is a table of classes and what they do.</p>
<table cellspacing="0" style="border-left:1px #000 solid;width:100%;">
<tr><td class="tabletop">Name</td><td class="tabletop" style="width:80%;">Description</td></tr>
<tr><td class="tablebottom">info</td><td class="tablebottom"><p class="info" style="margin-top:0px;">To be used with <span style="font-family:Courier New;">&lt;div&gt;</span> and <span style="font-family:Courier New;">&lt;p&gt;</span> tags to give text this background.</p></td></tr>
<tr><td class="tablebottom">notice</td><td class="tablebottom"><p class="notice">To be used with <span style="font-family:Courier New;">&lt;div&gt;</span> and <span style="font-family:Courier New;">&lt;p&gt;</span> tags to give text this background.</p></td></tr>
<tr><td class="tablebottom">fright | fleft | fmid</td><td class="tablebottom">Aligns the desired object right, left, or center and adds an appropriate amount of padding.</td></tr>
<tr><td class="tablebottom">title1 | title2 | title3</td><td class="tablebottom">Used in <span style="font-family:Courier New;">&lt;div&gt;</span> tags to give guides titles some extra decoration.  Give integer titles title1 (ex: <span style="font-family:Courier New;">&lt;div class="title1"&gt;1.0 - Whatever&lt;/div&gt;</span>), decimail titles title2 (ex: <span style="font-family:Courier New;">&lt;div class="title2"&gt;1.1 - Whatever&lt;/div&gt;</span>) and minor titles title3 (ex: <span style="font-family:Courier New;">&lt;div class="title3"&gt;Whatever&lt;/div&gt;</span>).</td></tr>
<tr><td class="tablebottom">boxed</td><td class="tablebottom"><div class="boxed">Most likely to be used with the <span style="font-family:Courier New;">&lt;div&gt;</span> tag, it gives whatever it is wrapped in this appearance.</div></td></tr>
<tr><td class="tablebottom">tabletop | tablebottom</td><td class="tablebottom">Described more in the tables, section these two classes are always used when making tables.</td></tr>
<tr><td class="tablebottom">toc_img</td><td class="tablebottom">Used for images that are in the top-right of guides.</td></tr>
<tr><td class="tablebottom">toc</td><td class="tablebottom">Used in table of contents lists (ex: <span style="font-family:Courier New;">&lt;ul class="toc"&gt;</span>)</td></tr>
<tr><td class="tablebottom">faq</td><td class="tablebottom">Used with <span style="font-family:Courier New;">&lt;div&gt;</span> tags to make FAQ sections in guides.</td></tr>
</table>


<div class="title1" id="2">General HTML & Text</div>
<p>Zybez uses xHTML Transitional 1.0; that may not mean much to you in that context, but it means that we have to follow a few guidelines when it comes to writing HTML for guides.  For starters, this means not using deprecated tags.  Some popular deprecated tags are: <span style="font-family:Courier New;">&lt;center&gt;</span>, <span style="font-family:Courier New;">&lt;left&gt;</span>, <span style="font-family:Courier New;">&lt;right&gt;</span>, <span style="font-family:Courier New;">&lt;i&gt;</span>, <span style="font-family:Courier New;">&lt;b&gt;</span>.  Avoiding these is easy, fortunately. If you want to align text, just use <span style="font-family:Courier New;">&lt;div style="text-align:center;"&rt;</span>.  To italicize, use <span style="font-family:Courier New;">&lt;em&gt;</span> or <span style="font-family:Courier New;">style="font-style:italic;"</span> and to make text bold, use <span style="font-family:Courier New;">&lt;strong&gt;</span> or <span style="font-family:Courier New;">style="font-weight:bold;"</span>.</p>
<p>If you want to add CSS to text and there isn't already a tag being used (such as <span style="font-family:Courier New;">&lt;strong&gt;</span> or <span style="font-family:Courier New;">&lt;p&gt;</span>), you can use the <span style="font-family:Courier New;">&lt;span&gt;</span> tag.  This way, you can add style to a text without having to add it to an entire paragraph.</p>

<div class="title2" id="2.1">Lists</div>
<p>HTML lists are quite similar to the ones I'm sure you've used BBCode to make on forums.  The <span style="font-family:Courier New;">&lt;ul&gt;</span> tag makes lists that appear like normal lines of text, but the <span style="font-family:Courier New;">&lt;ol&gt;</span> tag indents the list and adds numbers.  Inside each of these tags, you need to use <span style="font-family:Courier New;">&lt;li&gt;</span> before each list item and <span style="font-family:Courier New;">&lt;/li&gt;</span> after each list item.  Below is an example.</p>
<div style="width:75%;font-family:Courier New;margin:0 auto;border:1px dashed #000;background:#999999;padding:5px;">
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">ol</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">li</span><span style="color:red;">&gt;</span></span>First item<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/li</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">li</span><span style="color:red;">&gt;</span></span>Second item<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/li</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/ol</span><span style="color:red;">&gt;</span></span></div>
<p>The most common use for lists is to create tables of content.  They're quite similar to normal lists, bar a few excepts.  You need to link each item and add a special class (<span style="font-family:Courier New;">toc</span>) to the <span style="font-family:Courier New;">&lt;ul&gt;</span> tag.
<div style="width:75%;font-family:Courier New;margin:0 auto;border:1px dashed #000;background:#999999;padding:5px;">
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">div class=<span style="color:green;">"</span><span style="color:blue;">title1</span><span style="color:green;">"</span></span><span style="color:red;">&gt;</span></span>Table of Contents<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/div</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">ul class=<span style="color:green;">"</span><span style="color:blue;">toc</span><span style="color:green;">"</span></span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">li</span><span style="color:red;">&gt;</span></span><span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">a href=<span style="color:green;">"</span><span style="color:blue;">#1</span><span style="color:green;">"</span></span><span style="color:red;">&gt;</span></span>1.0 Main Title<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/a</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">ul</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">li</span><span style="color:red;">&gt;</span></span><span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">a href=<span style="color:green;">"</span><span style="color:blue;">#1.1</span><span style="color:green;">"</span></span><span style="color:red;">&gt;</span></span>Secondary Title<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/a</span><span style="color:red;">&gt;</span></span><span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/li</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">li</span><span style="color:red;">&gt;</span></span><span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">a href=<span style="color:green;">"</span><span style="color:blue;">#1.2</span><span style="color:green;">"</span></span><span style="color:red;">&gt;</span></span>Secondary Title<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/a</span><span style="color:red;">&gt;</span></span><span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/li</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/ul</span><span style="color:red;">&gt;</span></span><span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/li</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">li</span><span style="color:red;">&gt;</span></span><span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">a href=<span style="color:green;">"</span><span style="color:blue;">#2</span><span style="color:green;">"</span></span><span style="color:red;">&gt;</span></span>Main Title<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/a</span><span style="color:red;">&gt;</span></span><span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/li</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/ul</span><span style="color:red;">&gt;</span></span></div>
<p>To make the titles link to the individual section title in the guide, you'd just use, for example: <span style="font-family:Courier New;">&lt;div class="title2" id="1.1"&gt;1.1 - Secondary Title&lt;/div&gt;</span>.  The <span style="font-family:Courier New;">id</span> attribute is what creates the link, and must be the same as what's in the <span style="font-family:Courier New;">href</span> attribute, but without the # sign.</p>

<div class="title2" id="2.2">Links</div>
<p>As you know, interconnection to other guides is important to help readers find their desired information easier as well as raising search rankings.  You can link text and images by wrapping them in <span style="font-family:Courier New;">&lt;a&gt;</span> tags.  The interconnection wizard can generate these easier, but if you can remember the process, it's easier to type it yourself.  You'll always need a <span style="font-family:Courier New;">href</span> and <span style="font-family:Courier New;">title</span> attribute.  A good <span style="font-family:Courier New;">&lt;a&gt;</span> tag looks like this: <span style="font-family:Courier New;">&lt;a href="/skills?id=8" title="Zybez Runescape Help's Agility Skill Guide"&gt;Text or image here&lt;/a&gt;</span>.</p>

<div class="title2" id="2.3">Pointers</div>
<p>There are a few things you have to watch for whenever you're writing HTML:</p>
<ol>
<li>Make sure your code is neat so that it can be edited more easily later one.  Put one line break in between sub-sections and two line breaks between main sections in guides.  Format your code for tables and lists as you see in this guide, putting each list item or cell on a separate line.</li>
<li>Never use “ or ‘ in guides.  Microsoft Word generates them.  They're not valid xHTML.  If you've written something in Word, do a find and replace in notepad to get rid of them.</li>
<li>On links, always put <span style="font-family:Courier New;">title="Zybez Runescape Help's ______ Guide"</span> and on images always put <span style="font-family:Courier New;">alt="Zybez Runescape Help's Image of ______"</span>.  It increases search term density and the <span style="font-family:Courier New;">alt</span> attribute is required for valid xHTML anyway.</li>
<li>If you don't want to display a certain piece of a guide, but you don't want to delete it, wrap it with <span style="font-family:Courier New;">&lt;!--</span> and <span style="font-family:Courier New;">--></span>.  This will make it visible in the editor, but not in the guide.</li>
<li><strong>Always</strong> use <span style="font-family:Courier New;">&lt;br /&gt; and &lt;hr /&gt;</span>.  The space is required for it to be valid.</li>
</ol>


<div class="title1" id="3">Images</div>
<p>Images are displayed in HTML via the <span style="font-family:Courier New;">&lt;img&gt;</span> tag.  This must <strong>always</strong> include the <span style="font-family:Courier New;">src</span> and <span style="font-family:Courier New;">alt</span> attributes.  They may also include the <span style="font-family:Courier New;">class</span> and <span style="font-family:Courier New;">style</span> attributes.  To align an image left, center, or right, use one of the following: <span style="font-family:Courier New;">class="fleft"</span>, <span style="font-family:Courier New;">class="fmid"</span>, or <span style="font-family:Courier New;">class="fright"</span>.  If you're striving to achieve something different, you can use the <span style="font-family:Courier New;">style</span> attribute with the properties listed above.  In the end, an example of what a good image tag should look like is <span style="font-family:Courier New;">&lt;img src="imageurl" alt="Zybez Runescape Help's Image of _______" class="fright" /&gt;</span>.</p>
<p>If you're updating an image and note that it has a lot of unnecessary code, please clean it up.  Also, take out the <span style="font-family:Courier New;">height</span> and <span style="font-family:Courier New;">width</span> attributes when you upload an updated version of an image because nearly every time, the new image will not be the same size.</p>


<div class="title1" id="3">Tables</div>
<p>Tables are often the trickiest thing for someone who's learning an HTML.  Linear tables are easy, but they can get more complicated.  For starters, tables on Zybez must always include <span style="font-family:Courier New;">cellspacing="0"</span> and <span style="font-family:Courier New;">style="border-left:1px solid #000;"</span>.  Then, the table classes will do the rest of the CSS for you.  To start a table, use <span style="font-family:Courier New;">&lt;table cellspacing="0" style="border-left:1px solid #000;"&gt;</span>.  Then, to start a row, use <span style="font-family:Courier New;">&lt;tr&gt;</span>.  For each cell in that row, use <span style="font-family:Courier New;">&lt;td class="tabletop"&gt;</span> or <span style="font-family:Courier New;">&lt;td class="tablebottom"&gt;</span>, depending on whether or not the cell is on the top row or not; then end each cell with <span style="font-family:Courier New;">&lt;/td&gt;</span> and then the row with <span style="font-family:Courier New;">&lt;/tr&gt;</span> and finally end the table with <span style="font-family:Courier New;">&lt;/table&gt;</span>.  Once you get those basics, you can start with <span style="font-family:Courier New;">rowspan</span> and <span style="font-family:Courier New;">colspan</span> attributes.  As one could infer from the name, they define how many rows or columns a cell stretches over.  For example, if you wanted the left column of the table to stretch over the height of the other columns, you'd simply add <span style="font-family:Courier New;">rowspan="# of rows+1"</span> to the <span style="font-family:Courier New;">&lt;td&gt;</span> tag. Or, you could add <span style="font-family:Courier New;">colspan="# of columns"</span> to make 1 row span over several columns.  Look at the examples below.</p>
<table style="margin:0 auto;width:100%;">
<tr>
<td>
<div style="width:90%;font-family:Courier New;margin:0 auto;border:1px dashed #000;background:#999999;padding:5px;">
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">table cellspacing=<span style="color:green;">"</span><span style="color:blue;">0<span style="color:green;">"</span></span> style=<span style="color:green;">"</span><span style="color:blue;">border-left:1px #000 solid;width:50%;margin:0 auto;</span><span style="color:green;">"</span></span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">tr</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">td class=<span style="color:green;">"</span><span style="color:blue;">tabletop</span><span style="color:green;">"</span></span><span style="color:red;">&gt;</span></span>Cell<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/td</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">td class=<span style="color:green;">"</span><span style="color:blue;">tabletop</span><span style="color:green;">"</span></span><span style="color:red;">&gt;</span></span>Cell<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/td</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/tr</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">tr</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">td class=<span style="color:green;">"</span><span style="color:blue;">tablebottom<span style="color:green;">"</span></span> rowspan=<span style="color:green;">"</span><span style="color:blue;">4</span><span style="color:green;">"</span></span><span style="color:red;">&gt;</span></span>Full column<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/td</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/tr</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">tr</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">td class=<span style="color:green;">"</span><span style="color:blue;">tablebottom</span><span style="color:green;">"</span></span><span style="color:red;">&gt;</span></span>Cell<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/td</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/tr</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">tr</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">td class=<span style="color:green;">"</span><span style="color:blue;">tablebottom</span><span style="color:green;">"</span></span><span style="color:red;">&gt;</span></span>Cell<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/td</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/tr</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">tr</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">td class=<span style="color:green;">"</span><span style="color:blue;">tablebottom</span><span style="color:green;">"</span></span><span style="color:red;">&gt;</span></span>Cell<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/td</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/tr</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/table</span><span style="color:red;">&gt;</span></span></div>
</td>
<td>
<div style="width:90%;font-family:Courier New;margin:0 auto;border:1px dashed #000;background:#999999;padding:5px;">
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">table cellspacing=<span style="color:green;">"</span><span style="color:blue;">0<span style="color:green;">"</span></span> style=<span style="color:green;">"</span><span style="color:blue;">border-left:1px #000 solid;width:50%;margin:0 auto;</span><span style="color:green;">"</span></span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">tr</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">td colspan=<span style="color:green;">"</span><span style="color:blue;">2<span style="color:green;">"</span></span> class=<span style="color:green;">"</span><span style="color:blue;">tabletop</span><span style="color:green;">"</span></span><span style="color:red;">&gt;</span></span>Full row<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/td</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/tr</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">tr</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">td class=<span style="color:green;">"</span><span style="color:blue;">tablebottom</span><span style="color:green;">"</span></span><span style="color:red;">&gt;</span></span>Cell<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/td</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">td class=<span style="color:green;">"</span><span style="color:blue;">tablebottom</span><span style="color:green;">"</span></span><span style="color:red;">&gt;</span></span>Cell<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/td</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/tr</span><span style="color:red;">&gt;</span></span><br /><span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">tr</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">td class=<span style="color:green;">"</span><span style="color:blue;">tablebottom</span><span style="color:green;">"</span></span><span style="color:red;">&gt;</span></span>Cell<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/td</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">td class=<span style="color:green;">"</span><span style="color:blue;">tablebottom</span><span style="color:green;">"</span></span><span style="color:red;">&gt;</span></span>Cell<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/td</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/tr</span><span style="color:red;">&gt;</span></span><br />
<span style="color:blue;"><span style="color:red;">&lt;</span><span style="color:purple;">/table</span><span style="color:red;">&gt;</span></span></div>
</td>
</tr>
<td>
<table cellspacing="0" style="border-left:1px #000 solid;width:75%;margin:0 auto;">
<tr>
<td class="tabletop">Cell</td>
<td class="tabletop">Cell</td>
</tr>
<tr>
<td class="tablebottom" rowspan="4">Full column</td>
</tr>
<tr>
<td class="tablebottom">Cell</td>
</tr>
<tr>
<td class="tablebottom">Cell</td>
</tr>
<tr>
<td class="tablebottom">Cell</td>
</tr>
</table>
</td>
<td>
<table cellspacing="0" style="border-left:1px #000 solid;width:50%;margin:0 auto;">
<tr>
<td colspan="2" class="tabletop">Full row</td>
</tr>
<tr>
<td class="tablebottom">Cell</td>
<td class="tablebottom">Cell</td>
</tr>
<tr>
<td class="tablebottom">Cell</td>
<td class="tablebottom">Cell</td>
</tr>
</table>
</td>
</tr>
</table>
</td></tr><tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Author: <b>Jeremy</b></td>  
</tr>
</table>
</div>

<?php
end_page();
?>