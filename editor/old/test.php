<?php
/*$ROOT = '/usr/local/apache190/apache/htdocs/zybez/zybezwww/public_html';

$max_size = 100 * 1024;

$filetypes = array(
    'image/gif' => '.gif',
    'image/png' => '.png',
    'image/jpeg' => '.jpg',
    'image/jpeg' => '.jpeg');


if(isset($_FILES['img'])) {
    $ul_dir = '/img/staff/';
    $ul_name = basename($_FILES['img']['name']);
    $ul_file = $ROOT.$ul_dir.$ul_name;
    
    if(!array_key_exists($_FILES['img']['type'], $filetypes)) {
        echo 'Bad file Type.'; echo $_FILES['img']['type'];
    }
    elseif($_FILES['img']['size'] > $max_size) {
        echo 'File mustnot exceed '.$max_size.' bytes';
    }
    elseif(!move_uploaded_file($_FILES['img']['tmp_name'], $ul_file)) {
        echo 'File upload unsuccessful';
    }
    else {
        echo 'File is valid, and was successfully uploaded.';
    }
}
else {
   
    echo '<form action="'.$PHP_SELF.'" method="post" enctype="multipart/form-data">'
    .'<input type="hidden" name="MAX_FILE_SIZE" value="'.$max_size.'" />'
    .'<input type="file" name="img" />'
    .'<input type="submit" value="Submit" />';
    
    
}

function chars_encode($string) {
    $len = strlen($string);
    $estring = '';
    for($i = 0; $i < $len; $i++) {
       $estring .= '&#'.ord(substr($string, $i, 1)).';';
    }
    return $estring;
}

echo chars_encode('This is a test @#$%^&*');*/

$file = 'test2.php';
$notepad = file_get_contents($file);
$notepad .= "\n".$_SERVER['REMOTE_ADDR'];
$handle = fopen($file, 'a');
ftruncate ($handle, 0);
fwrite($handle, $notepad);
fclose($handle);

?>