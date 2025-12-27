<?php

$item_pw = 420;
$item_ph = 300;

$cat_pw = 520;
$cat_ph = 350;

if(isset($_GET['anchor'])) {
     $anchor = $_GET['anchor'];
     $query = str_replace('&anchor='.$anchor, '', $_SERVER['QUERY_STRING']);
     header('refresh: 0; url='.htmlspecialchars($_SERVER['PHP_SELF']).'?'.$query.'#'.$anchor);
}

require('backend.php');
require('price_cat_functions.inc.php');
start_page(10, 'Marketplace Manager', 'popup.inc');
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
<?php
echo '<div class="boxed" style="width:578px;"><a href="'.htmlspecialchars($_SERVER['PHP_SELF']).'">Marketplace Manager</a></div>'.NL.'<div class="boxbottom" style="padding-left: 24px; padding-top: 1px; padding-right: 24px;width:530px;">'.NL.NL;

echo '<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="get">'.NL.NL;

$query = $db->query("SELECT * FROM price_groups WHERE parent = 1 ORDER BY lft ASC");

$align = 'left';
while($info = $db->fetch_array($query)) {
    
    if(isset($_GET['area']) AND $_GET['area'] ==  $info['id']) {
        $class = 'boxed';
    }
    else {
        $class = 'boxed';
    }
    echo '<div class="'.$class.'" style="float: '.$align.'; width: 49%; margin-top: 5px;"><a href="'.htmlspecialchars($_SERVER['PHP_SELF']).'?area='.$info['id'].'" />'.$info['title'].'</a></div>'.NL;

    if($align == 'right') {
        $align = 'left';
    }
    else {
        $align = 'right';
    }    
}
echo '<div style="float: '.$align.'; width: 49%; margin-top: 5px;"><input type="submit" value="Search For" style="width: 40%;" / >&nbsp;<input type="text" name="search_terms" value="'.mysqli_real_escape_string($db->connect, $_GET['search_terms']).'" style="width: 55%;" /></div>'.NL;

echo '</form>'.NL.NL;

echo '<div style="clear: both;"></div>'.NL;

