<?php
session_start();
error_reporting(0);
include_once("../functions.inc.php");



if (isset($_POST['menu'])) {



    if ($_POST['menu'] == 'out' ) {



        $page=($_POST['page']);
        $perpage='10';
                if (isset($_SESSION['hd.rustem_list_out'])) {
	      $perpage=  $_SESSION['hd.rustem_list_out'];
        }
        $start_pos = ($page - 1) * $perpage;
        $user_id=id_of_user($_SESSION['helpdesk_user_login']);
		$ps=priv_status($user_id);

if (isset($_SESSION['hd.rustem_sort_out'])) {
	if ($_SESSION['hd.rustem_sort_out'] == "ok"){
		$stmt = $dbConnection->prepare('SELECT id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read,lock_by, ok_by, prio from tickets where user_init_id=:user_id and arch=:n and status=:s limit :start_pos, :perpage');
        $stmt->execute(array(':user_id' => $user_id,':s'=>'1', ':n'=>'0',':start_pos'=>$start_pos,':perpage'=>$perpage));
	}
	
	else if ($_SESSION['hd.rustem_sort_out'] == "free"){
		$stmt = $dbConnection->prepare('SELECT id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read,lock_by, ok_by, prio from tickets where user_init_id=:user_id and arch=:n and lock_by=:lb and status=:s limit :start_pos, :perpage');
        $stmt->execute(array(':user_id' => $user_id,':lb'=>'0',':s'=>'0', ':n'=>'0',':start_pos'=>$start_pos,':perpage'=>$perpage));
	}
	
	
	else if ($_SESSION['hd.rustem_sort_out'] == "ilock"){
		$stmt = $dbConnection->prepare('SELECT id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read,lock_by, ok_by, prio from tickets where user_init_id=:user_id and arch=:n and lock_by=:lb limit :start_pos, :perpage');
        $stmt->execute(array(':user_id' => $user_id,':lb'=>$user_id, ':n'=>'0',':start_pos'=>$start_pos,':perpage'=>$perpage));
	}
	
	else if ($_SESSION['hd.rustem_sort_out'] == "lock"){
		$stmt = $dbConnection->prepare('SELECT id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read,lock_by, ok_by, prio from tickets where user_init_id=:user_id and arch=:n and (lock_by<>:lb and lock_by<>0) and (status=0) limit :start_pos, :perpage');
        $stmt->execute(array(':user_id' => $user_id,':lb'=>$user_id, ':n'=>'0',':start_pos'=>$start_pos,':perpage'=>$perpage));
	}
}

if (!isset($_SESSION['hd.rustem_sort_out'])) {        

		$stmt = $dbConnection->prepare('SELECT id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read,lock_by, ok_by, prio from tickets where user_init_id=:user_id and arch=:n order by id desc limit :start_pos, :perpage');
        $stmt->execute(array(':user_id' => $user_id, ':n'=>'0',':start_pos'=>$start_pos,':perpage'=>$perpage));
        }






        
        
        
        
        
        
        $res1 = $stmt->fetchAll();





        $aha=get_total_pages('out', $user_id);
        if ($aha == "0") {
            ?>
            <div id="spinner" class="well well-large well-transparent lead">
                <center><?=lang('MSG_no_records');?></center>
            </div>
        <?php
        }
        if ($aha <> "0") { ?>






            <input type="hidden" value="<?php echo get_total_pages('out',$user_id); ?>" id="val_menu">


            <table class="table table-bordered table-hover" style=" font-size: 14px; ">
                <thead>
                <tr>
                    <th><center>#</center></th>
                    <th><center><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="<?=lang('t_LIST_prio');?>"></i></center></th>
                    <th><center><?=lang('t_LIST_subj');?></center></th>
                    <th><center><?=lang('t_LIST_worker');?></center></th>
                    <th><center><?=lang('t_LIST_create');?></center></th>
                    <th><center><?=lang('t_LIST_ago');?></center></th>
                    <th><center><?=lang('t_LIST_to');?></center></th>
                    <th><center><?=lang('t_LIST_status');?></center></th>
                    <th><center><?=lang('t_LIST_action');?></center></th>
                </tr>
                </thead>
                <tbody>

                <?php

                foreach($res1 as $row) {
                    $lb=$row['lock_by'];
                    $ob=$row['ok_by'];
                    
                    
        
    
    
    
////////////////////////////Раскрашивает и подписывает кнопки/////////////////////////////////////////////////////////////////
if ($row['is_read'] == "0") { $style="bold_for_new"; }
if ($row['is_read'] <> "0") { $style=""; }
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
////////////////////////////////////////////////////////////////////////////////////////////////////////////




////////////////////////////Показывает приоритет//////////////////////////////////////////////////////////////
                $prio="<span class=\"label label-info\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".lang('t_list_a_p_norm')."\"><i class=\"fa fa-minus\"></i></span>";

                if ($row['prio'] == "0") {$prio= "<span class=\"label label-primary\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".lang('t_list_a_p_low')."\"><i class=\"fa fa-arrow-down\"></i></span>"; }

                if ($row['prio'] == "2") {$prio= "<span class=\"label label-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".lang('t_list_a_p_high')."\"><i class=\"fa fa-arrow-up\"></i></span>"; }
////////////////////////////////////////////////////////////////////////////////////////////////////////////






////////////////////////////Показывает labels//////////////////////////////////////////////////////////////
                if ($row['status'] == 1) {$st=  "<span class=\"label label-success\"><i class=\"fa fa-check-circle\"></i> ".lang('t_list_a_oko')." ".nameshort(name_of_user_ret($ob))."</span>";
                    $t_ago=get_date_ok($row['date_create'], $row['id']);
                }
                if ($row['status'] == 0) {
                    $t_ago=$row['date_create'];
                    if ($lb <> 0) {

                        if ($lb == $user_id) {$st=  "<span class=\"label label-warning\"><i class=\"fa fa-gavel\"></i> ".lang('t_list_a_lock_i')."</span>";}

                        if ($lb <> $user_id) {$st=  "<span class=\"label label-default\"><i class=\"fa fa-gavel\"></i> ".lang('t_list_a_lock_u')." ".nameshort(name_of_user_ret($lb))."</span>";}

                    }
                    if ($lb == 0) {$st=  "<span class=\"label label-primary\"><i class=\"fa fa-clock-o\"></i> ".lang('t_list_a_hold')."</span>";}
                }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    
    
                    




                    ?>

                    <tr id="tr_<?php echo $row['id']; ?>" class="<?=$style?>">
                        <td style=" vertical-align: middle; "><small><center><?php echo $row['id']; ?></center></small></td>
                        <td style=" vertical-align: middle; "><small><center><?=$prio?></center></small></td>
                        <td style=" vertical-align: middle; "><a href="ticket?<?php echo $row['hash_name']; ?>"><?php cutstr(make_html($row['subj'], 'no')); ?></a></td>
                        <td style=" vertical-align: middle; "><small><?php name_of_client($row['client_id']); ?></small></td>
                        <td style=" vertical-align: middle; "><small><center><time id="c" datetime="<?=$row['date_create']; ?>"></time></center></small></td>
                        <td style=" vertical-align: middle; "><small><center><time id="a" datetime="<?=$t_ago;?>"></time></center></small></td>
                        <td style=" vertical-align: middle; "><small><?php get_unit_name($row['unit_id']); ?></small>
                            <small><div  id="" class=" text-muted"><?php name_of_user($row['user_to_id']); ?></div></small></td>
                        <td style=" vertical-align: middle; "><small><center><?=$st;?></center>
                            </small></td>
                        <td style=" vertical-align: middle; ">
                            <center>
                                <div class="btn-group btn-group-xs actions">
                                    <button data-toggle="tooltip" data-placement="bottom" title="<?=lang('t_list_a_ok_no');?>" type="button" <?=$dis_status;?> class="btn btn-success" user="<?=$user_id?>" value="<?php echo $row['id']; ?>" id="action_list_ok" status="<?=$ob_status?>"><?=$ob_text?></button>
                                </div>
                            </center>
                        </td>
                    </tr>
                <?php
                }

                ?>
                </tbody>
            </table>






        <?php

        }




    }

    if ($_POST['menu'] == 'find' ) {

        $z=($_GET['t']);
        //echo($z);
        $user_id=id_of_user($_SESSION['helpdesk_user_login']);
        $unit_user=unit_of_user($user_id);
        $priv_val=priv_status($user_id);


        $units = explode(",", $unit_user);
        $units = implode("', '", $units);
        
        
$ee=explode(",", $unit_user);
foreach($ee as $key=>$value) {$in_query = $in_query . ' :val_' . $key . ', '; }
$in_query = substr($in_query, 0, -2);
foreach ($ee as $key=>$value) { $vv[":val_" . $key]=$value;}


        if ($priv_val == 0) {


		$stmt = $dbConnection->prepare('SELECT
   	a.id, a.user_init_id, a.user_to_id, a.date_create, a.subj, a.msg, a.client_id, a.unit_id, a.status, a.hash_name, 
   	a.is_read, a.lock_by, a.ok_by, a.prio, a.last_update, a.arch, b.comment_text, b.t_id
        from tickets as a LEFT JOIN  comments as b ON a.id = b.t_id
    	where ((a.unit_id IN ('.$in_query.') and a.arch=:n) or (a.user_init_id=:user_id)) and 
    	(a.id=:z or a.subj like :z1 or a.msg like :z2 or b.comment_text like :z3)group by a.id limit 10');


            $paramss=array(':n'=>'0',':user_id'=>$user_id,':z'=>$z,':z1'=>'%'.$z.'%',':z2'=>'%'.$z.'%',':z3'=>'%'.$z.'%');
            $stmt->execute(array_merge($vv,$paramss));
            $res1 = $stmt->fetchAll();






        }
        else if ($priv_val == 1) {


		$stmt = $dbConnection->prepare('SELECT
   	a.id, a.user_init_id, a.user_to_id, a.date_create, a.subj, a.msg, a.client_id, a.unit_id, a.status, a.hash_name, 
   	a.is_read, a.lock_by, a.ok_by, a.prio, a.last_update, a.arch, b.comment_text, b.t_id
        from tickets as a LEFT JOIN  comments as b ON a.id = b.t_id
   	where (((a.user_to_id=:user_id) or
   	(a.user_to_id=:n and a.unit_id IN ('.$in_query.') )) or a.user_init_id=:user_id2) and 
   	(a.id=:z or a.subj like :z1 or a.msg like :z2 or b.comment_text like :z3) group by a.id limit 10');


            $paramss=array(':n'=>'0',':user_id'=>$user_id,':z'=>$z,':z1'=>'%'.$z.'%',':z2'=>'%'.$z.'%',':z3'=>'%'.$z.'%',':user_id2'=>$user_id);
            $stmt->execute(array_merge($vv,$paramss));
            $res1 = $stmt->fetchAll();





        }


        else if ($priv_val == 2) {

$stmt = $dbConnection->prepare('SELECT
   	a.id, a.user_init_id, a.user_to_id, a.date_create, a.subj, a.msg, a.client_id, a.unit_id, a.status, a.hash_name, 
   	a.is_read, a.lock_by, a.ok_by, a.prio, a.last_update, a.arch, b.comment_text, b.t_id
   	from tickets as a LEFT JOIN  comments as b ON a.id = b.t_id
    	where a.id=:z or a.subj like :z1 or a.msg like :z2 or b.comment_text like :z3 group by a.id limit 10');

            $stmt->execute(array(':z'=>$z,':z1'=>'%'.$z.'%',':z2'=>'%'.$z.'%',':z3'=>'%'.$z.'%'));
            $res1 = $stmt->fetchAll();






        }



        if(empty($res1)) {
            ?>
            <div class="well well-large well-transparent lead">
                <center>
                    <?=lang('MSG_no_records')?>
                </center>
            </div>
        <?php
        }



        else if(!empty($res1)) {

            ?>
            <center><small class="text-mutted"><em><?=lang('t_list_a_top')?></em></small></center>
            <table class="table table-bordered table-hover" style=" font-size: 14px; ">
            <thead>
            <tr>
                <th><center>#</center></th>
                <th><center><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="<?=lang('t_LIST_prio')?>"></i></center></th>
                <th><center><?=lang('t_LIST_subj')?></center></th>
                <th><center><?=lang('t_LIST_worker')?></center></th>
                <th><center><?=lang('t_LIST_create')?></center></th>
                <th><center><?=lang('t_LIST_ago')?></center></th>
                <th><center><?=lang('t_LIST_init')?></center></th>
                <th><center><?=lang('t_LIST_to')?></center></th>
                <th><center><?=lang('t_LIST_status')?></center></th>
            </tr>
            </thead>
            <tbody>
            <?php

            foreach($res1 as $row) {
                $lb=$row['lock_by'];
                $ob=$row['ok_by'];
                $arch = $row['arch'];


                $user_id_z=id_of_user($_SESSION['helpdesk_user_login']);
                $unit_user_z=unit_of_user($user_id_z);
                $status_ok_z=$row['status'];
                $ok_by_z=$row['ok_by'];
                $lock_by_z=$row['lock_by'];


////////////////////////////Раскрашивает и подписывает кнопки/////////////////////////////////////////////////////////////////
if ($row['is_read'] == "0") { $style="bold_for_new"; }
if ($row['is_read'] <> "0") { $style=""; }
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
////////////////////////////////////////////////////////////////////////////////////////////////////////////




////////////////////////////Показывает кому/////////////////////////////////////////////////////////////////
                if ($row['user_to_id'] <> 0 ) {
                    $to_text="<div class=''>".nameshort(name_of_user_ret($row['user_to_id']))."</div>";
                }
                if ($row['user_to_id'] == 0 ) {
                    $to_text="<strong data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".view_array(get_unit_name_return($row['unit_id']))."\">".lang('t_list_a_all')."</strong>";
                }
////////////////////////////////////////////////////////////////////////////////////////////////////////////



////////////////////////////Показывает приоритет//////////////////////////////////////////////////////////////
                $prio="<span class=\"label label-info\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".lang('t_list_a_p_norm')."\"><i class=\"fa fa-minus\"></i></span>";

                if ($row['prio'] == "0") {$prio= "<span class=\"label label-primary\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".lang('t_list_a_p_low')."\"><i class=\"fa fa-arrow-down\"></i></span>"; }

                if ($row['prio'] == "2") {$prio= "<span class=\"label label-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".lang('t_list_a_p_high')."\"><i class=\"fa fa-arrow-up\"></i></span>"; }
////////////////////////////////////////////////////////////////////////////////////////////////////////////






////////////////////////////Показывает labels//////////////////////////////////////////////////////////////
                if ($row['status'] == 1) {$st=  "<span class=\"label label-success\"><i class=\"fa fa-check-circle\"></i> ".lang('t_list_a_oko')." ".nameshort(name_of_user_ret($ob))."</span>";
                    $t_ago=get_date_ok($row['date_create'], $row['id']);
                }
                if ($row['status'] == 0) {
                    $t_ago=$row['date_create'];
                    if ($lb <> 0) {

                        if ($lb == $user_id) {$st=  "<span class=\"label label-warning\"><i class=\"fa fa-gavel\"></i> ".lang('t_list_a_lock_i')."</span>";}

                        if ($lb <> $user_id) {$st=  "<span class=\"label label-default\"><i class=\"fa fa-gavel\"></i> ".lang('t_list_a_lock_u')." ".nameshort(name_of_user_ret($lb))."</span>";}

                    }
                    if ($lb == 0) {$st=  "<span class=\"label label-primary\"><i class=\"fa fa-clock-o\"></i> ".lang('t_list_a_hold')."</span>";}
                }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



/////////если пользователь///////////////////////////////////////////////////////////////////////////////////////////
if ($priv_val == 1) { 
//ЗАявка не выполнена ИЛИ выполнена мной
//ЗАявка не заблокирована ИЛИ заблокирована мной
$lo == "no";
if (($status_ok_z == 0) || (($status_ok_z == 1) && ($ok_by_z == $user_id_z)))
                    {
                        if (($lock_by_z == 0) || ($lock_by_z == $user_id_z)) {
                        $lo == "yes";
						}
					}
                if ($lo == "yes") {$lock_st=""; $muclass="";}
                else if ($lo == "no") {$lock_st="disabled=\"disabled\""; $muclass="text-muted";}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





/////////если нач отдела/////////////////////////////////////////////////////////////////////////////////////////////
else if ($priv_val == 0) { 
$lock_st=""; $muclass="";	
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//////////главный админ//////////////////////////////////////////////////////////////////////////////////////////////
else if ($priv_val == 2) { 
$lock_st=""; $muclass="";
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
               
                if ($arch == "1") {$st=  "<span class=\"label label-default\">".lang('t_list_a_arch')." </span>";}
                if ($arch == "0") {
                    if ($row['status'] == 1) {$st=  "<span class=\"label label-success\"><i class=\"fa fa-check-circle\"></i> ".lang('t_list_a_oko')." ".nameshort(name_of_user_ret($ob))."</span>";}
                    if ($row['status'] == 0) {
                        if ($lb <> 0) {$st=  "<span class=\"label label-warning\"><i class=\"fa fa-gavel\"></i> ".lang('t_list_a_lock_u')." ".nameshort(name_of_user_ret($lb))."</span>";}
                        if ($lb == 0) {$st=  "<span class=\"label label-primary\"><i class=\"fa fa-clock-o\"></i> ".lang('t_list_a_hold')."</span>";}
                    }
                }
                if ($row['status'] == 1) {$t_ago=get_date_ok($row['date_create'], $row['id']);}
                if ($row['status'] == 0) {$t_ago=$row['date_create'];}



                ?>
                <tr id="tr_<?php echo $row['id']; ?>" class="<?=$style?>">
                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><center><?php echo $row['id']; ?></center></small></td>
                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><center><?=$prio?></center></small></td>
                    <td style=" vertical-align: middle; "><a class="<?=$muclass;?>" data-toggle="tooltip" data-placement="bottom" title="<?=make_html($row['subj'], 'no')?>" href="ticket?<?php echo $row['hash_name']; ?>"><?php cutstr(make_html($row['subj'], 'no')); ?></a></td>
                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><?php name_of_client($row['client_id']); ?></small></td>
                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><center><time id="c" datetime="<?=$row['date_create']; ?>"></time></center></small></td>
                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><center>
                    <time id="a" datetime="<?=$t_ago;?>"></time>
                    </center></small></td>

                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><?php echo nameshort(name_of_user_ret($row['user_init_id'])); ?></small></td>

                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>">
                            <?=$to_text?>
                        </small></td>
                    <td style=" vertical-align: middle; ">
                        <center><small>
                                <?=$st;?>
                            </small>
                        </center>
                    </td>
                </tr>
            <?php
            }

            ?>
            </tbody>
            </table>



        <?php
        }


    }

    if ($_POST['menu'] == 'in' ) {

        $page=($_POST['page']);
        
        $perpage='10';
        if (isset($_SESSION['hd.rustem_list_in'])) {
	      $perpage=  $_SESSION['hd.rustem_list_in'];
        }
        
        $start_pos = ($page - 1) * $perpage;

        $user_id=id_of_user($_SESSION['helpdesk_user_login']);
        $unit_user=unit_of_user($user_id);
        $priv_val=priv_status($user_id);

		//$unit_user = 1,2,3
        $units = explode(",", $unit_user);
        //$units = array[1,2,3]
        $units = implode("', '", $units);


$ee=explode(",", $unit_user);
foreach($ee as $key=>$value) {$in_query = $in_query . ' :val_' . $key . ', '; }
$in_query = substr($in_query, 0, -2);
foreach ($ee as $key=>$value) { $vv[":val_" . $key]=$value;}






        if ($priv_val == 0) {

/*
if (isset($_SESSION['hd.rustem_sort_in'])) {
	if ($_SESSION['hd.rustem_sort_in'] == "ok"){}
	else if ($_SESSION['hd.rustem_sort_in'] == "ilock"){}
	else if ($_SESSION['hd.rustem_sort_in'] == "lock"){}
}

if (!isset($_SESSION['hd.rustem_sort_in'])) {}

*/
//нач отдела
/*
выбрать все заявки, которые состоят с моих отделах
*/

if (isset($_SESSION['hd.rustem_sort_in'])) {

	if ($_SESSION['hd.rustem_sort_in'] == "ok"){$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update
							from tickets
							where unit_id IN (' . $in_query . ')  and arch=:n and status=:s
							limit :start_pos, :perpage');
            $paramss=array(':n'=>'0',':s'=>'1',':start_pos'=>$start_pos,':perpage'=>$perpage);
            $stmt->execute(array_merge($vv,$paramss));}
            
            	else if ($_SESSION['hd.rustem_sort_in'] == "free"){$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update
							from tickets
							where unit_id IN (' . $in_query . ')  and arch=:n and status=:s and lock_by=:lb
							limit :start_pos, :perpage');
            $paramss=array(':n'=>'0',':s'=>'0',':lb'=>'0',':start_pos'=>$start_pos,':perpage'=>$perpage);
            $stmt->execute(array_merge($vv,$paramss));}
            
	else if ($_SESSION['hd.rustem_sort_in'] == "ilock"){$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update
							from tickets
							where unit_id IN (' . $in_query . ')  and arch=:n and lock_by=:lb
							limit :start_pos, :perpage');
            $paramss=array(':n'=>'0',':lb'=>$user_id,':start_pos'=>$start_pos,':perpage'=>$perpage);
            $stmt->execute(array_merge($vv,$paramss));}
            
            
            
	else if ($_SESSION['hd.rustem_sort_in'] == "lock"){$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update
							from tickets
							where unit_id IN (' . $in_query . ')  and arch=:n and (lock_by<>:lb and lock_by<>0) and (status=0)
							limit :start_pos, :perpage');

            $paramss=array(':n'=>'0',':lb'=>$user_id,':start_pos'=>$start_pos,':perpage'=>$perpage);
            $stmt->execute(array_merge($vv,$paramss));}
}

if (!isset($_SESSION['hd.rustem_sort_in'])) {
	$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update
							from tickets
							where unit_id IN (' . $in_query . ')  and arch=:n
							order by ok_by asc, prio desc, id desc
							limit :start_pos, :perpage');

            $paramss=array(':n'=>'0',':start_pos'=>$start_pos,':perpage'=>$perpage);
            $stmt->execute(array_merge($vv,$paramss));
}
            
            $res1 = $stmt->fetchAll();





        }
        else if ($priv_val == 1) {

if (isset($_SESSION['hd.rustem_sort_in'])) {
	if ($_SESSION['hd.rustem_sort_in'] == "ok"){
		$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update
							from tickets
							where ((user_to_id=:user_id and arch=:n) or
							(user_to_id=:n1 and unit_id IN (' . $in_query . ') and arch=:n2)) and status=:s
							limit :start_pos, :perpage');
$paramss=array(':user_id'=>$user_id,':s'=>'1', ':n'=>'0',':n1'=>'0',':n2'=>'0',':start_pos'=>$start_pos,':perpage'=>$perpage);
$stmt->execute(array_merge($vv,$paramss));
	}
	
		else if ($_SESSION['hd.rustem_sort_in'] == "free"){
		$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update
							from tickets
							where ((user_to_id=:user_id and arch=:n) or
							(user_to_id=:n1 and unit_id IN (' . $in_query . ') and arch=:n2)) and lock_by=:lb and status=:s
							limit :start_pos, :perpage');
$paramss=array(':user_id'=>$user_id,':lb'=>'0', ':s'=>'0', ':n'=>'0',':n1'=>'0',':n2'=>'0',':start_pos'=>$start_pos,':perpage'=>$perpage);
$stmt->execute(array_merge($vv,$paramss));
	}
	
	else if ($_SESSION['hd.rustem_sort_in'] == "ilock"){
		$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update
							from tickets
							where ((user_to_id=:user_id and arch=:n) or
							(user_to_id=:n1 and unit_id IN (' . $in_query . ') and arch=:n2)) and lock_by=:lb
							limit :start_pos, :perpage');
$paramss=array(':user_id'=>$user_id,':lb'=>$user_id, ':n'=>'0',':n1'=>'0',':n2'=>'0',':start_pos'=>$start_pos,':perpage'=>$perpage);
$stmt->execute(array_merge($vv,$paramss));
	}
	else if ($_SESSION['hd.rustem_sort_in'] == "lock"){
				$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update
							from tickets
							where ((user_to_id=:user_id and arch=:n) or
							(user_to_id=:n1 and unit_id IN (' . $in_query . ') and arch=:n2)) and (lock_by<>:lb and lock_by<>0) and (status=0)
							limit :start_pos, :perpage');
$paramss=array(':user_id'=>$user_id,':lb'=>$user_id, ':n'=>'0',':n1'=>'0',':n2'=>'0',':start_pos'=>$start_pos,':perpage'=>$perpage);
$stmt->execute(array_merge($vv,$paramss));
	}
}



if (!isset($_SESSION['hd.rustem_sort_in'])) {
$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update
							from tickets
							where ((user_to_id=:user_id and arch=:n) or
							(user_to_id=:n1 and unit_id IN (' . $in_query . ') and arch=:n2))
							order by ok_by asc, prio desc, id desc
							limit :start_pos, :perpage');
$paramss=array(':user_id'=>$user_id, ':n'=>'0',':n1'=>'0',':n2'=>'0',':start_pos'=>$start_pos,':perpage'=>$perpage);
$stmt->execute(array_merge($vv,$paramss));
            }
            
            
            
            $res1 = $stmt->fetchAll();


        }
        else if ($priv_val == 2) {
//Главный начальник

        if (isset($_SESSION['hd.rustem_sort_in'])) {
        
        	if ($_SESSION['hd.rustem_sort_in'] == "ok"){
	        	
	        	$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update
							from tickets
							where arch=:n
							and status=:s
							limit :start_pos, :perpage');
							$stmt->execute(array(':n'=>'0',':s'=>'1',':start_pos'=>$start_pos,':perpage'=>$perpage));
	        	
        	}
        				else if ($_SESSION['hd.rustem_sort_in'] == "free"){	      
			$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update
							from tickets
							where arch=:n
							and lock_by=:lb and status=:s
							limit :start_pos, :perpage');
							$stmt->execute(array(':n'=>'0',':s'=>'0',':lb'=>'0',':start_pos'=>$start_pos,':perpage'=>$perpage));}
							
			else if ($_SESSION['hd.rustem_sort_in'] == "ilock"){	      
			$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update
							from tickets
							where arch=:n
							and lock_by=:lb
							limit :start_pos, :perpage');
							$stmt->execute(array(':n'=>'0',':lb'=>$user_id,':start_pos'=>$start_pos,':perpage'=>$perpage));}
			else if ($_SESSION['hd.rustem_sort_in'] == "lock"){
							$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update
							from tickets
							where arch=:n
							and (lock_by<>:lb and lock_by<>0) and (status=0)
							limit :start_pos, :perpage');
							$stmt->execute(array(':n'=>'0',':lb'=>$user_id,':start_pos'=>$start_pos,':perpage'=>$perpage));
			}
        

        }
        
        
         if (!isset($_SESSION['hd.rustem_sort_in'])) {
            $stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update
							from tickets
							where arch=:n
							order by ok_by asc, prio desc, id desc
							limit :start_pos, :perpage');
							$stmt->execute(array(':n'=>'0',':start_pos'=>$start_pos,':perpage'=>$perpage));
}
            
            $res1 = $stmt->fetchAll();

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









            <table class="table table-bordered table-hover" style=" font-size: 14px; ">
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
                <th style="width:60px;"><center><?=lang('t_LIST_action');?></center></th>
            </tr>
            </thead>
            <tbody>

            <?php

            foreach($res1 as $row) {
                $lb=$row['lock_by'];
                $ob=$row['ok_by'];


                $user_id_z=$_SESSION['helpdesk_user_id'];
                $unit_user_z=unit_of_user($user_id_z);
                $status_ok_z=$row['status'];
                $ok_by_z=$row['ok_by'];
                $lock_by_z=$row['lock_by'];

////////////////////////////Раскрашивает и подписывает кнопки/////////////////////////////////////////////////////////////////
if ($row['is_read'] == "0") { $style="bold_for_new"; }
if ($row['is_read'] <> "0") { $style=""; }
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
////////////////////////////////////////////////////////////////////////////////////////////////////////////




////////////////////////////Показывает кому/////////////////////////////////////////////////////////////////
                if ($row['user_to_id'] <> 0 ) {
                    $to_text="<div class=''>".nameshort(name_of_user_ret($row['user_to_id']))."</div>";
                }
                if ($row['user_to_id'] == 0 ) {
                    $to_text="<strong data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".view_array(get_unit_name_return($row['unit_id']))."\">".lang('t_list_a_all')."</strong>";
                }
////////////////////////////////////////////////////////////////////////////////////////////////////////////



////////////////////////////Показывает приоритет//////////////////////////////////////////////////////////////
                $prio="<span class=\"label label-info\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".lang('t_list_a_p_norm')."\"><i class=\"fa fa-minus\"></i></span>";

                if ($row['prio'] == "0") {$prio= "<span class=\"label label-primary\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".lang('t_list_a_p_low')."\"><i class=\"fa fa-arrow-down\"></i></span>"; }

                if ($row['prio'] == "2") {$prio= "<span class=\"label label-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".lang('t_list_a_p_high')."\"><i class=\"fa fa-arrow-up\"></i></span>"; }
////////////////////////////////////////////////////////////////////////////////////////////////////////////






////////////////////////////Показывает labels//////////////////////////////////////////////////////////////
                if ($row['status'] == 1) {$st=  "<span class=\"label label-success\"><i class=\"fa fa-check-circle\"></i> ".lang('t_list_a_oko')." ".nameshort(name_of_user_ret($ob))."</span>";
                    $t_ago=get_date_ok($row['date_create'], $row['id']);
                }
                if ($row['status'] == 0) {
                    $t_ago=$row['date_create'];
                    if ($lb <> 0) {

                        if ($lb == $user_id) {$st=  "<span class=\"label label-warning\"><i class=\"fa fa-gavel\"></i> ".lang('t_list_a_lock_i')."</span>";}

                        if ($lb <> $user_id) {$st=  "<span class=\"label label-default\"><i class=\"fa fa-gavel\"></i> ".lang('t_list_a_lock_u')." ".nameshort(name_of_user_ret($lb))."</span>";}

                    }
                    if ($lb == 0) {$st=  "<span class=\"label label-primary\"><i class=\"fa fa-clock-o\"></i> ".lang('t_list_a_hold')."</span>";}
                }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



/////////если пользователь///////////////////////////////////////////////////////////////////////////////////////////
if ($priv_val == 1) { 
//ЗАявка не выполнена ИЛИ выполнена мной
//ЗАявка не заблокирована ИЛИ заблокирована мной
$lo = "no";


if ($row['user_init_id'] == $user_id_z) {

                                $lo="yes";

                            }
                            

if ($row['user_init_id'] <> $user_id_z) {

if (($status_ok_z == 0) || (($status_ok_z == 1) && ($ok_by_z == $user_id_z)))
                    {
                        if (($lock_by_z == 0) || ($lock_by_z == $user_id_z)) {
                        $lo = "yes";
						}
					}
					}
					
					
                if ($lo == "yes") {$lock_st=""; $muclass="";}
                else if ($lo == "no") {$lock_st="disabled=\"disabled\""; $muclass="text-muted";}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





/////////если нач отдела/////////////////////////////////////////////////////////////////////////////////////////////
else if ($priv_val == 0) { 
$lock_st=""; $muclass="";	
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//////////главный админ//////////////////////////////////////////////////////////////////////////////////////////////
else if ($priv_val == 2) { 
$lock_st=""; $muclass="";
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                ?>

                <tr id="tr_<?php echo $row['id']; ?>" class="<?=$style?>">
                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><center><?php echo $row['id']; ?></center></small></td>
                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><center><?=$prio?></center></small></td>
                    <td style=" vertical-align: middle; "><a class="<?=$muclass;?>" data-toggle="tooltip" data-placement="bottom" title="<?=make_html($row['subj'], 'no')?>" href="ticket?<?php echo $row['hash_name']; ?>"><?php cutstr(make_html($row['subj'], 'no')); ?></a></td>
                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><?php name_of_client($row['client_id']); ?></small></td>
                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><center><time id="c" datetime="<?=$row['date_create']; ?>"></time></center></small></td>
                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><center><time id="a" datetime="<?=$t_ago;?>"></time></center></small></td>

                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><?php echo nameshort(name_of_user_ret($row['user_init_id'])); ?></small></td>

                    <td style=" vertical-align: middle; "><small class="<?=$muclass;?>">
                            <?=$to_text?>
                        </small></td>
                    <td style=" vertical-align: middle; "><small><center>
                                <?=$st;?> </center>
                        </small></td>
                    <td style=" vertical-align: middle; ">
                        <center>
                            <div class="btn-group btn-group-xs actions">
                                <button <?=$lock_st?> data-toggle="tooltip" data-placement="bottom" title="<?=$lb_tooltip?>" type="button" class="btn btn-warning" user="<?=$user_id?>" value="<?php echo $row['id']; ?>" id="action_list_lock" status="<?=$lb_status?>"><?=$lb_text?></button>

                                <button <?=$lock_st?> data-toggle="tooltip" data-placement="bottom" title="<?=$ob_tooltip?>" type="button" class="btn btn-success" user="<?=$user_id?>" value="<?php echo $row['id']; ?>" id="action_list_ok" status="<?=$ob_status?>"><?=$ob_text?></button>
                            </div>
                        </center>
                    </td>
                </tr>
            <?php
            }

            ?>
            </tbody>
            </table>





        <?php
        }
    }
    if ($_POST['menu'] == 'arch' ) {

        $page=($_POST['page']);
        $perpage='10';
                if (isset($_SESSION['hd.rustem_list_arch'])) {
	      $perpage=  $_SESSION['hd.rustem_list_arch'];
        }
        $start_pos = ($page - 1) * $perpage;



        $user_id=id_of_user($_SESSION['helpdesk_user_login']);
        $unit_user=unit_of_user($user_id);
        $units = explode(",", $unit_user);
        $units = implode("', '", $units);
        $priv_val=priv_status($user_id);
        
        
$ee=explode(",", $unit_user);
$s=1;
foreach($ee as $key=>$value) { $in_query = $in_query . ' :val_' . $key . ', '; $s++; }
$c=($s-1);
foreach($ee as $key=>$value) {$in_query2 = $in_query2 . ' :val_' . ($c+$key) . ', '; }
$in_query = substr($in_query, 0, -2);
$in_query2 = substr($in_query2, 0, -2);
foreach ($ee as $key=>$value) { $vv[":val_" . $key]=$value;}        
 foreach ($ee as $key=>$value) { $vv2[":val_" . ($c+$key)]=$value;}    
 
 
 //$pp2=array_merge($vv,$vv2);     
 
        if ($priv_val == 0) {



            $stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, ok_date
							from tickets
							where (unit_id IN ('. $in_query. ') or user_init_id=:user_id) and arch=:n
							order by id DESC
							limit :start_pos, :perpage');
                        
$paramss=array(':n'=>'1', ':user_id'=>$user_id,':start_pos'=>$start_pos,':perpage'=>$perpage);
$stmt->execute(array_merge($vv,$paramss));
$res1 = $stmt->fetchAll();




        }
        else if ($priv_val == 1) {




            $stmt = $dbConnection->prepare('
            SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, ok_date
							from tickets
							where (
							(user_to_id=:user_id and unit_id IN ('.$in_query.') and arch=:n) or
							(user_to_id=:n1 and unit_id IN ('.$in_query2.') and arch=:n2)
							) or (user_init_id=:user_id2 and arch=:n3)
							order by id DESC
							limit :start_pos, :perpage');


            
            
$paramss=array(':n'=>'1',':n1'=>'0',':n2'=>'1',':n3'=>'1', ':user_id'=>$user_id, ':user_id2'=>$user_id,':start_pos'=>$start_pos,':perpage'=>$perpage);

$stmt->execute(array_merge($vv,$vv2,$paramss));
$res1 = $stmt->fetchAll();



        }
        else	if ($priv_val == 2) {




            $stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, ok_date
							from tickets
							where arch=:n
							order by id DESC
							limit :start_pos, :perpage');

            $stmt->execute(array(':n'=>'1',':start_pos'=>$start_pos,':perpage'=>$perpage));
            $res1 = $stmt->fetchAll();




        }

        $aha=get_total_pages('arch', $user_id);
        if ($aha == "0") {
            ?>
            <div id="spinner" class="well well-large well-transparent lead">
                <center>
                    <?=lang('MSG_no_records');?>
                </center>
            </div>
        <?php
        }
        else if ($aha <> "0") {
            ?>

            <input type="hidden" value="<?php echo get_total_pages('arch', $user_id); ?>" id="val_menu">
            <input type="hidden" value="<?php echo $user_id; ?>" id="user_id">
            <input type="hidden" value="" id="total_tickets">
            <input type="hidden" value="" id="last_total_tickets">

            <table class="table table-bordered table-hover" style=" font-size: 14px; ">
                <thead>
                <tr>
                    <th><center>#</center></th>
                    <th><center><?=lang('t_LIST_subj');?></center></th>
                    <th><center><?=lang('t_LIST_worker');?></center></th>
                    <th><center><?=lang('t_LIST_create');?></center></th>
                    <th><center><?=lang('t_LIST_init');?></center></th>
                    <th><center><?=lang('t_LIST_to');?></center></th>
                    <th><center><?=lang('t_list_a_user_ok');?></center></th>
                    <th><center><?=lang('t_list_a_date_ok');?></center></th>
                </tr>
                </thead>
                <tbody>

                <?php



                foreach($res1 as $row) {


                    if ($row['user_to_id'] <> 0 ) {
                        $to_text="<div class=''>".nameshort(name_of_user_ret($row['user_to_id']))."</div>";
                    }
                    if ($row['user_to_id'] == 0 ) {
                        $to_text="<strong data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".view_array(get_unit_name_return($row['unit_id']))."\">".lang('t_list_a_all')."</strong>";
                    }










                    ?>
                    <tr >
                        <td style=" vertical-align: middle; "><small><center><?php echo $row['id']; ?></center></small></td>
                        <td style=" vertical-align: middle; "><small><a href="ticket?<?php echo $row['hash_name']; ?>"><?php cutstr(make_html($row['subj'], 'no')); ?></a></small></td>
                        <td style=" vertical-align: middle; "><small><?php name_of_client($row['client_id']); ?></small></td>
                        <td style=" vertical-align: middle; "><small><center><time id="c" datetime="<?=$row['date_create']; ?>"></time></center></small></td>
                        <td style=" vertical-align: middle; "><small><?=nameshort(name_of_user_ret($row['user_init_id'])); ?></small></td>

                        <td style=" vertical-align: middle; "><small>
                                <?=$to_text?>
                            </small></td>
                        <td style=" vertical-align: middle; "><small>
                                <?=nameshort(name_of_user_ret($row['ok_by'])); ?>
                            </small></td>
                        <td style=" vertical-align: middle; "><small><center>
                        <time id="c" datetime="<?=$row['ok_date']; ?>"></time>
                        </center></small></td>
                    </tr>
                <?php
                }


                ?>
                </tbody>
            </table>
        <?php


        }

    }





}


?>
