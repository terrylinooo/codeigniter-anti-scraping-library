# Codeigniter-Anti-Scraping-Library

Protecting your content from illegal scraping is not so difficult. AntiScraping works just like how Google works, detects users' behavior and analyzes users' information such as:

- IP address
- IP address's resolved hostname
- Session cookie
- Javascript cookie
- User-agent
- PHP HTTP_REFERER varible
- Page views

###How it works?###

If an user has reached the limit of your settings, AntiScraping will ban him and show a warning page, ask for the user to complete the reCaptcha, once the user done, AntiScraping will remove him out of the ban list.

![Screenshot](http://i.imgur.com/PvA6WPP.png)

By default, AntiScraping allows popular search englines, Google and Bing, their crawlers' IP can be resolved to hostname and easy to identify.

###Requirment###

AntiScraping library needs [Google reCaptcha](https://github.com/google/recaptcha) to work.

Sign up for an API key https://www.google.com/recaptcha/admin#list

###Installation###

#####Files#####
1. Copy **/libraries/AntiScraping.php** to your /libraries/ folder.
2. Copy **/config/antiscraping.php** to your /config/ folder.
3. Copy **/views/captcha.php** to your /views/ folder.
4. Copy **/core/MY_Controller.php** to your /core/ folder
5. Extends your Controller to MY_Controller (Check out MY_Controller.php and simply modify it for your needs)

#####Install MySQL tables#####

AntiScraping creates two MySQL tables in MEMORY engine by default, but if you wish to use InnoDB, you need to add this line in your Controller at the first time use of AntiScraping library.

change
```php
$config['sql_engine'] = 'innodb';
```
then add this line:
```php
$this->antiscraping->install_sql();
```

###First Try###
```php
$this->load->library('AntiScraping');

// Test

$this->antiscraping->user_ip_address = '66.249.92.125';
$this->antiscraping->user_ip_resolve = 'rate-limited-proxy-66-249-92-125.google.com';
$this->antiscraping->user_agent = 'Mediapartners-Google';

$anti_scraping_result = $this->antiscraping->run();

```
Use phpMyAdmin to check out the table as_ip_rule, should see this IP has been added to "allow" list, because it is Googlebot IP. Everyone loves Googlebot :)



###API###


####rebuild_sql####
public function rebuild_sql();
```php
/**
 * Rebuild SQL tables.
 */
$this->load->library('AntiScraping');

$this->load->antiscraping->rebuild_sql();
```
When the log and rule tables have become too large, you can rebuild them. 
Run this method in a Cron job is a good idea.



####install_sql####
public function install_sql();
```php
/**
 * Install SQL data that Anti-Scraping needs. Only run this function one time at the beginning.
 *
 * @param string $sql_engine
 */
 
$this->load->library('AntiScraping');

$this->load->antiscraping->install_sql();
```


####remove_deny_ip####
public function remove_deny_ip($ip);
```php
/**
 * Remove single IP or IP range from $deny_ip_pool
 *
 * @param string $ip
 * @return bool
 */

$this->load->library('AntiScraping');
 
// Remove this ipv6 range.
$this->antiscraping->remove_deny_ip('2607:f0d0::/32');

// Remove single IP
$this->antiscraping->remove_deny_ip('66.249.92.125');

// Remove IP range
$this->antiscraping->remove_deny_ip('31.13.24.0/21');
```
 

####remove_allow_ip####
public function remove_allow_ip($ip);
```php
/**
 * Remove single IP or IP range from $allow_ip_pool varible
 *
 * @param string $ip
 * @return bool
 */

$this->load->library('AntiScraping');

// Remove this ipv6 range.
$this->antiscraping->remove_allow_ip('2607:f0d0::/32');

// Remove single IP
$this->antiscraping->remove_allow_ip('66.249.92.125');

// Remove IP range
$this->antiscraping->remove_allow_ip('31.13.24.0/21');
```

 
####add_deny_ip####
public function add_deny_ip($ip);
```php
/**
 * Add single IP or IP range to $deny_ip_pool varible
 *
 * @param string $ip
 * @return bool
 */

$this->load->library('AntiScraping');

// Ban this ipv6 range.. All ipv6 IP in this range will be banned **permanently**.
$this->antiscraping->add_deny_ip('2607:f0d0::/32');

// Ban single IP
$this->antiscraping->add_deny_ip('66.249.92.125');

// Ban IP range
$this->antiscraping->add_deny_ip('31.13.24.0/21');
```


####add_allow_ip####
public function add_allow_ip($ip);
```php
/**
 * Add single IP or IP range to $allow_ip_pool varible
 *
 * @param string $ip
 * @return bool
 */
 
$this->load->library('AntiScraping');
 
// Allow this ipv6 range.. All ipv6 IP in this range will be allowed **permanently**.
$this->antiscraping->add_allow_ip('2607:f0d0::/32');

// Allow single IP
$this->antiscraping->add_allow_ip('66.249.92.125');

// Allow IP range
$this->antiscraping->add_allow_ip('31.13.24.0/21');
```


####ip_in_range####
public function ip_in_range($ip, $ip_range);
```php
/**
 * Check if a given IP is in a network
 *
 * @param  string $ip
 * @param  string $range
 * @return boolean
 */
 
$this->load->library('AntiScraping');

$ip = '2607:f0d0:1002:0051:0000:0000:0000:0004';
$ip_range = '2607:f0d0::/32';

if ($this->antiscraping->ip_in_range($ip, $ip_range))
{
    echo 'This IP is in range';
}
else
{
    echo 'This IP is not in range';
}
```
This method is used for supporting check_ip_status(), I think you will not use it.



####check_ip_status####
public function check_ip_status($ip);
```php
/**
 * Check an IP if it exists in AntiScraping allow/deny list.
 *
 * @param string $ip
 * @return array|bool
 */

$this->load->library('AntiScraping');

// Check ipv6 IP address.. first add an IP range to test it..
$this->antiscraping->add_deny_ip('2607:f0d0::/32');

// This IP is in the ban range
$check_ip_result = $this->antiscraping->check_ip_status('2607:f0d0:1002:0051:0000:0000:0000:0004');

foreach ($check_ip_result AS $key => $value)
{
    echo $key . ': ' . $value . '<br />'; 
}
```
output:
```php
status: deny
code: 11
```
Return array('status', 'code') the meaning is below:

| status  | code | 
| ------------- | ------------- |
| deny  | 1 : An IP is denied by single IP (defined in array $deny_ip_pool) |
| deny  | 2 : An IP is denied by rule table (defined in MySQL as_ip_rule table) |
| deny  | 11 : An IP is denied by IP range (defined in array $deny_ip_pool)|
| allow  | 1 : An IP is allowed by single IP (defined in array $allow_ip_pool) |
| allow  | 2 : An IP is allowed by rule table (defined in MySQL as_ip_rule table) |
| allow  | 11 : An IP is allowed by IP range (defined in array $allow_ip_pool)|



####initialize####
public function initialize($config = array());
```php
/**
 * Load config settings and initialize them.
 * Overwrite settings by magic function __set()
 *
 * @param array $config
 */

$this->load->library('AntiScraping');
 
$config['time_period'] = 'h';
$config['limit_pageviews']['h'] = 20; // default: 30
$config['interval_check_referer'] = 3; // default: 5

// default config settings are defined in /config/antiScraping.php

$this->antiscraping->initialize($config);

$anti_scraping_result = $this->antiscraping->run();

if ($anti_scraping_result == 'deny')
{
    // do something
}
```
You will not use this method unless you reset the $config setting in your script.

initialize() must be placed before run()




####run####
public function run();
```php
/**
 * Check rule table first, if an IP address has been listed, return 'deny' or 'allow' status.
 * Call function detect() if an IP address is not listed in rule table
 *
 * @return string - 'deny' or 'allow' or 'unknown'
 */
$this->load->library('AntiScraping');
 
$anti_scraping_result = $this->antiscraping->run();

if ($anti_scraping_result == 'deny')
{
    // do something
}
```
####debug####
public function debug($is_display = FALSE, $is_reset = TRUE);
```php
/**
 * Set $is_reset to FALSE if you don't want to rest the user data.
 * It helps to fake an IP address to debug that Anti-Scraping works or not.
 
 * @param bool $display
 * @param bool $is_reset
 * @return string
 */
 
 $this->load->library('AntiScraping');
 
 // After useing debug(), the debug information will be displayed in the page source. (HTML)
 $this->antiscraping->debug();
 $anti_scraping_result = $this->antiscraping->run();
 
 if ($anti_scraping_result == 'deny')
 {
    // Show captcha page to current user.
 }
```
![Screenshot](http://i.imgur.com/UmZccno.png)

if $is_display = TRUE, the debug information will be displayed on the front page.



####is_social_useragent####
public function is_social_useragent();
```php
/**
 * Check If an user's User-Agent contains social-network crawler's information
 *
 * @return bool
 */
 
 $this->load->library('AntiScraping');
 
 if ($this->antiscraping->is_social_useragent())
 {
    // Hide content and only show meta infomation in head.
 }
```
is_social_useragent() only check User-Agent, it can be faked. I highly recommed you hide your main content and only show meta infomation in head, that is only needed information for social robots.
Social network such as Faceook, will assign a robot to crawl your page when an user "likes" your page.

####is_denied_robot####
public function is_denied_robot();
```php
/**
 * Check If is an user a denied robot
 *
 * @return bool
 */
 
$this->load->library('AntiScraping');

if ($this->antiscraping->is_denied_robot())
{
    exit('You are banned!');
}
```


####is_allowed_robot####
public function is_allowed_robot();
```php
/**
 * Check If is an user an allowed robot
 *
 * @return bool
 */
 
$this->load->library('AntiScraping');

if ($this->antiscraping->is_allowed_robot())
{
    echo 'You are allowed to scrape many web pages as you want!'; 
}
```


####is_google####
public function is_google();
```php
/**
 * Check If is an user a Googlebot
 *
 * @return bool
 */
 
$this->load->library('AntiScraping');

if ($this->antiscraping->is_google())
{
   echo 'Hello! Googlebot!';
}
```


####is_bing####
public function is_bing();
```php
/**
 * Check If is an user a Bingbot
 *
 * @return bool
 */
 
$this->load->library('AntiScraping');

if ($this->antiscraping->is_bing())
{
    echo 'Hello! Bingbot!';
}
```


####is_yahoo####
public function is_yahoo();
```php
/**
 * Check If is an user a Yahoo bot
 *
 * @return bool
 */
 
$this->load->library('AntiScraping');

if ($this->antiscraping->is_is_yahoo())
{
   echo 'Ya~~~~hoooooooooooooo';
}
```


####is_robot####
public function is_robot();
```php
/**
 * Check If is an user a robot
 *
 * @return bool
 */
 
$this->load->library('AntiScraping');

if ($this->antiscraping->is_robot())
{
   // show something to search engine.
}
```




####delete_ip_rule####
public function delete_ip_rule($ip = '');
```php
/**
 * After a user has completed a CAPTCHA, delete his IP from Ban list.
 *
 * @param string $ip
 * @return bool
 */

$this->load->library('AntiScraping');

$anti_scraping_result = $this->antiscraping->run();

if ($anti_scraping_result == 'deny')
{
    if ($this->input->post('g-recaptcha-response'))
    {
        $remoteIp           = $this->input->ip_address();
        $gRecaptchaResponse = $this->input->post('g-recaptcha-response');

        $recaptcha = new \ReCaptcha\ReCaptcha(CAPTCHA_SECRET_KEY);
        $resp = $recaptcha->verify($gRecaptchaResponse, $remoteIp);

        if ($resp->isSuccess())
        {
            $this->antiscraping->delete_ip_rule();
        }
        else
        {
            $this->_reCaptcha();
        }
    }
    else
    {
        $this->_reCaptcha();
    }
}
```

####ban_ip_rule####
public function ban_ip_rule($assign_ip);
```php
/**
 * Manually ban an IP address
 *
 * @param string $assign_ip
 */

$this->load->library('AntiScraping');

$this->antiscraping->ban_ip_rule('127.0.0.1');
```
If you are testing your webiste on localhost environment (127.0.0.1), you will see you're banned immediately.



###Global Functions###


####CI_AntiScraping####
CI_AntiScraping()
```php
/**
 * Print javascript snippet in your webpages.
 * Use this function in your View
 */
 
 <?= CI_AntiScraping() ?>
```
![Screenshot](http://i.imgur.com/9GZX0Mn.png)

CI_AntiScraping() will output javascript snippet to generate cookie. Don't forget to set *cookie_domain* in config file.

###Varibles###

####enable_filtering####

If you don't want AntiScriping to detect bad robots or crawlers, you can set it FALSE;
In this case AntiScriping can still deny users by querying rule table (MySQL) and $deny_ip_pool (Array)

```php
$this->load->library('AntiScraping');

$this->enable_filtering = FALSE;

$anti_scraping_result = $this->antiscraping->run();

if ($anti_scraping_result == 'deny')
{
    // do something
}
```
