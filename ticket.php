<?php
session_start();

include("functions.inc.php");


$title_header="Завка #".get_ticket_id_by_hash($_GET['hash'])." - ".$CONF['name_of_firm'];

if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {
    include("inc/head.inc.php");
    include("inc/navbar.inc.php");

    $hn=$_GET['hash'];
    $query = "				SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, comment, last_edit, is_read, lock_by, ok_by, arch, ok_date, prio, last_update
							from tickets
							where hash_name='$hn' 
							";
    $sql = mysql_query($query) or die(mysql_error());
    if (mysql_num_rows($sql) == 1) {
        $row = mysql_fetch_assoc($sql);
        $lock_by=$row['lock_by'];
        $ok_by=$row['ok_by'];
        $ok_date=$row['ok_date'];
        $cid=$row['client_id'];
        $tid=$row['id'];
        $arch=$row['arch'];

        $status_ok=$row['status'];





        if ($arch == 1) {$st= "<span class=\"label label-default\"><i class=\"fa fa-archive\"></i> ".lang('TICKET_status_arch')."</span>";}
        if ($arch == 0) {
            if ($status_ok == 1) {$st=  "<span class=\"label label-success\"><i class=\"fa fa-check-circle\"></i> ".lang('TICKET_status_ok')." ".nameshort(name_of_user_ret($ok_by))."</span>";}
            if ($status_ok == 0) {
                if ($lock_by <> 0) {$st=  "<span class=\"label label-warning\"><i class=\"fa fa-gavel\"></i> ".lang('TICKET_status_lock')." ".name_of_user_ret($lock_by)."</span>";}
                if ($lock_by == 0) {$st=  "<span class=\"label label-primary\"><i class=\"fa fa-clock-o\"></i> ".lang('TICKET_status_new')."</span>";}
            }
        }














        if ($row['user_to_id'] <> 0 ) {
            $to_text="<div class=''>".name_of_user_ret($row['user_to_id'])."</div>";
        }
        if ($row['user_to_id'] == 0 ) {
            $to_text="<strong>".lang('t_list_a_all')."</strong> з ".get_unit_name_return($row['unit_id']);
        }




        if ($row['is_read'] == "0") {

            $q="update tickets set is_read='1' where id='$tid';";
            mysql_query($q);

        }

        if ($lock_by <> "0") {
            if ($lock_by == $_SESSION['helpdesk_user_id']) {
                $status_lock="me";
                //$lock_disabled="";
                $lock_text="<i class=\"fa fa-unlock\"></i> ".lang('TICKET_action_unlock')."";
                $lock_status="unlock";
            }
            else {
                //echo "кем-то";
                $status_lock="you";
                //$lock_disabled="disabled=\"disabled\"";
                $lock_status="unlock";
                $lock_text="<i class=\"fa fa-unlock\"></i> ".lang('TICKET_action_unlock')."";
                //$lock_status="lock";
            }



        }
        if ($lock_by == "0") {

            $lock_text="<i class=\"fa fa-lock\"></i> ".lang('TICKET_action_lock')."";
            $lock_status="lock";

        }

        if ($status_ok == "1") {
            $status_ok_text=lang('TICKET_action_nook');
            $status_ok_status="ok";
            //$status_ok_class="";
        }

        if ($status_ok == "0") {
            $status_ok_text="<i class=\"fa fa-check\"></i> ".lang('TICKET_action_ok')."";
            $status_ok_status="no_ok";
        }




        $inituserid_flag=0;
        if ($row['user_init_id'] == $_SESSION['helpdesk_user_id']) {
            $inituserid_flag=1;
        }



        $prio="<span class=\"label label-info\"><i class=\"fa fa-minus\"></i> ".lang('t_list_a_p_norm')."</span>";

        if ($row['prio'] == "0") {$prio= "<span class=\"label label-primary\"><i class=\"fa fa-arrow-down\"></i> ".lang('t_list_a_p_low')."</span>"; }

        if ($row['prio'] == "2") {$prio= "<span class=\"label label-danger\"><i class=\"fa fa-arrow-up\"></i> ".lang('t_list_a_p_high')."</span>"; }




        ?>
        <style>
            .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
                padding: 5px;
            }


            .animated {
                -webkit-transition: height 0.2s;
                -moz-transition: height 0.2s;
                transition: height 0.2s;
            }
        </style>
        <input type="hidden" id="main_last_new_ticket" value="<?=get_last_ticket_new($_SESSION['helpdesk_user_id']);?>">
        <input type="hidden" id="last_update" value="<?=$row['last_update'];?>">
        <input type="hidden" id="ticket_id" value="<?=$row['id'];?>">
        <div class="container">

        <div class="row">

        <div class="col-md-8">
        <?php if (isset($_GET['refresh'])) { ?>
            <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="fa fa-refresh"></i> <?=lang('TICKET_msg_updated');?></div>
        <?php
        }
        ?>
        <div class="panel panel-default" id="ticket_body">
        <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-ticket"></i> <?=lang('TICKET_name');?> <strong>#<?=$row['id']?></strong></h3> </div>
        <div class="panel-body">
<?php
//date_default_timezone_set('Europe/Kiev');
//echo date('l jS \of F Y h:i:s A');
?>


        <table class="table table-bordered">
            <tbody>
            <tr>
                <td style="width:50px;"><small><strong><?=lang('TICKET_t_from');?> </strong></small></td>
                <td><small><?=name_of_user($row['user_init_id'])?> </small></td>
                <td style="width:150px;"><small><strong> <?=lang('TICKET_t_was_create');?></strong></small></td>
                <td style="width:150px;"><small><?=dt_format($row['date_create'])?> </small></td>
            </tr>
            <tr>
                <td style="width:50px;"><small><strong><?=lang('TICKET_t_to');?> </strong></small></td>
                <td><small><?=$to_text;?> </small></td>
                <td style="width:50px;"><small><strong><?=lang('TICKET_t_last_edit');?> </strong></small></td>
                <td><small><?php if ($row['last_edit']) { echo dt_format($row['last_edit']); } ?> </small></td>
            </tr>
            <tr>
                <td><small><strong><?=lang('TICKET_t_worker');?></strong></small>
                </td>
                <td class=""><small><?=name_of_client($cid)?></small></td>

                <td style="width:50px;"><small><strong><?=lang('TICKET_t_last_up');?> </strong></small></td>
                <td><small><?php if ($row['last_update']) { echo dt_format($row['last_update']); } ?> </small></td>


            </tr>
            <tr>
                <td><small><strong><?=lang('TICKET_t_status');?></strong></small>
                </td>
                <td><small><?=$st;?></small></td>
                <td><small><strong><?=lang('TICKET_t_prio');?></strong></small>
                </td>
                <td><small><?=$prio;?></small>
                </td>
            </tr>

            </tbody>
        </table>







        <style>
            .tabler>thead>tr>th, .tabler>tbody>tr>th, .tabler>tfoot>tr>th, .tabler>thead>tr>td, .tabler>tbody>tr>td, .tabler>tfoot>tr>td {
                padding: 8px;
                line-height: 1.428571429;
                vertical-align: top;}
        </style>





        <div class="panel panel-default">

            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td style="width:50px;padding: 8px;border-right: 0px;"><small><strong><?=lang('TICKET_t_subj');?>: </strong></small></td>
                    <td style="padding: 8px; border-left: 0px;"><?php if (($inituserid_flag == 1) && ($arch == 0)) {?>

                        <a href="#" data-pk="<?=$tid?>" data-url="actions.php" id="edit_subj_ticket" data-type="text">
                            <?php } ?>
                            <?=$row['subj']?>
                            <?php if (($inituserid_flag == 1) && ($arch == 0)) {?></a><?php }?> </td>

                </tr>
                <tr>
                    <td style=" padding: 20px; " colspan="2"><?php if (($inituserid_flag == 1) && ($arch == 0)) {?><a href="#" data-pk="<?=$tid?>" data-url="actions.php" id="edit_msg_ticket" data-type="textarea"><?php } ?><?=$row['msg']?><?php if (($inituserid_flag == 1) && ($arch == 0)) {?></a><?php }?> </td>
                </tr>
                </tbody>
            </table>
            
            
                <?php
               //$h $_GET['hash']
        $query="SELECT name FROM files where h_name='$hn';";
        $res = mysql_query($query) or die(mysql_error());
		if(mysql_num_rows($res)>0) { 
			//$r= mysql_fetch_assoc( $res );
			?>
			<hr style="margin:0px;">
			<div class="row" style="padding:10px;">
			<div class="col-md-3">
			<center><small><strong>Додаткові файли:</strong></small></center>
			</div>
			<div class="col-md-9">
						<ul>
										<?php
			while ($r = mysql_fetch_assoc($res)) {
		?>
                 <li>
	                 <small><a target="_blank" href='upload_files/<?=$r['name'];?>'><?=$r['name'];?></a></small>
                 </li>
                <?php }?>
						</ul>

			</div>
			</div>
			
			
                <?php
                } ?>













        </div>
        <?php
        $user_id=id_of_user($_SESSION['helpdesk_user_login']);
        $unit_user=unit_of_user($user_id);
        $ps=priv_status($user_id);

        /*
        1. Если я нач отдела 
            1.1. Заявка моего отдела
        2. Если я пользователь
        +	2.1. Заявка не в архиве
        -	2.2. Заявка не выполнена ИЛИ выполнена мной
        +	2.3. Заявка моего отдела ВСЕМ
        +	2.4. Заявка МНЕ
        +	2.5. Инициатор заявки я
        
        */

        $lo="no";
        if ($ps == "0") {
            //echo "нач";	
            if ($arch == 0) {
                $u=explode(",",$unit_user);

                if (in_array($row['unit_id'], $u)) {$lo="yes";}

                //инициатор заявки я
                if ($row['user_init_id'] == $user_id) {
                    //echo "инициатор заявки я"."<br>";
                    $lo="yes";
                    //echo "f";
                }


                // Заявка мне
                if ($row['user_to_id'] == $user_id) {
                    //echo "ЗАявка мне"."<br>";
                    $lo="yes";
                }

            }

        }
        else	if ($ps == "2") {
            //echo "нач";	
            if ($arch == 0) {


                if ($row['unit_id'] == $unit_user) {$lo="yes";}

                $lo="yes";

            }

        }


        else if ($ps == "1") {
            $u=explode(",",$unit_user);
            if ($arch == 0) {
                //echo "заявка не в архиве"."<br>";


                // ЗАявка не выполнена ИЛИ выполнена мной
                if (($status_ok == 0) || (($status_ok == 1) && ($ok_by == $user_id)))
                {
                    //echo "ЗАявка не выполнена ИЛИ выполнена мной"."<br>";

                    //ЗАявка не заблокирована ИЛИ заблокирована мной
                    if (($lock_by == 0) || ($lock_by == $user_id)) {
                        //echo "ЗАявка не заблокирована ИЛИ заблокирована мной"."<br>";


                        // ЗАявка моего отдела ВСЕМ

                        if ((in_array($row['unit_id'], $u)) && ($row['user_to_id'] == "0")) {
                            //echo "ЗАявка моего отдела ВСЕМ"."<br>";
                            $lo="yes";
                        }

                        // Заявка мне
                        if ($row['user_to_id'] == $user_id) {
                            //echo "ЗАявка мне"."<br>";
                            $lo="yes";
                        }

                        //инициатор заявки я
                        if ($row['user_init_id'] == $user_id) {
                            //echo "инициатор заявки я"."<br>";
                            $lo="yes";
                            //echo "f";
                        }
                    }
                    if ($row['user_init_id'] == $user_id) {
                        //echo "инициатор заявки я"."<br>";
                        $lo="yes";
                        //echo "f";
                    }
                }



            }



            //echo("user");
        }

        //echo $lo;



        if ($lo == "no") {$lock_disabled="disabled=\"disabled\"";}
        if ($lo == "yes") {$lock_disabled="";}

        //echo $row['unit_id']." eval ".$unit_user;







        /*
        
              if ($arch == 1) {$st= "заявка в архіві";}  
          if ($arch == 0) {
              if ($status_ok == 1) {$st=  "заявка виконана користувачем ".name_of_user_ret($ok_by);} 
              if ($status_ok == 0) {
                  if ($lock_by <> 0) {$st=  "с заявкою працює ".name_of_user_ret($lock_by);}
                  if ($lock_by == 0) {$st=  "нова заявка, очікування дії";}
              }
          } 
        */



        /*
    if (
    ((($row['user_to_id'] == $_SESSION['helpdesk_user_id'])
        ||
        ( ($row['unit_id'] == $unit_user))) || ($row['user_init_id'] == $user_id)
    ) && ($arch == 0) ){
    
    
    */
        //IN ticket
        ?>
        <hr>


        <div class="col-md-12">
            <div id="ccc"></div>



            <hr style=" margin-top: 0px;
 margin-bottom: 0px; ">


            <div class="btn-group btn-group-justified">
                <div class="btn-group">
                    <button <?=$lock_disabled?> id="action_refer_to" value="0" type="button" class="btn btn btn-danger"><i class="fa fa-share"></i> <?=lang('TICKET_t_refer');?></button>
                </div>



                <div class="btn-group">
                    <button <?=$lock_disabled?> id="action_lock" status="<?=$lock_status?>" value="<?=$_SESSION['helpdesk_user_id']?>" tid="<?=$tid?>" type="button" class="btn btn btn-danger"> <?=$lock_text?></button>
                </div><div class="btn-group">
                    <button <?=$lock_disabled?> id="action_ok" status="<?=$status_ok_status?>" value="<?=$_SESSION['helpdesk_user_id']?>" tid="<?=$tid?>" type="button" class="btn btn btn-danger"><?=$status_ok_text?> </button>
                </div>
            </div>
            </center>


        </div>
        <div id="refer_to" class="col-md-12 panel panel-default" style="padding:10px; margin-top: 20px; margin-bottom: 0px;">




            <div class="form-group" id="t_for_to" data-toggle="popover" data-html="true" data-trigger="manual" data-placement="right" data-content="<small><?=lang('NEW_to_unit_desc');?></small>">
                <label for="to" class="col-sm-3 control-label"><small><?=lang('TICKET_t_refer_to');?>: </small></label>
                <div class="col-sm-5" style="">
                    <select <?=$lock_disabled?> data-placeholder="<?=lang('NEW_to_unit');?>" class="chosen-select form-control input-sm" id="t_to" name="unit_id">
                        <option value="0"></option>
                                        <?php
                        $qstring = "SELECT name as label, id as value FROM deps where id !='0' ;";
                        $result = mysql_query($qstring);//query the database for entries containing the term

                        while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
                        {
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



                <div class="col-sm-3" style="">

                    <select <?=$lock_disabled?> data-placeholder="<?=lang('NEW_to_user');?>" class="chosen-select form-control input-sm" id="t_users_do" name="unit_id">
                        <option value="0"></option>
                        <?php
                        $qstring = "SELECT fio as label, id as value FROM users where status='1' and login !='system' order by fio ASC;";
                        $result = mysql_query($qstring);//query the database for entries containing the term

                        while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
                        {
//echo($row['label']);
                            $row['label']=$row['label'];
                            $row['value']=(int)$row['value'];


                            ?>

                            <option value="<?=$row['value']?>"><?=$row['label']?></option>

                        <?php


                        }

                        ?>

                    </select>
                    <p class="help-block"><small style="padding-left:30px;"><?=lang('TICKET_t_opt');?></small></p>

                </div>
                <div class="col-sm-1" style="">
                    <button id="ref_ticket" value="<?=$tid?>" type="button" class="btn btn-default btn-sm" <?=$lock_disabled?>><i class="fa fa-check"></i></button>
                </div>

            </div>




        </div>





        <?php

        //else {
        //OUT ticket
        ?>


        <!--div class="col-md-12">
	<?php if (0 == 0) { ?>
	<hr>
	            

				<button type="button" class="btn btn-block btn btn-danger"id="action_ok" status="<?=$status_ok_status?>" value="<?=$_SESSION['helpdesk_user_id']?>" tid="<?=$tid?>" ><?=$status_ok_text?></button>

            </center>
            
            <?php } ?>
	
</div-->







        <?php
        //}




        if ($arch == 1) {
            ?>
            <div class="col-md-12" style="padding-top:20px;">
                <div class="alert alert-warning"><?=lang('TICKET_t_in_arch');?></div>
            </div>
        <?php
        }
        if ($arch == 0) {
            if ($status_ok == 1) {
                ?>


                <div class="col-md-12" style="padding-top:20px;" id="msg_e">
                    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?=lang('TICKET_t_ok');?> <strong> <?=name_of_user($ok_by)?></strong> <?php dt_format($ok_date); ?>.<br> <?=lang('TICKET_t_ok_1');?></div>
                </div>


            <?php
            }
            if ($status_ok == 0) {
                if ($lock_by <> 0) {
                    if ($status_lock == "you") {

                        ?>
                        <div class="col-md-12" style="padding-top:20px;">
                            <div class="alert alert-warning"><?=lang('TICKET_t_lock');?> <strong><?=name_of_user($lock_by)?></strong>. <br><?=lang('TICKET_t_lock_1');?></div>
                        </div>
                    <?php
                    }
                    if ($status_lock == "me") {

                        ?>
                        <div class="col-md-12" style="padding-top:20px;" id="msg_e">
                            <div class="alert alert-warning"><?=lang('TICKET_t_lock_i');?></div>
                        </div>
                    <?php
                    }

                }

            }
        }













        ?>

        <div class="col-md-12" style="" id="msg">
        </div>



        <br>

        </div>


        </div>






        <div  class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#home" data-toggle="tab"><i class="fa fa-comments-o"></i> <?=lang('TICKET_t_comment');?></a></li>
                <li><a href="#profile" data-toggle="tab"><i class="fa fa-list"></i> <?=lang('TICKET_t_history');?></a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade in active" id="home"><?php

                    $rew = mysql_query("SELECT user_id, comment_text, dt from comments
							 where
							t_id='$tid';
							");


                    ?>
                    <div class="col-md-12" style=" padding-left: 0px; padding-right: 0px; ">

                        <div class="panel panel-default">

                            <div class="panel-body">

                                <div id="comment_content">
                                    <table class="table ">
                                        <tbody>
                                        <?php while ($rews = mysql_fetch_assoc($rew)) { ?>
                                            <tr>
                                                <td style="width:200px;"><center><strong><?=nameshort(name_of_user_ret($rews['user_id']));?></strong><br><small class="text-muted"><?=dt_format($rews['dt'])?></small></center></td>
                                                <td><?=$rews['comment_text']?></td>

                                            </tr>
                                        <?php } ?>


                                        </tbody>
                                    </table>
                                </div>





                                <div class="control-group">
                                    <div class="controls">
                                        <div class="form-group" id="for_msg">
                                            <label for="msg" class="col-sm-3 control-label"><small><?=lang('TICKET_t_your_comment');?>:</small></label>
                                            <div class="col-sm-9" style="">






                                                <textarea data-toggle="popover" data-html="true" data-trigger="manual" data-placement="right" data-content="&lt;small&gt;<?=lang('TICKET_t_det_ticket');?>&lt;/small&gt;" placeholder="<?=lang('TICKET_t_comm_ph');?>" class="form-control input-sm animated" name="msg" id="msg" rows="1" required="" data-validation-required-message="Укажите сообщение" aria-invalid="false"></textarea>





                                            </div>
                                            
                                            <div class="col-sm-9"></div>
                                            <div class="col-sm-3" style=""><button id="do_comment" user="<?=$_SESSION['helpdesk_user_id']?>" value="<?=$tid?>" type="button" class="btn btn-default btn-sm"><?=lang('TICKET_t_send');?> (ctrl+enter)</button></div>
                                            
                                        </div>
                                        <div class="help-block" style="margin:0px;"></div></div></div>







                            </div>
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade" id="profile"><?php
                    ///////////////////////////////



                    $re = mysql_query("SELECT msg,
							date_op, init_user_id, to_user_id, to_unit_id from ticket_log where
							ticket_id='$tid' order by date_op DESC;
							");

                    if(mysql_num_rows($re)>0) {






                        ?>

                        <div class="col-md-12" style=" padding-left: 0px; padding-right: 0px; ">


                            <div class="panel panel-default">
                                <div class="panel-body">

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
                                        <?php while ($row = mysql_fetch_assoc($re)) {



                                            $t_action=$row['msg'];

                                            if ($t_action == 'refer') {
                                                $icon_action="fa fa-long-arrow-right";
                                                $text_action="".lang('TICKET_t_a_refer')." <br>".get_unit_name_return($row['to_unit_id'])."<br>".name_of_user_ret($row['to_user_id']);

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
                                            // get_unit_name($row['to_unit_id']
                                            // name_of_user($row['to_user_id']
                                            ?>
                                            <tr>
                                                <td style="width: 100px; vertical-align: inherit;"><small><center><?=dt_format_full($row['date_op'])?></center></small></td>
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



                    <?php } ?></div>
            </div>
        </div>
        </div>


        <div class="col-md-4">
            <div class="panel panel-info">
                <?=get_client_info_ticket($cid)?>
            </div>
        </div>



        </div>

        </div>
    <?php







    }
    else {
        ?>
        <div class="well well-large well-transparent lead">
            <center><?=lang('TICKET_t_no');?></center>
        </div>
    <?php
    }



    ?>


    <?php
    include("inc/footer.inc.php");

}
else {
    include 'auth.php';
}
?>