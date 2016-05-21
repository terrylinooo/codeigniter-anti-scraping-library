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

If an user reached the limit of your settings, AntiScraping will ban him and show a warning page, ask for the user to complete the reCaptcha, once the user done, AntiScraping will remove him out of the ban list.

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

#####Install Mysql tables#####

AntiScraping creates two MySQL tables in MEMORY engine by default, but if you wish to use InnoDB, you need to add this line in your Controller at the first time use of AntiScraping library.

```php
// sql_engine: memory, innodb, myisam
$this->antiscraping->install_sql('innodb');
```
or change
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
public function rebuild_sql($sql_engine = 'InnoDB');
```php
/**
 * Rebuild SQL tables.
 *
 * @param string $sql_engine
 */
```

####install_sql####
public function install_sql($sql_engine = 'InnoDB');
```php
/**
 * Install SQL data that Anti-Scraping needs. Only run this function one time at the beginning.
 *
 * @param string $sql_engine
 */
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
```

####check_ip_status####
public function check_ip_status($ip);
```php
/**
 * Check an IP if it exists in AntiScraping allow/deny list.
 *
 * @param string $ip
 * @return array|bool
 */
```

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
public function debug($display = FALSE, $is_reset = TRUE);
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

if $display = TRUE, the debug information will be displayed on the front page.


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


####is_search_engine####
public function is_search_engine();
```php
/**
 * Check If is an user really a search engine crawler.
 *
 * @return bool
 */
 
$this->load->library('AntiScraping');
 
$anti_scraping_result = $this->antiscraping->run();

if ($anti_scraping_result == 'deny')
{
    // do something..
}
if ($this->antiscraping->is_search_engine())
{
   // show something to search engine.
}
```
is_search_engine() must be placed after run(), because AntiScraping checks IP and Hostname to double confirm that if the current user is  a search engline crawler. 


####delete_ip_rule####
public function delete_ip_rule($ip = '');
```php
/**
 * After a user has completed a CAPTCHA, delete his IP from Ban list.
 *
 * @param string $ip
 * @return bool
 */
 
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
```

