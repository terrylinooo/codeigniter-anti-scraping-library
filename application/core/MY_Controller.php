<?php

	public function __construct()
    {
        parent::__construct();

        define('ROOT_DOMAIN', 'yourname.org');
        ini_set("session.cookie_domain", '.' . ROOT_DOMAIN);
        
        // Sign up for API key here 
        // https://www.google.com/recaptcha/admin#list
        define('CAPTCHA_SECRET_KEY', '6LfH_R5TAABAAPQJM27zAn6ChPLle2Sna24o-hZf');
        define('CAPTCHA_SITE_KEY', '6LfH_R8TAAAABJTo21zGBRaZnpJDqKDJ4c5kgsZF');


        $this->load->helper('cookie');
        $this->load->library('anti_scraping');
        
        // PSR-4 autoloader, it will automaticlly load ReCaptcha when it needs.
        require_once APPPATH .'third_party/autoload.php';

        $this->AntiScraping();
    }

    public function AntiScraping()
    {
        // Install SQL table for AntiScraping, after installed, please remove this line.
        // storage engine: memory, innodb, myisam
        $this->anti_scraping->install('memory'); 

        /* for test
        
        $this->anti_scraping->user_ip_address = '66.249.92.125';
        $this->anti_scraping->user_ip_resolve = 'rate-limited-proxy-66-249-92-125.google.com';
        $this->anti_scraping->user_agent = 'Mediapartners-Google';
        echo $this->anti_scraping->debug();
        
        */

        $anti_scraping_result = $this->anti_scraping->filtering();

        if ( $anti_scraping_result == 'deny' )
        {
            if ($this->input->post('g-recaptcha-response'))
            {
                $remoteIp           = $this->input->ip_address();
                $gRecaptchaResponse = $this->input->post('g-recaptcha-response');

                $recaptcha = new \ReCaptcha\ReCaptcha(CAPTCHA_SECRET_KEY);
                $resp = $recaptcha->verify($gRecaptchaResponse, $remoteIp);

                if ($resp->isSuccess())
                {
                    $this->anti_scraping->remove_deny();
                }
                else
                {
                    $this->ReCaptcha();
                }
            }
            else
            {
                $this->ReCaptcha();
            }
        }
    }

    public function ReCaptcha()
    {
        $data = array();

        $data['title'] = 'Please solve Captcha';
        $data['heading'] = 'Something went wrong';
        $data['message'] = 'Please complete the CAPTCHA to confirm you are a human.';
        $data['lang']    = 'en';

        $data['captcha_site_key'] = CAPTCHA_SITE_KEY;

        ob_start();

        $output = $this->load->view('captcha', $data, true);
        echo $output;
        $buffer = ob_get_contents();
        ob_end_clean();
        
        echo $buffer;
        exit;
    }
