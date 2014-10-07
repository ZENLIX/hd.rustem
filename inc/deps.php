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
         <div class="col-md-6"> <h3><i class="fa fa-sitemap"></i> <?=lang('DEPS_title');?></h3></div><div class="col-md-6"> 
         
         <h4> <div class="input-group">
      <input type="text" class="form-control input-sm ui-autocomplete-input" id="deps_text" placeholder="<?=lang('DEPS_name');?>" autocomplete="off">
      <span class="input-group-btn">
        <button id="deps_add" class="btn btn-default btn-sm" type="submit"><?=lang('DEPS_add');?></button>
      </span>
    </div></h4></div>
         
</div>
 </div>
        

<div class="row" >
<div class="col-md-3">

<?php if ($CONF['fix_subj'] == "false") { ?>
<div class="alert alert-danger" role="alert">
      <small>
<?=lang('DEPS_off');?>
      </small>
      </div>
<?php } ?> 

      <div class="alert alert-info" role="alert">
      <small>
      <i class="fa fa-info-circle"></i> 
	      
<?=lang('DEPS_info');?>
      </small>
      </div>
      </div>

      <div class="col-md-9" id="content_deps">
      
      
<?php 
	
		
	
	
			$stmt = $dbConnection->prepare('select id, name, status from deps where id!=:n');
			$stmt->execute(array(':n' => '0'));
			$res1 = $stmt->fetchAll();
	
	
?>      
      
      
      
<table class="table table-bordered table-hover" style=" font-size: 14px; " id="">
        <thead>
          <tr>
          	<th><center>ID</center></th>
            <th><center><?=lang('DEPS_n');?></center></th>
            <th><center><?=lang('DEPS_action');?></center></th>
          </tr>
        </thead>
		<tbody>		
		<?php 
		
			foreach($res1 as $row) {
			
			$cl="";
			if ($row['status'] == "0") {$id_action="deps_show"; $icon="<i class=\"fa fa-eye-slash\"></i>"; $cl="active";}
			if ($row['status'] == "1") {$id_action="deps_hide"; $icon="<i class=\"fa fa-eye\"></i>"; $cl="";}
			
			
		?>
		<tr id="tr_<?=$row['id'];?>" class="<?=$cl;?>">
		
		
		<td><small><center><?=$row['id'];?></center></small></td>
		<td><small><a href="#" data-pk="<?=$row['id']?>" data-url="actions.php" id="edit_deps" data-type="text"><?=$row['name'];?></a></small></td>
<td>

<small><center><button id="deps_del" type="button" class="btn btn-danger btn-xs" value="<?=$row['id'];?>">del</button> 

<button id="<?=$id_action;?>" type="button" class="btn btn-default btn-xs" value="<?=$row['id'];?>"><?=$icon;?></button></center></small>

</td>
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