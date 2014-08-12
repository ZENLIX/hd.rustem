<?php

// activate full error reporting
//error_reporting(E_ALL & E_STRICT);

include 'XMPPHP/XMPP.php';

#Use XMPPHP_Log::LEVEL_VERBOSE to get more logging for error reports
#If this doesn't work, are you running 64-bit PHP with < 5.2.6?
$conn = new XMPPHP_XMPP('jabber.SERVER.com.ua', 5222, 'your_login@jabber.SERVER.com.ua', 'your_password', 'xmpphp', 'jabber.SERVER.com.ua', $printlog=false, $loglevel=XMPPHP_Log::LEVEL_INFO);

try {
	//$conn->useEncryption(true);
    $conn->connect();
    
    $conn->processUntil('session_start');
    $conn->presence();
    $conn->message('to_user@jabber.SERVER.com.ua', 'This is a test message!');
    $conn->disconnect();
} catch(XMPPHP_Exception $e) {
    die($e->getMessage());
}
