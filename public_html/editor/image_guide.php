<?php
require('backend.php');
start_page(1,'The Guide to Zybez Images');
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
<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<div style="margin:1pt; font-size:large; font-weight:bold;">
&raquo; <u>The Guide to Zybez Images</u></div>
<hr class="main" noshade="noshade" />
<table style="border-left: 1px solid #000000; border-top: 1px solid #000000" width="100%" cellpadding="5" cellspacing="0">
<tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">
<div class="title1">Table of Contents</div>
<ul class="toc">
<li><a href="#1">Introduction/Paint.NET</a></li>
<li><a href="#2">Item Database Images</a></li>
<li><a href="#3">Monster Database Images</a></li>
<li><a href="#4">Mapping</a></li>
<li><a href="#5">Miscellaneous Images</a></li>
</ul>

<a name="1"></a>
<div class="title1">Introduction/Paint.NET</div>
<p>If you're reading this, you should already be knowledgeable to the four main goals of Zybez: quality, detail, enthusiasm and innovation.  The first two heavily pertain to properly taking images to be used on Zybez Runescape Help.  All images should be of good quality (saved as ".png" if they're not transparent and ".gif" if they are) and display what they're meant to effectively.  This includes getting a good angle on a monster picture, or zooming properly on an NPC for a quest image.  Always think about the quality and detail of images before you take them.</p>
<p>My recommended program for editing images, and the program this guide is written around, is Paint.NET.  Whilst one can do everything they need to in Paint.NET in either Photoshop or GIMP, I find Paint.NET to be the wisest choice.  This is because Photoshop costs a lot of cash and GIMP is much more complicated and harder to learn.  However, if you have these programs, you probably know how to use the efficiently enough to edit your images properly.  If not, don't worry; the tools in Paint.NET - and this guide - are very similar to those of all image editing programs.</p>
<p>You can download Paint.NET by clicking <a href="http://www.download.com/Paint-NET/3000-2192_4-10338146.html?part=dl-PaintNET&subj=dl&tag=button&cdlPid=10837963" title="">here</a>.</p>
<p class="info">When saving images as ".png", lowercase is preferred over uppercase.  However, this is only controlled by your program.  Microsoft Paint saves as ".PNG" whereas most others save as ".png".  The only time ".PNG" is preferred is when you're replacing an already existing image with that suffix.</p>

<a name="2"></a>
<div class="title1">Item Database Images</div>
<div class="notice">Microsoft Paint can not properly produce an item image.  This is because you never know if you're perfectly centered on the background.  You must use Paint.NET for the creation of these images.</div>
<p>Placing the item on its background correctly allows for managers to have an easier time moving the image to put it into the Item Database.  The following steps are to be taken in order to properly place an item on its background.</p>
<ol>
<li>Open a fairly large new canvas. 400 pixels wide and 400 pixels tall will work fine (<a href="/staff/jeremy/imageguide/new.png" title="">Picture</a>).</li>
<li>Paste your item image onto the canvas and drag it so that the actual item is near the bottom right of the canvas (<a href="/staff/jeremy/imageguide/bottomright.png" title="">Picture</a>).</li>
<li>Select the magic wand tool (<img src="/staff/jeremy/imageguide/magicwand.gif" alt="" />) and set the tolerance to 22%.</li>
<li>Click the background of the item and then press the delete key.  Continue until all background is removed. <b>Keep the black outline and the dark brown shadow!</b></li>
<li>Using the rectangle selection tool to select the very edges of the item (<a href="/staff/jeremy/imageguide/edgeselect.png" title="">Picture</a>). A 600%+ zoom helps with this step.</li>
<li>Copy the selection.</li>
<li>Open <a href="/staff/jeremy/imageguide/bg.png" alt="bg.png">bg.png</a> on a new canvas and create a new layer (<img src="/staff/jeremy/imageguide/newlayer.gif" alt="" />).</li>
<li>Paste the item onto the new layer. Save as "item_name.png".</li></ol>

<a href="#2" onclick=hide('tohide2')><div class="title2">Show/Hide The Video Guide</div></a><br />
<div id="tohide2" style="display:none;text-align:center;">
<object width="425" height="350" rel="nofollow" ><param name="movie" value="http://www.youtube.com/v/LnJ-QCB29Lo"></param><embed src="http://www.youtube.com/v/LnJ-QCB29Lo" type="application/x-shockwave-flash" width="425" height="350" rel="nofollow"></embed></object></div>

<p>Some items such as arrows, potions, seeds, and other stackables require an animated gif. Follow these steps to produce one.</p>
<ol>
<li>Make all the frames as you normally would saving the images as ".gif" instead.</li>
<li>Download <a href="http://ms-gif-animator.en.softonic.com/" title="">Microsoft GIF Animator</a>.</li>
<li>Add all of the frames (1-5 for arrows/seeds and the like or 1-4 for potions) using the Insert button (<img src="/staff/jeremy/imageguide/addframe.gif" alt="" />).</li>
<li>Under the "Animation" tab, check "Looping" and "Repeat Forever".</li>
<li>Press CTRL + L to select all the frames.  Under the "Image" tab, put "300" in the "Duration" field and make sure the "Undraw Method" is set to "Undefined" and that the "Transparency" box is unchecked.</li>
<li>Save as "item_name.gif".</li></ol>

<p>When making images for the Tomes Database, make the image transparent and safe as gif.  Do not put it on the background.</p>

