<?php

$folder = $_GET['folder'];
$folder_array = array('monsters','skills','guilds','misc','quests');

if (in_array($folder,$folder_array)) {
	$folder = 'uploads/'.$folder.'/';
	$folder2 = ucwords($_GET['folder']);
} else {
	$folder = 'uploads/';
	$folder2 = 'Main';
}


require(dirname(__FILE__) . '/' . 'backend.php');
require('edit_class.php');
include (dirname(__FILE__) . '/' . 'upload_class.php');

start_page( 19, 'Upload Images' );
//<!-- UPLOAD CODE
$max_size = 500 * 1024; // the max. size for uploading
$max_sizekb = $max_size / 1024;
$my_upload = new file_upload;

$my_upload->upload_dir = (dirname(__FILE__) . '/' . $folder); // "files" is the folder for the uploaded files (you have to create this folder)
$my_upload->extensions = array(".png", ".gif"); // specify the allowed extensions here
// $my_upload->extensions = "de"; // use this to switch the messages into an other language (translate first!!!)
$my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
$my_upload->rename_file = false;
		
if(isset($_POST['Submit'])) {
	$my_upload->the_temp_file = $_FILES['upload']['tmp_name'];
	$my_upload->the_file = $_FILES['upload']['name'];
	$my_upload->http_error = $_FILES['upload']['error'];
	$my_upload->replace = (isset($_POST['replace'])) ? $_POST['replace'] : "n"; // because only a checked checkboxes is true
	$my_upload->do_filename_check = (isset($_POST['check'])) ? $_POST['check'] : "n"; // use this boolean to check for a valid filename
	$new_name = (isset($_POST['name'])) ? $_POST['name'] : "";
	$myname = $my_upload->the_file;
	if ($my_upload->upload($new_name)) { // new name is an additional filename information, use this to rename the uploaded file
		$full_path = $my_upload->upload_dir.$my_upload->file_copy;
		$info = $my_upload->get_uploaded_file_info($full_path);
		// ... or do something like insert the filename to the database
	}
        $ses->record_act('Upload Images ('.$folder2.')', 'Upload', $myname, $ip);
}
/// UPLOAD CODE -->




?>
<div class="boxtop">Upload Images</div><div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">
<?php

?>
<div align="left" style="margin:1">
<b><font size="+1">&raquo; <a href="upload.php">Image Upload Form</a></font></b>
</div>
<hr class="main" noshade="noshade" /><br />

<div class="notice" style="color:#000;"><b>DO NOT INSERT THE IMAGE INTO A GUIDE USING /EDITOR/UPLOADS PATH. EVER.</b><br /><br />
Please ensure your image has been appropriately cropped before uploading.<br />
If you are uploading a newer picture of an image already in a guide, give it the same file name.<br />
The filename for the image will be whatever you call it, provided it's appropriate; your image will be moved to the right folder.
</div><br />

<div class="notice">
<ul>
<li>Check <a href="/community/index.php?showtopic=1171046" style="color:black;font-weight:bold;">this topic</a> for new image submissions regularly.</li>
<li>Make sure you check images before you upload them for the quality standards listed on the topic.</li>
<li>When you upload images, please quote and reply in the topic so that no one does them twice.</li>
<li>Do <strong>NOT</strong> check the HD boxes in guides/monsters after you've uploaded images.  The manager will do that when they move the images.  However, if they forget and the images have been moved and all the imagea in the guide are HD, you may check the box.</li></ul></div><br />

<form name="form1" enctype="multipart/form-data" method="post" action="<?php $_SERVER['REQUEST_URI']; ?>">
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_size; ?>">
<table style="border: 2px solid #000; padding: 2px; border-bottom:none;" align="center" width="75%">
<tr>
<td colspan="2" align="center">Max filesize = <?php echo $max_sizekb; ?>KB.</td>
</tr>
<tr>
<td width="34%" align="right"><label for="upload">Browse: </label><br />&nbsp;</td>
<td width="66%"><img src="/img/idbimg/bg.png" style="float:right;" /><input type="file" name="upload" size="30" /><br />Accepts: png and gif only.</td>
</tr>
<tr>
<td align="right">
<!--<label for="name">Rename after upload?</label><br />-->
<div style="display:none;"><label for="check">ALWAYS keep checked: </label></div></td>
<td>
<!--<input type="text" name="name" size="30" /> (without the extension)<br />-->
<div style="display:none;"><input name="check" type="checkbox" value="y" checked="checked" /></div></td>
</tr>
<?php
		if( $ses->permit( 8 ) ) {
?>
<tr>
<td align="right"><label for="replace">Upload and replace?</label></td>
<td><input type="checkbox" name="replace" value="y"></td>
</tr>
<?php
}
?>
<tr>
<td colspan="2" align="center">If not obvious, please indicate what your image is for in the notepad.<br /><br /><input type="submit" name="Submit" value="Upload Now" /></tr>
<tr>
<td colspan="2"><br />
<?php echo $my_upload->show_error_string(); ?>
<?php if (isset($info)) echo "<blockquote><b>Details:</b><br />".nl2br($info)."</blockquote>"; ?></td></tr></table>
</form>
<?php
$info = $db->fetch_row("SELECT * FROM `admin_pads` WHERE `file` = 'upload".$folder2."'");
$last = format_time( $info['time'] + 21600 );
if( isset( $_POST['text'] ) ) {
    $pad = addslashes( $_POST['text'] );
    $query = $db->query("UPDATE `admin_pads` SET `text` = '".$pad."', `time` = '".time()."' WHERE `file` = 'upload".$folder2."'");
    $ses->record_act('Upload Images ('.$folder2.')', 'Edit', 'Notepad', $ip);
    header("Location: ".$_SERVER['REQUEST_URI']);
	}

echo '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post"><table style="border: 2px solid #000; text-align:center; padding: 2px;" align="center" width="75%">';
echo '<tr><td><textarea name="text" rows="15" style="width: 95%; font: 10px Verdana, Arial, Helvetica, sans, sans serif;">' . $info['text'] . '</textarea></td></tr>';
echo '<tr><td><input type="submit" value="Update" />&nbsp;<input type="reset" value="Undo Changes" /></td></tr></table>';
echo '</form><br /><br />';
?>

<table width="100%" cellspacing="0" style="border-left: 1px solid #000">
<tr>
<td class="tabletop">Preview Images</td></tr>
<tr>
<td class="tablebottom">
<?php 
// <!-- PRINCE'S CODE
$path  = (dirname(__FILE__) . '/' . $folder);

	$dir_handle  =  @opendir($path)  or  die("Unable  to  open  $path"); 
		while  ($file  =  readdir($dir_handle))  { 

	if($file  ==  "."  ||  $file  ==  ".."  ||  $file  ==  "index.php" || $file == "editor-uploads" || in_array($file,$folder_array)) 
	continue; 

		echo  "$file<br /><img src=\"$folder$file\" alt=\"$file\" border=\"0\" /><hr /><br />\n";
	}

closedir($dir_handle); 

// PRINCE'S CODE -->
?>
</td></tr>
</table><br />
</div>

<?php
end_page();
?>