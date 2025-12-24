<?php
/*** Configuration ***/

/* Site Conf */
$Confuration['site_name']  = 'RuneScape Help Editor';
$Confuration['site_url']   = 'https://2007rshelp.com';

/* DB Conf */
$Confuration['mysql_host'] = 'localhost';
$Configuration['mysql_user'] = 'rsc';
$Configuration['mysql_pass'] = 'heyplants44';
$Configuration['mysql_db']   = 'rsc_site';


// Online / Offline- Addition by Ben: 19 apr.
$Configuration['offline'] = FALSE;

/* Define Global Values */
define( 'MYSQL_HOST'	, $Configuration['mysql_host']	);
define( 'MYSQL_USER'	, $Configuration['mysql_user']	);
define( 'MYSQL_PASS'	, $Configuration['mysql_pass']	);
define( 'MYSQL_DB'		, $Configuration['mysql_db']	);
define( 'SITE_NAME'		, $Configuration['site_name']	);
define( 'SITE_URL'		, $Configuration['site_url']	);
define( 'OFFLINE'		, $Configuration['offline']		);
?>
