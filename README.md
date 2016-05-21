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
 
####remove_deny_ip####
public function remove_deny_ip($ip);
```php
/**
 * Remove single IP or IP range from $allow_ip_pool varible
 *
 * @param string $ip
 * @return bool
 */
 ```
####remove_allow_ip####
public function remove_allow_ip($ip);
```php
/**
 * Add single IP or IP range to $deny_ip_pool varible
 *
 * @param string $ip
 * @return bool
 */
 ```
    public function add_deny_ip($ip);

    /**
     * Add single IP or IP range to $allow_ip_pool varible
     *
     * @param string $ip
     * @return bool
     */
    public function add_allow_ip($ip);

    /**
     * Check if a given IP is in a network
     *
     * @param  string $ip
     * @param  string $range
     * @return boolean
     */
    public function ip_in_range($ip, $ip_range);

    /**
     * Check an IP if it exists in AntiScraping allow/deny list.
     *
     * @param string $ip
     * @return array|bool
     */
    public function check_ip_status($ip);

    /**
     * Load config settings and initialize them.
     * Overwrite settings by magic function __set()
     *
     * @param array $config
     */
    public function initialize($config = array());

    /**
     * Check rule table first, if an IP address has been listed, return 'deny' or 'allow' status.
     * Call function detect() if an IP address is not listed in rule table
     *
     * @return string - 'deny' or 'allow' or 'unknown'
     */
    public function run();


    /**
     * Set $is_reset to FALSE if you don't want to rest the user data.
     * It helps to fake an IP address to debug that Anti-Scraping works or not.
     *
     * @param bool $is_reset
     * @return string
     */
    public function debug($display = FALSE, $is_reset = TRUE);

    /**
     * Check If an user's User-Agent contains social-network crawler's information
     *
     * @return bool
     */
    public function is_social_useragent();

    /**
     * Check If is an user really a search engine crawler.
     *
     * @return bool
     */
    public function is_search_engine();

    /**
     * After a user has completed a CAPTCHA, delete his IP from Ban list.
     *
     * @param string $ip
     * @return bool
     */
    public function delete_ip_rule($ip = '');

    /**
     * Manually ban an IP address
     *
     * @param string $assign_ip
     */
    public function ban_ip_rule($assign_ip);

###Examples###
