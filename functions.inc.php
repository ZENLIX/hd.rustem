<?php

///////////////////////////////////////////////////////////////////////////
include_once('conf.php');

///////////////////////////////////////////////////////////////////////////
date_default_timezone_set('Europe/Kiev');
$connection = mysql_connect($host, $username, $password) or die ("Error: Kunne ikke koble til databasen");
mysql_select_db($db_name, $connection);


$dbConnection = new PDO('mysql:dbname='.$db_name.';host='.$host.';charset=utf8', $username, $password);
$dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



mysql_query('SET NAMES utf8');

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);
include_once('inc/mail.inc.php');




switch ($lang) {
  case 'ua':
  $lang_file = 'lang.ua.php';
  break;

  case 'ru':
  $lang_file = 'lang.ru.php';
  break;
  
  case 'en':
  $lang_file = 'lang.en.php';
  break;

//  default:
//  $lang_file = 'lang.en.php';

}

include_once 'lang/'.$lang_file;



function generateRandomString($length = 5) {
    $characters = '0123456789';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}

function validate_exist_mail($str) {
	$re = mysql_num_rows(mysql_query("SELECT email from users where email='$str';"));
	if ($re > 0) {$r=false;}
	else if ($re <= 0) {$r=true;}

	return $r;
}

function validate_email($str)
{
    return preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',$str);
}

function validate_alphanumeric_underscore($str)
{
    return preg_match('/^[a-zA-Z0-9_\.-]+$/',$str);
}

function update_val_by_key($key, $val) {

//$sql="update conf set value='$val' where param='$key'";
//mysql_query($sql);

}

function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyz0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 5; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}




function nameshort($name) {
    $nameshort = preg_replace('/(\w+) (\w)\w+ (\w)\w+/iu', '$1 $2. $3.', $name);
    return $nameshort;
}


function xss_clean($data)
{
        // Fix &entity\n;
        $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
 
        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
 
        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
 
        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
 
        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
 
        do
        {
                // Remove really unwanted tags
                $old_data = $data;
                $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        }
        while ($old_data !== $data);
 
        // we are done...
        return $data;
} 








function get_val_by_key($key) {
///	$re = mysql_query("SELECT value from conf where param='$key';");
//	$client_arr = mysql_fetch_array($re);
//	$res=$client_arr['value'];
//	return $res;
}

function validate_admin($user_id) {
global $dbConnection;

$stmt = $dbConnection->prepare('SELECT is_admin from users where id=:user_id LIMIT 1');
$stmt->execute(array(':user_id' => $user_id));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$admin=$row['is_admin'];

    if ($admin == "8") {return true;}
    else {return false;}

}


function view_comment($tid) {
	global $dbConnection;
	?>
	<table class="table ">
                                        <tbody>
                                        <?php 
        $stmt = $dbConnection->prepare('SELECT user_id, comment_text, dt from comments where t_id=:tid');
        $stmt->execute(array(':tid' => $tid));
                                        while ($rews = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <tr>
                                                <td style="width:200px;"><center><strong><?=nameshort(name_of_user_ret($rews['user_id']));?></strong><br><small class="text-muted"><?=dt_format($rews['dt'])?></small></center></td>
                                                <td><?=xss_clean($rews['comment_text'])?></td>

                                            </tr>
                                        <?php } ?>


                                        </tbody>
                                    </table>

	<?php
	
}


function validate_user($user_id, $input) {

global $dbConnection;

    if (!isset($_SESSION['code'])) {

        if (isset($_COOKIE['authhash_code'])) {

            $user_id=$_COOKIE['authhash_uid'];
            $input=$_COOKIE['authhash_code'];
            $_SESSION['code']=$input;
            $_SESSION['helpdesk_user_id']=$user_id;
            /*
            $_SESSION['helpdesk_sort_prio'] = "none";
            $_SESSION['helpdesk_sort_id'] = "none";
            $_SESSION['helpdesk_sort_subj'] = "none";
                    $_SESSION['helpdesk_sort_clientid'] = "none";
                $_SESSION['helpdesk_sort_userinitid'] = "none";
                */
        }


    }

//$user_id
//$input



    
    
$stmt = $dbConnection->prepare('SELECT pass,login,fio from users where id=:user_id LIMIT 1');
    $stmt->execute(array(':user_id' => $user_id));
    
    
    if ($stmt -> rowCount() == 1) {
    	$row = $stmt->fetch(PDO::FETCH_ASSOC);

    
    
    
    
    
    
        //$row = mysql_fetch_assoc($sql);
        $dbpass=md5($row['pass']);
        $_SESSION['helpdesk_user_login'] = $row['login'];
        $_SESSION['helpdesk_user_fio'] = $row['fio'];
        //$_SESSION['helpdesk_sort_prio'] == "none";
        if ($dbpass == $input) { return true;}
        else { return false;}
    }
}

function get_ticket_id_by_hash($in) {
/*
	$q_total="select id from tickets where hash_name='$in'";
    $res_total = mysql_query($q_total) or die(mysql_error());
    $total_ticket= mysql_fetch_assoc( $res_total );
*/
    global $dbConnection;

$stmt = $dbConnection->prepare('select id from tickets where hash_name=:in');
$stmt->execute(array(':in' => $in));
$total_ticket = $stmt->fetch(PDO::FETCH_ASSOC);
    
    
    $tt=$total_ticket['id'];
    return $tt;
}





