<?php
$base = dirname(dirname(__FILE__)); 
include($base ."/conf.php");
date_default_timezone_set('Europe/Kiev');
function humanTiming_old ($time)
{

    $time = time() - $time;

    return floor($time/86400);
}
$dbConnection = new PDO(
    'mysql:host='.$CONF_DB['host'].';dbname='.$CONF_DB['db_name'],
    $CONF_DB['username'],
    $CONF_DB['password'],
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
);
$dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function get_conf_param($in) {
 global $dbConnection;
 $stmt = $dbConnection->prepare('SELECT value FROM perf where param=:in');
 $stmt->execute(array(':in' => $in));
 $con = $stmt->fetch(PDO::FETCH_ASSOC);

return $con['value'];

}

$CONF = array (
'days2arch'   => get_conf_param('days2arch')
);





/*   
5 0 * * * /usr/bin/php5 -f /var/www/hd_prod/sys/4cron.php > /var/www/hd_prod/4cron.log 2>&1
*/

            $stmt = $dbConnection->prepare('SELECT id, ok_by, ok_date,date_create
							from tickets
							where arch=:n1 and ok_by !=:n2');
			$stmt->execute(array(':n1' => '0',':n2' => '0'));
			$res1 = $stmt->fetchAll();
foreach($res1 as $row) {




    $m=$row['id'];
    $td= humanTiming_old(strtotime($row['ok_date']))."<br>";

    if ($td > $CONF['days2arch'] ) {

                $stmt = $dbConnection->prepare('update tickets set arch=:n1, last_update=now() where id=:m');
		$stmt->execute(array(':n1' => '1',':m' => $m));
        
        
        
                
                
            $stmt = $dbConnection->prepare('INSERT INTO ticket_log (msg, date_op, ticket_id)
values (:arch, now(), :m)');
			$stmt->execute(array(':arch' => 'arch',':m' => $m));
    }

}

?>
