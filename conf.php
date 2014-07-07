<?php

$host 		= "localhost"; 		// Host name
$username 	= "root"; 			// Mysql username
$password 	= ""; 				// Mysql password
$db_name 	= "hd_prod"; 			// Mysql password

$title_header			="helpdesk";					//System Name
$admin_password			='1234';							//admin def:1234
$lang					='ru';								//system language
$CONF['hostname']		='http://localhost/web/HD.rustem/';	//path
$CONF['mail']			='hd@hd.local';						//email
$CONF['days2arch']		=3;									//days to arch
$CONF['name_of_firm']	="IT корпорация";					//Name of Organization
$CONF['fix_ticket_subj']=true;								//Ticket subj list or input? {true or false}
$CONF['file_uploads']	=true;								// New ticket - file upload?
$acceptable = array(
        'application/pdf',
        'image/jpeg',
        'image/jpg',
        'image/gif',
        'image/png'
    );
?>