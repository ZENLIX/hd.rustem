<?php
include("functions.inc.php");
/*   
5 0 * * * /usr/bin/php5 -f /var/www/hd_prod/4cron.php > /var/www/hd_prod/4cron.log 2>&1
*/
$results = mysql_query("SELECT id, ok_by, ok_date,date_create
							from tickets
							where arch='0' and ok_by !='0'");
while ($row = mysql_fetch_assoc($results)) {

    $m=$row['id'];
    $td= humanTiming_old(strtotime($row['date_create']))."<br>";

    if ($td > $CONF['days2arch'] ) {

        $query_update_ticket= "update tickets set arch='1', last_update=now() where id='$m'";
        mysql_query ( $query_update_ticket )or die(mysql_error());
                $query_atl = "INSERT INTO ticket_log (msg, date_op, ticket_id)
values ('arch', now(), '$m'); ";
                mysql_query ( $query_atl )or die(mysql_error());
    }

}

?>