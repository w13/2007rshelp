# 2007rshelp - RuneScape Fansite

A legacy RuneScape fansite and help resource. This project contains the source code for the website, which has served the community for over two decades.

## History

The website first went online in **January 2001**, originally established as a resource for RuneScape players. It has evolved through various eras of the game, accumulating a vast database of guides, calculators, and tools.

## Tech Stack

- **Language:** PHP (Legacy codebase, recently migrated to PHP 8.3)
- **Server:** Apache
- **Database:** MySQL
- **Frontend:** HTML, CSS, JavaScript (jQuery)

## Project Structure

- `public_html/`: The web root containing the main application logic, assets, and scripts.
- `api/`: Backend API endpoints.
- `editor/`: Content management and administrative tools.
- `tests/`: Integration and unit tests.

## Development

### Requirements
- PHP 8.3+
- Apache Web Server
- MySQL / MariaDB

### Local Setup
1. Clone the repository.
2. Configure your web server to serve `public_html` as the document root.
3. Copy `config.inc.php.example` to `config.inc.php` in `public_html/` and configure database credentials.
