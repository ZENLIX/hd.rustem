<?php
session_start();
include("functions.inc.php");
if ( isset($_POST['mode']) ) {

    $mode=($_POST['mode']);

if ($mode == "get_host_conf") {

print($CONF['hostname']);
}

if ($mode == "get_lang_param") {
$p=($_POST['param']);
$r=lang($p);
print($r);
}


    if ($mode == "activate_login") {
        $mailadr=($_POST['mailadress']);
        $query="SELECT id, fio,login,status FROM users where email='$mailadr';";
        $res = mysql_query($query) or die(mysql_error());

        if(mysql_num_rows($res)>0) {

            $r= mysql_fetch_assoc( $res );

            if ($r['status'] == "0") {

                $l=$r['login'];
                $fio=$r['fio'];
                $id=$r['id'];

                $pass=randomPassword();

                mailtoactivate($l, $mailadr, $pass);
                mailtoactivate_admin($l, $mailadr, $pass);

                $npass=md5($pass);
                $query_update_client= "update users set pass='$npass', status='1' where id='$id'";
                mysql_query ( $query_update_client )or die(mysql_error());

                ?>
                <div class="alert alert-success">
                    <center><?=lang('CREATE_ACC_success');?>
                    </center>
                </div>
            <?php
            }
            else if ($r['status'] == "1") {

                ?>
                <div class="alert alert-danger">
                    <center><?=lang('CREATE_ACC_already');?>
                    </center>
                </div>
            <?php

            }


        }
        else {
            ?>
            <div class="alert alert-danger">
                <center><?=lang('CREATE_ACC_error');?>
                </center>
            </div>
        <?php
        }
        ?>
        <center><img src="img/help-desk-icon.png"><h2 class="text-muted"><?=lang('MAIN_TITLE');?></h2><small class="text-muted"><?=lang('AUTH_USER');?></small></center><br>
        <input type="text" name="login" autocomplete="off" class="form-control" placeholder="<?=lang('login');?>">
        <input type="password" name="password" class="form-control" placeholder="<?=lang('pass');?>">
        <div style="padding-left:75px;">
            <div class="checkbox">
                <label>
                    <input id="mc" name="remember_me" value="1" type="checkbox"> <?=lang('remember_me');?>
                </label>
            </div>
        </div>
        <?php if ($va == 'error') { ?>
            <div class="alert alert-danger">
                <center><?=lang('error_auth');?></center>
            </div> <?php } ?>
        <input type="hidden" name="req_url" value="/index.php">
        <button class="btn btn-lg btn-primary btn-block"> <i class="fa fa-sign-in"></i>  <?=lang('log_in');?></button>

        <!hr style=" margin: 10px; ">
        <small>
            <center style=" margin-bottom: -20px; "><br><a href="#" id="show_activate_form"><?=lang('first_in_auth');?>.</a>
            </center>
        </small>

    <?php

    }
    if ($mode == "activate_login_form") {
        ?>
        <center><img src="img/help-desk-icon.png"><h2 class="text-muted"><?=lang('MAIN_TITLE');?></h2><small class="text-danger"><?=lang('user_auth');?></small></center><br>
        <input type="text" id="mailadress" name="login" autocomplete="off" class="form-control" placeholder="<?=lang('work_mail');?>">
        <p class="help-block"><small><?=lang('work_mail_ph');?></small></p>
        <div style="padding-left:75px;">
        </div>
        <br>
        <button id="do_activate" type="submit" class="btn btn-lg btn-success btn-block"> <i class="fa fa-check-circle-o"></i>  <?=lang('action_auth');?></button>

        <!hr style=" margin: 10px; ">




    <?php
    }









    if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {


		if ($mode == "get_list_notes") {
		$userid=$_SESSION['helpdesk_user_id'];
		
		
		$stmt = $dbConnection->prepare('SELECT id, hashname, message from notes where user_id=:userid order by dt DESC');
	$stmt->execute(array(':userid' => $userid));
	$res = $stmt->fetchAll();
		
		
		
		//$query="SELECT id, hashname, message from notes where user_id='$userid' order by dt DESC";
        //  $res = mysql_query($query) or die(mysql_error());
?>
    <table class="table table-hover" style="margin-bottom: 0px;" id="table_list">
  

<?php
if (empty($res)) {
			echo lang('empty');
		}
else if (!empty($res)) {
		//while ($row = mysql_fetch_assoc($res)) 
		foreach($res as $row) {
		
		
		$t_msg=cutstr_ret(strip_tags($row['message']));
		
		if (strlen($t_msg) < 2){$t_msg="<em>".lang('NOTES_single')."</em>";}
		
			?>
			  <tr class="tr_<?=$row['id'];?>"><td style="width:90%"><a style=" cursor: pointer; " id="to_notes" value="<?=$row['hashname'];?>"><?=$t_msg;?></a></td><td><button id="del_notes" value="<?=$row['hashname'];?>" type="button" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-trash"></i></button></td></tr>
			<?php
		}
		?></table><?php
		}
		}
		
		if ($mode == "save_notes") {
		$noteid=($_POST['hn']);
		$message=($_POST['msg']);
		$message = str_replace("\r\n", "\n", $message);
		$message = str_replace("\r", "\n", $message);
		$message = str_replace("&nbsp;", " ", $message);
		
		
		
		//$query="update notes set message='$message', dt=now() where hashname='$noteid'";
		//mysql_query($query)or die(mysql_error());
		
		$stmt = $dbConnection->prepare('update notes set message=:message, dt=now() where hashname=:noteid');
		$stmt->execute(array(':message' => $message, ':noteid' => $noteid));

		
		print_r ($_POST['msg']);
		}
		
	
	
	if ($mode == "get_first_note") {
		$noteid=($_POST['hn']);
		$uid=$_SESSION['helpdesk_user_id'];
		
		
		
		//$query="select hashname, message from notes where user_id='$uid' order by dt DESC limit 1";
		$stmt = $dbConnection->prepare('select hashname, message from notes where user_id=:uid order by dt DESC limit 1');
		$stmt->execute(array(':uid' => $uid));
		
        //mysql_query($query);
        $res = $stmt->fetchAll();
        //$res = mysql_query($query) or die(mysql_error());
        
        //if (mysql_num_rows($res) == 0) {
        if (empty($res)) {
        echo "no";
        
        }
        else if (!empty($res)) {
        //if (mysql_num_rows($res) > 0) {
        //while ($row = mysql_fetch_assoc($res)) {
			foreach($res as $row) {
        echo $row['message'];
        }
        }
        
        
		}
		
		
		if ($mode == "get_notes") {
		$noteid=($_POST['hn']);
		
		$stmt = $dbConnection->prepare('select hashname, message from notes where hashname=:noteid');
		$stmt->execute(array(':noteid' => $noteid));
		$res = $stmt->fetchAll();
		
		//$query="select hashname, message from notes where hashname='$noteid'";
        //mysql_query($query);
        //$res = mysql_query($query) or die(mysql_error());
        //while ($row = mysql_fetch_assoc($res)) {
		foreach($res as $row) {
        echo $row['message'];

        }
		}
		/*
		if ($mode == "del_user") {
		$noteid=$_POST['nid'];
		$query_comment="delete from comments where id='$noteid'";
        mysql_query($query_comment);
        $query_users="delete from users where id='$noteid'";
        mysql_query($query_users);
		}
		*/
		
		if ($mode == "del_notes") {
		$noteid=($_POST['nid']);
		$stmt = $dbConnection->prepare('delete from notes where hashname=:noteid');
		$stmt->execute(array(':noteid' => $noteid));

		//$query="delete from notes where hashname='$noteid'";
        //mysql_query($query);
		}
		
		if ($mode == "create_notes") {
		$uid=$_SESSION['helpdesk_user_id'];
		$hn=md5(time());
		$stmt = $dbConnection->prepare('insert into notes (message, hashname, user_id, dt) values (:nr, :hn, :uid, now())');
		$stmt->execute(array(':nr' => 'new record', ':hn'=> $hn, ':uid'=>$uid));

		//$query="insert into notes (message, hashname, user_id, dt) values ('new record', '$hn', '$uid', now());";
        //mysql_query($query)or die(mysql_error());
        echo $hn;
		}
		



if ($mode == "get_client_from_new_t") {
if (isset($_POST['get_client_info'])) {

    $client_id=($_POST['get_client_info']);



    //include("functions.inc.php");
    get_client_info($client_id);



}
if (isset($_POST['new_client_info'])) {
    $fio=($_POST['new_client_info']);
    $u_l=($_POST['new_client_login']);
    //include("functions.inc.php");
    ?>


    <div id="" class="alert alert-warning alert-dismissable" style="padding: 5px; margin-bottom: 10px;">
        <button style="right: 0px;" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <small>
            <?=lang('msg_created_new_user');?> <br></small>
    </div>
    <div class="panel panel-success" id="user_info" style="display: block;">
        <div class="panel-body">
            <div class="panel-heading">
                <h4 class="panel-title"><i class="fa fa-user"></i> <?=lang('WORKER_TITLE');?></h4>
            </div>
            <div class="panel-body">




                <table class="table  ">
                    <tbody>
                    <tr>
                        <td style=" width: 30px; "><small><?=lang('WORKER_fio');?>:</small></td>
                        <td><small>
                                <a href="#" id="username" data-type="text" data-pk="1" data-title="Enter username"><?=$fio?></a>
                            </small>
                        </td>
                    </tr>
                    <tr>
                        <td style=" width: 30px; "><small><?=lang('WORKER_login');?>:</small></td>
                        <td><small><a href="#" id="new_login" data-type="text"  data-pk="1" data-title="Enter username"><?=$u_l?></a></small></td>
                    </tr>
                    <tr>
                        <td style=" width: 30px; "><small><?=lang('WORKER_posada');?>:</small></td>
                        <td><small><a href="#" id="new_posada"  data-type="select" data-source="<?=$CONF['hostname'];?>/json.php?posada" data-pk="1" data-title="<?=lang('WORKER_posada');?>"></a></small></td>
                    </tr>
                    <tr>
                        <td style=" width: 30px; "><small><?=lang('WORKER_unit');?>:</small></td>
                        <td><small><a href="#" id="new_unit" data-type="select" data-source="<?=$CONF['hostname'];?>/json.php?units" data-pk="1" data-title="<?=lang('NEW_unit');?>"></a></small></td>
                    </tr>

                    <tr>
                        <td style=" width: 30px; "><small><?=lang('WORKER_tel');?>:</small></td>
                        <td><small><a href="#" id="new_tel" data-type="text" data-pk="1" data-title="Enter username"></a></small></td>
                    </tr>
                    <tr>
                        <td style=" width: 30px; "><small><?=lang('WORKER_room');?>:</small></td>
                        <td><small><a href="#" id="new_adr" data-type="text" data-pk="1" data-title="Enter username"></a></small></td>
                    </tr>
                    <tr>
                        <td style=" width: 30px; "><small><?=lang('WORKER_mail');?>:</small></td>
                        <td><small><a href="#" id="new_mail" data-type="text" data-pk="1" data-title="Enter username"></a></small></td>
                    </tr>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
<?php
}

}






////////////////////////////////////////////////////////////////////////////////////////////////////
        if ($mode == "get_report") {
            $id=($_POST['id']);
            $s=($_POST['s']);
            $e=($_POST['e']);



            $query="SELECT id, date_op, msg, init_user_id,to_user_id,to_unit_id,ticket_id from ticket_log where (date_op between '$s' AND '$e') and (msg='create' or msg='refer') and to_user_id='$id'";
            $res = mysql_query($query) or die(mysql_error());
            $user_to_id=0;
            //$user_ok_by=0;
            while ($row = mysql_fetch_assoc($res)) {
                $user_to_id=$user_to_id+1;
                $tid=$row['id'];
                
                	$q="SELECT id from ticket_log where msg='refer' and ticket_id='$tid' and init_user_id='$id' group by ticket_id";
					$r=mysql_query($q) or die(mysql_error());
					$user_refer=0;
					while ($rowq = mysql_fetch_assoc($r)) {
					$user_refer=$user_refer+1;
					}
					
					$q_ok="SELECT max(id) from ticket_log where msg='ok' and ticket_id='$tid' and init_user_id='$id' group by ticket_id";
					$r_ok=mysql_query($q_ok) or die(mysql_error());
					$user_ok=0;
					while ($row_ok = mysql_fetch_assoc($r_ok)) {
					$user_ok=$user_ok+1;
					}
					
					
					
            }
            
            $user_no_ok=$user_to_id-$user_ok;
            
            $uid=$_SESSION['helpdesk_user_id'];
            $unit_user=unit_of_user($uid);
            $units = explode(",", $unit_user);
            $units = "'". implode("', '", $units) ."'";
            
            
			$q_unit="SELECT id, date_op, msg, init_user_id,to_user_id,to_unit_id,ticket_id from ticket_log where (date_op between '$s' AND '$e') and (msg='create' or msg='refer') and to_user_id='0' and to_unit_id IN (".$units.")";
			$res_unit = mysql_query($q_unit) or die(mysql_error());
			$user_unit=0;
			while ($row_unit = mysql_fetch_assoc($res_unit)) {
					$user_unit=$user_unit+1;
					
					
					$user_unit_ok=0;
					$q_unit_ok="select max(id) from ticket_log where msg='ok' and ticket_id='$tid' and init_user_id='$id' group by ticket_id";
					$res_unit_ok = mysql_query($q_unit_ok) or die(mysql_error());
					while ($row_unit_ok = mysql_fetch_assoc($res_unit_ok)) {
					$user_unit_ok=$user_unit_ok+1;
					}
					}
			

            ?>
            результат за перiод <?=$s."-".$e;?>
            <br>
            Всього заявок надійшло до користувача <?=$user_to_id?> <br>
            	З них переадресовано<?=$user_refer?><br>
				Виконано користувачем <?=$user_ok?><br>
				Не виконано користувачем<?=$user_no_ok?><br>
            <br>
            Всього заявок надійшло на відділ користувача <?=$user_unit?><br>
            	З них користувач виконав <?=$user_unit_ok?>
<hr>

        <?php
        
        
                    $query="SELECT id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update from tickets where (date_create between '$s' AND '$e') and user_init_id='$id'";
            $res = mysql_query($query) or die(mysql_error());
            $user_to_id=0;
            //$user_ok_by=0;
            ?>
<table class="table table-bordered table-hover" style=" font-size: 14px; ">
            <thead>
            <tr>
                <th><center>#</center></th>
                <th><center><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="<?=lang('t_LIST_prio');?>"></i></center></th>
                <th><center><?=lang('t_LIST_subj');?></center></th>
                <th><center><?=lang('t_LIST_worker');?></center></th>
                <th><center><?=lang('t_LIST_create');?></center></th>
                <th><center><?=lang('t_LIST_ago');?></center></th>
                <th><center><?=lang('t_LIST_init');?></center></th>
                <th><center><?=lang('t_LIST_to');?></center></th>
                <th><center><?=lang('t_LIST_status');?></center></th>
                <th style="width:60px;"><center><?=lang('t_LIST_action');?></center></th>
            </tr>
            </thead>
            <tbody>

            <?php
            //if (mysql_num_rows($results) > 0) {
            while ($row = mysql_fetch_assoc($res)) {

                $lb=$row['lock_by'];
                $ob=$row['ok_by'];


                $user_id_z=$_SESSION['helpdesk_user_id'];
                $unit_user_z=unit_of_user($user_id_z);
                $status_ok_z=$row['status'];
                $ok_by_z=$row['ok_by'];
                $lock_by_z=$row['lock_by'];



                $lo="no";

                if (priv_status($user_id) == "0") {
                    $u=explode(",",$unit_user_z);

                    if (in_array($row['unit_id'], $u)) {$lo="yes";}
                    if ($row['user_init_id'] == $user_id_z) {$lo="yes";}
                    if ($row['user_to_id'] == $user_id) {$lo="yes";}
                }
                else if (priv_status($user_id) == "2") {
                    if ($row['unit_id'] == $unit_user_z) {$lo="yes";}
                    if ($row['user_init_id'] == $user_id_z) {$lo="yes";}
                    if ($row['user_to_id'] == $user_id) {$lo="yes";}
                }



                else if (priv_status($user_id) == "1") {

                    $u=explode(",",$unit_user_z);
                    //print_r ($u);
                    // ЗАявка не выполнена ИЛИ выполнена мной
                    if (($status_ok_z == 0) || (($status_ok_z == 1) && ($ok_by_z == $user_id_z)))
                    {
                        //echo "ЗАявка не выполнена ИЛИ выполнена мной"."<br>";

                        //ЗАявка не заблокирована ИЛИ заблокирована мной
                        if (($lock_by_z == 0) || ($lock_by_z == $user_id_z)) {
                            //echo "ЗАявка не заблокирована ИЛИ заблокирована мной"."<br>";


                            // ЗАявка моего отдела ВСЕМ
                            if ((in_array($row['unit_id'], $u)) && ($row['user_to_id'] == "0")) {

                                //if (($row['unit_id'] == $unit_user_z) && ($row['user_to_id'] == "0")) {
                                //echo "ЗАявка моего отдела ВСЕМ"."<br>";
                                $lo="yes";
                            }

                            // Заявка мне
                            if ($row['user_to_id'] == $user_id_z) {
                                //echo "ЗАявка мне"."<br>";
                                $lo="yes";
                            }

                            //инициатор заявки я
                            if ($row['user_init_id'] == $user_id_z) {
                                //echo "инициатор заявки я"."<br>";
                                $lo="yes";
                                //echo "f";
                            }
                        }
                        //инициатор заявки я
                        if ($row['user_init_id'] == $user_id_z) {
                            //echo "инициатор заявки я"."<br>";
                            $lo="yes";
                            //echo "f";
                        }
                    }






                }






//echo $lo;
                if ($lo == "yes") {$lock_st=""; $muclass="";}
                if ($lo == "no") {$lock_st="disabled=\"disabled\""; $muclass="text-muted";}














                if ($row['is_read'] == "0") {

                    $style="bold_for_new";

                    if ($row['status'] == "1") {
                        $ob_text="<i class=\"fa fa-check-circle-o\"></i>";
                        $ob_status="unok";
                        $ob_tooltip=lang('t_list_a_nook');
                        $style="success";

                        if ($lb <> "0") {
                            $lb_text="<i class=\"fa fa-lock\"></i>";
                            $lb_status="unlock";
                            $lb_tooltip=lang('t_list_a_unlock');
                        }
                        if ($lb == "0") {
                            $lb_text="<i class=\"fa fa-unlock\"></i>";
                            $lb_status="lock";
                            $lb_tooltip=lang('t_list_a_lock');
                        }


                    }

                    if ($row['status'] == "0") {
                        $ob_text="<i class=\"fa fa-circle-o\"></i>";
                        $ob_status="ok";
                        $ob_tooltip=lang('t_list_a_ok');
                        if ($lb <> "0") {
                            $lb_text="<i class=\"fa fa-lock\"></i>";
                            $lb_status="unlock";
                            $lb_tooltip=lang('t_list_a_unlock');
                            if ($lb == $user_id) {$style="warning";}
                            if ($lb <> $user_id) {$style="active";}
                        }

                        if ($lb == "0") {
                            $lb_text="<i class=\"fa fa-unlock\"></i>";
                            $lb_status="lock";
                            $lb_tooltip=lang('t_list_a_lock');
                        }

                    }

                }

                if ($row['is_read'] <> "0") {

                    if ($row['status'] == "1") {
                        $ob_text="<i class=\"fa fa-check-circle-o\"></i>";
                        $ob_status="unok";
                        $style="success";
                        $ob_tooltip=lang('t_list_a_nook');
                        if ($lb <> "0") {
                            $lb_text="<i class=\"fa fa-lock\"></i>";
                            $lb_status="unlock";
                            $lb_tooltip=lang('t_list_a_unlock');
                        }
                        if ($lb == "0") {
                            $lb_text="<i class=\"fa fa-unlock\"></i>";
                            $lb_status="lock";
                            $lb_tooltip=lang('t_list_a_lock');
                        }
                    }
                    if ($row['status'] == "0") {
                        $ob_text="<i class=\"fa fa-circle-o\"></i>";
                        $ob_status="ok";
                        $ob_tooltip=lang('t_list_a_ok');
                        if ($lb <> "0") {
                            $lb_text="<i class=\"fa fa-lock\"></i>";
                            $lb_status="unlock";
                            $lb_tooltip=lang('t_list_a_unlock');
                            if ($lb == $user_id) {$style="warning";}
                            if ($lb <> $user_id) {$style="active";}
                        }
                        if ($lb == "0") {
                            $style="";
                            $lb_text="<i class=\"fa fa-unlock\"></i>";
                            $lb_status="lock";$lb_tooltip=lang('t_list_a_lock');

                        }

                    }
                }

                if ($row['user_to_id'] <> 0 ) {
                    $to_text="<div class=''>".nameshort(name_of_user_ret($row['user_to_id']))."</div>";
                }
                if ($row['user_to_id'] == 0 ) {
                    $to_text="<strong data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_unit_name_return($row['unit_id'])."\">".lang('t_list_a_all')."</strong>";
                }

                $prio="<span class=\"label label-info\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".lang('t_list_a_p_norm')."\"><i class=\"fa fa-minus\"></i></span>";

                if ($row['prio'] == "0") {$prio= "<span class=\"label label-primary\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".lang('t_list_a_p_low')."\"><i class=\"fa fa-arrow-down\"></i></span>"; }

                if ($row['prio'] == "2") {$prio= "<span class=\"label label-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".lang('t_list_a_p_high')."\"><i class=\"fa fa-arrow-up\"></i></span>"; }

                /*
                          if ($row['status'] == 1) {$st=  "<i class=\"fa fa-check-circle\"></i> виконано ".nameshort(name_of_user_ret($ob));} 
                          if ($row['status'] == 0) {
                              if ($lb <> 0) {
                                  if ($lb == $user_id) {$st=  "<i class=\"fa fa-gavel\"></i> працює ".nameshort(name_of_user_ret($lb));}
                                  if ($lb <> $user_id) {$st=  "<i class=\"fa fa-gavel\"></i> працює ".nameshort(name_of_user_ret($lb));}
                              
                              
                              }
                              if ($lb == 0) {$st=  "<i class=\"fa fa-clock-o\"></i> очікування дії";}
                          }
                    
                        
                        */



                if ($row['status'] == 1) {$st=  "<span class=\"label label-success\"><i class=\"fa fa-check-circle\"></i> ".lang('t_list_a_oko')." ".nameshort(name_of_user_ret($ob))."</span>";}
                if ($row['status'] == 0) {
                    if ($lb <> 0) {

                        if ($lb == $user_id) {$st=  "<span class=\"label label-warning\"><i class=\"fa fa-gavel\"></i> ".lang('t_list_a_lock_i')."</span>";}

                        if ($lb <> $user_id) {$st=  "<span class=\"label label-default\"><i class=\"fa fa-gavel\"></i> ".lang('t_list_a_lock_u')." ".nameshort(name_of_user_ret($lb))."</span>";}

                        //$st=$lb;

                    }
                    if ($lb == 0) {$st=  "<span class=\"label label-primary\"><i class=\"fa fa-clock-o\"></i> ".lang('t_list_a_hold')."</span>";}
                }
                ?>




                <tr id="tr_<?php echo $row['id']; ?>" class="<?=$style?>">
                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><center><?php echo $row['id']; ?></center></small></td>
                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><center><?=$prio?></center></small></td>
                    <td style=" vertical-align: middle; "><a class="<?=$muclass;?>" data-toggle="tooltip" data-placement="bottom" title="<?=$row['subj']?>" href="ticket.php?hash=<?php echo $row['hash_name']; ?>"><?php cutstr($row['subj']); ?></a></td>
                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><?php name_of_client($row['client_id']); ?></small></td>
                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><center><?php dt_format($row['date_create']); ?></center></small></td>
                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><center></center></small></td>

                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><?php echo nameshort(name_of_user_ret($row['user_init_id'])); ?></small></td>

                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>">
                            <?=$to_text?>
                        </small></td>
                    <td style=" vertical-align: middle; "><small><center>
                                <?=$st;?> </center>
                        </small></td>
                    <td style=" vertical-align: middle; ">
                        
                    </td>
                </tr>
            <?php
            }

            ?>
            </tbody>
            </table>
<?php
        
        
        
        
        
        
        
        
        
        
        
        }

////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////


        if ($mode == "get_unit_id") {
            $uid=($_POST['uid']);


            $u=unit_of_user($uid);
            $units = explode(",", $u);
            echo $units[0];

        }


        if ($mode == "get_ticket_body") {
        }

if ($mode == "update_dashboard_labels") {
            $results[] = array(
                'a' => get_total_tickets_free(),
                'b' => get_total_tickets_lock(),
                'c' => get_total_tickets_out_and_success()
            );
print json_encode($results);
}

if ($mode == "update_list_labels") {
$newt=get_total_tickets_free();

if ($newt != 0) {
	$newtickets="(".$newt.")";
}
if ($newt == 0) {
	$newtickets="";
}
$outt=get_total_tickets_out_and_success();
if ($outt != 0) {
	$out_tickets="(".$outt.")";
}
if ($outt == 0) {
	$out_tickets="";
}

            $results[] = array(
                'in' => $newtickets,
                'out' => $out_tickets
            );
print json_encode($results);
}
        if ($mode == "check_update_one") {
            $lu=($_POST['last_update']);
            $ticket_id=($_POST['id']);
            
            /*$query="SELECT last_update,hash_name FROM tickets where id='$ticket_id';";
            $res = mysql_query($query) or die(mysql_error());
            $fio= mysql_fetch_assoc( $res );
            */
    
    $stmt = $dbConnection->prepare('SELECT last_update,hash_name FROM tickets where id=:ticket_id');
	$stmt->execute(array(':ticket_id' => $ticket_id));
	$fio = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $db_lu=$fio['last_update'];
            $db_hn=$fio['hash_name'];
            $at=get_last_action_type($ticket_id);

            if (strtotime($db_lu) > strtotime($lu)) {
                if ($at == 'comment') {$todo="comment";

                } else { $todo="update";}}
            if (strtotime($db_lu) <= strtotime($lu)) {$todo= "no";}


            $results[] = array(
                'type' => $todo,
                'time' => $db_lu,
                'hash' => $db_hn
            );


            print json_encode($results);
        }
        
        
        
        if ($mode == "get_users_list") {
        $idzz=($_POST['unit']);
        
        //$qstring = "SELECT fio, id, unit FROM users;";
        //$result = mysql_query($qstring);
    
    $stmt = $dbConnection->prepare('SELECT fio, id, unit FROM users');
	$stmt->execute();
	$result = $stmt->fetchAll();
		
		
		$results[] = array(
                'name' => '',
                'co' => '0'
            );
            foreach($result as $row) {
		//while ($row = mysql_fetch_assoc($result)) {
		
        $un=$row['fio'];
        $ud=(int)$row['id'];
        $u=explode(",",$row['unit']);
		
		if (in_array($idzz, $u)) {
			$results[] = array(
                'name' => $un,
                'co' => $ud
            );


            
		}
		
		

        }

        print json_encode($results);
        }
        
        if ($mode == "edit_helper") {
        $hn=($_POST['hn']);
        
       /* $query="select id, user_init_id, unit_to_id, dt, title, message, hashname
							from helper
							where hashname='$hn';";
    $res = mysql_query($query) or die(mysql_error());
    $fio= mysql_fetch_assoc( $res );
    */
    
    
    $stmt = $dbConnection->prepare('select id, user_init_id, unit_to_id, dt, title, message, hashname from helper where hashname=:hn');
	$stmt->execute(array(':hn' => $hn));
	$fio = $stmt->fetch(PDO::FETCH_ASSOC);
	
	
    $u=$fio['unit_to_id'];
    

        ?>
        <form class="form-horizontal" role="form">
        



    <div class="form-group">
        <label for="u" class="col-md-2 control-label"><small><?=lang('NEW_to');?>: </small></label>
        <div class="col-md-6">
            <select data-placeholder="<?=lang('NEW_to_unit');?>" class="chosen-select form-control" id="u" name="unit_id" multiple>
                <?php
  						$u=explode(",", $u);
                        //$qstring = "SELECT name as label, id as value FROM deps;";
                        //$result = mysql_query($qstring);//query the database for entries containing the term

						$stmt = $dbConnection->prepare('SELECT name as label, id as value FROM deps');
						$stmt->execute();
						$result = $stmt->fetchAll();



                       // while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
                        foreach($result as $row) {
//echo($row['label']);
                            $row['label']=$row['label'];
                            $row['value']=(int)$row['value'];

$opt_sel='';
foreach ($u as $val) {
if ($val== $row['value']) {$opt_sel="selected";}

}

                            ?>

                            <option <?=$opt_sel;?> value="<?=$row['value']?>"><?=$row['label']?></option>

                        <?php

//
                        }

                        ?>

            </select>
        </div>
    </div>
        <div class="">
    <div class="">
        <div class="form-group">

            <label for="t" class="col-sm-2 control-label"><small><?=lang('HELP_desc');?>: </small></label>

            <div class="col-sm-10">


                <input  type="text" name="fio" class="form-control input-sm" id="t" placeholder="Опис проблеми" value="<?=$fio['title'];?>">



            </div>



        </div></div>
        <div class="form-group">

            <label for="t2" class="col-sm-2 control-label"><small><?=lang('HELP_do');?>: </small></label>

            <div class="col-sm-10">


                <div id="summernote_help"><?=$fio['message'];?></div>



            </div>
            <div class="col-md-12"><hr></div>
            <div class="col-md-2"></div>
<div class="col-md-10">
    <div class="btn-group btn-group-justified">
        <div class="btn-group">
            <button id="do_save_help" value="<?=$hn?>" class="btn btn-success" type="submit"><i class="fa fa-check-circle-o"></i> <?=lang('HELP_save');?></button>
        </div>
        <div class="btn-group">
            <a href="helper.php" class="btn btn-default" type="submit"><i class="fa fa-reply"></i> <?=lang('HELP_back');?></a>
        </div>
    </div>


        </div>
        </form>
        <?php
        
        }

        
        
        if ($mode == "create_helper") {
        
        ?>
        <form class="form-horizontal" role="form">
        



    <div class="form-group">
        <label for="u" class="col-md-2 control-label"><small><?=lang('NEW_to');?>: </small></label>
        <div class="col-md-6">
            <select style="height: 34px;" data-placeholder="<?=lang('NEW_to_unit');?>" class="chosen-select form-control" id="u" name="unit_id" multiple>
                <option value="0"><?=lang('HELP_all');?></option>
                <?php
                        //$qstring = "SELECT name as label, id as value FROM deps where id !='0' ;";
                        //$result = mysql_query($qstring);//query the database for entries containing the term




						$stmt = $dbConnection->prepare('SELECT name as label, id as value FROM deps where id !=:n');
						$stmt->execute(array(':n' => '0'));
						$result = $stmt->fetchAll();
						foreach($result as $row) {
                        
                        
                        //while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
//echo($row['label']);
                            $row['label']=$row['label'];
                            $row['value']=(int)$row['value'];


                            ?>

                            <option value="<?=$row['value']?>"><?=$row['label']?></option>

                        <?php


                        }

                        ?>

            </select>
        </div>
    </div>
        <div class="">
    <div class="">
        <div class="form-group">

            <label for="t" class="col-sm-2 control-label"><small><?=lang('HELP_desc');?>: </small></label>

            <div class="col-sm-10">


                <input  type="text" name="fio" class="form-control input-sm" id="t" placeholder="<?=lang('HELP_desc');?>">



            </div>



        </div></div>
        <div class="form-group">

            <label for="t2" class="col-sm-2 control-label"><small><?=lang('HELP_do');?>: </small></label>

            <div class="col-sm-10">


                <div id="summernote_help"></div>



            </div>
            <div class="col-md-12"><hr></div>
            <div class="col-md-2"></div>
<div class="col-md-10">
    <div class="btn-group btn-group-justified">
        <div class="btn-group">
            <button id="do_create_help" class="btn btn-success" type="submit"><i class="fa fa-check-circle-o"></i> <?=lang('HELP_create');?></button>
        </div>
        <div class="btn-group">
            <a href="helper.php" class="btn btn-default" type="submit"><i class="fa fa-reply"></i> <?=lang('HELP_back');?></a>
        </div>
    </div>


        </div>
        </form>
        <?php
        
        }
        
        if ($mode == "find_help") {
        $t=($_POST['t']);
        $user_id=id_of_user($_SESSION['helpdesk_user_login']);
        $unit_user=unit_of_user($user_id);
        $priv_val=priv_status($user_id);

        $units = explode(",", $unit_user);
        //$units = "'". implode("', '", $units) ."'";
        array_push($units,"0");

/*$results = mysql_query("SELECT 
							id, user_init_id, unit_to_id, dt, title, message, hashname
							from helper where title like '%" . $t . "%' or message like '%" . $t . "%'
							order by dt desc
							");
							*/
        //while ($row = mysql_fetch_assoc($results)) {
        
        
        $stmt = $dbConnection->prepare("SELECT 
							id, user_init_id, unit_to_id, dt, title, message, hashname
							from helper where title like :t or message like :t2
							order by dt desc");
						$stmt->execute(array(':t' => '%'.$t.'%',':t2' => '%'.$t.'%'));
						$result = $stmt->fetchAll();
						foreach($result as $row) {
        
        
        
        
        
        $unit2id = explode(",", $row['unit_to_id']);

		
		$diff = array_intersect($units, $unit2id); 

        $priv_h="no";
        if ($priv_val == 1) {
        	if (($diff) || ($user_id==$row['user_init_id'])) {$ac= "ok";}
			//if ($user_id==$row['user_init_id']) {$ac= "ok";}
        
	    if ($user_id==$row['user_init_id']) {$priv_h="yes";}
        }
        
        
        else if ($priv_val == 0) {
        $ac= "ok";
	        if ($user_id==$row['user_init_id']) {$priv_h="yes";}
        }
        
        
        else if ($priv_val == 2) {
        $ac= "ok";
	        $priv_h="yes";
        }
        
        
        
        if ($ac == "ok") {
        ?>
        
	        <h5 style=" margin-bottom: 5px; "><i class="fa fa-file-text-o"></i> <a href="helper.php?h=<?=$row['hashname'];?>"><?=$row['title'];?></a> <small>(<?=lang('DASHBOARD_author');?>: <?=nameshort(name_of_user_ret($row['user_init_id']));?>)<?php if ($priv_h== "yes") { echo " 
	        <div class=\"btn-group\">
	        <button id=\"edit_helper\" value=\"".$row['hashname']."\" type=\"button\" class=\"btn btn-default btn-xs\"><i class=\"fa fa-pencil\"></i></button>
	        <button id=\"del_helper\" value=\"".$row['hashname']."\"type=\"button\" class=\"btn btn-default btn-xs\"><i class=\"fa fa-trash-o\"></i></button>
	        </div>
	        "; } ?></small></h5>
	        <p style=" margin-bottom: 30px; "><small><?=cutstr_help_ret(strip_tags($row['message']));?>
	        </small>
	        
        </p>
        <?php
        }
        }


        //find_help
        }
        
        if ($mode == "del_help") {
        $hn=($_POST['hn']);
        
    $stmt = $dbConnection->prepare('delete from helper where hashname=:hn');
	$stmt->execute(array(':hn' => $hn));
	
        //$query_del_ticket_log = "delete from helper where hashname='$hn';";
        //mysql_query ( $query_del_ticket_log )or die(mysql_error());
        
        }
        
        
        if ($mode == "list_help") {
        $user_id=id_of_user($_SESSION['helpdesk_user_login']);
        $unit_user=unit_of_user($user_id);
        $priv_val=priv_status($user_id);

        $units = explode(",", $unit_user);
        array_push($units,"0");
        
        
        
        $stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, unit_to_id, dt, title, message, hashname
							from helper
							order by dt desc');
						$stmt->execute();
						$result = $stmt->fetchAll();
						//foreach($result as $row) {
                        
                        
if(empty($result)) {





?>
<div class="jumbotron">
  <p>                </p><center><?=lang('MSG_no_records');?></center><p></p>
  
</div>



<?php
}
else if(!empty($result)) {
        //while ($row = mysql_fetch_assoc($results)) {
        foreach($result as $row) {
        $unit2id = explode(",", $row['unit_to_id']);
        //print_r($units);
        //echo"<br>";
        //print_r($unit2id);
        //$resulta = array_intersect($units, $unit2id);
		//print_r($resulta);
		
		$diff = array_intersect($units, $unit2id); 
		//print_r($diff);
		
		//if ($diff) {echo "ok";}
        /*
        если есть
        
        */
        
        
        
        
        
        
        
        $priv_h="no";
        if ($priv_val == 1) {
        	if (($diff) || ($user_id==$row['user_init_id'])) {$ac= "ok";}
        
        
	        if ($user_id==$row['user_init_id']) {$priv_h="yes";}
        }
        else if ($priv_val == 0) {
        $ac= "ok";
	        if ($user_id==$row['user_init_id']) {$priv_h="yes";}
        }
        else if ($priv_val == 2) {
        $ac= "ok";
	        $priv_h="yes";
        }
        
        if ($ac == "ok") {
        ?>
        
	        <h5 style=" margin-bottom: 5px; "><i class="fa fa-file-text-o"></i> <a href="helper.php?h=<?=$row['hashname'];?>"><?=$row['title'];?></a> <small>(<?=lang('DASHBOARD_author');?>: <?=nameshort(name_of_user_ret($row['user_init_id']));?>)<?php if ($priv_h== "yes") { echo " 
	        <div class=\"btn-group\">
	        <button id=\"edit_helper\" value=\"".$row['hashname']."\" type=\"button\" class=\"btn btn-default btn-xs\"><i class=\"fa fa-pencil\"></i></button>
	        <button id=\"del_helper\" value=\"".$row['hashname']."\"type=\"button\" class=\"btn btn-default btn-xs\"><i class=\"fa fa-trash-o\"></i></button>
	        </div>
	        "; } ?></small></h5>
	        <p style=" margin-bottom: 30px; "><small><?=cutstr_help_ret(strip_tags($row['message']));?>
	        </small>
	        
        </p>
        <?php
        }
        }
        }
        
        
        
        
        }
        ///////
                if ($mode == "do_save_help") {
        $u=$_POST['u'];
        $beats = implode(',', $u);
        $hn=($_POST['hn']);
        
        $t=($_POST['t']);
        $user_id_z=$_SESSION['helpdesk_user_id'];
        //$msg=$_POST['msg'];
        //$hn=md5(time());
        $message=($_POST['msg']);
		$message = str_replace("\r\n", "\n", $message);
		$message = str_replace("\r", "\n", $message);
		$message = str_replace("&nbsp;", " ", $message);
		//$message = defender_xss($message);
		
		//$query="update helper set user_init_id='$user_id_z', unit_to_id='$beats', dt=now(), title='$t', message='$message' where hashname='$hn';";
        //mysql_query($query)or die(mysql_error());
        
    $stmt = $dbConnection->prepare('update helper set user_init_id=:user_id_z, unit_to_id=:beats, dt=now(), title=:t, message=:message where hashname=:hn');
	$stmt->execute(array(':hn' => $hn, ':user_id_z'=>$user_id_z, ':beats'=>$beats, ':t'=>$t, ':message'=>$message));
        
        //echo $query;
        }
        
        if ($mode == "do_create_help") {
        $u=$_POST['u'];
        $beats = implode(',', $u);
        
        
        $t=($_POST['t']);
        $user_id_z=$_SESSION['helpdesk_user_id'];
        //$msg=$_POST['msg'];
        $hn=md5(time());
        $message=($_POST['msg']);
		$message = str_replace("\r\n", "\n", $message);
		$message = str_replace("\r", "\n", $message);
		$message = str_replace("&nbsp;", " ", $message);
		//$message = defender_xss($message);
		
		//$query="insert into helper (hashname, user_init_id,unit_to_id, dt, title,message) values 
		//('$hn','$user_id_z','$beats', now(), '$t','$message');";
        //mysql_query($query)or die(mysql_error());
        
         $stmt = $dbConnection->prepare('insert into helper (hashname, user_init_id,unit_to_id, dt, title,message) values 
		(:hn,:user_id_z,:beats, now(), :t,:message)');
		 $stmt->execute(array(':hn' => $hn, ':user_id_z'=>$user_id_z, ':beats'=>$beats, ':t'=>$t, ':message'=>$message));
      
        
        
        
        
        //echo $beats;
        }
        
        if ($mode == "dashboard_t") {

//////////////////////////////////////////////////////////////////////////////////////
		$page=1;
        $perpage='5';
        $start_pos = ($page - 1) * $perpage;

        $user_id=id_of_user($_SESSION['helpdesk_user_login']);
        $unit_user=unit_of_user($user_id);
        $priv_val=priv_status($user_id);

        /*
        cookie['sort']={id, prio, создание, обновление}
        
        order by id DESC
        order by ok_by asc, prio desc, id desc
        */
        $units = explode(",", $unit_user);
        $units = implode("', '", $units);



        /*
        if ($_SESSION['helpdesk_sort_prio'] == "asc" )  {$order.="prio asc"; $prio_icon="<i class=\"fa fa-caret-down\"></i>";}
        if ($_SESSION['helpdesk_sort_prio'] == "desc" ) {$order.="prio desc"; $prio_icon="<i class=\"fa fa-caret-up\"></i>";}
        if ($_SESSION['helpdesk_sort_prio'] == "none" ) {$order.=""; $prio_icon="";}
        
        if ($_SESSION['helpdesk_sort_id'] == "asc" )  {$order.="id asc"; $id_icon="<i class=\"fa fa-caret-down\"></i>";}
        if ($_SESSION['helpdesk_sort_id'] == "desc" ) {$order.="id desc"; $id_icon="<i class=\"fa fa-caret-up\"></i>";}
        if ($_SESSION['helpdesk_sort_id'] == "none" ) {$order.=""; $id_icon="";}
        
        if ($_SESSION['helpdesk_sort_subj'] == "asc" )  {$order.="subj asc";  $subj_icon="<i class=\"fa fa-caret-down\"></i>";}
        if ($_SESSION['helpdesk_sort_subj'] == "desc" ) {$order.="subj desc"; $subj_icon="<i class=\"fa fa-caret-up\"></i>";}
        if ($_SESSION['helpdesk_sort_subj'] == "none" ) {$order.=""; $subj_icon="";}
        
        if ($_SESSION['helpdesk_sort_clientid'] == "asc" )  {$order.="client_id asc";  $cli_icon="<i class=\"fa fa-caret-down\"></i>";}
        if ($_SESSION['helpdesk_sort_clientid'] == "desc" ) {$order.="client_id desc"; $cli_icon="<i class=\"fa fa-caret-up\"></i>";}
        if ($_SESSION['helpdesk_sort_clientid'] == "none" ) {$order.=""; 		 $cli_icon="";}
                       
        if ($_SESSION['helpdesk_sort_userinitid'] == "asc" )  {$order.="user_init_id asc";  $init_icon="<i class=\"fa fa-caret-down\"></i>";}
        if ($_SESSION['helpdesk_sort_userinitid'] == "desc" ) {$order.="user_init_id desc"; $init_icon="<i class=\"fa fa-caret-up\"></i>";}
        if ($_SESSION['helpdesk_sort_userinitid'] == "none" ) {$order.="";          $init_icon="";}
        
        
        if ($order == "") {$order="ok_by asc, prio desc, id desc";}
        */


        //client_id       user_init_id
        //,user_init_id,unit_id,user_to_id





        //$order=$order1.",".$order3;






        if ($priv_val == 0) {
        /*
            $results = mysql_query("SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update
							from tickets
							where unit_id IN (".$units.")  and arch='0'
							order by ok_by asc, prio desc, id desc
							limit $start_pos, $perpage
							");
		*/
							
	$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update
							from tickets
							where unit_id IN (:units)  and arch=:n
							order by ok_by asc, prio desc, id desc
							limit :start_pos, :perpage');
	$stmt->execute(array(':n' => '0', ':units'=>$units, ':start_pos'=>$start_pos, ':perpage'=>$perpage));
	$results = $stmt->fetchAll();
							
							
							
							
							
							
        }
        else if ($priv_val == 1) {
            /*$results = mysql_query("SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update
							from tickets
							where ((user_to_id='$user_id' and arch='0') or
							(user_to_id='0' and unit_id IN (".$units.") and arch='0'))
							order by ok_by asc, prio desc, id desc
							limit $start_pos, $perpage
							");
							*/
							
							
	$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update
							from tickets
							where ((user_to_id=:user_id and arch=:n) or
							(user_to_id=:n1 and unit_id IN (:units) and arch=:n2))
							order by ok_by asc, prio desc, id desc
							limit :start_pos, :perpage');
	$stmt->execute(array(':n' => '0', ':units'=>$units, ':start_pos'=>$start_pos, ':perpage'=>$perpage, ':user_id'=>$user_id,':n1' => '0',':n2' => '0'));
	$results = $stmt->fetchAll();
	
	
							
        }
        else if ($priv_val == 2) {
            /*$results = mysql_query("SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update
							from tickets
							where arch='0'
							order by ok_by asc, prio desc, id desc
							limit $start_pos, $perpage
							");
							*/
							
								$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update
							from tickets
							where arch=:n
							order by ok_by asc, prio desc, id desc
							limit :start_pos, :perpage');
	$stmt->execute(array(':n' => '0',':start_pos'=>$start_pos, ':perpage'=>$perpage));
	$results = $stmt->fetchAll();
							
							
							
        }




        $aha=get_total_pages('in', $user_id);
        if ($aha == "0") {

            ?>
            <div id="spinner" class="well well-large well-transparent lead">
                <center>
                    <?=lang('MSG_no_records');?>
                </center>
            </div>
        <?php } if ($aha <> "0") {

            ?>

            <input type="hidden" value="<?php echo get_total_pages('in', $user_id); ?>" id="val_menu">
            <input type="hidden" value="<?php echo $user_id; ?>" id="user_id">
            <input type="hidden" value="" id="total_tickets">
            <input type="hidden" value="" id="last_total_tickets">








<div class="table-responsive">
            <table class="table table-bordered table-hover " style=" font-size: 14px; ">
            <thead>
            <tr>
                <th><center><div id="sort_id" action="<?=$_SESSION['helpdesk_sort_id'];?>">#<?=$id_icon;?></div></center></th>
                <th><center><div id="sort_prio" action="<?=$_SESSION['helpdesk_sort_prio'];?>"><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="<?=lang('t_LIST_prio');?>"></i><?=$prio_icon;?></div></center></th>
                <th><center><div id="sort_subj" action="<?=$_SESSION['helpdesk_sort_subj'];?>"><?=lang('t_LIST_subj');?><?=$subj_icon;?></div></center></th>
                <th><center><div id="sort_cli" action="<?=$_SESSION['helpdesk_sort_clientid'];?>"><?=lang('t_LIST_worker');?><?=$cli_icon;?></div></center></th>
                <th><center><?=lang('t_LIST_create');?></center></th>
                <th><center><?=lang('t_LIST_ago');?></center></th>
                <th><center><div id="sort_init" action="<?=$_SESSION['helpdesk_sort_userinitid'];?>"><?=lang('t_LIST_init');?><?=$init_icon;?></div></center></th>
                <th><center><?=lang('t_LIST_to');?></center></th>
                <th><center><?=lang('t_LIST_status');?></center></th>
                
            </tr>
            </thead>
            <tbody>

            <?php
            //if (mysql_num_rows($results) > 0) {
            
            

        foreach($results as $row) {
            
            
            //while ($row = mysql_fetch_assoc($results)) {

                $lb=$row['lock_by'];
                $ob=$row['ok_by'];
                /*
                if (priv_status($user_id) == "0") {
                    $lock_st="";	$muclass="";
                }
                if (priv_status($user_id) == "1") {
                    if ($lb <> $user_id) {$lock_st="disabled=\"disabled\""; $muclass="text-muted";}
                    if (($lb == "0") || ($lb == $user_id)) {$lock_st=""; $muclass="";}
                }
                
                */

//$lock_st="disabled=\"disabled\"";
//$muclass="text-muted";

                $user_id_z=$_SESSION['helpdesk_user_id'];
                $unit_user_z=unit_of_user($user_id_z);
                $status_ok_z=$row['status'];
                $ok_by_z=$row['ok_by'];
                $lock_by_z=$row['lock_by'];



                $lo="no";

                if (priv_status($user_id) == "0") {
                    $u=explode(",",$unit_user_z);

                    if (in_array($row['unit_id'], $u)) {$lo="yes";}
                    if ($row['user_init_id'] == $user_id_z) {$lo="yes";}
                    if ($row['user_to_id'] == $user_id) {$lo="yes";}
                }
                else if (priv_status($user_id) == "2") {
                    if ($row['unit_id'] == $unit_user_z) {$lo="yes";}
                    if ($row['user_init_id'] == $user_id_z) {$lo="yes";}
                    if ($row['user_to_id'] == $user_id) {$lo="yes";}
                }



                else if (priv_status($user_id) == "1") {

                    $u=explode(",",$unit_user_z);
                    //print_r ($u);
                    // ЗАявка не выполнена ИЛИ выполнена мной
                    if (($status_ok_z == 0) || (($status_ok_z == 1) && ($ok_by_z == $user_id_z)))
                    {
                        //echo "ЗАявка не выполнена ИЛИ выполнена мной"."<br>";

                        //ЗАявка не заблокирована ИЛИ заблокирована мной
                        if (($lock_by_z == 0) || ($lock_by_z == $user_id_z)) {
                            //echo "ЗАявка не заблокирована ИЛИ заблокирована мной"."<br>";


                            // ЗАявка моего отдела ВСЕМ
                            if ((in_array($row['unit_id'], $u)) && ($row['user_to_id'] == "0")) {

                                //if (($row['unit_id'] == $unit_user_z) && ($row['user_to_id'] == "0")) {
                                //echo "ЗАявка моего отдела ВСЕМ"."<br>";
                                $lo="yes";
                            }

                            // Заявка мне
                            if ($row['user_to_id'] == $user_id_z) {
                                //echo "ЗАявка мне"."<br>";
                                $lo="yes";
                            }

                            //инициатор заявки я
                            if ($row['user_init_id'] == $user_id_z) {
                                //echo "инициатор заявки я"."<br>";
                                $lo="yes";
                                //echo "f";
                            }
                        }
                        //инициатор заявки я
                        if ($row['user_init_id'] == $user_id_z) {
                            //echo "инициатор заявки я"."<br>";
                            $lo="yes";
                            //echo "f";
                        }
                    }






                }






//echo $lo;
                if ($lo == "yes") {$lock_st=""; $muclass="";}
                if ($lo == "no") {$lock_st="disabled=\"disabled\""; $muclass="text-muted";}














                if ($row['is_read'] == "0") {

                    $style="bold_for_new";

                    if ($row['status'] == "1") {
                        $ob_text="<i class=\"fa fa-check-circle-o\"></i>";
                        $ob_status="unok";
                        $ob_tooltip=lang('t_list_a_nook');
                        $style="success";

                        if ($lb <> "0") {
                            $lb_text="<i class=\"fa fa-lock\"></i>";
                            $lb_status="unlock";
                            $lb_tooltip=lang('t_list_a_unlock');
                        }
                        if ($lb == "0") {
                            $lb_text="<i class=\"fa fa-unlock\"></i>";
                            $lb_status="lock";
                            $lb_tooltip=lang('t_list_a_lock');
                        }


                    }

                    if ($row['status'] == "0") {
                        $ob_text="<i class=\"fa fa-circle-o\"></i>";
                        $ob_status="ok";
                        $ob_tooltip=lang('t_list_a_ok');
                        if ($lb <> "0") {
                            $lb_text="<i class=\"fa fa-lock\"></i>";
                            $lb_status="unlock";
                            $lb_tooltip=lang('t_list_a_unlock');
                            if ($lb == $user_id) {$style="warning";}
                            if ($lb <> $user_id) {$style="active";}
                        }

                        if ($lb == "0") {
                            $lb_text="<i class=\"fa fa-unlock\"></i>";
                            $lb_status="lock";
                            $lb_tooltip=lang('t_list_a_lock');
                        }

                    }

                }

                if ($row['is_read'] <> "0") {

                    if ($row['status'] == "1") {
                        $ob_text="<i class=\"fa fa-check-circle-o\"></i>";
                        $ob_status="unok";
                        $style="success";
                        $ob_tooltip=lang('t_list_a_nook');
                        if ($lb <> "0") {
                            $lb_text="<i class=\"fa fa-lock\"></i>";
                            $lb_status="unlock";
                            $lb_tooltip=lang('t_list_a_lock');
                        }
                        if ($lb == "0") {
                            $lb_text="<i class=\"fa fa-unlock\"></i>";
                            $lb_status="lock";
                            $lb_tooltip=lang('t_list_a_lock');
                        }
                    }
                    if ($row['status'] == "0") {
                        $ob_text="<i class=\"fa fa-circle-o\"></i>";
                        $ob_status="ok";
                        $ob_tooltip=lang('t_list_a_ok');
                        if ($lb <> "0") {
                            $lb_text="<i class=\"fa fa-lock\"></i>";
                            $lb_status="unlock";
                            $lb_tooltip=lang('t_list_a_unlock');
                            if ($lb == $user_id) {$style="warning";}
                            if ($lb <> $user_id) {$style="active";}
                        }
                        if ($lb == "0") {
                            $style="";
                            $lb_text="<i class=\"fa fa-unlock\"></i>";
                            $lb_status="lock";$lb_tooltip=lang('t_list_a_lock');

                        }

                    }
                }

                if ($row['user_to_id'] <> 0 ) {
                    $to_text="<div class=''>".nameshort(name_of_user_ret($row['user_to_id']))."</div>";
                }
                if ($row['user_to_id'] == 0 ) {
                    $to_text="<strong data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_unit_name_return($row['unit_id'])."\">".lang('t_list_a_all')."</strong>";
                }

                $prio="<span class=\"label label-info\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".lang('t_list_a_p_norm')."\"><i class=\"fa fa-minus\"></i></span>";

                if ($row['prio'] == "0") {$prio= "<span class=\"label label-primary\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".lang('t_list_p_low')."\"><i class=\"fa fa-arrow-down\"></i></span>"; }

                if ($row['prio'] == "2") {$prio= "<span class=\"label label-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".lang('t_list_p_high')."\"><i class=\"fa fa-arrow-up\"></i></span>"; }

                /*
                          if ($row['status'] == 1) {$st=  "<i class=\"fa fa-check-circle\"></i> виконано ".nameshort(name_of_user_ret($ob));} 
                          if ($row['status'] == 0) {
                              if ($lb <> 0) {
                                  if ($lb == $user_id) {$st=  "<i class=\"fa fa-gavel\"></i> працює ".nameshort(name_of_user_ret($lb));}
                                  if ($lb <> $user_id) {$st=  "<i class=\"fa fa-gavel\"></i> працює ".nameshort(name_of_user_ret($lb));}
                              
                              
                              }
                              if ($lb == 0) {$st=  "<i class=\"fa fa-clock-o\"></i> очікування дії";}
                          }
                    
                        
                        */



                if ($row['status'] == 1) {$st=  "<span class=\"label label-success\"><i class=\"fa fa-check-circle\"></i> ".lang('t_list_a_oko')." ".nameshort(name_of_user_ret($ob))."</span>";
	            $t_ago=get_date_ok($row['date_create'], $row['id']);
	              //$t_ago='s';  
                }
                if ($row['status'] == 0) {
                $t_ago=humanTiming(strtotime($row['date_create']));
                
                
                    if ($lb <> 0) {

                        if ($lb == $user_id) {$st=  "<span class=\"label label-warning\"><i class=\"fa fa-gavel\"></i> ".lang('t_list_a_lock_i')."</span>";}

                        if ($lb <> $user_id) {$st=  "<span class=\"label label-default\"><i class=\"fa fa-gavel\"></i> ".lang('t_list_a_lock_u')." ".nameshort(name_of_user_ret($lb))."</span>";}

                        //$st=$lb;

                    }
                    if ($lb == 0) {$st=  "<span class=\"label label-primary\"><i class=\"fa fa-clock-o\"></i> ".lang('t_list_a_hold')."</span>";}
                }
                ?>




                <tr id="tr_<?php echo $row['id']; ?>" class="<?=$style?>">
                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><center><?php echo $row['id']; ?></center></small></td>
                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><center><?=$prio?></center></small></td>
                    <td style=" vertical-align: middle; "><a class="<?=$muclass;?>" data-toggle="tooltip" data-placement="bottom" title="<?=$row['subj']?>" href="ticket.php?hash=<?php echo $row['hash_name']; ?>"><?php cutstr($row['subj']); ?></a></td>
                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><?php name_of_client($row['client_id']); ?></small></td>
                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><center><?php dt_format($row['date_create']); ?></center></small></td>
                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><center><?=$t_ago;?></center></small></td>

                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><?php echo nameshort(name_of_user_ret($row['user_init_id'])); ?></small></td>

                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>">
                            <?=$to_text?>
                        </small></td>
                    <td style=" vertical-align: middle; "><small><center>
                                <?=$st;?> </center>
                        </small></td>

                </tr>
            <?php
            }

            ?>
            </tbody>
            </table>

</div>



        <?php
        }

//////////////////////////////////////////////////////////////////////////////////////
                
        
        
        
        
        
        }
        
		if ($mode == "last_news") {
		     
            $uid=$_SESSION['helpdesk_user_id'];
            $unit_user=unit_of_user($uid);
            $priv_val=priv_status($uid);


            $units = explode(",", $unit_user);
            $units = implode("', '", $units);


            if ($priv_val == "0") {
            
                $stmt = $dbConnection->prepare('SELECT id, hash_name, last_update from tickets where (unit_id IN (:units) or user_init_id=:uid) order by last_update DESC limit 5');
	$stmt->execute(array(':units' => $units, ':uid'=>$uid));
	$res1 = $stmt->fetchAll();
            
            
                /*$queryid = "SELECT id, hash_name, last_update from tickets where (unit_id IN (".$units.") or user_init_id='$uid') order by last_update DESC limit 5;";
                $res1 = mysql_query($queryid) or die(mysql_error());
*/
				foreach($res1 as $rews) {
                //while ($rews = mysql_fetch_assoc($res1)) {

                    $at=get_last_action_ticket($rews['id']);

                    $who_action=get_who_last_action_ticket($rews['id']);
                    //if ($who_action <> $uid) {
                        $results[] = array(
                            'name' => $rews['id'],
                            'at' => $at,
                            'hash' => $rews['hash_name'],
                            'time' => dt_format_full_r($rews['last_update'])
                        );
                    //}

                }
            }


            else if ($priv_val == "1") {

                $stmt = $dbConnection->prepare('SELECT id, hash_name, last_update from tickets where (
	((user_to_id=:uid) or (user_to_id=:n and unit_id IN (:units)))
	or user_init_id=:uid2) order by last_update DESC limit 5');
	$stmt->execute(array(':units' => $units, ':uid'=>$uid, ':n'=>'0', ':uid2'=>$uid));
	$res1 = $stmt->fetchAll();
	
	
	
                /*$queryid = "SELECT id, hash_name, last_update from tickets where (
	((user_to_id='$uid') or (user_to_id='0' and unit_id IN (".$units.")))
	or user_init_id='$uid') order by last_update DESC limit 5;";
                $res1 = mysql_query($queryid) or die(mysql_error());
                */
                foreach($res1 as $rews) {
                //while ($rews = mysql_fetch_assoc($res1)) {

                    $at=get_last_action_ticket($rews['id']);
                    $who_action=get_who_last_action_ticket($rews['id']);
                    //if ($who_action <> $uid) {

                        $results[] = array(
                            'name' => $rews['id'],
                            'at' => $at,
                            'hash' => $rews['hash_name'],
                            'time' => dt_format_full_r($rews['last_update'])
                        );
                    //}
                }


                //$count="1";
            }
            else if ($priv_val == "2") {


                $stmt = $dbConnection->prepare('SELECT id, hash_name, last_update from tickets order by last_update DESC limit 5');
	$stmt->execute();
	$res1 = $stmt->fetchAll();
	
	

                /*$queryid = "SELECT id, hash_name, last_update from tickets order by last_update DESC limit 5;";
                $res1 = mysql_query($queryid) or die(mysql_error());
                */
                
                //while ($rews = mysql_fetch_assoc($res1)) {
foreach($res1 as $rews) {
                    $at=get_last_action_ticket($rews['id']);
                    $who_action=get_who_last_action_ticket($rews['id']);
                    //if ($who_action <> $uid) {

                        $results[] = array(
                            'name' => $rews['id'],
                            'at' => $at,
                            'hash' => $rews['hash_name'],
                            'time' => dt_format_full_r($rews['last_update'])
                        );
                   // }
                }


                //$count="1";
            }
		
		

		if (empty($results)) {
			?>
			            <div id="" class="well well-large well-transparent lead">
                <center>
                    <?=lang('MSG_no_records');?>
                </center>
            </div>
			<?php
		}
		else {
		//print_r ($results);
				    ?><table class="table table-hover" style="margin-bottom: 0px;" id=""> <?php
				    
		foreach ($results as $arr) {
		?>
		
		<tr><td style=" width: 100px; vertical-align: inherit;"><small><i class="fa fa-tag"></i> </small><a href="ticket.php?hash=<?=$arr['hash'];?>"><small><?=lang('TICKET_name');?> #<?=$arr['name'];?></small></a></td><td><small><?=$arr['at'];?></small></td><td style=" width: 110px; vertical-align: inherit;"><small style="float:right;" class="text-muted "> <?=$arr['time'];?></small></td></tr>
		
		<?php
		//echo $arr['name']."<br>";
		}
		?></table><?php
		}
		
		}
		
		
		
        if ($mode == "check_update") {
            $pm=($_POST['type']);//in|out|arch|all
            $uid=$_SESSION['helpdesk_user_id'];
            $lu=($_POST['last_update']);

            $current_ticket_update=get_last_ticket($pm,$uid);

            if (strtotime($current_ticket_update) > strtotime($lu)) {echo $current_ticket_update;}
            if (strtotime($current_ticket_update) <= strtotime($lu)) {echo "no";}
//echo strtotime($current_ticket_update)."__".strtotime($lu);
        }



        if ($mode == "list_ticket_update") {
            $pm=($_POST['type']);//in|out|arch
            $uid=$_SESSION['helpdesk_user_id'];
            $lu=($_POST['last_update']);
            $nlu=($_POST['new_last_update']);
            $unit_user=unit_of_user($uid);
            $priv_val=priv_status($uid);


            $units = explode(",", $unit_user);
            $units = implode("', '", $units);
			//$t_lang=

            if ($priv_val == "0") {
    $stmt = $dbConnection->prepare('SELECT id, hash_name, last_update from tickets where (unit_id IN (:units) or user_init_id=:uid) and last_update > :lu');
	$stmt->execute(array(':units' => $units, ':uid'=>$uid, ':lu'=>$lu));
	$res1 = $stmt->fetchAll();
	foreach($res1 as $rews) {
	
            /*
                $queryid = "SELECT id, hash_name, last_update from tickets where (unit_id IN (".$units.") or user_init_id='$uid') and last_update > '$lu';";
                $res1 = mysql_query($queryid) or die(mysql_error());

                while ($rews = mysql_fetch_assoc($res1)) {
*/
                    $at=get_last_action_ticket($rews['id']);

                    $who_action=get_who_last_action_ticket($rews['id']);
                    if ($who_action <> $uid) {
                        $results[] = array(
                        	'url' => $CONF['hostname'],
                        	'up' => lang('JS_up'),
                        	'ticket' => lang('JS_ticket'),
                            'name' => $rews['id'],
                            'at' => $at,
                            'hash' => $rews['hash_name'],
                            'time' => dt_format_short($rews['last_update'])
                        );
                    }

                }
            }


            else if ($priv_val == "1") {

    $stmt = $dbConnection->prepare('SELECT id, hash_name, last_update from tickets where (
	((user_to_id=:uid) or (user_to_id=:n and unit_id IN (:units)))
	or user_init_id=:uid2) and last_update > :lu');
	$stmt->execute(array(':units' => $units, ':uid'=>$uid, ':lu'=>$lu, ':uid2'=>$uid, ':n'=>'0'));
	$res1 = $stmt->fetchAll();
	foreach($res1 as $rews) {
	
	
                /*$queryid = "SELECT id, hash_name, last_update from tickets where (
	((user_to_id='$uid') or (user_to_id='0' and unit_id IN (".$units.")))
	or user_init_id='$uid') and last_update > '$lu';";
                $res1 = mysql_query($queryid) or die(mysql_error());
                while ($rews = mysql_fetch_assoc($res1)) {
*/
                    $at=get_last_action_ticket($rews['id']);
                    $who_action=get_who_last_action_ticket($rews['id']);
                    if ($who_action <> $uid) {

                        $results[] = array(
                        	'url' => $CONF['hostname'],
                        	'up' => lang('JS_up'),
                        	'ticket' => lang('JS_ticket'),
                            'name' => $rews['id'],
                            'at' => $at,
                            'hash' => $rews['hash_name'],
                            'time' => dt_format_short($rews['last_update'])
                        );
                    }
                }


                //$count="1";
            }
            else if ($priv_val == "2") {

    $stmt = $dbConnection->prepare('SELECT id, hash_name, last_update from tickets where last_update > :lu');
	$stmt->execute(array(':lu'=>$lu));
	$res1 = $stmt->fetchAll();
	foreach($res1 as $rews) {
	
	
                /*$queryid = "SELECT id, hash_name, last_update from tickets where last_update > '$lu';";
                $res1 = mysql_query($queryid) or die(mysql_error());
                while ($rews = mysql_fetch_assoc($res1)) {
                */

                    $at=get_last_action_ticket($rews['id']);
                    $who_action=get_who_last_action_ticket($rews['id']);
                    if ($who_action <> $uid) {

                        $results[] = array(
                        	'url' => $CONF['hostname'],
                        	'up' => lang('JS_up'),
                        	'ticket' => lang('JS_ticket'),
                            'name' => $rews['id'],
                            'at' => $at,
                            'hash' => $rews['hash_name'],
                            'time' => dt_format_short($rews['last_update'])
                        );
                    }
                }


                //$count="1";
            }
//// 
///
///
            print json_encode($results);
//echo strtotime($current_ticket_update)."__".strtotime($lu);
        }

        /*
        if ($mode == "sort_init") {
        $t=$_POST['t'];

        if ($t== "asc") {
        $_SESSION['helpdesk_sort_userinitid']="asc";
        $_SESSION['helpdesk_sort_id']="none";
        $_SESSION['helpdesk_sort_subj']="none";
        $_SESSION['helpdesk_sort_clientid']="none";
        $_SESSION['helpdesk_sort_prio']="none";
        }
        if ($t== "desc") {
        $_SESSION['helpdesk_sort_userinitid']="desc";
        $_SESSION['helpdesk_sort_id']="none";
        $_SESSION['helpdesk_sort_subj']="none";}
        $_SESSION['helpdesk_sort_clientid']="none";
        $_SESSION['helpdesk_sort_prio']="none";
        if ($t== "none") {
        $_SESSION['helpdesk_sort_userinitid']="none";
        }

        }

        if ($mode == "sort_cli") {
        $t=$_POST['t'];

        if ($t== "asc") {
        $_SESSION['helpdesk_sort_clientid']="asc";
        $_SESSION['helpdesk_sort_id']="none";
        $_SESSION['helpdesk_sort_subj']="none";
        $_SESSION['helpdesk_sort_userinitid']="none";
        $_SESSION['helpdesk_sort_prio']="none";
        }
        if ($t== "desc") {
        $_SESSION['helpdesk_sort_clientid']="desc";
        $_SESSION['helpdesk_sort_id']="none";
        $_SESSION['helpdesk_sort_subj']="none";
        $_SESSION['helpdesk_sort_userinitid']="none";
        $_SESSION['helpdesk_sort_prio']="none";
        }
        if ($t== "none") {$_SESSION['helpdesk_sort_clientid']="none";}

        }

        if ($mode == "sort_prio") {
        $t=$_POST['t'];

        if ($t== "asc") {
        $_SESSION['helpdesk_sort_prio']="asc";
        $_SESSION['helpdesk_sort_id']="none";
        $_SESSION['helpdesk_sort_subj']="none";
        $_SESSION['helpdesk_sort_userinitid']="none";
        $_SESSION['helpdesk_sort_clientid']="none";
        }
        if ($t== "desc") {
        $_SESSION['helpdesk_sort_prio']="desc";
        $_SESSION['helpdesk_sort_id']="none";
        $_SESSION['helpdesk_sort_subj']="none";
        $_SESSION['helpdesk_sort_userinitid']="none";
        $_SESSION['helpdesk_sort_clientid']="none";
        }
        if ($t== "none") {$_SESSION['helpdesk_sort_prio']="none";}

        }

        if ($mode == "sort_id") {
        $t=$_POST['t'];

        if ($t== "asc") {$_SESSION['helpdesk_sort_id']="asc";$_SESSION['helpdesk_sort_prio']="none";$_SESSION['helpdesk_sort_subj']="none";$_SESSION['helpdesk_sort_userinitid']="none";
        $_SESSION['helpdesk_sort_clientid']="none";}
        if ($t== "desc") {$_SESSION['helpdesk_sort_id']="desc";$_SESSION['helpdesk_sort_prio']="none";$_SESSION['helpdesk_sort_subj']="none";$_SESSION['helpdesk_sort_userinitid']="none";
        $_SESSION['helpdesk_sort_clientid']="none";}
        if ($t== "none") {$_SESSION['helpdesk_sort_id']="none";}

        }

        if ($mode == "sort_subj") {
        $t=$_POST['t'];

        if ($t== "asc")  {$_SESSION['helpdesk_sort_subj']="asc";$_SESSION['helpdesk_sort_prio']="none";$_SESSION['helpdesk_sort_id']="none";$_SESSION['helpdesk_sort_userinitid']="none";
        $_SESSION['helpdesk_sort_clientid']="none";}
        if ($t== "desc") {$_SESSION['helpdesk_sort_subj']="desc";$_SESSION['helpdesk_sort_prio']="none";$_SESSION['helpdesk_sort_id']="none";$_SESSION['helpdesk_sort_userinitid']="none";
        $_SESSION['helpdesk_sort_clientid']="none";}
        if ($t== "none") {$_SESSION['helpdesk_sort_subj']="none";}

        }


        */
        if ($mode == "find_worker") {

            $fio=($_POST['fio']);
            
            $stmt = $dbConnection->prepare('SELECT id,fio,tel,unit_desc,adr,tel_ext,email,login, posada, email FROM clients where fio like :fio');
			$stmt->execute(array(':fio' => '%'.$fio.'%'));
			$fio = $stmt->fetch(PDO::FETCH_ASSOC);



           /* $query="SELECT id,fio,tel,unit_desc,adr,tel_ext,email,login, posada, email FROM clients where fio like '%" . $fio . "%';";
            $res = mysql_query($query) or die(mysql_error());
            $fio= mysql_fetch_assoc( $res );
            */
            
            
            
            
            $fio_user=$fio['fio'];
            $loginf=$fio['login'];
            $tel_user=$fio['tel'];
            $pod=$fio['unit_desc'];
            $adr=$fio['adr'];
            $tel_ext=$fio['tel_ext'];
            $mails=$fio['email'];
            $posada=$fio['posada'];
            $id=$fio['id'];

            /*
            $q_total="select count(id) as t1 from tickets where client_id='$id'";
            $res_total = mysql_query($q_total) or die(mysql_error());
            $total_ticket= mysql_fetch_assoc( $res_total );
            */
            
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
            ?>

            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-default">
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

                                <?php  ?>

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
                                    <td><small class="text-muted"><?php echo $tt; ?></small></td>
                                </tr>

                                <tr>
                                    <td style=" width: 30px; "><small class="text-muted"><?=lang('WORKER_last');?>:</small></td>
                                    <td><small class="text-muted"><?php echo $lt; ?></small></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">



                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><i class="fa fa-pencil-square-o"></i> <?=lang('WORKER_edit_info');?></h4>
                        </div>
                        <div class="panel-body">



                            <form class="form-horizontal" role="form" id="form_approve">
                                <div class="form-group">
                                    <label for="pib" class="col-sm-2 control-label"><small><?=lang('WORKER_fio');?></small></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="pib" class="form-control input-sm" id="pib" placeholder="<?=lang('WORKER_fio');?>" value="<?=$fio_user;?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="login" class="col-sm-2 control-label"><small><?=lang('WORKER_login');?></small></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="login" class="form-control input-sm" id="login" placeholder="<?=lang('WORKER_login');?>" value="<?=$loginf?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="posada" class="col-sm-2 control-label"><small><?=lang('WORKER_posada');?></small></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="posada" class="form-control input-sm" id="posada" placeholder="<?=lang('WORKER_posada');?>" value="<?=$posada?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pidrozdil" class="col-sm-2 control-label"><small><?=lang('WORKER_unit');?></small></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="pid" class="form-control input-sm" id="pidrozdil" placeholder="<?=lang('WORKER_unit');?>" value="<?=$pod;?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tel" class="col-sm-2 control-label"><small><?=lang('WORKER_tel');?></small></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="tel" class="form-control input-sm" id="tel" placeholder="<?=lang('WORKER_tel_full');?>" value="<?php echo $tel_user." ".$tel_ext; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="adr" class="col-sm-2 control-label"><small><?=lang('WORKER_room');?></small></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="adr" class="form-control input-sm" id="adr" placeholder="<?=lang('WORKER_room');?>" value="<?php echo $adr; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label"><small><?=lang('WORKER_mail');?></small></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="mail" class="form-control input-sm" id="email" placeholder="<?=lang('WORKER_mail');?>" value="<?=$mails?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                </div>
                                <div class="col-sm-6">
                                    <input type="hidden" name="id_client" value="<?=$id;?>">
                                    <button type="submit" id="send_zapit_edit" class="btn btn-success btn-xs btn-block"><?=lang('WORKER_send_approve');?></button>
                                </div>


                            </form>

                        </div>

                    </div>
                    <div id="sze_info">

                    </div>





                </div>
            </div>
        <?php
        }

        if ($mode == "aprove_yes") {
            $id=($_POST['id']);

            /*$clientquery="SELECT id,fio,tel,unit_desc,adr ,email,login, posada, email,client_id FROM approved_info where id='$id';";
            $resclient = mysql_query($clientquery) or die(mysql_error());
            $fio= mysql_fetch_assoc( $resclient );*/
            
            
            $stmt = $dbConnection->prepare('SELECT id,fio,tel,unit_desc,adr ,email,login, posada, email,client_id FROM approved_info where id=:id');
			$stmt->execute(array(':id' => $id));
			$fio = $stmt->fetch(PDO::FETCH_ASSOC);
            

            $qfio=($fio['fio']);
            $qlogin=($fio['login']);
            $tel=($fio['tel']);
            $qpod=($fio['unit_desc']);
            $adr=($fio['adr']);
            //$tel_ext=$fio['tel_ext'];
            $email=($fio['email']);
            $posada=($fio['posada']);
            $cid=($fio['client_id']);
//echo $fio['tel'];



            /*$query_update_client= "update clients set fio='$qfio', tel='$tel', login='$qlogin', unit_desc='$qpod',
						adr='$adr', email='$email', posada='$posada' where id='$cid'";
            mysql_query ( $query_update_client )or die(mysql_error());*/
            
            $stmt = $dbConnection->prepare('update clients set fio=:qfio, tel=:tel, login=:qlogin, unit_desc=:qpod,
						adr=:adr, email=:email, posada=:posada where id=:cid');
			$stmt->execute(array(':qfio' => $qfio, ':tel' => $tel,':qlogin' => $qlogin,':qpod' => $qpod,':adr' => $adr,':email' => $email, ':posada' => $posada, ':cid' => $cid));
            
            
            
            
            
            /*$query_del_ticket_log = "delete from approved_info where id='$id';";
            mysql_query ( $query_del_ticket_log )or die(mysql_error());*/
            
            $stmt = $dbConnection->prepare('delete from approved_info where id=:id');
			$stmt->execute(array(':id' => $id));
            
//echo $query_update_client;
        }
        if ($mode == "aprove_no") {
            $id=($_POST['id']);
            
            /*$query_add_ticket_log = "delete from approved_info where id='$id';";
            mysql_query ( $query_add_ticket_log )or die(mysql_error());*/
            
            $stmt = $dbConnection->prepare('delete from approved_info where id=:id');
			$stmt->execute(array(':id' => $id));

        }


        if ($mode == "edit_profile_main") {
            $l=($_POST['login']);
            $m=($_POST['mail']);
            $id=($_POST['id']);
			$langu=($_POST['lang']);
// Проверка логіна сімволи і к-во
// проверка email
            $ec=0;
            if (!validate_alphanumeric_underscore($l)) { $ec=1;}
			if (!validate_email($m)) {$ec=1;}
			if (!validate_exist_mail($m)) {$ec=1;}


            if ($ec == 0) {
                /*$query_update_ticket= "update users set login='$l', email='$m', lang='$langu' where id='$id'";
                mysql_query ( $query_update_ticket )or die(mysql_error());*/
           
            $stmt = $dbConnection->prepare('update users set login=:l, email=:m, lang=:langu where id=:id');
			$stmt->execute(array(':id' => $id,':l' => $l,':m' => $m,':langu' => $langu));


                ?>
                <div class="alert alert-success">
                    <?=lang('PROFILE_msg_ok');?>
                </div>
            <?php
            }
            if ($ec == 1) {
                ?>
                <div class="alert alert-danger">
                    <?=lang('PROFILE_msg_error');?>
                </div>
            <?php
            }
        }


        if ($mode == "edit_profile_pass") {
            $p_old=md5(($_POST['old_pass']));
            $p_new=md5(($_POST['new_pass']));
            $p_new2=md5(($_POST['new_pass2']));
            $id=($_POST['id']);
			
//echo $p_old." ".$p_new." ".$p_new2;




            /*$q_total="select pass from users where id='$id'";
            $res_total = mysql_query($q_total) or die(mysql_error());
            $total_ticket= mysql_fetch_assoc( $res_total );*/
            
            
            $stmt = $dbConnection->prepare('select pass from users where id=:id');
			$stmt->execute(array(':id' => $id));
			$total_ticket = $stmt->fetch(PDO::FETCH_ASSOC);
            
            
            $pass_orig=$total_ticket['pass'];

            $ec=0;

            if ($pass_orig <> $p_old) {
                $ec=1;
                $text=lang('PROFILE_msg_pass_err');
            }

            if ($p_new <> $p_new2) {
                $ec=1;
                $text=lang('PROFILE_msg_pass_err2');
            }

            if (strlen($p_new) < 3) {
                $ec=1;
                $text=lang('PROFILE_msg_pass_err3');
            }




            if ($ec == 0) {
                /*$query_update_ticket= "update users set pass='$p_new' where id='$id';";
                mysql_query ( $query_update_ticket )or die(mysql_error());*/
                
                
            $stmt = $dbConnection->prepare('update users set pass=:p_new where id=:id');
			$stmt->execute(array(':id' => $id,':p_new' => $p_new));
                
                session_destroy();
                unset($_SESSION);
                session_unset();
                setcookie('authhash_uid', "");
                setcookie('authhash_code', "");
                unset($_COOKIE['authhash_uid']);
                unset($_COOKIE['authhash_code']);


                ?>
                <div class="alert alert-success">
                    <?=lang('PROFILE_msg_pass_ok');?>
                </div>
            <?php
            }
            if ($ec == 1) {
                ?>
                <div class="alert alert-danger">
                    <?=lang('PROFILE_msg_te');?> <?=$text;?>
                </div>
            <?php
            }




        }


        if ($mode == "subj_del") {
            $id=($_POST['id']);
            
            /*$q="delete from subj where id='$id';";
            mysql_query ( $q )or die(mysql_error());*/
            
            $stmt = $dbConnection->prepare('delete from subj where id=:id');
			$stmt->execute(array(':id' => $id));

            //$results = mysql_query("select id, name from subj;");
    
    
    $stmt = $dbConnection->prepare('select id, name from subj');
	$stmt->execute();
	$res1 = $stmt->fetchAll();
	
            ?>



            <table class="table table-bordered table-hover" style=" font-size: 14px; " id="">
                <thead>
                <tr>
                    <th><center>ID</center></th>
                    <th><center><?=lang('TABLE_name');?></center></th>
                    <th><center><?=lang('TABLE_action');?></center></th>
                </tr>
                </thead>
                <tbody>
                <?php 
                foreach($res1 as $row) {
                //while ($row = mysql_fetch_assoc($results)) {
                ?>
                    <tr id="tr_<?=$row['id'];?>">


                        <td><small><?=$row['id'];?></small></td>
                        <td><small><?=$row['name'];?></small></td>
                        <td><small><center><button id="subj_del" type="button" class="btn btn-danger btn-xs" value="<?=$row['id'];?>">del</button></center></small></td>
                    </tr>
                <?php } ?>



                </tbody>
            </table>
            <br>
        <?


        }
        if ($mode == "deps_add") {
            $t=($_POST['text']);
            /*$q="insert into deps (name) values ('$t');";
            mysql_query ( $q )or die(mysql_error());
            */

			$stmt = $dbConnection->prepare('insert into deps (name) values (:t)');
			$stmt->execute(array(':t' => $t));



            //$results = mysql_query("select id, name from deps where id!='0';");
    
    $stmt = $dbConnection->prepare('select id, name from deps where id!=:n');
	$stmt->execute(array(':n' => '0'));
	$res1 = $stmt->fetchAll();
            ?>



            <table class="table table-bordered table-hover" style=" font-size: 14px; " id="">
                <thead>
                <tr>
                    <th><center>ID</center></th>
                    <th><center><?=lang('TABLE_name');?></center></th>
                    <th><center><?=lang('TABLE_action');?></center></th>
                </tr>
                </thead>
                <tbody>
                <?php 
                //while ($row = mysql_fetch_assoc($results)) {
	                foreach($res1 as $row) {
	                
                ?>
                    <tr id="tr_<?=$row['id'];?>">


                        <td><small><?=$row['id'];?></small></td>
                        <td><small><?=$row['name'];?></small></td>
                        <td><small><center><button id="deps_del" type="button" class="btn btn-danger btn-xs" value="<?=$row['id'];?>">del</button></center></small></td>
                    </tr>
                <?php } ?>



                </tbody>
            </table>
            <br>
        <?


        }
                if ($mode == "deps_del") {
            $id=($_POST['id']);
            /*$q="delete from deps where id='$id';";
            mysql_query ( $q )or die(mysql_error());*/
			$stmt = $dbConnection->prepare('delete from deps where id=:id');
			$stmt->execute(array(':id' => $id));
            
            //$results = mysql_query("select id, name from deps where id!='0';");
            
            $stmt = $dbConnection->prepare('select id, name from deps where id!=:n');
			$stmt->execute(array(':n' => '0'));
			$res1 = $stmt->fetchAll();
            ?>



            <table class="table table-bordered table-hover" style=" font-size: 14px; " id="">
                <thead>
                <tr>
                    <th><center>ID</center></th>
                    <th><center><?=lang('TABLE_name');?></center></th>
                    <th><center><?=lang('TABLE_action');?></center></th>
                </tr>
                </thead>
                <tbody>
                <?php 
                //while ($row = mysql_fetch_assoc($results)) {
	                foreach($res1 as $row) {
                ?>
                    <tr id="tr_<?=$row['id'];?>">


                        <td><small><?=$row['id'];?></small></td>
                        <td><small><?=$row['name'];?></small></td>
                        <td><small><center><button id="deps_del" type="button" class="btn btn-danger btn-xs" value="<?=$row['id'];?>">del</button></center></small></td>
                    </tr>
                <?php } ?>



                </tbody>
            </table>
            <br>
        <?


        }
        
        
                if ($mode == "subj_edit") {
            $v=($_POST['v']);
            $sid=($_POST['id']);
            
            /*$q="update subj set name='$v' where id='$sid';";
            mysql_query ( $q )or die(mysql_error());*/
            
            $stmt = $dbConnection->prepare('update subj set name=:v where id=:sid');
			$stmt->execute(array(':sid' => $sid,':v' => $v));

            //$results = mysql_query("select id, name from subj;");
           
            $stmt = $dbConnection->prepare('select id, name from subj');
			$stmt->execute();
			$res1 = $stmt->fetchAll();
            ?>



            <table class="table table-bordered table-hover" style=" font-size: 14px; " id="">
                <thead>
                <tr>
                    <th><center>ID</center></th>
                    <th><center><?=lang('TABLE_name');?></center></th>
                    <th><center><?=lang('TABLE_action');?></center></th>
                </tr>
                </thead>
                <tbody>
                <?php 
                foreach($res1 as $row) {
                //while ($row = mysql_fetch_assoc($results)) {
	                
                ?>
                    <tr id="tr_<?=$row['id'];?>">


                        <td><small><?=$row['id'];?></small></td>
                        <td><small><?=$row['name'];?></small></td>
                        <td><small><center><button id="subj_del" type="button" class="btn btn-danger btn-xs" value="<?=$row['id'];?>">del</button></center></small></td>
                    </tr>
                <?php } ?>



                </tbody>
            </table>
            <br>
        <?


        }
        
        
        
        
        if ($mode == "subj_add") {
            $t=($_POST['text']);
            
            /*$q="insert into subj (name) values ('$t');";
            mysql_query ( $q )or die(mysql_error());*/
			
			$stmt = $dbConnection->prepare('insert into subj (name) values (:t)');
			$stmt->execute(array(':t' => $t));
			
			

            //$results = mysql_query("select id, name from subj;");
            $stmt = $dbConnection->prepare('select id, name from subj');
			$stmt->execute();
			$res1 = $stmt->fetchAll();
            ?>



            <table class="table table-bordered table-hover" style=" font-size: 14px; " id="">
                <thead>
                <tr>
                    <th><center>ID</center></th>
                    <th><center><?=lang('TABLE_name');?></center></th>
                    <th><center><?=lang('TABLE_action');?></center></th>
                </tr>
                </thead>
                <tbody>
                <?php 
                foreach($res1 as $row) {
                //while ($row = mysql_fetch_assoc($results)) {
	                
                ?>
                    <tr id="tr_<?=$row['id'];?>">


                        <td><small><?=$row['id'];?></small></td>
                        <td><small><?=$row['name'];?></small></td>
                        <td><small><center><button id="subj_del" type="button" class="btn btn-danger btn-xs" value="<?=$row['id'];?>">del</button></center></small></td>
                    </tr>
                <?php } ?>



                </tbody>
            </table>
            <br>
        <?


        }

        if ($mode == "posada_add") {
            $t=($_POST['text']);
            /*$q="insert into posada (name) values ('$t');";
            mysql_query ( $q )or die(mysql_error());

            $results = mysql_query("select id, name from posada;");
            */
            
            
            $stmt = $dbConnection->prepare('insert into posada (name) values (:t)');
			$stmt->execute(array(':t' => $t));

            $stmt = $dbConnection->prepare('select id, name from posada');
			$stmt->execute();
			$res1 = $stmt->fetchAll();
			
			
            ?>



            <table class="table table-bordered table-hover" style=" font-size: 14px; " id="">
                <thead>
                <tr>
                    <th><center>ID</center></th>
                    <th><center><?=lang('TABLE_name');?></center></th>
                    <th><center><?=lang('TABLE_action');?></center></th>
                </tr>
                </thead>
                <tbody>
                <?php 
                foreach($res1 as $row) {
                //while ($row = mysql_fetch_assoc($results)) {
	                
                ?>
                    <tr id="tr_<?=$row['id'];?>">


                        <td><small><?=$row['id'];?></small></td>
                        <td><small><?=$row['name'];?></small></td>
                        <td><small><center><button id="posada_del" type="button" class="btn btn-danger btn-xs" value="<?=$row['id'];?>">del</button></center></small></td>
                    </tr>
                <?php } ?>



                </tbody>
            </table>
            <br>
        <?


        }

        if ($mode == "posada_del") {
            $id=($_POST['id']);
            
            /*$q="delete from posada where id='$id';";
            mysql_query ( $q )or die(mysql_error());
//echo($q);
            $results = mysql_query("select id, name from posada;");
            */
            
            
            $stmt = $dbConnection->prepare('delete from posada where id=:id');
			$stmt->execute(array(':id' => $id));

            $stmt = $dbConnection->prepare('select id, name from posada');
			$stmt->execute();
			$res1 = $stmt->fetchAll();
            ?>



            <table class="table table-bordered table-hover" style=" font-size: 14px; " id="">
                <thead>
                <tr>
                    <th><center>ID</center></th>
                    <th><center><?=lang('TABLE_name');?></center></th>
                    <th><center><?=lang('TABLE_action');?></center></th>
                </tr>
                </thead>
                <tbody>
                <?php 
                foreach($res1 as $row) {
                //while ($row = mysql_fetch_assoc($results)) {
	                
                ?>
                    <tr id="tr_<?=$row['id'];?>">


                        <td><small><?=$row['id'];?></small></td>
                        <td><small><?=$row['name'];?></small></td>
                        <td><small><center><button id="posada_del" type="button" class="btn btn-danger btn-xs" value="<?=$row['id'];?>">del</button></center></small></td>
                    </tr>
                <?php } ?>



                </tbody>
            </table>
            <br>
        <?


        }


        if ($mode == "units_add") {
            $t=($_POST['text']);
            
            /*
            $q="insert into units (name) values ('$t');";
            mysql_query ( $q )or die(mysql_error());

            $results = mysql_query("select id, name from units;");
            */
            
            $stmt = $dbConnection->prepare('insert into units (name) values (:t)');
			$stmt->execute(array(':t' => $t));

            $stmt = $dbConnection->prepare('select id, name from units');
			$stmt->execute();
			$res1 = $stmt->fetchAll();
            ?>



            <table class="table table-bordered table-hover" style=" font-size: 14px; " id="">
                <thead>
                <tr>
                    <th><center>ID</center></th>
                    <th><center><?=lang('TABLE_name');?></center></th>
                    <th><center><?=lang('TABLE_action');?></center></th>
                </tr>
                </thead>
                <tbody>
                <?php 
                foreach($res1 as $row) {
                //while ($row = mysql_fetch_assoc($results)) {
	                
                ?>
                    <tr id="tr_<?=$row['id'];?>">


                        <td><small><?=$row['id'];?></small></td>
                        <td><small><?=$row['name'];?></small></td>
                        <td><small><center><button id="units_del" type="button" class="btn btn-danger btn-xs" value="<?=$row['id'];?>">del</button></center></small></td>
                    </tr>
                <?php } ?>



                </tbody>
            </table>
            <br>
        <?


        }
        if ($mode == "units_del") {
            $id=($_POST['id']);
            
            /*$q="delete from units where id='$id';";
            mysql_query ( $q )or die(mysql_error());
//echo($q);
            $results = mysql_query("select id, name from units;");
            */
            
            
            
            $stmt = $dbConnection->prepare('delete from units where id=:id');
			$stmt->execute(array(':id' => $id));

            $stmt = $dbConnection->prepare('select id, name from units');
			$stmt->execute();
			$res1 = $stmt->fetchAll();
            
            ?>



            <table class="table table-bordered table-hover" style=" font-size: 14px; " id="">
                <thead>
                <tr>
                    <th><center>ID</center></th>
                    <th><center><?=lang('TABLE_name');?></center></th>
                    <th><center><?=lang('TABLE_action');?></center></th>
                </tr>
                </thead>
                <tbody>
                <?php 
                foreach($res1 as $row) {
                //while ($row = mysql_fetch_assoc($results)) {
	                
                ?>
                    <tr id="tr_<?=$row['id'];?>">


                        <td><small><?=$row['id'];?></small></td>
                        <td><small><?=$row['name'];?></small></td>
                        <td><small><center><button id="units_del" type="button" class="btn btn-danger btn-xs" value="<?=$row['id'];?>">del</button></center></small></td>
                    </tr>
                <?php } ?>



                </tbody>
            </table>
            <br>
        <?


        }
        if ($mode == "send_zapit_add") {
            $pib=($_POST['pib']);
            $login=($_POST['login']);
            $posada=($_POST['posada']);
            $pid=($_POST['pid']);
            $tel=($_POST['tel']);
            $adr=($_POST['adr']);
            $mail=($_POST['mail']);
            //$uf=$_SESSION['helpdesk_user_id'];
            //$id=$_POST['id_client'];

            /*$query_add_ticket_log = "insert into clients
(fio, tel, login, unit_desc, adr, email, posada)
VALUES ('$pib', '$tel', '$login', '$pid', '$adr', '$mail',  '$posada');";
            mysql_query ( $query_add_ticket_log )or die(mysql_error());*/
            
            
            $stmt = $dbConnection->prepare('insert into clients
			(fio, tel, login, unit_desc, adr, email, posada)
			VALUES (:pib, :tel, :login, :pid, :adr, :mail,  :posada)');
			$stmt->execute(array(':pib' => $pib,':tel' => $tel,':login' => $login,':pid' => $pid,':adr' => $adr,':mail' => $mail,':posada' => $posada));
			
			
            ?>
            <div class="alert alert-success">
                <?=lang('PROFILE_msg_send');?>
            </div>
        <?php
        }
        
                if ($mode == "send_zapit_edit_ok") {
            $pib=($_POST['pib']);
            $login=($_POST['login']);
            $posada=($_POST['posada']);
            $pid=($_POST['pid']);
            $tel=($_POST['tel']);
            $adr=($_POST['adr']);
            $mail=($_POST['mail']);
            //$uf=$_SESSION['helpdesk_user_id'];
            $id=($_POST['id_client']);

            /*$query_add_ticket_log = "update clients set
fio='$pib', tel='$tel', login='$login', unit_desc='$pid', adr='$adr', email='$mail', posada='$posada' where id = '$id';";
            mysql_query ( $query_add_ticket_log )or die(mysql_error());*/
            
			$stmt = $dbConnection->prepare('update clients set
fio=:pib, tel=:tel, login=:login, unit_desc=:pid, adr=:adr, email=:mail, posada=:posada where id = :id');
			$stmt->execute(array(':pib' => $pib,':tel' => $tel,':login' => $login,':pid' => $pid,':adr' => $adr,':mail' => $mail,':posada' => $posada, ':id'=>$id));
            ?>
            <div class="alert alert-success">
                <?=lang('PROFILE_msg_ok');?>
            </div>
        <?php
        }
        
        
        if ($mode == "send_zapit_edit") {
            $pib=($_POST['pib']);
            $login=($_POST['login']);
            $posada=($_POST['posada']);
            $pid=($_POST['pid']);
            $tel=($_POST['tel']);
            $adr=($_POST['adr']);
            $mail=($_POST['mail']);
            $uf=$_SESSION['helpdesk_user_id'];
            $id=($_POST['id_client']);

            /*$query_add_ticket_log = "insert into approved_info
(client_id, fio, tel, login, unit_desc, adr, email, posada, user_from, date_app)
VALUES ('$id', '$pib', '$tel', '$login', '$pid', '$adr', '$mail',  '$posada', '$uf', now())";
            mysql_query ( $query_add_ticket_log )or die(mysql_error());*/
            
            
            $stmt = $dbConnection->prepare('insert into approved_info
(client_id, fio, tel, login, unit_desc, adr, email, posada, user_from, date_app)
VALUES (:id, :pib, :tel, :login, :pid, :adr, :mail,  :posada, :uf, now())');
			$stmt->execute(array(':pib' => $pib,':tel' => $tel,':login' => $login,':pid' => $pid,':adr' => $adr,':mail' => $mail,':posada' => $posada, ':uf'=>$uf));

            
            ?>
            <div class="alert alert-success">
                <?=lang('PROFILE_msg_send');?>
            </div>
        <?php
        }


        if ($mode == "arch_now") {
            $user=($_POST['user']);
            $tid=($_POST['tid']);

            /*$clientquery="SELECT arch FROM tickets where id='$tid';";
            $resclient = mysql_query($clientquery) or die(mysql_error());
            $fio= mysql_fetch_assoc( $resclient );*/
            
$stmt = $dbConnection->prepare('SELECT arch FROM tickets where id=:tid');
$stmt->execute(array(':tid' => $tid));
$fio = $stmt->fetch(PDO::FETCH_ASSOC);

            $s=$fio['arch'];

            if ($s == "0") {
                //$query_update_ticket= "update tickets set arch='1', last_update=now() where id='$tid'";
                
                $stmt = $dbConnection->prepare('update tickets set arch=:n1, last_update=now() where id=:tid');
                $stmt->execute(array(':tid' => $tid,':n1' => '1'));
            }
            if ($s == "1") {
                //$query_update_ticket= "update tickets set arch='0', last_update=now() where id='$tid'";
                $stmt = $dbConnection->prepare('update tickets set arch=:n1, last_update=now() where id=:tid');
                $stmt->execute(array(':tid' => $tid,':n1' => '0'));
            }
            //mysql_query ( $query_update_ticket )or die(mysql_error());
            
            
            
            
            $unow=$_SESSION['helpdesk_user_id'];
            /*
            $query_atl = "INSERT INTO ticket_log (msg, date_op, init_user_id, ticket_id)
values ('arch', now(), '$unow', '$tid'); ";
            mysql_query ( $query_atl )or die(mysql_error());*/
            
                $stmt = $dbConnection->prepare('INSERT INTO ticket_log (msg, date_op, init_user_id, ticket_id)
values (:ar, now(), :unow, :tid');
                $stmt->execute(array(':tid' => $tid,':unow' => $unow, ':ar'=>'arch'));
                
                
        }
/*
        if ($mode == "del_now") {
            $user=($_POST['user']);
            $tid=($_POST['tid']);

            $query_update_ticket= "delete from tickets where id='$tid'";
            mysql_query ( $query_update_ticket )or die(mysql_error());
            $query_update_ticket= "delete from comments where t_id='$tid'";
            mysql_query ( $query_update_ticket )or die(mysql_error());
            $query_update_ticket= "delete from ticket_log where ticket_id='$tid'";
            mysql_query ( $query_update_ticket )or die(mysql_error());
        }
*/
        if ($mode == "status_no_ok") {
            $user=($_POST['user']);
            $tid=($_POST['tid']);



//проверить если уже status='1' и ok_by != $user




            /*$clientquery="SELECT status, ok_by FROM tickets where id='$tid';";
            $resclient = mysql_query($clientquery) or die(mysql_error());
            $fio= mysql_fetch_assoc( $resclient );*/


			$stmt = $dbConnection->prepare('SELECT status, ok_by FROM tickets where id=:tid');
			$stmt->execute(array(':tid' => $tid));
			$fio = $stmt->fetch(PDO::FETCH_ASSOC);

            $st=$fio['status'];
            $ob=$fio['ok_by'];

            $ps=priv_status($ob);



            if ($st == "0") {
                /*$query_update_ticket= "update tickets set ok_by='$user', status='1', ok_date=now(), last_update=now() where id='$tid'";
                mysql_query ( $query_update_ticket )or die(mysql_error());*/

			$stmt = $dbConnection->prepare('update tickets set ok_by=:user, status=:s, ok_date=now(), last_update=now() where id=:tid');
			$stmt->execute(array(':s'=>'1',':tid' => $tid,':user'=>$user));
			

                $unow=$_SESSION['helpdesk_user_id'];
                
                
                /*$query_atl = "INSERT INTO ticket_log (msg, date_op, init_user_id, ticket_id)
values ('ok', now(), '$unow', '$tid'); ";
                mysql_query ( $query_atl )or die(mysql_error());*/
                
            $stmt = $dbConnection->prepare('INSERT INTO ticket_log (msg, date_op, init_user_id, ticket_id)
values (:ok, now(), :unow, :tid)');
			$stmt->execute(array(':ok'=>'ok',':tid' => $tid,':unow'=>$unow));

                ?>

                <div class="alert alert-success"><i class="fa fa-check"></i> <?=lang('TICKET_msg_OK');?></div>

            <?php
            }
            if ($st == "1") {



                ?>

                <div class="alert alert-danger"><?=lang('TICKET_msg_OK_error');?> <?=name_of_user($ob);?></div>

            <?php
            }
        }
        if ($mode == "status_ok") {

            $user=($_POST['user']);
            $tid=($_POST['tid']);


            /*$clientquery="SELECT status, ok_by, user_init_id FROM tickets where id='$tid';";
            $resclient = mysql_query($clientquery) or die(mysql_error());
            $fio= mysql_fetch_assoc( $resclient );*/
            
            $stmt = $dbConnection->prepare('SELECT status, ok_by, user_init_id FROM tickets where id=:tid');
			$stmt->execute(array(':tid' => $tid));
			$fio = $stmt->fetch(PDO::FETCH_ASSOC);
			
			

            $st=$fio['status'];
            $ob=$fio['ok_by'];
            $uinitd=$fio['user_init_id'];

            $ps=priv_status($user);



            if ($st == "1") {

//echo $ps;
//////////////////////////////////////////////////////////////////////////////////////////
                if ( ($ob == $user) || ($ps == "0") || ($ps == "2") || ($uinitd == $user)) {

                    /*$query_update_ticket= "update tickets set ok_by='0', status='0', last_update=now() where id='$tid'";
                    mysql_query ( $query_update_ticket )or die(mysql_error());
                    */
                    
                    $stmt = $dbConnection->prepare('update tickets set ok_by=:n, status=:n1, last_update=now() where id=:tid');
					$stmt->execute(array(':tid' => $tid, ':n'=>'0',':n1'=>'0'));
                    
                    
                    
                    $unow=$_SESSION['helpdesk_user_id'];
                    
                    /*$query_atl = "INSERT INTO ticket_log (msg, date_op, init_user_id, ticket_id)
values ('no_ok', now(), '$unow', '$tid'); ";
                    mysql_query ( $query_atl )or die(mysql_error());*/
                    
                    $stmt = $dbConnection->prepare('INSERT INTO ticket_log (msg, date_op, init_user_id, ticket_id)
values (:no_ok, now(), :unow, :tid');
					$stmt->execute(array(':tid' => $tid, ':unow'=>$unow,':no_ok'=>'no_ok'));
                    ?>

                    <div class="alert alert-success"><i class="fa fa-check"></i> <?=lang('TICKET_msg_unOK');?></div>

                <?php
                }
            }
            if ($st == "0") {
                ?>
                <div class="alert alert-danger"><?=lang('TICKET_msg_unOK_error');?></div>
            <?php
            }


        }

        if ($mode == "lock") {
            $user=($_POST['user']);
            $tid=($_POST['tid']);
//проверить если уже lock_by != $user




            /*$clientquery="SELECT lock_by FROM tickets where id='$tid';";
            $resclient = mysql_query($clientquery) or die(mysql_error());
            $fio= mysql_fetch_assoc( $resclient );*/
            
            
            $stmt = $dbConnection->prepare('SELECT lock_by FROM tickets where id=:tid');
			$stmt->execute(array(':tid' => $tid));
			$fio = $stmt->fetch(PDO::FETCH_ASSOC);
			

//$st=$fio['status'];
            $lb=$fio['lock_by'];

            $ps=priv_status($lb);



            if ($lb == "0") {

//if ( ($ob == $user) || ($ps == "0")) {


                /*$query_update_ticket= "update tickets set lock_by='$user', last_update=now() where id='$tid'";
                mysql_query ( $query_update_ticket )or die(mysql_error());
                */
                
            $stmt = $dbConnection->prepare('update tickets set lock_by=:user, last_update=now() where id=:tid');
			$stmt->execute(array(':tid' => $tid, ':user'=>$user));
                
                $unow=$_SESSION['helpdesk_user_id'];
                
                /*$query_atl = "INSERT INTO ticket_log (msg, date_op, init_user_id, ticket_id)
values ('lock', now(), '$unow', '$tid'); ";
                mysql_query ( $query_atl )or die(mysql_error());*/
            
            $stmt = $dbConnection->prepare('INSERT INTO ticket_log (msg, date_op, init_user_id, ticket_id)
values (:lock, now(), :unow, :tid');
			$stmt->execute(array(':tid' => $tid, ':unow'=>$unow, ':lock'=>'lock'));
                ?>

                <div class="alert alert-success"><i class="fa fa-check"></i> <?=lang('TICKET_msg_lock');?></div>

            <?php
            }
            if ($lb <> "0") {



                ?>
                <div class="alert alert-danger"><?=lang('TICKET_msg_lock_error');?> <?=name_of_user($lb);?></div>
            <?php
            }





        }
        if ($mode == "unlock") {
//$user=$_POST['user'];
            $tid=($_POST['tid']);



            /*$query_update_ticket= "update tickets set lock_by='0', last_update=now() where id='$tid'";
            mysql_query ( $query_update_ticket )or die(mysql_error());*/
            
            $stmt = $dbConnection->prepare('update tickets set lock_by=:n, last_update=now() where id=:tid');
			$stmt->execute(array(':tid' => $tid, ':n'=>'0'));
            
            
            $unow=$_SESSION['helpdesk_user_id'];
            
            
            /*$query_atl = "INSERT INTO ticket_log (msg, date_op, init_user_id, ticket_id)
values ('unlock', now(), '$unow', '$tid'); ";
            mysql_query ( $query_atl )or die(mysql_error());*/
            
            $stmt = $dbConnection->prepare('INSERT INTO ticket_log (msg, date_op, init_user_id, ticket_id)
values (:unlock, now(), :unow, :tid');
			$stmt->execute(array(':tid' => $tid, ':unow'=>$unow, ':unlock'=>'unlock'));

            ?>

            <div class="alert alert-success"><i class="fa fa-check"></i> <?=lang('TICKET_msg_unlock');?></div>

        <?php
        }



        if ($mode == "update_to") {


            $tid=($_POST['ticket_id']);
            $to=($_POST['to']);
            $tou=($_POST['tou']);
            $tom=($_POST['tom']);
			$x_refer_comment='<small class=\"text-muted\">'.nameshort(name_of_user_ret($_SESSION['helpdesk_user_id'])).' '.lang('REFER_comment_add').' ('.date(' d.m.Y h:i:s').'):</small> '.strip_tags(xss_clean(($_POST['tom'])));
//echo "refer";
            /*$query_update_ticket= "update tickets set unit_id='$to', user_to_id='$tou', msg=concat(msg,'<br>','$x_refer_comment'), lock_by='0', last_update=now() where id='$tid'";
            mysql_query ( $query_update_ticket )or die(mysql_error());*/
            
            $stmt = $dbConnection->prepare('update tickets set unit_id=:to, user_to_id=:tou, msg=concat(msg,:br,:x_refer_comment), lock_by=:n, last_update=now() where id=:tid');
			$stmt->execute(array(':to'=>$to,':tou'=>$tou,':br'=>'<br>',':x_refer_comment'=>$x_refer_comment,':tid' => $tid, ':n'=>'0'));
            
            
            
//echo $query_update_ticket;

            $unow=$_SESSION['helpdesk_user_id'];
            
            /*$query_add_ticket_log = "INSERT INTO ticket_log (msg, date_op, init_user_id, to_user_id, ticket_id, to_unit_id)
values ('refer', now(), '$unow', '$tou', '$tid', '$to'); ";
//echo $query_add_ticket_log;
            mysql_query ( $query_add_ticket_log )or die(mysql_error());
            */
            
            $stmt = $dbConnection->prepare('INSERT INTO ticket_log (msg, date_op, init_user_id, to_user_id, ticket_id, to_unit_id) values (:refer, now(), :unow, :tou, :tid, :to)');
			$stmt->execute(array(':to'=>$to,':tou'=>$tou,':refer'=>'refer',':tid' => $tid, ':unow'=>$unow));





            if ($tou == "0") {
                send_mail_to('new_all',$tid);
            }

            if ($tou <> "0") {
                send_mail_to('new_user',$tid);
                send_mail_to('new_coord',$tid);
            }





            ?>
            <div class="alert alert-success"><?=lang('TICKET_msg_refer');?></div>
        <?php
        }


        if ($mode == "add_user") {
            $fio=($_POST['fio']);
            $login=($_POST['login']);
            $pass=md5(($_POST['pass']));
//$unit[]=$_POST['unit'];
            $priv=($_POST['priv']);
            $mail=($_POST['mail']);
            $mess=($_POST['mess']);
            $lang=($_POST['lang']);
            $hidden=array();
            $hidden = ($_POST['unit']); //get the values from the keeporder
            print_r($hidden);
			$unit=($_POST['unit']);

            /*$query_add_ticket_log = "INSERT INTO users (fio, login, pass, status, priv, unit, email, messages, lang)
values ('$fio', '$login', '$pass', '1', '$priv', '$unit', '$mail', '$mess', '$lang'); ";
mysql_query ( $query_add_ticket_log )or die(mysql_error());*/

 $stmt = $dbConnection->prepare('INSERT INTO users (fio, login, pass, status, priv, unit, email, messages, lang)
values (:fio, :login, :pass, :one, :priv, :unit, :mail, :mess, :lang)');
 $stmt->execute(array(':fio'=>$fio, ':login'=>$login, ':pass'=>$pass, ':one'=>'1', ':priv'=>$priv, ':unit'=>$unit, ':mail'=>$mail, ':mess'=>$mess, ':lang'=>$mess));




        }


        if ($mode == "edit_ticket_subj") {
            $v=($_POST['value']);
            $pk=($_POST['pk']);
            
            /*$query_add_ticket_log = "update tickets set subj='$v', last_edit=now(), last_update=now() where id='$pk';";
            mysql_query ( $query_add_ticket_log )or die(mysql_error());*/

			 $stmt = $dbConnection->prepare('update tickets set subj=:v, last_edit=now(), last_update=now() where id=:pk');
			 $stmt->execute(array(':v'=>$v, ':pk'=>$pk));
 

            $unow=$_SESSION['helpdesk_user_id'];
            
            /*$query_atl = "INSERT INTO ticket_log (msg, date_op, init_user_id, ticket_id)
values ('edit_subj', now(), '$unow', '$pk'); ";
            mysql_query ( $query_atl )or die(mysql_error());
            */
            
			 $stmt = $dbConnection->prepare('INSERT INTO ticket_log (msg, date_op, init_user_id, ticket_id)
values (:edit_subj, now(), :unow, :pk');
			 $stmt->execute(array(':edit_subj'=>'edit_subj', ':pk'=>$pk,':unow'=>$unow));

        }

        if ($mode == "edit_ticket_msg") {
            $v=($_POST['value']);
            $pk=($_POST['pk']);
            
            
            /*$query_add_ticket_log = "update tickets set msg='$v', last_edit=now(), last_update=now() where id='$pk';";
            mysql_query ( $query_add_ticket_log )or die(mysql_error());
            */
            
            
            $stmt = $dbConnection->prepare('update tickets set msg=:v, last_edit=now(), last_update=now() where id=:pk');
			$stmt->execute(array(':v'=>$v, ':pk'=>$pk));

            $unow=$_SESSION['helpdesk_user_id'];
            
            /*$query_atl = "INSERT INTO ticket_log (msg, date_op, init_user_id, ticket_id)
values ('edit_msg', now(), '$unow', '$pk'); ";
            mysql_query ( $query_atl )or die(mysql_error());*/
            
            $stmt = $dbConnection->prepare('INSERT INTO ticket_log (msg, date_op, init_user_id, ticket_id)
values (:edit_msg, now(), :unow, :pk');
			$stmt->execute(array(':edit_msg'=>'edit_msg', ':pk'=>$pk,':unow'=>$unow));
            
            
        }

        if ($mode == "view_comment") {


            $tid_comment=($_POST['tid']);
			view_comment($tid_comment);
                        
            
        }

        if ($mode == "add_comment") {

            $user_comment=($_POST['user']);
            $tid_comment=($_POST['tid']);
			$text_comment=strip_tags(xss_clean(($_POST['textmsg'])));

            /*$query_add_comment = "INSERT INTO comments (t_id, user_id, comment_text, dt)
values ('$tid_comment', '$user_comment', '$text_comment', now()); ";
			mysql_query ( $query_add_comment )or die(mysql_error());*/
			
			
			$stmt = $dbConnection->prepare('INSERT INTO comments (t_id, user_id, comment_text, dt)
values (:tid_comment, :user_comment, :text_comment, now())');
			$stmt->execute(array(':tid_comment'=>$tid_comment, ':user_comment'=>$user_comment,':text_comment'=>$text_comment));
			

            /*$query_atl = "INSERT INTO ticket_log (msg, date_op, init_user_id, ticket_id)
values ('comment', now(), '$user_comment', '$tid_comment'); ";
            mysql_query ( $query_atl )or die(mysql_error());*/
            
            $stmt = $dbConnection->prepare('INSERT INTO ticket_log (msg, date_op, init_user_id, ticket_id)
values (:comment, now(), :user_comment, :tid_comment)');
			$stmt->execute(array(':tid_comment'=>$tid_comment, ':user_comment'=>$user_comment,':comment'=>'comment'));


//echo $query_add_comment;

           /* $query_add_ticket_log = "update tickets set last_update=now() where id='$tid_comment';";
            mysql_query ( $query_add_ticket_log )or die(mysql_error());
            */

            $stmt = $dbConnection->prepare('update tickets set last_update=now() where id=:tid_comment');
			$stmt->execute(array(':tid_comment'=>$tid_comment));


            view_comment($tid_comment);
        }

        if ($mode == "edit_user") {
            $fio=($_POST['fio']);
            $login=($_POST['login']);

            $unit=($_POST['unit']);
            $priv=($_POST['priv']);
            $status=($_POST['status']);
            $usid=($_POST['idu']);
            $mail=($_POST['mail']);
			$mess=($_POST['mess']);
			$lang=($_POST['lang']);
            if (strlen($_POST['pass'])>1) { 
            $p=md5($_POST['pass']); 
            $stmt = $dbConnection->prepare('update users set fio=:fio, login=:login,pass=:pass status=:status, priv=:priv, unit=:unit, email=:mail, messages=:mess, lang=:lang where id=:usid');
			 $stmt->execute(array(':fio'=>$fio, ':login'=>$login, ':status'=>$status, ':priv'=>$priv, ':unit'=>$unit, ':mail'=>$mail, ':mess'=>$mess, ':lang'=>$mess, ':usid'=>$usid, ':pass'=>$pass));

            }
            else { $p=""; 
	            $stmt = $dbConnection->prepare('update users set fio=:fio, login=:login, status=:status, priv=:priv, unit=:unit, email=:mail, messages=:mess, lang=:lang where id=:usid');
			 $stmt->execute(array(':fio'=>$fio, ':login'=>$login, ':status'=>$status, ':priv'=>$priv, ':unit'=>$unit, ':mail'=>$mail, ':mess'=>$mess, ':lang'=>$mess, ':usid'=>$usid));

            }

            /*$query_add_ticket_log = "update users set fio='$fio', login='$login', ".$p." status='$status', priv='$priv', unit='$unit', email='$mail', messages='$mess', lang='$lang' where id='$usid';";
			mysql_query ( $query_add_ticket_log )or die(mysql_error());
			*/
			
			 
 
 
 
        }

if ($mode == "upload_file") {
$name=$_POST['name'];
$hn=$_POST['hn'];
//$obj = json_decode($name);
//$name=$obj->{'name'};
/*$query_add_ticket_log = "insert into files (name, h_name) VALUES ('$name', '$hn')";
mysql_query ( $query_add_ticket_log )or die(mysql_error());
*/


	         $stmt = $dbConnection->prepare('insert into files (name, h_name) VALUES (:name, :hn)');
			 $stmt->execute(array(':name'=>$name, ':hn'=>$hn));
			 
			 
//var_dump(json_decode($name));
}

        if ($mode == "add_ticket") {
            $type=($_POST['type_add']);
            ///////////
            $user_init_id=($_POST['user_init_id']);
            $user_to_id=($_POST['user_do']);
            $subj=strip_tags(xss_clean(($_POST['subj'])));
            $msg=strip_tags(xss_clean(($_POST['msg'])));
            $status='0';
            $unit_id=($_POST['unit_id']);
            $prio=($_POST['prio']);
            ///////////
            $client_fio=strip_tags(xss_clean(($_POST['fio'])));
            $client_tel=strip_tags(xss_clean(($_POST['tel'])));
            $client_login=strip_tags(xss_clean(($_POST['login'])));
            $unit_desc=strip_tags(xss_clean(($_POST['pod'])));

            $client_adr=strip_tags(xss_clean(($_POST['adr'])));
            //$client_tel=$_POST['tel'];
            $client_mail=strip_tags(xss_clean(($_POST['mail'])));
            $client_posada=strip_tags(xss_clean(($_POST['posada'])));

            $client_id_param=($_POST['client_id_param']);

            if ($client_fio == "пусто") {$client_fio="";}
            if ($client_tel == "пусто") {$client_tel="";}
            if ($client_login == "пусто") {$client_login="";}
            if ($unit_desc == "пусто") {$unit_desc="";}
            if ($client_adr == "пусто") {$client_adr="";}
            if ($client_mail == "пусто") {$client_mail="";}
            if ($client_posada == "пусто") {$client_posada="";}


            if ($type == "add") {

                /*$queryid="SELECT MAX(id) max_id FROM clients";
                $res1 = mysql_query($queryid) or die(mysql_error());
                $max= mysql_fetch_array( $res1 );*/
                
                
                    $stmt = $dbConnection->prepare("SELECT MAX(id) max_id FROM clients");
					$stmt->execute();
					$max = $stmt->fetch(PDO::FETCH_NUM);
                
                $max_id=$max[0]+1;
                $hashname=($_POST['hashname']);
                
                
                /*$query_add_client= "insert into clients
(id, fio, tel, login, unit_desc, adr, email, posada)
VALUES ('$max_id', '$client_fio', '$client_tel', '$client_login', '$unit_desc', '$client_adr',  '$client_mail', '$client_posada')";
                mysql_query ( $query_add_client )or die(mysql_error());*/



			 $stmt = $dbConnection->prepare('insert into clients 
			 (id, fio, tel, login, unit_desc, adr, email, posada)
			 VALUES 
			 (:max_id, :client_fio, :client_tel, :client_login, :unit_desc, :client_adr,  :client_mail, :client_posada)');
			 $stmt->execute(array(
			 ':max_id'			=>	$max_id, 
			 ':client_fio'		=>	$client_fio, 
			 ':client_tel'		=>	$client_tel,
			 ':client_login'	=>	$client_login, 
			 ':unit_desc'		=>	$unit_desc, 
			 ':client_adr'		=>	$client_adr, 
			 ':client_mail'		=>	$client_mail, 
			 ':client_posada'	=>	$client_posada));


                /*$queryid_ticket="SELECT MAX(id) max_id FROM tickets";
                $res1_ticket = mysql_query($queryid_ticket) or die(mysql_error());
                $max_id_ticket= mysql_fetch_array( $res1_ticket );*/
                
                    $stmt = $dbConnection->prepare("SELECT MAX(id) max_id FROM tickets");
					$stmt->execute();
					$max_id_ticket = $stmt->fetch(PDO::FETCH_NUM);
                
                
                $max_id_res_ticket=$max_id_ticket[0]+1;


                /*$query_add_ticket = "INSERT INTO tickets
								(id, user_init_id,user_to_id,date_create,subj,msg, client_id, unit_id, status, hash_name, prio, last_update) 
								VALUES 
								('$max_id_res_ticket', '$user_init_id','$user_to_id', now(),'$subj', '$msg','$max_id','$unit_id', '$status', '$hashname', '$prio', now())";
                mysql_query ( $query_add_ticket ) or die(mysql_error());*/
                
                $stmt = $dbConnection->prepare('INSERT INTO tickets
				(id, user_init_id,user_to_id,date_create,subj,msg, client_id, unit_id, status, hash_name, prio, last_update) 
				VALUES 
				(:max_id_res_ticket, :user_init_id, :user_to_id, now(),:subj, :msg,:max_id,:unit_id, :status, :hashname, :prio, now())');
			
			 $stmt->execute(array(
			 ':max_id_res_ticket'	=>	$max_id_res_ticket,
			 ':user_init_id'		=>	$user_init_id,
			 ':user_to_id'			=>	$user_to_id,
			 ':subj'				=>	$subj,
			 ':msg'					=>	$msg,
			 ':max_id'				=>	$max_id,
			 ':unit_id'				=>	$unit_id,
			 ':status'				=>	$status,
			 ':hashname'			=>	$hashname,
			 ':prio'				=>	$prio));
                
                
                
                
                

                /*$unow=$_SESSION['helpdesk_user_id'];
                $query_atl = "INSERT INTO ticket_log (msg, date_op, init_user_id, ticket_id, to_user_id, to_unit_id)
values ('create', now(), '$unow', '$max_id_res_ticket', '$user_to_id', '$unit_id'); ";
                mysql_query ( $query_atl )or die(mysql_error());*/
                
                
               $stmt = $dbConnection->prepare('INSERT INTO ticket_log (msg, date_op, init_user_id, ticket_id, to_user_id, to_unit_id) values (:create, now(), :unow, :max_id_res_ticket, :user_to_id, :unit_id)');
			 
			   $stmt->execute(array(':create'=>'create', ':unow'=>$unow,':max_id_res_ticket'=>$max_id_res_ticket,':user_to_id'=>$user_to_id,':unit_id'=>$unit_id));
                
                
                //ОТПРАВКА ПИСЬМА
                /*
                Если задано Подразделение (ВСЕМ) - то письмо начальнику, всему подразделению
                Если задано Подразделение и ПОЛЬЗОВАТЕЛЬ - то письмо начальнику, и пользователю

                if ($user_to_id == "0") {
                send_mail_to('new_all',$max_id_res_ticket);
                }

                if ($user_to_id <> "0") {
                send_mail_to('new_user',$max_id_res_ticket);
                send_mail_to('new_coord',$max_id_res_ticket);
                }

                send_mail_to('new',$max_id_res_ticket);
                */

                if ($user_to_id == "0") {
                    send_mail_to('new_all',$max_id_res_ticket);
                }

                else if ($user_to_id <> "0") {
                    send_mail_to('new_user',$max_id_res_ticket);
                    send_mail_to('new_coord',$max_id_res_ticket);
                }


                echo($hashname);
            }
            if ($type == "edit") {

                $hashname=($_POST['hashname']);
                /*
                $query_add_client= "update clients set tel='$client_tel', login='$client_login', unit_desc='$unit_desc', adr='$client_adr', email='$client_mail', posada='$client_posada' where id='$client_id_param'";
                mysql_query ( $query_add_client )or die(mysql_error());*/
                $stmt = $dbConnection->prepare('update clients set tel=:client_tel, login=:client_login, unit_desc=:unit_desc, adr=:client_adr, email=:client_mail, posada=:client_posada where id=:client_id_param');
                
			 $stmt->execute(array(':client_tel'=>$client_tel, ':client_login'=>$client_login, ':unit_desc'=>$unit_desc, ':client_adr'=>$client_adr, ':client_mail'=>$client_mail, ':client_posada'=>$client_posada, ':client_id_param'=>$client_id_param));
                
                
                
//echo $query_add_client;		

                /*$queryid_ticket="SELECT MAX(id) max_id FROM tickets";
                $res1_ticket = mysql_query($queryid_ticket) or die(mysql_error());
                $max_id_ticket= mysql_fetch_array( $res1_ticket );
                */
                
                
                    $stmt = $dbConnection->prepare("SELECT MAX(id) max_id FROM tickets");
					$stmt->execute();
					$max_id_ticket = $stmt->fetch(PDO::FETCH_NUM);
                
                
                $max_id_res_ticket=$max_id_ticket[0]+1;


                /*$query_add_ticket = "INSERT INTO tickets
								(id, user_init_id,user_to_id,date_create,subj,msg, client_id, unit_id, status, hash_name, prio,last_update) 
								VALUES 
								('$max_id_res_ticket', '$user_init_id','$user_to_id', now(),'$subj', '$msg','$client_id_param','$unit_id', '$status', '$hashname', '$prio', now())";
                mysql_query ( $query_add_ticket ) or die(mysql_error());
                */
                
                $stmt = $dbConnection->prepare('INSERT INTO tickets
								(id, user_init_id,user_to_id,date_create,subj,msg, client_id, unit_id, status, hash_name, prio, last_update) VALUES (:max_id_res_ticket, :user_init_id, :user_to_id, now(),:subj, :msg,:max_id,:unit_id, :status, :hashname, :prio, now())');
			 $stmt->execute(array(':max_id_res_ticket'=>$max_id_res_ticket,':user_init_id'=>$user_init_id,':user_to_id'=>$user_to_id,':subj'=>$subj,':msg'=>$msg,':max_id'=>$client_id_param,':unit_id'=>$unit_id,':status'=>$status,':hashname'=>$hashname,':prio'=>$prio));
                
                
                //echo $query_add_ticket;
                $unow=$_SESSION['helpdesk_user_id'];
                
                /*$query_atl = "INSERT INTO ticket_log (msg, date_op, init_user_id, ticket_id, to_user_id, to_unit_id)
values ('create', now(), '$unow', '$max_id_res_ticket', '$user_to_id', '$unit_id'); ";


                mysql_query ( $query_atl )or die(mysql_error());*/
                
                
               $stmt = $dbConnection->prepare('INSERT INTO ticket_log (msg, date_op, init_user_id, ticket_id, to_user_id, to_unit_id) values (:create, now(), :unow, :max_id_res_ticket, :user_to_id, :unit_id)');
			 
			   $stmt->execute(array(':create'=>'create', ':unow'=>$unow,':max_id_res_ticket'=>$max_id_res_ticket,':user_to_id'=>$user_to_id,':unit_id'=>$unit_id));
                
                
                
                if ($user_to_id == "0") {
                    send_mail_to('new_all',$max_id_res_ticket);
                    //echo "new_all";
                }

                else if ($user_to_id <> "0") {
                //echo "new_user";
                //echo "new_coord";
                    send_mail_to('new_user',$max_id_res_ticket);
                    send_mail_to('new_coord',$max_id_res_ticket);
                }
                echo($hashname);
            }





        }

    }
}
?>
