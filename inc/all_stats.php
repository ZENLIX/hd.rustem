<?php
session_start();
include("../functions.inc.php");

if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {
if ($_SESSION['helpdesk_user_id']) {
   include("head.inc.php");
   include("navbar.inc.php");
   $priv_val = priv_status($_SESSION['helpdesk_user_id']);
 if ( ($priv_val == "2") || ($priv_val == "0") ) {
  

?>


<div class="container">
<input type="hidden" id="main_last_new_ticket" value="<?=get_last_ticket_new($_SESSION['helpdesk_user_id']);?>">
<div class="page-header" style="margin-top: -15px;">
<div class="row">
         <div class="col-md-6"> <h3><i class="fa fa-bar-chart-o"></i> <?=lang('ALLSTATS_main');?></h3></div>
         

         
</div>
 </div>
        

<div class="row" >
<div class="col-md-3">
<div class="alert alert-info" role="alert">
      <small>
      <i class="fa fa-info-circle"></i> 
	      
<?=lang('ALLSTATS_help');?>
      </small>
      </div>

</div>
<div class="col-md-9">
<h4><center><?=lang('ALLSTATS_unit');?></center></h4>
<table class="table table-bordered">
<tbody>
                                <tr>
                    <td style="width: 300px;"></td>
                    <td style=""><strong><small><center><?=lang('ALLSTATS_unit_free');?>	</center></small></strong></td>
                    <td style=""><strong><small><center><?=lang('ALLSTATS_unit_lock');?>		</center></small></strong></td>
                    <td style=""><strong><small><center><?=lang('ALLSTATS_unit_ok');?>	</center></small></strong></td>
                    
                </tr>
<?php

$unit_user=unit_of_user($_SESSION['helpdesk_user_id']);
$ee=explode(",", $unit_user);
foreach ($ee as $key=>$value) { 
?>



                <tr>
                    <td style=""><small><?=get_unit_name_return4news($value);?>	</small></td>
                    <td style=""><small><center><?=get_unit_stat_free($value);?>	</center></small></td>
                    <td style=""><small><center><?=get_unit_stat_lock($value);?>	</center></small></td>
                    <td style=""><small><center><?=get_unit_stat_ok($value);?>		</center></small></td>
                </tr>

                
                
	<?php } ?>
</tbody>
</table>

<h4><center><?=lang('ALLSTATS_user');?></center></h4>
<table class="table table-bordered table-hover">
                <tbody>
                <tr>
                    <td style="width: 200px;">	<strong><small><center><?=lang('ALLSTATS_user_fio');?>					</center></small></strong></td>
                    <td style="">				<strong><small><center><?=lang('t_LIST_status');?>			</center></small></strong></td>
                    <td style="">				<strong><small><center><?=lang('ALLSTATS_user_free');?>			</center></small></strong></td>
                    <td style="">				<strong><small><center><?=lang('ALLSTATS_user_lock');?>			</center></small></strong></td>
                    <td style="">				<strong><small><center><?=lang('ALLSTATS_user_ok');?>			</center></small></strong></td>
                    <td style="">				<strong><small><center><?=lang('ALLSTATS_user_out_all');?>		</center></small></strong></td>
                    <td style="">				<strong><small><center><?=lang('ALLSTATS_user_out_all_not');?>	</center></small></strong></td>
                </tr>
<?php
//$ee - массив id отделов, на которые у меня есть права
//$ec - массив id отделов пользователей
//если какой-то отдел совпадает вывести 
$stmt = $dbConnection->prepare('SELECT id, unit from users');
    $stmt->execute();
	$result = $stmt->fetchAll();
        if (!empty($result)) {
        
        
        
        
foreach ($result as $row) {
$ec=explode(",", $row['unit']);

$result = array_intersect($ee, $ec);
if($result) { 
?>

<tr>
                    <td style="width: 200px;"><small><?=name_of_user_ret($row['id']);?></small></td>
                    <td style=""><small class="text-danger"><center><?=get_user_status($row['id']);?></center></small></td>
                    <td style=""><small class="text-danger"><center><?=get_total_tickets_free($row['id']);?></center></small></td>
                    <td style=""><small class="text-warning"><center><?=get_total_tickets_lock($row['id']);?></center></small></td>
                    <td style=""><small class="text-success"><center><?=get_total_tickets_ok($row['id']);?></center></small></td>
                    <td style=""><small class=""><center><?=get_total_tickets_out($row['id']);?></center></small></td>
                    <td style=""><small class=""><center><?=get_total_tickets_out_and_success($row['id']);?></center></small></td>
</tr>






<?php
}


}}


?>

                </tbody>
</table>
</div>

</div>
</div>

<?php
 include("footer.inc.php");
?>

<?php
}
	}
	}
else {
    include '../auth.php';
}
?>