function get_client_info_ticket($id) {
global $dbConnection;
$stmt = $dbConnection->prepare('SELECT fio,tel,unit_desc,adr,tel_ext,email,login,posada FROM clients where id=:id');
$stmt->execute(array(':id' => $id));
$fio = $stmt->fetch(PDO::FETCH_ASSOC);
    
    
    
    $fio_user=$fio['fio'];
    $loginf=$fio['login'];
    $tel_user=$fio['tel'];
    $pod=$fio['unit_desc'];
    $adr=$fio['adr'];
    $tel_ext=$fio['tel_ext'];

    $posada=$fio['posada'];
    $email=$fio['email'];

    /*$q_total="select count(id) as t1 from tickets where client_id='$id'";
    $res_total = mysql_query($q_total) or die(mysql_error());
    $total_ticket= mysql_fetch_assoc( $res_total );*/
    
    $stmt = $dbConnection->prepare('select count(id) as t1 from tickets where client_id=:id');
	$stmt->execute(array(':id' => $id));
	$total_ticket = $stmt->fetch(PDO::FETCH_ASSOC);
    
    
    $tt=$total_ticket['t1'];
    
    /*$q_last="select max(date_create) as dc from tickets where client_id='$id'";
    $res_last=mysql_query($q_last) or die(mysql_error());
    $last_ticket=mysql_fetch_assoc( $res_last );*/
    
    $stmt = $dbConnection->prepare('select max(date_create) as dc from tickets where client_id=:id');
	$stmt->execute(array(':id' => $id));
	$last_ticket = $stmt->fetch(PDO::FETCH_ASSOC);
    
    
    $lt=$last_ticket['dc'];

    $uid=$_SESSION['helpdesk_user_id'];
    $priv_val=priv_status($uid);
    ?>



    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-user"></i> <?=lang('WORKER_TITLE');?></h4>
    </div>
    <div class="panel-body">
        <h4><center><strong><?php echo $fio_user; ?></strong></center></h4>

        <table class="table  ">
            <tbody>
            <?php if ($loginf) { ?>
                <tr>
                    <td style=" width: 30px; "><small><?=lang('WORKER_login');?>:</small></td>
                    <td><small><?=$loginf?></small></td>
                </tr>
            <?php } if ($posada) { ?>
                <tr>
                    <td style=" width: 30px; "><small><?=lang('WORKER_posada');?>:</small></td>
                    <td><small><?php echo $posada; ?></small></td>
                </tr>
            <?php } if ($pod) { ?>
                <tr>
                    <td style=" width: 30px; "><small><?=lang('WORKER_unit');?>:</small></td>
                    <td><small><?php echo $pod; ?></small></td>
                </tr>
            <?php } if ($tel_user) { ?>
                <tr>
                    <td style=" width: 30px; "><small><?=lang('WORKER_tel');?>:</small></td>
                    <td><small><?php echo $tel_user." ".$tel_ext; ?></small></td>
                </tr>
            <?php } if ($adr) { ?>
                <tr>
                    <td style=" width: 30px; "><small><?=lang('WORKER_room');?>:</small></td>
                    <td><small><?php echo $adr; ?></small></td>
                </tr>
            <?php } if ($email) { ?>
                <tr>
                    <td style=" width: 30px; "><small><?=lang('WORKER_mail');?>:</small></td>
                    <td><small><?php echo $email; ?></small></td>
                </tr>
            <?php } ?>
            <tr>
                <td style=" width: 30px; "><small class="text-muted"><?=lang('WORKER_total');?>:</small></td>
                <td><small>
                        <?php if ($priv_val <> "1") { ?>
                        <a target="_blank" href="userinfo.php?user=<?=$id?>">
                            <?php }?>
                            <?php echo $tt; ?>
                            <?php if ($priv_val <> "1") { ?>
                        </a>
                    <?php }?>
                    </small></td>
            </tr>

            <tr>
                <td style=" width: 30px; "><small class="text-muted"><?=lang('WORKER_last');?>:</small></td>
                <td><small><?php if ($priv_val <> "1") { ?><a target="_blank" href="userinfo.php?user=<?=$id?>"><?php } ?><?php echo $lt; ?><?php if ($priv_val <> "1") { ?></a><?php } ?></small></td>
            </tr>
            </tbody>
        </table>

    </div>

<?php
}

function get_unit_name_return4news($input) {
global $dbConnection;



    //include("../dbconnect.inc.php");
    //if ($input == "0") { echo "личный доступ"; }
    $u=explode(",", $input);
    foreach ($u as $val) {

    /*$query="SELECT name FROM deps where id='$val'";
    $rest = mysql_query($query) or die(mysql_error());
    $dep= mysql_fetch_assoc( $rest );*/
    
    $stmt = $dbConnection->prepare('SELECT name FROM deps where id=:val');
	$stmt->execute(array(':val' => $val));
	$dep = $stmt->fetch(PDO::FETCH_ASSOC);

    
    $res=$dep['name'];
    
    }
    //else { echo "не определено";}
    return $res;
}


function get_unit_name_return($input) {
global $dbConnection;



    //include("../dbconnect.inc.php");
    //if ($input == "0") { echo "личный доступ"; }
    $u=explode(",", $input);
    foreach ($u as $val) {

    /*$query="SELECT name FROM deps where id='$val'";
    $rest = mysql_query($query) or die(mysql_error());
    $dep= mysql_fetch_assoc( $rest );*/
    
    $stmt = $dbConnection->prepare('SELECT name FROM deps where id=:val');
	$stmt->execute(array(':val' => $val));
	$dep = $stmt->fetch(PDO::FETCH_ASSOC);

    
    $res.=$dep['name'];
    $res.="<br>";
    }
    //else { echo "не определено";}
    return $res;
}




function get_w_by_id($id) {





    ?>
    <div class="col-md-3">
        ddd
    </div>
    <div class="col-md-8">

        ddd

    </div>
<?php

}




