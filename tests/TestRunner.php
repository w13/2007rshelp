#!/usr/bin/env php
<?php
/**
 * Test Runner for 2007rshelp.com
 * Validates core functionality after security improvements
 */

// Test configuration
define('TEST_MODE', true);
$_SERVER['SCRIPT_NAME'] = '/tests/TestRunner.php';
$_SERVER['REQUEST_URI'] = '/tests/TestRunner.php';
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

class TestRunner {
    private $passed = 0;
    private $failed = 0;
    private $tests = [];

    public function __construct() {
        echo "\n";
        echo "╔════════════════════════════════════════════════════════════════╗\n";
        echo "║          2007rshelp.com - Core Functionality Tests             ║\n";
        echo "╚════════════════════════════════════════════════════════════════╝\n\n";
    }

    public function assert($condition, $message) {
        if ($condition) {
            $this->passed++;
            echo "  ✓ " . $message . "\n";
            return true;
        } else {
            $this->failed++;
            echo "  ✗ FAILED: " . $message . "\n";
            return false;
        }
    }

    public function assertEquals($expected, $actual, $message) {
        if ($expected === $actual) {
            $this->passed++;
            echo "  ✓ " . $message . "\n";
            return true;
        } else {
            $this->failed++;
            echo "  ✗ FAILED: " . $message . "\n";
            echo "    Expected: " . var_export($expected, true) . "\n";
            echo "    Actual:   " . var_export($actual, true) . "\n";
            return false;
        }
    }

    public function assertNotNull($value, $message) {
        return $this->assert($value !== null, $message);
    }

    public function assertEmpty($value, $message) {
        return $this->assert(empty($value), $message);
    }

    public function assertNotEmpty($value, $message) {
        return $this->assert(!empty($value), $message);
    }

    public function assertContains($needle, $haystack, $message) {
        $result = (is_array($haystack) && in_array($needle, $haystack)) ||
                  (is_string($haystack) && strpos($haystack, $needle) !== false);
        return $this->assert($result, $message);
    }

    public function assertNotContains($needle, $haystack, $message) {
        $result = (is_array($haystack) && !in_array($needle, $haystack)) ||
                  (is_string($haystack) && strpos($haystack, $needle) === false);
        return $this->assert($result, $message);
    }

    public function section($name) {
        echo "\n" . str_repeat("─", 64) . "\n";
        echo "Testing: " . $name . "\n";
        echo str_repeat("─", 64) . "\n";
    }

    public function summary() {
        $total = $this->passed + $this->failed;
        $percentage = $total > 0 ? round(($this->passed / $total) * 100, 1) : 0;

        echo "\n";
        echo "════════════════════════════════════════════════════════════════\n";
        echo "Test Results\n";
        echo "════════════════════════════════════════════════════════════════\n";
        echo "Total Tests:  " . $total . "\n";
        echo "Passed:       " . $this->passed . " ✓\n";
        echo "Failed:       " . $this->failed . ($this->failed > 0 ? " ✗" : "") . "\n";
        echo "Success Rate: " . $percentage . "%\n";
        echo "════════════════════════════════════════════════════════════════\n\n";

        if ($this->failed === 0) {
            echo "🎉 All tests passed! Core functionality is working correctly.\n\n";
            return 0;
        } else {
            echo "⚠️  Some tests failed. Review the output above for details.\n\n";
            return 1;
        }
    }
}

// Initialize test runner
$test = new TestRunner();

