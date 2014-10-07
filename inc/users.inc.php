<?php

session_start();
//include("../functions.inc.php");



if (isset($_POST['menu'])) {

if ($_POST['menu'] == 'new' ) {


if (isset($_GET['ok'])) {
	
	?>
	<div class="alert alert-success"><?=lang('USERS_msg_add');?></div>
	<?php
}

?>

<div class="panel panel-default">
  <div class="panel-heading"><?=lang('USERS_new');?></div>
  <div class="panel-body">

<div id="form_message"></div>
<form class="form-horizontal" role="form">


  <div class="form-group" id="fio_user_grp">
    <label for="fio" class="col-sm-2 control-label"><?=lang('USERS_fio');?></label>
    <div class="col-sm-10">
    <input autocomplete="off" id="fio_user" name="fio_user" type="" class="form-control input-sm" placeholder="<?=lang('USERS_fio_full');?>">
    </div>
  </div>
  <div class="form-group" id="login_user_grp">
    <label for="login" class="col-sm-2 control-label"><?=lang('USERS_login');?></label>
        <div class="col-sm-10">
    <input autocomplete="off" name="login_user" type="" class="form-control input-sm" id="login_user" placeholder="<?=lang('USERS_login');?>">
        </div>
  </div>
  <div class="form-group" id="pass_user_grp">
    <label for="exampleInputPassword1" class="col-sm-2 control-label"><?=lang('USERS_pass');?></label>
        <div class="col-sm-10">
    <input autocomplete="off" name="password" type="password" class="form-control input-sm" id="exampleInputPassword1" placeholder="<?=lang('USERS_pass');?>">
        </div>
  </div>
    <div class="form-group">
    <label for="mail" class="col-sm-2 control-label"><?=lang('USERS_mail');?></label>
        <div class="col-sm-10">
    <input autocomplete="off" name="mail" type="text" class="form-control input-sm" id="mail" placeholder="<?=lang('USERS_mail');?>">
        </div>
  </div>
  
  
  
      <div class="form-group">
    <label for="lang" class="col-sm-2 control-label"><?=lang('SYSTEM_lang');?></label>
        <div class="col-sm-10">
    <select data-placeholder="<?=lang('SYSTEM_lang');?>" class="chosen-select form-control input-sm" id="lang" name="lang">
                    <option value="0"></option>
                    
                        <option value="en">English</option>
                        <option value="ru">Русский</option>
                        <option value="ua">Українська</option>
</select>
        </div>
  </div>
  
  
  
  <div class="form-group">
  <label for="my-select" class="col-sm-2 control-label"><?=lang('USERS_units');?></label>
  <div class="col-sm-10">
  <select multiple="multiple" id="my-select" name="unit[]">
<?php
                        /*$qstring = "SELECT name as label, id as value FROM deps where id !='0' ;";
                        $result = mysql_query($qstring);
                        while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
                        */
                        
                        
        $stmt = $dbConnection->prepare('SELECT name as label, id as value FROM deps where id !=:n');
		$stmt->execute(array(':n'=>'0'));
		$res1 = $stmt->fetchAll();                 
        foreach($res1 as $row) {
                        
                        
                        
                        
                        
                        
                        
                        
//echo($row['label']);
                            $row['label']=$row['label'];
                            $row['value']=(int)$row['value'];


                            ?>

                            <option value="<?=$row['value']?>"><?=$row['label']?></option>

                        <?php


                        }

                        ?>

    </select>
  </div>
  </div>
  
  
  

      <div class="form-group">
    <label for="mess" class="col-sm-2 control-label"><?=lang('MAIL_msg');?></label>
        <div class="col-sm-10">
        <textarea placeholder="<?=lang('');?>" class="form-control input-sm animated" name="mess" id="mess" rows="3"></textarea>
        

        </div>
  </div>
  
    <div class="form-group">
  <label for="mess" class="col-sm-2 control-label"><?=lang('USERS_profile_priv');?></label>
  <div class="col-sm-10">
<div class="radio col-sm-12">
  <label>
    <input type="radio" name="optionsRadios" id="optionsRadios3" value="2" >
    <strong class="text-warning"><?=lang('USERS_nach1');?></strong>
    <p class="help-block"><small><?=lang('USERS_nach1_desc');?></small></p>
  </label>
</div>

<div class="radio col-sm-12">
  <label>
    <input type="radio" name="optionsRadios" id="optionsRadios1" value="0" >
    <strong class="text-success"><?=lang('USERS_nach');?></strong>
    <p class="help-block"><small><?=lang('USERS_nach_desc');?></small></p>
  </label>
</div>
<div class="radio col-sm-12">
  <label>
    <input type="radio" name="optionsRadios" id="optionsRadios2" value="1" checked="checked">
    <strong class="text-info"><?=lang('USERS_wo');?></strong>
    <p class="help-block"><small><?=lang('USERS_wo_desc');?></small></p>
  </label>
  
</div>
  </div>
  </div>
  
    <div class="form-group">
  <label for="mess" class="col-sm-2 control-label"><?=lang('USERS_privs');?></label>
  <div class="col-sm-10">
  
  
  
	  <div class="col-sm-6">
	  <div class="checkbox">
    <label>
      <input type="checkbox" id="priv_add_client" checked="checked"> <?=lang('TICKET_p_add_client');?>
    </label>
  </div>
	  </div>
	  
	  	  <div class="col-sm-6">
	  <div class="checkbox">
    <label>
      <input type="checkbox" id="priv_edit_client" checked="checked"> <?=lang('TICKET_p_edit_client');?>
    </label>
  </div>
	  </div>
	  
  </div>
    </div>

<div class="col-sm-12"><hr></div>
<div class="col-md-offset-3 col-md-6">
<center>
    <button type="submit" id="create_user" class="btn btn-success"><?=lang('USERS_make_create');?></button>
</center>
</div>
</form>




  </div>
</div>
	  


<?php
}

if ($_POST['menu'] == 'list' ) {
?>
<div class="panel panel-default">
  <div class="panel-heading"><?=lang('USERS_list');?></div>
  <div class="panel-body">
  <table class="table table-bordered">
        <thead>
          <tr>
            <th><center><small><?=lang('USERS_uid');?>			</small></center></th>
            <th><center><small><?=lang('USERS_fio');?>			</small></center></th>
            <th><center><small><?=lang('USERS_login');?>		</small></center></th>
            <th><center><small><?=lang('USERS_privs');?>		</small></center></th>
            <th><center><small><?=lang('USERS_unit');?>		</small></center></th>
            
          </tr>
        </thead>
        <tbody>
        <?php
    //include("../dbconnect.inc.php");
	//$results = mysql_query("SELECT id, fio, login, priv, unit, status from users;");
	//while ($row = mysql_fetch_assoc($results)) {
	//$getunit=get_unit_name($row['priv']);
	
	
	
	    $stmt = $dbConnection->prepare('SELECT id, fio, login, priv, unit, status from users');
		$stmt->execute();
		$res1 = $stmt->fetchAll();                 
        foreach($res1 as $row) {
	
	
	
	$unit=view_array(get_unit_name_return($row['unit']));
	$statuss=$row['status'];
	
	if ($row['priv'] == "0") {$priv=lang('USERS_p_1');}
	else if ($row['priv'] == "1") {$priv=lang('USERS_p_2');}
	else if ($row['priv'] == "2") {$priv=lang('USERS_p_3');}
	
	if ($statuss == "1") {$r="";}
	if ($statuss != "1") {$r="active";}
	
	?>
          <tr class="<?=$r;?>">
            <td><small><center><?php echo $row['id']; ?></center></small></td>
            <td><small><a value="<?php echo $row['id']; ?>" href="<?php echo $CONF['hostname']; ?>users?edit=<?=$row['id'];?>"><?php echo $row['fio']; ?></a></small></td>
            <td><small><?php echo $row['login']; ?></small></td>
            <td><small><?php echo $priv; ?></small></td>
            <td><small><span data-toggle="tooltip" data-placement="right" title="<?=$unit;?>"><?=lang('LIST_pin')?> <?=count(get_unit_name_return($row['unit'])); ?> </span></small></td>
          </tr>
        <?php } ?>
       </tbody>
      </table>
  </div>
</div>
<?php
}
if ($_POST['menu'] == 'edit' ) {
//echo $_POST['id'];
$usid=($_POST['id']);
   
   
   
   
  /* $query = "SELECT fio, pass, login, status, priv, unit,email,messages,lang from users where id='$usid'; ";
    $sql = mysql_query($query) or die(mysql_error());
if (mysql_num_rows($sql) == 1) {
$row = mysql_fetch_assoc($sql);
*/



	    $stmt = $dbConnection->prepare('SELECT fio, pass, login, status, priv, unit,email,messages,lang,priv_add_client,priv_edit_client from users where id=:usid');
		$stmt->execute(array(':usid'=>$usid));
		$res1 = $stmt->fetchAll();                 
		
        foreach($res1 as $row) {




$priv_add_client=$row['priv_add_client'];
$priv_edit_client=$row['priv_edit_client'];
$fio=$row['fio'];
$login=$row['login'];
$pass=$row['pass'];
$status=$row['status'];
$priv=$row['priv'];
$unit=$row['unit'];
$email=$row['email'];
$messages=$row['messages'];
$langu=$row['lang'];


            if ($priv_add_client == "1") {$priv_add_client="checked";} else {$priv_add_client="";}
            if ($priv_edit_client == "1") {$priv_edit_client="checked";} else {$priv_edit_client="";}



if ($langu == "en") 	 {$status_lang_en="selected";}
else if ($langu == "ru") {$status_lang_ru="selected";}
else if ($langu == "ua") {$status_lang_ua="selected";}

if ($status == "0") {$status_lock="selected";}
if ($status == "1") {$status_unlock="selected";}


if ($priv == "0") {$status_admin="checked";}
if ($priv == "1") {$status_user="checked";}
if ($priv == "2") {$status_superadmin="checked";}


}
if (isset($_GET['ok'])) {
	
	?>
	<div class="alert alert-success"><?=lang('USERS_msg_edit_ok');?></div>
	<?php
}
?>
<div class="panel panel-default">
  <div class="panel-heading"><?=lang('USERS_make_edit');?></div>
  <div class="panel-body">






<form class="form-horizontal" role="form">


  <div class="form-group">
    <label for="fio" class="col-sm-2 control-label"><?=lang('USERS_fio');?></label>
    <div class="col-sm-10">
    <input autocomplete="off" id="fio_edit" name="fio_edit" type="" class="form-control input-sm" placeholder="<?=lang('USERS_fio_full');?>" value="<?=$fio?>">
    </div>
  </div>
  <div class="form-group">
    <label for="login" class="col-sm-2 control-label"><?=lang('USERS_login');?></label>
        <div class="col-sm-10">
    <input autocomplete="off" name="login" type="" class="form-control input-sm" id="login" placeholder="<?=lang('USERS_login');?>" value="<?=$login?>">
        </div>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1" class="col-sm-2 control-label"><?=lang('USERS_pass');?></label>
        <div class="col-sm-10">
    <input autocomplete="off" name="password" type="password" class="form-control input-sm" id="exampleInputPassword1" placeholder="<?=lang('USERS_pass');?>" value="">
        </div>
  </div>
      <div class="form-group">
    <label for="mail" class="col-sm-2 control-label"><?=lang('USERS_mail');?></label>
        <div class="col-sm-10">
    <input autocomplete="off" name="mail" type="text" class="form-control input-sm" id="mail" placeholder="<?=lang('USERS_mail');?>" value="<?=$email;?>">
        </div>
  </div>
  
        <div class="form-group">
    <label for="lang" class="col-sm-2 control-label"><?=lang('SYSTEM_lang');?></label>
        <div class="col-sm-10">
    <select data-placeholder="<?=lang('SYSTEM_lang');?>" class="chosen-select form-control input-sm" id="lang" name="lang">
                    <option value="0"></option>
                    
                        <option <?=$status_lang_en;?> value="en">English</option>
                        <option <?=$status_lang_ru;?> value="ru">Русский</option>
                        <option <?=$status_lang_ua;?> value="ua">Українська</option>
</select>
        </div>
  </div>
  
    <div class="form-group">
  <label for="my-select" class="col-sm-2 control-label"><?=lang('USERS_units');?></label>
  <div class="col-sm-10">
  <select multiple="multiple" id="my-select" name="unit[]">
<?php
  						$u=explode(",", $unit);
                        
                        
                       /* $qstring = "SELECT name as label, id as value FROM deps where id !='0' ;";
                        $result = mysql_query($qstring);
                        while ($row = mysql_fetch_array($result,MYSQL_ASSOC)){*/
                        
        $stmt = $dbConnection->prepare('SELECT name as label, id as value FROM deps where id !=:n');
		$stmt->execute(array(':n'=>'0'));
		$res1 = $stmt->fetchAll();                 
		
        foreach($res1 as $row) {
                        
                        
                        
//echo($row['label']);
                            $row['label']=$row['label'];
                            $row['value']=(int)$row['value'];

$opt_sel='';
foreach ($u as $val) {
if ($val== $row['value']) {$opt_sel="selected";}

}

                            ?>

                            <option <?=$opt_sel;?> value="<?=$row['value']?>"><?=$row['label']?></option>

                        <?php

//
                        }

                        ?>
    </select>
  </div>
  </div>
  

        <div class="form-group">
    <label for="mess" class="col-sm-2 control-label"><?=lang('MAIL_msg');?></label>
        <div class="col-sm-10">
        <textarea placeholder="<?=lang('');?>" class="form-control input-sm animated" name="mess" id="mess" rows="3"><?=$messages;?></textarea>
        

        </div>
  </div>
  
  
  
  <div class="form-group">
  <label for="mess" class="col-sm-2 control-label"><?=lang('USERS_profile_priv');?></label>
  <div class="col-sm-10">
<div class="radio col-sm-12">
  <label>
    <input type="radio" name="optionsRadios" id="optionsRadios3" value="2" <?=$status_superadmin?>>
    <strong class="text-warning"><?=lang('USERS_nach1');?></strong>
    <p class="help-block"><small><?=lang('USERS_nach1_desc');?></small></p>
  </label>
</div>

<div class="radio col-sm-12">
  <label>
    <input type="radio" name="optionsRadios" id="optionsRadios1" value="0" <?=$status_admin?>>
    <strong class="text-success"><?=lang('USERS_nach');?></strong>
    <p class="help-block"><small><?=lang('USERS_nach_desc');?></small></p>
  </label>
</div>
<div class="radio col-sm-12">
  <label>
    <input type="radio" name="optionsRadios" id="optionsRadios2" value="1" <?=$status_user?>>
    <strong class="text-info"><?=lang('USERS_wo');?></strong>
    <p class="help-block"><small><?=lang('USERS_wo_desc');?></small></p>
  </label>
  
</div>
  </div>
  </div>
  
  
    <div class="form-group">
  <label for="mess" class="col-sm-2 control-label"><?=lang('USERS_privs');?></label>
  <div class="col-sm-10">
  
  
  
	  <div class="col-sm-6">
	  <div class="checkbox">
    <label>
      <input type="checkbox" id="priv_add_client" <?=$priv_add_client?>> <?=lang('TICKET_p_add_client');?>
    </label>
  </div>
	  </div>
	  
	  	  <div class="col-sm-6">
	  <div class="checkbox">
    <label>
      <input type="checkbox" id="priv_edit_client" <?=$priv_edit_client?>> <?=lang('TICKET_p_edit_client');?>
    </label>
  </div>
	  </div>
	  
  </div>
    </div>
  
  
  
  
  <div class="col-sm-12"><hr></div>
    <div class="form-group">
    <label for="lock" class="col-sm-2 control-label"><?=lang('USERS_acc');?></label>
        <div class="col-sm-10">
    
    <select class="form-control input-sm" name="lock" id="lock">
  <option <?=$status_lock?> value="0"><?=lang('USERS_not_active');?></option>
  <option <?=$status_unlock?> value="1"><?=lang('USERS_active');?></option>
  	</select>
    
        </div>
  </div>

<hr>
<div class="col-md-offset-1 col-md-10">



<center>
<div class="btn-group">
    <button type="button" class="btn btn-success" id="edit_user" value="<?=$_POST['id']?>" ><?=lang('USERS_editable');?></button>
    <!--button type="button" class="btn btn-danger" id="delete_user" value="<?=$_POST['id']?>" ><?=lang('USERS_delete');?></button-->
</div>
</center>

</div>
</form>








  </div>
</div>

<?php
}

}

?>
