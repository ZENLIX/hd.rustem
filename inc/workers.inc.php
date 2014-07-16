<?php

session_start();
include_once("../functions.inc.php");


if ((priv_status($_SESSION['helpdesk_user_id']) == "0")||(priv_status($_SESSION['helpdesk_user_id']) == "2")) {


if (isset($_POST['menu'])) {

if ($_POST['menu'] == 'new' ) {


if (isset($_GET['ok'])) {
	
	?>
	<div class="alert alert-success"><?=lang('USERS_msg_add');?></div>
	<?php
}

?>

<div class="panel panel-default" id="content_worker">
  <div class="panel-heading"><?=lang('USERS_new');?></div>
  <div class="panel-body"><div class="col-md-12">



                    <div class="">

                        <div class="panel-body">



                            <form class="form-horizontal" role="form" id="form_approve">
                                <div class="form-group">
                                    <label for="pib" class="col-sm-2 control-label"><small><?=lang('WORKER_fio');?></small></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="pib" class="form-control input-sm" id="pib" placeholder="<?=lang('WORKER_fio');?>" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="login" class="col-sm-2 control-label"><small><?=lang('WORKER_login');?></small></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="login" class="form-control input-sm" id="login" placeholder="<?=lang('WORKER_login');?>" value="">
                                    </div>
                                </div>
                                
                                
                                
                                
                                
                                
                                
                                
                                <!--div class="form-group">
                                    <label for="posada" class="col-sm-2 control-label"><small><?=lang('WORKER_posada');?></small></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="posada" class="form-control input-sm" id="posada" placeholder="<?=lang('WORKER_posada');?>" value="">
                                    </div>
                                </div-->
                                
                                
 <div class="control-group">
    <div class="controls">
        <div class="form-group">
            <label for="posada" class="col-sm-2 control-label"><small><?=lang('WORKER_posada');?>: </small></label>
            <div class="col-sm-10" style="">
                <select name="posada" data-placeholder="<?=lang('WORKER_posada');?>" class="chosen-select form-control input-sm">
                    <option value="0"></option>
                    <?php
                    /*$qstring = "SELECT name FROM posada order by name COLLATE utf8_unicode_ci ASC";
                    $result = mysql_query($qstring);
                    while ($row = mysql_fetch_array($result,MYSQL_ASSOC)){*/
                    
                    
                    
        $stmt = $dbConnection->prepare('SELECT name FROM posada order by name COLLATE utf8_unicode_ci ASC');
		$stmt->execute();
		$res1 = $stmt->fetchAll();                 
		
        foreach($res1 as $row) {
                    
                    
                        ?>

                        <option value="<?=$row['name']?>"><?=$row['name']?></option>

                    <?php


                    }

                    ?>

                </select>
            </div>
        </div>

    </div>
</div>
                               
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                <!--div class="form-group">
                                    <label for="pidrozdil" class="col-sm-2 control-label"><small><?=lang('WORKER_unit');?></small></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="pid" class="form-control input-sm" id="pidrozdil" placeholder="<?=lang('WORKER_unit');?>" value="">
                                    </div>
                                </div-->
                                
                                
 <div class="control-group">
    <div class="controls">
        <div class="form-group">
            <label for="pidrozdil" class="col-sm-2 control-label"><small><?=lang('WORKER_unit');?>: </small></label>
            <div class="col-sm-10" style="">
                <select name="pid" data-placeholder="<?=lang('WORKER_unit');?>" class="chosen-select form-control input-sm">
                    <option value="0"></option>
                    <?php
                    /*$qstring = "SELECT name FROM units order by name COLLATE utf8_unicode_ci ASC";
                    $result = mysql_query($qstring);//query the database for entries containing the term

                    while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
                    {*/
                    
                    
                            $stmt = $dbConnection->prepare('SELECT name FROM units order by name COLLATE utf8_unicode_ci ASC');
		$stmt->execute();
		$res1 = $stmt->fetchAll();                 
		
        foreach($res1 as $row) {
                        ?>

                        <option value="<?=$row['name']?>"><?=$row['name']?></option>

                    <?php


                    }

                    ?>

                </select>
            </div>
        </div>

    </div>
</div>                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                <div class="form-group">
                                    <label for="tel" class="col-sm-2 control-label"><small><?=lang('WORKER_tel');?></small></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="tel" class="form-control input-sm" id="tel" placeholder="<?=lang('WORKER_tel_full');?>" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="adr" class="col-sm-2 control-label"><small><?=lang('WORKER_room');?></small></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="adr" class="form-control input-sm" id="adr" placeholder="<?=lang('WORKER_room');?>" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label"><small><?=lang('WORKER_mail');?></small></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="mail" class="form-control input-sm" id="email" placeholder="<?=lang('WORKER_mail');?>" value="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                </div>
                                <div class="col-sm-6">
                                    <input type="hidden" name="id_client" value="">
                                    <button type="submit" id="send_zapit_add" class="btn btn-success btn-xs btn-block"><?=lang('DEPS_add');?></button>
                                </div>


                            </form>

                        </div>

                    </div>
                    <div id="sze_info">

                    </div>





                </div>
</div>
</div>
	  


<?php
}

if ($_POST['menu'] == 'list' ) {
$page=($_POST['page']);
$perpage='10';

$start_pos = ($page - 1) * $perpage;
?>
<div class="panel panel-default">
  <div class="panel-heading"><?=lang('USERS_list');?> <div style="float:right;"><a href="<?=$CONF['hostname']?>clients?add"  class="btn btn-success btn-xs"><?=lang('DEPS_add');?></a></div></div>
  <div class="panel-body">
  <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th><center><small><?=lang('USERS_uid');?>			</small></center></th>
            <th><center><small><?=lang('USERS_fio');?>			</small></center></th>
            <th><center><small><?=lang('USERS_login');?>		</small></center></th>
            <th><center><small><?=lang('WORKER_tel');?>		</small></center></th>
            <th><center><small><?=lang('WORKER_unit');?>		</small></center></th>
            <th><center><small><?=lang('WORKER_room');?>		</small></center></th>
            <th><center><small><?=lang('WORKER_mail');?>		</small></center></th>
            <th><center><small><?=lang('WORKER_posada');?>		</small></center></th>
          </tr>
        </thead>
        <tbody>
        <?php
    //include("../dbconnect.inc.php");
    if (isset($_POST['t'])) {
    $t=($_POST['t']);
    
    
    
	    //$results = mysql_query("SELECT id, fio, login, tel, unit_desc, adr, email, posada from clients where ((fio like '%" . $t . "%') or (login like '%" . $t . "%')) limit $start_pos, $perpage;");
	    
	    
	    
	        $stmt = $dbConnection->prepare('SELECT id, fio, login, tel, unit_desc, adr, email, posada from clients where ((fio like :t) or (login like :t2)) limit :start_pos, :perpage');
			$stmt->execute(array(':t' => '%'.$t.'%',':t2' => '%'.$t.'%',':start_pos' => $start_pos, ':perpage'=>$perpage));
			$res1 = $stmt->fetchAll();
			//foreach($res1 as $row) {
	    
	    
	    
	    
    }
    if (!isset($_POST['t'])) {
	//$results = mysql_query("SELECT id, fio, login, tel, unit_desc, adr, email, posada from clients limit $start_pos, $perpage;");
		    
		    
		    $stmt = $dbConnection->prepare('SELECT id, fio, login, tel, unit_desc, adr, email, posada from clients limit :start_pos, :perpage');
			$stmt->execute(array(':start_pos' => $start_pos, ':perpage'=>$perpage));
			$res1 = $stmt->fetchAll();
			
			
			
	}
	//while ($row = mysql_fetch_assoc($results)) {
	foreach($res1 as $row) {
	//$getunit=get_unit_name($row['priv']);
	//$unit=get_unit_name_return($row['unit']);
	//$statuss=$row['status'];
	
	
	
	?>
          <tr class="">
            <td><small><center><?=$row['id'];?></center></small></td>
            <td><small><a value="<?=$row['id']; ?>" href="<?=$CONF['hostname']?>clients?edit=<?=$row['id'];?>"><?=$row['fio'];?></a></small></td>
            <td><small><?=$row['login'];?></small></td>
            <td><small><?=$row['tel'];?></small></td>
            <td><small><?=$row['unit_desc'];?></small></td>
            <td><small><?=$row['adr'];?></small></td>
            <td><small><?=$row['email'];?></small></td>
            <td><small><?=$row['posada'];?></small></td>
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
$usid=($_GET['edit']);



   /*$query = "SELECT id, fio, tel, login, unit_desc, adr, email, posada from clients where id='$usid'; ";
    $sql = mysql_query($query) or die(mysql_error());
    	
    	if (mysql_num_rows($sql) == 1) {
	    $row = mysql_fetch_assoc($sql);
	    */
	    
		    $stmt = $dbConnection->prepare('SELECT id, fio, tel, login, unit_desc, adr, email, posada from clients where id=:usid');
			$stmt->execute(array(':usid'=>$usid));
			$res1 = $stmt->fetchAll();
			
foreach($res1 as $row) {
	    
	    
	    
$fio_id=$row['id'];
$fio=$row['fio'];
$login=$row['login'];
$tel=$row['tel'];

$unit_desc=$row['unit_desc'];
$adr=$row['adr'];
$posada=$row['posada'];
$email=$row['email'];



}


if (isset($_GET['ok'])) {
	
	?>
	<div class="alert alert-success"><?=lang('USERS_msg_add');?></div>
	<?php
}

?>

<div class="panel panel-default" id="content_worker">
  <div class="panel-heading"><?=lang('USERS_make_edit');?></div>
  <div class="panel-body"><div class="col-md-12">



                    <div class="">

                        <div class="panel-body">



                            <form class="form-horizontal" role="form" id="form_approve">
                                <div class="form-group">
                                    <label for="pib" class="col-sm-2 control-label"><small><?=lang('WORKER_fio');?></small></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="pib" class="form-control input-sm" id="pib" placeholder="<?=lang('WORKER_fio');?>" value="<?=$fio;?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="login" class="col-sm-2 control-label"><small><?=lang('WORKER_login');?></small></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="login" class="form-control input-sm" id="login" placeholder="<?=lang('WORKER_login');?>" value="<?=$login;?>">
                                    </div>
                                </div>
                                
                                
                                
                                
                                
                                
                                
                                
                                <!--div class="form-group">
                                    <label for="posada" class="col-sm-2 control-label"><small><?=lang('WORKER_posada');?></small></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="posada" class="form-control input-sm" id="posada" placeholder="<?=lang('WORKER_posada');?>" value="">
                                    </div>
                                </div-->
                                
                                
 <div class="control-group">
    <div class="controls">
        <div class="form-group">
            <label for="posada" class="col-sm-2 control-label"><small><?=lang('WORKER_posada');?>: </small></label>
            <div class="col-sm-10" style="">
                <select name="posada" data-placeholder="<?=lang('WORKER_posada');?>" class="chosen-select form-control input-sm">
                    <option value="0"></option>
                    <?php
                    /*$qstring = "SELECT name FROM posada order by name COLLATE utf8_unicode_ci ASC";
                    $result = mysql_query($qstring);
                    while ($row = mysql_fetch_array($result,MYSQL_ASSOC)){*/
                    
        $stmt = $dbConnection->prepare('SELECT name FROM posada order by name COLLATE utf8_unicode_ci ASC');
		$stmt->execute();
		$res1 = $stmt->fetchAll();                 
        foreach($res1 as $row) {
                    
                    
                    $se="";
                    if ($posada == $row['name']) { $se="selected";}
                        ?>

                        <option <?=$se;?> value="<?=$row['name']?>"><?=$row['name']?></option>

                    <?php


                    }

                    ?>

                </select>
            </div>
        </div>

    </div>
</div>
                               
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                <!--div class="form-group">
                                    <label for="pidrozdil" class="col-sm-2 control-label"><small><?=lang('WORKER_unit');?></small></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="pid" class="form-control input-sm" id="pidrozdil" placeholder="<?=lang('WORKER_unit');?>" value="">
                                    </div>
                                </div-->
                                
                                
 <div class="control-group">
    <div class="controls">
        <div class="form-group">
            <label for="pidrozdil" class="col-sm-2 control-label"><small><?=lang('WORKER_unit');?>: </small></label>
            <div class="col-sm-10" style="">
                <select name="pid" data-placeholder="<?=lang('WORKER_unit');?>" class="chosen-select form-control input-sm">
                    <option value="0"></option>
                    <?php
                    /*$qstring = "SELECT name FROM units order by name COLLATE utf8_unicode_ci ASC";
                    $result = mysql_query($qstring);                    
                    while ($row = mysql_fetch_array($result,MYSQL_ASSOC)){*/
                    
        $stmt = $dbConnection->prepare('SELECT name FROM units order by name COLLATE utf8_unicode_ci ASC');
		$stmt->execute();
		$res1 = $stmt->fetchAll();                 
        foreach($res1 as $row) {
                    
                    
                    $se2="";
                    if ($unit_desc == $row['name']) { $se2="selected";}
                        ?>

                        <option <?=$se2;?> value="<?=$row['name']?>"><?=$row['name']?></option>

                    <?php


                    }

                    ?>

                </select>
            </div>
        </div>

    </div>
</div>                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                <div class="form-group">
                                    <label for="tel" class="col-sm-2 control-label"><small><?=lang('WORKER_tel');?></small></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="tel" class="form-control input-sm" id="tel" placeholder="<?=lang('WORKER_tel_full');?>" value="<?=$tel;?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="adr" class="col-sm-2 control-label"><small><?=lang('WORKER_room');?></small></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="adr" class="form-control input-sm" id="adr" placeholder="<?=lang('WORKER_room');?>" value="<?=$adr;?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label"><small><?=lang('WORKER_mail');?></small></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="mail" class="form-control input-sm" id="email" placeholder="<?=lang('WORKER_mail');?>" value="<?=$email;?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                </div>
                                <div class="col-sm-6">
                                    <input type="hidden" name="id_client" value="<?=$fio_id;?>">
                                    <button type="submit" id="send_zapit_edit_ok" class="btn btn-success btn-xs btn-block"><?=lang('USERS_editable');?></button>
                                </div>


                            </form>

                        </div>

                    </div>
                    <div id="sze_info">

                    </div>





                </div>
</div>
</div>

<?php
}

}
}
?>