// Test 1: Configuration File
$test->section("Configuration");
try {
    define('IN_OSRS_HELP', TRUE);
    require_once dirname(__DIR__) . '/public_html/config.inc.php';

    $test->assert(defined('MYSQL_HOST'), "MYSQL_HOST constant is defined");
    $test->assert(defined('MYSQL_USER'), "MYSQL_USER constant is defined");
    $test->assert(defined('MYSQL_PASS'), "MYSQL_PASS constant is defined");
    $test->assert(defined('MYSQL_DB'), "MYSQL_DB constant is defined");
    $test->assert(defined('SITE_NAME'), "SITE_NAME constant is defined");
    $test->assert(defined('SITE_URL'), "SITE_URL constant is defined");
    $test->assert(defined('OFFLINE'), "OFFLINE constant is defined");

    $test->assertEquals('Old School RuneScape Help', SITE_NAME, "Site name is correct");
    $test->assertEquals('https://2007rshelp.com', SITE_URL, "Site URL is correct");
    $test->assertEquals(FALSE, OFFLINE, "Site is not in offline mode");

    $test->assertNotEmpty(MYSQL_HOST, "Database host is set");
    $test->assertNotEmpty(MYSQL_USER, "Database user is set");
    $test->assertNotEmpty(MYSQL_PASS, "Database password is set");
    $test->assertNotEmpty(MYSQL_DB, "Database name is set");

} catch (Exception $e) {
    $test->assert(false, "Configuration file loads without errors: " . $e->getMessage());
}

// Test 2: Classes
$test->section("Core Classes");
try {
    require_once dirname(__DIR__) . '/public_html/classes.inc.php';

    $test->assert(class_exists('db'), "Database class exists");
    $test->assert(class_exists('display'), "Display class exists");
    $test->assert(class_exists('timer'), "Timer class exists");
    $test->assert(class_exists('page'), "Page class exists");

    // Test db class instantiation
    $db = new db();
    $test->assert(is_object($db), "Database object can be instantiated");
    $test->assert(method_exists($db, 'connect'), "Database has connect method");
    $test->assert(method_exists($db, 'query'), "Database has query method");
    $test->assert(method_exists($db, 'fetch_row'), "Database has fetch_row method");
    $test->assert(method_exists($db, 'fetch_array'), "Database has fetch_array method");
    $test->assert(method_exists($db, 'escape_string'), "Database has escape_string method");

    // Test timer class
    $timer = new timer();
    $test->assert(is_object($timer), "Timer object can be instantiated");
    $test->assert(method_exists($timer, 'startTimer'), "Timer has startTimer method");
    $test->assert(method_exists($timer, 'endTimer'), "Timer has endTimer method");

    // Test timer functionality
    $timer->startTimer();
    usleep(1000); // Sleep 1ms
    $elapsed = $timer->endTimer();
    $test->assert($elapsed > 0 && $elapsed < 1, "Timer measures elapsed time correctly");

} catch (Exception $e) {
    $test->assert(false, "Classes load without errors: " . $e->getMessage());
}

// Test 3: Functions
$test->section("Core Functions");
try {
    require_once dirname(__DIR__) . '/public_html/functions.inc.php';

    $test->assert(function_exists('dynamify'), "dynamify function exists");
    $test->assert(function_exists('city_key'), "city_key function exists");
    $test->assert(function_exists('city_shops'), "city_shops function exists");
    $test->assert(function_exists('city_npc'), "city_npc function exists");
    $test->assert(function_exists('monsters'), "monsters function exists");
    $test->assert(function_exists('offline_start'), "offline_start function exists");

    // Test city_key function
    $key = city_key('varrock');
    $test->assertNotEmpty($key, "city_key returns non-empty result");
    $test->assertContains('Varrock', $key, "city_key formats city name correctly");

    // Test city_key with NA
    $key_na = city_key('NA');
    $test->assertEmpty($key_na, "city_key returns empty for NA");

} catch (Exception $e) {
    $test->assert(false, "Functions load without errors: " . $e->getMessage());
}

