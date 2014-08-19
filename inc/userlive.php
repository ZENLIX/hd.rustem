<?php
session_start();
include("../functions.inc.php");

if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {
if (validate_admin($_SESSION['helpdesk_user_id'])) {
   include("head.inc.php");
   include("navbar.inc.php");
   
  

?>


<div class="container">
<div class="page-header" style="margin-top: -15px;">
<div class="row">
         <div class="col-md-6"> <h3><i class="fa fa-history"></i> <?=lang('Live_title');?></h3></div><div class="col-md-6"> 
         
</div>
         
</div>
 </div>
        

<div class="row" >
<div class="col-md-3">



      <div class="alert alert-info" role="alert">
      <small>
      <i class="fa fa-info-circle"></i> 
          
<?=lang('Live_info');?>
      </small>
      </div>
      </div>

      <div class="col-md-9" id="content_users">
      
      
<?php 
    
	
    
    
	    $stmt = $dbConnection->prepare('select id, fio,last_login,live  from users');
	    $stmt->execute();
	    $res1 = $stmt->fetchAll();
    
    
?>      
      
      
      
<table class="table table-bordered table-hover" style=" font-size: 14px; ">
        <thead>
          <tr>
            <th><center>ID</center></th>
            <th><center><?=lang('Live_name');?></center></th>
            <th><center><?=lang('Live_status');?></center></th>
          </tr>
        </thead>
	<tbody>		
	<?php 
	
	    foreach($res1 as $row) {
	    $cl="";
			if ($row['live'] == "0") {$icon="<i class=\"fa fa-thumbs-down\"></i> <span class=\"label label-danger\">".lang('Live_status_off')."</span>"; $cl="active";}
			if ($row['live'] == "1") {$icon="<i class=\"fa fa-thumbs-up\"></i> <span class=\"label label-success\">".lang('Live_status_on')."</span>"; $cl="";}

	?>
	<tr id="tr_<?=$row['id'];?>" class="<?=$cl;?>">
	
	
	<td><small><center><?=$row['id'];?></center></small></td>
	
	<td><small><?=$row['fio'];?></small></td>
	<td style=" vertical-align: middle; "><small><center><?=$icon;?></center></small></td>
	

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
