<?php
use Craft\HttpException;
// Make sure this is PHP 5.3 or later
// -----------------------------------------------------------------------------

if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID < 50300)
{
	exit('Craft requires PHP 5.3.0 or later, but you&rsquo;re running '.PHP_VERSION.'. Please talk to your host/IT department about upgrading PHP or your server.');
}

// Check for this early because Craft uses it before the requirements checker gets a chance to run.
if (!extension_loaded('mbstring') || (extension_loaded('mbstring') && ini_get('mbstring.func_overload') == 1))
{
	exit('Craft requires the <a href="http://php.net/manual/en/book.mbstring.php" target="_blank">PHP multibyte string</a> extension in order to run. Please talk to your host/IT department about enabling it on your server.');
}

// omitScriptNameInUrls and usePathInfo tests
// -----------------------------------------------------------------------------

if ((isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] == '/testScriptNameRedirect')
	|| (isset($_SERVER['QUERY_STRING']) && strpos($_SERVER['QUERY_STRING'], 'testScriptNameRedirect') !== false))
{
	exit('success');
}

if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] == '/testPathInfo')
{
	exit('success');
}

// PHP environment normalization
// -----------------------------------------------------------------------------

// These have been deprecated in PHP 6 in favor of default_charset, which defaults to 'UTF-8'
// http://php.net/manual/en/migration56.deprecated.php
if (PHP_VERSION_ID < 60000)
{
	// Set MB to use UTF-8
	mb_internal_encoding('UTF-8');
	mb_http_input('UTF-8');
	mb_http_output('UTF-8');
}

mb_detect_order('auto');

// Normalize how PHP's string methods (strtoupper, etc) behave.
setlocale(
	LC_CTYPE,
	'C.UTF-8',     // libc >= 2.13
	'C.utf8',      // different spelling
	'en_US.UTF-8', // fallback to lowest common denominator
	'en_US.utf8'   // different spelling for fallback
);

// Set default timezone to UTC
date_default_timezone_set('UTC');

// Load and run Craft
// -----------------------------------------------------------------------------

$app = require 'bootstrap.php';

//$param = include CRAFT_CONFIG_PATH . 'db.php';
//$dsn = "mysql:dbname={$param['database']};host={$param['server']}";
//$user = $param['user'];
//$password = $param['password'];
//
//$pdo = new PDO($dsn, $user, $password);
//$stmt = $pdo->query("select ip from ip_addresses");
//$ips = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
//
//$my_ip = '';
//if (getenv('HTTP_CLIENT_IP')) {
//	$my_ip = getenv('HTTP_CLIENT_IP');
//} else if(getenv('HTTP_X_FORWARDED_FOR')) {
//	$my_ip = getenv('HTTP_X_FORWARDED_FOR');
//} else if(getenv('HTTP_X_FORWARDED')) {
//	$my_ip = getenv('HTTP_X_FORWARDED');
//} else if(getenv('HTTP_FORWARDED_FOR')) {
//	$my_ip = getenv('HTTP_FORWARDED_FOR');
//} else if(getenv('HTTP_FORWARDED')) {
//	$my_ip = getenv('HTTP_FORWARDED');
//} else if(getenv('REMOTE_ADDR')) {
//	$my_ip = getenv('REMOTE_ADDR');
//} else {
//	$my_ip = 'UNKNOWN';
//}
//
//if ($_SERVER['HTTP_HOST'] == 'education-career.jp' && !in_array($my_ip, $ips)) {
//	throw new HttpException(404);
//}

$app->run();
