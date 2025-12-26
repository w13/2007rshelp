#!/usr/bin/env php
<?php
/**
 * Page Rendering Tests
 * Tests that core pages can be rendered without errors
 */

class PageRenderTest {
    private $passed = 0;
    private $failed = 0;

    public function __construct() {
        echo "\n";
        echo "╔════════════════════════════════════════════════════════════════╗\n";
        echo "║                  Page Rendering Tests                          ║\n";
        echo "╚════════════════════════════════════════════════════════════════╝\n\n";
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

    public function section($name) {
        echo "\n" . str_repeat("─", 64) . "\n";
        echo $name . "\n";
        echo str_repeat("─", 64) . "\n";
    }

    public function testPageRender($file, $description) {
        // Set up minimal environment
        $_SERVER['SCRIPT_NAME'] = '/' . basename($file);
        $_SERVER['REQUEST_URI'] = '/' . basename($file);
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['SERVER_NAME'] = 'localhost';
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $_GET = array();
        $_POST = array();
        $_COOKIE = array();

        ob_start();
        try {
            include $file;
            $output = ob_get_clean();

            // Check output is not empty
            if (strlen($output) > 100) {
                $this->passed++;
                echo "  ✓ " . $description . " renders successfully (" . strlen($output) . " bytes)\n";
                return true;
            } else {
                $this->failed++;
                echo "  ✗ FAILED: " . $description . " output too short (" . strlen($output) . " bytes)\n";
                return false;
            }
        } catch (Exception $e) {
            ob_end_clean();
            $this->failed++;
            echo "  ✗ FAILED: " . $description . " - " . $e->getMessage() . "\n";
            return false;
        } catch (Error $e) {
            ob_end_clean();
            $this->failed++;
            echo "  ✗ FAILED: " . $description . " - " . $e->getMessage() . "\n";
            return false;
        }
    }

    public function summary() {
        $total = $this->passed + $this->failed;
        $percentage = $total > 0 ? round(($this->passed / $total) * 100, 1) : 0;

        echo "\n";
        echo "════════════════════════════════════════════════════════════════\n";
        echo "Page Rendering Results\n";
        echo "════════════════════════════════════════════════════════════════\n";
        echo "Total Tests:  " . $total . "\n";
        echo "Passed:       " . $this->passed . " ✓\n";
        echo "Failed:       " . $this->failed . ($this->failed > 0 ? " ✗" : "") . "\n";
        echo "Success Rate: " . $percentage . "%\n";
        echo "════════════════════════════════════════════════════════════════\n\n";

        if ($this->failed === 0) {
            echo "🎉 All page rendering tests passed!\n\n";
            return 0;
        } else {
            echo "⚠️  Some page rendering tests failed.\n\n";
            return 1;
        }
    }
}

$test = new PageRenderTest();
$base = dirname(__DIR__) . '/public_html';

// Test core pages
$test->section("Core Page Rendering");
$test->testPageRender($base . '/index.php', 'Homepage');

echo "\nNote: Other pages require database connectivity and proper GET parameters.\n";
echo "For full integration testing, use IntegrationTest.php with a web server.\n";

exit($test->summary());
