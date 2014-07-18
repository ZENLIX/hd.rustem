<?php
$base = dirname(dirname(__FILE__)); 
include($base ."/functions.inc.php");
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
    $td= humanTiming_old(strtotime($row['date_create']))."<br>";

    if ($td > $CONF['days2arch'] ) {

                $stmt = $dbConnection->prepare('update tickets set arch=:n1, last_update=now() where id=:m');
		$stmt->execute(array(':n1' => '1',':m' => $m));
        
        
        
                
                
            $stmt = $dbConnection->prepare('INSERT INTO ticket_log (msg, date_op, ticket_id)
values (:arch, now(), :m)');
			$stmt->execute(array(':arch' => 'arch',':m' => $m));
    }

}

?>
