<?php
session_start();
include("functions.inc.php");

if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {
if ($_SESSION['helpdesk_user_id']) {
   include("inc/head.inc.php");
   include("inc/navbar.inc.php");
   
  
if (isset($_GET['h'])) {

$h=($_GET['h']);
    
    
    
    $stmt = $dbConnection->prepare('select id, user_init_id, unit_to_id, dt, title, message, hashname
							from helper where hashname=:h');
	$stmt->execute(array(':h' => $h));
	$fio = $stmt->fetch(PDO::FETCH_ASSOC);


	?>
	
	<div class="container">
<input type="hidden" id="main_last_new_ticket" value="<?=get_last_ticket_new($_SESSION['helpdesk_user_id']);?>">
	<div class="page-header" style="margin-top: -15px;">
	<div class="row">
	<div class="col-md-10">
<h3><i class="fa fa-globe"></i> <?=lang('HELPER_title');?></h3>
	</div>

	</div>
     </div>
     <div class="row" id="content_notes" style="padding-bottom: 25px;">
<div class="col-md-1">
<a href="helper.php" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> <?=lang('HELPER_back');?></a>
</div>
<div class="col-md-11" id="">

<div class="panel panel-default">
  <div class="panel-body">
	<h3 style=" margin-top: 0px; "><?=$fio['title']?></h3>
	<p><?=$fio['message']?></p>
	<hr>
	
	<p class="text-right"><small class="text-muted"><?=lang('HELPER_pub');?>: <?=nameshort(name_of_user_ret($fio['user_init_id']));?></small><br><small class="text-muted"><?=lang('HELPER_date');?>: <?=dt_format_full_r($fio['dt']);?></small></p>
	
  </div>
</div>
</div>

</div>
 </div>
	
	<?php
}
else if (!isset($_GET['h'])) {
?>



<div class="container">
<input type="hidden" id="main_last_new_ticket" value="<?=get_last_ticket_new($_SESSION['helpdesk_user_id']);?>">
	<div class="page-header" style="margin-top: -15px;">
	<div class="row">
	<div class="col-md-3">
<h3><i class="fa fa-globe"></i> <?=lang('HELPER_title');?></h3>
	</div>
	
	<div class="col-md-6" style="padding-top: 25px;">                    <div class="input-group">
                        <input type="text" class="form-control input-sm" id="find_helper" autofocus placeholder="<?=lang('HELPER_desc');?>">
      <span class="input-group-btn">
        <button id="" class="btn btn-default btn-sm" type="submit"><i class="fa fa-search"></i> <?=lang('HELPER_find');?></button>
      </span>
                    </div>	</div>
	<div class="col-md-3" style="padding-top: 25px;">
	<button id="create_new_help" type="submit" class="btn btn-success btn-sm btn-block"><i class="fa fa-file-o"></i> <?=lang('HELPER_create');?></button>
	</div>
	</div>
     </div>
     <div class="row" id="content_notes" style="padding-bottom: 25px;">


<div class="col-md-12" id="help_content">
	
	
</div>

</div>
 </div>
        


<?php
}
 include("inc/footer.inc.php");
?>


<?php
	
	}
else {
    include 'auth.php';
}
}
?>