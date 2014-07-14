<?php

session_start();
error_reporting(0);
include_once("../functions.inc.php");



if (isset($_POST['menu'])) {



    if ($_POST['menu'] == 'out' ) {



        $page=($_POST['page']);
        $perpage='10';
        $start_pos = ($page - 1) * $perpage;
        $user_id=id_of_user($_SESSION['helpdesk_user_login']);

        /*$results = mysql_query("SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read,lock_by, ok_by, prio
							from tickets
							where user_init_id='$user_id' and arch='0'
							order by id desc
							limit $start_pos, $perpage
							");
							*/
							
		    $stmt = $dbConnection->prepare('SELECT id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read,lock_by, ok_by, prio from tickets where user_init_id=:user_id and arch=:n order by id desc limit :start_pos, :perpage');

			$stmt->execute(array(':user_id' => $user_id, ':n'=>'0',':start_pos'=>$start_pos,':perpage'=>$perpage));
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

                //while ($row = mysql_fetch_assoc($results)) {
					foreach($res1 as $row) {
                    $lb=$row['lock_by'];
                    $ob=$row['ok_by'];

                    if ($row['is_read'] == "0") {$style="bold_for_new";


                        if ($row['status'] == "1") {
                            $ob_text="<i class=\"fa fa-check-circle-o\"></i>";
                            $ob_status="unok";
                            $style="success";
                            if ($lb <> "0") {
                                $lb_text="<i class=\"fa fa-lock\"></i>";
                                $lb_status="unlock";
                            }
                            if ($lb == "0") {
                                $lb_text="<i class=\"fa fa-unlock\"></i>";
                                $lb_status="lock";
                            }

                        }

                        if ($row['status'] == "0") {
                            $ob_text="<i class=\"fa fa-circle-o\"></i>";
                            $ob_status="ok";
                            if ($lb <> "0") {
                                $lb_text="<i class=\"fa fa-lock\"></i>";
                                $lb_status="unlock";
                                if ($lb == $user_id) {$style="warning";}
                                if ($lb <> $user_id) {$style="active";}
                            }
                            if ($lb == "0") {
                                $lb_text="<i class=\"fa fa-unlock\"></i>";
                                $lb_status="lock";
                            }

                        }

                    }
                    if ($row['is_read'] <> "0") {

                        if ($row['status'] == "1") {
                            $ob_text="<i class=\"fa fa-check-circle-o\"></i>";
                            $ob_status="unok";
                            $style="success";
                            if ($lb <> "0") {
                                $lb_text="<i class=\"fa fa-lock\"></i>";
                                $lb_status="unlock";
                            }
                            if ($lb == "0") {
                                $lb_text="<i class=\"fa fa-unlock\"></i>";
                                $lb_status="lock";
                            }
                        }


                        if ($row['status'] == "0") {
                            $ob_text="<i class=\"fa fa-circle-o\"></i>";
                            $ob_status="ok";
                            if ($lb <> "0") {
                                $lb_text="<i class=\"fa fa-lock\"></i>";
                                $lb_status="unlock";
                                if ($lb == $user_id) {$style="warning";}
                                if ($lb <> $user_id) {$style="active";}
                            }
                            if ($lb == "0") {
                                $style="";
                                $lb_text="<i class=\"fa fa-unlock\"></i>";
                                $lb_status="lock";
                            }
                        }
                    }

                    $prio="<span class=\"label label-info\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".lang('t_list_a_p_norm')."\"><i class=\"fa fa-minus\"></i></span>";

                    if ($row['prio'] == "0") {$prio= "<span class=\"label label-primary\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".lang('t_list_a_p_low')."\"><i class=\"fa fa-arrow-down\"></i></span>"; }

                    if ($row['prio'] == "2") {$prio= "<span class=\"label label-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".lang('t_list_a_p_high')."\"><i class=\"fa fa-arrow-up\"></i></span>"; }




                    if ($row['status'] == 1) {$st=  "<i class=\"fa fa-check-circle\"></i> ".lang('t_list_a_oko')." ".nameshort(name_of_user_ret($ob));}
                    if ($row['status'] == 0) {
                        if ($lb <> 0) {$st=  "<i class=\"fa fa-gavel\"></i> ".lang('t_list_a_lock_u')." ".nameshort(name_of_user_ret($lb));}
                        if ($lb == 0) {$st=  "<i class=\"fa fa-clock-o\"></i> ".lang('t_list_a_hold')."";}
                    }


                    if ($row['status'] == 1) {$st=  "<span class=\"label label-success\"><i class=\"fa fa-check-circle\"></i> ".lang('t_list_a_oko')." ".nameshort(name_of_user_ret($ob))."</span>";
	                    $t_ago=get_date_ok($row['date_create'], $row['id']);
                    }
                    if ($row['status'] == 0) {
                    	$t_ago=humanTiming(strtotime($row['date_create']));
                        if ($lb <> 0) {$st=  "<span class=\"label label-warning\"><i class=\"fa fa-gavel\"></i> ".lang('t_list_a_lock_u')." ".nameshort(name_of_user_ret($lb))."</span>";}
                        if ($lb == 0) {$st=  "<span class=\"label label-primary\"><i class=\"fa fa-clock-o\"></i> ".lang('t_list_a_hold')."</span>";}
                    }




                    ?>

                    <tr id="tr_<?php echo $row['id']; ?>" class="<?=$style?>">
                        <td style=" vertical-align: middle; "><small><center><?php echo $row['id']; ?></center></small></td>
                        <td style=" vertical-align: middle; "><small><center><?=$prio?></center></small></td>
                        <td style=" vertical-align: middle; "><a href="ticket.php?hash=<?php echo $row['hash_name']; ?>"><?php cutstr($row['subj']); ?></a></td>
                        <td style=" vertical-align: middle; "><small><?php name_of_client($row['client_id']); ?></small></td>
                        <td style=" vertical-align: middle; "><small><center><?php dt_format($row['date_create']); ?></center></small></td>
                        <td style=" vertical-align: middle; "><small><center><?=$t_ago;?></center></small></td>
                        <td style=" vertical-align: middle; "><small><?php get_unit_name($row['unit_id']); ?></small>
                            <small><div  id="" class=" text-muted editable"><?php name_of_user($row['user_to_id']); ?></div></small></td>
                        <td style=" vertical-align: middle; "><small><center><?=$st;?></center>
                            </small></td>
                        <td style=" vertical-align: middle; ">
                            <center>
                                <div class="btn-group btn-group-xs actions">
                                    <button data-toggle="tooltip" data-placement="bottom" title="<?=lang('t_list_a_ok_no');?>" type="button" class="btn btn-success" user="<?=$user_id?>" value="<?php echo $row['id']; ?>" id="action_list_ok" status="<?=$ob_status?>"><?=$ob_text?></button>
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
        /*
        $results = mysql_query("SELECT 
                            id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio
                            from tickets
                            where unit_id='$unit_user'  and arch='0'
                            order by id DESC
                            limit $start_pos, $perpage
                            ");
                            */

        $units = explode(",", $unit_user);
        $units = implode("', '", $units);
        //print_r($units);

        //$units = "'". implode("', '", $units) ."'";
        //echo $units;
        //print_r ($list);





        if ($priv_val == 0) {
            /*$results = mysql_query("SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update, arch
							from tickets
							where ((unit_id IN (".$units.") and arch='0') or (user_init_id='$user_id')) and (id='$z' or subj like '%" . $z . "%') limit 10
							");*/
							
			$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update, arch
							from tickets
							where ((unit_id IN (:units) and arch=:n) or (user_init_id=:user_id)) and (id=:z or subj like :z1) limit 10');

			$stmt->execute(array(':units' => $units, ':n'=>'0',':user_id'=>$user_id,':z'=>$z,':z1'=>$z));
			$res1 = $stmt->fetchAll();
							
							
							
							
							
        }
        else if ($priv_val == 1) {
        
        
            /*$results = mysql_query("SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update, arch
							from tickets
							where (((user_to_id='$user_id') or
							(user_to_id='0' and unit_id IN (".$units.") )) or user_init_id='$user_id') and (id='$z' or subj like '%" . $z . "%')
							limit 10
							");
							*/
							
										$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update, arch
							from tickets
							where (((user_to_id=:user_id) or
							(user_to_id=:n and unit_id IN (:units) )) or user_init_id=:user_id2) and (id=:z or subj like :z1)
							limit 10');

			$stmt->execute(array(':units' => $units, ':n'=>'0',':user_id'=>$user_id,':z'=>$z,':z1'=>$z,':user_id2'=>$user_id));
			$res1 = $stmt->fetchAll();
							
							
							
							
							
							
        }


        else if ($priv_val == 2) {
            /*$results = mysql_query("SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update, arch
							from tickets
							where id='$z' or subj like '%" . $z . "%'
							limit 10
							");
							*/
							
			$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio, last_update, arch
							from tickets
							where id=:z or subj like :z1
							limit 10');

			$stmt->execute(array(':z'=>$z,':z1'=>$z));
			$res1 = $stmt->fetchAll();
			
			
							
							
							
        }


        //$count_rows = mysql_numrows($results);
        //if ($count_rows == "0") {
        if(empty($res1)) {
            ?>
            <div class="well well-large well-transparent lead">
                <center>
                    <?=lang('MSG_no_records')?>
                </center>
            </div>
        <?php
        }


        //if ($count_rows <> "0") {
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
            //while ($row = mysql_fetch_assoc($results)) {
            foreach($res1 as $row) {
                $lb=$row['lock_by'];
                $ob=$row['ok_by'];
                $arch = $row['arch'];
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

                $user_id_z=id_of_user($_SESSION['helpdesk_user_login']);
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



                    // ЗАявка не выполнена ИЛИ выполнена мной
                    if (($status_ok_z == 0) || (($status_ok_z == 1) && ($ok_by_z == $user_id_z)))
                    {
                        //echo "ЗАявка не выполнена ИЛИ выполнена мной"."<br>";

                        //ЗАявка не заблокирована ИЛИ заблокирована мной
                        if (($lock_by_z == 0) || ($lock_by_z == $user_id_z)) {
                            //echo "ЗАявка не заблокирована ИЛИ заблокирована мной"."<br>";


                            // ЗАявка моего отдела ВСЕМ
                            if ((in_array($row['unit_id'], $u)) && ($row['user_to_id'] == "0")) {
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
                        $style="success";

                        if ($lb <> "0") {
                            $lb_text="<i class=\"fa fa-lock\"></i>";
                            $lb_status="unlock";
                        }
                        if ($lb == "0") {
                            $lb_text="<i class=\"fa fa-unlock\"></i>";
                            $lb_status="lock";
                        }


                    }

                    if ($row['status'] == "0") {
                        $ob_text="<i class=\"fa fa-circle-o\"></i>";
                        $ob_status="ok";

                        if ($lb <> "0") {
                            $lb_text="<i class=\"fa fa-lock\"></i>";
                            $lb_status="unlock";
                            if ($lb == $user_id) {$style="warning";}
                            if ($lb <> $user_id) {$style="active";}
                        }

                        if ($lb == "0") {
                            $lb_text="<i class=\"fa fa-unlock\"></i>";
                            $lb_status="lock";
                        }

                    }

                }

                if ($row['is_read'] <> "0") {

                    if ($row['status'] == "1") {
                        $ob_text="<i class=\"fa fa-check-circle-o\"></i>";
                        $ob_status="unok";
                        $style="success";
                        if ($lb <> "0") {
                            $lb_text="<i class=\"fa fa-lock\"></i>";
                            $lb_status="unlock";
                        }
                        if ($lb == "0") {
                            $lb_text="<i class=\"fa fa-unlock\"></i>";
                            $lb_status="lock";
                        }
                    }
                    if ($row['status'] == "0") {
                        $ob_text="<i class=\"fa fa-circle-o\"></i>";
                        $ob_status="ok";
                        if ($lb <> "0") {
                            $lb_text="<i class=\"fa fa-lock\"></i>";
                            $lb_status="unlock";
                            if ($lb == $user_id) {$style="warning";}
                            if ($lb <> $user_id) {$style="active";}
                        }
                        if ($lb == "0") {
                            $style="";
                            $lb_text="<i class=\"fa fa-unlock\"></i>";
                            $lb_status="lock";
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

                if ($arch == "1") {$st=  "<span class=\"label label-default\">".lang('t_list_a_arch')." </span>";}
                if ($arch == "0") {
                    if ($row['status'] == 1) {$st=  "<span class=\"label label-success\"><i class=\"fa fa-check-circle\"></i> ".lang('t_list_a_oko')." ".nameshort(name_of_user_ret($ob))."</span>";}
                    if ($row['status'] == 0) {
                        if ($lb <> 0) {$st=  "<span class=\"label label-warning\"><i class=\"fa fa-gavel\"></i> ".lang('t_list_a_lock_u')." ".nameshort(name_of_user_ret($lb))."</span>";}
                        if ($lb == 0) {$st=  "<span class=\"label label-primary\"><i class=\"fa fa-clock-o\"></i> ".lang('t_list_a_hold')."</span>";}
                    }
                }
                if ($row['status'] == 1) {$t_ago=get_date_ok($row['date_create'], $row['id']);}
                if ($row['status'] == 0) {$t_ago=humanTiming(strtotime($row['date_create']));}
                
                
                
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
            /*$results = mysql_query("SELECT 
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

			$stmt->execute(array(':units' => $units, ':n'=>'0',':start_pos'=>$start_pos,':perpage'=>$perpage));
			$res1 = $stmt->fetchAll();
							
							
							
							
							
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


			$stmt->execute(array(':user_id'=>$user_id,':units' => $units, ':n'=>'0',':n1'=>'0',':n2'=>'0',':start_pos'=>$start_pos,':perpage'=>$perpage));
			$res1 = $stmt->fetchAll();
							
							
        }
        else if ($priv_val == 2) {
            
            /*results = mysql_query("SELECT 
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

			$stmt->execute(array(':n'=>'0',':start_pos'=>$start_pos,':perpage'=>$perpage));
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
            //if (mysql_num_rows($results) > 0) {
            //while ($row = mysql_fetch_assoc($results)) {
				foreach($res1 as $row) {
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



                
                
                
                if ($row['status'] == 1) {$st=  "<span class=\"label label-success\"><i class=\"fa fa-check-circle\"></i> ".lang('t_list_a_oko')." ".nameshort(name_of_user_ret($ob))."</span>";
	                $t_ago=get_date_ok($row['date_create'], $row['id']);
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
        /*
        
        
        
        Если 0 (нач отдела) то может смотреть все заявки своего отдела
        
        
        
        
        
        
        
        */
        $page=($_POST['page']);
        $perpage='10';
        $start_pos = ($page - 1) * $perpage;
        //$page='N';


        $user_id=id_of_user($_SESSION['helpdesk_user_login']);
        $unit_user=unit_of_user($user_id);
        $units = explode(",", $unit_user);
        $units = implode("', '", $units);
        $priv_val=priv_status($user_id);
        if ($priv_val == 0) {
            
            /*$results = mysql_query("SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, ok_date
							from tickets
							where (unit_id IN (".$units.") or user_init_id='$user_id') and arch='1'
							order by id DESC
							limit $start_pos, $perpage
							");
							*/
							
							
			$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, ok_date
							from tickets
							where (unit_id IN (:units) or user_init_id=:user_id) and arch=:n
							order by id DESC
							limit :start_pos, :perpage');

			$stmt->execute(array(':n'=>'1',':units'=>$units, ':user_id'=>$user_id,':start_pos'=>$start_pos,':perpage'=>$perpage));
			$res1 = $stmt->fetchAll();
							
							
							
							
        }
        else if ($priv_val == 1) {

            /*$results = mysql_query("SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, ok_date
							from tickets
							where ((user_to_id='$user_id' and unit_id IN (".$units.") and arch='1') or
							(user_to_id='0' and unit_id IN (".$units.") and arch='1')) or (user_init_id='$user_id' and arch='1')
							order by id DESC
							limit $start_pos, $perpage
							");
							*/
							
							
			$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, ok_date
							from tickets
							where ((user_to_id=:user_id and unit_id IN (:units) and arch=:n) or
							(user_to_id=:n1 and unit_id IN (:units2) and arch=:n2)) or (user_init_id=:user_id2 and arch=:n3)
							order by id DESC
							limit :start_pos, :perpage');

			$stmt->execute(array(':n'=>'1',':n1'=>'0',':n2'=>'1',':n3'=>'1',':units'=>$units,':units2'=>$units, ':user_id'=>$user_id, ':user_id2'=>$user_id,':start_pos'=>$start_pos,':perpage'=>$perpage));
			$res1 = $stmt->fetchAll();
							
							
							
							
        }
        else	if ($priv_val == 2) {
            /*$results = mysql_query("SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, ok_date
							from tickets
							where arch='1'
							order by id DESC
							limit $start_pos, $perpage
							");*/
							
							
							
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
        if ($aha <> "0") {
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


                //while ($row = mysql_fetch_assoc($results)) {
foreach($res1 as $row) {


                    if ($row['user_to_id'] <> 0 ) {
                        $to_text="<div class=''>".nameshort(name_of_user_ret($row['user_to_id']))."</div>";
                    }
                    if ($row['user_to_id'] == 0 ) {
                        $to_text="<strong data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".get_unit_name_return($row['unit_id'])."\">".lang('t_list_a_all')."</strong>";
                    }










                    ?>
                    <tr >
                        <td style=" vertical-align: middle; "><small><center><?php echo $row['id']; ?></center></small></td>
                        <td style=" vertical-align: middle; "><small><a href="ticket.php?hash=<?php echo $row['hash_name']; ?>"><?php cutstr($row['subj']); ?></a></small></td>
                        <td style=" vertical-align: middle; "><small><?php name_of_client($row['client_id']); ?></small></td>
                        <td style=" vertical-align: middle; "><small><center><?php dt_format($row['date_create']); ?></center></small></td>
                        <td style=" vertical-align: middle; "><small><?=nameshort(name_of_user_ret($row['user_init_id'])); ?></small></td>

                        <td style=" vertical-align: middle; "><small>
                                <?=$to_text?>
                            </small></td>
                        <td style=" vertical-align: middle; "><small>
                                <?=nameshort(name_of_user_ret($row['ok_by'])); ?>
                            </small></td>
                        <td style=" vertical-align: middle; "><small><center><?php dt_format($row['ok_date']); ?></center></small></td>
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