function get_client_info($id) {
	global $CONF;
	global $dbConnection;
	
    //include("../dbconnect.inc.php");
    /*$query="SELECT fio,tel,unit_desc,adr,tel_ext,email,login, posada, email FROM clients where id='$id'";
    $res = mysql_query($query) or die(mysql_error());
    $fio= mysql_fetch_assoc( $res );*/
    
    $stmt = $dbConnection->prepare('SELECT fio,tel,unit_desc,adr,tel_ext,email,login, posada, email FROM clients where id=:id');
	$stmt->execute(array(':id' => $id));
	$fio = $stmt->fetch(PDO::FETCH_ASSOC);
    
    
    
    $fio_user=$fio['fio'];
    $loginf=$fio['login'];
    $tel_user=$fio['tel'];
    $pod=$fio['unit_desc'];
    $adr=$fio['adr'];
    $tel_ext=$fio['tel_ext'];
    $mails=$fio['email'];
    $posada=$fio['posada'];


    /*$q_total="select count(id) as t1 from tickets where client_id='$id'";
    $res_total = mysql_query($q_total) or die(mysql_error());
    $total_ticket= mysql_fetch_assoc( $res_total );*/
    
    $stmt = $dbConnection->prepare('select count(id) as t1 from tickets where client_id=:id');
	$stmt->execute(array(':id' => $id));
	$total_ticket = $stmt->fetch(PDO::FETCH_ASSOC);
	$tt=$total_ticket['t1'];
	
	
    /*$q_last="select max(date_create) as dc from tickets where client_id='$id'";
    $res_last=mysql_query($q_last) or die(mysql_error());
    $last_ticket=mysql_fetch_assoc( $res_last );*/
    
    $stmt = $dbConnection->prepare('select max(date_create) as dc from tickets where client_id=:id');
	$stmt->execute(array(':id' => $id));
	$last_ticket = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $lt=$last_ticket['dc'];
    $uid=$_SESSION['helpdesk_user_id'];
    $priv_val=priv_status($uid);
    ?>



    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-user"></i> <?=lang('WORKER_TITLE');?></h4>
    </div>
    <div class="panel-body">
        <h4><center><strong><?php echo $fio_user; ?></strong></center></h4>

        <table class="table  ">
            <tbody>

            <tr>
                <td style=" width: 30px; "><small><?=lang('WORKER_login');?>:</small></td>
                <td><small><a href="#" id="edit_login" data-type="text"><?=$loginf?></a></small></td>
            </tr>
            <tr>
                <td style=" width: 30px; "><small><?=lang('WORKER_posada');?>:</small></td>
                <td><small><a href="#" id="edit_posada" data-type="select" data-source="<?=$CONF['hostname'];?>/json.php?posada" data-pk="1" data-title="<?=lang('WORKER_posada');?>"><?=$posada?></a></small></td>
            </tr>
            <tr>
                <td style=" width: 30px; "><small><?=lang('WORKER_unit');?>:</small></td>
                <td><small><a href="#" id="edit_unit" data-type="select" data-source="<?=$CONF['hostname'];?>/json.php?units" data-pk="1" data-title="<?=lang('NEW_unit');?>"><?php echo $pod; ?></a></small></td>
            </tr>

            <tr>
                <td style=" width: 30px; "><small><?=lang('WORKER_tel');?>:</small></td>
                <td><small><a href="#" id="edit_tel" data-type="text"><?php echo $tel_user." ".$tel_ext; ?></a></small></td>
            </tr>
            <tr>
                <td style=" width: 30px; "><small><?=lang('WORKER_room');?>:</small></td>
                <td><small><a href="#" id="edit_adr" data-type="text"><?php echo $adr; ?></a></small></td>
            </tr>
            <tr>
                <td style=" width: 30px; "><small><?=lang('WORKER_mail');?>:</small></td>
                <td><small><a href="#" id="edit_mail" data-type="text"><?=$mails?></a></small></td>
            </tr>
            <tr>
                <td style=" width: 30px; "><small class="text-muted"><?=lang('WORKER_total');?>:</small></td>
                <td><small class="text-muted">
                        <?php if ($priv_val <> "1") { ?>
                        <a target="_blank" href="userinfo.php?user=<?=$id?>"><?php }?><?php echo $tt; ?><?php if ($priv_val <> "1") { ?></a><?php } ?></small></td>
            </tr>

            <tr>
                <td style=" width: 30px; "><small class="text-muted"><?=lang('WORKER_last');?>:</small></td>
                <td><small class="text-muted">
                        <?php if ($priv_val <> "1") { ?>
                        <a target="_blank" href="userinfo.php?user=<?=$id?>">
                            <?php }?><?php echo $lt; ?><?php if ($priv_val <> "1") { ?></a><?php } ?></small></td>
            </tr>
            </tbody>
        </table>

    </div>

<?php
}
function client_unit($input) {
    //include("../dbconnect.inc.php");
    global $dbConnection;
    
    /*$query="SELECT unit_desc FROM clients where id='$input'";
    $res = mysql_query($query) or die(mysql_error());
    $fio= mysql_fetch_assoc( $res );
    */
    
    $stmt = $dbConnection->prepare('SELECT unit_desc FROM clients where id=:input');
	$stmt->execute(array(':input' => $input));
	$fio = $stmt->fetch(PDO::FETCH_ASSOC);
	
	
    echo($fio['unit_desc']);

}
function id_of_user($input) {
    //include("../dbconnect.inc.php");
    global $dbConnection;
    $stmt = $dbConnection->prepare('SELECT id FROM users where login=:input');
	$stmt->execute(array(':input' => $input));
	$id = $stmt->fetch(PDO::FETCH_ASSOC);
	
    return ($id['id']);
}






function priv_status($input) {
    //include("../dbconnect.inc.php");
    global $dbConnection;

    
    $stmt = $dbConnection->prepare('SELECT priv FROM users where id=:input');
	$stmt->execute(array(':input' => $input));
	$id = $stmt->fetch(PDO::FETCH_ASSOC);
    
    
    return ($id['priv']);
}


function get_last_ticket_new($id)
{
global $dbConnection;
    $unit_user=unit_of_user($id);
    $priv_val=priv_status($id);
    $units = explode(",", $unit_user);
    $units = "'". implode("', '", $units) ."'";


    if ($priv_val == "0") {
            /*
    $stmt = $dbConnection->prepare('SELECT max(last_update) from tickets where unit_id IN (:units) or user_init_id=:id');
	$stmt->execute(array(':units' => $units, ':id' => $id));
	$max = $stmt->fetch(PDO::FETCH_NUM);
        */
                $queryid = "SELECT max(last_update) from tickets where unit_id IN (".$units.") or user_init_id='$id';";
        $res1 = mysql_query($queryid) or die(mysql_error());
        $max= mysql_fetch_array( $res1 );

        
        $max_id=$max[0];
        //echo $max_id;
    }


    else if ($priv_val == "1") {
            /*$queryid = "SELECT max(last_update) from tickets where ((user_to_id='$id') or (user_to_id='0' and unit_id IN (".$units."))) or user_init_id='$id'";
            $res1 = mysql_query($queryid) or die(mysql_error());
            $max= mysql_fetch_array( $res1 );
 */
    /*$stmt = $dbConnection->prepare("SELECT max(last_update) from tickets where ((user_to_id=:id) or (user_to_id=:tid and unit_id IN (:units))) or user_init_id=:id2");
	$stmt->execute(array(':units' => $units, ':id' => $id, ':tid' => '0', ':id2' => $id));
	$max = $stmt->fetch(PDO::FETCH_NUM);
       */
               $queryid = "SELECT max(last_update) from tickets where ((user_to_id='$id') or (user_to_id='0' and unit_id IN (".$units.")) or (user_init_id='$id'))";
        $res1 = mysql_query($queryid) or die(mysql_error());
        $max= mysql_fetch_array( $res1 );

        
        
        $max_id=$max[0];


        //$count="1";
    }

    else if ($priv_val == "2") {


                
        
    /*$stmt = $dbConnection->prepare("SELECT max(last_update) from tickets;");
	$stmt->execute();
	$max = $stmt->fetch(PDO::FETCH_NUM);
        */
                $queryid = "SELECT max(last_update) from tickets;";
        $res1 = mysql_query($queryid) or die(mysql_error());
        $max= mysql_fetch_array( $res1 );

        
        $max_id=$max[0];


        //$count="1";
    }
    return $max_id;
}

function get_who_last_action_ticket($ticket_id) {
    global $dbConnection;
    $query="select init_user_id from ticket_log where ticket_id='$ticket_id' order by date_op DESC limit 1;";
    $res = mysql_query($query) or die(mysql_error());
    $fio= mysql_fetch_assoc( $res );

    /*$stmt = $dbConnection->prepare('select init_user_id from ticket_log where ticket_id=:ticket_id order by date_op DESC limit 1');
	$stmt->execute(array(':ticket_id' => $ticket_id));
	$fio = $stmt->fetch(PDO::FETCH_ASSOC);
	*/
    $r=$fio['init_user_id'];
    return $r;
}

