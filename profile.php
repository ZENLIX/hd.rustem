<?php
session_start();
include("functions.inc.php");

if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {
//if (validate_admin($_SESSION['helpdesk_user_id'])) {
   include("inc/head.inc.php");
   include("inc/navbar.inc.php");
   
 

?>
<style>
.table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
padding: 3px;
}
</style>
<input type="hidden" id="main_last_new_ticket" value="<?=get_last_ticket_new($_SESSION['helpdesk_user_id']);?>">
<?php
$usid=$_SESSION['helpdesk_user_id'];
$query = "SELECT fio, pass, login, status, priv, unit,email from users where id='$usid'; ";
    $sql = mysql_query($query) or die(mysql_error());
    if (mysql_num_rows($sql) == 1) {
	    $row = mysql_fetch_assoc($sql);


$login=$row['login'];
$pass=$row['pass'];
$email=$row['email'];
}

?>

<div class="container">
<div class="page-header" style="margin-top: -15px;">
          <h3 ><center><?=lang('P_title');?></center></h3>
 </div>
        

<div class="row">
        
      

      <div class="col-md-offset-2 col-md-8">
      <div class="panel panel-default">
      <div class="panel-heading"><i class="fa fa-user"></i> <?=lang('P_main');?></div>
      <div class="panel-body">
      
      
      
      <form class="form-horizontal" role="form">
      <div class="form-group">
    <label for="login" class="col-sm-4 control-label"><?=lang('P_login');?></label>
        <div class="col-sm-8">
    <input autocomplete="off" name="login" type="" class="form-control input-sm" id="login" placeholder="<?=lang('P_login');?>" value="<?=$login;?>">
        </div>
  </div>
    <div class="form-group">
    <label for="mail" class="col-sm-4 control-label"><?=lang('P_mail');?></label>
        <div class="col-sm-8">
    <input autocomplete="off" name="mail" type="text" class="form-control input-sm" id="mail" placeholder="<?=lang('P_mail');?>" value="<?=$email;?>">
    <p class="help-block"><small><?=lang('P_mail_desc');?></small></p>
        </div>
  </div>
    <div class="col-md-offset-3 col-md-6">
<center>
    <button type="submit" id="edit_profile_main" value="<?=$usid?>" class="btn btn-success"><i class="fa fa-pencil"></i> <?=lang('P_edit');?></button>
</center>
</div>
      </form>
      
      
      
      
      
      </div>
      
      </div>
      <div id="m_info"></div>
      <div class="panel panel-default">
      <div class="panel-heading"><i class="fa fa-key"></i> <?=lang('P_passedit');?></div>
      <div class="panel-body">
      <form class="form-horizontal" role="form">
      
              <div class="form-group">
    <label for="old_pass" class="col-sm-4 control-label"><?=lang('P_pass_old');?></label>
        <div class="col-sm-8">
    <input autocomplete="off" name="old_pass" type="password" class="form-control input-sm" id="old_pass" placeholder="<?=lang('P_pass_old2');?>">
        </div>
  </div>
      
      
        <div class="form-group">
    <label for="new_pass" class="col-sm-4 control-label"><?=lang('P_pass_new');?></label>
        <div class="col-sm-8">
    <input autocomplete="off" name="new_pass" type="password" class="form-control input-sm" id="new_pass" placeholder="<?=lang('P_pass_new2');?>">
        </div>
  </div>
  
          <div class="form-group">
    <label for="new_pass2" class="col-sm-4 control-label"><?=lang('P_pass_new_re');?></label>
        <div class="col-sm-8">
    <input autocomplete="off" name="new_pass2" type="password" class="form-control input-sm" id="new_pass2" placeholder="<?=lang('P_pass_new_re2');?>">
        </div>
  </div>
  <div class="col-md-offset-3 col-md-6">
<center>
    <button type="submit" id="edit_profile_pass" value="<?=$usid?>" class="btn btn-success"><i class="fa fa-pencil"></i> <?=lang('P_do_edit_pass');?></button>
</center>
</div>
  
  
      </form>
  
      </div>
      </div>
<div id="p_info"></div>
      
      
      </div>
      
     
      
      
</div>
      
      
      
      
<br>
</div>
<?php
 include("inc/footer.inc.php");
?>

<?php
	//}
	}
else {
    include 'auth.php';
}
?>