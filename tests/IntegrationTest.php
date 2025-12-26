#!/usr/bin/env php
<?php
/**
 * Integration Tests - Tests actual page rendering and API endpoints
 */

class IntegrationTest {
    private $passed = 0;
    private $failed = 0;
    private $baseUrl = 'https://2007rshelp.com';

    public function __construct() {
        echo "\n";
        echo "╔════════════════════════════════════════════════════════════════╗\n";
        echo "║              Integration & HTTP Tests                          ║\n";
        echo "╚════════════════════════════════════════════════════════════════╝\n\n";
        echo "Note: These tests require the web server to be running.\n";
        echo "Testing against: " . $this->baseUrl . "\n\n";
    }

    public function assert($condition, $message) {
        if ($condition) {
            $this->passed++;
            echo "  ✓ " . $message . "\n";
        } else {
            $this->failed++;
            echo "  ✗ FAILED: " . $message . "\n";
        }
    }

    public function assertContains($needle, $haystack, $message) {
        if (strpos($haystack, $needle) !== false) {
            $this->passed++;
            echo "  ✓ " . $message . "\n";
        } else {
            $this->failed++;
            echo "  ✗ FAILED: " . $message . "\n";
            echo "    Looking for: " . $needle . "\n";
        }
    }

    public function section($name) {
        echo "\n" . str_repeat("─", 64) . "\n";
        echo $name . "\n";
        echo str_repeat("─", 64) . "\n";
    }

    public function testUrl($url, $expectedCode = 200, $description = '') {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == $expectedCode) {
            $this->passed++;
            echo "  ✓ " . ($description ?: $url) . " (HTTP $httpCode)\n";
            return $response;
        } else {
            $this->failed++;
            echo "  ✗ FAILED: " . ($description ?: $url) . " (expected HTTP $expectedCode, got HTTP $httpCode)\n";
            return false;
        }
    }

    public function testSecurityHeaders($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $headers = curl_exec($ch);
        curl_close($ch);

        $this->assertContains('X-Frame-Options', $headers, "X-Frame-Options header present");
        $this->assertContains('X-Content-Type-Options', $headers, "X-Content-Type-Options header present");
        $this->assertContains('X-XSS-Protection', $headers, "X-XSS-Protection header present");
        $this->assertContains('Referrer-Policy', $headers, "Referrer-Policy header present");

        return $headers;
    }

    public function summary() {
        $total = $this->passed + $this->failed;
        $percentage = $total > 0 ? round(($this->passed / $total) * 100, 1) : 0;

        echo "\n";
        echo "════════════════════════════════════════════════════════════════\n";
        echo "Integration Test Results\n";
        echo "════════════════════════════════════════════════════════════════\n";
        echo "Total Tests:  " . $total . "\n";
        echo "Passed:       " . $this->passed . " ✓\n";
        echo "Failed:       " . $this->failed . ($this->failed > 0 ? " ✗" : "") . "\n";
        echo "Success Rate: " . $percentage . "%\n";
        echo "════════════════════════════════════════════════════════════════\n\n";

        if ($this->failed === 0) {
            echo "🎉 All integration tests passed!\n\n";
            return 0;
        } else {
            echo "⚠️  Some integration tests failed.\n\n";
            return 1;
        }
    }
}

$test = new IntegrationTest();

// Test 1: File Protection
$test->section("Test 1: Configuration File Protection");
echo "These files should return 403 Forbidden:\n";
$test->testUrl('https://2007rshelp.com/config.inc.php', 403, 'config.inc.php blocked');
$test->testUrl('https://2007rshelp.com/classes.inc.php', 403, 'classes.inc.php blocked');
$test->testUrl('https://2007rshelp.com/functions.inc.php', 403, 'functions.inc.php blocked');

// Test 2: Security Headers
$test->section("Test 2: Security Headers");
$test->testSecurityHeaders('https://2007rshelp.com/');

// Test 3: Main Pages
$test->section("Test 3: Main Pages Load Successfully");
$response = $test->testUrl('https://2007rshelp.com/', 200, 'Homepage');
if ($response) {
    $test->assertContains('Old-School RuneScape Help', $response, "Homepage contains title");
}

$response = $test->testUrl('https://2007rshelp.com/items.php', 200, 'Items page');
if ($response) {
    $test->assertContains('Item Database', $response, "Items page contains database content");
}

$response = $test->testUrl('https://2007rshelp.com/monsters.php', 200, 'Monsters page');
if ($response) {
    $test->assertContains('Monster', $response, "Monsters page contains relevant content");
}

$test->testUrl('https://2007rshelp.com/skills.php', 200, 'Skills page');
$test->testUrl('https://2007rshelp.com/quests.php', 200, 'Quests page');
$test->testUrl('https://2007rshelp.com/calcs.php', 200, 'Calculators page');

// Test 4: API Endpoints
$test->section("Test 4: API Endpoints");
$response = $test->testUrl('https://2007rshelp.com/api/monsters/dragon', 200, 'API - Monsters endpoint');
if ($response) {
    $body = substr($response, strpos($response, "\r\n\r\n"));
    $json = json_decode($body, true);
    if ($json !== null) {
        $test->assert(true, "API returns valid JSON");
        $test->assert(isset($json['monsters']), "API returns monsters array");
    } else {
        $test->assert(false, "API returns valid JSON");
    }
}

$response = $test->testUrl('https://2007rshelp.com/api/items/sword', 200, 'API - Items endpoint');
if ($response) {
    $body = substr($response, strpos($response, "\r\n\r\n"));
    $json = json_decode($body, true);
    if ($json !== null) {
        $test->assert(true, "API returns valid JSON");
        $test->assert(isset($json['items']), "API returns items array");
    } else {
        $test->assert(false, "API returns valid JSON");
    }
}

// Test 5: Static Assets
$test->section("Test 5: Static Assets Load");
$test->testUrl('https://2007rshelp.com/css/bluelight.css', 200, 'CSS file loads');
$test->testUrl('https://2007rshelp.com/calcs.js', 200, 'JavaScript file loads');
$test->testUrl('https://2007rshelp.com/favicon.ico', 200, 'Favicon loads');

// Test 6: XSS Protection
$test->section("Test 6: XSS Attack Prevention");
$xss_test = $test->testUrl('https://2007rshelp.com/items.php?search_term=<script>alert(1)</script>', 200, 'XSS attempt in query string');
if ($xss_test) {
    $test->assert(
        strpos($xss_test, '<script>alert(1)</script>') === false,
        "XSS payload is sanitized (script tags removed or encoded)"
    );
}

exit($test->summary());
