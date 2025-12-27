<?php
// CLI Scraper for OSRS Items
// Usage: php cli_scraper.php [scan|add <id> <name>|auto]

define('IN_ZYBEZ', true); // Bypass security check
define('ROOT', '/home/2007rshelp/public_html');
define('NL', "\n");

// Include Configuration and Classes
if (!file_exists(ROOT . '/config.inc.php')) {
    die("Error: config.inc.php not found at " . ROOT . "\n");
}
require ROOT . '/config.inc.php';
require ROOT . '/classes.inc.php';

// Setup DB
$db = new db();
$db->set_mysql_host(MYSQL_HOST);
$db->set_mysql_user(MYSQL_USER);
$db->set_mysql_pass(MYSQL_PASS);

// Connect
try {
    $db->connect();
    $db->select_db(MYSQL_DB);
} catch (Exception $e) {
    die("DB Connection Error: " . $e->getMessage() . "\n");
}

function fetch_url($url) {
    // PHP CLI might miss curl extension, so use system curl
    $cmd = "curl -s -L -A 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36' " . escapeshellarg($url);
    $output = shell_exec($cmd);
    return $output;
}

function get_top_100() {
    $urls = [
        'https://secure.runescape.com/m=itemdb_oldschool/top100?list=2&scale=0',
        'https://secure.runescape.com/m=itemdb_oldschool/top100?list=3&scale=0',
        'https://secure.runescape.com/m=itemdb_oldschool/top100?list=1',
        'https://secure.runescape.com/m=itemdb_oldschool/top100?list=2&scale=2',
        'https://secure.runescape.com/m=itemdb_oldschool/top100?list=1&scale=3'
    ];

    $items = [];
    $seen = [];

    foreach ($urls as $url) {
        echo "Fetching list from: $url\n";
        $html = fetch_url($url);
        
        if (!$html) {
            echo "Warning: Failed to fetch list from $url\n";
            continue;
        }

        // Match links: https://secure.runescape.com/m=itemdb_oldschool/Air+rune/viewitem?obj=556
        preg_match_all('/href="[^"]*\/m=itemdb_oldschool\/([^\/]+)\/viewitem\?obj=(\d+)"/i', $html, $matches);
        
        if (isset($matches[1])) {
            foreach ($matches[1] as $k => $name_enc) {
                $osrs_id = $matches[2][$k];
                if (isset($seen[$osrs_id])) continue;
                $seen[$osrs_id] = true;
                
                $name_dec = urldecode($name_enc);
                $items[] = [
                    'id' => $osrs_id,
                    'name' => $name_dec
                ];
            }
        }
    }
    return $items;
}

function check_item_exists($name) {
    global $db;
    $esc_name = $db->escape_string($name);
    // Only checking by NAME as requested
    $res = $db->query("SELECT id FROM items WHERE name = '$esc_name'");
    return mysqli_num_rows($res) > 0;
}