function get_last_action_type($ticket_id) {
    global $dbConnection;
 
    /*$stmt = $dbConnection->prepare('select date_op, msg, init_user_id, to_user_id, to_unit_id from ticket_log where ticket_id=:ticket_id order by date_op DESC limit 1');
	$stmt->execute(array(':ticket_id' => $ticket_id));
	$fio = $stmt->fetch(PDO::FETCH_ASSOC);
    */
    $query="select date_op, msg, init_user_id, to_user_id, to_unit_id from ticket_log where ticket_id='$ticket_id' order by date_op DESC limit 1;";
    $res = mysql_query($query) or die(mysql_error());
    $fio= mysql_fetch_assoc( $res );


    $r=$fio['msg'];
    return $r;
}
function get_last_action_ticket($ticket_id) {
global $dbConnection;
 /*
    $stmt = $dbConnection->prepare('select date_op, msg, init_user_id, to_user_id, to_unit_id from ticket_log where ticket_id=:ticket_id order by date_op DESC limit 1');
	$stmt->execute(array(':ticket_id' => $ticket_id));
	$fio = $stmt->fetch(PDO::FETCH_ASSOC);
	*/
	    $query="select date_op, msg, init_user_id, to_user_id, to_unit_id from ticket_log where ticket_id='$ticket_id' order by date_op DESC limit 1;";
    $res = mysql_query($query) or die(mysql_error());
    $fio= mysql_fetch_assoc( $res );

    $r=$fio['msg'];
    $uss=nameshort(name_of_user_ret($fio['init_user_id']));
    $uss_to=nameshort(name_of_user_ret($fio['to_user_id']));
    $unit_to=get_unit_name_return4news($fio['to_unit_id']);
    if ($r=='refer') {$red='<i class=\'fa fa-long-arrow-right\'></i> '.lang('TICKET_ACTION_refer').' '.$uss.' '.lang('TICKET_ACTION_refer_to').' '.$unit_to.' '.$uss_to;}
    if ($r=='ok') {$red='<i class=\'fa fa-check-circle-o\'></i> '.lang('TICKET_ACTION_ok').' '.$uss;}
    if ($r=='no_ok') {$red='<i class=\'fa fa-circle-o\'></i> '.lang('TICKET_ACTION_nook').' '.$uss;}
    if ($r=='lock') {$red='<i class=\'fa fa-lock\'></i> '.lang('TICKET_ACTION_lock').' '.$uss;}
    if ($r=='unlock') {$red='<i class=\'fa fa-unlock\'></i> '.lang('TICKET_ACTION_unlock').' '.$uss;}
    if ($r=='create') {$red='<i class=\'fa fa-star-o\'></i> '.lang('TICKET_ACTION_create').' '.$uss;}
    if ($r=='edit_msg') {$red='<i class=\'fa fa-pencil-square\'></i> '.lang('TICKET_ACTION_edit').' '.$uss;}
    if ($r=='edit_subj') {$red='<i class=\'fa fa-pencil-square\'></i> '.lang('TICKET_ACTION_edit').' '.$uss;}
    if ($r=='comment') {$red='<i class=\'fa fa-comment\'></i> '.lang('TICKET_ACTION_comment').' '.$uss;}
    if ($r == 'arch') {$red='<i class=\'fa fa-archive\'></i> '.lang('TICKET_ACTION_arch').'';}
    return $red;
}

function get_last_ticket($menu, $id) {
global $dbConnection;
 

	
	
    if ($menu == "all") {
        $unit_user=unit_of_user($id);
        $priv_val=priv_status($id);

        $units = explode(",", $unit_user);
        $units = "'". implode("', '", $units) ."'";

        if ($priv_val == "0") {

           /* 
                $stmt = $dbConnection->prepare('SELECT max(last_update) from tickets where unit_id IN (:units) or user_init_id=:id');
	$stmt->execute(array(':units' => $units, ':id' => $id));
	$max = $stmt->fetch(PDO::FETCH_NUM);
            */
                        $queryid = "SELECT max(last_update) from tickets where unit_id IN (".$units.") or user_init_id='$id';";
            $res1 = mysql_query($queryid) or die(mysql_error());
            $max= mysql_fetch_array( $res1 );

            
            
            $max_id=$max[0];
            //echo $max_id;
        }


        else if ($priv_val == "1") {


            $queryid = "SELECT max(last_update) from tickets where ((user_to_id='$id') or (user_to_id='0' and unit_id IN (".$units."))) or user_init_id='$id'";
            $res1 = mysql_query($queryid) or die(mysql_error());
            $max= mysql_fetch_array( $res1 );

            /*
            $stmt = $dbConnection->prepare("SELECT max(last_update) from tickets where ((user_to_id=:id) or (user_to_id=:tid and unit_id IN (:units))) or user_init_id=:id2");
	$stmt->execute(array(':units' => $units, ':id' => $id, ':tid' => '0', ':id2' => $id));
	$max = $stmt->fetch(PDO::FETCH_NUM);
            */
            
          
            $max_id=$max[0];


            //$count="1";
        }
        else if ($priv_val == "2") {

            
    /*$stmt = $dbConnection->prepare("SELECT max(last_update) from tickets");
	$stmt->execute();
	$max = $stmt->fetch(PDO::FETCH_NUM);
           */
                       $queryid = "SELECT max(last_update) from tickets;";
            $res1 = mysql_query($queryid) or die(mysql_error());
            $max= mysql_fetch_array( $res1 );
 
            $max_id=$max[0];
            //echo $max_id;
        }
    }
    if ($menu == "in") {



        $unit_user=unit_of_user($id);
        $priv_val=priv_status($id);
        $units = explode(",", $unit_user);
        $units = "'". implode("', '", $units) ."'";
        if ($priv_val == "0") {

                        $queryid = "SELECT max(last_update) from tickets where unit_id IN (".$units.") and arch='0'";
            $res1 = mysql_query($queryid) or die(mysql_error());
            $max= mysql_fetch_array( $res1 );
/*
    $stmt = $dbConnection->prepare("SELECT max(last_update) from tickets where unit_id IN (:units) and arch='0'");
	$stmt->execute(array(':units' => $units));
	$max = $stmt->fetch(PDO::FETCH_NUM);
            */
            $max_id=$max[0];
            //echo $max_id;
        }


        else if ($priv_val == "1") {



                        $queryid = "SELECT max(last_update) from tickets where ((user_to_id='$id' and arch='0') or (user_to_id='0' and unit_id IN (".$units.") and arch='0'))";
            $res1 = mysql_query($queryid) or die(mysql_error());
            $max= mysql_fetch_array( $res1 );

            /*
            $stmt = $dbConnection->prepare("SELECT max(last_update) from tickets where ((user_to_id=:id and arch='0') or (user_to_id='0' and unit_id IN (:units) and arch='0'))");
	$stmt->execute(array(':id' => $id,':units' => $units));
	$max = $stmt->fetch(PDO::FETCH_NUM);
            
            */
            $max_id=$max[0];


            //$count="1";
        }
        else if ($priv_val == "2") {

                        $queryid = "SELECT max(last_update) from tickets where arch='0'";
            $res1 = mysql_query($queryid) or die(mysql_error());
            $max= mysql_fetch_array( $res1 );

/*
            $stmt = $dbConnection->prepare("SELECT max(last_update) from tickets where arch='0'");
	$stmt->execute();
	$max = $stmt->fetch(PDO::FETCH_NUM);
	*/
            $max_id=$max[0];
            //echo $max_id;
        }



        //$count = mysql_num_rows(mysql_query("select * from tickets where user_to_id='$id' and arch='0'"));
    }
    if ($menu == "out") {
        //$count = mysql_num_rows(mysql_query("select * from tickets where user_init_id='$id' and arch='0'"));



        
                $queryid = "SELECT max(last_update) from tickets where user_init_id='$id' and arch='0'";
        $res1 = mysql_query($queryid) or die(mysql_error());
        $max= mysql_fetch_array( $res1 );

        /*
    $stmt = $dbConnection->prepare("SELECT max(last_update) from tickets where user_init_id=:id and arch='0'");
	$stmt->execute(array(':id' => $id));
	$max = $stmt->fetch(PDO::FETCH_NUM);
	*/
	
        $max_id=$max[0];
    }
    if ($menu == "arch") {




        $unit_user=unit_of_user($id);
        $priv_val=priv_status($id);
        $units = explode(",", $unit_user);
        $units = "'". implode("', '", $units) ."'";
        if ($priv_val == "0") {
            //$count = mysql_num_rows(mysql_query("SELECT * from tickets where unit_id='$unit_user'  and arch='1'"));


            /*
                $stmt = $dbConnection->prepare("SELECT max(last_update) from tickets where unit_id IN (:units)  and arch='1'");
	$stmt->execute(array(':units' => $units));
	$max = $stmt->fetch(PDO::FETCH_NUM);
	*/
	            $queryid = "SELECT max(last_update) from tickets where unit_id IN (".$units.")  and arch='1'";
            $res1 = mysql_query($queryid) or die(mysql_error());
            $max= mysql_fetch_array( $res1 );

            $max_id=$max[0];




        }


        else if ($priv_val == "1") {


            $queryid = "SELECT max(last_update) from tickets where (user_to_id='$id' and unit_id IN (".$units.") and arch='1') or
							(user_to_id='0' and unit_id IN (".$units.") and arch='1')";
            $res1 = mysql_query($queryid) or die(mysql_error());
            $max= mysql_fetch_array( $res1 );


            
            /*
                            $stmt = $dbConnection->prepare("SELECT max(last_update) from tickets where (user_to_id=:id and unit_id IN (:units) and arch='1') or
							(user_to_id='0' and unit_id IN (:units2) and arch='1')");
	$stmt->execute(array(':units' => $units, ':id' => $id, ':units2' => $units));
	$max = $stmt->fetch(PDO::FETCH_NUM);
            */
            $max_id=$max[0];


            //$count="1";
        }
        if ($priv_val == "2") {
            //$count = mysql_num_rows(mysql_query("SELECT * from tickets where unit_id='$unit_user'  and arch='1'"));


            
            /*$stmt = $dbConnection->prepare("SELECT max(last_update) from tickets where arch='1'");
	$stmt->execute();
	$max = $stmt->fetch(PDO::FETCH_NUM);
	*/
	            $queryid = "SELECT max(last_update) from tickets where arch='1'";
            $res1 = mysql_query($queryid) or die(mysql_error());
            $max= mysql_fetch_array( $res1 );

            $max_id=$max[0];




        }









        //$count = mysql_num_rows(mysql_query("select * from tickets where user_init_id='$id' and arch='1' or user_to_id='$id' and arch='1'"));
    }

    if ($menu == "client") {
        //$count = mysql_num_rows(mysql_query("select * from clients")) or die('error! Записей не найдено!');
    }




    return $max_id;

}



