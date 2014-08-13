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
         <div class="col-md-6"> <h3><i class="fa fa-male"></i> <?=lang('POSADA_title');?></h3></div><div class="col-md-6"> 
         
         <h4> <div class="input-group">
      <input type="text" class="form-control input-sm ui-autocomplete-input" id="posada_text" placeholder="<?=lang('POSADA_name');?>" autocomplete="off">
      <span class="input-group-btn">
        <button id="posada_add" class="btn btn-default btn-sm" type="submit"><?=lang('POSADA_add');?></button>
      </span>
    </div></h4></div>
         
</div>
 </div>
        

<div class="row">

      
      <div class="col-md-3">
      <div class="alert alert-info" role="alert">
      <small>
      <i class="fa fa-info-circle"></i> 
	      
<?=lang('POSADA_info');?>
      </small>
      </div>
      </div>

      <div class="col-md-9" id="content_posada">
      
<?php 
	
		//$results = mysql_query("select id, name from posada;");
		$stmt = $dbConnection->prepare('select id, name from posada');
		$stmt->execute();
		$res1 = $stmt->fetchAll(); 
	
	
	
	
?>      
      
      
      
<table class="table table-bordered table-hover" style=" font-size: 14px; " id="">
        <thead>
          <tr>
          	<th><center>ID</center></th>
            <th><center><?=lang('POSADA_n');?></center></th>
            <th><center><?=lang('POSADA_action');?></center></th>
          </tr>
        </thead>
		<tbody>		
		<?php 
		//while ($row = mysql_fetch_assoc($results)) {
			 foreach($res1 as $row) {
		?>
		<tr id="tr_<?=$row['id'];?>">
		
		
		<td><small><center><?=$row['id'];?></center></small></td>
		<td><small><?=$row['name'];?></small></td>
<td><small><center><button id="posada_del" type="button" class="btn btn-danger btn-xs" value="<?=$row['id'];?>">del</button></center></small></td>
		</tr>
				<?php } ?>
		
		
			
		</tbody>
</table>
      <br>
      <?php
      
       ?>
      </div>
      
      
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