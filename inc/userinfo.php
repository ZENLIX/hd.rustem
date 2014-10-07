<?php
session_start();
include("../functions.inc.php");

if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {

   include("head.inc.php");
   include("navbar.inc.php");
   
$user_id=($_GET["user"]);
$user_ids=id_of_user($_SESSION['helpdesk_user_login']);
$priv_val=priv_status($user_ids);


if (($priv_val=="2") || ($priv_val=="0")) {


?>
<div class="container">
<div class="page-header" style="margin-top: -15px;">
          <h3 ><?=lang('userinfo_ticket');?> <?=name_of_client($user_id);?></h3>
 </div>
 
 
 
 
<div class="row" style="padding-bottom:20px;">
<div class="col-md-4">
	<div class="panel panel-info">
	  
	  
	<?php
	get_client_info_ticket($user_id);
	?>
	  </div>
</div>
  <div class="col-md-8">
  
  <?php

	    
	    
		$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read,lock_by, ok_by, arch
							from tickets
							where client_id=:user_id
							order by id DESC');
		$stmt->execute(array(':user_id' => $user_id));
		$res1 = $stmt->fetchAll();   
		if (!empty($res1)) {
		              
        foreach($res1 as $row) {	    
	    
	    
	    
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
                $to_text="<strong>".lang('t_list_a_all')."</strong> з ".view_array(get_unit_name_return($row['unit_id']));
            }




            if ($row['is_read'] == "0") {


                $res = $dbConnection->prepare("update tickets set is_read=:n where id=:tid");
                $res->execute(array(':n' => '1', ':tid'=>$tid));

            }

            if ($lock_by <> "0") {
                if ($lock_by == $_SESSION['helpdesk_user_id']) {
                    $status_lock="me";
                    //$lock_disabled="";
                    $lock_text="<i class=\"fa fa-unlock\"></i> ".lang('TICKET_action_unlock')."";
                    $lock_status="unlock";
                }
                else {

                    $status_lock="you";

                    $lock_status="unlock";
                    $lock_text="<i class=\"fa fa-unlock\"></i> ".lang('TICKET_action_unlock')."";

                }



            }
            if ($lock_by == "0") {

                $lock_text="<i class=\"fa fa-lock\"></i> ".lang('TICKET_action_lock')."";
                $lock_status="lock";

            }

            if ($status_ok == "1") {
                $status_ok_text=lang('TICKET_action_nook');
                $status_ok_status="ok";

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
	    <div class="panel panel-default">
  <div class="panel-heading"><i class="fa fa-ticket"></i> <a href="<?=$CONF['hostname']?>/ticket?<?=$row['hash_name']?>"> <?=lang('TICKET_name');?> <strong>#<?=$row['id']?></strong></a></div>
  <div class="panel-body">
	    <table class="table table-bordered">
                <tbody>
                <tr>
                    <td style="width:50px;"><small><strong><?=lang('TICKET_t_from');?> </strong></small></td>
                    <td><small><?=name_of_user($row['user_init_id'])?> </small></td>
                    <td style="width:150px;"><small><strong> <?=lang('TICKET_t_was_create');?></strong></small></td>
                    <td style="width:150px;"><small><time id="c" datetime="<?=$row['date_create']; ?>"></time> </small></td>
                </tr>
                <tr>
                    <td style="width:50px;"><small><strong><?=lang('TICKET_t_to');?> </strong></small></td>
                    <td><small><?=$to_text;?> </small></td>
                    <td style="width:50px;"><small><strong><?=lang('TICKET_t_last_edit');?> </strong></small></td>
                    <td><small><?php if ($row['last_edit']) { ?> <time id="c" datetime="<?=$row['last_edit'];?>"></time> <?php } ?> </small></td>
                </tr>
                <tr>
                    <td><small><strong><?=lang('TICKET_t_worker');?></strong></small>
                    </td>
                    <td class=""><small><?=name_of_client($cid)?></small></td>

                    <td style="width:50px;"><small><strong><?=lang('TICKET_t_last_up');?> </strong></small></td>
                    <td><small><?php if ($row['last_update']) { ?> <time id="c" datetime="<?=$row['last_update'];?>"></time> <?php } ?> </small></td>


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
            <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td style="width:50px;padding: 8px;border-right: 0px;"><small><strong><?=lang('TICKET_t_subj');?>: </strong></small></td>
                        <td style="padding: 8px; border-left: 0px;">

                                <?=make_html($row['subj'])?>
                     </td>

                    </tr>
                    <tr>
                        <td style=" padding: 5px; " colspan="2"><?=make_html($row['msg'])?> </td>
                    </tr>
                    </tbody>
                </table>

  </div></div>
	    <?php
	    
	    }							
  
  }
   ?>
  
  
  
  
  
  
  </div>
  
  
  
  
  
</div>
 
</div>

















<?php
}
 include("footer.inc.php");
?>

<?php
	}
else {
    include 'auth.php';
}
?>
