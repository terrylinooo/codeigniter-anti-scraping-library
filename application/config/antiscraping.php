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

/*
 * Robot information list
 */

// Please add a 'dot' before the domain string
// to prevent fake hostname such as: agooglebot.com, yyahoo.com

$config['robot']['allow_robot_host'] = array(
    '.googlebot.com',
    '.google.com',
    '.live.com',   // search.live.com
    '.msn.com',    // msnbot.msn.com, search.msn.com
    '.ask.com',
    '.bing.com',
    '.inktomisearch.com',
    '.yahoo.com',
    '.yahoo.net',  // crawl.yahoo.net
    '.yandex.com',
    '.yandex.ru',
    '.w3.org'
);

$config['robot']['deny_robot_host'] = array(
    '.webcrawler.link'
);

/*
 *  Notice: The defined user-agent strings below, their IP address must can be resolved as domain name defined 
 *  in $config['robot']['allow_robot_host'] array, otherwise AntiScraping will ignore this setting.
 *
 *  Ex. Baiduspider's hostname is not resolved to the correct IP address, for security reason, AntiScraping doesn't
 *  trust it because it is very easy to fake User-Agent information.
 * 
 *  If you put "baidu" here, the Baiduspider's IP will be banned because cannot resolve hostname to current IP, 
 *  AntiScraping think this is fake hostname.
 */

$config['robot']['allow_robot_useragent'] = array(
    'google',
    'bing',
    'live',
    'msn',
    'ask',
    'inktomisearch',
    'yahoo',
    'yandex',
    'w3.org'
);

$config['robot']['deny_robot_useragent'] = array(
    'archive.org', // Wayback machine
    'ahrefs.com',
    'tweetmeme.com',
    'findlinks',
    'grapeshot.co.uk'
);

$config['robot']['social_robot_useragent'] = array(
    'Twitterbot',
    'Facebot',
    'facebookexternalhit',
    'Pinterest'
);

// Just let is_robot() knows the user-agent information below is also robot.

$config['robot']['other_robot_useragent'] = array(
    'baidu'
);