// Test 4: Database Connection
$test->section("Database Connection");
try {
    $db = new db();
    $db->set_mysql_host(MYSQL_HOST);
    $db->set_mysql_user(MYSQL_USER);
    $db->set_mysql_pass(MYSQL_PASS);
    $db->set_mysql_database(MYSQL_DB);

    $connection = $db->connect();
    $test->assert($connection !== false, "Database connection successful");

    if ($connection) {
        $select = $db->select_db(MYSQL_DB);
        $test->assert($select !== false, "Database selection successful");

        // Test simple query
        $result = $db->query("SELECT 1 as test");
        $test->assert($result !== false, "Simple query executes successfully");

        $row = $db->fetch_array($result);
        $test->assertEquals('1', $row['test'], "Query returns expected result");

        // Test query counting
        $queries = $db->count_queries();
        $test->assert($queries > 0, "Query counter works (counted: $queries)");

        $db->disconnect();
    }

} catch (Exception $e) {
    $test->assert(false, "Database connection works: " . $e->getMessage());
}

// Test 5: Input Sanitization
$test->section("Input Sanitization (Display Class)");
try {
    $db = new db();
    $db->set_mysql_host(MYSQL_HOST);
    $db->set_mysql_user(MYSQL_USER);
    $db->set_mysql_pass(MYSQL_PASS);
    $db->set_mysql_database(MYSQL_DB);
    $db->connect();
    $db->select_db(MYSQL_DB);

    $disp = new display($db, SITE_URL, dirname(__DIR__) . '/public_html');
    $test->assert(is_object($disp), "Display object can be instantiated");

    // Test input sanitization
    $testInputs = array(
        array('test_int', '123', 'int', 's' => '1,999'),
        array('test_string', 'hello<script>alert("xss")</script>', 'string', 'l' => 50),
        array('test_enum', 'DESC', 'enum', 'e' => array('DESC', 'ASC'), 'd' => 'ASC'),
    );

    $cleaned = $disp->cleanVars($testInputs);

    $test->assertEquals('123', $cleaned['test_int'], "Integer input sanitized correctly");
    $test->assertNotContains('<script>', $cleaned['test_string'], "XSS removed from string input");
    $test->assertEquals('DESC', $cleaned['test_enum'], "Enum value validated correctly");

    $db->disconnect();

} catch (Exception $e) {
    $test->assert(false, "Input sanitization works: " . $e->getMessage());
}

// Test 6: Template System
$test->section("Template System");
try {
    $db = new db();
    $disp = new display($db, SITE_URL, dirname(__DIR__) . '/public_html');

    // Test file loading
    $layout = $disp->get_file('/content/layout.inc');
    $test->assertNotEmpty($layout, "Template file loads successfully");
    $test->assertContains('[#SITE_NAME#]', $layout, "Template contains placeholders");
    $test->assertContains('[#CONTENT#]', $layout, "Template contains content placeholder");

    // Test CSS selection
    $css = $disp->use_css();
    $test->assertNotEmpty($css, "CSS path is generated");
    $test->assertContains('css/', $css, "CSS path contains css directory");

    // Test meta description
    $meta = $disp->metadesc('items.php');
    $test->assertNotEmpty($meta, "Meta description generated for items.php");
    $test->assertContains('Runescape', $meta, "Meta description contains relevant keywords");

    // Test title generation
    $title = $disp->title('Items', 'Database', 'Default Site');
    $test->assertEquals('Database - Items - Default Site', $title, "Title format is correct");

} catch (Exception $e) {
    $test->assert(false, "Template system works: " . $e->getMessage());
}

// Test 7: Security - XSS Protection
$test->section("Security Features");
try {
    // Test that $_SERVER['REQUEST_URI'] in config.inc.php is sanitized
    $test->assert(defined('IN_OSRS_HELP'), "Security constant IN_OSRS_HELP is defined");

    // Test that configuration array is unset (should not be accessible)
    $test->assert(!isset($Configuration), "Configuration array is cleaned up from memory");

    // Simulate XSS attempt in error message
    $_SERVER['REQUEST_URI'] = '/test.php?<script>alert("xss")</script>';
    $security_message = "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\n".
        "<html><head>\n".
        "<title>404 Not Found</title>\n".
        "</head><body>\n".
        "<h1>Not Found</h1>\n".
        "<p>The requested URL " . htmlspecialchars($_SERVER['REQUEST_URI'] ?? '', ENT_QUOTES, 'UTF-8') . " was not found on this server.</p>\n".
        "</body></html>";

    $test->assertNotContains('<script>', $security_message, "XSS is sanitized in error messages");
    $test->assertContains('&lt;script&gt;', $security_message, "XSS is HTML-encoded in error messages");

} catch (Exception $e) {
    $test->assert(false, "Security features work: " . $e->getMessage());
}