if(isset($_POST['moveitm']) AND isset($_POST['ids']) AND isset($_POST['category'])) {
    echo '<br /><hr />'.NL.NL;
    $ids = unserialize(base64_decode($_POST['ids']));
    $par = base64_decode($_POST['par']);
    $first = true;
    if($_POST['category'] != 0) {
        for($i = 0; array_key_exists($i, $ids); $i++) {
            if($first) {
                $idq = 'id = '.$ids[$i];
                $idq2 = 'phold_id = '.$ids[$i];
                $first = false;
            }
            else {
                $idq .= ' OR id = '.$ids[$i];
                $idq2 .= ' OR id = '.$ids[$i];
            }
        }
        if(!$first) {
            $category = intval($_POST['category']);
            $db->query("UPDATE price_items SET category = ".$category." WHERE ".$idq);
            $db->query("UPDATE price_items SET phold_cat = ".$category." WHERE ".$idq);
            echo '<p align="center">The selected items have been moved.</p>'.NL;
            //header('refresh: 1; url='.htmlspecialchars($_SERVER['PHP_SELF']).'?'.$par);
        }
        else {
            echo '<p align="center">No action. There were no items selected.</p>';
            //header('refresh: 1; url='.htmlspecialchars($_SERVER['PHP_SELF']).'?'.$par);
        }
    }
    else {
        echo '<p align="center">Items cannot be placed in this category.</p>';
        header('refresh: 1; url='.htmlspecialchars($_SERVER['PHP_SELF']).'?'.$par);
    }
}
elseif(isset($_POST['iact']) AND $_POST['iact'] == 'move') {
    echo '<br /><hr />'.NL.NL;
    $first = true;
    for($i = 1; $i <= $_POST['itotal']; $i++) {
        if(isset($_POST['sel'.$i])) {
            $id = $_POST['sel'.$i];
            if($first) {
                $ids = array();
                $ids[] = $id;
                $idq = 'id = '.$id;
                $first = false;
            }
            else {
                $idq .= ' OR id = '.$id;
                $ids[] = $id;
            }
        }
    }
    if(!$first) {
        if(!isset($_POST['par'])) $par = base64_encode($_SERVER['QUERY_STRING']);
        else $par = $_POST['par'];
        $ids_enc = base64_encode(serialize($ids));
        $query = $db->query("SELECT * FROM price_items WHERE ".$idq);
        echo '<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="post">'.NL;
        echo '<input type="hidden" name="ids" value="'.$ids_enc.'" /><input type="hidden" name="moveitm" value="true" /><input type="hidden" name="par" value="'.$par.'" />'.NL;
        echo '<p><span class="title3">Move the following items to </span><select name="category">'.NL;
        echo '<option value="0">Select a Category</option>'.NL;
        $tree = display_tree(1);
        for($num = 1; array_key_exists($num, $tree); $num++) {
            $ind = str_repeat('--', $tree[$num]['ind']-1);
            if($tree[$num]['ind'] < 2) {
                echo '<option value="0">&nbsp;</option>'.NL;
                echo '<option value="0" style="font-weight: bold; font-size: 11px;">'.$tree[$num]['title'].'</option>'.NL;
            }
            elseif($tree[$num]['items'] == 0) {
                echo '<option value="0">'.$ind.' '.$tree[$num]['title'].'</option>'.NL;
            }      
            else {
                echo '<option value="'.$tree[$num]['id'].'">'.$ind.' '.$tree[$num]['title'].'</option>'.NL;
            }
        }
        echo '</select> <input type="submit" value="Go" /></p>'.NL;
            
        while($info = $db->fetch_array($query)) {
            echo '&raquo; '.$info['name'];
            if(!empty($info['phold_id'])) echo ' (Placeholder)';
            echo '<br />'.NL;
        }
        echo '</form>'.NL;
    }
    else {
        echo '<p align="center">There were no items selected. Please try again.</p>'.NL;
    }
}
elseif(isset($_POST['delitm']) AND isset($_GET['par']) AND $ses->permit(15)) {
    echo '<br /><hr />'.NL.NL;
    $id = intval($_POST['delitm']);
    $db->query("DELETE FROM price_items WHERE id = ".$id." OR phold_id = ".$id);
    $db->query("UPDATE price_items SET iorder = iorder - 1 WHERE category = '".$_POST['category']."' AND iorder > ".$_POST['iorder']);
    $par = base64_decode($_GET['par']);
    header('refresh: 1; url='.htmlspecialchars($_SERVER['PHP_SELF']).'?'.$par);
    echo '<p align="center">Entry successfully deleted from OSRS RuneScape Help.</p>'.NL;
}
elseif(isset($_GET['delitm']) AND isset($_GET['par']) AND $ses->permit(15)) {
    echo '<br /><hr />'.NL.NL;
    $id = intval($_GET['delitm']);
    $area = intval($_GET['area']);
    $cat = intval($_GET['cat']);
    $info = $db->fetch_row("SELECT * FROM price_items WHERE id = ".$id);

    $par = base64_decode($_GET['par']);
    
    if($info) {
        $name = $info['name'];
        $before = (!empty($info['phold_id'])) ? 'placeholder' : 'item';
        echo '<p align="center">Are you sure you want to delete the '.$before.', \''.$name.'\'</p>';
        echo '<form method="post" action="'.htmlspecialchars($_SERVER['PHP_SELF']).'?par='.$_GET['par'].'"><center><input type="hidden" name="delitm" value="'.$id.'" / ><input type="hidden" name="iorder" value="'.$info['iorder'].'" / ><input type="hidden" name="category" value="'.$info['category'].'" / ><input type="hidden" name="right" value="'.$info['rgt'].'" / ><input type="submit" value="Yes" /></center></form>'.NL;
        echo '<form method="post" action="'.htmlspecialchars($_SERVER['PHP_SELF']).'?'.$par.'"><center><input type="submit" value="No" /></center></form>'.NL;
			$ses->record_act('Price Guide', 'Delete', $name, $ip);
    }
    else {
        echo '<p align="center">That identification number does not exist.</p>'.NL;
        echo '<p align="center"><a href="javascript:history.go(-1)"><b>&lt;-- Go Back</b></a></p>'.NL;
    }
}
elseif(isset($_POST['delcat']) AND isset($_GET['area']) AND $ses->permit(15)) {
    echo '<br /><hr />'.NL.NL;
    delete_category($_POST['delcat'], $_POST['left'], $_POST['right']);
    header('refresh: 1; url='.htmlspecialchars($_SERVER['PHP_SELF']).'?area='.$_GET['area'].'&conf=yes');
    echo '<p align="center">Entry successfully deleted from OSRS RuneScape Help.</p>'.NL;
}
elseif(isset($_GET['delcat']) AND isset($_GET['area']) AND $ses->permit(15)) {
    echo '<br /><hr />'.NL.NL;
    $id = intval($_GET['delcat']);
    $area = intval($_GET['area']);
    $info = $db->fetch_row("SELECT * FROM price_groups WHERE id = ".$id);
    
    $check1 = $db->num_rows("SELECT * FROM price_groups WHERE parent = ".$id);
    $check2 = $db->num_rows("SELECT * FROM price_items WHERE category = ".$id);
    $check = $check1 + $check2;
    
    if($info AND $check == 0) {
    
        $title = $info['title'];
        echo '<p align="center">Are you sure you want to delete the category, \''.$title.'\'</p>';
        echo '<form method="post" action="'.htmlspecialchars($_SERVER['PHP_SELF']).'?area='.$_GET['area'].'&conf=yes"><center><input type="hidden" name="delcat" value="'.$id.'" / ><input type="hidden" name="left" value="'.$info['lft'].'" / ><input type="hidden" name="right" value="'.$info['rgt'].'" / ><input type="submit" value="Yes" /></center></form>'.NL;
        echo '<form method="post" action="'.htmlspecialchars($_SERVER['PHP_SELF']).'?area='.$_GET['area'].'&conf=yes"><center><input type="submit" value="No" /></center></form>'.NL;
    }
    elseif($info AND $check > 0) {
        $title = $info['title'];
        echo '<p align="center">Are still '.$check.' entries within the category \''.$title.'\'.</p>'.NL;
        echo '<p align="center">Categories cannot be deleted until they are empty.</p>';
        echo '<p align="center"><a href="javascript:history.go(-1)"><b>&lt;-- Go Back</b></a></p>'.NL;
    }
    else {
        echo '<p align="center">That identification number does not exist.</p>'.NL;
        echo '<p align="center"><a href="javascript:history.go(-1)"><b>&lt;-- Go Back</b></a></p>'.NL;
    }
}
elseif(isset($_GET['conf']) AND isset($_GET['area'])) {

    echo '<br /><hr />'.NL.NL;
    
    $area = $_GET['area'];
    $tree = display_tree($area);
    $after = $tree[0]['rgt'] - 1;
    $en_url = base64_encode($_SERVER['QUERY_STRING']);

    echo '<a href="javascript: void(0)" onclick="javascript:window.open(\'/editor/pricec_popup.php?act=new&area='.$area.'&after='.$after.'&par='.$en_url.'\', \'new\', \'left=600,width='.$cat_pw.',height='.$cat_ph.',scrollbars=no,location=yes\')"><img src="images/new_category.gif" alt="New Category" align="right" border="0" /></a>'.NL;
    echo '<div style="font-size: 14px;"><b>Configuring '.$tree[0]['title'].'</b></div>'.NL;
    echo '<a name="'.$tree[0]['id'].'" href="javascript: void(0)" onclick="javascript:window.open(\'/editor/pricec_popup.php?act=edit&id='.$tree[0]['id'].'&par='.$en_url.'\', \'cat'.$tree[0]['id'].'\', \'left=600,width='.$cat_pw.',height='.$cat_ph.',scrollbars=no,location=yes\')">Edit</a>';
    if($ses->permit(15)) {
        echo ' / <a href="'.htmlspecialchars($_SERVER['PHP_SELF']).'?delcat='.$tree[0]['id'].'&area='.$area.'">Delete</a>';
    }
    echo '<br /><br />'.NL;
    echo '<table style="border-left: 1px solid #000000;" width="100%" cellpadding="1" cellspacing="0">'.NL;
    echo '<tr>'.NL;
    echo '<td class="tabletop">Category:</td>'.NL;
    echo '<td class="tabletop">Action:</td>'.NL;
    echo '</tr>'.NL.NL;
    for($num = 1; array_key_exists($num, $tree); $num++) {
    
        $id = $tree[$num]['id'];
        $title = $tree[$num]['title'];
        $items = $tree[$num]['items'];
        $ind = $tree[$num]['ind'];

        if($ind == 1) $sym = '&raquo;';
        elseif($ind == 2) $sym = '+';
        else $sym = '-';
        
        $fsize = 13 - $ind;
        $marg = 20 * $ind;
        
        echo '<tr>'.NL;
        echo '<td class="tablebottom" style="text-align: left;">';
        echo '<div style="font-size: '.$fsize.'px; margin-left: '.$marg.'px;">'.$sym.' '.$title.'</div>';
        echo '</td>'.NL;
        echo '<td class="tablebottom"><a name="'.$info['id'].'" href="javascript: void(0)" onclick="javascript:window.open(\'/editor/pricec_popup.php?act=edit&id='.$id.'&par='.$en_url.'\', \'cat'.$id.'\', \'left=600,width='.$cat_pw.',height='.$cat_ph.',scrollbars=no,location=yes\')">Edit</a>';
        if($ses->permit(15)) {
            echo ' / <a href="'.htmlspecialchars($_SERVER['PHP_SELF']).'?delcat='.$id.'&area='.$area.'">Delete</a>';
        }
        echo '</td>'.NL;
        echo '</tr>'.NL;
    }
    if($num == 1) {
        echo '<tr>'.NL;
        echo '<td class="tablebottom" colspan="2">No Categories Found.</td>'.NL;
        echo '</tr>'.NL;
    }
    echo '</table>'.NL;
    

}
elseif(isset($_GET['area']) OR isset($_GET['category'])) {

    echo '<br /><hr />'.NL.NL;
    
    if(!isset($_GET['category'])) {
        $area = $_GET['area'];
    }
    else {
        $category = intval($_GET['category']);
        $cinfo = $db->fetch_row("SELECT * FROM price_groups WHERE id = ".$category);
        $lft = intval($cinfo['lft']);
        $ainfo = $db->fetch_row("SELECT * FROM price_groups WHERE parent = 1 AND lft < ".$lft." AND rgt > ".$lft);
        $area = $ainfo['id'];
    }
    $tree = display_tree($area);

    echo '<a href="'.htmlspecialchars($_SERVER['PHP_SELF']).'?area='.$tree[0]['id'].'&conf=yes" title="Configure \''.$title.'\'"><img src="images/area_configuration.gif" alt="Area Configuration" align="right" border="0" /></a>'.NL;
    echo '<div style="font-size: 14px;"><b>Browsing '.$tree[0]['title'].'</b></div><br />'.NL.NL;
    for($num = 1; array_key_exists($num, $tree); $num++) {
    
        $id = $tree[$num]['id'];
        $title = $tree[$num]['title'];
        $parent = $tree[$num]['parent'];
        $items = $tree[$num]['items'];
        $ind = $tree[$num]['ind'];
        
        if($_GET['category'] == $id) $title = '<b><i>'.$title.'</i></b>';
        
        if($ind == 1) $sym = '&raquo;';
        elseif($ind == 2) $sym = '+';
        else $sym = '-';
        
        $fsize = 13 - $ind;
        $marg = 20 * $ind;
        
        if($items) {
            echo '<div style="font-size: '.$fsize.'px; margin-left: '.$marg.'px; margin-bottom: 2px;">'.$sym.' <a href="'.htmlspecialchars($_SERVER['PHP_SELF']).'?category='.$id.'#ilist" title="View Category">'.$title.'</a></div>'.NL;
        }
        else {
            echo '<div style="font-size: '.$fsize.'px; margin-left: '.$marg.'px; margin-bottom: 2px;">'.$sym.' '.$title.'</div>'.NL;
        }
    }
    if($num == 1) {
        echo '<p align="center">No Categories Found.</p>'.NL;
    }
    
    if(!empty($category)) {

        $en_url = base64_encode($_SERVER['QUERY_STRING']);
                
        if($cinfo['items'] == 1)    {
        
            if(isset($_POST['iact']) AND $_POST['iact'] == 'order') {
                $order_error = false;
                $array = array();
                
                for($num = 1; $num <= $_POST['itotal']; $num++) {
                    $id = $_POST['id'.$num];
                    $iorder = $_POST['iorder'.$num];
                    if(array_key_exists($iorder, $array)) {
                        $order_error = true;
                        break;
                    }
                    else {
                        $array[$iorder] = $id;
                    }
                }
                
                if(!$order_error) {
                    foreach($array AS $iorder => $id) {
                        $db->query("UPDATE price_items SET price_items.iorder = ".$iorder." WHERE id = ".$id);
                    }
                }
            }
            echo '<br /><hr />'.NL.NL;
            
            echo '<a href="javascript: void(0)" onclick="javascript:window.open(\'/editor/price_popup.php?act=new&category=' .$category.'&par='.$en_url.'\', \'new\', \'left=600,width='.$item_pw.',height='.$item_ph.',scrollbars=no,location=yes\')"><img src="images/new_item2.gif" title="New Item" border="0" align="right" /></a>'.NL;
            echo '<a href="javascript: void(0)" onclick="javascript:window.open(\'/editor/pricep_popup.php?act=new&category=' .$category.'&par='.$en_url.'\', \'new\', \'left=600,width='.$item_pw.',height='.$item_ph.',scrollbars=no,location=yes\')"><img src="images/new_placeholder.gif" title="New Item" border="0" align="right" /></a>'.NL;
            echo '<a name="ilist"></a>'.NL;
            echo '<div style="font-size: 12px; margin-bottom: 10px; margin-top: 8px;"><b>Viewing '.$cinfo['title'].'</b></div>'.NL.NL;
            
            $query = $db->query("SELECT * FROM price_items WHERE category = ".$category." ORDER BY price_items.iorder ASC");
            $total = mysqli_num_rows($query);
            $ids = array();
            
            echo '<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'?'.$_SERVER['QUERY_STRING'].'" method="post">'.NL;
            echo '<table style="border-left: 1px solid #000000;" width="100%" cellpadding="1" cellspacing="0">'.NL;
            echo '<tr>'.NL;
            echo '<td class="tabletop">&nbsp;</td>'.NL;
            echo '<td class="tabletop">Name:</td>'.NL;
            echo '<td class="tabletop">Price:</td>'.NL;
            echo '<td class="tabletop">Action:</td>'.NL;
            echo '<td class="tabletop">Order:</td>'.NL;
            echo '<td class="tabletop">Sel:</td>'.NL;
            echo '</tr>'.NL.NL;
            
            for($count = 1; $info = $db->fetch_array($query); $count++) {
                $ids[] = $info['id'];
                echo '<tr>'.NL;
                if(empty($info['phold_id'])) {
                    if(empty($info['price_high'])) {
                        $price = number_format($info['price_low']).'gp';
                    }
                    else {
                        $price = number_format($info['price_low']).'gp - '.number_format($info['price_high']).'gp';
                    }
                    echo '<td class="tablebottom">'.$info['id'].'</td>'.NL;
                    echo '<td class="tablebottom">'.$info['name'];
                    if($info['member'] == 1) echo '<img src="images/member.gif" alt="(m)"/>';
                    echo '</td>'.NL;
                    echo '<td class="tablebottom">'.$price.'</td>'.NL;
                    echo '<td class="tablebottom"><a name="'.$info['id'].'" href="javascript: void(0)" onclick="javascript:window.open(\'/editor/price_popup.php?act=edit&id='.$info['id'].'&par='.$en_url.'\', '.$info['id'].', \'left=600,width='.$item_pw.',height='.$item_ph.',scrollbars=no,location=yes\')">Edit</a>';
 
                }
                else {
                    echo '<td class="tablebottom" colspan="3"> Placeholder for '.$info['name'].' &raquo;</td>'.NL;
                    echo '<td class="tablebottom"><a name="'.$info['id'].'" href="javascript: void(0)" onclick="javascript:window.open(\'/editor/pricep_popup.php?act=edit&id='.$info['id'].'&par='.$en_url.'\', '.$info['id'].', \'left=600,width='.$item_pw.',height='.$item_ph.',scrollbars=no,location=yes\')">Edit</a>';
                }
                if($ses->permit(15)) {
                    echo ' / <a href="'.htmlspecialchars($_SERVER['PHP_SELF']).'?delitm='.$info['id'].'&par='.$en_url.'">Delete</a>';
                }
                echo '</td>'.NL;
                echo '<td class="tablebottom"><input type="hidden" name="id'.$count.'" value="'.$info['id'].'" /><select name="iorder'.$count.'">';

                for($num = 1; $num <= $total; $num++) {
                    if($num == $info['iorder']) {
                        echo '<option value="'.$num.'" selected="selected">'.$num.'</option>';
                    }
                    else {
                        echo '<option value="'.$num.'">'.$num.'</option>';
                    }
                }
                echo '</select></td>'.NL;
                echo '<td class="tablebottom"><input type="checkbox" name="sel'.$count.'" value="'.$info['id'].'" /></td>'.NL;
                echo '</tr>'.NL ;
            }
            if($total == 0) {
                echo '<tr>'.NL;
                echo '<td class="tablebottom" colspan="6">There are currently no items in this category.</td>'.NL;
                echo '</tr>'.NL;
            }
            else {
                $count--;
                echo '<tr>'.NL;
                /*echo '<td class="tablebottom" style="border-right: none;" colspan="2"><input type="button" value="Edit All" onclick="';
                for($i = 0; array_key_exists($i, $ids); $i++) {
                    echo 'javascript:window.open(\'/editor/price_popup.php?act=edit&id='.$ids[$i].'&par='.$en_url.'\', '.$ids[$i].', \'left=600,width='.$item_pw.',height='.$item_ph.',scrollbars=no,location=yes\');';
                }
                echo '" /></td>'.NL;*/
                echo '<td class="tablebottom" colspan="6" style="text-align: right;"><select name="iact"><option value="order">Order All Items</option><option value="move">With Selected: Move</option></select> <input type="submit" value="Go" /><input type="hidden" name="itotal" value="'.$count.'" /></td></tr>'.NL;
            }
            echo '</table>'.NL.'</form>'.NL.NL;
        }
    }
}
elseif(isset($_GET['search_terms'])) {

    echo '<br /><hr />'.NL.NL;
    
    echo '<div style="font-size: 12px; margin-bottom: 10px; margin-top: 8px;"><b>Search Results</b></div>'.NL.NL;
    
    echo '<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="post">'.NL;
    echo '<table style="border-left: 1px solid #000000;" width="100%" cellpadding="1" cellspacing="0">'.NL;
    echo '<tr>'.NL;
    echo '<td class="tabletop">Name:</td>'.NL;
    echo '<td class="tabletop">Price:</td>'.NL;
    echo '<td class="tabletop">Action:</td>'.NL;
    echo '<td class="tabletop">Sel:</td>'.NL;
    echo '</tr>'.NL.NL;
    
    $search = str_replace(',', '', mysqli_real_escape_string($db->connect, $_GET['search_terms']));
    $search = trim($search);
    $search = explode(' ', $search);

    $search[0] = "(price_items.name = '".$search[0]."' OR price_items.name LIKE '% ".$search[0]." %' OR price_items.name LIKE '".$search[0]." %' OR price_items.name LIKE '% ".$search[0]."' OR ((price_items.keywords = '".$search[0]."' OR price_items.keywords LIKE '% ".$search[0]." %' OR price_items.keywords LIKE '".$search[0]." %' OR price_items.keywords LIKE '% ".$search[0]."') AND price_items.keywords != ''))";
    for($num = 1; array_key_exists($num, $search); $num++) {
        $search[$num] = "AND (price_items.name = '".$search[$num]."' OR price_items.name LIKE '% ".$search[$num]." %' OR price_items.name LIKE '".$search[$num]." %' OR price_items.name LIKE '% ".$search[$num]."' OR price_items.keywords = '".$search[$num]."' OR price_items.keywords LIKE '% ".$search[$num]." %' OR price_items.keywords LIKE '".$search[$num]." %' OR price_items.keywords LIKE '% ".$search[$num]."') ";
    }

    /*$search[0] = "(price_items.name LIKE '%".$search[0]."%' OR (price_items.keywords LIKE '%".$search[0]."%' AND price_items.keywords != '')) ";
    for($num = 1; array_key_exists($num, $search); $num++) {
        $search[$num] = "AND (price_items.name LIKE '%".$search[$num]."%' OR (price_items.keywords LIKE '%".$search[$num]."%' AND price_items.keywords != '')) ";
    }*/
    
    $search = implode('', $search);
    $_SERVER['QUERY_STRING'] = "SELECT price_items.*, price_groups.title FROM price_items, price_groups WHERE ".$search." AND price_groups.id = price_items.category AND phold_id = 0 ORDER BY name";
    
    $query = $db->query($_SERVER['QUERY_STRING']);
    $en_url = base64_encode('search_terms=' . $_GET['search_terms']); //base64_encode($_SERVER['QUERY_STRING']);
    for($i = 1; $info = $db->fetch_array($query); $i++) {
    
        if(empty($info['price_high'])) {
            $price = number_format($info['price_low']).'gp';
        }
        else {
            $price = number_format($info['price_low']).'gp - '.number_format($info['price_high']).'gp';
        }
    
        echo '<tr>'.NL;
        echo '<td class="tablebottom">'.$info['name'];
        if($info['member'] == 1) echo '<img src="images/member.gif" alt="(m)"/>';
        echo '</td>'.NL;
        echo '<td class="tablebottom">'.$price.'</td>'.NL;
        echo '<td class="tablebottom"><a name="'.$info['id'].'" href="javascript: void(0)" onclick="javascript:window.open(\'/editor/price_popup.php?act=edit&id='.$info['id'].'&par='.$en_url.'\', \'itm'.$info['id'].'\', \'left=600,width='.$item_pw.',height='.$item_ph.',scrollbars=no,location=yes\')">Edit</a>';
        if($ses->permit(15)) {
            echo ' / <a href="'.htmlspecialchars($_SERVER['PHP_SELF']).'?delitm='.$info['id'].'&par='.$en_url.'">Delete</a>';
        }
        echo '</td>'.NL;
        echo '<td class="tablebottom"><input type="checkbox" name="sel'.$i.'" value="'.$info['id'].'" /></td>'.NL;
        echo '</tr>'.NL;
    }
    if(mysqli_num_rows($query) == 0) {
        echo '<tr>'.NL;
        echo '<td class="tablebottom" colspan="4">Your search did not return any results.</td>'.NL;
        echo '</tr>'.NL;
    }
    else {
        $itotal = $i--;
        echo '<input type="hidden" name="itotal" value="'.$itotal.'" /><input type="hidden" name="par" value="'.$en_url.'" />'.NL;
        echo '<tr>'.NL;
        echo '<td class="tablebottom" colspan="4" style="text-align: right;"><select name="iact"><option value="move">With Selected: Move</option></select><input type="submit" value="Go" /></td>'.NL;
        echo '</tr>'.NL;
    }
    echo '</table></form>'.NL.NL;
}
elseif(isset($_GET['rebuild']) AND isset($_GET['left'])) {
    $id = intval($_GET['rebuild']);
    $left = intval($_GET['left']);
    rebuild_tree($id, $left);
}
else {

    if(isset($_POST['ract']) AND $_POST['ract'] == 'clearsel') {
        $first = true;
        for($i = 1; $i <= $_POST['itotal']; $i++) {
            if(isset($_POST['sel'.$i]) AND $first) {
                $id = $_POST['sel'.$i];
                $id_q = "id = ".$id;
                $first = false;
            }
            elseif(isset($_POST['sel'.$i])) {
                $id = $_POST['sel'.$i];
                $id_q .= " OR id = ".$id;
            }
        }
        if(!$first) {
            $db->query("UPDATE price_items SET reports = 0 WHERE ".$id_q);
        }
    }
    elseif(isset($_POST['ract']) AND $_POST['ract'] == 'clearshow') {
		$db->query("UPDATE `price_items` SET reports = 0 ORDER BY reports DESC LIMIT 10");
    }
    elseif(isset($_POST['ract']) AND $_POST['ract'] == 'clearall') {
		$db->query("UPDATE `price_items` SET reports = 0");
    }
    echo '<br /><hr />'.NL.NL;
  $query = $db->query("SELECT * FROM price_items WHERE jagex_pid = 0 and phold_id = 0 ORDER BY reports DESC, price_low DESC, price_high DESC LIMIT 0,10");
  //$query = $db->query("SELECT * FROM price_items WHERE  ORDER BY name ASC LIMIT 50");
	$info = $db->fetch_row("SELECT COUNT(*) as total FROM `price_items` WHERE reports >= 2");
    echo '<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="post">'.NL;
    echo '<div style="font-size: 14px;"><b>Viewing Most Reported Items ( '.mysqli_num_rows($query).' / '.$info['total'].' )</b></div><br />'.NL.NL;
    echo '<b>Instructions:</b> <a href="#" onclick=hide(\'tohide\')>Show/Hide</a><br />' . NL;
    echo '<div id="tohide" style="display:none">' . NL;
    echo '1) BE CAREFUL - ALWAYS check the price guide last updated section to make sure you didn\'t make a mistake.<br />' . NL;
    echo '2) Get prices from the Grand Exchange, but round them a bit on both upper and lower prices, so we don\'t have to update daily.<br />' . NL;
    echo '3) Only use CLEAR ALL if you have updated a LOT of the price reports.</div>' . NL;
    echo '<table style="border-left: 1px solid #000000;" width="100%" cellpadding="1" cellspacing="0">'.NL;
    echo '<tr>'.NL;
    echo '<td class="tabletop">Name:</td>'.NL;
    echo '<td class="tabletop">Reports:</td>'.NL;
    echo '<td class="tabletop">Action:</td>'.NL;
    echo '<td class="tabletop">Sel:</td>'.NL;
    echo '</tr>'.NL.NL;
    for($count = 1; $info = $db->fetch_array($query); $count++) {
        $ids[] = $info['id'];
        echo '<tr>'.NL;
        if(empty($info['price_high'])) {
            $price = number_format($info['price_low']).'gp';
        }
        else {
            $price = number_format($info['price_low']).'gp - '.number_format($info['price_high']).'gp';
        }
        echo '<td class="tablebottom">'.$info['name'];
        if($info['member'] == 1) echo '<img src="images/member.gif" alt="(m)"/>';
        echo '</td>'.NL;
        echo '<td class="tablebottom">'.$info['reports'].'</td>'.NL;
        echo '<td class="tablebottom"><a name="'.$info['id'].'" href="javascript: void(0)" onclick="javascript:window.open(\'/editor/price_popup.php?act=edit&id='.$info['id'].'&par='.$en_url.'\', '.$info['id'].', \'left=600,width='.$item_pw.',height='.$item_ph.',scrollbars=no,location=yes\')">Edit</a>';
        if($ses->permit(15)) {
            echo ' / <a href="'.htmlspecialchars($_SERVER['PHP_SELF']).'?delitm='.$info['id'].'&par='.$en_url.'">Delete</a>';
        }
        echo '</td>'.NL;
        echo '<td class="tablebottom"><input type="checkbox" name="sel'.$count.'" value="'.$info['id'].'" /></td>'.NL;
        echo '</tr>'.NL ;
    }
    if($count == 1) {
        echo '<tr>'.NL ; 
        echo '<td class="tablebottom" colspan="4">There are no reports at this time.</td>'.NL;
        echo '</tr>'.NL ; 
    }
    else { 
        $count--;
        echo '<tr>'.NL;
        echo '<td class="tablebottom" colspan="6" style="text-align: right;">'.NL;
        echo '<select name="ract">'.NL.'<option value="clearsel">Clear Selected Reports</option>'.NL.'<option value="clearshow">Clear Shown Reports</option>'.NL;
	if($ses->permit(15)) {
        echo '<option value="clearall">Clear All Reports</option>'.NL;
			  }
        echo '</select><input type="submit" value="Go" /><input type="hidden" name="itotal" value="'.$count.'" /></td></tr>'.NL;
    }
    echo '</table>'.NL.'</form><br />'.NL.NL;
}

echo '<br /></div>'.NL;

end_page();

//echo '<a href="' .htmlspecialchars($_SERVER['PHP_SELF']).'?rebuild='.$_GET['area'].'&left=1">Rebuild</a><br /><br />'.NL;
?>