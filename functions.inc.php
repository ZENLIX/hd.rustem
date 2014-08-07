<?php


include_once('conf.php');
include_once('sys/class.phpmailer.php');
include_once('sys/Parsedown.php');
require 'library/HTMLPurifier.auto.php';
date_default_timezone_set('Europe/Kiev');
$dbConnection = new PDO(
    'mysql:host='.$CONF_DB['host'].';dbname='.$CONF_DB['db_name'],
    $CONF_DB['username'],
    $CONF_DB['password'],
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
);
$dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if ($CONF['debug_mode'] == false) {
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);
}
include_once('inc/mail.inc.php');


$forhostname=substr($CONF['hostname'], -1);
if ($forhostname == "/") {$CONF['hostname']=$CONF['hostname'];}
else if ($forhostname <> "/") {$CONF['hostname']=$CONF['hostname']."/";}


function get_user_lang(){
    global $dbConnection;


    $mid=$_SESSION['helpdesk_user_id'];
    $stmt = $dbConnection->prepare('SELECT lang from users where id=:mid');
    $stmt->execute(array(':mid' => $mid));
    $max = $stmt->fetch(PDO::FETCH_NUM);

    $max_id=$max[0];
    $length = strlen(utf8_decode($max_id));
    if (($length < 1) || $max_id == "0") {$ress='ru';} else {$ress=$max_id;}
    return $ress;
}


$lang=get_user_lang();
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

    default:
        $lang_file = 'lang.ru.php';

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
    global $dbConnection;
    $uid=$_SESSION['helpdesk_user_id'];

    $stmt = $dbConnection->prepare('SELECT count(email) as n from users where email=:str and id != :uid');
    $stmt->execute(array(':str' => $str,':uid' => $uid));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row['n'] > 0) {$r=false;}
	else if ($row['n'] == 0) {$r=true;}

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

}

function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyz0123456789";
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 5; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}

function randomhash() {
    $alphabet = "abcdefghijklmnopqrstuwxyz0123456789";
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 24; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}




function nameshort($name) {
    $nameshort = preg_replace('/(\w+) (\w)\w+ (\w)\w+/iu', '$1 $2. $3.', $name);
    return $nameshort;
}


function xss_clean($data)
{

    $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');


    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);


    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);


    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);


    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

    do
    {

        $old_data = $data;
        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
    }
    while ($old_data !== $data);


    return $data;
}