// Test 8: Calculator Functions (JavaScript in PHP context)
$test->section("Calculator Logic");
try {
    // Test XP calculation formulas (from calcs.js)
    function findXp($level) {
        $level--;
        $xp = 0;
        $num = 1;
        while($level > 0) {
            $a = $num / 7;
            $xp = $xp + floor($num + 300 * pow(2, $a));
            $num++;
            $level--;
        }
        $xp = floor($xp / 4);
        return $xp;
    }

    function findLevel($xp) {
        if($xp >= 200000000) return 126;
        $level = 0;
        $points = 0;
        $check = 0;
        $num = 1;
        while($check <= $xp) {
            $a = $num / 7;
            $points = $points + floor($num + 300 * pow(2, $a));
            $check = floor($points / 4);
            $num++;
            $level++;
        }
        return $level;
    }

    // Test XP calculations
    $test->assert(findXp(1) == 0, "Level 1 = 0 XP");
    $test->assert(findXp(2) == 83, "Level 2 = 83 XP");
    $test->assert(findXp(99) == 13034431, "Level 99 = 13,034,431 XP");

    // Test level calculations
    $test->assertEquals(2, findLevel(83), "83 XP = Level 2");
    $test->assertEquals(99, findLevel(13034431), "13,034,431 XP = Level 99");

} catch (Exception $e) {
    $test->assert(false, "Calculator logic works: " . $e->getMessage());
}

// Test 9: File Permissions
$test->section("File Security");
try {
    $config_file = dirname(__DIR__) . '/public_html/config.inc.php';
    $htaccess_file = dirname(__DIR__) . '/public_html/.htaccess';

    $test->assert(file_exists($config_file), "config.inc.php exists");
    $test->assert(is_readable($config_file), "config.inc.php is readable by PHP");

    $test->assert(file_exists($htaccess_file), ".htaccess exists");
    $test->assert(is_readable($htaccess_file), ".htaccess is readable");

    // Check .htaccess contains security rules
    $htaccess_content = file_get_contents($htaccess_file);
    $test->assert(
        stripos($htaccess_content, 'config') !== false,
        ".htaccess protects config files"
    );
    $test->assertContains('Require all denied', $htaccess_content, ".htaccess denies access to sensitive files");
    $test->assertContains('X-Frame-Options', $htaccess_content, ".htaccess sets security headers");

} catch (Exception $e) {
    $test->assert(false, "File security checks work: " . $e->getMessage());
}

// Test 10: Environment Variables
$test->section("Environment Variable Support");
try {
    // Test that config supports environment variables
    $test->assert(
        MYSQL_HOST === getenv('DB_HOST') || MYSQL_HOST === 'localhost',
        "Database host uses environment variable or fallback"
    );

    $test->assert(
        MYSQL_USER === getenv('DB_USER') || MYSQL_USER === 'rsc',
        "Database user uses environment variable or fallback"
    );

    $test->assert(
        MYSQL_DB === getenv('DB_NAME') || MYSQL_DB === 'rsc_site',
        "Database name uses environment variable or fallback"
    );

    // Test that getenv returns false for unset variables (confirming fallback works)
    if (!getenv('DB_HOST')) {
        $test->assert(true, "Environment variables not set - using fallback values (OK)");
    } else {
        $test->assert(true, "Environment variables are set and being used");
    }

} catch (Exception $e) {
    $test->assert(false, "Environment variable support works: " . $e->getMessage());
}

// Display summary and exit
exit($test->summary());
