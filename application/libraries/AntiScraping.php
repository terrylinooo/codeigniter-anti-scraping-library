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
    public function rebuild_sql();
    public function install_sql($sql_engine = 'InnoDB');
    public function remove_deny_ip($ip);
    public function remove_allow_ip($ip);
    public function add_deny_ip($ip);
    public function add_allow_ip($ip);
    public function delete_ip_rule($ip = '');
    public function ban_ip_rule($assign_ip);
    public function ip_in_range($ip, $ip_range);
    public function check_ip_status($ip);
    public function initialize($config = array());
    public function debug($is_display = false, $is_reset = true);
    public function is_social_robot_useragent();
    public function run();
    public function is_denied_robot();
    public function is_allowed_robot();
    public function is_robot();
    public function is_google();
    public function is_bing();
    public function is_yahoo();
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
