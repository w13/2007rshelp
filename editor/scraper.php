<?php
require('backend.php');
require('edit_class.php');

start_page(6, 'OSRS Item Scraper'); // Permission 6 for Item DB

$edit = new edit('items', $db);

function fetch_url($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

echo '<div class="boxtop">OSRS Item Scraper</div><div class="boxbottom" style="padding: 10px;">';

if (isset($_GET['act']) && $_GET['act'] == 'add' && isset($_GET['osrs_id']) && isset($_GET['osrs_name'])) {
    // Add Item Logic
    $osrs_id = intval($_GET['osrs_id']);
    $osrs_name = urldecode($_GET['osrs_name']);
    
    // Double check if exists
    $check = $db->query("SELECT id FROM items WHERE pid = $osrs_id OR name = '" . $db->escape_string($osrs_name) . "'");
    if ($db->num_rows($check) > 0) {
        echo '<p style="color:red;">Item already exists in database!</p>';
    } else {
        // Fetch Details
        $detail_url = "https://secure.runescape.com/m=itemdb_oldschool/" . urlencode($osrs_name) . "/viewitem?obj=" . $osrs_id;
        $html = fetch_url($detail_url);
        
        if ($html) {
            // Extract Data
            preg_match('/<h2>(.*?)<\/h2>/s', $html, $name_match);
            preg_match('/<h3>(.*?)<\/h3>/s', $html, $examine_match);
            preg_match('/src="(.*?_obj_big\.gif\?id=\d+)"/', $html, $img_match);
            
            $name = isset($name_match[1]) ? trim($name_match[1]) : $osrs_name;
            $examine = isset($examine_match[1]) ? trim($examine_match[1]) : '';
            $img_url = isset($img_match[1]) ? $img_match[1] : '';
            
            // Download Image
            $local_img_name = 'nopic.gif';
            if ($img_url) {
                // Determine clean filename
                $clean_name = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $name));
                $local_img_name = $clean_name . '.gif';
                $img_data = fetch_url($img_url);
                if ($img_data) {
                    $save_path = ROOT . '/../img/idbimg/' . $local_img_name;
                    // Check if path exists, otherwise try relative to public_html or just use default
                    // Assuming /home/2007rshelp/public_html/img/idbimg/ based on file structure
                    if (is_dir(ROOT . '/../img/idbimg/')) {
                         file_put_contents(ROOT . '/../img/idbimg/' . $local_img_name, $img_data);
                    } elseif (is_dir(ROOT . '/img/idbimg/')) {
                         file_put_contents(ROOT . '/img/idbimg/' . $local_img_name, $img_data);
                    } else {
                        $local_img_name = 'nopic.gif'; // Failed to find dir
                    }
                }
            }
            
            // Insert
            $db->query("INSERT INTO items (
                name, image, type, member, trade, equip, weight, speed, stack, examine, 
                quest, obtain, highalch, lowalch, sellgen, buygen, keepdrop, retrieve, 
                questuse, att, def, otherb, notes, credits, pricelink, keyword, time, pid, complete
            ) VALUES (
                '" . $db->escape_string($name) . "',
                '" . $db->escape_string($local_img_name) . "',
                3, 
                1, 
                1, 
                0, 
                0, 
                0, 
                0, 
                '" . $db->escape_string($examine) . "',
                'No', 
                'Grand Exchange', 
                0, 0, 0, 0, 
                '', '', '', 
                '0|0|0|0|0', '0|0|0|0|0', '0|0|0', 
                '', 
                'OSRS Scraper', 
                '', '', 
                " . time() . ",
                $osrs_id,
                1
            )");
            
            $ses->record_act('Item Database', 'Scrape Add', $name, $_SERVER['REMOTE_ADDR']);
            echo '<p style="color:green;">Successfully added <b>' . $name . '</b>!</p>';
            
        } else {
            echo '<p style="color:red;">Failed to fetch item details.</p>';
        }
    }
    echo '<p><a href="scraper.php">Return to List</a></p>';
    
} else {
    // List View
    echo '<h3>Scan for New Items</h3>';
    echo '<p>This tool scans the OSRS Grand Exchange Top 100 Most Traded list for items not in our database.</p>';
    echo '<form method="post"><input type="hidden" name="scan" value="1"><input type="submit" value="Scan Now"></form>';
    
    if (isset($_POST['scan'])) {
        echo '<hr>';
        $url = 'https://secure.runescape.com/m=itemdb_oldschool/top100?list=2&scale=0';
        $html = fetch_url($url);
        
        if ($html) {
            // Match links like: href="/m=itemdb_oldschool/Air+rune/viewitem?obj=556"
            // Note: The HTML might use &amp; or just & in URL
            preg_match_all('/href="\/m=itemdb_oldschool\/([^\/]+)\/viewitem\?obj=(\d+)"/i', $html, $matches);
            
            $count = 0;
            $new_count = 0;
            
            echo '<table width="100%" cellpadding="3" cellspacing="0" border="1" style="border-collapse:collapse;">';
            echo '<tr style="background:#ccc;"><th>OSRS ID</th><th>Name</th><th>Status</th><th>Action</th></tr>';
            
            if (isset($matches[1]) && is_array($matches[1])) {
                foreach ($matches[1] as $k => $name_enc) {
                    $osrs_id = $matches[2][$k];
                    $name = urldecode($name_enc);
                    $name = str_replace('+', ' ', $name); // Just in case
                    
                    // Check DB
                    $check = $db->query("SELECT id FROM items WHERE pid = $osrs_id OR name = '" . $db->escape_string($name) . "'");
                    
                    if ($db->num_rows($check) == 0) {
                        $status = '<span style="color:green;font-weight:bold;">NEW</span>';
                        $action = '<a href="scraper.php?act=add&osrs_id=' . $osrs_id . '&osrs_name=' . urlencode($name) . '">Add to DB</a>';
                        $new_count++;
                    } else {
                        $status = '<span style="color:gray;">Exists</span>';
                        $action = '-';
                    }
                    
                    // Only show new items or maybe all? Let's show all for now but highlight new.
                    // Or maybe just new to reduce clutter if list is long.
                    // Let's show all but prioritizing new.
                    
                    echo '<tr>';
                    echo '<td>' . $osrs_id . '</td>';
                    echo '<td>' . $name . '</td>';
                    echo '<td>' . $status . '</td>';
                    echo '<td>' . $action . '</td>';
                    echo '</tr>';
                    
                    $count++;
                }
            }
            echo '</table>';
            echo '<p>Scanned ' . $count . ' items. Found ' . $new_count . ' new items.</p>';
            
        } else {
            echo '<p style="color:red;">Failed to fetch OSRS Top 100 list.</p>';
        }
    }
}

echo '</div>';
end_page();
?>