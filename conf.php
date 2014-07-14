<?php




$CONF_DB['host'] 		= "127.0.0.1"; 		// Host name
$CONF_DB['username'] 	= "root"; 			// Mysql username
$CONF_DB['password'] 	= ""; 				// Mysql password
$CONF_DB['db_name'] 	= "hd_prod"; 			// Mysql password


$title_header			="helpdesk";					//System Name
$CONF['hostname']		='http://localhost/web/HD.rustem/';	//path
$CONF['mail']			='hd@hd.local';						//email
$CONF['days2arch']		=3;									//days to arch
$CONF['name_of_firm']	="IT корпорация";					//Name of Organization
$CONF['fix_ticket_subj']=true;								//Ticket subj list or input? {true or false}
$CONF['file_uploads']	=true;								// New ticket - file upload?
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

/*
http://malsup.github.io/jquery.form.js

$CONF_DB = array (
'host' 		=> 'localhost',
'username'	=> 'root'
);


*/

?>
