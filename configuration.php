<?php
class JConfig {
	var $offline = '0';
	var $editor = 'jce';
	var $list_limit = '50';
	var $helpurl = '';
	var $debug = '0';
	var $debug_lang = '0';
	var $sef = '1';
	var $sef_rewrite = '1';
	var $sef_suffix = '0';
	var $feed_limit = '10';
	var $feed_email = 'author';
	var $secret = 'F4uF0NZPIPGaHMsa';
	var $gzip = '1';
	var $error_reporting = '0';
	var $xmlrpc_server = '0';
	var $log_path = '/logs';
	var $tmp_path = '/tmp';
	var $live_site = '';
	var $force_ssl = '2';
	var $offset = '7';
	var $caching = '0';
	var $cachetime = '15';
	var $cache_handler = 'file';
	var $memcache_settings = array();
	var $ftp_enable = '0';
	var $ftp_host = '';
	var $ftp_port = '0';
	var $ftp_user = '';
	var $ftp_pass = '';
	var $ftp_root = '';
	var $dbtype = 'mysql';
	var $host = 'localhost';
	var $user = 'root';
	var $db = 'mercubuana';
	var $dbprefix = 'jos_';
	var $mailer = 'smtp';
	var $mailfrom = 'default@default.id';
	var $fromname = 'Default';
	var $sendmail = '/usr/sbin/sendmail';
	var $smtpauth = '1';
	var $smtpsecure = '';
	var $smtpport = '';
	var $smtpuser = '';
	var $smtppass = '';
	var $smtphost = '';
	var $MetaAuthor = '1';
	var $MetaTitle = '1';
	var $lifetime = '90';
	var $session_handler = 'database';
	var $password = '';
	var $sitename = 'Default';
	var $MetaDesc = '';
	var $MetaKeys = '';
	var $offline_message = 'This site is down for maintenance. Please check back again soon.';
}
?>