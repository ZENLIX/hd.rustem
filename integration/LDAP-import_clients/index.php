<!DOCTYPE html>
<html>
  <head>
    <title>LDAP TEST</title>
        <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>

<div class="container">
<p>
<?php


	$host 		= "localhost"; 		// Host name
	$username 	= "root"; 			// Mysql username
	$password 	= ""; 				// Mysql password
	$db_name 	= "hd_prod"; 		// Mysql password

	$connection = mysql_connect($host, $username, $password) or die ("Error SQL connection");
	mysql_select_db($db_name, $connection);
	mysql_query('SET NAMES utf8');


function getsid($in) {
	
$sid = "S-";
$sidinhex = str_split($in, 2);
$sid = $sid.hexdec($sidinhex[0])."-";
$sid = $sid.hexdec($sidinhex[6].$sidinhex[5].$sidinhex[4].$sidinhex[3].$sidinhex[2].$sidinhex[1]);
$subauths = hexdec($sidinhex[7]);
for($i = 0; $i < $subauths; $i++) {
$start = 8 + (4 * $i);
//$sid = $sid."-".hexdec($sidinhex[$start+3].$sidinhex[$start+2].$sidinhex[$start+1].$sidinhex[$start]);
$sid = hexdec($sidinhex[$start+3].$sidinhex[$start+2].$sidinhex[$start+1].$sidinhex[$start]);


}
return $sid;
}



$total=0;
error_reporting(0);
$ds=ldap_connect("10.0.0.1"); // IP AD-server
if ($ds) {
	$r=ldap_bind($ds,'login_user@domain.local','password'); //auth info
	$sr=ldap_search($ds,
		"ou=Users, ou=ORganization, dc=domain, dc=local",
		'(&(objectcategory=organizationalUnit)(!(UserAccountControl:1.2.840.113556.1.4.804:=2)))');
//ou= ветка в которой искать, у нас это была Organization/Users
	ldap_sort($ds, $sr, 'ou');
	$info = ldap_get_entries($ds, $sr);


	for ($i=0; $i<$info["count"]; $i++) {

		$n=$info[$i]['name'][0];
		$podrazd=iconv('windows-1251', 'UTF-8', $n);
		
	//$query_add_client= "insert into units (name) VALUES ('$podrazd')";
	//mysql_query ( $query_add_client );	
		
		
		
		if ($ds) {
			$n=str_replace(',', '\,', $n);
			$sr2=ldap_search($ds,
				"ou=".$n.", ou=Users, ou=ORganization, dc=domain, dc=local",
				'(&(objectcategory=Person)(!(UserAccountControl:1.2.840.113556.1.4.804:=2)))');
			//echo "Всего в подразделении " . ldap_count_entries($ds, $sr2) . "";
			ldap_sort($ds, $sr2, 'cn');
			$info2 = ldap_get_entries($ds, $sr2);
			if ($info2["count"] > 0) {
			echo "<h2>".$podrazd."</h2>";
			echo "<p class='text-muted'><small>Всего в подразделении " . ldap_count_entries($ds, $sr2) . "</small></p>";
			$total=$total+ldap_count_entries($ds2, $sr2);
			?><table class='table table-hover table-condensed table-bordered'>
			<thead>
			<tr class="warning">
			<td><b><center>ФИО</center></b></td>
			<td><b><center>Фамилия</center></b></td>
			<td><b><center>Имя</center></b></td>
			<td><b><center>Отчество</center></b></td>
			<td><b><center>Логин</center></b></td>
			<td><b><center>ID</center></b></td>
			<td><b><center>e-mail</center></b></td>

			</tr>
			</thead>
			<?php
			for ($m=0; $m<$info2["count"]; $m++) {
				$name=$info2[$m]['name'][0];
				$fio=iconv('windows-1251', 'UTF-8', $name);
				//$s=$info2[$m]['objectsid'][0];
				
				
				
				$sid=getsid(bin2hex($info2[$m]['objectsid'][0]));

		
				$pieces = explode(" ", $fio);
				$f1=$pieces[0];
				$f2=$pieces[1];
				$f3=$pieces[2];
				$mail=$info2[$m]['mail'][0];
				$usr_login=$info2[$m]['samaccountname'][0];
	//$query_add_client= "insert into us_tmp (sid, login) VALUES ('$sid', '$usr_login')";
	//mysql_query ( $query_add_client );	
				/*
$query_add_client= "insert into clients
								(login, full_name, email, unit_desc)
								VALUES
								('$usr_login', '$fio', '$mail', '$podrazd')";
mysql_query ( $query_add_client );
				*/
				
				?>
				<tbody>
				<tr>
				<td><?=$fio?></td>
				<td><?=$pieces[0]?></td>
				<td><?=$pieces[1]?></td>
				<td><?=$pieces[2]?></td>
				<td><?=$info2[$m]['samaccountname'][0]?></td>
				<td><small><?=$sid?></small></td>
				<td><?=$info2[$m]['mail'][0]?></td>
				</tr>
				</tbody>
				<?php
				}
			?>
			</table>
			<hr><?php
			}
		}

	}

	ldap_close($ds);

} else {
	echo "Unable to connect to LDAP server";
}



//
//
//
//
//
?>
</p>
Всего записей : <?=$total?></div>
  </p>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
