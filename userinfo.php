<?php
session_start();
include("functions.inc.php");

if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {

   include("inc/head.inc.php");
   include("inc/navbar.inc.php");
   
$user_id=mysql_real_escape_string($_GET["user"]);







?>
<div class="container">
<div class="page-header" style="margin-top: -15px;">
          <h3 >Заявки користувача <?=name_of_client($user_id);?></h3>
 </div>
 
 
 
 
<div class="row" style="padding-bottom:20px;">
<div class="col-md-4">
	<div class="panel panel-default">
	  
	  
	<?php
	get_client_info($user_id);
	?>
	  </div>
</div>
  <div class="col-md-8">
  
  <?php
  /*
  	$query = mysql_query("SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read,lock_by, ok_by, arch
							from tickets
							where client_id='$user_id'
							order by id DESC
							");
							//$sql = mysql_query($query) or die(mysql_error());
							if (mysql_num_rows($query) > 0) {
	    while ($row = mysql_fetch_assoc($query)) {
	    */
	    
	    
		$stmt = $dbConnection->prepare('SELECT 
							id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, is_read,lock_by, ok_by, arch
							from tickets
							where client_id=:user_id
							order by id DESC');
		$stmt->execute();
		$res1 = $stmt->fetchAll();   
		if (!empty($res1)) {
		              
        foreach($res1 as $row) {	    
	    
	    
	    
	    
	    
if ($row['user_to_id'] <> 0 ) {
$to_text=get_unit_name_return($row['unit_id'])."<div class='text-muted'>".name_of_user_ret($row['user_to_id'])."</div>";



}
if ($row['user_to_id'] == 0 ) {
	$to_text=get_unit_name_return($row['unit_id']);
}
	    ?>
	    <div class="panel panel-default">
  <div class="panel-heading"><h3 class="panel-title">Заявка #<?=$row['id']?></h3> 
  </div>
  <div class="panel-body">
<div style="float:right;"><small class="text-muted"><em>Було створено <?=dt_format($row['date_create'])?><br>
  <?php if ($row['last_edit']) { echo "Останнє редагування "; echo dt_format($row['last_edit']); }?>
  </em></small></div>
  
  <table class="table ">
          <tbody>
          <tr>
              <td style=" width: 30px; "><strong>Ініціатор:</strong></td>
              <td><em>
              <?=name_of_user($row['user_init_id'])?> 
              </em>
              </td>
          </tr>
          <tr>
              <td style=" width: 30px; "><strong>Виконувач:</strong></td>
              <td><em><?php echo $to_text; ?> </em></td>
          </tr>
          <tr>
              <td style=" width: 30px; "><strong>Тема:</strong></td>
              <td><em>
                            
              
              
               
              <?=$row['subj']?> 
              
              </em></td>
          </tr>

                    <tr>
              <td style=" width: 30px; "><strong>Повідомлення:</strong></td>
             

              <td><em>
              
             <?=$row['msg']?></em> </td>
          </tr>
          </tbody>
</table>
  
  <?php 
$tid=$row['id'];
//echo $tid;
	/*$re = mysql_query("SELECT 
							date_op, init_user_id, to_user_id, to_unit_id from ticket_log where
							ticket_id='$tid';
							");
							
							if(mysql_num_rows($re)>0) {
							
							*/
							
							
							
		$stmt = $dbConnection->prepare('SELECT 
							date_op, init_user_id, to_user_id, to_unit_id from ticket_log where
							ticket_id=:tid');
		$stmt->execute();
		$res1 = $stmt->fetchAll(array(':tid'=>$tid));   
		if (!empty($res1)) {
		              
        						
							
							
							
 ?>

<div class="col-md-12">


<div class="panel panel-default">
  <div class="panel-heading"><i class="fa fa-exchange"></i> Журнал переадресування </div>
  <div class="panel-body">
  
  <table class="table">
  <thead>
  <tr>
  <th><center><small>Дата</small></center>	</th>
  <th><center><small>Ініціатор	</small></center></th>
  <th><center><small><i class="fa fa-long-arrow-right"></i> 	</small></center></th>
  <th colspan="2"><center><small>Отримувач	</small></center></th>
  
  	   
  </tr>
  </thead>
  
          <tbody>
          <?php 
          foreach($res1 as $rowd) {
          //while ($rowd = mysql_fetch_assoc($re)) { 
	          
          ?>
          <tr>
          <td style="width: 100px;"><small><center><?=dt_format($rowd['date_op'])?></center></small></td>
              <td style=" width: 200px; "><small><center><?=name_of_user($rowd['init_user_id'])?></center></small></td>
              <td style=" width: 50px; "><small><center><i class="fa fa-long-arrow-right"></i> </center></small></td>
              <td style=" width: 100px; "><small><?=get_unit_name($rowd['to_unit_id'])?></small></td>
              <td style=" width: 100px; "><small><?=name_of_user($rowd['to_user_id'])?></small></td>
              
          </tr>
          <?php } ?>
          </tbody>
  </table>
  </div>
</div>
  




</div>



<?php } ?>
  
  
  </div>
	    </div>
	    <?php
	    
	    }							
  
  }
   ?>
  
  
  
  
  
  
  </div>
  
  
  
  
  
</div>
 
</div>

















<?php
 include("inc/footer.inc.php");
?>

<?php
	}
else {
    include 'auth.php';
}
?>