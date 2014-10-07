<?php
session_start();
include("../functions.inc.php");

if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {
if (validate_admin($_SESSION['helpdesk_user_id'])) {
   include("head.inc.php");
   include("navbar.inc.php");
   
  

?>


<div class="container">
<input type="hidden" id="main_last_new_ticket" value="<?=get_last_ticket_new($_SESSION['helpdesk_user_id']);?>">
<div class="page-header" style="margin-top: -15px;">
<div class="row">
         <div class="col-md-6"> <h3><i class="fa fa-files-o"></i> <?=lang('FILES_title');?></h3></div><div class="col-md-6"> 
         
</div>
         
</div>
 </div>
        

<div class="row" >
<div class="col-md-3">

<?php if ($CONF['file_uploads'] == "false") { ?>
<div class="alert alert-danger" role="alert">
      <small>
<?=lang('FILES_off');?>
      </small>
      </div>
<?php } ?> 

      <div class="alert alert-info" role="alert">
      <small>
      <i class="fa fa-info-circle"></i> 
	      
<?=lang('FILES_info');?>
      </small>
      </div>
      </div>

      <div class="col-md-9" id="content_files">
      
      
<?php 
	
		
	
	
			$stmt = $dbConnection->prepare('select id, ticket_hash, original_name,file_hash,file_type,file_size,file_ext from files');
			$stmt->execute();
			$res1 = $stmt->fetchAll();
	
	
?>      
      
      
      
<table class="table table-bordered table-hover" style=" font-size: 14px; " id="">
        <thead>
          <tr>
          	<th><center>ID</center></th>
            <th><center><?=lang('FILES_name');?></center></th>
            <th><center><?=lang('FILES_ticket');?></center></th>
            <th><center><?=lang('FILES_size');?></center></th>
            <th><center><?=lang('t_LIST_action');?></center></th>
          </tr>
        </thead>
		<tbody>		
		<?php 
		
			foreach($res1 as $row) {
		?>
		<tr id="tr_<?=$row['id'];?>">
		
		
		<td><small><center><?=$row['id'];?></center></small></td>
		
		<td><small><?=get_file_icon($row['file_hash']);?> <?=$row['original_name'];?></small></td>
		<td><small><a href="./ticket?<?=$row['ticket_hash']?>">#<?=get_ticket_id_by_hash($row['ticket_hash']);?></a></small></td>
		<td><small><?=round(($row['file_size']/(1024*1024)),2);?> Mb</small></td>
<td><small><center>
<button id="files_del" type="button" class="btn btn-danger btn-xs" value="<?=$row['file_hash'];?>" title="<?=lang('FILES_del');?>"><i class="fa fa-trash-o"></i> </button>
<a href="<?=$CONF['hostname'];?>sys/download.php?<?=$row['file_hash'];?>" class="btn btn-success btn-xs" title="<?=lang('FILES_down');?>"><i class="fa fa-download"></i> </a>
</center></small></td>


		</tr>
				<?php } ?>
		
		
			
		</tbody>
</table>
      </div>
            <br>
      <?php
      
       ?>
     
      
      
</div>
      
      
      
      
<br>
</div>
<?php
 include("footer.inc.php");
?>

<?php
	}
	}
else {
    include '../auth.php';
}
?>