function get_total_tickets_out() {

global $dbConnection;
$uid=$_SESSION['helpdesk_user_id'];
$res = $dbConnection->prepare('SELECT count(*) from tickets where user_init_id=:uid');
$res->execute(array(':uid' => $uid));
$count = $res->fetch(PDO::FETCH_NUM);

	
	//$count = mysql_num_rows(mysql_query("SELECT * from tickets where user_init_id='$uid';"));
	return $count[0];
}
function get_total_tickets_lock() {
global $dbConnection;
	$uid=$_SESSION['helpdesk_user_id'];
	
	
$res = $dbConnection->prepare("SELECT count(*) from tickets where lock_by=:uid and status='0'");
$res->execute(array(':uid' => $uid));
$count = $res->fetch(PDO::FETCH_NUM);
	//$count = mysql_num_rows(mysql_query("SELECT * from tickets where lock_by='$uid' and status='0';"));
	return $count[0];
}
function get_total_tickets_ok() {
global $dbConnection;

$uid=$_SESSION['helpdesk_user_id'];
$res = $dbConnection->prepare("SELECT count(*) from tickets where ok_by=:uid");
$res->execute(array(':uid' => $uid));
$count = $res->fetch(PDO::FETCH_NUM);	



	//$uid=$_SESSION['helpdesk_user_id'];
	//$count = mysql_num_rows(mysql_query("SELECT * from tickets where ok_by='$uid';"));
	return $count[0];
}
function get_total_tickets_out_and_success() {

	
	
	
	
	global $dbConnection;

$uid=$_SESSION['helpdesk_user_id'];
$res = $dbConnection->prepare("SELECT count(*) from tickets where user_init_id=:uid and (ok_by='0') and arch='0'");
$res->execute(array(':uid' => $uid));
$count = $res->fetch(PDO::FETCH_NUM);


	return $count[0];
	}
	function get_total_tickets_out_and_lock() {
	global $dbConnection;
	$uid=$_SESSION['helpdesk_user_id'];
	
	$res = $dbConnection->prepare("SELECT count(*) from tickets where user_init_id=:uid and (lock_by!='0' and ok_by='0') and arch='0'");
$res->execute(array(':uid' => $uid));
$count = $res->fetch(PDO::FETCH_NUM);

	return $count[0];
	}
	
	
	
	
	
	
		function get_total_tickets_out_and_ok() {
		global $dbConnection;
	$uid=$_SESSION['helpdesk_user_id'];
	
	
	$res = $dbConnection->prepare("SELECT count(*) from tickets where user_init_id=:uid and (ok_by!='0') and arch='0'");
$res->execute(array(':uid' => $uid));
$count = $res->fetch(PDO::FETCH_NUM);

	return $count[0];
	}

