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
or change *$config['sql_engine']* to *innodb* then add this line:
```php
$this->antiscraping->install_sql();
```
###API###


###Examples###