function add_item($osrs_id, $osrs_name) {
    global $db;
    
    echo "Adding item: $osrs_name (OSRS ID: $osrs_id)...";
    
    // Double check existence
    if (check_item_exists($osrs_name)) {
        echo "Skipping: Item '$osrs_name' already exists in DB.\n";
        return;
    }

    $detail_url = "https://secure.runescape.com/m=itemdb_oldschool/" . urlencode($osrs_name) . "/viewitem?obj=" . $osrs_id;
    $html = fetch_url($detail_url);
    
    if (!$html) {
        echo "Error: Failed to fetch detail page for '$osrs_name'.\n";
        return;
    }

    // Extract Details
    preg_match('/<div class=\'item-description (.*?)\'>\s*<h2>(.*?)<\/h2>\s*<p>(.*?)<\/p>/s', $html, $detail_match);
    preg_match('/src=[\'"](.*?_obj_big\.gif\?id=\d+)[\'"]/', $html, $img_match);
    
    $is_member = (isset($detail_match[1]) && strpos($detail_match[1], 'member') !== false) ? 1 : 0;
    $name = isset($detail_match[2]) ? trim($detail_match[2]) : $osrs_name;
    $examine = isset($detail_match[3]) ? trim($detail_match[3]) : '';
    $img_url = isset($img_match[1]) ? $img_match[1] : '';
    
    echo "  - Scraped Name: $name\n";
    echo "  - Scraped Examine: $examine\n";
    echo "  - Scraped Member: " . ($is_member ? "Yes" : "No") . "\n";
    echo "  - Scraped Image: $img_url\n";

    // ... Download Image Logic ...
    $local_img_name = 'nopic.gif';
    if ($img_url) {
        $clean_name = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $name));
        $local_img_name = $clean_name . '.gif';
        $save_path = ROOT . '/img/idbimg/' . $local_img_name;
        
        echo "  - Downloading image to $save_path...\n";
        $img_data = fetch_url($img_url);
        if ($img_data) {
            if (file_put_contents($save_path, $img_data)) {
                echo "  - Image saved.\n";
            } else {
                echo "  - Error: Failed to write image file. Check permissions.\n";
                $local_img_name = 'nopic.gif';
            }
        } else {
            echo "  - Error: Failed to download image.\n";
        }
    }

    // Insert into DB
    $sql = "INSERT INTO items (
        name, image, type, member, trade, equip, weight, speed, stack, examine, 
        quest, obtain, highalch, lowalch, sellgen, buygen, keepdrop, retrieve, 
        questuse, att, def, otherb, notes, credits, pricelink, keyword, time, pid, complete,
        equip_id, equip_type
    ) VALUES (
        '" . $db->escape_string($name) . "',
        '" . $db->escape_string($local_img_name) . "',
        3, 
        '$is_member', 
        1, 
        0, 
        '?', 
        '0', 
        0, 
        '" . $db->escape_string($examine) . "',
        'No', 
        'Grand Exchange', 
        0, 0, 0, 0, 
        '', '', '', 
        '0|0|0|0|0', '0|0|0|0|0', '0|0|0', 
        '', 
        'W13', 
        NULL, '', 
        " . time() . ",
        $osrs_id,
        1,
        0,
        -1
    )";

    if ($db->query($sql)) {
        echo "SUCCESS: Item '$name' added to database.\n";
    } else {
        echo "DB ERROR: Failed to insert item.\n";
    }
}

// Main Logic
$mode = isset($argv[1]) ? $argv[1] : 'scan';

if ($mode == 'scan') {
    $items = get_top_100();
    echo "Found " . count($items) . " items in Top 100.\n";
    echo str_pad("OSRS ID", 10) . str_pad("NAME", 40) . "STATUS\n";
    echo str_repeat("-", 60) . "\n";
    
    $new_count = 0;
    foreach ($items as $item) {
        $exists = check_item_exists($item['name']);
        $status = $exists ? "EXISTS" : "NEW";
        if (!$exists) $new_count++;
        
        $color = $exists ? "" : "\033[32m"; // Green for new
        $reset = $exists ? "" : "\033[0m";
        
        echo $color . str_pad($item['id'], 10) . str_pad(substr($item['name'], 0, 38), 40) . $status . $reset . "\n";
    }
    echo str_repeat("-", 60) . "\n";
    echo "Total NEW items: $new_count\n";
    
} elseif ($mode == 'add') {
    if (!isset($argv[2]) || !isset($argv[3])) {
        die("Usage: php cli_scraper.php add <osrs_id> <name>\n");
    }
    add_item($argv[2], $argv[3]);
    
} elseif ($mode == 'auto') {
    $items = get_top_100();
    echo "Auto-adding new items...\n";
    foreach ($items as $item) {
        if (!check_item_exists($item['name'])) {
            add_item($item['id'], $item['name']);
            sleep(1); // Polite delay
        }
    }
} else {
    echo "Unknown mode: $mode\n";
    echo "Usage: php cli_scraper.php [scan|add <id> <name>|auto]\n";
}

$db->disconnect();
?>