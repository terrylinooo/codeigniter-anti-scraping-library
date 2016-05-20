<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
<meta charset="utf-8">
<meta name="robots" CONTENT="noindex, nofollow">
<title><?= $title ?></title>

<style type="text/css">

::selection { background-color: #E13300; color: white; }
::-moz-selection { background-color: #E13300; color: white; }

body {
	background-color: #fff;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
	border: 1px solid #D0D0D0;

}

fieldset {
    border: 1px solid #D0D0D0;
    margin: 10px;
}
p {
	margin: 12px 15px 12px 15px;
}
</style>
<script src="https://www.google.com/recaptcha/api.js?hl=<?= $lang ?>"></script>
</head>
<body>
	<div id="container">
		<h1><?= $heading ?></h1>

        <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
            <fieldset>
                <legend><?= $message ?></legend>

				<div class="g-recaptcha" data-sitekey="<?= $captcha_site_key ?>"></div>

                <p><input type="submit" value="Submit" /></p>
            </fieldset>
        </form>
	</div>
</body>
</html>
