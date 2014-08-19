<?php
$base = dirname(dirname(__FILE__)); 
include($base ."/conf.php");
date_default_timezone_set('Europe/Kiev');

$dbConnection = new PDO(
    'mysql:host='.$CONF_DB['host'].';dbname='.$CONF_DB['db_name'],
    $CONF_DB['username'],
    $CONF_DB['password'],
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
);
$dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   
//(*/5 * * * * /usr/bin/php5 -f /var/www/hd_prod/sys/live.php > /var/www/hd_prod/sys/4cron.log 2>&1)


            $stmt = $dbConnection->prepare('Update users set live=:live WHERE UNIX_TIMESTAMP(last_login)<UNIX_TIMESTAMP(NOW())-60');
	    $stmt->execute(array(':live' => 0));

	

?>
