<?php
header('Content-type: image/png');

/** MAP & IMAGE SETTINGS **/

$map_dir = 'img/treasuretrails/locator/'; // Path to All Image Files
$convert1 = 2.163; // Pixels per Minute Conversion N/S
$convert2 = 2.143; // Pixels per Minute Conversion E/W

$v_zero = 3870; // Pixels from Top of Overall Map to Observatory
$h_zero = 1439; // Pixels from Left Side of Overall Map to Observatory

$out_h = 400; // Pixel Hieght for Output Image
$out_w = 400; // Pixel Width for Output Image



/** VERTICAL CALCULATIONS **/

// Get Degrees
$v_deg = (int)($_POST['v_deg'] ?? 0);

// Get Minutes
$v_min = (int)($_POST['v_min'] ?? 0);

// Calculate Total Minutes & Convert to Pixels
$v_min_total = ( $v_deg * 60 ) + $v_min;
$v_pix = $v_min_total * $convert1;

// Get Direction
$v_direction = $_POST['v_direction'] ?? 'north';
if (!in_array($v_direction, ['north', 'south'])) {
    $v_direction = 'north';
}

// Find Overall Dimensions
if( $v_direction == 'north' ) {
    $up = ( $v_zero - $v_pix );
}
else {
    $up = ( $v_zero + $v_pix );
}



/** HORIZONTAL CALCULATIONS **/

// Get Degrees
$h_deg = (int)($_POST['h_deg'] ?? 0);

// Get Minutes
$h_min = (int)($_POST['h_min'] ?? 0);

// Calculate Total Minutes & Convert to Pixels
$h_min_total = ( $h_deg * 60 ) + $h_min;
$h_pix = $h_min_total * $convert2;

// Get Direction
$h_direction = $_POST['h_direction'] ?? 'east';
if (!in_array($h_direction, ['east', 'west'])) {
    $h_direction = 'east';
}

// Find Overall Dimensions
if( $h_direction == 'east' ) {
    $across = ( $h_zero + $h_pix );
}
else {
    $across = ( $h_zero - $h_pix );
}



/** FIND MAP SECTION **/

// Find the Intervals
$atmp = floor( $across / 800 );
$utmp = floor( $up / 800 );

// Limit the Horizontal Interval - Define Horizontal Padding
if( $atmp <= 0 ) {
    $a = 0;
    $pada = 200;
}
elseif( $atmp >= 9 ) {
    $a = 9;
    $pada = 200;
}
else {
    $a = $atmp;
    $pada = 200;
}

// Limit the Vertical Interval - Define Vertical Padding
if( $utmp <= 0 ) {
    $u = 0;
    $padu = 190;
}
elseif( $utmp >= 7 ) {
    $u = 7;
    $padu = 200;
}
else {
    $u = $utmp;
    $padu = 200;
}

// Use Intervals to Calculate Map Start Point
$simg_w = ( $a * 800 ) - $pada;
$simg_h = ( $u * 800 ) - $padu;



/** FINAL CALCULATIONS **/

// Specific Map Dimensions
$up = $up - $simg_h;
$across = $across - $simg_w;

// Generate Map Name
$map_name = 'map' . $a . $u;



/** IMAGE GENERATION **/

$halfout_h = $out_h / 2;
$halfout_w = $out_w / 2;

// Create Output Image Base
$img = imagecreatetruecolor( $out_w, $out_h );

// Create Image and Copy RuneScape World Map Section
$big_map = imagecreatefrompng( $map_dir . $map_name . '.png' );
imagecopy( $img, $big_map, 0, 0, ( $across - $halfout_w ), ( $up - $halfout_h ), $out_w, $out_h );

// Create and Copy Crosshair Image.
$red = imagecreatefrompng( $map_dir . 'red.png' );
imagecopy( $img, $red, 0, $halfout_h, 0, 0, $out_w, 1 );
imagecopy( $img, $red, $halfout_w, 0, 0, 0, 1, $out_h );

// Create and Copy Compass Image
$comp = imagecreatefromgif( $map_dir . 'comp.gif' );
imagecopy( $img, $comp, ( $out_w - 70 ), 0, 0, 0, 70, 70 );

// Create and Scale Image
//$scale = imagecreatefromgif( $map_dir . 'scale.gif' );
//imagecopy( $img, $scale, 0, 10, 0, 0, 149, 33 );

// Output the Image
imagepng( $img );

// Destroy the Image
imagedestroy( $img );
?>