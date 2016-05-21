<?php defined('BASEPATH') OR exit('No direct script access allowed.');

// SQL table for AntiScraping library.

$config['db_table_log'] = 'as_ip_log';
$config['db_table_ip_rule'] = 'as_ip_rule';

// AntiScraping SQL tables will using the follwing storage engine..
// memory, innodb, myisam
// Notice: "memory" storage engine is temporary. The data will be disappeared when you reboot system.

$config['sql_engine'] = 'memory';

// time_period

$config['time_period'] = 'h'; // s: second, m: minute, h: hour, d: day

// limit_pageviews
// The setting "time_period" decides how many pageviews an user can view in a specific period.
// For example, time_period = m, it means an user can only view 10 pages (defined below) in 1 minute, and then need to solve Chaptcha to continue..
// The limitation is defined below:

$config['limit_pageviews']['s'] = 2; // unit: views
$config['limit_pageviews']['m'] = 10;
$config['limit_pageviews']['h'] = 30;
$config['limit_pageviews']['d'] = 60;

// interval_check_referer
// Anti-Scraping will check HTTP_REFERER if the "last access time" - "now time" < "defined value".

$config['interval_check_referer'] = 5; // unit: second

// interval_check_session
// Anti-Scraping will check session_id if the "last access time" - "now time" < "defined value".

$config['interval_check_session'] = 30; // unit: second

// reset_flags
// How many seconds to reset an user's record. It will reset all flags to 0.

$config['reset_flags'] = 3600; // unit: second

// limit_flags
// Anti-Scraping will ban an user who reached the limit.

$config['limit_flags']['cookie'] = 5;
$config['limit_flags']['session'] = 5;
$config['limit_flags']['referer'] = 10;

// cookie_name for javascript.

$config['cookie_name'] = 'ssjd';

// cookie_domain

$config['cookie_domain'] = '';