function get_total_tickets_free() {
global $dbConnection;
	$uid=$_SESSION['helpdesk_user_id'];
	$unit_user=unit_of_user($uid);
    $priv_val=priv_status($uid);
    
    $units = explode(",", $unit_user);
    $units = "'". implode("', '", $units) ."'";
	
	if ($priv_val == "0") {
	
	
	$res = $dbConnection->prepare("SELECT count(*) from tickets where unit_id IN (:units) and status='0' and lock_by='0'");
$res->execute(array(':units' => $units));
$count = $res->fetch(PDO::FETCH_NUM);
$count=$count[0];	
	

        }


        else if ($priv_val == "1") {

	$res = $dbConnection->prepare("SELECT count(*) from tickets where ((user_to_id=:uid and arch='0') or (user_to_id='0' and unit_id IN (:units) and arch='0')) and status='0' and lock_by='0'");
$res->execute(array(':uid' => $uid, ':units' => $units));
$count = $res->fetch(PDO::FETCH_NUM);
$count=$count[0];



           
            //$count="1";
        }
        else if ($priv_val == "2") {

            $count = mysql_num_rows(mysql_query("SELECT * from tickets where status='0' and lock_by='0';"));

$res = $dbConnection->prepare("SELECT count(*) from tickets where status='0' and lock_by='0'");
$res->execute();
$count = $res->fetch(PDO::FETCH_NUM);
$count=$count[0];
            //$count="1";
        }

	return $count;
}

