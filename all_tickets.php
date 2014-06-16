<?php
session_start();
include("functions.inc.php");

if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {
if (validate_admin($_SESSION['helpdesk_user_id'])) {
   include("inc/head.inc.php");
   include("inc/navbar.inc.php");
   
   
if (isset($_GET['create'])) {
	$status_create="active";
}
if (isset($_GET['list'])) {
	$status_list="active";
}

?>
<style>
.table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
padding: 3px;
}
</style>


<div class="container">
<div class="page-header" style="margin-top: -15px;">
<div class="row">
           <div class="col-md-4"><h3><i class="fa fa-ticket"></i> Всі заявки</h3></div>
  	 <div class="col-md-3" style="padding-top:20px;">
	 <small class="text-muted"><span class="label label-default">&nbsp;</span> - заявка, з якою працюють </small><br>
	 <small class="text-muted"><span class="label label-warning">&nbsp;</span> - заявка, з якою Ви працюєте </small>
	 </div>
	 <div class="col-md-2" style="padding-top:20px; ">
	 <small class="text-muted"><span class="label label-danger">&nbsp;</span> - не прочитана заявка </small><br>
	 <small class="text-muted"><span class="label label-success">&nbsp;</span> - виконана заявка </small>
	 </div>
         
</div>
 </div>
        

<div class="row" id="content_worker">

      
      
<?php
/*
$page=$_POST['page'];
	$perpage='10';
	$start_pos = ($page - 1) * $perpage;
	*/
	
	$user_id=id_of_user($_SESSION['helpdesk_user_login']);
	$unit_user=unit_of_user($user_id);
	//$priv_val=priv_status($user_id);
$results = mysql_query("SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read, lock_by, ok_by, prio
							from tickets
							
							order by id DESC");
							
							
							
							
							
							?>
      <table class="table table-bordered table-hover" style=" font-size: 14px; ">
        <thead>
          <tr>
            <th><center>#</center></th>
            <th><center><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="Прiорiтет"></i></center></th>
            <th><center>Тема</center></th>
            <th><center>Клієнт</center></th>
            <th><center>Створено</center></th>
            <th><center>Пройшло</center></th>
            <th><center>Ініціатор</center></th>
            <th><center>Кому</center></th>
            <th style="width:150px;"><center>Дія</center></th>
          </tr>
        </thead>
		<tbody>			
		<?php
      while ($row = mysql_fetch_assoc($results)) {

$lb=$row['lock_by'];
$ob=$row['ok_by'];

if (priv_status($user_id) == "0") {
	$lock_st="";	$muclass="";
}
if (priv_status($user_id) == "1") {
	if ($lb <> $user_id) {$lock_st="disabled=\"disabled\""; $muclass="text-muted";}
	if (($lb == "0") || ($lb == $user_id)) {$lock_st=""; $muclass="";}
}

if ($row['is_read'] == "0") {

	$style="danger";
	
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
	$to_text="<div class='text-muted'>".name_of_user_ret($row['user_to_id'])."</div>";
}
if ($row['user_to_id'] == 0 ) {
	$to_text="<strong>Всім</strong>";
}

$prio="";

if ($row['prio'] == "1") {$prio= "<span class=\"label label-info\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Низький прiорiтет\"><i class=\"fa fa-arrow-down\"></i></span>"; }

if ($row['prio'] == "2") {$prio= "<span class=\"label label-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Високий прiорiтет\"><i class=\"fa fa-arrow-up\"></i></span>"; }



	?>
		
		<tr id="tr_<?php echo $row['id']; ?>" class="<?=$style?>">
            <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><center><?php echo $row['id']; ?></center></small></td>
            <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><center><?=$prio?></center></small></td>
            <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><a data-toggle="tooltip" data-placement="bottom" title="<?=$row['subj']?>" href="ticket.php?hash=<?php echo $row['hash_name']; ?>"><?php cutstr($row['subj']); ?></a></small></td>
            <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><?php name_of_client($row['client_id']); ?></small></td>
            <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><center><?php dt_format($row['date_create']); ?></center></small></td>
            <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><center><?=humanTiming(strtotime($row['date_create']));?></center></small></td>

            <td style=" vertical-align: middle; "><small class="<?=$muclass;?>"><?php name_of_user($row['user_init_id']); ?></small></td>
            
            <td style=" vertical-align: middle; "><small class="<?=$muclass;?>">
           <?=$to_text?> 
           </small></td>
            <td style=" vertical-align: middle; ">
            <center>
            <div class="btn-group btn-group-xs actions">
				<button <?=$lock_st?> data-toggle="tooltip" data-placement="bottom" title="Блокувати або розблокувати" type="button" class="btn btn-warning" user="<?=$user_id?>" value="<?php echo $row['id']; ?>" id="action_list_lock" status="<?=$lb_status?>"><?=$lb_text?></button>

				<button <?=$lock_st?> data-toggle="tooltip" data-placement="bottom" title="Виконано або не виконано" type="button" class="btn btn-success" user="<?=$user_id?>" value="<?php echo $row['id']; ?>" id="action_list_ok" status="<?=$ob_status?>"><?=$ob_text?></button>
				
				<button data-toggle="tooltip" data-placement="bottom" title="В архів" type="button" class="btn btn-default" user="<?=$user_id?>" value="<?php echo $row['id']; ?>" id="action_arch_now" status=""><i class="fa fa-archive"></i></button>
				
				<button data-toggle="tooltip" data-placement="bottom" title="Видалити назавжди" type="button" class="btn btn-danger" user="<?=$user_id?>" value="<?php echo $row['id']; ?>" id="action_del_time" status=""><i class="fa fa-trash-o"></i></button>
								
								
  			</div>
            </center>
			</td>
          </tr>
		  <?php
	}
	
		?>
	</tbody>
	</table>

      
     
      
      
</div>
      
      
      
      
<br>
</div>
<?php
 include("inc/footer.inc.php");
?>

<?php
	}
	}
else {
    include 'auth.php';
}
?>