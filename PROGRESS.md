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
    - **UI/Cleanup:**
        - Fixed missing header image and restored top leaderboard ad positioning (floating on the right side of the header).
        - Properly centered the vertical sidebar AdSense banner using Flexbox and auto-margins.
        - Fixed `Undefined array key "id"` warning in `classes.inc.php`.
        - Removed legacy Facebook SDK and Like buttons.
    - **Rebranding:**

### 4. Code Review Findings
- **Database Patterns:** The codebase generally relies on "clean input" via `cleanVars`. This has been strengthened.
- **Template System:** The placeholder replacement system in `backend.php` (e.g., `[#CONTENT#]`) is functional but relies on output buffering.
- **Broken Features:** `equipmentprofile.php` is known to be broken (missing `equipment` table) but is considered unused.
- **Outdated Analytics/Ads:**
    - The current Google Analytics code uses Universal Analytics (`UA-` prefix), which was sunset by Google in July 2023. It needs to be updated to Google Analytics 4 (GA4).
    - AdSense snippets are using old manual placement styles. Modern "Auto-Ads" or responsive ad units would work better with the new Flexbox layout.

### 5. UI & Advertising Modernization (Dec 27, 2025 - Part 2)
- **Responsive AdSense:**
    - Replaced legacy `advert_side()` and `advert_top()` JS calls in `public_html/content/ads.inc` with modern, responsive AdSense units.
    - Updated `public_html/content/layout.inc` top leaderboard to use a responsive AdSense unit.
    - Added CSS in `public_html/css/global_new.css` to handle the `.top-leaderboard-container` with absolute positioning on desktop and static/centered positioning on mobile.
- **XSS Protection (Global):**
    - Identified and fixed a widespread XSS vulnerability where `$_SERVER['SCRIPT_NAME']` and `$_SERVER['PHP_SELF']` were echoed directly without escaping.
    - Fixed typos in `public_html/editor/correction.php` (e.g., `$_SERVER['SCRIPT_NAME';`).
- **CLI Optimization:**
    - Created `.geminiignore` to exclude large directories (like `public_html/img` at 536MB) and sensitive files from CLI indexing, preventing "JavaScript heap out of memory" errors.

### 6. Header Banner Layout Fix & Modernization (Dec 27, 2025 - Part 3)
- **Fixed Duplicate Header Issue:**
    - Modified `public_html/css/global_new.css` to ensure the `#banner` element properly displays the header background image without duplication.
    - Added `background-size: cover` to the `#banner` div for proper scaling of the header image.
    - Changed `#banner a` to use `position: absolute` instead of being a block element in the normal document flow, ensuring it overlays the entire banner area without taking up space.
    - **Root Cause**: Discovered the responsive CSS at `@media (max-width: 950px)` was setting `.top-leaderboard-container` to `position: static` and `height: auto`, which caused the AdSense container to expand the banner div beyond its 100px height, creating the appearance of duplicate headers.
- **Removed Top Horizontal AdSense Banner:**
    - Completely removed the horizontal AdSense banner from the header area in `public_html/content/layout.inc`.
    - Removed associated `.top-leaderboard-container` CSS styles from `public_html/css/global_new.css`.
    - Simplified the responsive CSS for the banner section.
- **Removed Redundant AdSense Units:**
    - Removed duplicate sidebar AdSense banner from `public_html/content/ads.inc`.
    - Now only 2 AdSense units remain: 1 sidebar (in links.inc) and 1 bottom-of-content (in layout.inc).
- **Modernized Header HTML:**
    - Replaced outdated table-based layout in `public_html/content/bar-top.inc` with semantic HTML5 using `<nav>`, flexbox, and proper structure.
    - Replaced table-based layout in `public_html/content/bar-bottom.inc` with modern flexbox layout.
    - Added semantic `<header role="banner">` wrapper in `public_html/content/layout.inc`.
    - Added ARIA labels and accessibility improvements (aria-label, role attributes).
    - Added new CSS classes for modern layout: `.theme-selector`, `.theme-options`, `.bottombar-content`, `.search-container`, `.sr-only`.
    - Fixed theme selector layout to keep "THEMES" text and icons on the same line using `flex-wrap: nowrap`.
    - Positioned search box to the right side of the bottom bar with `justify-content: flex-end` and added modern styling (rounded borders, hover effects).
    - Removed unnecessary sr-only span from banner (accessibility maintained via aria-label on anchor).
    - Maintained identical visual appearance while using modern, accessible HTML5 markup.
- **Cleaned Up Layout:**
    - Removed duplicate `popUpImage` element from `public_html/content/layout.inc` that was appearing at the end of the file.
- **Result:** The header now uses modern, semantic HTML5 with improved accessibility while maintaining the same visual appearance. Clean layout with no duplication issues and optimized AdSense placement.

## Next Steps
- Continue reviewing `public_html/editor/` for legacy patterns.
- Monitor for any layout issues on specific pages with the new responsive ad units.
