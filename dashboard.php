

<input type="hidden" id="main_last_new_ticket" value="<?=get_last_ticket_new($_SESSION['helpdesk_user_id']);?>">

	    <style>
        .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
            padding: 3px;
        }
    </style>
<div class="container">
<div class="page-header" style="margin-top: -15px;">
<h3><i class="fa fa-tachometer"></i> <?=lang('DASHBOARD_TITLE');?></h3>
</div>
<div class="row" style="">

<div class="col-md-6">

<div class="alert alert-info alert-dismissable">
  
  <center><strong><?=get_myname();?><?=lang('DASHBOARD_def_msg');?>
</div>

</div>
<div class="col-md-6">
<div class="panel panel-default">
  <div class="panel-heading"><a href="stats.php"><i class="fa fa-bar-chart-o"></i> <?=lang('DASHBOARD_ticket_stats');?></a></div>
  <div class="panel-body">
  <div class="row">
  <!--div class="col-md-3 col-xs-3"><center>	<strong class="text-primary" style="font-weight: bold; font-style: normal; font-variant: normal; font-size: 20px;"><?=get_total_tickets_out();?></strong><br><small><i class="fa fa-tag"></i>  створено	</small>	</center></div>
    <div class="col-md-3 col-xs-3"><center>	<strong class="text-success" style="font-weight: bold; font-style: normal; font-variant: normal; font-size: 20px;"><?=get_total_tickets_ok();?></strong><br><small><i class='fa fa-check-circle-o'></i> виконано	</small>	</center></div-->  
  <div class="col-md-4 col-xs-4"><center>    <strong class="text-danger"  style="font-weight: bold; font-style: normal; font-variant: normal; font-size: 20px;" data-toggle="tooltip" data-placement="top" title="<?=lang('DASHBOARD_ticket_in_desc');?>">
  <a class="text-danger" href="list.php?in" id="d_label_1"><?=get_total_tickets_free();?></a>
  </strong><br><small><i class="fa fa-download"></i> <?=lang('DASHBOARD_ticket_in');?>	</small>	</center></div>
    
  <div class="col-md-4 col-xs-4"><center>	<strong class="text-warning" style="font-weight: bold; font-style: normal; font-variant: normal; font-size: 20px;" data-toggle="tooltip" data-placement="top" title="<?=lang('DASHBOARD_ticket_lock_desc');?>" id="d_label_2"><?=get_total_tickets_lock();?></strong><br><small><i class='fa fa-lock'></i> <?=lang('DASHBOARD_ticket_lock');?> </small>	</center></div>
  
  <div class="col-md-4 col-xs-4"><center>	<strong class="text-primary" style="font-weight: bold; font-style: normal; font-variant: normal; font-size: 20px;" data-toggle="tooltip" data-placement="top" title="<?=lang('DASHBOARD_ticket_out_desc');?>"><a class="text-primary" href="list.php?out" id="d_label_3"><?=get_total_tickets_out_and_success();?></a></strong><br><small><i class="fa fa-upload"></i>  <?=lang('DASHBOARD_ticket_out');?></small>	</center></div>

  </div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-6">
<div class="panel panel-default">
  <div class="panel-heading"><i class="fa fa-bullhorn"></i> <?=lang('DASHBOARD_last_news');?></div>
  <div class="panel-body">
    
    
    
    <div id="last_news"></div>
    
    
    
  </div>
</div>
</div>
<div class="col-md-6">
<div class="panel panel-default">
  <div class="panel-heading"><a href="helper.php"><i class="fa fa-globe"></i> <?=lang('DASHBOARD_last_help');?></a></div>
  <div class="panel-body">
  <?php
    $user_id=id_of_user($_SESSION['helpdesk_user_login']);
        $unit_user=unit_of_user($user_id);
        $priv_val=priv_status($user_id);

        $units = explode(",", $unit_user);
        //$units = "'". implode("', '", $units) ."'";
        array_push($units,"0");
        
        $results = mysql_query("SELECT 
							id, user_init_id, unit_to_id, dt, title, message, hashname
							from helper
							order by dt desc
							limit 5
							");
        ?>
<table class="table table-hover" style="margin-bottom: 0px;" id="">
<?php
        while ($row = mysql_fetch_assoc($results)) {
        $unit2id = explode(",", $row['unit_to_id']);
        $diff = array_intersect($units, $unit2id);
        if ($priv_val == 1) {
        	if ($diff) {$ac= "ok";}
        
        
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
        <tr><td><small><i class="fa fa-file-text-o"></i> </small><a href="helper.php?h=<?=$row['hashname'];?>"><small><?=cutstr_help2_ret($row['title']);?></small></a></td><td><small style="float:right;" class="text-muted">(<?=lang('DASHBOARD_author');?>: <?=nameshort(name_of_user_ret($row['user_init_id']));?>)</small></td></tr>

        <?php }
        }?>
</table>
  </div>
</div>
</div>

<div class="col-md-12">
<div class="panel panel-default">
  <div class="panel-heading"><a href="list.php?in"><i class="fa fa-list-alt"></i> <?=lang('DASHBOARD_last_in');?></a></div>
  <div class="panel-body">
    
    <div id="spinner" class="well well-large well-transparent lead">
                <center><i class="fa fa-spinner fa-spin icon-2x"></i> <?=lang('LIST_loading');?> ...</center>
    </div>
            
    <div id="dashboard_t"></div>
    
    
  </div>
</div>
</div>
</div>
 </div>
        


