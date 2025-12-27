# Project Progress - Tech Debt Cleanup & Code Review

## Completed Tasks (Dec 27, 2025)

### 1. Error Reporting & Debugging
- Updated `public_html/backend.php` to enable full error reporting (`E_ALL`) and display errors. This ensures compatibility issues with PHP 8.3 are visible during development.

### 2. Security Improvements
- **SQL Injection Prevention:** Fixed `public_html/classes.inc.php`'s `cleanVars` function. The `sql` case was incorrectly applying `htmlentities` to data destined for SQL queries, which caused issues with literal characters (like apostrophes) and didn't provide proper protection. It now correctly uses `mysqli_real_escape_string`.
- **XSS Prevention:** Updated `public_html/search.inc.php`, `public_html/items.php`, `public_html/quests.php`, and `public_html/monsters.php` to use `htmlspecialchars` when echoing user-provided search terms back into form inputs.
- **Mixed Content Fix:** Updated `public_html/content/layout.inc` to use HTTPS for jQuery CDN links, avoiding mixed content warnings.

### 3. Tech Debt Cleanup
- **Redundant Scripts:** Removed double-loading of jQuery in `layout.inc` and upgraded to a modern version (3.7.1).
- **Output Buffering & Redirects:** Refactored `items.php`, `quests.php`, and `monsters.php` to handle redirects and session/cookie logic *before* any output is generated, resolving "headers already sent" issues.
- **Function Logic:** Modified `city_shops` and `city_npc` in `public_html/functions.inc.php` to return strings instead of echoing directly. This ensures they work correctly with the `dynamify` function and maintain proper output order.
- **API Robustness:** Added fallbacks for APC/APCu caching in `api.base.inc.php` (both in `api/` and `api_dev/`) to prevent fatal errors when the extension is missing.
- **General Cleanup:** Standardized logic in `misc.php` and `minigames.php` to handle missing IDs gracefully and avoid PHP notices.
- **Modernization & Security (Latest):** 
    - Fixed `mysqli_sql_exception: No database selected` errors in `quests.php`, `items.php`, `monsters.php`, and `statsgrabber.php` by ensuring early database connection and selection.
    - Implemented comprehensive XSS protection using `htmlspecialchars` across `quests.php`, `items.php`, `monsters.php`, `statsgrabber.php`, `search.inc.php`, `tomes.php`, `shops.php`, and others.
    - Secured SQL queries in `stats_functions.inc.php`, `price_cat_functions.inc.php`, and various page scripts by enforcing strict integer casting and string escaping.
    - Refactored `classes.inc.php`'s `page` class to support centralized, secure guide rendering with area-specific templates and fixed template paths.
    - Secured `locator_image.php` by validating and sanitizing all coordinate and direction inputs.
    - Improved `classes.inc.php`'s `cleanVars` to initialize `$dataArr`, preventing potential `extract()` errors in `backend.php`.
    - Fixed `Undefined array key "map"` warning in `cities.php` by adding a null coalescing operator.
    - Updated `schema.sql` to include the `cities` table definition.
    - Modernized frontend layout using Flexbox and CSS variables in `global_new.css`.
    - Refactored theme management to use `localStorage` for better persistence and FOUC prevention.
    - Standardized legacy PHP tags and removed dangerous `document.writeln` calls.
    - Updated Google Analytics to GA4 (`G-Z60SEVLSGL`) in `layout.inc` and `osrsplayers.php`.
    - **Rebranding:**
        - Renamed the project from "Zybez" to "OSRS RuneScape Help" across all code, text, and documentation.
        - Updated security constant from `IN_ZYBEZ` to `IN_OSRS_HELP`.
        - Updated URLs from `zybez.net` to `2007rshelp.com`.
        - Cleaned up sitemap XML tags and files.
        - Created `update_project_name.sql` for database data migration.

### 4. Code Review Findings
- **Database Patterns:** The codebase generally relies on "clean input" via `cleanVars`. This has been strengthened.
- **Template System:** The placeholder replacement system in `backend.php` (e.g., `[#CONTENT#]`) is functional but relies on output buffering.
- **Broken Features:** `equipmentprofile.php` is known to be broken (missing `equipment` table) but is considered unused.
- **Outdated Analytics/Ads:**
    - The current Google Analytics code uses Universal Analytics (`UA-` prefix), which was sunset by Google in July 2023. It needs to be updated to Google Analytics 4 (GA4).
    - AdSense snippets are using old manual placement styles. Modern "Auto-Ads" or responsive ad units would work better with the new Flexbox layout.

## Next Steps
- **Action Required:** Review and update AdSense snippets for better mobile performance.
- Investigate remaining files in `public_html/` for similar XSS and SQLi patterns.
