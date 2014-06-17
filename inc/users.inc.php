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


  <div class="form-group">
    <label for="exampleInputEmail1" class="col-sm-2 control-label"><?=lang('USERS_fio');?></label>
    <div class="col-sm-10">
    <input autocomplete="off" id="fio" name="fio" type="" class="form-control input-sm" id="exampleInputEmail1" placeholder="<?=lang('USERS_fio_full');?>">
    </div>
  </div>
  <div class="form-group">
    <label for="login" class="col-sm-2 control-label"><?=lang('USERS_login');?></label>
        <div class="col-sm-10">
    <input autocomplete="off" name="login" type="" class="form-control input-sm" id="login" placeholder="<?=lang('USERS_login');?>">
        </div>
  </div>
  <div class="form-group">
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
  <label for="my-select" class="col-sm-2 control-label"><?=lang('USERS_units');?></label>
  <div class="col-sm-10">
  <select multiple="multiple" id="my-select" name="unit[]">
<?php
                        $qstring = "SELECT name as label, id as value FROM deps where id !='0' ;";
                        $result = mysql_query($qstring);//query the database for entries containing the term

                        while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
                        {
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
  
  
  
    <!--div class="form-group">
    <label for="unit" class="col-sm-2 control-label">Відділ</label>
        <div class="col-sm-10">
    
    <select class="form-control input-sm" name="unit" id="unit">
  <option value="1">Відділ впровадження інформаційних систем</option>
  <option value="2">Сектор зв'язку</option>
  <option value="3">Відділ інформаційної безпеки та адміністрування мереж</option>
  <option value="4">Відділ супроводження користувачів</option>
  <option value="5">Відділ супроводження інформаційних систем</option>
</select>
    
        </div>
  </div-->
  
  
<div class="radio col-sm-4">
  <label>
    <input type="radio" name="optionsRadios" id="optionsRadios3" value="2">
    <?=lang('USERS_nach1');?>
    <p class="help-block"><small><?=lang('USERS_nach1_desc');?></small></p>
  </label>
</div>
<div class="radio col-sm-4">
  <label>
    <input type="radio" name="optionsRadios" id="optionsRadios1" value="0" >
    <?=lang('USERS_nach');?>
    <p class="help-block"><small><?=lang('USERS_nach_desc');?></small></p>
  </label>
</div>
<div class="radio col-sm-4">
  <label>
    <input type="radio" name="optionsRadios" id="optionsRadios2" value="1" checked>
    <?=lang('USERS_wo');?>
    <p class="help-block"><small><?=lang('USERS_wo_desc');?></small></p>
  </label>
  
</div>

<hr>
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
  <table class="table table-striped table-bordered">
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
	$results = mysql_query("SELECT id, fio, login, priv, unit, status from users;");
	while ($row = mysql_fetch_assoc($results)) {
	//$getunit=get_unit_name($row['priv']);
	$unit=get_unit_name_return($row['unit']);
	$statuss=$row['status'];
	
	if ($row['priv'] == "0") {$priv=lang('USERS_p_1');}
	else if ($row['priv'] == "1") {$priv=lang('USERS_p_2');}
	else if ($row['priv'] == "2") {$priv=lang('USERS_p_3');}
	
	if ($statuss == "1") {$r="success";}
	if ($statuss != "1") {$r="active";}
	
	?>
          <tr class="<?=$r;?>">
            <td><small><?php echo $row['id']; ?></small></td>
            <td><small><a value="<?php echo $row['id']; ?>" href="users.php?edit=<?=$row['id'];?>"><?php echo $row['fio']; ?></a></small></td>
            <td><small><?php echo $row['login']; ?></small></td>
            <td><small><?php echo $priv; ?></small></td>
            <td><small><?=$unit?></small></td>
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
$usid=$_POST['id'];
   $query = "SELECT fio, pass, login, status, priv, unit,email from users where id='$usid'; ";
    $sql = mysql_query($query) or die(mysql_error());
    if (mysql_num_rows($sql) == 1) {
	    $row = mysql_fetch_assoc($sql);

$fio=$row['fio'];
$login=$row['login'];
$pass=$row['pass'];
$status=$row['status'];
$priv=$row['priv'];
$unit=$row['unit'];
$email=$row['email'];

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
    <label for="exampleInputEmail1" class="col-sm-2 control-label"><?=lang('USERS_fio');?></label>
    <div class="col-sm-10">
    <input autocomplete="off" id="fio" name="fio" type="" class="form-control input-sm" id="exampleInputEmail1" placeholder="<?=lang('USERS_fio_full');?>" value="<?=$fio?>">
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
  <label for="my-select" class="col-sm-2 control-label"><?=lang('USERS_units');?></label>
  <div class="col-sm-10">
  <select multiple="multiple" id="my-select" name="unit[]">
<?php
  						$u=explode(",", $unit);
                        $qstring = "SELECT name as label, id as value FROM deps where id !='0' ;";
                        $result = mysql_query($qstring);//query the database for entries containing the term

                        while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
                        {
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
  
    <!--div class="form-group">
    <label for="unit" class="col-sm-2 control-label">Відділ</label>
        <div class="col-sm-10">
    
    <select class="form-control input-sm" name="unit" id="unit">
  <option <?=$unit_1;?> value="1">Відділ впровадження інформаційних систем</option>
  <option <?=$unit_2;?> value="2">Сектор зв'язку</option>
  <option <?=$unit_3;?> value="3">Відділ інформаційної безпеки та адміністрування мереж</option>
  <option <?=$unit_4;?> value="4">Відділ супроводження користувачів</option>
  <option <?=$unit_5;?> value="5">Відділ супроводження інформаційних систем</option>
</select>
    
        </div>
  </div-->
  
  
<div class="radio col-sm-4">
  <label>
    <input type="radio" name="optionsRadios" id="optionsRadios3" value="2" <?=$status_superadmin?>>
    <?=lang('USERS_nach1');?>
    <p class="help-block"><small><?=lang('USERS_nach1_desc');?></small></p>
  </label>
</div>

<div class="radio col-sm-4">
  <label>
    <input type="radio" name="optionsRadios" id="optionsRadios1" value="0" <?=$status_admin?>>
    <?=lang('USERS_nach');?>
    <p class="help-block"><small><?=lang('USERS_nach_desc');?></small></p>
  </label>
</div>
<div class="radio col-sm-4">
  <label>
    <input type="radio" name="optionsRadios" id="optionsRadios2" value="1" <?=$status_user?>>
    <?=lang('USERS_wo');?>
    <p class="help-block"><small><?=lang('USERS_wo_desc');?></small></p>
  </label>
  
</div>

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