function get_myname(){
	$uid=$_SESSION['helpdesk_user_id'];
	
	
	$n=explode(" ", name_of_user_ret($uid));
	return $n[1]." ".$n[2];
}
function get_total_pages_workers() {
global $dbConnection;
$perpage='10';
//$count = mysql_num_rows(mysql_query("SELECT * from clients;"));

$res = $dbConnection->prepare("SELECT count(*) from clients");
$res->execute();
$count = $res->fetch(PDO::FETCH_NUM);
$count=$count[0];



if ($count <> 0) {
        $pages_count = ceil($count / $perpage);
        return $pages_count;
    }
    else {
        $pages_count = 0;
        return $pages_count;
    }

    return $count;
}
function get_total_pages($menu, $id) {
    //include("../dbconnect.inc.php");
    global $dbConnection;
    $perpage='10';
    if ($menu == "in") {



        $unit_user=unit_of_user($id);
        $priv_val=priv_status($id);
        $units = explode(",", $unit_user);
        $units = "'". implode("', '", $units) ."'";
        if ($priv_val == "0") {
            $count = mysql_num_rows(mysql_query("SELECT * from tickets where unit_id IN (".$units.") and arch='0'"));

        }


        else if ($priv_val == "1") {

            $count = mysql_num_rows(mysql_query("SELECT * from tickets where ((user_to_id='$id' and arch='0') or (user_to_id='0' and unit_id IN (".$units.") and arch='0'))"));


            //$count="1";
        }
        else if ($priv_val == "2") {

            $count = mysql_num_rows(mysql_query("SELECT * from tickets where arch='0';"));


            //$count="1";
        }



        //$count = mysql_num_rows(mysql_query("select * from tickets where user_to_id='$id' and arch='0'"));
    }
    if ($menu == "out") {
        $count = mysql_num_rows(mysql_query("select * from tickets where user_init_id='$id' and arch='0'"));
    }
    if ($menu == "arch") {




        $unit_user=unit_of_user($id);
        $priv_val=priv_status($id);
        $units = explode(",", $unit_user);
        $units = "'". implode("', '", $units) ."'";

        if ($priv_val == "0") {
            $count = mysql_num_rows(mysql_query("SELECT * from tickets where (unit_id IN (".$units.") or user_init_id='$id') and arch='1'"));

        }


        else if ($priv_val == "1") {

            $count = mysql_num_rows(mysql_query("SELECT * from tickets
							where (user_to_id='$id' and unit_id IN (".$units.") and arch='1') or
							(user_to_id='0' and unit_id IN (".$units.") and arch='1') or (user_init_id='$id' and arch='1')"));


            //$count="1";
        }
        else if ($priv_val == "2") {

            $count = mysql_num_rows(mysql_query("SELECT * from tickets
							where arch='1';"));


            //$count="1";
        }








        //$count = mysql_num_rows(mysql_query("select * from tickets where user_init_id='$id' and arch='1' or user_to_id='$id' and arch='1'"));
    }

    if ($menu == "client") {
        $count = mysql_num_rows(mysql_query("select * from clients")) or die('error! Записей не найдено!');
    }


    if ($count <> 0) {
        $pages_count = ceil($count / $perpage);
        return $pages_count;
    }
    else {
        $pages_count = 0;
        return $pages_count;
    }

    return $count;

}
function name_of_client($input) {
    //include("../dbconnect.inc.php");
    $query="SELECT fio FROM clients where id='$input'";
    $res = mysql_query($query) or die(mysql_error());
    $fio= mysql_fetch_assoc( $res );
    echo($fio['fio']);

}
function name_of_client_ret($input) {
    //include("../dbconnect.inc.php");
    $query="SELECT fio FROM clients where id='$input'";
    $res = mysql_query($query) or die(mysql_error());
    $fio= mysql_fetch_assoc( $res );
    return $fio['fio'];

}

function rus_date() {
// Перевод
global $lang;

if ($lang == "ua") {
    $translate = array(
        "am" => "дп",
        "pm" => "пп",
        "AM" => "ДП",
        "PM" => "ПП",
        "Monday" => "Понедельник",
        "Mon" => "Пн",
        "Tuesday" => "Вторник",
        "Tue" => "Вт",
        "Wednesday" => "Среда",
        "Wed" => "Ср",
        "Thursday" => "Четверг",
        "Thu" => "Чт",
        "Friday" => "Пятница",
        "Fri" => "Пт",
        "Saturday" => "Суббота",
        "Sat" => "Сб",
        "Sunday" => "Воскресенье",
        "Sun" => "Нд",
        "January" => "Січня",
        "Jan" => "січ",
        "February" => "Лютого",
        "Feb" => "лют",
        "March" => "Березня",
        "Mar" => "берез",
        "April" => "Квітня",
        "Apr" => "квіт",
        "May" => "Травня",
        "May" => "трав",
        "June" => "Липня",
        "Jun" => "лип",
        "July" => "Червня",
        "Jul" => "черв",
        "August" => "Серпеня",
        "Aug" => "серп",
        "September" => "Вересня",
        "Sep" => "верес",
        "October" => "Жовтня",
        "Oct" => "жовт",
        "November" => "Листопад",
        "Nov" => "лист",
        "December" => "Грудень",
        "Dec" => "гру",
        "st" => "ое",
        "nd" => "ое",
        "rd" => "е",
        "th" => "ое"
    );
    }
    else if ($lang == "ru") {
    $translate = array(
        "am" => "дп",
        "pm" => "пп",
        "AM" => "ДП",
        "PM" => "ПП",
        "Monday" => "Понедельник",
        "Mon" => "Пн",
        "Tuesday" => "Вторник",
        "Tue" => "Вт",
        "Wednesday" => "Среда",
        "Wed" => "Ср",
        "Thursday" => "Четверг",
        "Thu" => "Чт",
        "Friday" => "Пятница",
        "Fri" => "Пт",
        "Saturday" => "Суббота",
        "Sat" => "Сб",
        "Sunday" => "Воскресенье",
        "Sun" => "Вс",
        "January" => "Января",
        "Jan" => "янв",
        "February" => "Февраля",
        "Feb" => "фев",
        "March" => "Марта",
        "Mar" => "март",
        "April" => "Апреля",
        "Apr" => "апр",
        "May" => "Мая",
        "May" => "мая",
        "June" => "Июня",
        "Jun" => "июня",
        "July" => "Июля",
        "Jul" => "июля",
        "August" => "Агуста",
        "Aug" => "авг",
        "September" => "Сентября",
        "Sep" => "сент",
        "October" => "Октября",
        "Oct" => "окт",
        "November" => "Ноября",
        "Nov" => "нояб",
        "December" => "Декабря",
        "Dec" => "дек",
        "st" => "ое",
        "nd" => "ое",
        "rd" => "е",
        "th" => "ое"
    );
    }
    
        else if ($lang == "en") {
    $translate = array(
        "am" => "am",
        "pm" => "pm",
        "AM" => "AM",
        "PM" => "PM",
        "Monday" => "Monday",
        "Mon" => "Mon",
        "Tuesday" => "Tuesday",
        "Tue" => "Tue",
        "Wednesday" => "Wednesday",
        "Wed" => "Wed",
        "Thursday" => "Thursday",
        "Thu" => "Thu",
        "Friday" => "Friday",
        "Fri" => "Fri",
        "Saturday" => "Saturday",
        "Sat" => "Sat",
        "Sunday" => "Sunday",
        "Sun" => "Sun",
        "January" => "January",
        "Jan" => "Jan",
        "February" => "February",
        "Feb" => "Feb",
        "March" => "March",
        "Mar" => "Mar",
        "April" => "April",
        "Apr" => "Apr",
        "May" => "May",
        "May" => "May",
        "June" => "June",
        "Jun" => "Jun",
        "July" => "July",
        "Jul" => "Jul",
        "August" => "August",
        "Aug" => "Aug",
        "September" => "September",
        "Sep" => "Sep",
        "October" => "October",
        "Oct" => "Oct",
        "November" => "November",
        "Nov" => "Nov",
        "December" => "December",
        "Dec" => "Dec",
        "st" => "st",
        "nd" => "nd",
        "rd" => "rd",
        "th" => "th"
    );
    }
    // если передали дату, то переводим ее
    if (func_num_args() > 1) {
        $timestamp = func_get_arg(1);
        return strtr(date(func_get_arg(0), $timestamp), $translate);
    } else {
// иначе текущую дату
        return strtr(date(func_get_arg(0)), $translate);
    }
}

function dt_format ($input) {

    $dat=date_create($input);
    //$last_bu = date_format($dat, 'H:i, D, d M');
    $v=rus_date("H:i, D, j M", strtotime($input));
    echo($v);
}

function dt_format_full ($input) {

    $dat=date_create($input);
    //$last_bu = date_format($dat, 'H:i, D, d M');
    $v=rus_date("H:i:s, D, j M", strtotime($input));
    echo($v);
}

function dt_format_full_r ($input) {

    $dat=date_create($input);
    //$last_bu = date_format($dat, 'H:i, D, d M');
    $v=rus_date("H:i, D, j M", strtotime($input));
    return($v);
}
function dt_format_short ($input) {

    $dat=date_create($input);
    //$last_bu = date_format($dat, 'H:i, D, d M');
    $v=rus_date("H:i", strtotime($input));
    return($v);
}


function time_ago($in) {
    $time = $in;
    $datetime1 = date_create($time);
    $datetime2 = date_create('now',new DateTimeZone('Europe/Kiev'));
    $interval = date_diff($datetime1, $datetime2);
    echo $interval->format('%d д %h:%I');
    //echo strftime("%e", strtotime($interval));

}
function humanTiming_period ($time1, $time_ago)
{
global $lang;

    $time = (strtotime($time_ago) - strtotime($time1)); // to get the time since that moment

    $tokens = array (
        31536000 => 'р',
        2592000 => 'міс',
        604800 => 'тижд',
        86400 => 'дн',
        3600 => 'год',
        60 => 'хв',
        1 => 'сек'
    );


if ($lang == "ua") {


    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        //substr($numberOfUnits, -1)
        if ($text=='міс') {
            if ($numberOfUnits == "1") {$text="місяць";}
            if (($numberOfUnits >= "2") && ($numberOfUnits <= "4")) {$text="місяці";} //3,4
            if ($numberOfUnits > "4") {$text="місяців";}
        }

        if ($text=='тижд') {
            if (substr($numberOfUnits, -1) == "1") {$text="тиждень";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="тижні";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="тижнів";}
        }

        if ($text=='дн') {
            if (substr($numberOfUnits, -1) == "1") {$text="день";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="дні";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="днів";}
        }

        if ($text=='год') {
            if (substr($numberOfUnits, -1) == "1") {$text="година";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="години";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="годин";}
        }


        if ($text=='хв') {
            if (substr($numberOfUnits, -1) == "1") {$text="хвилина";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="хвилини";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="хвилин";}
        }

        if ($text=='сек') {
            if (substr($numberOfUnits, -1) == "1") {$text="секунда";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="секунд";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="секунд";}
        }



        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'':'');


        //return $time;

    }
}
else if ($lang == "ru") {


    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        //substr($numberOfUnits, -1)
        if ($text=='міс') {
            if ($numberOfUnits == "1") {$text="месяц";}
            if (($numberOfUnits >= "2") && ($numberOfUnits <= "4")) {$text="месяца";} //3,4
            if ($numberOfUnits > "4") {$text="месяцев";}
        }

        if ($text=='тижд') {
            if (substr($numberOfUnits, -1) == "1") {$text="неделя";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="недели";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="недель";}
        }

        if ($text=='дн') {
            if (substr($numberOfUnits, -1) == "1") {$text="день";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="дня";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="дней";}
        }

        if ($text=='год') {
            if (substr($numberOfUnits, -1) == "1") {$text="час";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="часа";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="часов";}
        }


        if ($text=='хв') {
            if (substr($numberOfUnits, -1) == "1") {$text="минута";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="минут";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="минут";}
        }

        if ($text=='сек') {
            if (substr($numberOfUnits, -1) == "1") {$text="секунда";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="секунд";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="секунд";}
        }



        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'':'');


        //return $time;

    }
}
else if ($lang == "en") {


    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        //substr($numberOfUnits, -1)
        if ($text=='міс') {
            if ($numberOfUnits == "1") {$text="month";}
            if (($numberOfUnits >= "2") && ($numberOfUnits <= "4")) {$text="month";} //3,4
            if ($numberOfUnits > "4") {$text="month";}
        }

        if ($text=='тижд') {
            if (substr($numberOfUnits, -1) == "1") {$text="week";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="weeks";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="weeks";}
        }

        if ($text=='дн') {
            if (substr($numberOfUnits, -1) == "1") {$text="day";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="days";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="days";}
        }

        if ($text=='год') {
            if (substr($numberOfUnits, -1) == "1") {$text="hour";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="hours";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="hours";}
        }


        if ($text=='хв') {
            if (substr($numberOfUnits, -1) == "1") {$text="minute";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="minutes";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="minutes";}
        }

        if ($text=='сек') {
            if (substr($numberOfUnits, -1) == "1") {$text="second";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="seconds";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="seconds";}
        }



        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'':'');


        //return $time;

    }
}
}


