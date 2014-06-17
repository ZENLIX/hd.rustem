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
          <h3 ><i class="fa fa-users"></i> <?=lang('USERS_title');?></h3>
 </div>
        

<div class="row">
  <div class="col-md-3">
	  <ul class="nav nav-pills nav-stacked">
  <li class="<?=$status_create?>"><a href="users.php?create" id="create_user"><i class="fa fa-male"></i> <?=lang('USERS_create');?></a></li>
  <li class="<?=$status_list?>"><a href="users.php?list" id="list_user"><i class="fa fa-list-alt"></i> <?=lang('USERS_list');?></a></li>
 </ul>
  </div>
  <div class="col-md-8">
	  <div id="content_users">
	  <?php
	  
	  if (isset($_GET['create'])) {
		//echo "in";
		$_POST['menu']="new";
		include_once("inc/users.inc.php");
		}
		
		if (isset($_GET['list'])) {
		//echo "in";
		$_POST['menu']="list";
		include_once("inc/users.inc.php");
		}
		
		if (isset($_GET['edit'])) {
		//echo "in";
		$_POST['menu']="edit";
		$_POST['id']=$_GET['edit'];
		include_once("inc/users.inc.php");
		}
	  
	  ?>
</div>
	  </div>
      
      

      
      
      
     
      
      
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