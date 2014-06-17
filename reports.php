<?php
session_start();
include("functions.inc.php");

if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {
if (validate_admin($_SESSION['helpdesk_user_id'])) {
   include("inc/head.inc.php");
   include("inc/navbar.inc.php");
   
  

?>
<style>
.table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
padding: 3px;
}
</style>


<div class="container">
<div class="page-header" style="margin-top: -15px;">
<div class="row">
         <div class="col-md-6"> <h3> Звіти</h3></div>
         
         
</div>
 </div>
        

<div class="row" id="content_reports">

      <div class="col-md-3"> 
      
      
      <div class="control-group">
    	<div class="controls">
  <div class="form-group" style=" padding-bottom: 20px; ">
      
	      <div id="reportrange" class="pull-right">
    <i class="fa fa-calendar fa-lg"></i>
    <span><?php echo date("F j, Y", strtotime('-30 day')); ?> - <?php echo date("F j, Y"); ?></span> <b class="caret"></b>
    <input type="hidden" id="d_start" value="<?php echo date("Y-m-d", strtotime('-30 day')); ?>">
    <input type="hidden" id="d_stop" value="<?php echo date("Y-m-d"); ?>">
	      </div></div></div>
</div>
 <div class="control-group">
    	<div class="controls">
  <div class="form-group">
	      <div class="input-group">
      
      
      
      
              <select data-placeholder="Виконавець" class="chosen-select form-control input-sm" id="user_report" name="unit_id">
  <option value="0"></option>
  <?php
  $qstring = "SELECT fio as label, id as value FROM users order by fio ASC;";
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
      
      
      
      <span class="input-group-btn">
        <button id="do_report" class="btn btn-default btn-sm" type="submit">Знайти</button>
      </span>
    </div></div></div></div>
    
    
      </div>
      <div class="col-md-9" id="content_report"> 
      </div>
</div></div>      
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