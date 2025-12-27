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

### 4. Code Review Findings
- **Database Patterns:** The codebase generally relies on "clean input" via `cleanVars`. This has been strengthened.
- **Template System:** The placeholder replacement system in `backend.php` (e.g., `[#CONTENT#]`) is functional but relies on output buffering.
- **Broken Features:** `equipmentprofile.php` is known to be broken (missing `equipment` table) but is considered unused.

## Next Steps
- Review `public_html/skills.php` for similar patterns.
- Investigate `public_html/calcs.php` for tech debt.
- Consider moving to a more modern database layer (like PDO with prepared statements) for better security, although `cleanVars` is currently the established pattern.
- Check and fix remaining mixed content (HTTP links) in other include files.
