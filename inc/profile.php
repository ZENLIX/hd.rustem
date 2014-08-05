<?php
session_start();
include("../functions.inc.php");

if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {
//if (validate_admin($_SESSION['helpdesk_user_id'])) {
   include("head.inc.php");
   include("navbar.inc.php");
   
 

?>

<input type="hidden" id="main_last_new_ticket" value="<?=get_last_ticket_new($_SESSION['helpdesk_user_id']);?>">
<?php
$usid=$_SESSION['helpdesk_user_id'];

//$query = "SELECT fio, pass, login, status, priv, unit,email, lang from users where id='$usid'; ";
//    $sql = mysql_query($query) or die(mysql_error());
    
    
    	$stmt = $dbConnection->prepare('SELECT fio, pass, login, status, priv, unit,email, lang from users where id=:usid');
		$stmt->execute(array(':usid'=>$usid));
		$res1 = $stmt->fetchAll(); 
    
    
    
    
    
		//if (mysql_num_rows($sql) == 1) {
	    //$row = mysql_fetch_assoc($sql);
foreach($res1 as $row) {

$fio=$row['fio'];
$login=$row['login'];
$pass=$row['pass'];
$email=$row['email'];

$langu=$row['lang'];

if ($langu == "en") 	 {$status_lang_en="selected";}
else if ($langu == "ru") {$status_lang_ru="selected";}
else if ($langu == "ua") {$status_lang_ua="selected";}


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
      <div class="col-sm-4 text-right" ><strong ><small><?=lang('WORKER_fio');?>:</small></strong></div>
      <div class="col-sm-8"><small><?=$fio;?></small></div>
      </div>
      <div class="form-group">
      <div class="col-sm-4 text-right" ><strong ><small><?=lang('PROFILE_priv');?>:</small></strong></div>
      <div class="col-sm-8"><small><?=priv_status_name($usid);?></small></div>
      </div>
      <div class="form-group">
      <div class="col-sm-4 text-right"><strong><small><?=lang('PROFILE_priv_unit');?>:</small></strong></div>
      <div class="col-sm-8"><p><small><?=view_array(get_unit_name_return(unit_of_user($_SESSION['helpdesk_user_id'])));?></small></p></div>
      <div class="col-sm-12">
      <hr>
      </div>
      </div>
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
  
  
          <div class="form-group">
    <label for="lang" class="col-sm-4 control-label"><?=lang('SYSTEM_lang');?></label>
        <div class="col-sm-8">
    <select data-placeholder="<?=lang('SYSTEM_lang');?>" class="chosen-select form-control input-sm" id="lang" name="lang">
                    <option value="0"></option>
                    
                        <option <?=$status_lang_en;?> value="en">English</option>
                        <option <?=$status_lang_ru;?> value="ru">Русский</option>
                        <option <?=$status_lang_ua;?> value="ua">Українська</option>
</select>
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
      <div class="panel panel-danger">
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
 include("footer.inc.php");
?>

<?php
	//}
	}
else {
    include 'auth.php';
}
?>