function get_file_icon($in) {
    global $dbConnection;
	$stmt = $dbConnection->prepare('SELECT file_type FROM files where file_hash=:file_hash');
    $stmt->execute(array(':file_hash' => $in));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $ftype=$row['file_type'];
    
    
    switch($ftype) {


    
    
    case 'application/pdf': $icon="<i class=\"fa fa-file-pdf-o\"></i>";	break;
    case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document': $icon="<i class=\"fa fa-file-word-o\"></i>";	break;
    case 'application/msword': $icon="<i class=\"fa fa-file-word-o\"></i> ";	break;
    case 'application/excel': $icon="<i class=\"fa fa-file-excel-o\"></i>";	break;
    case 'application/vnd.ms-excel': $icon="<i class=\"fa fa-file-excel-o\"></i>";	break;
    case 'application/x-excel': $icon="<i class=\"fa fa-file-excel-o\"></i>";	break;
    case 'application/x-msexcel': $icon="<i class=\"fa fa-file-excel-o\"></i>";	break;
    case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': $icon="<i class=\"fa fa-file-word-o\"></i>";	break;
    case 'image/jpeg': $icon="<i class=\"fa fa-file-image-o\"></i>";	break;
    case 'image/jpg': $icon="<i class=\"fa fa-file-image-o\"></i>";	break;
    case 'image/gif': $icon="<i class=\"fa fa-file-image-o\"></i>";	break;
    case 'image/png': $icon="<i class=\"fa fa-file-image-o\"></i>";	break;
    
		default: $icon="<i class=\"fa fa-file\"></i>";
    }
	
	return $icon;
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

function view_log($tid) {
global $dbConnection;

                        $stmt = $dbConnection->prepare('SELECT msg,
							date_op, init_user_id, to_user_id, to_unit_id from ticket_log where
							ticket_id=:tid order by date_op DESC');
                        $stmt->execute(array(':tid'=>$tid));
                        $re = $stmt->fetchAll();






                        if(!empty($re)) {






                            ?>

                            <div class="col-md-12" style=" padding-left: 0px; padding-right: 0px; ">


                                <div class="panel panel-default">
                                    <div class="panel-body" style="max-height: 400px; scroll-behavior: initial; overflow-y: scroll;">

                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th><center><small><?=lang('TICKET_t_date');?></small></center>	</th>
                                                <th><center><small><?=lang('TICKET_t_init');?>	</small></center></th>
                                                <th><center><small><?=lang('TICKET_t_action');?> 	</small></center></th>
                                                <th><center><small><?=lang('TICKET_t_desc');?>	</small></center></th>


                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php
                                            foreach($re as $row) {




                                                $t_action=$row['msg'];

                                                if ($t_action == 'refer') {
                                                    $icon_action="fa fa-long-arrow-right";
                                                    $text_action="".lang('TICKET_t_a_refer')." <br>".view_array(get_unit_name_return($row['to_unit_id']))."<br>".name_of_user_ret($row['to_user_id']);

                                                }
                                                if ($t_action == 'arch') {$icon_action="fa fa-archive"; $text_action=lang('TICKET_t_a_arch');}

                                                if ($t_action == 'ok') {$icon_action="fa fa-check-circle-o"; $text_action=lang('TICKET_t_a_ok');}
                                                if ($t_action == 'no_ok') {$icon_action="fa fa-circle-o"; $text_action=lang('TICKET_t_a_nook');}
                                                if ($t_action == 'lock') {$icon_action="fa fa-lock"; $text_action=lang('TICKET_t_a_lock');}
                                                if ($t_action == 'unlock') {$icon_action="fa fa-unlock"; $text_action=lang('TICKET_t_a_unlock');}
                                                if ($t_action == 'create') {$icon_action="fa fa-star-o"; $text_action=lang('TICKET_t_a_create');}

                                                if ($t_action == 'edit_msg') {$icon_action="fa fa-pencil-square"; $text_action=lang('TICKET_t_a_e_text');}
                                                if ($t_action == 'edit_subj') {$icon_action="fa fa-pencil-square"; $text_action=lang('TICKET_t_a_e_subj');}
                                                if ($t_action == 'comment') {$icon_action="fa fa-comment"; $text_action=lang('TICKET_t_a_com');}

                                                ?>
                                                <tr>
                                                    <td style="width: 100px; vertical-align: inherit;"><small><center>
                                                    
                                                    <time id="c" datetime="<?=$row['date_op']?>"></time>
                                                    
                                                    </center></small></td>
                                                    <td style=" width: 200px; vertical-align: inherit;"><small><center><?=name_of_user($row['init_user_id'])?></center></small></td>
                                                    <td style=" width: 50px; vertical-align: inherit;"><small><center><i class="<?=$icon_action;?>"></i>  </center></small></td>
                                                    <td style=" width: 200px; vertical-align: inherit;"><small><?=$text_action?></small></td>


                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>





                            </div>



                        <?php }
}

function make_html($in, $type) {



	$Parsedown = new Parsedown();
	$text=$Parsedown->text($in);

$config = HTMLPurifier_Config::createDefault();
$config->set('Core.Encoding', 'UTF-8');
$config->set('HTML.Doctype', 'XHTML 1.0 Transitional');
$config->set('Cache.DefinitionImpl', null);
$config->set('AutoFormat.RemoveEmpty',true);
$config->set('AutoFormat.AutoParagraph',true);

if ($type  == "no") {
$config->set('HTML.ForbiddenElements', array( 'p' ) );
}

$purifier = new HTMLPurifier($config);

// here, the javascript command is stripped off
$content = $purifier->purify($text);

return $content;
	
}

function view_comment($tid) {
    global $dbConnection;
    

    ?>







    	<div class="row" id="comment_body" style="max-height: 400px; scroll-behavior: initial; overflow-y: scroll;">
    
        <div class="timeline-centered">
        <?php
        $stmt = $dbConnection->prepare('SELECT user_id, comment_text, dt from comments where t_id=:tid');
        $stmt->execute(array(':tid' => $tid));
        while ($rews = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
        
        <article class="timeline-entry">

            <div class="timeline-entry-inner">

                <div class="timeline-icon bg-info">
                    <i class="entypo-feather"></i>
                </div>

                <div class="timeline-label">
                                                    <div class="header">
                                    <strong class="primary-font"><?=nameshort(name_of_user_ret($rews['user_id']));?></strong> <small class="pull-right text-muted">
                                        <span class="glyphicon glyphicon-time"></span> 
                                        <time id="b" datetime="<?=$rews['dt'];?>"></time> <time id="c" datetime="<?=$rews['dt'];?>"></time></small>
                                        
                                </div><br>
                    <p><?=make_html($rews['comment_text'], true); ?></p>
                </div>
            </div>

        </article>
        
        
        

        
        
        
        

                            

        <?php } ?>
                   
        </div>
    </div>





<?php

}

function check_unlinked_file() {
	global $dbConnection;
	
	$stmt = $dbConnection->prepare('SELECT original_name, ticket_hash, file_hash, file_ext FROM files
									LEFT JOIN tickets ON tickets.hash_name = files.ticket_hash
									WHERE tickets.hash_name IS NULL');
    $stmt->execute();
	$result = $stmt->fetchAll();
        if (!empty($result)) {
        
        
        
        
foreach ($result as $row) {
        
                $stmt = $dbConnection->prepare("delete FROM files where ticket_hash=:id");
                $stmt->execute(array(':id'=> $row['ticket_hash']));
				unlink(realpath(dirname(__FILE__))."/upload_files/".$row['file_hash'].".".$row['file_ext']);


}}

	
}


function validate_user($user_id, $input) {

    global $dbConnection;

    if (!isset($_SESSION['code'])) {

        if (isset($_COOKIE['authhash_code'])) {

            $user_id=$_COOKIE['authhash_uid'];
            $input=$_COOKIE['authhash_code'];
            $_SESSION['code']=$input;
            $_SESSION['helpdesk_user_id']=$user_id;

        }


    }


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
    global $dbConnection;

    $stmt = $dbConnection->prepare('select id from tickets where hash_name=:in');
    $stmt->execute(array(':in' => $in));
    $total_ticket = $stmt->fetch(PDO::FETCH_ASSOC);


    $tt=$total_ticket['id'];
    return $tt;
}

function get_helper() {
    global $dbConnection;


    $user_id   = id_of_user($_SESSION['helpdesk_user_login']);
    $unit_user = unit_of_user($user_id);
    $priv_val  = priv_status($user_id);

    $units = explode(",", $unit_user);
    array_push($units, "0");

    $stmt = $dbConnection->prepare('SELECT
							id, user_init_id, unit_to_id, dt, title, message, hashname
							from helper
							order by dt desc
							limit 5');
    $stmt->execute();
    $result = $stmt->fetchAll();
    ?>
    <table class="table table-hover" style="margin-bottom: 0px;" id="">
        <?php

        if (empty($result)) {
            ?>
            <div id="" class="well well-large well-transparent lead">
                <center>
                    <?= lang('MSG_no_records'); ?>
                </center>
            </div>
        <?php
        } else if (!empty($result)) {
            foreach ($result as $row) {

                $unit2id = explode(",", $row['unit_to_id']);
                $diff    = array_intersect($units, $unit2id);
                if ($priv_val == 1) {
                    if ($diff) {
                        $ac = "ok";
                    }


                    if ($user_id == $row['user_init_id']) {
                        $priv_h = "yes";
                    }
                } else if ($priv_val == 0) {
                    $ac = "ok";
                    if ($user_id == $row['user_init_id']) {
                        $priv_h = "yes";
                    }
                } else if ($priv_val == 2) {
                    $ac     = "ok";
                    $priv_h = "yes";
                }

                if ($ac == "ok") {

                    ?>
                    <tr><td><small><i class="fa fa-file-text-o"></i> </small><a href="helper?h=<?= $row['hashname']; ?>"><small><?= cutstr_help2_ret($row['title']); ?></small></a></td><td><small style="float:right;" class="text-muted">(<?= lang('DASHBOARD_author'); ?>: <?= nameshort(name_of_user_ret($row['user_init_id'])); ?>)</small></td></tr>

                <?php
                }
            }
        }
        ?>
    </table>
<?
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


    $stmt = $dbConnection->prepare('select count(id) as t1 from tickets where client_id=:id');
    $stmt->execute(array(':id' => $id));
    $total_ticket = $stmt->fetch(PDO::FETCH_ASSOC);


    $tt=$total_ticket['t1'];


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
                        <a target="_blank" href="userinfo?user=<?=$id?>">
                            <?php }?>
                            <?php echo $tt; ?>
                            <?php if ($priv_val <> "1") { ?>
                        </a>
                    <?php }?>
                    </small></td>
            </tr>

            <tr>
                <td style=" width: 30px; "><small class="text-muted"><?=lang('WORKER_last');?>:</small></td>
                <td><small><?php if ($priv_val <> "1") { ?><a target="_blank" href="userinfo?user=<?=$id?>"><?php } ?>
                
                <time id="b" datetime="<?=$lt;?>"></time>
                <time id="c" datetime="<?=$lt;?>"></time>
                
                <?php if ($priv_val <> "1") { ?></a><?php } ?></small></td>
            </tr>
            </tbody>
        </table>

    </div>

<?php
}

function get_unit_name_return4news($input) {
    global $dbConnection;

    $u=explode(",", $input);
    foreach ($u as $val) {

        $stmt = $dbConnection->prepare('SELECT name FROM deps where id=:val');
        $stmt->execute(array(':val' => $val));
        $dep = $stmt->fetch(PDO::FETCH_ASSOC);


        $res=$dep['name'];

    }
    return $res;
}


function get_unit_name_return($input) {
    global $dbConnection;

    $u=explode(",", $input);
    $res=array();
    foreach ($u as $val) {

        $stmt = $dbConnection->prepare('SELECT name FROM deps where id=:val');
        $stmt->execute(array(':val' => $val));
        $dep = $stmt->fetch(PDO::FETCH_ASSOC);

		
		array_push($res, $dep['name']);
        //$res.=$dep['name'];
        //$res.="<br>";
    }

    return $res;
}

function view_array($in) {
$end_element = array_pop($in);
foreach ($in as $value) {
   // делаем что-либо с каждым элементом
        $res.=$value;
        $res.="<br>";
}
$res.=$end_element;
   // делаем что-либо с последним элементом $end_element





	
	return $res;
}



function get_user_val($in) {
	global $CONF;
    global $dbConnection;
    $i=$_SESSION['helpdesk_user_id'];
    $stmt = $dbConnection->prepare('SELECT '.$in.' FROM users where id=:id');
    $stmt->execute(array(':id'=>$i));
    
    $fior = $stmt->fetch(PDO::FETCH_NUM);
	

	
return $fior[0];	
}




function get_client_info($id) {
    global $CONF;
    global $dbConnection;

    $stmt = $dbConnection->prepare('SELECT fio,tel,unit_desc,adr,tel_ext,email,login, posada, email FROM clients where id=:id');
    $stmt->execute(array(':id' => $id));
    $fio = $stmt->fetch(PDO::FETCH_ASSOC);


	$priv_edit_client=get_user_val('priv_edit_client');
    $fio_user=$fio['fio'];
    $loginf=$fio['login'];
    $tel_user=$fio['tel'];
    $pod=$fio['unit_desc'];
    $adr=$fio['adr'];
    $tel_ext=$fio['tel_ext'];
    $mails=$fio['email'];
    $posada=$fio['posada'];


    $stmt = $dbConnection->prepare('select count(id) as t1 from tickets where client_id=:id');
    $stmt->execute(array(':id' => $id));
    $total_ticket = $stmt->fetch(PDO::FETCH_ASSOC);
    $tt=$total_ticket['t1'];

    $stmt = $dbConnection->prepare('select max(date_create) as dc from tickets where client_id=:id');
    $stmt->execute(array(':id' => $id));
    $last_ticket = $stmt->fetch(PDO::FETCH_ASSOC);

    $lt=$last_ticket['dc'];
    $uid=$_SESSION['helpdesk_user_id'];
    $priv_val=priv_status($uid);
    //echo $priv_edit_client;
    if ($priv_edit_client == 1) {$can_edit=true;}
    else if ($priv_edit_client == 0) {$can_edit=false;}
    //$can_edit=false;
    if ($can_edit == true) {
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
                <td><small><a href="#" id="edit_posada" data-type="select" data-source="<?=$CONF['hostname'];?>/inc/json.php?posada" data-pk="1" data-title="<?=lang('WORKER_posada');?>"><?=$posada?></a></small></td>
            </tr>
            <tr>
                <td style=" width: 30px; "><small><?=lang('WORKER_unit');?>:</small></td>
                <td><small><a href="#" id="edit_unit" data-type="select" data-source="<?=$CONF['hostname'];?>/inc/json.php?units" data-pk="1" data-title="<?=lang('NEW_to_unit');?>"><?php echo $pod; ?></a></small></td>
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
                        <a target="_blank" href="userinfo?user=<?=$id?>"><?php }?><?php echo $tt; ?><?php if ($priv_val <> "1") { ?></a><?php } ?></small></td>
            </tr>

            <tr>
                <td style=" width: 30px; "><small class="text-muted"><?=lang('WORKER_last');?>:</small></td>
                <td><small class="text-muted">
                        <?php if ($priv_val <> "1") { ?>
                        <a target="_blank" href="userinfo?user=<?=$id?>">
                            <?php }?>
                <time id="b" datetime="<?=$lt;?>"></time>
                <time id="c" datetime="<?=$lt;?>"></time>
                            
                            <?php if ($priv_val <> "1") { ?></a><?php } ?></small></td>
            </tr>
            </tbody>
        </table>

    </div>

<?php
}



 if ($can_edit == false) {
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
                <td><small><?=$loginf?></small></td>
            </tr>
            <tr>
                <td style=" width: 30px; "><small><?=lang('WORKER_posada');?>:</small></td>
                <td><small><?=$posada?></small></td>
            </tr>
            <tr>
                <td style=" width: 30px; "><small><?=lang('WORKER_unit');?>:</small></td>
                <td><small><?php echo $pod; ?></small></td>
            </tr>

            <tr>
                <td style=" width: 30px; "><small><?=lang('WORKER_tel');?>:</small></td>
                <td><small><?php echo $tel_user." ".$tel_ext; ?></small></td>
            </tr>
            <tr>
                <td style=" width: 30px; "><small><?=lang('WORKER_room');?>:</small></td>
                <td><small><?php echo $adr; ?></small></td>
            </tr>
            <tr>
                <td style=" width: 30px; "><small><?=lang('WORKER_mail');?>:</small></td>
                <td><small><?=$mails?></small></td>
            </tr>
            <tr>
                <td style=" width: 30px; "><small class="text-muted"><?=lang('WORKER_total');?>:</small></td>
                <td><small class="text-muted">
                        <?php if ($priv_val <> "1") { ?>
                        <a target="_blank" href="userinfo?user=<?=$id?>"><?php }?><?php echo $tt; ?><?php if ($priv_val <> "1") { ?></a><?php } ?></small></td>
            </tr>

            <tr>
                <td style=" width: 30px; "><small class="text-muted"><?=lang('WORKER_last');?>:</small></td>
                <td><small class="text-muted">
                        <?php if ($priv_val <> "1") { ?>
                        <a target="_blank" href="userinfo?user=<?=$id?>">
                            <?php }?><?php echo $lt; ?><?php if ($priv_val <> "1") { ?></a><?php } ?></small></td>
            </tr>
            </tbody>
        </table>

    </div>

<?php
}



}
function client_unit($input) {
    global $dbConnection;


    $stmt = $dbConnection->prepare('SELECT unit_desc FROM clients where id=:input');
    $stmt->execute(array(':input' => $input));
    $fio = $stmt->fetch(PDO::FETCH_ASSOC);


    echo($fio['unit_desc']);

}
function id_of_user($input) {
    global $dbConnection;
    $stmt = $dbConnection->prepare('SELECT id FROM users where login=:input');
    $stmt->execute(array(':input' => $input));
    $id = $stmt->fetch(PDO::FETCH_ASSOC);

    return ($id['id']);
}


function priv_status_name($input) {
    global $dbConnection;


    $stmt = $dbConnection->prepare('SELECT priv FROM users where id=:input');
    $stmt->execute(array(':input' => $input));
    $id = $stmt->fetch(PDO::FETCH_ASSOC);

switch($id['priv']) {
	case '2': 	$r="<strong class=\"text-warning\">".lang('USERS_nach1')."</strong>";	break;
	case '0': 	$r="<strong class=\"text-success\">".lang('USERS_nach')."</strong>";	break;
	case '1': 	$r="<strong class=\"text-info\">".lang('USERS_wo')."</strong>";	break;
	default: $r="";
}	


    return ($r);
}



function priv_status($input) {
    global $dbConnection;


    $stmt = $dbConnection->prepare('SELECT priv FROM users where id=:input');
    $stmt->execute(array(':input' => $input));
    $id = $stmt->fetch(PDO::FETCH_ASSOC);


    return ($id['priv']);
}


function get_last_ticket_new($id) {
    global $dbConnection;
    $unit_user=unit_of_user($id);
    $priv_val=priv_status($id);
    $units = explode(",", $unit_user);


    $units =implode("', '", $units);
    
$ee=explode(",", $unit_user);
foreach($ee as $key=>$value) {$in_query = $in_query . ' :val_' . $key . ', '; }
$in_query = substr($in_query, 0, -2);
foreach ($ee as $key=>$value) { $vv[":val_" . $key]=$value;}

    if ($priv_val == "0") {

        $stmt = $dbConnection->prepare('SELECT max(last_update) from tickets where unit_id IN ('.$in_query.') or user_init_id=:id');

            $paramss=array(':id' => $id);
            $stmt->execute(array_merge($vv,$paramss));

            
            
      
        $max = $stmt->fetch(PDO::FETCH_NUM);



        $max_id=$max[0];
        //echo $max_id;
    }


    else if ($priv_val == "1") {


        $stmt = $dbConnection->prepare("SELECT max(last_update) from tickets where ((user_to_id=:id) or (user_to_id=:tid and unit_id IN (".$in_query."))) or user_init_id=:id2");
        
        
        $paramss=array(':id' => $id, ':tid' => '0', ':id2' => $id);
        $stmt->execute(array_merge($vv,$paramss));
        
        
        $max = $stmt->fetch(PDO::FETCH_NUM);



        $max_id=$max[0];



    }

    else if ($priv_val == "2") {




        $stmt = $dbConnection->prepare("SELECT max(last_update) from tickets;");
        $stmt->execute();
        $max = $stmt->fetch(PDO::FETCH_NUM);



        $max_id=$max[0];



    }
    return $max_id;
}

function get_who_last_action_ticket($ticket_id) {
    global $dbConnection;

    $stmt = $dbConnection->prepare('select init_user_id from ticket_log where ticket_id=:ticket_id order by date_op DESC limit 1');
    $stmt->execute(array(':ticket_id' => $ticket_id));
    $fio = $stmt->fetch(PDO::FETCH_ASSOC);

    $r=$fio['init_user_id'];
    return $r;
}

function get_last_action_type($ticket_id) {
    global $dbConnection;

    $stmt = $dbConnection->prepare('select date_op, msg, init_user_id, to_user_id, to_unit_id from ticket_log where ticket_id=:ticket_id order by date_op DESC limit 1');
    $stmt->execute(array(':ticket_id' => $ticket_id));
    $fio = $stmt->fetch(PDO::FETCH_ASSOC);



    $r=$fio['msg'];
    return $r;
}
function get_last_action_ticket($ticket_id) {
    global $dbConnection;

    $stmt = $dbConnection->prepare('select date_op, msg, init_user_id, to_user_id, to_unit_id from ticket_log where ticket_id=:ticket_id order by date_op DESC limit 1');
    $stmt->execute(array(':ticket_id' => $ticket_id));
    $fio = $stmt->fetch(PDO::FETCH_ASSOC);



    $r=$fio['msg'];
    $uss=nameshort(name_of_user_ret($fio['init_user_id']));
    $uss_to=nameshort(name_of_user_ret($fio['to_user_id']));
    $unit_to=get_unit_name_return4news($fio['to_unit_id']);
    if ($r=='refer') {$red='<i class=\'fa fa-long-arrow-right\'></i> '.lang('TICKET_ACTION_refer').' <em>'.$uss.'</em> '.lang('TICKET_ACTION_refer_to').' '.$unit_to.' '.$uss_to;}
    if ($r=='ok') {$red='<i class=\'fa fa-check-circle-o\'></i> '.lang('TICKET_ACTION_ok').' <em>'.$uss.'</em>';}
    if ($r=='no_ok') {$red='<i class=\'fa fa-circle-o\'></i> '.lang('TICKET_ACTION_nook').' <em>'.$uss.'</em>';}
    if ($r=='lock') {$red='<i class=\'fa fa-lock\'></i> '.lang('TICKET_ACTION_lock').' <em>'.$uss.'</em>';}
    if ($r=='unlock') {$red='<i class=\'fa fa-unlock\'></i> '.lang('TICKET_ACTION_unlock').' <em>'.$uss.'</em>';}
    if ($r=='create') {$red='<i class=\'fa fa-star-o\'></i> '.lang('TICKET_ACTION_create').' <em>'.$uss.'</em>';}
    if ($r=='edit_msg') {$red='<i class=\'fa fa-pencil-square\'></i> '.lang('TICKET_ACTION_edit').' <em>'.$uss.'</em>';}
    if ($r=='edit_subj') {$red='<i class=\'fa fa-pencil-square\'></i> '.lang('TICKET_ACTION_edit').' <em>'.$uss.'</em>';}
    if ($r=='comment') {$red='<i class=\'fa fa-comment\'></i> '.lang('TICKET_ACTION_comment').'<br>'. '<em>'.$uss.'</em>';}
    if ($r == 'arch') {$red='<i class=\'fa fa-archive\'></i> '.lang('TICKET_ACTION_arch').'';}
    return $red;
}

function get_last_ticket($menu, $id) {
    global $dbConnection;




    if ($menu == "all") {
        $unit_user=unit_of_user($id);
        $priv_val=priv_status($id);

		$ee=explode(",", $unit_user);
		foreach($ee as $key=>$value) {$in_query = $in_query . ' :val_' . $key . ', '; }
		$in_query = substr($in_query, 0, -2);
		foreach ($ee as $key=>$value) { $vv[":val_" . $key]=$value;}

        if ($priv_val == "0") {


            $stmt = $dbConnection->prepare('SELECT max(last_update) from tickets where unit_id IN ('.$in_query.') or user_init_id=:id');
            $paramss=array(':id' => $id);
            $stmt->execute(array_merge($vv,$paramss));
            $max = $stmt->fetch(PDO::FETCH_NUM);
			$max_id=$max[0];
        }


        else if ($priv_val == "1") {
			$stmt = $dbConnection->prepare("SELECT max(last_update) from tickets where (
			(user_to_id=:id) or (user_to_id=:tid and unit_id IN (".$in_query."))
			) or user_init_id=:id2");
            $paramss=array(':id' => $id, ':tid' => '0', ':id2' => $id);
            $stmt->execute(array_merge($vv,$paramss));
            
            $max = $stmt->fetch(PDO::FETCH_NUM);
			$max_id=$max[0];



        }
        else if ($priv_val == "2") {


            $stmt = $dbConnection->prepare("SELECT max(last_update) from tickets");
            $stmt->execute();
            $max = $stmt->fetch(PDO::FETCH_NUM);

            $max_id=$max[0];

        }
    }
    else if ($menu == "in") {



        $unit_user=unit_of_user($id);
        $priv_val=priv_status($id);
        $units = explode(",", $unit_user);
        $units = implode("', '", $units);
$ee=explode(",", $unit_user);
foreach($ee as $key=>$value) {$in_query = $in_query . ' :val_' . $key . ', '; }
$in_query = substr($in_query, 0, -2);
foreach ($ee as $key=>$value) { $vv[":val_" . $key]=$value;}

        
        
        if ($priv_val == "0") {



            $stmt = $dbConnection->prepare("SELECT max(last_update) from tickets where unit_id IN (".$in_query.") and arch='0'");
            //$stmt->execute(array(':units' => $units));
			$stmt->execute($vv);
            
            
            $max = $stmt->fetch(PDO::FETCH_NUM);



            $max_id=$max[0];

        }


        else if ($priv_val == "1") {




            $stmt = $dbConnection->prepare("SELECT max(last_update) from tickets where ((user_to_id=:id and arch='0') or (user_to_id='0' and unit_id IN (".$in_query.") and arch='0'))");
            
            $paramss=array(':id' => $id);
            $stmt->execute(array_merge($vv,$paramss));
            
           
            $max = $stmt->fetch(PDO::FETCH_NUM);


            $max_id=$max[0];



        }
        else if ($priv_val == "2") {


            $stmt = $dbConnection->prepare("SELECT max(last_update) from tickets where arch='0'");
            $stmt->execute();
            $max = $stmt->fetch(PDO::FETCH_NUM);

            $max_id=$max[0];

        }




    }
    else if ($menu == "out") {





        $stmt = $dbConnection->prepare("SELECT max(last_update) from tickets where user_init_id=:id and arch='0'");
        $stmt->execute(array(':id' => $id));
        $max = $stmt->fetch(PDO::FETCH_NUM);


        $max_id=$max[0];
    }
    else if ($menu == "arch") {




        $unit_user=unit_of_user($id);
        $priv_val=priv_status($id);

        
$ee=explode(",", $unit_user);
$s=1;
foreach($ee as $key=>$value) { $in_query = $in_query . ' :val_' . $key . ', '; $s++; }
$c=($s-1);
foreach($ee as $key=>$value) {$in_query2 = $in_query2 . ' :val_' . ($c+$key) . ', '; }
$in_query = substr($in_query, 0, -2);
$in_query2 = substr($in_query2, 0, -2);
foreach ($ee as $key=>$value) { $vv[":val_" . $key]=$value;}        
 foreach ($ee as $key=>$value) { $vv2[":val_" . ($c+$key)]=$value;} 
        
        if ($priv_val == "0") {

            $stmt = $dbConnection->prepare("SELECT max(last_update) from tickets where unit_id IN (".$in_query.") and arch='1'");
            
            //$stmt->execute(array(':units' => $units));
            $stmt->execute($vv);
            $max = $stmt->fetch(PDO::FETCH_NUM);

            $max_id=$max[0];




        }


        else if ($priv_val == "1") {





            $stmt = $dbConnection->prepare("SELECT max(last_update) from tickets where 
            (user_to_id=:id and unit_id IN (".$in_query.") and arch='1')
             or
			(user_to_id='0' and unit_id IN (".$in_query2.") and arch='1')");
							
							
           
            
            
            $paramss=array(':id' => $id);
			$stmt->execute(array_merge($vv,$vv2,$paramss));
            
            
            $max = $stmt->fetch(PDO::FETCH_NUM);





            $max_id=$max[0];



        }
        else if ($priv_val == "2") {

            $stmt = $dbConnection->prepare("SELECT max(last_update) from tickets where arch='1'");
            $stmt->execute();
            $max = $stmt->fetch(PDO::FETCH_NUM);

            $max_id=$max[0];




        }









    }





    return $max_id;

}



function get_total_tickets_out() {

    global $dbConnection;
    $uid=$_SESSION['helpdesk_user_id'];
    $res = $dbConnection->prepare('SELECT count(*) from tickets where user_init_id=:uid');
    $res->execute(array(':uid' => $uid));
    $count = $res->fetch(PDO::FETCH_NUM);


    return $count[0];
}
function get_total_tickets_lock() {
    global $dbConnection;
    $uid=$_SESSION['helpdesk_user_id'];


    $res = $dbConnection->prepare("SELECT count(*) from tickets where lock_by=:uid and status='0'");
    $res->execute(array(':uid' => $uid));
    $count = $res->fetch(PDO::FETCH_NUM);
    return $count[0];
}
function get_total_tickets_ok() {
    global $dbConnection;

    $uid=$_SESSION['helpdesk_user_id'];
    $res = $dbConnection->prepare("SELECT count(*) from tickets where ok_by=:uid");
    $res->execute(array(':uid' => $uid));
    $count = $res->fetch(PDO::FETCH_NUM);



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

    $units = $unit_user;
    
    

$in_query="";
$unit_user=unit_of_user($uid);
$ee=explode(",", $unit_user);
foreach($ee as $key=>$value) {$in_query = $in_query . ' :val_' . $key . ', '; }
$in_query = substr($in_query, 0, -2);
foreach ($ee as $key=>$value) { $vv[":val_" . $key]=$value;}




    if ($priv_val == "0") {


        $res = $dbConnection->prepare("SELECT count(*) from tickets where unit_id IN (".$in_query.") and status='0' and lock_by='0'");
        
        
        //$res->execute(array(':units' => $units));
        $res->execute($vv);
        $count = $res->fetch(PDO::FETCH_NUM);
        $count=$count[0];


    }


    else if ($priv_val == "1") {

        $res = $dbConnection->prepare("SELECT count(*) from tickets where ((user_to_id=:uid and arch='0') or (user_to_id='0' and unit_id IN (".$in_query.") and arch='0')) and status='0' and lock_by='0'");
        
        
        //$res->execute(array(':uid' => $uid));
        
        $paramss=array(':uid' => $uid);
        $res->execute(array_merge($vv,$paramss));
        $count = $res->fetch(PDO::FETCH_NUM);
        $count=$count[0];





    }
    else if ($priv_val == "2") {



        $res = $dbConnection->prepare("SELECT count(*) from tickets where status='0' and lock_by='0'");
        $res->execute();
        $count = $res->fetch(PDO::FETCH_NUM);
        $count=$count[0];

    }

    return $count;
}


function get_dashboard_msg(){
    global $dbConnection;
    $mid=$_SESSION['helpdesk_user_id'];

    $stmt = $dbConnection->prepare('SELECT messages from users where id=:mid');
    $stmt->execute(array(':mid' => $mid));
    
    //$max = $stmt->fetch(PDO::FETCH_ASSOC);
	$res1 = $stmt->fetchAll();


    
    if (isset($res1['messages'])) {$max_id=$res1['messages'];}
    else {$max_id="";}
    
    
    $length = strlen(utf8_decode($max_id));
    if ($length < 1) {$ress=lang('DASHBOARD_def_msg');} else {$ress=$max_id;}
    return $ress;
}
function get_myname(){
    $uid=$_SESSION['helpdesk_user_id'];
	$nu=name_of_user_ret($uid);
	$length = strlen(utf8_decode($nu));

	if ($length > 2) {$n=explode(" ", name_of_user_ret($uid)); $t=$n[1]." ".$n[2];}
	else if ($length <= 2) {$t="";}
    //$n=explode(" ", name_of_user_ret($uid));
    return $t;
}
function get_total_pages_workers() {
    global $dbConnection;
    $perpage='10';

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

function get_approve() {
global $dbConnection;
	        $stmt = $dbConnection->prepare('select count(id) as t1 from approved_info ');
            $stmt->execute();
            $total_ticket = $stmt->fetch(PDO::FETCH_ASSOC);


            return $total_ticket['t1'];
}

function get_total_pages($menu, $id) {

    global $dbConnection;
    $perpage='10';
    
    
    
    
    if ($menu == "in") {
$perpage='10';
if (isset($_SESSION['hd.rustem_list_in'])) {
	      $perpage=  $_SESSION['hd.rustem_list_in'];
        }

        $unit_user=unit_of_user($id);
        $priv_val=priv_status($id);
        $units = explode(",", $unit_user);
        $units = implode("', '", $units);


$ee=explode(",", $unit_user);
foreach($ee as $key=>$value) {$in_query = $in_query . ' :val_' . $key . ', '; }
$in_query = substr($in_query, 0, -2);
foreach ($ee as $key=>$value) { $vv[":val_" . $key]=$value;}

        if ($priv_val == "0") {
            $res = $dbConnection->prepare("SELECT count(*) from tickets where unit_id IN (".$in_query.") and arch='0'");
            
            $res->execute($vv);
            $count = $res->fetch(PDO::FETCH_NUM);
            $count=$count[0];


        }


        else if ($priv_val == "1") {

            $res = $dbConnection->prepare("SELECT count(*) from tickets where ((user_to_id=:id and arch='0') or (user_to_id='0' and unit_id IN (".$in_query.") and arch='0'))");
            
            $paramss=array(':id' => $id);
            $res->execute(array_merge($vv,$paramss));
            $count = $res->fetch(PDO::FETCH_NUM);
            $count=$count[0];

        }
        else if ($priv_val == "2") {


            $res = $dbConnection->prepare("SELECT count(*) from tickets where arch='0'");
            $res->execute();
            $count = $res->fetch(PDO::FETCH_NUM);
            $count=$count[0];

        }



    }
    if ($menu == "out") {
$perpage='10';
if (isset($_SESSION['hd.rustem_list_out'])) {
	      $perpage=  $_SESSION['hd.rustem_list_out'];
        }
        $res = $dbConnection->prepare("SELECT count(*) from tickets where user_init_id=:id and arch='0'");
        $res->execute(array(':id' => $id));
        $count = $res->fetch(PDO::FETCH_NUM);
        $count=$count[0];

    }
    if ($menu == "arch") {
$perpage='10';
if (isset($_SESSION['hd.rustem_list_arch'])) {
	      $perpage=  $_SESSION['hd.rustem_list_arch'];
        }



        $unit_user=unit_of_user($id);
        $priv_val=priv_status($id);
        $units = explode(",", $unit_user);
        $units = implode("', '", $units);

$ee=explode(",", $unit_user);
$s=1;
foreach($ee as $key=>$value) { $in_query = $in_query . ' :val_' . $key . ', '; $s++; }
$c=($s-1);
foreach($ee as $key=>$value) {$in_query2 = $in_query2 . ' :val_' . ($c+$key) . ', '; }
$in_query = substr($in_query, 0, -2);
$in_query2 = substr($in_query2, 0, -2);
foreach ($ee as $key=>$value) { $vv[":val_" . $key]=$value;}        
 foreach ($ee as $key=>$value) { $vv2[":val_" . ($c+$key)]=$value;} 
 

        if ($priv_val == "0") {


            $res = $dbConnection->prepare("SELECT count(*) from tickets where (unit_id IN (".$in_query.") or user_init_id=:id) and arch='1'");
            
            $paramss=array(':id' => $id);
            $res->execute(array_merge($vv,$paramss));
            $count = $res->fetch(PDO::FETCH_NUM);
            $count=$count[0];
        }


        else if ($priv_val == "1") {


            $res = $dbConnection->prepare("SELECT count(*) from tickets
							where (user_to_id=:id and unit_id IN (".$in_query.") and arch='1') or
							(user_to_id='0' and unit_id IN (".$in_query2.") and arch='1') or
							(user_init_id=:id2 and arch='1')");

            $paramss=array(':id' => $id,':id2' => $id);
            $res->execute(array_merge($vv,$vv2,$paramss));
            $count = $res->fetch(PDO::FETCH_NUM);
            $count=$count[0];



        }
        else if ($priv_val == "2") {


            $res = $dbConnection->prepare("SELECT count(*) from tickets where arch='1'");

            $res->execute();
            $count = $res->fetch(PDO::FETCH_NUM);
            $count=$count[0];



        }








    }

    if ($menu == "client") {

        $res = $dbConnection->prepare("SELECT count(*) from clients");

        $res->execute();
        $count = $res->fetch(PDO::FETCH_NUM);
        $count=$count[0];


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
    global $dbConnection;

    $stmt = $dbConnection->prepare('SELECT fio FROM clients where id=:input');
    $stmt->execute(array(':input' => $input));
    $fio = $stmt->fetch(PDO::FETCH_ASSOC);


    echo($fio['fio']);

}
function name_of_client_ret($input) {
    global $dbConnection;

    $stmt = $dbConnection->prepare('SELECT fio FROM clients where id=:input');
    $stmt->execute(array(':input' => $input));
    $fio = $stmt->fetch(PDO::FETCH_ASSOC);

    return $fio['fio'];

}






function time_ago($in) {
    $time = $in;
    $datetime1 = date_create($time);
    $datetime2 = date_create('now',new DateTimeZone('Europe/Kiev'));
    $interval = date_diff($datetime1, $datetime2);
    echo $interval->format('%d д %h:%I');

}







function humanTiming_period ($time1, $time_ago)
{
   

    $time = (strtotime($time_ago) - strtotime($time1)); // to get the time since that moment

    

    return $time;
}




function humanTiming_old ($time)
{

    $time = time() - $time;

    return floor($time/86400);
}




function get_unit_name($input) {
    global $dbConnection;

    $u=explode(",", $input);

    foreach ($u as $val) {
        $stmt = $dbConnection->prepare('SELECT name FROM deps where id=:val');
        $stmt->execute(array(':val' => $val));
        $dep = $stmt->fetch(PDO::FETCH_ASSOC);



        $res.=$dep['name'];
        $res.="<br>";
    }

    echo $res;
}

function name_of_user($input) {
    global $dbConnection;

    $stmt = $dbConnection->prepare('SELECT fio FROM users where id=:input');
    $stmt->execute(array(':input' => $input));
    $fio = $stmt->fetch(PDO::FETCH_ASSOC);

    echo($fio['fio']);
}

function name_of_user_ret($input) {
    global $dbConnection;


    $stmt = $dbConnection->prepare('SELECT fio FROM users where id=:input');
    $stmt->execute(array(':input' => $input));
    $fio = $stmt->fetch(PDO::FETCH_ASSOC);


    return($fio['fio']);
}

function unit_of_user($input) {
    global $dbConnection;

    $stmt = $dbConnection->prepare('SELECT unit FROM users where id=:input');
    $stmt->execute(array(':input' => $input));
    $fio = $stmt->fetch(PDO::FETCH_ASSOC);

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
    global $dbConnection;
    $stmt = $dbConnection->prepare('select date_op from ticket_log where ticket_id=:id and msg=:ok order by date_op DESC');
    $stmt->execute(array(':id' => $id, ':ok' => 'ok'));
    $total_ticket = $stmt->fetch(PDO::FETCH_ASSOC);



    $tt=$total_ticket['date_op'];

    return $tt;
}
?>
