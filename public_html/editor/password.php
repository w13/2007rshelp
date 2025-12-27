<?php
require( 'backend.php' );
start_page(0, 'Change Password' );
echo '<div class="boxtop">Change Password</div>' . NL . '<div class="boxbottom" style="padding-left: 24px; padding-top: 6px; padding-right: 24px;">' . NL;

?>
<div style="margin:1pt; font-size:large; font-weight:bold;">&raquo; Change Password</div>
<hr noshade="noshade" />
<?php
$message = '<p>Use the form below to change your current password to a different one.</p>';

if( isset( $_POST['pass1'] ) AND isset( $_POST['pass2'] ) AND isset( $_POST['pass3'] ) ) {

	$pass1 = $_POST['pass1'];
	$pass2 = $_POST['pass2'];
	$pass3 = $_POST['pass3'];

	$enc_pass1 = md5( $pass1 );
	$enc_pass3 = md5( $pass3 );

	if( $pass1 == $pass2 ) {
		$crit1 = true;
	}
	else {
		$crit1 = false;
	}
	$len = strlen( $pass1 );
	if( $len >= 5 ) {
		$crit2 = true;
	}
	else {
		$crit2 = false;
	}
	if( $len <= 12 ) {
		$crit3 = true;
	}
	else {
		$crit3 = false;
	}
	if( $crit1 ) {
		$query = $db->query( "SELECT pass FROM admin WHERE user = '" . $_SESSION['user'] . "'" );
		$info = $db->fetch_array( $query );
		
		if( $info['pass'] == $enc_pass3 ) {
			$crit4 = true;
		}
		else {
			$crit4 = false;
		}
	}
	else {
		$crit4 = false;
	}
	if( $crit1 AND $crit2 AND $crit3  AND $crit4 ) {
		$query = $db->query( "UPDATE admin SET pass = '" . $enc_pass1 . "' WHERE user = '" . $_SESSION['user'] . "'" );
		$message = '<p>Your password has been changed sucessfully.</p>' . NL;
		$done;
	}
	elseif( !$crit1 ) {
		$message = '<p>Your new passwords did not match.</p>' . NL;
	}
	elseif( !$crit2 ) {
		$message = '<p>Your new password was too short. It must be between 5 and 12 characters.</p>' . NL;
	}
	elseif( !$crit3 ) {
		$message = '<p>Your new password was too long. It must be between 5 and 12 characters.</p>' . NL;
	}
	elseif( !$crit4 ) {
		$message = '<p>Your current password was incorrect.</p>' . NL;
	}	
}

echo $message;

if( !isset( $done ) ) {
?>
<br />
<form action="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>" method="POST">
<table width="50%" align="center" style="border-left: 1px solid #000000" cellspacing="0">
<tr>
<td class="tabletop" colspan="2">Change Password Form</td>
</td>
<tr>
<td class="tablebottom">New Password:</td>
<td class="tablebottom"><input type="password" name="pass1" /></td>
</tr>
<tr>
<td class="tablebottom">Retype New Password:</td>
<td class="tablebottom"><input type="password" name="pass2" /></td>
</tr>
<tr>
<td class="tablebottom">Current Password:</td>
<td class="tablebottom"><input type="password" name="pass3" /></td>
</tr>
<tr>
<td class="tablebottom" colspan="2"><input type="submit" value="Change Password" /></td>
</td>
</table>
</form><br />
<?php
}
echo '</div>'. NL;

end_page();
?>