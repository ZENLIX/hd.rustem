<?php
########################################
#	HD.rustem - configuration file
#	Yaroslav Snisar (c) 2014
#	info@rustem.com.ua
########################################

//Access information to MySQL database
$CONF_DB = array (
	'host' 		=> 'localhost', 
	'username'	=> 'root',
	'password'	=> '',
	'db_name'	=> 'hd.rustem'
);

//System configuration variables and some options
$CONF = array (
	'title_header'	=> 'helpdesk',
	'hostname'		=> 'http://localhost/web/HD.rustem',
	'mail'			=> 'hd@hd.local',
	'days2arch'		=> 3,
	'name_of_firm'	=> 'IT корпорация',
	'fix_subj'		=> true,
	'first_login'	=> false,
	'file_uploads'	=> true,
	'ad_auth'	=> false,
	'debug_mode'	=> false
);

$CONF_MAIL = array (
	'active'	=> false,
	'host'		=> 'smtp.gmail.com',
	'port'		=> 587,
	'auth'		=> true,
	'auth_type' => 'tls', //ssl or tls
	'username'	=> 'your_login@gmail.com',
	'password'	=> 'your_pass',
	'from'		=> 'helpdesk',
	'debug'		=> false 
);

?>
