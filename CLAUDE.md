# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a legacy PHP website for Old-School RuneScape (OSRS) help and database resources. The site provides:
- Item database with search functionality
- Monster/NPC database
- Quest guides
- Skill guides and calculators
- Price guide (redirects to runescapecommunity.com)
- API endpoints for monsters and items
- Content management editor system

The site uses a custom MVC-like architecture built on PHP 5/7 with MySQLi, jQuery, and vanilla JavaScript.

## Core Architecture

### Bootstrap Flow
All public-facing pages follow this pattern:
1. Define `$cleanArr` array for input sanitization
2. Require `backend.php` (the bootstrap file)
3. Call `start_page($title)` to initialize
4. Output page content
5. Call `end_page()` to render template

### Key Files

**Backend System** (`/public_html/`):
- `backend.php` - Application bootstrap, establishes database connection, loads classes/functions, handles page rendering
- `config.inc.php` - Configuration (database credentials, site URL, offline mode)
- `classes.inc.php` - Core classes: `db` (database wrapper), `display` (templating/security), `timer` (performance), `page` (guide rendering)
- `functions.inc.php` - Shared utility functions (`dynamify()`, `city_key()`, `city_shops()`, `monsters()`, etc.)

**Database Classes**:
- `db` class in `classes.inc.php` provides MySQLi wrapper with methods: `connect()`, `query()`, `fetch_row()`, `fetch_array()`, `num_rows()`, `escape_string()`
- Database credentials defined in `config.inc.php` as constants (MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB)

**Display & Templating**:
- `display` class handles template loading via `get_file()`, CSS selection, input sanitization via `cleanVars()`, and page metadata
- Templates in `/content/` directory (layout.inc, links.inc, ads.inc, copyright.inc, etc.)
- Template uses placeholder replacement: `[#SITE_NAME#]`, `[#CONTENT#]`, `[#LINKS#]`, `[#ADS#]`, etc.

**Input Sanitization**:
- All pages define `$cleanArr` array with validation rules before requiring backend.php
- Format: `array('var_name', $_GET['key'], 'type', 'options')`
- Types: `int`, `sql`, `string`, `enum`, `bin`, `ip`
- Options: `s` (min,max range), `l` (max length), `e` (enum values), `d` (default)
- Automatically extracted after sanitization if `$cleanArr` is set

### API System

**Location**: `/public_html/api/`

**Architecture**:
- Entry point: `api.php` loads `api.inc.php` and instantiates API class
- `api.inc.php` extends `api.base.inc.php` (base API functionality)
- Clean URLs via `.htaccess`: `/api/monsters/black+dragon` → `api.php?api_action=monsters&api_query=black+dragon`
- Actions defined as protected methods: `actionMonsters()`, `actionItems()`, etc.
- Built-in caching system via `cacheFetch()` and `cacheStore()`
- Returns JSON responses with proper content-type headers

**Available Endpoints**:
- `/api/monsters/{search}` - Search monsters/NPCs
- `/api/items/{search}` - Search items

### JavaScript Architecture

**Calculator System** (`calcs.js`):
- Handles RuneScape XP calculations with functions: `findXp(level)`, `findLevel(xp)`, `reCalculate()`
- Supports skill calculators with bonus multipliers (sacred clay tools, prayer methods, combat modes)
- Features reverse mode to calculate levels achieved from X actions
- Includes table sorting functionality

**Other JavaScript**:
- `compare.js` - Equipment comparison functionality
- `equipmentprofile.js` - Equipment profile display
- `graphs/` directory contains graphing functionality (uses Flash SWF and modern JS alternatives)

### Database Tables

Based on code analysis, key tables include:
- `monsters` - NPC/monster data (id, name, combat, hp, race, member, nature, attstyle, examine, locations, drops, i_drops, tactic, notes, img)
- `items` - Item database (id, name, type, member, trade, quest, obtain, examine, notes, keyword, img)
- `quests` - Quest guides (id, name, type, text, reward, difficulty, length, author)
- `skills` - Skill guides (id, name, type, author, time, text)
- `cities` - City guides
- `shops` / `shops_items` - Shop information

## Development Commands

### Testing/Debugging

Enable debug mode:
```php
$DEBUG = 1;  // Shows SQL queries and input validation errors
```

**Test Suite**: Basic integration tests are available in `/tests/`:
- `TestRunner.php` - Main test runner
- `IntegrationTest.php` - Database and core functionality tests
- `PageRenderTest.php` - Template rendering tests
- Run tests: `php tests/TestRunner.php`

### Database Access

The database connection is established automatically via `backend.php`. Access via global `$db` object:
```php
global $db;
$result = $db->query("SELECT * FROM monsters WHERE id = 123");
$row = $db->fetch_array($result);
```

### CLI Utilities

**Item Scraper** (`cli_scraper.php`):
A command-line utility for scraping and adding OSRS items from the official RuneScape item database.

