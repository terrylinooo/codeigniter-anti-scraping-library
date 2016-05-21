<?php
/**
 * @name        CodeIgniter Anti-Scraping Library
 * @author      Terry Lin
 * @link        https://github.com/terrylinooo/Codeigniter-Anti-Scraping-Library/
 * @license     MIT License Copyright (c) 2016 Terry Lin
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */


class AntiScraping implements AntiScrapingInterface
{


   // Anyone need this library??
   



}

interface AntiScrapingInterface
{
    /**
     * Rebuild SQL tables.
     *
     * @param string $sql_engine
     */
    public function rebuild_sql();

    /**
     * Install SQL data that Anti-Scraping needs. Only run this function one time at the beginning.
     *
     * @param string $sql_engine
     */
    public function install_sql($sql_engine = 'InnoDB');

    /**
     * Remove single IP or IP range from $deny_ip_pool
     *
     * @param string $ip
     * @return bool
     */
    public function remove_deny_ip($ip);

    /**
     * Remove single IP or IP range from $allow_ip_pool
     *
     * @param string $ip
     * @return bool
     */
    public function remove_allow_ip($ip);

    /**
     * Add single IP or IP range to $deny_ip_pool
     *
     * @param string $ip
     * @return bool
     */
    public function add_deny_ip($ip);

    /**
     * Add single IP or IP range to $allow_ip_pool
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
     * @param bool $display
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
}
/**
 * Put this global function in your HTML template, usually in the footer.
 *
 * @return string
 */

function CI_AntiScraping()
{
    return AntiScraping::set_javascript_cookie() . "\n" . AntiScraping::$debug_message_output;
}
