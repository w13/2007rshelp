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
    - Updated `skills.php`, `misc.php`, `minigames.php`, `cities.php`, `guilds.php`, `dungeonmaps.php`, `miningmaps.php`, `tomes.php`, and `shops.php` to use `htmlspecialchars` for database-sourced content, preventing XSS.
    - Secured `shops.php` by implementing proper integer casting for IDs and sanitizing search parameters.
    - Hardened `price_cat_functions.inc.php` against SQL injection by enforcing integer casting and string escaping in all tree-management functions.
    - Refactored `classes.inc.php`'s `page` class to support centralized, secure guide rendering with area-specific templates.
    - Secured `locator_image.php` by validating and sanitizing all coordinate and direction inputs.
    - Improved `classes.inc.php`'s `cleanVars` to initialize `$dataArr`, preventing potential `extract()` errors in `backend.php`.
    - Fixed SQL injection vulnerability in `calcs_functions.inc.php` by properly escaping the `$user` variable before using it in queries and using `urlencode` for CURL requests.
    - Improved `calcs.php` with proper escaping of database content in tables and headings.
    - Standardized on standard PHP tags instead of short tags in `cities.php`.
    - **Frontend Revamp:**
        - Modernized `global_new.css` to use Flexbox layout instead of floats and fixed widths, improving responsiveness.
        - Introduced CSS variables for better theme management and consistency.
        - Refactored `scripts.js` to use `localStorage` for theme persistence instead of cookies with hardcoded expiration dates.
        - Optimized theme loading in `layout.inc` to prevent "flash of unstyled content" (FONT) by applying the theme early in the `<head>`.
        - Cleaned up `bar-top.inc` by removing legacy tables and using Flexbox for alignment.
        - Removed dangerous `document.writeln` calls and cleaned up legacy ad-tracking code in `scripts.js`.

### 4. Code Review Findings
- **Database Patterns:** The codebase generally relies on "clean input" via `cleanVars`. This has been strengthened.
- **Template System:** The placeholder replacement system in `backend.php` (e.g., `[#CONTENT#]`) is functional but relies on output buffering.
- **Broken Features:** `equipmentprofile.php` is known to be broken (missing `equipment` table) but is considered unused.

## Next Steps
- Investigate remaining files in `public_html/` for similar XSS and SQLi patterns.
- Review `public_html/compare.php` and related functions.
- Look into `public_html/priceguide.php`.
- Consider refactoring the guide display logic into a more centralized class/function to avoid repetition.
- Check and fix remaining mixed content (HTTP links) in other include files.