Usage:
```bash
# Scan for new items in Top 100 lists
php cli_scraper.php scan

# Add a specific item by OSRS ID and name
php cli_scraper.php add 556 "Air rune"

# Auto-add all new items found in Top 100
php cli_scraper.php auto
```

Features:
- Scrapes item data from secure.runescape.com
- Extracts name, examine text, member status, and item images
- Downloads and saves item images to `/public_html/img/idbimg/`
- Checks for duplicates before inserting
- Color-coded terminal output for new vs. existing items
- Polite 1-second delay between requests in auto mode

**IMPORTANT**: Do not delete `cli_scraper.php` - it's an active utility used for database maintenance.

### Running the Site

This is a traditional PHP application - no build process required. Configure a web server (Apache/nginx) with PHP and MySQL:

1. Ensure PHP 7.0+ with MySQLi extension
2. Point document root to `/public_html/`
3. Configure database credentials in `config.inc.php`
4. Ensure mod_rewrite enabled for API clean URLs

### Editor System

**Location**: `/public_html/editor/`

The editor is a content management system for authorized users with:
- Session-based authentication (`sessions.php`, `login_class.inc.php`)
- File upload functionality (`upload_class.php`)
- WYSIWYG editing capabilities
- Content includes guides, videos, ads, polls, IRC integration

Access requires login credentials stored in the database.

## Important Conventions

### Security Practices

1. **Input Validation**: Always define `$cleanArr` before requiring backend.php
2. **SQL Injection**: Use `$db->escape_string()` or parameterized queries via cleanVars
3. **XSS Prevention**: The `cleanVars()` method applies `htmlentities()` to string/sql types
4. **Access Control**: Check `IN_ZYBEZ` constant is defined in included files

### Code Patterns

**Creating a New Page**:
```php
<?php
$cleanArr = array(
    array('id', $_GET['id'], 'int', 's' => '1,9999')
);
require(dirname(__FILE__) . '/backend.php');
start_page('Page Title');

// Page content here

end_page();
?>
```

**Dynamic Content Function Calls**:
The `dynamify()` function allows embedding function calls in database content:
- Format: `($func->function_name(#param1||param2#)$)`
- Used for city keys, shop lists, monster lists in city guides

**Template Variables**:
Common replacements in layout.inc:
- `[#SITE_NAME#]` - Page title
- `[#CONTENT#]` - Main content (from ob_start/ob_get_contents)
- `[#LINKS#]` - Navigation menu
- `[#ADS#]` - Advertisement content
- `[#QUERIES#]` - Database query count
- `[#TIME#]` - Page generation time
- `[#LOAD#]` - Server load percentage

## Known Issues & Legacy Code

**Security**: A comprehensive security audit was completed in December 2024, addressing:
- SQL injection vulnerabilities (all queries now use proper escaping)
- XSS vulnerabilities (output now properly sanitized with htmlspecialchars)
- Path traversal issues (file paths now validated)
- Session security (secure flags, regeneration, timeout enforcement)

**Remaining Legacy Issues**:
- Error reporting suppresses notices and warnings
- Some features reference deprecated/removed services (Discord, Zybez forums redirect to runescapecommunity.com)
- Database credentials are committed in `config.inc.php` (consider using environment variables)
- jQuery loaded twice in layout.inc (versions 1.10.2 and 1.11.0)
- Mixed HTTP/HTTPS references in templates

## File Organization

```
/
├── CLAUDE.md                # Project documentation for Claude Code
├── cli_scraper.php          # CLI utility for scraping OSRS items
├── .env.example             # Example environment configuration
├── .gitignore               # Git ignore rules
├── /tests/                  # Test suite
│   ├── TestRunner.php
│   ├── IntegrationTest.php
│   └── PageRenderTest.php
└── /public_html/            # Web root
    ├── backend.php          # Application bootstrap
    ├── config.inc.php       # Configuration
    ├── classes.inc.php      # Core classes
    ├── functions.inc.php    # Shared utility functions
    ├── index.php            # Homepage
    ├── items.php            # Item database browser
    ├── monsters.php         # Monster database browser
    ├── quests.php           # Quest guide browser
    ├── skills.php           # Skill guide browser
    ├── calcs.php            # Skill calculators
    ├── /api/                # JSON API endpoints
    ├── /editor/             # Content management system
    ├── /content/            # Page templates & includes
    ├── /css/                # Stylesheets (multiple themes)
    ├── /graphs/             # Graphing functionality
    ├── /img/                # Images organized by type
    │   ├── /idbimg/         # Item images
    │   ├── /npcimg/         # Monster/NPC images
    │   └── /qimg/           # Quest guide images
    └── *.js                 # Client-side scripts
```

## Maintenance Notes

**Tech Debt Cleanup**: Previous documentation files (SECURITY.md, TEST_RESULTS.md, MIGRATION_*.md, etc.) and backup files (.bak) have been removed. The codebase is now cleaner with only essential files retained.

**Active Utilities**:
- `cli_scraper.php` is actively used for database maintenance - do not remove
- Test suite in `/tests/` is used for validation - do not remove
