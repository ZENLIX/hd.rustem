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
	'db_name'	=> 'hd_prod'
);

//System configuration variables and some options
$CONF = array (
	'title_header'	=> 'helpdesk',
	'hostname'		=> 'http://localhost/web/HD.rustem',
	'mail'			=> 'hd@hd.local',
	'days2arch'		=> 3,
	'name_of_firm'	=> 'IT корпорация',
	'fix_subj'		=> true,
	'file_uploads'	=> true,
	'debug_mode'	=> false
);

$CONF_MAIL = array (
	'active'	=> true,
	'host'		=> 'smtp.gmail.com',
	'port'		=> 587,
	'auth'		=> true,
	'auth_type' => 'tls', //ssl or tls
	'username'	=> 'your_login@gmail.com',
	'password'	=> 'your_pass',
	'from'		=> 'helpdesk',
	'debug'		=> false 
);

//List of good file types to upload
$acceptable = array(
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/msword',
        'application/excel',
        'application/vnd.ms-excel',
        'application/x-excel',
        'application/x-msexcel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'image/jpeg',
        'image/jpg',
        'image/gif',
        'image/png'

    );

?>