<a name="3"></a>
<div class="title1">Monster Database Images</div>
<p class="info">If you do not have Paint.NET and do not wish to obtain it, you can crop monsters in Microsoft Paint.  Just use the eraser to delete every pixel except the monster leaving a white background.  This makes it easier for someone with Paint.NET to crop out the background to make it transparent.</p>
<p>To ensure that your monster picture is properly cropped, follow these steps:</p>
<ol>
<li>Open/paste your monster picture into your canvas.  Play around with the tolerace on the magic wand tool (<img src="/staff/jeremy/imageguide/magicwand.gif" alt="" />) as you select large portions of the background.</li>
<li>Once you have your desired selection, press the "Delete" key to remove the selection from the canvas.</li>
<li>Sometimes you'll need to use the eraser to get parts that don't agree with the monster's outline.</li>
<li>Use the rectangle selection tool to select a close box around the monster (if not exact), then press the crop to selection button (<img src="/staff/jeremy/imageguide/croptoselection.gif" alt="" />).</li>
<li>Once the monster is fully cropped, save as "monstername_level.gif".</li></ol>
<a href="#3" onclick=hide('tohide3')><div class="title2">Show/Hide The Video Guide</div></a><br />
<div id="tohide3" style="display:none;text-align:center;">
<object width="425" height="350"><param name="movie" value="http://www.youtube.com/v/QuPwyBC4QFY"></param><embed src="http://www.youtube.com/v/QuPwyBC4QFY" type="application/x-shockwave-flash" width="425" height="350"></embed></object></div>

<a name="4"></a>
<div class="title1">Mapping</div>
<p>Mapping can often times be tricky and require some experience with images, but having patience will make the process a lot easier.  First off, it's imperative that whilst mapping, you do <b>not</b> log out.  This will change your angle and change the color of the floor.  You should also try to get your images quickly to avoid too much trouble with the auto-angling anti-macro software in Runescape.  Follow these steps in order to map properly:</p>
<ol>
<li>Open <a href="http://www.gadwin.com/download/index.htm#PrintScreen" title="">Gadwin's Print Screen</a> or <a href="http://www.swiftkit.net/index.php?page=downloads" title="">SwiftKit</a> so that you can quickly save your screenshots with ease.</li>
<li>Set your screenshot program to take them in ".png" format.</li>
<li>Log into Runescape and go to the desired area. Set your brightness to the fourth setting on the bar.  Get your compass as close to north as possible and get the walls in straight lines.</li>
<li>Walk around taking more screenshots than you think you'd need to.  It's ok if you have overlapping images.</li>
<li>Once you're positive you have as many images as you need, sign out and open up your screenshots.</li>
<li>Cutting out the minimap with elipse or lasso selection tools, paste onto a clean canvas and patch them together until you have a full map.</li>
<li>Clean up any jagged lines with the pencil tool.  Use the eyedropper to select the floor color and then the pencil tool to erase NPC/item/player dots on the map.</li>
<li>Make all the surrounding area black and save.</li>
<li>Add the <a href="/staff/jeremy/imageguide/compass.gif" title="">compass</a> to a good place on the map (preferably top-right).</li>
<li>Paste the <a href="/staff/jeremy/imageguide/CELTG___.TTF" title="">Celtic Garamond the 2nd</a> and <a href="/staff/jeremy/imageguide/Argonaut-Regular.ttf" title="">Argonaut</a> fonts into "C:/WINDOWS/Fonts/".</li>
<li>Write "Mapped By: [NAME]" on the bottom of the map in Argonaut font.</li>
<li>On a new layer, write "Zybez" in a size that's appropriate to the map (usually 36+).  Lower the opacity to 30-50 (12-20%) depending on how it looks.</li>
<li>Mark NPCs/locations with the <a href="/editor/mapwiz.php" title="">dots</a> on a new layer and lower the opacity to about 150 (60%) opacity.</li>
<li>Save as a different filename than you previous did and upload both the marked and unmarked copies.</li></ol>

<a name="5"></a>
<div class="title1">Miscellaneous Images</div>
<p>Here are a few things to remember when you're uploading any type of image for the managers to put into its proper guide.</p>
<ol>
<li>If the image is transparent, save it as ".gif".  If it's not, save as ".png".</li>
<li>For quest scroll images, crop the scroll as close to the edges as possible.  Then open <a href="/staff/jeremy/imageguide/scroll_crop.gif">this image</a>, copy it, add a new layer to the scroll canvas, paste the image over it, merge the layers, then crop away the whitespace.  You'll be left with a perfectly cropped scroll.  Save as ".gif" and upload!</li>
<li>When uploading images that are meant to replace an already existing image, it helps us to save it as the exact file name it was previously saved as.  That way it'll overwrite the old image.</li>
<li>When possible, note in the Upload Images notepad what folder the image is to go into.</li>
<li>When uploading a map or any marked image, upload an unmarked copy as well.  This is so that we can make sure that the image looks its best before going onto Zybez.</li>
<li>If you see an image uploaded that's not complete, or not correct, go ahead and do it the right way.  For example, if an uncropped monster is uploaded, we'd greatly appreciate you cropping it and reuploading.</li>
</ol>

<p style="text-align:center;font-size:20px;font-weight:bold;">What are you waiting for? Start gathering images!</p>

</td></tr><tr><td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">Author: <b>Jeremy</b></td>  
</tr>
</table>
</div>
<?php
end_page();
?>