function humanTiming ($time)
{
global $lang;
    $time = time() - $time; // to get the time since that moment

    $tokens = array (
        31536000 => 'р',
        2592000 => 'міс',
        604800 => 'тижд',
        86400 => 'дн',
        3600 => 'год',
        60 => 'хв',
        1 => 'сек'
    );




if ($lang == "ua") {
    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        //substr($numberOfUnits, -1)
        if ($text=='міс') {
            if ($numberOfUnits == "1") {$text="місяць";}
            if (($numberOfUnits >= "2") && ($numberOfUnits <= "4")) {$text="місяці";} //3,4
            if ($numberOfUnits > "4") {$text="місяців";}
        }

        if ($text=='тижд') {
            if (substr($numberOfUnits, -1) == "1") {$text="тиждень";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="тижні";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="тижнів";}
        }

        if ($text=='дн') {
            if (substr($numberOfUnits, -1) == "1") {$text="день";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="дні";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="днів";}
        }

        if ($text=='год') {
            if (substr($numberOfUnits, -1) == "1") {$text="година";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="години";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="годин";}
        }


        if ($text=='хв') {
            if (substr($numberOfUnits, -1) == "1") {$text="хвилина";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="хвилини";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="хвилин";}
        }

        if ($text=='сек') {
            if (substr($numberOfUnits, -1) == "1") {$text="секунда";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="секунд";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="секунд";}
        }



        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'':'');


}


    }

else if ($lang == "en") {


    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        //substr($numberOfUnits, -1)
        if ($text=='міс') {
            if ($numberOfUnits == "1") {$text="month";}
            if (($numberOfUnits >= "2") && ($numberOfUnits <= "4")) {$text="month";} //3,4
            if ($numberOfUnits > "4") {$text="month";}
        }

        if ($text=='тижд') {
            if (substr($numberOfUnits, -1) == "1") {$text="week";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="weeks";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="weeks";}
        }

        if ($text=='дн') {
            if (substr($numberOfUnits, -1) == "1") {$text="day";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="days";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="days";}
        }

        if ($text=='год') {
            if (substr($numberOfUnits, -1) == "1") {$text="hour";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="hours";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="hours";}
        }


        if ($text=='хв') {
            if (substr($numberOfUnits, -1) == "1") {$text="minute";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="minutes";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="minutes";}
        }

        if ($text=='сек') {
            if (substr($numberOfUnits, -1) == "1") {$text="second";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="seconds";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="seconds";}
        }



        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'':'');


        //return $time;

    }
}
else if ($lang == "ru") {


    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        //substr($numberOfUnits, -1)
        if ($text=='міс') {
            if ($numberOfUnits == "1") {$text="месяц";}
            if (($numberOfUnits >= "2") && ($numberOfUnits <= "4")) {$text="месяца";} //3,4
            if ($numberOfUnits > "4") {$text="месяцев";}
        }

        if ($text=='тижд') {
            if (substr($numberOfUnits, -1) == "1") {$text="неделя";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="недели";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="недель";}
        }

        if ($text=='дн') {
            if (substr($numberOfUnits, -1) == "1") {$text="день";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="дня";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="дней";}
        }

        if ($text=='год') {
            if (substr($numberOfUnits, -1) == "1") {$text="час";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="часа";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="часов";}
        }


        if ($text=='хв') {
            if (substr($numberOfUnits, -1) == "1") {$text="минута";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="минут";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="минут";}
        }

        if ($text=='сек') {
            if (substr($numberOfUnits, -1) == "1") {$text="секунда";}
            if ((substr($numberOfUnits, -1) >= "2") && (substr($numberOfUnits, -1) <= "4")) {$text="секунд";} //3,4
            if (substr($numberOfUnits, -1) > "4") {$text="секунд";}
        }



        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'':'');


        //return $time;

    }
}



}

function humanTiming_old ($time)
{

    $time = time() - $time; // to get the time since that moment

    return floor($time/86400);
}




function get_unit_name($input) {
    $u=explode(",", $input);

    foreach ($u as $val) {

    $query="SELECT name FROM deps where id='$val'";
    $rest = mysql_query($query) or die(mysql_error());
    $dep= mysql_fetch_assoc( $rest );
    $res.=$dep['name'];
    $res.="<br>";
    }
    //else { echo "не определено";}
    echo $res;
}

function name_of_user($input) {
    //include("../dbconnect.inc.php");
    $query="SELECT fio FROM users where id='$input'";
    $res = mysql_query($query) or die(mysql_error());
    $fio= mysql_fetch_assoc( $res );
    echo($fio['fio']);
}

function name_of_user_ret($input) {
    //include("../dbconnect.inc.php");
    $query="SELECT fio FROM users where id='$input'";
    $res = mysql_query($query) or die(mysql_error());
    $fio= mysql_fetch_assoc( $res );
    return($fio['fio']);
}

function unit_of_user($input) {
    //include("../dbconnect.inc.php");
    $query="SELECT unit FROM users where id='$input'";
    $res = mysql_query($query) or die(mysql_error());
    $fio= mysql_fetch_assoc( $res );
    return ($fio['unit']);
}

function cutstr_help_ret($input) {

    $result = implode(array_slice(explode('<br>',wordwrap($input,500,'<br>',false)),0,1));
    $r=$result;
    if($result!=$input)$r.='...';
    return $r;
}

function cutstr_help2_ret($input) {

    $result = implode(array_slice(explode('<br>',wordwrap($input,100,'<br>',false)),0,1));
    $r=$result;
    if($result!=$input)$r.='...';
    return $r;
}

function cutstr_ret($input) {

    $result = implode(array_slice(explode('<br>',wordwrap($input,30,'<br>',true)),0,1));
    return $result;
    if($result!=$input)return'...';
}


function cutstr($input) {

    $result = implode(array_slice(explode('<br>',wordwrap($input,51,'<br>',false)),0,1));
    echo $result;
    if($result!=$input)echo'...';
}
function get_date_ok($d_create, $id) {
	$q_total="select date_op from ticket_log where ticket_id='$id' and msg='ok' order by date_op DESC";
    $res_total = mysql_query($q_total) or die(mysql_error());
    $total_ticket= mysql_fetch_assoc( $res_total );
    $tt=$total_ticket['date_op'];
    
    return humanTiming_period($d_create, $tt);
	//return $d_create;
}
?>